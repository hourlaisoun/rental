@extends('layouts.app')

@section('title', 'Invoices | Rental System')
@section('page_title', 'គ្រប់គ្រងវិក្កយបត្រ (Invoices)')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form បង្កើតវិក្កយបត្រ -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="file-plus" class="w-5 h-5 text-emerald-600"></i> បង្កើតវិក្កយបត្រថ្មី
        </h3>
        <form action="{{ route('web.invoices.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ជ្រើសរើសកិច្ចសន្យា/បន្ទប់</label>
                <select name="lease_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none">
                    @foreach($leases as $lease)
                        <option value="{{ $lease->id }}">បន្ទប់ {{ $lease->room->room_number }} ({{ $lease->tenant->name }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ប្រចាំខែ/ឆ្នាំ</label>
                <input type="month" name="month_year" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none">
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">គីឡូទឹកប្រើប្រាស់ (m³)</label>
                    <input type="number" step="0.1" name="water_usage" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none" placeholder="10">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">គីឡូភ្លើងប្រើប្រាស់ (kWh)</label>
                    <input type="number" step="0.1" name="electricity_usage" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none" placeholder="50">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ថ្ងៃផុតកំណត់បង់ប្រាក់</label>
                <input type="date" name="due_date" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none">
            </div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg transition">ចេញវិក្កយបត្រ</button>
        </form>
    </div>

    <!-- បញ្ជីវិក្កយបត្រ -->
    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">បញ្ជីវិក្កយបត្រទាំងអស់</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 text-gray-500 text-sm">
                        <th class="py-3 px-4">បន្ទប់</th>
                        <th class="py-3 px-4">ប្រចាំខែ</th>
                        <th class="py-3 px-4">ទឹក/ភ្លើង</th>
                        <th class="py-3 px-4">សរុប</th>
                        <th class="py-3 px-4">ស្ថានភាព</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($invoices as $inv)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 font-bold text-gray-800">បន្ទប់ {{ $inv->lease->room->room_number }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $inv->month_year }}</td>
                            <td class="py-3 px-4 text-xs text-gray-500">
                                ទឹក: ${{ $inv->water_total }} | ភ្លើង: ${{ $inv->electricity_total }}
                            </td>
                            <td class="py-3 px-4 font-bold text-blue-600">${{ number_format($inv->total_amount, 2) }}</td>
                            <td class="py-3 px-4">
                                @if($inv->status == 'paid')
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">បង់រួច</span>
                                @else
                                    <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-md text-xs font-medium">មិនទាន់បង់</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-400">មិនទាន់មានទិន្នន័យវិក្កយបត្រនៅឡើយទេ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection