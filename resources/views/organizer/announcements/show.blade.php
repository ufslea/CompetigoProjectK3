@extends('layouts.organizer')

@section('title', 'Detail Pengumuman')

@section('content')
<div class="page-header mb-6">
    <h2 class="text-2xl font-bold text-primary-dark">Detail Pengumuman</h2>
    <p class="text-gray-600">Informasi lengkap dari pengumuman yang dipublikasikan.</p>
</div>

<div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">

    {{-- Judul --}}
    <div class="mb-5">
        <h3 class="text-xl font-semibold text-primary-dark">{{ $pengumuman->judul }}</h3>
        <p class="text-sm text-gray-500">
            Dipublikasikan pada: {{ $pengumuman->created_at->format('d M Y, H:i') }}
        </p>
    </div>

    {{-- Isi --}}
    <div class="prose max-w-none text-gray-800 leading-relaxed mb-6">
        {!! nl2br(e($pengumuman->deskripsi)) !!}
    </div>

    {{-- Lampiran jika ada --}}
    @if ($pengumuman->file)
        <div class="mt-4">
            <p class="font-semibold text-gray-700 mb-2">Lampiran:</p>
            <a href="{{ asset('storage/announcements/' . $announcement->file) }}" 
               class="px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-md shadow"
               download>
                Download Lampiran
            </a>
        </div>
    @endif

    {{-- Tombol Aksi --}}
    <div class="mt-8 flex items-center gap-3">
        <a href="{{ route('organizer.announcements.index') }}" 
            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-md">
            Kembali
        </a>

        <a href="{{ route('organizer.announcements.edit', $announcement->id) }}" 
           class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">
            Edit
        </a>
    </div>
</div>

@include('components.footer')
@endsection
