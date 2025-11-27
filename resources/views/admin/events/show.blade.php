@extends('layouts.admin')

@section('title', 'Detail Event')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Detail Event</h1>
    <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <h3 class="font-semibold text-gray-700 mb-4">Informasi Event</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-sm font-medium text-gray-600">Nama Event</p>
                    <p class="text-gray-900">{{ $event->nama }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Organizer</p>
                    <p class="text-gray-900">{{ $event->organizer->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">URL</p>
                    <a href="{{ $event->url }}" target="_blank" class="text-blue-600 hover:underline">{{ $event->url }}</a>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Status</p>
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $event->status == 'active' ? 'bg-green-100 text-green-800' : 
                           ($event->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </div>
            </div>
        </div>

        <div>
            <h3 class="font-semibold text-gray-700 mb-4">Waktu Pelaksanaan</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-sm font-medium text-gray-600">Tanggal Mulai</p>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Tanggal Akhir</p>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($event->tanggal_akhir)->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-6">
        <h3 class="font-semibold text-gray-700 mb-2">Deskripsi</h3>
        <p class="text-gray-700 whitespace-pre-wrap">{{ $event->deskripsi }}</p>
    </div>

    <div class="border-t pt-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-700">Sub Lomba</h3>
            <a href="{{ route('admin.events.sublomba.index', $event->events_id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Lihat Semua</a>
        </div>
        <div class="space-y-2">
            @forelse($event->subLombas as $sublomba)
                <div class="p-3 bg-gray-50 rounded-lg flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-900">{{ $sublomba->nama }}</p>
                        <p class="text-sm text-gray-500">{{ $sublomba->kategori }}</p>
                    </div>
                    <a href="{{ route('admin.events.sublomba.edit', ['event_id' => $event->events_id, 'id' => $sublomba->sublomba_id]) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Edit</a>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Belum ada sub lomba</p>
            @endforelse
        </div>
    </div>

    <div class="border-t pt-6 mt-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-700">Participants</h3>
            <a href="{{ route('admin.events.participants.index', $event->events_id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Lihat Semua</a>
        </div>
        <div class="space-y-2">
            @forelse($event->subLombas->flatMap->participants->take(5) as $partisipan)
                <div class="p-3 bg-gray-50 rounded-lg flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-900">{{ $partisipan->user->nama ?? '-' }}</p>
                        <p class="text-sm text-gray-500">{{ $partisipan->institusi ?? '-' }}</p>
                    </div>
                    <a href="{{ route('admin.events.participants.show', ['event' => $event->events_id, 'id' => $partisipan->partisipan_id]) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">Detail</a>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Belum ada peserta</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

