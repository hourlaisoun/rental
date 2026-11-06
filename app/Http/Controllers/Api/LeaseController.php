<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaseController extends Controller
{
    // បញ្ជីកិច្ចសន្យាជួលទាំងអស់
    public function index()
    {
        try {
            $leases = Lease::with(['tenant', 'room'])->get();

            return response()->json([
                'success' => true,
                'data'    => $leases
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // ចុះកិច្ចសន្យាជួលថ្មី (Assign Tenant to Room)
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'tenant_id'      => 'nullable|exists:users,id',
                'room_id'        => 'required|exists:rooms,id',
                'start_date'     => 'required|date',
                'monthly_rent'   => 'nullable|numeric',
                'rent_amount'    => 'nullable|numeric',
                'deposit_amount' => 'required|numeric',
                'payment_method' => 'nullable|string',
            ]);

            // ពិនិត្យមើលថាតើបន្ទប់នៅទំនេរដែរឬទេ
            $room = Room::find($request->room_id);

            if ($room && $room->status === 'occupied') {
                return response()->json([
                    'success' => false,
                    'message' => 'បន្ទប់នេះមានអ្នកជួលរួចហើយ!'
                ], 400);
            }

            // ប្រើ Database Transaction
            $lease = DB::transaction(function () use ($request, $room) {
                $rent = $request->rent_amount ?? $request->monthly_rent ?? 0;

                // បង្កើត Lease ថ្មី
                $newLease = Lease::create([
                    'tenant_id'      => $request->tenant_id ?? auth()->id() ?? 1,
                    'room_id'        => $request->room_id,
                    'start_date'     => $request->start_date,
                    'rent_amount'    => $rent,
                    'monthly_rent'   => $rent,
                    'deposit_amount' => $request->deposit_amount,
                    'payment_method' => $request->payment_method ?? 'cash',
                    'status'         => 'active',
                ]);

                // អាប់ដេត status បន្ទប់ទៅជា 'occupied'
                if ($room) {
                    $room->update(['status' => 'occupied']);
                }

                return $newLease;
            });

            // Load ត្រឹម tenant និង room គ្រប់គ្រាន់ហើយ
            $lease->load(['tenant', 'room']);

            return response()->json([
                'success' => true,
                'message' => 'ការកក់បន្ទប់ត្រូវបានបង្កើតដោយជោគជ័យ!',
                'data'    => $lease
            ], 201);

        } catch (\Exception $e) {
            // 💡 បង្ហាញសារ Error ពិតប្រាកដលើ App ផ្ទាល់តែម្ដង
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }
}