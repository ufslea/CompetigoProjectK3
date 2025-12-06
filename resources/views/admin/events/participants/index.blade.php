@extends('layouts.admin')

@section('title', 'Participants')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Participants</h1>
        <p class="text-gray-600 mt-1">Daftar peserta event</p>
    </div>
    @if(isset($event_id))
        <a href="{{ route('admin.events.show', $event_id) }}" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Event
        </a>
    @endif
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form action="{{ route('admin.events.participants.index', $event_id ?? '') }}" method="GET" class="flex gap-4 flex-wrap">
        <input type="text" name="search" placeholder="Cari nama, email..." value="{{ $search ?? '' }}" class="flex-1 min-w-64 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <select name="status" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">Semua Status</option>
            <option value="pending" {{ ($status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="submitted" {{ ($status ?? '') == 'submitted' ? 'selected' : '' }}>Submitted</option>
            <option value="approved" {{ ($status ?? '') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ ($status ?? '') == 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Cari</button>
        <a href="{{ route('admin.events.participants.index', $event_id ?? '') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Reset</a>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full divide-y divide-gray-200">
        <thead class="bg-gray-50 sticky top-0">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Sub Lomba</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Institusi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($partisipans as $partisipan)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $partisipan->user->nama ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $partisipan->user->email ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $partisipan->sublomba->nama ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $partisipan->institusi ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $partisipan->status == 'approved' ? 'bg-green-100 text-green-800' : 
                               ($partisipan->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($partisipan->status == 'submitted' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                            {{ ucfirst($partisipan->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @php
                            $eventId = $event_id ?? $partisipan->sublomba->event_id ?? null;
                        @endphp
                        <a href="{{ route('admin.events.participants.show', ['event_id' => $eventId, 'id' => $partisipan->partisipan_id]) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Detail</a>
                        <a href="{{ route('admin.events.participants.edit', ['event_id' => $eventId, 'id' => $partisipan->partisipan_id]) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada peserta</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($partisipans->hasPages())
        <div class="px-6 py-4">
            {{ $partisipans->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection

