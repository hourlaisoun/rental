@extends('layouts.app')

@section('title', 'Properties | Rental System')
@section('page_title', 'គ្រប់គ្រងអគារស្នាក់នៅ (Properties)')

@section('content')
@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Form បន្ថែមអគារ -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-5 h-5 text-blue-600"></i> បន្ថែមអគារថ្មី
        </h3>
        <form action="{{ route('web.properties.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ឈ្មោះអគារ</label>
                <input type="text" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="ឧ. អាផាតមិន សន្តិភាព">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">អាសយដ្ឋាន</label>
                <input type="text" name="address" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="ឧ. ភ្នំពេញ">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ការពិពណ៌នា</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="ព័ត៌មានបន្ថែម..."></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg transition">រក្សាទុក</button>
        </form>
    </div>

    <!-- បញ្ជីអគារ -->
    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">បញ្ជីអគារទាំងអស់</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 text-gray-500 text-sm">
                        <th class="py-3 px-4">#</th>
                        <th class="py-3 px-4">ឈ្មោះអគារ</th>
                        <th class="py-3 px-4">អាសយដ្ឋាន</th>
                        <th class="py-3 px-4">ចំនួនបន្ទប់</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($properties as $property)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 font-semibold text-gray-600">{{ $property->id }}</td>
                            <td class="py-3 px-4 font-bold text-blue-600">{{ $property->title }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $property->address }}</td>
                            <td class="py-3 px-4"><span class="px-2 py-1 bg-blue-50 text-blue-600 rounded-md font-semibold">{{ $property->rooms_count }} បន្ទប់</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-400">មិនទាន់មានទិន្នន័យអគារនៅឡើយទេ</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection