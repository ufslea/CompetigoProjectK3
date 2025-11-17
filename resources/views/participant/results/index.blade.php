@extends('layouts.participant')

@section('title', 'Hasil & Sertifikat')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Hasil & Sertifikat</h1>
    <p class="text-gray-600 mt-1">Lihat hasil dan sertifikat dari kompetisi yang Anda ikuti</p>
</div>

{{-- Tabs --}}
<div class="mb-6 border-b border-gray-200">
    <div class="flex gap-8">
        <button class="tab-btn active" data-tab="results" onclick="switchTab(event, 'results')">
            <span class="inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                </svg>
                Hasil Kompetisi
            </span>
        </button>
        <button class="tab-btn" data-tab="certificates" onclick="switchTab(event, 'certificates')">
            <span class="inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H2a2 2 0 00-2 2v14a2 2 0 002 2h14.75a.75.75 0 00.75-.75V7a2 2 0 00-2-2h-2.586a1 1 0 000-2H6a2 2 0 00-2 2v2.718a.75.75 0 001.5 0V5zm10 10a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/>
                </svg>
                Sertifikat
            </span>
        </button>
    </div>
</div>

{{-- Results Tab --}}
<div id="results" class="tab-content">
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

    @if ($hasil->isEmpty())
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada hasil</h3>
            <p class="mt-2 text-sm text-gray-600">Hasil kompetisi akan ditampilkan di sini setelah kompetisi berakhir.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($hasil as $result)
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    {{-- Header dengan Rank --}}
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-white">
                                {{ $result->sublomba->nama ?? 'N/A' }}
                            </h3>
                            @if ($result->rank)
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white text-indigo-600 font-bold">
                                    #{{ $result->rank }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="px-6 py-4">
                        <div class="mb-4">
                            <label class="text-xs font-medium text-gray-600 uppercase">Event</label>
                            <p class="text-sm font-medium text-gray-900 mt-1">
                                {{ $result->sublomba->event->nama ?? 'N/A' }}
                            </p>
                        </div>

                        @if ($result->deskripsi)
                            <div class="mb-4">
                                <label class="text-xs font-medium text-gray-600 uppercase">Deskripsi Hasil</label>
                                <p class="text-sm text-gray-700 mt-1">{{ $result->deskripsi }}</p>
                            </div>
                        @endif

                        <div class="pt-4 border-t border-gray-200">
                            <a href="{{ route('participant.results.show', $result->sublomba->event_id) }}" 
                               class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-medium text-sm">
                                Lihat Detail
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Certificates Tab --}}
<div id="certificates" class="tab-content hidden">
    @php
        $sertifikats = isset($sertifikats) ? $sertifikats : [];
    @endphp

    @if (empty($sertifikats) || count($sertifikats) == 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada sertifikat</h3>
            <p class="mt-2 text-sm text-gray-600">Sertifikat akan ditampilkan di sini jika Anda meraih penghargaan.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($sertifikats as $cert)
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    {{-- Certificate Preview --}}
                    <div class="aspect-video bg-gradient-to-br from-yellow-50 to-yellow-100 flex items-center justify-center p-4">
                        @if ($cert->gambar)
                            <img src="{{ asset('storage/' . $cert->gambar) }}" alt="Sertifikat" class="w-full h-full object-contain">
                        @else
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-xs text-yellow-600 mt-2">Sertifikat</p>
                            </div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="px-6 py-4">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">
                            {{ $cert->sublomba->nama ?? 'N/A' }}
                        </h3>
                        <p class="text-xs text-gray-600 mb-4">
                            {{ $cert->sublomba->event->nama ?? 'N/A' }}
                        </p>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('participant.results.certificates.preview', $cert->sertifikat_id) }}" 
                               class="flex-1 px-3 py-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition text-sm font-medium text-center">
                                Preview
                            </a>
                            <a href="{{ route('participant.results.certificates.download', $cert->sertifikat_id) }}" 
                               class="flex-1 px-3 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium text-center">
                                Download
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .tab-btn {
        @apply pb-3 px-1 text-gray-600 border-b-2 border-transparent hover:text-gray-900 hover:border-gray-300 transition font-medium;
    }
    .tab-btn.active {
        @apply text-indigo-600 border-indigo-600;
    }
    .tab-content {
        @apply block;
    }
    .tab-content.hidden {
        @apply hidden;
    }
</style>

<script>
function switchTab(e, tabName) {
    e.preventDefault();
    
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Deactivate all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById(tabName).classList.remove('hidden');
    
    // Activate clicked button
    e.target.closest('.tab-btn').classList.add('active');
}
</script>
@endsection
