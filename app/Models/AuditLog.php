<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class AuditLog extends Model
{
    protected $fillable = [
        'action',
        'module',
        'user_id',
        'status',
        'amount',
        'source_bank',
        'destination_bank',
        'notes',
        'verified_by',
        'attached_file',
        'initiated_user',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quick helper to create an audit log entry.
     *
     * @param  string       $action        Human-readable action description
     * @param  string       $module        e.g. 'Remittance', 'Bank & Deposit', 'Member Management', 'Profile'
     * @param  string       $status        e.g. 'completed', 'cleared', 'reversed'
     * @param  array        $extra         Optional overrides: amount, source_bank, destination_bank, notes, verified_by, attached_file, initiated_user
     * @return static
     */
    public static function log(
        string $action,
        string $module = 'General',
        string $status = 'completed',
        array  $extra  = []
    ): static {
        return static::create(array_merge([
            'action'         => $action,
            'module'         => $module,
            'user_id'        => Auth::id(),
            'status'         => $status,
            'initiated_user' => Auth::user()?->email,
        ], $extra));
    }
}
