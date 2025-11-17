@extends('layouts.organizer')

@section('content')
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

        @if($events->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($events as $event)
                <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                    
                    <h3 class="text-xl font-semibold mb-2">{{ $event->nama }}</h3>

                    <p class="text-gray-600 line-clamp-3">{{ $event->deskripsi }}</p>

                    <div class="mt-4 space-y-2">
                        <div class="text-sm text-gray-500">
                            <strong>Mulai:</strong> {{ $event->tanggal_mulai?->format('d M Y') ?? '-' }}
                        </div>
                        <div class="text-sm text-gray-500">
                            <strong>Akhir:</strong> {{ $event->tanggal_akhir?->format('d M Y') ?? '-' }}
                        </div>
                        <span class="inline-block text-sm bg-indigo-100 text-indigo-600 px-3 py-1 rounded-xl">
                            {{ ucfirst($event->status) }}
                        </span>
                    </div>

                    <div class="flex justify-between mt-5 gap-2">
                        <a href="{{ route('organizer.events.show', $event->events_id) }}"
                           class="flex-1 text-center text-indigo-600 hover:underline py-2 bg-indigo-50 rounded">Detail</a>

                        <a href="{{ route('organizer.events.edit', $event->events_id) }}"
                           class="flex-1 text-center text-yellow-600 hover:underline py-2 bg-yellow-50 rounded">Edit</a>

                        <form action="{{ route('organizer.events.destroy', $event->events_id) }}" method="POST"
                              onsubmit="return confirm('Hapus event ini?')" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full text-red-600 hover:underline py-2 bg-red-50 rounded">Hapus</button>
                        </form>
                    </div>

                </div>
                @endforeach
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
