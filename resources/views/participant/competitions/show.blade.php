@extends('layouts.participant')

@section('title', $event->nama)

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    {{-- Success Alert --}}
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
            <svg class="h-5 w-5 text-green-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Event Header --}}
    <div class="mb-8">
        @if ($event->gambar)
            <img src="{{ asset('storage/' . $event->gambar) }}" alt="{{ $event->nama }}" 
                 class="w-full h-64 object-cover rounded-lg mb-4">
        @else
            <div class="w-full h-64 bg-gray-200 rounded-lg mb-4 flex items-center justify-center">
                <span class="text-gray-500">No Image</span>
            </div>
        @endif

        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $event->nama }}</h1>
        <p class="text-gray-600 mb-4">{{ $event->deskripsi }}</p>

        <div class="flex flex-wrap gap-3 mb-4">
            <div class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg text-sm font-medium">
                📅 {{ $event->tanggal_mulai?->format('d M Y') }} - {{ $event->tanggal_akhir?->format('d M Y') }}
            </div>
            <a href="{{ $event->url }}" target="_blank" rel="noopener noreferrer"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                🔗 Kunjungi Website Event
            </a>
        </div>
    </div>

    {{-- Sub Lomba List --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Daftar Kategori Lomba</h2>

        @if ($event->subLombas->isEmpty())
            <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
                <p class="text-gray-500">Belum ada kategori lomba untuk event ini</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($event->subLombas as $sublomba)
                    @php
                        // Check apakah user sudah register untuk sublomba ini
                        $partisipan = \App\Models\Partisipan::where('user_id', Auth::id())
                            ->where('sublomba_id', $sublomba->sublomba_id)
                            ->first();
                        
                        $userRegistered = $partisipan ? true : false;
                        $userSubmitted = $partisipan && $partisipan->status === 'submitted' ? true : false;
                        $verificationStatus = $partisipan?->verification_status;
                        $isVerified = $verificationStatus === 'approved';
                    @endphp

                    <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden hover:shadow-lg transition">
                        {{-- Header dengan tipe --}}
                        <div class="p-4 {{ $sublomba->jenis_sublomba === 'berbayar' ? 'bg-orange-50 border-b-2 border-orange-200' : 'bg-blue-50 border-b-2 border-blue-200' }}">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold text-gray-900">{{ $sublomba->nama }}</h3>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $sublomba->jenis_sublomba === 'berbayar' ? 'bg-orange-200 text-orange-800' : 'bg-blue-200 text-blue-800' }}">
                                    {{ $sublomba->jenis_sublomba === 'berbayar' ? '💳 Berbayar' : '🆓 Gratis' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-700">Kategori: <span class="font-semibold">{{ $sublomba->kategori }}</span></p>
                        </div>

                        {{-- Body --}}
                        <div class="p-4">
                            <p class="text-gray-600 text-sm mb-3">{{ \Str::limit($sublomba->deskripsi, 100) }}</p>

                            <div class="mb-4 p-3 bg-gray-50 rounded text-sm text-gray-700 space-y-1">
                                <div><strong>Deadline:</strong> {{ $sublomba->deadline ? \Carbon\Carbon::parse($sublomba->deadline)->format('d M Y H:i') : '-' }}</div>
                                <div><strong>Tipe Submission:</strong> <span class="font-semibold">{{ $sublomba->requires_submission ? '📁 Wajib Submit Karya' : '✓ Hanya Registrasi' }}</span></div>
                                <div><strong>Status:</strong> <span class="font-semibold {{ $sublomba->status === 'open' ? 'text-green-600' : 'text-red-600' }}">{{ ucfirst($sublomba->status) }}</span></div>
                            </div>

                            {{-- Status Badge & Verification --}}
                            @if ($userSubmitted)
                                <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded text-sm text-green-800 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>✓ Karya sudah disubmit</span>
                                </div>
                            @elseif ($userRegistered)
                                @if($isVerified)
                                    @if($sublomba->requires_submission)
                                        <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded text-sm text-blue-800 flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>✓ Terverifikasi - Siap submit karya</span>
                                        </div>
                                    @else
                                        <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded text-sm text-green-800 flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>✓ Terverifikasi - Selesai</span>
                                        </div>
                                    @endif
                                @else
                                    <div class="mb-3 p-3 {{ $verificationStatus === 'rejected' ? 'bg-red-50 border border-red-200' : 'bg-yellow-50 border border-yellow-200' }} rounded text-sm {{ $verificationStatus === 'rejected' ? 'text-red-800' : 'text-yellow-800' }} flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ $verificationStatus === 'rejected' ? '✗ Ditolak - Hubungi organizer' : '⏳ Menunggu verifikasi' }}</span>
                                    </div>
                                @endif
                            @endif

                            {{-- Action Buttons --}}
                            <div class="flex gap-2">
                                @if ($userSubmitted)
                                    <button disabled class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg font-medium cursor-not-allowed text-sm">
                                        ✓ Sudah Disubmit
                                    </button>
                                @elseif ($userRegistered)
                                    @if($sublomba->requires_submission)
                                        @if($isVerified)
                                            <a href="{{ route('participant.competitions.create', $event->events_id) }}"
                                               class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium text-sm text-center transition">
                                                📤 Submit Karya
                                            </a>
                                        @else
                                            <button disabled class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg font-medium cursor-not-allowed text-sm">
                                                ⏳ Menunggu Verifikasi
                                            </button>
                                        @endif
                                    @else
                                        <button disabled class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg font-medium cursor-not-allowed text-sm">
                                            ✓ Selesai
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('participant.competitions.register', [$event->events_id, $sublomba->sublomba_id]) }}"
                                       class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium text-sm text-center transition">
                                        📝 Daftar
                                    </a>
                                @endif

                                <a href="{{ $sublomba->link }}" target="_blank" rel="noopener noreferrer" 
                                   class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium text-sm text-center transition">
                                    ℹ️ Info
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Additional Info --}}
    <div class="mt-12 p-6 bg-blue-50 border border-blue-200 rounded-lg">
        <h3 class="font-bold text-blue-900 mb-3">Panduan Pendaftaran</h3>
        <ol class="text-sm text-blue-800 space-y-2 list-decimal list-inside">
            <li><strong>Step 1:</strong> Klik tombol "Daftar" pada kategori lomba yang ingin diikuti</li>
            <li><strong>Step 2:</strong> Isi form pendaftaran dan upload bukti pembayaran/follow sosmed</li>
            <li><strong>Step 3:</strong> Setelah pendaftaran diterima, upload karya Anda melalui tombol "Submit Karya"</li>
            <li><strong>Step 4:</strong> Tunggu hasil dari panitia</li>
        </ol>
    </div>
</div>

@endsection

