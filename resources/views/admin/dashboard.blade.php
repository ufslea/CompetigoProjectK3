@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl p-6 shadow-md hover:scale-[1.02] transition-all">
        <h3 class="font-semibold text-lg mb-2">Total Users</h3>
        <p class="text-3xl font-bold">{{ \App\Models\User::count() }}</p>
    </div>
    <div class="bg-gradient-to-r from-pink-500 to-purple-500 text-white rounded-xl p-6 shadow-md hover:scale-[1.02] transition-all">
        <h3 class="font-semibold text-lg mb-2">Total Events</h3>
        <p class="text-3xl font-bold">{{ \App\Models\Event::count() }}</p>
    </div>
    <div class="bg-gradient-to-r from-green-500 to-teal-500 text-white rounded-xl p-6 shadow-md hover:scale-[1.02] transition-all">
        <h3 class="font-semibold text-lg mb-2">Total Participants</h3>
        <p class="text-3xl font-bold">{{ \App\Models\Partisipan::count() }}</p>
    </div>
    <div class="bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl p-6 shadow-md hover:scale-[1.02] transition-all">
        <h3 class="font-semibold text-lg mb-2">Pending Reports</h3>
        <p class="text-3xl font-bold">{{ \App\Models\Laporan::where('status', 'pending')->count() }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Events</h2>
        <div class="space-y-3">
            @forelse(\App\Models\Event::latest()->take(5)->get() as $event)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">{{ $event->nama }}</p>
                        <p class="text-sm text-gray-500">{{ $event->organizer->nama ?? 'N/A' }}</p>
                    </div>
                    <a href="{{ route('admin.events.show', $event->events_id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">View</a>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No events yet</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Reports</h2>
        <div class="space-y-3">
            @forelse(\App\Models\Laporan::with('pelapor', 'event')->latest()->take(5)->get() as $laporan)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">{{ $laporan->judul }}</p>
                        <p class="text-sm text-gray-500">{{ $laporan->pelapor->nama ?? 'N/A' }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $laporan->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($laporan->status == 'processed' ? 'bg-blue-100 text-blue-800' : 
                           ($laporan->status == 'finished' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                        {{ ucfirst($laporan->status) }}
                    </span>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No reports yet</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

