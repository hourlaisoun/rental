<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Property;
use App\Models\Room;
use App\Models\User;

class DashboardController extends Controller
{
    public function stats()
    {
        $totalProperties = Property::count();
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $availableRooms = Room::where('status', 'available')->count();
        $totalTenants = User::where('role', 'tenant')->count();
        
        $totalRevenue = Invoice::where('status', 'paid')->sum('total_amount');
        $unpaidInvoices = Invoice::where('status', 'unpaid')->count();

        return response()->json([
            'total_properties' => $totalProperties,
            'total_rooms' => $totalRooms,
            'occupied_rooms' => $occupiedRooms,
            'available_rooms' => $availableRooms,
            'total_tenants' => $totalTenants,
            'total_revenue' => $totalRevenue,
            'unpaid_invoices_count' => $unpaidInvoices,
        ]);
    }
}