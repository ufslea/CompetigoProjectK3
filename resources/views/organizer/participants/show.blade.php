@extends('layouts.organizer')

@section('content')
<div class="flex">
    @include('components.sidebar-organizer')

    <div class="flex-1 px-8 py-6">
        @include('components.navbar')

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Detail Peserta</h1>
            <p class="text-gray-600 mt-2">Informasi lengkap peserta dan data submisinya</p>
        </div>

        {{-- Participant Card --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8 mb-6">
            <div class="grid grid-cols-2 gap-6 mb-8">
                {{-- Left Column --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Informasi Peserta</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Nama Peserta</p>
                            <p class="text-gray-900 font-semibold mt-1">{{ $partisipan->user->nama ?? '-' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Email</p>
                            <p class="text-gray-900 mt-1">{{ $partisipan->user->email ?? '-' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Institusi</p>
                            <p class="text-gray-900 mt-1">{{ $partisipan->institusi ?? '-' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Kontak</p>
                            <p class="text-gray-900 mt-1">{{ $partisipan->kontak ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Informasi Submisi</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Sub Lomba</p>
                            <p class="text-gray-900 font-semibold mt-1">{{ $partisipan->sublomba->nama ?? '-' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Event</p>
                            <p class="text-gray-900 font-semibold mt-1">{{ $partisipan->sublomba->event->nama ?? '-' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Status</p>
                            <div class="mt-1">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $partisipan->status == 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($partisipan->status == 'rejected' ? 'bg-red-100 text-red-800' : 
                                       ($partisipan->status == 'submitted' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                    {{ ucfirst($partisipan->status) }}
                                </span>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Tanggal Daftar</p>
                            <p class="text-gray-900 mt-1">{{ $partisipan->registered_at?->format('d M Y H:i') ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- File Karya Section --}}
            @if($partisipan->file_karya)
                <div class="border-t pt-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">File Karya</h2>
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <div>
                            <p class="text-sm text-gray-600">File Karya</p>
                            <a href="{{ $partisipan->file_karya }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                Lihat File Karya
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Back Button --}}
        <div class="flex gap-3">
            <a href="{{ route('organizer.participants.index') }}" 
               class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition font-medium">
                ← Kembali
            </a>
        </div>
    </div>
</div>

@include('components.footer')
@endsection
