<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    // មើលបញ្ជី Properties ទាំងអស់
    public function index()
    {
        $properties = Property::with('rooms')->get();
        return response()->json($properties);
    }

    // បង្កើត Property ថ្មី
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $property = Property::create([
            'landlord_id' => $request->user()->id,
            'title' => $request->title,
            'address' => $request->address,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Property created successfully',
            'property' => $property
        ], 201);
    }

    // មើលព័ត៌មាន Property មួយ
    public function show($id)
    {
        $property = Property::with('rooms')->find($id);

        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        return response()->json($property);
    }
}