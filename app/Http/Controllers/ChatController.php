<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Fetch messages for the current user's conversation.
     * Accepts optional ?after=<id> to only return newer messages (for polling).
     */
    public function getMessages(Request $request)
    {
        $user = Auth::user();

        // Determine whose conversation to fetch
        if ($user->role === 'admin') {
            // Admin must specify which user's conversation via ?user_id=
            $userId = $request->query('user_id');
            if (!$userId) {
                return response()->json(['messages' => [], 'conversations' => $this->getConversationList()]);
            }

            // Archived users (status=inactive) should not appear/open in admin chatbox.
            $isActiveRecipient = User::whereKey($userId)
                ->where('role', '!=', 'admin')
                ->where('status', 'active')
                ->exists();

            if (!$isActiveRecipient) {
                return response()->json(['messages' => [], 'conversations' => $this->getConversationList()]);
            }
        } else {
            $userId = $user->id;
        }

        $query = ChatMessage::with('sender')
            ->forUser($userId)
            ->orderBy('id', 'asc');

        if ($request->filled('after')) {
            $query->where('id', '>', (int) $request->after);
        }

        // Mark messages sent to the current user as read
        ChatMessage::forUser($userId)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $query->get()->map(function ($msg) use ($user) {
            return [
                'id'              => $msg->id,
                'message'         => $msg->message,
                'is_mine'         => $msg->sender_id === $user->id,
                'sender'          => $msg->sender->name ?? 'Unknown',
                'is_admin'        => $msg->sender->role === 'admin',
                'time'            => $msg->created_at->format('h:i A'),
                'attachment_url'  => $msg->attachment_path ? asset('storage/' . $msg->attachment_path) : null,
                'attachment_name' => $msg->attachment_name,
                'attachment_type' => $msg->attachment_type,
            ];
        });

        // For regular users: also return whether the Finance Dept (any admin) is online
        $adminOnline = false;
        if ($user->role !== 'admin') {
            $adminOnline = User::where('role', 'admin')
                ->where('last_seen_at', '>=', now()->subMinutes(5))
                ->exists();
        }

        $response = ['messages' => $messages, 'admin_online' => $adminOnline];

        if ($user->role === 'admin') {
            $response['conversations'] = $this->getConversationList();
        }

        return response()->json($response);
    }

    /**
     * Send a message.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message'    => 'nullable|string|max:2000',
            'attachment' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx,txt,zip',
        ]);

        // Require at least a message or an attachment
        if (!$request->filled('message') && !$request->hasFile('attachment')) {
            return response()->json(['error' => 'Message or attachment is required.'], 422);
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            $request->validate(['user_id' => 'required|exists:users,id']);
            $recipient = User::whereKey($request->user_id)
                ->where('role', '!=', 'admin')
                ->where('status', 'active')
                ->first();

            if (!$recipient) {
                return response()->json(['error' => 'Cannot send message to an archived user.'], 422);
            }

            $userId = $recipient->id;
        } else {
            $userId = $user->id;
        }

        $attachmentPath = null;
        $attachmentName = null;
        $attachmentType = null;

        if ($request->hasFile('attachment')) {
            $file           = $request->file('attachment');
            $attachmentName = $file->getClientOriginalName();
            $attachmentPath = $file->store('chat-attachments', 'public');
            $mime           = $file->getClientMimeType();
            $attachmentType = str_starts_with($mime, 'image/') ? 'image' : 'file';
        }

        $msg = ChatMessage::create([
            'user_id'         => $userId,
            'sender_id'       => $user->id,
            'message'         => $request->message ?? '',
            'is_read'         => false,
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'attachment_type' => $attachmentType,
        ]);

        $msg->load('sender');

        return response()->json([
            'id'              => $msg->id,
            'message'         => $msg->message,
            'is_mine'         => true,
            'sender'          => $msg->sender->name,
            'is_admin'        => $msg->sender->role === 'admin',
            'time'            => $msg->created_at->format('h:i A'),
            'attachment_url'  => $attachmentPath ? asset('storage/' . $attachmentPath) : null,
            'attachment_name' => $attachmentName,
            'attachment_type' => $attachmentType,
        ]);
    }

    /**
     * Get unread message count for the current user.
     */
    public function getUnreadCount()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin: total unread across all conversations where sender is not admin
            $count = ChatMessage::where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->count();
        } else {
            // Regular user: unread messages in their conversation sent by admin
            $count = ChatMessage::forUser($user->id)
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->count();
        }

        return response()->json(['unread' => $count]);
    }

    /**
        * Return the list of ACTIVE non-admin users for the admin inbox,
     * with last-message preview and unread count where applicable.
     * Users who have never chatted still appear so admin can initiate.
     */
    private function getConversationList()
    {
        $adminId = Auth::id();

        // Build a lookup of chat stats keyed by user_id
        $chatStats = ChatMessage::selectRaw(
                'user_id,
                 MAX(id) as last_msg_id,
                 SUM(CASE WHEN is_read = 0 AND sender_id != ? THEN 1 ELSE 0 END) as unread_count',
                [$adminId]
            )
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        // Get active non-admin users only (archived users are excluded)
        $users = User::where('role', '!=', 'admin')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return $users->map(function ($user) use ($chatStats) {
            $stats   = $chatStats->get($user->id);
            $lastMsg = $stats ? ChatMessage::find($stats->last_msg_id) : null;

            $lastPreview = '';
            if ($lastMsg) {
                if ($lastMsg->message) {
                    // Strip @@REPLY@@sender@@snippet@@ prefix for the preview
                    $rawMsg = $lastMsg->message;
                    if (preg_match('/^@@REPLY@@.+?@@.+?@@([\s\S]*)$/', $rawMsg, $m)) {
                        $rawMsg = trim($m[1]);
                    }
                    $lastPreview = $rawMsg ?: ($lastMsg->attachment_name ? '📎 ' . $lastMsg->attachment_name : '');
                } elseif ($lastMsg->attachment_name) {
                    $lastPreview = '📎 ' . $lastMsg->attachment_name;
                }
            }
            return [
                'user_id'      => $user->id,
                'user_name'    => $user->name,
                'last_message' => $lastPreview,
                'last_time'    => $lastMsg ? $lastMsg->created_at->format('h:i A') : '',
                'unread'       => $stats ? (int) $stats->unread_count : 0,
                'is_online'    => $user->isOnline(),
            ];
        })->sortByDesc(function ($c) {
            // Put conversations with messages first (non-empty last_time), then alphabetical
            return $c['last_time'] !== '' ? 1 : 0;
        })->values();
    }

    /**
     * Admin inbox view (optional full-page view).
     */
    public function inbox()
    {
        $this->authorizeAdmin();
        $conversations = $this->getConversationList();
        return view('chat.inbox', compact('conversations'));
    }

    private function authorizeAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
    }
}
