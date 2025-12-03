@extends('layouts.participant')

@section('title', 'Preview Sertifikat')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('participant.results.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Preview Sertifikat</h1>
    </div>
</div>

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    {{-- Certificate Display --}}
    <div class="bg-gray-100 p-8 flex items-center justify-center" style="min-height: 600px;">
        @if (isset($sertifikat) && $sertifikat->gambar)
            <div class="w-full max-w-4xl">
                <img src="{{ asset('storage/' . $sertifikat->gambar) }}" alt="Sertifikat" class="w-full h-auto rounded-lg shadow-xl">
            </div>
        @else
            <div class="text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-500">Gambar sertifikat tidak tersedia</p>
            </div>
        @endif
    </div>

    {{-- Certificate Info --}}
    @if (isset($sertifikat))
        <div class="p-8 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="text-xs font-medium text-gray-600 uppercase">Sub Lomba</label>
                    <p class="text-lg font-semibold text-gray-900 mt-1">
                        {{ $sertifikat->sublomba->nama ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-600 uppercase">Event</label>
                    <p class="text-lg font-semibold text-gray-900 mt-1">
                        {{ $sertifikat->sublomba->event->nama ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-600 uppercase">Nama Peserta</label>
                    <p class="text-lg font-semibold text-gray-900 mt-1">
                        {{ $sertifikat->partisipan->user->nama ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-600 uppercase">Institusi</label>
                    <p class="text-lg font-semibold text-gray-900 mt-1">
                        {{ $sertifikat->partisipan->institusi ?? 'N/A' }}
                    </p>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3 pt-6 border-t border-gray-200">
                <a href="{{ route('participant.results.certificates.download', $sertifikat->sertifikat_id) }}" 
                   class="flex-1 px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-center font-medium">
                    <span class="inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download Sertifikat
                    </span>
                </a>
                <a href="{{ route('participant.results.index') }}" 
                   class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-center font-medium">
                    Kembali ke Hasil
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
