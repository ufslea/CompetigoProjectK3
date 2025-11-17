@extends('layouts.admin')

@section('title', 'Sub Lomba')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Sub Lomba</h1>
        <p class="text-gray-600 mt-1">Event: {{ $event->nama }}</p>
    </div>
    <a href="{{ route('admin.events.show', $event->events_id) }}" class="text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Event
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($subLombas as $sublomba)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $sublomba->nama }}</div>
                        <div class="text-sm text-gray-500">{{ Str::limit($sublomba->deskripsi, 50) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $sublomba->kategori }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $sublomba->deadline ? \Carbon\Carbon::parse($sublomba->deadline)->format('d M Y') : '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            {{ $sublomba->status == 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($sublomba->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.events.sublomba.edit', ['event_id' => $event->events_id, 'id' => $sublomba->sublomba_id]) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada sub lomba</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

