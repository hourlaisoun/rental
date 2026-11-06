@extends('layouts.app')

@section('title', 'Dashboard | Rental System')
@section('page_title', 'ផ្ទាំងព័ត៌មានទូទៅ (Dashboard Overview)')

@section('content')
<!-- Overview Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Total Properties Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">អគារសរុប</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_properties'] }}</h3>
        </div>
        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
            <i data-lucide="building"></i>
        </div>
    </div>

    <!-- Total Rooms Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">បន្ទប់សរុប (ទំនេរ/មានអ្នកជួល)</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">
                {{ $stats['total_rooms'] }} 
                <span class="text-xs text-green-600 font-normal">({{ $stats['available_rooms'] }} ទំនេរ)</span>
            </h3>
        </div>
        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-lg">
            <i data-lucide="door-open"></i>
        </div>
    </div>

    <!-- Total Tenants Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">អ្នកជួលសរុប</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_tenants'] }}</h3>
        </div>
        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
            <i data-lucide="users"></i>
        </div>
    </div>

    <!-- Total Revenue Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">ចំណូលសរុប (ទទួលបាន)</p>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">${{ number_format($stats['total_revenue'], 2) }}</h3>
        </div>
        <div class="p-3 bg-amber-50 text-amber-600 rounded-lg">
            <i data-lucide="dollar-sign"></i>
        </div>
    </div>

</div>

<!-- Quick Action & Status Banner -->
<!-- សកម្មភាពរហ័ស (Quick Actions) -->
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
    <h3 class="text-lg font-bold text-gray-800 mb-4">សកម្មភាពរហ័ស (Quick Actions)</h3>
    <div class="flex flex-wrap gap-4">
        <!-- ប៊ូតុង បន្ថែមអគារថ្មី -->
        <a href="{{ route('web.properties') }}" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2.5 rounded-lg transition shadow-sm">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            <span>បន្ថែមអគារថ្មី</span>
        </a>

        <!-- ប៊ូតុង បន្ថែមបន្ទប់ថ្មី -->
        <a href="{{ route('web.rooms') }}" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2.5 rounded-lg transition shadow-sm">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            <span>បន្ថែមបន្ទប់ថ្មី</span>
        </a>

        <!-- ប៊ូតុង បង្កើតវិក្កយបត្រថ្មី -->
        <a href="{{ route('web.invoices') }}" class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-4 py-2.5 rounded-lg transition shadow-sm">
            <i data-lucide="file-plus" class="w-5 h-5"></i>
            <span>បង្កើតវិក្កយបត្រថ្មី</span>
        </a>
    </div>
</div>
@endsection