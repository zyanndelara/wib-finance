<?php

namespace App\Http\Controllers;

use App\Models\Rider;
use Illuminate\Http\Request;

class RiderController extends Controller
{
    public function index()
    {
        $riders = Rider::latest()->get();
        return view('remittance', compact('riders'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'nullable|in:pending,cleared',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        $rider = Rider::create([
            'name' => $request->name,
            'status' => $request->status ?? 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rider added successfully!',
            'rider' => $rider
        ]);
    }

    public function update(Request $request, Rider $rider)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|in:pending,cleared',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        $rider->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rider updated successfully!',
            'rider' => $rider
        ]);
    }

    public function destroy(Rider $rider)
    {
        $rider->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rider deleted successfully!'
        ]);
    }
}
