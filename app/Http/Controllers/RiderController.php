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
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:pending,cleared',
        ]);

        $rider = Rider::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rider added successfully!',
            'rider' => $rider
        ]);
    }

    public function update(Request $request, Rider $rider)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:pending,cleared',
        ]);

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
