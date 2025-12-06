@extends('layouts.participant')

@section('content')
<div class="container py-5">

    {{-- Judul --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar Kompetisi</h1>
        <p class="text-gray-600">Temukan dan ikuti kompetisi yang Anda minati</p>
    </div>

    {{-- Alerts --}}
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3">
            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm font-medium text-green-800">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3">
            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm font-medium text-red-800">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Search and Filter Bar --}}
    <div class="mb-8 bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Search Input --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Kompetisi</label>
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $search ?? '' }}" 
                            placeholder="Cari nama atau deskripsi kompetisi..." 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <svg class="absolute right-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                {{-- Status Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select 
                        name="status" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white">
                        <option value="">Semua Status</option>
                        <option value="active" {{ ($status ?? '') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="completed" {{ ($status ?? '') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="upcoming" {{ ($status ?? '') == 'upcoming' ? 'selected' : '' }}>Mendatang</option>
                    </select>
                </div>
            </div>

            {{-- Submit and Reset Buttons --}}
            <div class="flex gap-3">
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium flex items-center gap-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>
                <a 
                    href="{{ route('participant.competitions.index') }}" 
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Results Info --}}
    @if($search || $status)
        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-sm text-blue-900">
                Menampilkan kompetisi
                @if($search) dengan pencarian "<strong>{{ $search }}</strong>" @endif
                @if($status) dengan status "<strong>{{ $status }}</strong>" @endif
            </p>
        </div>
    @endif

    {{-- Grid --}}
    @if($events->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @php
                $favoriteIds = Auth::check()
                    ? Auth::user()->favorits()->pluck('events_id')->toArray()
                    : [];
            @endphp

            @foreach ($events as $event)
                @php
                    $isFavorited = in_array($event->events_id, $favoriteIds);
                @endphp

                <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100 hover:shadow-md transition">

                    {{-- Banner --}}
                    @if ($event->gambar)
                        <img src="{{ asset('storage/' . $event->gambar) }}"
                             class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center text-gray-400">
                            <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif

                    {{-- Body --}}
                    <div class="p-4 flex flex-col h-full">

                        {{-- Status Badge --}}
                        <div class="mb-2">
                            @if($event->status === 'active')
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                            @elseif($event->status === 'completed')
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Selesai</span>
                            @else
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Mendatang</span>
                            @endif
                        </div>

                        {{-- Judul --}}
                        <h2 class="text-lg font-semibold text-gray-900 mb-1 line-clamp-2">
                            {{ $event->nama }}
                        </h2>

                        {{-- Tanggal --}}
                        <p class="text-gray-500 text-sm mb-3 flex items-center gap-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $event->tanggal_mulai?->format('d M Y') ?? '-' }}
                        </p>

                        {{-- Deskripsi --}}
                        <p class="text-gray-600 text-sm mb-4 flex-grow line-clamp-3">
                            {{ \Str::limit($event->deskripsi, 100) }}
                        </p>

                        {{-- CTA --}}
                        <div class="flex justify-between items-center gap-2 border-t pt-4">

                            {{-- Lihat Detail --}}
                            <a href="{{ route('participant.competitions.show', $event->events_id) }}"
                               class="flex-1 text-center px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition">
                                Lihat Detail
                            </a>

                            {{-- Favorit --}}
                            @if(Auth::check())
                                <button 
                                    class="favorite-btn p-2 rounded-lg border transition"
                                    data-id="{{ $event->events_id }}"
                                    title="{{ $isFavorited ? 'Hapus dari favorit' : 'Tambah ke favorit' }}"
                                    style="{{ $isFavorited ? 'background:#fef08a; border-color:#facc15;' : 'border-color:#e5e7eb;' }}">
                                    <svg class="h-5 w-5" style="{{ $isFavorited ? 'color:#f59e0b;' : 'color:#d1d5db;' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </button>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="p-2 rounded-lg border border-gray-300 hover:bg-gray-50 transition"
                                   title="Login untuk menambah favorit">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"/>
                                    </svg>
                                </a>
                            @endif

                        </div>

                    </div>
                </div>

            @endforeach

        </div>

        {{-- Pagination --}}
        <div class="flex justify-center mb-8">
            <div class="pagination">
                {{ $events->appends(request()->query())->links() }}
            </div>
        </div>
    @else
        {{-- Empty State --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada kompetisi ditemukan</h3>
            <p class="text-gray-600 mb-6">Coba ubah filter atau cari istilah yang berbeda</p>
            <a href="{{ route('participant.competitions.index') }}" class="inline-block px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Lihat Semua Kompetisi
            </a>
        </div>
    @endif

</div>

{{-- AJAX Favorite Handler --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".favorite-btn").forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            const eventId = btn.dataset.id;
            const isFavorited = btn.style.backgroundColor === 'rgb(254, 240, 138)';

            if (isFavorited) {
                // DELETE - Remove from favorites
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
                        btn.style.background = '';
                        btn.style.borderColor = '#e5e7eb';
                        btn.querySelector('svg').style.color = '#d1d5db';
                    }
                })
                .catch(error => console.error('Error:', error));

            } else {
                // POST - Add to favorites
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
                        btn.style.background = '#fef08a';
                        btn.style.borderColor = '#facc15';
                        btn.querySelector('svg').style.color = '#f59e0b';
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });
});
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
