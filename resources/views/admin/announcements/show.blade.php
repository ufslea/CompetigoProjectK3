@extends('layouts.admin')

@section('title', 'Detail Pengumuman')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Detail Pengumuman</h1>
    <div class="flex space-x-3">
        <a href="{{ route('admin.announcements.edit', $pengumuman->pengumuman_id) }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-edit mr-2"></i>Edit
        </a>
        <a href="{{ route('admin.announcements.index') }}" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="mb-6">
        <h3 class="font-semibold text-gray-700 mb-2">Event</h3>
        <p class="text-gray-900">{{ $pengumuman->event->nama ?? '-' }}</p>
    </div>

    <div class="mb-6">
        <h3 class="font-semibold text-gray-700 mb-2">Judul</h3>
        <p class="text-gray-900 text-xl">{{ $pengumuman->judul }}</p>
    </div>

    <div class="mb-6">
        <h3 class="font-semibold text-gray-700 mb-2">Isi</h3>
        <div class="text-gray-700 whitespace-pre-wrap bg-gray-50 p-4 rounded-lg">{{ $pengumuman->isi }}</div>
    </div>

    <div class="border-t pt-4">
        <p class="text-sm text-gray-500">Dibuat: {{ $pengumuman->created_at->format('d M Y H:i') }}</p>
        <p class="text-sm text-gray-500">Diupdate: {{ $pengumuman->updated_at->format('d M Y H:i') }}</p>
    </div>
</div>
@endsection

