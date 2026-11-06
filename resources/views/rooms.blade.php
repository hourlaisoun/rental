@extends('layouts.app')

@section('title', 'Rooms | Rental System')
@section('page_title', 'គ្រប់គ្រងបន្ទប់ជួល (Rooms)')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form បន្ថែមបន្ទប់ -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-5 h-5 text-indigo-600"></i> បន្ថែមបន្ទប់ថ្មី
        </h3>
        <form action="{{ route('web.rooms.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ជ្រើសរើសអគារ</label>
                <select name="property_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    @foreach($properties as $prop)
                        <option value="{{ $prop->id }}">{{ $prop->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">លេខបន្ទប់</label>
                <input type="text" name="room_number" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="ឧ. 101, A2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">តម្លៃជួល ($/ខែ)</label>
                <input type="number" step="0.01" name="base_price" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="150.00">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">ថ្លៃទឹក ($/m³)</label>
                    <input type="number" step="0.01" name="water_rate" value="0.50" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">ថ្លៃភ្លើង ($/kWh)</label>
                    <input type="number" step="0.01" name="electricity_rate" value="0.25" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none">
                </div>
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 rounded-lg transition">រក្សាទុក</button>
        </form>
    </div>

    <!-- បញ្ជីបន្ទប់ -->
    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">បញ្ជីបន្ទប់ទាំងអស់</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 text-gray-500 text-sm">
                        <th class="py-3 px-4">លេខបន្ទប់</th>
                        <th class="py-3 px-4">អគារ</th>
                        <th class="py-3 px-4">តម្លៃជួល</th>
                        <th class="py-3 px-4">ស្ថានភាព</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($rooms as $room)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 font-bold text-gray-800">បន្ទប់ {{ $room->room_number }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $room->property->title }}</td>
                            <td class="py-3 px-4 font-semibold text-emerald-600">${{ number_format($room->base_price, 2) }}</td>
                            <td class="py-3 px-4">
                                @if($room->status == 'available')
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">ទំនេរ</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-md text-xs font-medium">មានអ្នកជួល</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-400">មិនទាន់មានទិន្នន័យបន្ទប់នៅឡើយទេ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection