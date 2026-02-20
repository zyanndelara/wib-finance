<?php

namespace App\Http\Controllers;

use App\Models\Remittance;
use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RemittanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'rider_id' => 'required|exists:riders,id',
            'total_deliveries' => 'required|integer|min:0',
            'total_delivery_fee' => 'required|numeric|min:0',
            'total_remit' => 'required|numeric|min:0',
            'total_tips' => 'nullable|numeric|min:0',
            'total_collection' => 'required|numeric|min:0',
            'mode_of_payment' => 'required|string',
            'remit_photo' => 'nullable|image|max:5120', // 5MB max
        ]);

        $remittanceData = [
            'rider_id' => $request->rider_id,
            'total_deliveries' => $request->total_deliveries,
            'total_delivery_fee' => $request->total_delivery_fee,
            'total_remit' => $request->total_remit,
            'total_tips' => $request->total_tips ?? 0,
            'total_collection' => $request->total_collection,
            'mode_of_payment' => $request->mode_of_payment,
            'status' => 'pending',
        ];

        // Handle file upload
        if ($request->hasFile('remit_photo')) {
            $file = $request->file('remit_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('remittances', $filename, 'public');
            $remittanceData['remit_photo'] = $path;
        }

        $remittance = Remittance::create($remittanceData);

        // Load the rider relationship
        $remittance->load('rider');

        return response()->json([
            'success' => true,
            'message' => 'Remittance submitted successfully!',
            'remittance' => $remittance
        ]);
    }

    public function index()
    {
        $remittances = Remittance::with('rider')->latest()->get();
        return response()->json([
            'success' => true,
            'remittances' => $remittances
        ]);
    }

    public function show(Remittance $remittance)
    {
        $remittance->load('rider');
        return response()->json([
            'success' => true,
            'remittance' => $remittance
        ]);
    }

    public function update(Request $request, Remittance $remittance)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed',
        ]);

        $remittance->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Remittance updated successfully!',
            'remittance' => $remittance
        ]);
    }

    public function destroy(Remittance $remittance)
    {
        // Delete photo if exists
        if ($remittance->remit_photo) {
            Storage::disk('public')->delete($remittance->remit_photo);
        }

        $remittance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Remittance deleted successfully!'
        ]);
    }
}
