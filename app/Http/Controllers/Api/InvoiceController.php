<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Lease;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // បញ្ជីវិក្កយបត្រទាំងអស់
    public function index()
    {
        $invoices = Invoice::with(['lease.tenant', 'lease.room'])->get();
        return response()->json($invoices);
    }

    // បង្កើត Invoice ប្រចាំខែ
    public function store(Request $request)
    {
        $request->validate([
            'lease_id' => 'required|exists:leases,id',
            'month_year' => 'required|string', // ឧទាហរណ៍: "2026-09"
            'water_usage' => 'required|numeric',
            'electricity_usage' => 'required|numeric',
            'due_date' => 'required|date',
        ]);

        $lease = Lease::with('room')->findOrFail($request->lease_id);

        // គណនាថ្លៃទឹក និង ភ្លើង
        $waterTotal = $request->water_usage * $lease->room->water_rate;
        $electricityTotal = $request->electricity_usage * $lease->room->electricity_rate;
        $totalAmount = $lease->rent_amount + $waterTotal + $electricityTotal;

        $invoice = Invoice::create([
            'lease_id' => $lease->id,
            'month_year' => $request->month_year,
            'rent_amount' => $lease->rent_amount,
            'water_usage' => $request->water_usage,
            'water_total' => $waterTotal,
            'electricity_usage' => $request->electricity_usage,
            'electricity_total' => $electricityTotal,
            'total_amount' => $totalAmount,
            'status' => 'unpaid',
            'due_date' => $request->due_date,
        ]);

        return response()->json([
            'message' => 'Invoice generated successfully',
            'invoice' => $invoice
        ], 201);
    }

    // កែប្រែ Status ទៅជា បង់រួច (Paid)
    public function markAsPaid($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update(['status' => 'paid']);

        return response()->json([
            'message' => 'Invoice marked as paid successfully',
            'invoice' => $invoice
        ]);
    }
}