@extends('layouts.admin')

@section('title', 'Verifikasi Event')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Verifikasi Event</h1>
    <p class="text-gray-600 mt-1">Kelola dan verifikasi semua event</p>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form action="{{ route('admin.events.index') }}" method="GET" class="flex gap-4 flex-wrap">
        <input type="text" name="search" placeholder="Cari nama atau organizer..." value="{{ $search ?? '' }}" class="flex-1 min-w-64 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">Semua Status</option>
            <option value="pending" {{ ($status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="active" {{ ($status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="completed" {{ ($status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Cari</button>
        <a href="{{ route('admin.events.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Reset</a>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full divide-y divide-gray-200">
        <thead class="bg-gray-50 sticky top-0">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Nama Event</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Organizer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($events as $event)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $event->nama }}</div>
                        <div class="text-sm text-gray-500">{{ Str::limit($event->deskripsi, 50) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $event->organizer->nama ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}</div>
                        <div class="text-sm text-gray-500">s/d {{ \Carbon\Carbon::parse($event->tanggal_akhir)->format('d M Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $event->status == 'active' ? 'bg-green-100 text-green-800' : 
                               ($event->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($event->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.events.show', $event->events_id) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada event</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($events->hasPages())
        <div class="px-6 py-4">
            {{ $events->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection

