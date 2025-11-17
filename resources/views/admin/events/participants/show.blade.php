@extends('layouts.admin')

@section('title', 'Detail Participant')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Detail Participant</h1>
    <a href="{{ route('admin.events.participants.index', ['event_id' => $partisipan->sublomba->event_id]) }}" class="text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="font-semibold text-gray-700 mb-4">Informasi User</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-sm font-medium text-gray-600">Nama</p>
                    <p class="text-gray-900">{{ $partisipan->user->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Email</p>
                    <p class="text-gray-900">{{ $partisipan->user->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">No. HP</p>
                    <p class="text-gray-900">{{ $partisipan->user->no_hp ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div>
            <h3 class="font-semibold text-gray-700 mb-4">Informasi Partisipasi</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-sm font-medium text-gray-600">Sub Lomba</p>
                    <p class="text-gray-900">{{ $partisipan->sublomba->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Institusi</p>
                    <p class="text-gray-900">{{ $partisipan->institusi ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Kontak</p>
                    <p class="text-gray-900">{{ $partisipan->kontak ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Status</p>
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $partisipan->status == 'approved' ? 'bg-green-100 text-green-800' : 
                           ($partisipan->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($partisipan->status == 'submitted' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                        {{ ucfirst($partisipan->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if($partisipan->file_karya)
        <div class="mt-6 border-t pt-6">
            <h3 class="font-semibold text-gray-700 mb-2">File Karya</h3>
            <a href="{{ $partisipan->file_karya }}" target="_blank" class="text-blue-600 hover:underline">{{ $partisipan->file_karya }}</a>
        </div>
    @endif

    <div class="mt-6 flex justify-end">
        <a href="{{ route('admin.events.participants.edit', ['event_id' => $partisipan->sublomba->event_id, 'id' => $partisipan->partisipan_id]) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            Edit Status
        </a>
    </div>
</div>
@endsection

