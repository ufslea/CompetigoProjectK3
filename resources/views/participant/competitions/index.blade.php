@extends('layouts.participant')

@section('content')
<div class="container py-5">

    {{-- Judul --}}
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Daftar Kompetisi</h1>

    {{-- Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Success Alert --}}
@if (session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm font-medium text-green-800">{{ session('success') }}</span>
        </div>
    </div>
@endif

{{-- Error Alert --}}
@if (session('error'))
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm font-medium text-red-800">{{ session('error') }}</span>
        </div>
    </div>
@endif
        @php
            $favoriteIds = Auth::check()
                ? Auth::user()->favorits()->pluck('events_id')->toArray()
                : [];
        @endphp

        @foreach ($events as $event)
            @php
                $isFavorited = in_array($event->events_id, $favoriteIds);
            @endphp

            <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">

                {{-- Banner --}}
                @if ($event->gambar)
                    <img src="{{ asset('storage/' . $event->gambar) }}"
                         class="w-full h-40 object-cover">
                @else
                    <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500">
                        No Image
                    </div>
                @endif

                {{-- Body --}}
                <div class="p-4">

                    {{-- Judul --}}
                    <h2 class="text-lg font-semibold text-gray-900 mb-1">
                        {{ $event->nama }}
                    </h2>

                    {{-- Tanggal --}}
                    <p class="text-gray-500 text-sm mb-3">
                        {{ $event->tanggal_mulai?->format('d M Y') ?? '-' }} —
                        {{ $event->tanggal_akhir?->format('d M Y') ?? '-' }}
                    </p>

                    {{-- Deskripsi --}}
                    <p class="text-gray-600 text-sm mb-4">
                        {{ \Str::limit($event->deskripsi, 90) }}
                    </p>

                    {{-- CTA --}}
                    <div class="flex justify-between items-center">

                        {{-- Lihat Detail --}}
                        <a href="{{ route('participant.competitions.show', $event->events_id) }}"
                           class="px-4 py-2 rounded-md text-white text-sm"
                           style="background:#003366;">
                            Lihat Detail
                        </a>

                        {{-- Favorit --}}
                        @if(Auth::check())
                            <button 
                                class="text-sm text-blue-700 underline favorite-btn"
                                data-id="{{ $event->events_id }}">
                                {{ $isFavorited ? 'Unfavorit' : 'Favorit' }}
                            </button>
                        @else
                            <a href="{{ route('login') }}" 
                               class="text-sm text-blue-700 underline">
                                Favorit
                            </a>
                        @endif

                    </div>

                </div>
            </div>

        @endforeach

    </div>

    {{-- Pagination --}}
    <div class="mt-6 flex justify-center">
        {{ $events->links() }}
    </div>
</div>

{{-- AJAX --}}
<script>
document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".favorite-btn").forEach(btn => {

        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const eventId = btn.dataset.id;
            const isUnfavoriting = btn.innerText.trim() === "Unfavorit";

            if (isUnfavoriting) {
                // DELETE
                fetch(`/favorit/${eventId}`, {
                    method: "DELETE",
                    headers: { 
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        btn.innerText = "Favorit";
                    }
                })
                .catch(error => console.error('Error:', error));

            } else {
                // POST
                fetch(`/favorit`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({ events_id: parseInt(eventId) })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' || data.status === 'already') {
                        btn.innerText = "Unfavorit";
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });

    });

});
</script>
@endsection
