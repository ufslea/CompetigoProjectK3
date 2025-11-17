@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
{{-- Header --}}
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
    <p class="text-gray-600 mt-2">Pantau dan kelola seluruh sistem kompetisi</p>
</div>

{{-- Key Statistics --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    {{-- Total Users Card --}}
    <div class="bg-gradient-to-br from-indigo-600 to-indigo-700 text-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-indigo-200 text-sm font-medium">Total Users</p>
                <p class="text-3xl font-bold mt-2">{{ \App\Models\User::count() }}</p>
            </div>
            <svg class="h-12 w-12 text-indigo-300 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM9 20H4v-2a6 6 0 0112 0v2H9z"/>
            </svg>
        </div>
    </div>

    {{-- Total Events Card --}}
    <div class="bg-gradient-to-br from-purple-600 to-purple-700 text-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-200 text-sm font-medium">Total Events</p>
                <p class="text-3xl font-bold mt-2">{{ \App\Models\Event::count() }}</p>
            </div>
            <svg class="h-12 w-12 text-purple-300 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
    </div>

    {{-- Total Participants Card --}}
    <div class="bg-gradient-to-br from-green-600 to-green-700 text-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-200 text-sm font-medium">Total Participants</p>
                <p class="text-3xl font-bold mt-2">{{ \App\Models\Partisipan::count() }}</p>
            </div>
            <svg class="h-12 w-12 text-green-300 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8.048M7.485 9.75H4.5A2.25 2.25 0 002.25 12v0a2.25 2.25 0 002.25 2.25h2.985m0 0a4 4 0 110-8.048m0 8.048h3.985A2.25 2.25 0 0019.5 12v0a2.25 2.25 0 00-2.25-2.25h-2.985m0-8.048v.005"/>
            </svg>
        </div>
    </div>

    {{-- Pending Reports Card --}}
    <div class="bg-gradient-to-br from-orange-600 to-orange-700 text-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-200 text-sm font-medium">Pending Reports</p>
                <p class="text-3xl font-bold mt-2">{{ \App\Models\Laporan::where('status', 'pending')->count() }}</p>
            </div>
            <svg class="h-12 w-12 text-orange-300 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
    </div>
</div>

{{-- Recent Data Section --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Recent Events --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Recent Events</h2>
            <a href="{{ route('admin.events.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View All</a>
        </div>

        @if(\App\Models\Event::count() > 0)
            <div class="divide-y divide-gray-100">
                @forelse(\App\Models\Event::with('organizer')->latest()->take(5)->get() as $event)
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $event->nama }}</h3>
                                <p class="text-sm text-gray-600 mt-1">Organizer: {{ $event->organizer->nama ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500 mt-2">{{ $event->tanggal_mulai?->format('d M Y') }} - {{ $event->tanggal_akhir?->format('d M Y') }}</p>
                            </div>
                            <a href="{{ route('admin.events.show', $event->events_id) }}" class="ml-4 px-3 py-1 text-sm bg-indigo-100 text-indigo-600 rounded hover:bg-indigo-200 transition whitespace-nowrap">
                                View
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No events yet</p>
                @endforelse
            </div>
        @else
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-500 mt-3 text-sm">No events yet</p>
            </div>
        @endif
    </div>

    {{-- Recent Reports --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Recent Reports</h2>
            <a href="{{ route('admin.reports.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View All</a>
        </div>

        @if(\App\Models\Laporan::count() > 0)
            <div class="divide-y divide-gray-100">
                @forelse(\App\Models\Laporan::with('pelapor', 'event')->latest()->take(5)->get() as $laporan)
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $laporan->judul }}</h3>
                                <p class="text-sm text-gray-600 mt-1">From: {{ $laporan->pelapor->nama ?? 'N/A' }}</p>
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="text-xs px-2 py-1 rounded-full 
                                        {{ $laporan->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($laporan->status == 'processed' ? 'bg-blue-100 text-blue-800' : 
                                           ($laporan->status == 'finished' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                        {{ ucfirst($laporan->status) }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $laporan->created_at?->format('d M Y') }}</span>
                                </div>
                            </div>
                            <a href="{{ route('admin.reports.show', $laporan->laporan_id) }}" class="ml-4 px-3 py-1 text-sm bg-indigo-100 text-indigo-600 rounded hover:bg-indigo-200 transition whitespace-nowrap">
                                View
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No reports yet</p>
                @endforelse
            </div>
        @else
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-500 mt-3 text-sm">No reports yet</p>
            </div>
        @endif
    </div>
</div>

{{-- Quick Stats --}}
<div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-6 border border-indigo-100">
    <h3 class="font-semibold text-gray-900 mb-4">Quick Stats</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="p-4 bg-white rounded-lg">
            <p class="text-sm text-gray-600">Organizers</p>
            <p class="text-2xl font-bold text-indigo-600 mt-2">{{ \App\Models\User::where('role', 'organizer')->count() }}</p>
        </div>
        <div class="p-4 bg-white rounded-lg">
            <p class="text-sm text-gray-600">Participants</p>
            <p class="text-2xl font-bold text-purple-600 mt-2">{{ \App\Models\User::where('role', 'participant')->count() }}</p>
        </div>
        <div class="p-4 bg-white rounded-lg">
            <p class="text-sm text-gray-600">Total Sub Lombas</p>
            <p class="text-2xl font-bold text-green-600 mt-2">{{ \App\Models\SubLomba::count() }}</p>
        </div>
        <div class="p-4 bg-white rounded-lg">
            <p class="text-sm text-gray-600">Total Results</p>
            <p class="text-2xl font-bold text-orange-600 mt-2">{{ \App\Models\Hasil::count() }}</p>
        </div>
    </div>
</div>
@endsection

