@extends('layouts.organizer')

@section('content')

@php
    $search = $search ?? '';
    $status = $status ?? '';
    $events = $events ?? collect();
@endphp


<div class="flex">
    @include('components.sidebar-organizer')

    <div class="flex-1 px-8 py-6">
        @include('components.navbar')

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-[#1D3557]">Daftar Pengumuman</h1>

            <a href="{{ route('organizer.announcements.create') }}"
               class="px-4 py-2 bg-[#1D3557] text-white rounded-lg hover:bg-[#457B9D] transition">
               + Tambah Pengumuman
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Search & Filter Section --}}
        <div class="mb-6 bg-white rounded-lg shadow-md p-4">
            <form method="GET" action="{{ route('organizer.announcements.index') }}" class="flex items-end gap-4">
                {{-- Search Input --}}
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Pengumuman</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Judul atau isi pengumuman..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                </div>

                {{-- Event Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Event</label>
                    <select name="event" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Semua</option>
                        @foreach($events as $event)
                            <option value="{{ $event->events_id }}" {{ $event_filter == $event->events_id ? 'selected' : '' }}>
                                {{ $event->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-2">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Cari
                    </button>
                    <a href="{{ route('organizer.announcements.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            @forelse($pengumumans as $pengumuman)
                <div class="border-b py-4 last:border-b-0">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h2 class="text-lg font-semibold text-[#1D3557]">{{ $pengumuman->judul }}</h2>
                            <p class="text-sm text-gray-600 mt-1">
                                Event: <strong>{{ $pengumuman->event->nama ?? 'N/A' }}</strong>
                            </p>
                            <p class="text-gray-600 mt-2">{{ Str::limit($pengumuman->isi, 150) }}</p>
                            <p class="text-xs text-gray-400 mt-2">
                                {{ $pengumuman->created_at?->format('d M Y H:i') ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-3 flex gap-3">
                        <a href="{{ route('organizer.announcements.edit', $pengumuman->pengumuman_id) }}"
                           class="text-yellow-600 hover:text-yellow-800 underline text-sm font-medium">
                            Edit
                        </a>

                        <form action="{{ route('organizer.announcements.destroy', $pengumuman->pengumuman_id) }}" 
                              method="POST" class="inline"
                              onsubmit="return confirm('Hapus pengumuman ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 underline text-sm font-medium">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

            @empty
                <div class="text-center py-8">
                    <p class="text-gray-500 mb-4">Belum ada pengumuman.</p>
                    <a href="{{ route('organizer.announcements.create') }}"
                       class="inline-block px-4 py-2 bg-[#1D3557] text-white rounded hover:bg-[#457B9D] transition">
                        Buat Pengumuman Pertama
                    </a>
                </div>
            @endforelse

            {{-- Pagination --}}
            @if($pengumumans->count() > 0)
                <div class="mt-6">
                    {{ $pengumumans->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
</div>

@include('components.footer')
@endsection
