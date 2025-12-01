@extends('layouts.organizer')

@section('content')
<div class="flex">
    @include('components.sidebar-organizer')

    <div class="flex-1 px-8 py-6">

        @include('components.navbar')

        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $event->nama }}</h1>

        <div class="bg-white shadow-md rounded-2xl p-6 mb-8">

            @if($event->gambar)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $event->gambar) }}" alt="{{ $event->nama }}" 
                         class="w-full h-64 object-cover rounded-lg">
                </div>
            @endif

            <p class="text-gray-700 mb-4">{{ $event->deskripsi }}</p>

            <p class="mb-2">
                <strong>URL:</strong> 
                <a href="{{ $event->url }}" target="_blank" class="text-indigo-600 hover:underline">{{ $event->url }}</a>
            </p>

            <p class="mb-3">
                <strong>Tanggal:</strong> 
                {{ $event->tanggal_mulai?->format('d M Y') ?? '-' }} 
                → 
                {{ $event->tanggal_akhir?->format('d M Y') ?? '-' }}
            </p>

            <span class="inline-block bg-indigo-100 text-indigo-600 px-4 py-1 rounded-xl">
                {{ ucfirst($event->status) }}
            </span>

            <div class="mt-4 flex gap-2">
                <a href="{{ route('organizer.events.edit', $event->events_id) }}"
                   class="px-4 py-2 bg-yellow-500 text-white rounded-xl hover:scale-105 transition">Edit</a>
                <form action="{{ route('organizer.events.destroy', $event->events_id) }}" method="POST" class="inline"
                      onsubmit="return confirm('Hapus event ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-xl hover:scale-105 transition">Hapus</button>
                </form>
                <a href="{{ route('organizer.events.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded-xl hover:scale-105 transition">Kembali</a>
            </div>
        </div>

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold">Sub-Lomba</h2>

            <a href="{{ route('organizer.events.sublomba.create', $event->events_id) }}"
               class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow hover:scale-105 transition">
                + Tambah Sub-Lomba
            </a>
        </div>

        @if($event->subLombas->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($event->subLombas as $sublomba)
                <div class="bg-white shadow rounded-2xl p-5 hover:shadow-lg transition">
                    <h3 class="font-semibold text-lg mb-1">{{ $sublomba->nama_sublomba ?? $sublomba->nama }}</h3>
                    <p class="text-gray-600 text-sm">{{ ucfirst($sublomba->jenis) ?? 'N/A' }}</p>

                    <div class="flex justify-between mt-4 gap-2">
                        <a href="{{ route('organizer.events.sublomba.edit', [$event->events_id, $sublomba->sublomba_id]) }}" 
                           class="flex-1 text-center text-yellow-600 hover:underline py-2 bg-yellow-50 rounded text-sm">
                            Edit
                        </a>
                        <form action="{{ route('organizer.events.sublomba.destroy', [$event->events_id, $sublomba->sublomba_id]) }}" 
                              method="POST" class="flex-1"
                              onsubmit="return confirm('Hapus sub-lomba ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full text-red-600 hover:underline py-2 bg-red-50 rounded text-sm">Hapus</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-gray-50 rounded-xl p-8 text-center">
                <p class="text-gray-500 mb-4">Belum ada sub-lomba</p>
                <a href="{{ route('organizer.events.sublomba.create', $event->events_id) }}" 
                   class="inline-block px-6 py-2 bg-indigo-600 text-white rounded-xl hover:scale-105 transition">
                    Buat Sub-Lomba Pertama
                </a>
            </div>
        @endif

    </div>
</div>

@include('components.footer')
@endsection