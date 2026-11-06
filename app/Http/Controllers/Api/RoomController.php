<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // មើលបញ្ជីបន្ទប់ទាំងអស់
    public function index()
    {
        $rooms = Room::with('property')->get();

        // កែសម្រួលឱ្យមាន 'success' និង 'data' ស្អាត
        return response()->json([
            'success' => true,
            'data' => $rooms
        ], 200);
    }

    // បង្កើតបន្ទប់ថ្មី
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_number' => 'required|string',
            'base_price' => 'required|numeric',
            'water_rate' => 'required|numeric',
            'electricity_rate' => 'required|numeric',
        ]);

        $room = Room::create([
            'property_id' => $request->property_id,
            'room_number' => $request->room_number,
            'base_price' => $request->base_price,
            'water_rate' => $request->water_rate,
            'electricity_rate' => $request->electricity_rate,
            'status' => 'available',
        ]);

        return response()->json([
            'message' => 'Room created successfully',
            'room' => $room
        ], 201);
    }
}