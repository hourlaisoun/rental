<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Lease;
use App\Models\Property;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardWebController extends Controller
{
    public function index()
    {
        $stats = [
            'total_properties' => Property::count(),
            'total_rooms' => Room::count(),
            'occupied_rooms' => Room::where('status', 'occupied')->count(),
            'available_rooms' => Room::where('status', 'available')->count(),
            'total_tenants' => User::where('role', 'tenant')->count(),
            'total_revenue' => Invoice::where('status', 'paid')->sum('total_amount'),
            'unpaid_invoices_count' => Invoice::where('status', 'unpaid')->count(),
        ];

        return view('dashboard', compact('stats'));
    }

    // ទំព័រ Properties
    public function properties()
    {
        $properties = Property::withCount('rooms')->latest()->get();
        return view('properties', compact('properties'));
    }

    // រក្សាទុក Property ថ្មីពី Web
    public function storeProperty(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
        ]);

        Property::create([
            'landlord_id' => auth()->id() ?? 1, // Default fallback សម្រាប់ testing
            'title' => $request->title,
            'address' => $request->address,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'បន្ថែមអគារជោគជ័យ!');
    }

    // ទំព័រ Rooms
    public function rooms()
    {
        $rooms = Room::with('property')->latest()->get();
        $properties = Property::all();
        return view('rooms', compact('rooms', 'properties'));
    }

    // រក្សាទុក Room ថ្មីពី Web
    public function storeRoom(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_number' => 'required|string',
            'base_price' => 'required|numeric',
            'water_rate' => 'required|numeric',
            'electricity_rate' => 'required|numeric',
        ]);

        Room::create([
            'property_id' => $request->property_id,
            'room_number' => $request->room_number,
            'base_price' => $request->base_price,
            'water_rate' => $request->water_rate,
            'electricity_rate' => $request->electricity_rate,
            'status' => 'available',
        ]);

        return redirect()->back()->with('success', 'បន្ថែមបន្ទប់ជោគជ័យ!');
    }

    public function tenants()
    {
        $tenants = \App\Models\User::where('role', 'tenant')->latest()->get();
        return view('tenants', compact('tenants'));
    }

    // ទំព័រ Invoices
    public function invoices()
    {
        $invoices = Invoice::with(['lease.room', 'lease.tenant'])->latest()->get();
        $leases = Lease::with(['room', 'tenant'])->where('status', 'active')->get();
        return view('invoices', compact('invoices', 'leases'));
    }

    // បង្កើត Invoice ថ្មី
    public function storeInvoice(Request $request)
    {
        $request->validate([
            'lease_id' => 'required|exists:leases,id',
            'month_year' => 'required|string',
            'water_usage' => 'required|numeric',
            'electricity_usage' => 'required|numeric',
            'due_date' => 'required|date',
        ]);

        $lease = Lease::with('room')->findOrFail($request->lease_id);

        $waterTotal = $request->water_usage * $lease->room->water_rate;
        $electricityTotal = $request->electricity_usage * $lease->room->electricity_rate;
        $totalAmount = $lease->rent_amount + $waterTotal + $electricityTotal;

        Invoice::create([
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

        return redirect()->back()->with('success', 'បង្កើតវិក្កយបត្រជោគជ័យ!');
    }
}