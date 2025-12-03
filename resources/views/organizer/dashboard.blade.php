@extends('layouts.organizer')

@section('title', 'Dashboard Organizer')

@section('content')
<div class="flex">
    @include('components.sidebar-organizer')

    <div class="flex-1 px-8 py-6">
        @include('components.navbar')

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Organizer</h1>
            <p class="text-gray-600 mt-2">Kelola dan pantau semua acara kompetisi Anda</p>
        </div>

        {{-- Key Statistics --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Event Card --}}
            <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 text-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-indigo-200 text-sm font-medium">Total Event</p>
                        <p class="text-3xl font-bold mt-2">{{ $totalEvent }}</p>
                    </div>
                    <svg class="h-12 w-12 text-indigo-300 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            {{-- Active Participants Card --}}
            <div class="bg-gradient-to-br from-purple-600 to-purple-700 text-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-200 text-sm font-medium">Peserta Aktif</p>
                        <p class="text-3xl font-bold mt-2">{{ $pesertaAktif }}</p>
                    </div>
                    <svg class="h-12 w-12 text-purple-300 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM9 20H4v-2a6 6 0 0112 0v2H9z"/>
                    </svg>
                </div>
            </div>

            {{-- Sub Lomba Card --}}
            <div class="bg-gradient-to-br from-pink-600 to-pink-700 text-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-pink-200 text-sm font-medium">Sub Lomba</p>
                        <p class="text-3xl font-bold mt-2">{{ $totalSubLomba }}</p>
                    </div>
                    <svg class="h-12 w-12 text-pink-300 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            {{-- Announcements Card --}}
            <div class="bg-gradient-to-br from-orange-600 to-orange-700 text-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-200 text-sm font-medium">Pengumuman</p>
                        <p class="text-3xl font-bold mt-2">{{ $pengumuman }}</p>
                    </div>
                    <svg class="h-12 w-12 text-orange-300 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.961 1.961 0 01-2.756-1.735V5.882m0 0a2 2 0 00-2-2H3a2 2 0 00-2 2v12a2 2 0 002 2h1.841c.026.04.112.034.113.06V5.882m0 0V5C1.094 2.476.838 1.5 2.747 1.5h2.383c2.908 0 2.653.94 2.653 3.382v12.357c0 2.441.255 3.382-2.653 3.382H2.747C.838 21 1.094 20.024 1.094 17.5V5.882"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            {{-- Active Events Section --}}
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Event Aktif</h2>
                </div>
                
                @if($eventAktif->isEmpty())
                    <div class="p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-500 mt-3 text-sm">Belum ada event aktif</p>
                        <a href="{{ route('organizer.events.create') }}" class="mt-3 inline-block text-indigo-600 hover:text-indigo-800 font-medium">
                            Buat Event Baru
                        </a>
                    </div>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach($eventAktif as $event)
                            <div class="p-6 hover:bg-gray-50 transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900">{{ $event->nama }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ $event->tanggal_mulai->format('d M Y') }} - {{ $event->tanggal_akhir->format('d M Y') }}
                                        </p>
                                        <p class="text-sm text-gray-500 mt-2">{{ Str::limit($event->deskripsi, 100) }}</p>
                                    </div>
                                    <div class="ml-4 flex gap-2">
                                        <a href="{{ route('organizer.events.show', $event->events_id) }}" 
                                           class="px-3 py-1 text-sm bg-indigo-100 text-indigo-600 rounded hover:bg-indigo-200 transition">
                                            Lihat
                                        </a>
                                        <a href="{{ route('organizer.events.edit', $event->events_id) }}" 
                                           class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition">
                                            Edit
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Top Sub Lomba Section --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Sub Lomba Populer</h2>
                </div>
                
                @if($topSubLomba->isEmpty())
                    <div class="p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-gray-500 mt-3 text-sm">Belum ada sub lomba</p>
                    </div>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach($topSubLomba as $index => $subLomba)
                            <div class="p-4 hover:bg-gray-50 transition">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 text-white flex items-center justify-center text-sm font-bold">
                                            #{{ $index + 1 }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 text-sm">{{ $subLomba->nama }}</p>
                                            <p class="text-xs text-gray-500">{{ $subLomba->event->nama }}</p>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-600">
                                        {{ $subLomba->partisipans_count }} peserta
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Recent Announcements Section --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Pengumuman Terbaru</h2>
                <a href="{{ route('organizer.announcements.create') }}" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                    Buat Baru
                </a>
            </div>
            
            @if($recentAnnouncements->isEmpty())
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.961 1.961 0 01-2.756-1.735V5.882m0 0a2 2 0 00-2-2H3a2 2 0 00-2 2v12a2 2 0 002 2h1.841c.026.04.112.034.113.06V5.882m0 0V5C1.094 2.476.838 1.5 2.747 1.5h2.383c2.908 0 2.653.94 2.653 3.382v12.357c0 2.441.255 3.382-2.653 3.382H2.747C.838 21 1.094 20.024 1.094 17.5V5.882"/>
                    </svg>
                    <p class="text-gray-500 mt-3 text-sm">Belum ada pengumuman</p>
                </div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach($recentAnnouncements as $announcement)
                        <div class="p-6 hover:bg-gray-50 transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $announcement->judul }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($announcement->isi, 150) }}</p>
                                    <div class="flex items-center gap-4 mt-3">
                                        <span class="text-xs text-gray-500">{{ $announcement->created_at->format('d M Y H:i') }}</span>
                                        <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700">
                                            {{ $announcement->event->nama ?? 'Event' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4 flex gap-2">
                                    <a href="{{ route('organizer.announcements.edit', $announcement->pengumuman_id) }}" 
                                       class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Quick Actions Footer --}}
        <div class="mt-8 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-6 border border-indigo-100">
            <h3 class="font-semibold text-gray-900 mb-4">Akses Cepat</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('organizer.events.create') }}" class="p-4 bg-white rounded-lg hover:shadow-md transition text-center">
                    <svg class="h-6 w-6 mx-auto text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <p class="text-sm font-medium text-gray-900">Event Baru</p>
                </a>
                <a href="{{ route('organizer.announcements.create') }}" class="p-4 bg-white rounded-lg hover:shadow-md transition text-center">
                    <svg class="h-6 w-6 mx-auto text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.961 1.961 0 01-2.756-1.735V5.882m0 0a2 2 0 00-2-2H3a2 2 0 00-2 2v12a2 2 0 002 2h1.841c.026.04.112.034.113.06V5.882m0 0V5C1.094 2.476.838 1.5 2.747 1.5h2.383c2.908 0 2.653.94 2.653 3.382v12.357c0 2.441.255 3.382-2.653 3.382H2.747C.838 21 1.094 20.024 1.094 17.5V5.882"/>
                    </svg>
                    <p class="text-sm font-medium text-gray-900">Pengumuman</p>
                </a>
                <a href="{{ route('organizer.participants.index') }}" class="p-4 bg-white rounded-lg hover:shadow-md transition text-center">
                    <svg class="h-6 w-6 mx-auto text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM9 20H4v-2a6 6 0 0112 0v2H9z"/>
                    </svg>
                    <p class="text-sm font-medium text-gray-900">Peserta</p>
                </a>
                <a href="{{ route('organizer.results.index') }}" class="p-4 bg-white rounded-lg hover:shadow-md transition text-center">
                    <svg class="h-6 w-6 mx-auto text-pink-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    <p class="text-sm font-medium text-gray-900">Hasil</p>
                </a>
            </div>
        </div>
    </div>
</div>

@include('components.footer')
@endsection
