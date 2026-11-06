@extends('layouts.app')

@section('title', 'Tenants | Rental System')
@section('page_title', 'គ្រប់គ្រងអ្នកជួល (Tenants)')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h3 class="text-lg font-bold text-gray-800 mb-4">បញ្ជីអ្នកជួលទាំងអស់</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200 text-gray-500 text-sm">
                    <th class="py-3 px-4">#</th>
                    <th class="py-3 px-4">ឈ្មោះ</th>
                    <th class="py-3 px-4">អ៊ីមែល</th>
                    <th class="py-3 px-4">លេខទូរស័ព្ទ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($tenants as $tenant)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 font-semibold text-gray-600">{{ $tenant->id }}</td>
                        <td class="py-3 px-4 font-bold text-gray-800">{{ $tenant->name }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $tenant->email }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $tenant->phone ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-400">មិនទាន់មានទិន្នន័យអ្នកជួលនៅឡើយទេ</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection