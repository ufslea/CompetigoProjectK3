@extends('layouts.organizer')

@section('content')
@php
    $search = $search ?? '';
    $status_filter = $status_filter ?? '';
@endphp
@php
    $search = $search ?? '';
    $status_filter = $status_filter ?? '';
    $status = $status ?? ''; // ← tambahan untuk memperbaiki error sekarang
@endphp

<div class="flex">
    @include('components.sidebar-organizer')

    <div class="flex-1 px-8 py-6">

        @include('components.navbar')

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Daftar Event</h1>
            <a href="{{ route('organizer.events.create') }}"
               class="px-5 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow hover:scale-105 transition">
                + Tambah Event
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- Search & Filter Section --}}
        <div class="mb-6 bg-white rounded-lg shadow-md p-4">
            <form method="GET" action="{{ route('organizer.events.index') }}" class="flex items-end gap-4">
                {{-- Search Input --}}
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Event</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Nama atau deskripsi event..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                </div>

                {{-- Status Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Semua</option>
                        <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="finished" {{ $status === 'finished' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-2">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Cari
                    </button>
                    <a href="{{ route('organizer.events.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @if($events->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                <div class="bg-white shadow-md rounded-2xl overflow-hidden hover:shadow-lg transition">
                    
                    @if($event->gambar)
                        <img src="{{ asset('storage/' . $event->gambar) }}" alt="{{ $event->nama }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-300 flex items-center justify-center text-gray-500">
                            No Image
                        </div>
                    @endif

                    <div class="p-5">
                        <h3 class="text-lg font-semibold mb-2">{{ $event->nama }}</h3>
                        <p class="text-gray-600 text-sm line-clamp-2">{{ $event->deskripsi }}</p>

                        <div class="mt-3 space-y-1">
                            <div class="text-xs text-gray-500">
                                <strong>Mulai:</strong> {{ $event->tanggal_mulai?->format('d M Y') ?? '-' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                <strong>Akhir:</strong> {{ $event->tanggal_akhir?->format('d M Y') ?? '-' }}
                            </div>
                            <span class="inline-block text-xs bg-indigo-100 text-indigo-600 px-2 py-1 rounded-lg mt-2">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-2 mt-4">
                            <a href="{{ route('organizer.events.show', $event->events_id) }}"
                               class="flex-1 text-center text-indigo-600 hover:underline py-2 bg-indigo-50 rounded text-sm font-medium">Detail</a>

                            <a href="{{ route('organizer.events.edit', $event->events_id) }}"
                               class="flex-1 text-center text-yellow-600 hover:underline py-2 bg-yellow-50 rounded text-sm font-medium">Edit</a>

                            <form action="{{ route('organizer.events.destroy', $event->events_id) }}" method="POST"
                                  onsubmit="return confirm('Hapus event ini?')" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full text-red-600 hover:underline py-2 bg-red-50 rounded text-sm font-medium">Hapus</button>
                            </form>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $events->links('pagination::tailwind') }}
            </div>
        @else
            <div class="bg-gray-50 rounded-xl p-8 text-center">
                <p class="text-gray-500 mb-4">Belum ada event</p>
                <a href="{{ route('organizer.events.create') }}" class="inline-block px-6 py-2 bg-indigo-600 text-white rounded-xl hover:scale-105 transition">
                    Buat Event Pertama
                </a>
            </div>
        @endif

    </div>
</div>

@include('components.footer')
@endsection
