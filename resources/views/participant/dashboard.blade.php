@extends('layouts.participant')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-900">Selamat datang, {{ auth()->user()->nama }}! 👋</h1>
    <p class="text-gray-600 mt-2">Kelola partisipasi Anda dalam kompetisi di sini</p>
</div>

{{-- Success Alert --}}
@if (session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm font-medium text-green-800">{{ session('success') }}</span>
        </div>
    </div>
@endif

{{-- Statistics Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    {{-- Total Competitions --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Kompetisi</p>
                <p class="text-3xl font-bold text-gray-900">
                    @php
                        $totalCompetitions = auth()->user()->partisipans()->distinct('sublomba_id')->get()->count();
                    @endphp
                    {{ $totalCompetitions }}
                </p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Pending Reports --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Laporan Pending</p>
                <p class="text-3xl font-bold text-gray-900">
                    @php
                        $pendingReports = auth()->user()->laporans()
                            ->where('status', 'pending')
                            ->count();
                    @endphp
                    {{ $pendingReports ?? 0 }}
                </p>
            </div>
            <div class="p-3 bg-yellow-100 rounded-full">
                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- New Notifications --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Notifikasi Baru</p>
                <p class="text-3xl font-bold text-gray-900">
                    @php
                        $newNotifications = \App\Models\Notifikasi::where('user_id', auth()->user()->user_id)
                            ->where('is_read', false)
                            ->count();
                    @endphp
                    {{ $newNotifications }}
                </p>
            </div>
            <div class="p-3 bg-red-100 rounded-full">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0018 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Certificates --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Sertifikat</p>
                <p class="text-3xl font-bold text-gray-900">
                    @php
                        $certificates = \App\Models\Sertifikat::whereIn(
                            'partisipan_id',
                            auth()->user()->partisipans()->pluck('partisipan_id')
                        )->count();
                    @endphp
                    {{ $certificates }}
                </p>
            </div>
            <div class="p-3 bg-green-100 rounded-full">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Quick Actions --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Akses Cepat</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                <a href="{{ route('participant.competitions.index') }}" 
                   class="p-4 bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:shadow-md transition">
                    <svg class="h-6 w-6 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <p class="text-sm font-medium text-blue-900">Kompetisi</p>
                </a>

                <a href="{{ route('participant.results.index') }}" 
                   class="p-4 bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg hover:shadow-md transition">
                    <svg class="h-6 w-6 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <p class="text-sm font-medium text-green-900">Hasil & Sertifikat</p>
                </a>

                <a href="{{ route('participant.reports.index') }}" 
                   class="p-4 bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg hover:shadow-md transition">
                    <svg class="h-6 w-6 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-sm font-medium text-purple-900">Laporan</p>
                </a>

                <a href="{{ route('participant.notifications.index') }}" 
                   class="p-4 bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-lg hover:shadow-md transition">
                    <svg class="h-6 w-6 text-red-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0018 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <p class="text-sm font-medium text-red-900">Notifikasi</p>
                </a>

                <a href="{{ route('participant.favorites') }}" 
                   class="p-4 bg-gradient-to-br from-pink-50 to-pink-100 border border-pink-200 rounded-lg hover:shadow-md transition">
                    <svg class="h-6 w-6 text-pink-600 mb-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.172 15.172a4 4 0 005.656 0m0-5.656a4 4 0 00-5.656 0m0 0a4 4 0 005.656 5.656m0 0l2.828 2.828m-9.656-9.656a4 4 0 00-5.656 0m0 5.656a4 4 0 005.656 0"/>
                    </svg>
                    <p class="text-sm font-medium text-pink-900">Favorit</p>
                </a>

                <a href="{{ route('profile.show') }}" 
                   class="p-4 bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 rounded-lg hover:shadow-md transition">
                    <svg class="h-6 w-6 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <p class="text-sm font-medium text-gray-900">Profil</p>
                </a>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h2>
            
            @php
                $recentActivities = collect();
                
                // Get recent partisipans
                $partisipans = auth()->user()->partisipans()
                    ->with('sublomba', 'sublomba.event')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
                    
                foreach ($partisipans as $partisipan) {
                    $recentActivities->push([
                        'type' => 'participation',
                        'title' => 'Mendaftar kompetisi: ' . ($partisipan->sublomba?->event?->nama ?? 'N/A'),
                        'time' => $partisipan->created_at,
                        'icon' => 'blue',
                    ]);
                }
                
                // Get recent reports
                $reports = auth()->user()->laporans()
                    ->with('event')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
                    
                foreach ($reports as $report) {
                    $recentActivities->push([
                        'type' => 'report',
                        'title' => 'Melaporkan: ' . $report->judul,
                        'time' => $report->created_at,
                        'icon' => 'purple',
                    ]);
                }
                
                // Sort by time
                $recentActivities = $recentActivities->sortByDesc('time')->take(10);
            @endphp

            @if ($recentActivities->isEmpty())
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <p class="mt-4 text-sm text-gray-600">Belum ada aktivitas</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($recentActivities as $activity)
                        <div class="flex items-start gap-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="p-2 rounded-full @if($activity['icon'] === 'blue') bg-blue-100 @elseif($activity['icon'] === 'purple') bg-purple-100 @endif">
                                @if($activity['type'] === 'participation')
                                    <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                @else
                                    <svg class="h-4 w-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $activity['title'] }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $activity['time']?->diffForHumans() ?? '-' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Sidebar Info --}}
    <div class="space-y-6">
        {{-- Profile Card --}}
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg shadow-sm text-white p-6">
            <div class="text-center">
                <div class="h-16 w-16 bg-white/20 rounded-full mx-auto flex items-center justify-center text-white text-2xl font-bold mb-4">
                    {{ substr(auth()->user()->nama, 0, 1) }}
                </div>
                <h3 class="text-lg font-semibold">{{ auth()->user()->nama }}</h3>
                <p class="text-sm text-white/80 mt-1">{{ auth()->user()->email }}</p>
                <div class="mt-4">
                    <span class="px-3 py-1 bg-white/20 text-white text-xs font-semibold rounded-full">
                        Peserta
                    </span>
                </div>
                <a href="{{ route('profile.edit') }}" class="mt-4 inline-block px-4 py-2 bg-white text-indigo-600 rounded-lg font-medium hover:bg-gray-100 transition text-sm">
                    Edit Profil
                </a>
            </div>
        </div>

        {{-- Upcoming Events --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Event Mendatang</h3>
            
            @php
                $upcomingEvents = \App\Models\Event::where('tanggal_mulai', '>=', now())
                    ->orderBy('tanggal_mulai', 'asc')
                    ->take(3)
                    ->get();
            @endphp

            @if ($upcomingEvents->isEmpty())
                <p class="text-sm text-gray-600 text-center py-4">Tidak ada event mendatang</p>
            @else
                <div class="space-y-3">
                    @foreach ($upcomingEvents as $event)
                        <div class="p-3 border border-gray-200 rounded-lg hover:border-indigo-300 transition">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $event->nama }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $event->tanggal_mulai?->format('d M Y') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Tips & Resources --}}
        <div class="bg-blue-50 rounded-lg border border-blue-200 p-6">
            <h3 class="text-sm font-semibold text-blue-900 mb-3">💡 Tips</h3>
            <ul class="space-y-2 text-xs text-blue-800">
                <li class="flex gap-2">
                    <span>✓</span>
                    <span>Pantau notifikasi untuk update terbaru</span>
                </li>
                <li class="flex gap-2">
                    <span>✓</span>
                    <span>Simpan event favorit untuk akses cepat</span>
                </li>
                <li class="flex gap-2">
                    <span>✓</span>
                    <span>Buat laporan jika ada masalah</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
