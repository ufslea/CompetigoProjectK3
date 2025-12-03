@extends('layouts.organizer')

@section('content')
<div class="flex">
    @include('components.sidebar-organizer')

    <div class="flex-1 px-8 py-6">
        @include('components.navbar')

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Detail Peserta & Verifikasi</h1>
            <p class="text-gray-600 mt-2">Verifikasi bukti pembayaran/follow dan approval untuk submit karya</p>
        </div>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                <svg class="h-5 w-5 text-green-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Peserta Information Card --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8 mb-6">
            <div class="grid grid-cols-2 gap-8 mb-8">
                {{-- Left Column: Peserta Info --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">📋 Informasi Peserta</h2>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Nama Peserta</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $partisipan->user->nama ?? '-' }}</p>
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

                {{-- Right Column: Registration Info --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">📝 Informasi Pendaftaran</h2>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Event</p>
                            <p class="text-lg font-semibold text-gray-900 mt-1">{{ $partisipan->sublomba->event->nama ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Sub Lomba</p>
                            <p class="text-gray-900 mt-1">
                                <span class="font-semibold">{{ $partisipan->sublomba->nama ?? '-' }}</span>
                                <span class="ml-2 text-xs px-2 py-1 rounded-full {{ $partisipan->sublomba->jenis_sublomba === 'berbayar' ? 'bg-orange-100 text-orange-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $partisipan->sublomba->jenis_sublomba === 'berbayar' ? '💳 Berbayar' : '🆓 Gratis' }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Tanggal Daftar</p>
                            <p class="text-gray-900 mt-1">{{ $partisipan->registered_at?->format('d M Y H:i') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Status Submission</p>
                            <div class="mt-1">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $partisipan->status === 'submitted' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $partisipan->status === 'submitted' ? '📤 Submitted' : '⏳ Pending' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-8">

            {{-- Verification Status Section --}}
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">✅ Status Verifikasi</h2>
                
                <div class="p-4 rounded-lg mb-4 {{ $partisipan->verification_status === 'approved' ? 'bg-green-50 border border-green-200' : ($partisipan->verification_status === 'rejected' ? 'bg-red-50 border border-red-200' : 'bg-yellow-50 border border-yellow-200') }}">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Status Verifikasi Saat Ini</p>
                            <div class="mt-2">
                                <span class="px-4 py-2 rounded-full font-semibold text-sm
                                    {{ $partisipan->verification_status === 'approved' ? 'bg-green-200 text-green-800' : ($partisipan->verification_status === 'rejected' ? 'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800') }}">
                                    {{ $partisipan->verification_status === 'approved' ? '✓ APPROVED' : ($partisipan->verification_status === 'rejected' ? '✗ REJECTED' : '⏳ PENDING') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    @if($partisipan->verified_at)
                        <div class="mt-4 text-sm text-gray-600">
                            <p><strong>Diverifikasi oleh:</strong> {{ $partisipan->verifiedBy?->nama ?? 'System' }}</p>
                            <p><strong>Waktu Verifikasi:</strong> {{ $partisipan->verified_at->format('d M Y H:i') }}</p>
                            @if($partisipan->verification_notes)
                                <p class="mt-2"><strong>Catatan:</strong></p>
                                <p class="text-gray-700 italic">{{ $partisipan->verification_notes }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- Bukti File Section --}}
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">🔍 Bukti {{ $partisipan->sublomba->jenis_sublomba === 'berbayar' ? 'Pembayaran' : 'Follow Sosmed' }}</h2>
                
                @if($partisipan->file_karya)
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center gap-4">
                            @if(str_ends_with($partisipan->file_karya, '.pdf'))
                                <svg class="w-12 h-12 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 2.586L15.414 5A2 2 0 0116 6.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                                </svg>
                            @else
                                <svg class="w-12 h-12 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.3A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"/>
                                </svg>
                            @endif
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ basename($partisipan->file_karya) }}</p>
                                <p class="text-sm text-gray-600 mt-1">Bukti {{ $partisipan->sublomba->jenis_sublomba === 'berbayar' ? 'pembayaran (screenshot transfer)' : 'follow sosmed (screenshot)' }}</p>
                            </div>
                            <a href="{{ asset('storage/' . $partisipan->file_karya) }}" target="_blank" 
                               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                👁️ Lihat
                            </a>
                        </div>
                    </div>
                @else
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 text-center">
                        <p class="text-gray-600">Belum ada file bukti yang diupload</p>
                    </div>
                @endif
            </div>

            {{-- Submission Details (if submitted and requires submission) --}}
            @if($partisipan->status === 'submitted' && $partisipan->sublomba->requires_submission)
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">📁 Karya Submission</h2>
                    
                    @if($partisipan->deskripsi_karya)
                        {{-- Check if it's a link or file --}}
                        @if(str_contains($partisipan->deskripsi_karya, 'http://') || str_contains($partisipan->deskripsi_karya, 'https://'))
                            {{-- Link Submission --}}
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex items-center gap-4">
                                    <svg class="w-12 h-12 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">Link Submission</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $partisipan->deskripsi_karya }}</p>
                                    </div>
                                    <a href="{{ $partisipan->deskripsi_karya }}" target="_blank" rel="noopener noreferrer"
                                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                        🔗 Buka
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endif

                    @if($partisipan->file_karya)
                        {{-- File Submission (Image or Document) --}}
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 {{ $partisipan->deskripsi_karya ? 'mt-3' : '' }}">
                            <div class="flex items-center gap-4">
                                @if(str_ends_with(strtolower($partisipan->file_karya), '.jpg') || str_ends_with(strtolower($partisipan->file_karya), '.jpeg') || str_ends_with(strtolower($partisipan->file_karya), '.png') || str_ends_with(strtolower($partisipan->file_karya), '.gif') || str_ends_with(strtolower($partisipan->file_karya), '.webp'))
                                    {{-- Image File --}}
                                    <svg class="w-12 h-12 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                    </svg>
                                @elseif(str_ends_with(strtolower($partisipan->file_karya), '.pdf'))
                                    {{-- PDF File --}}
                                    <svg class="w-12 h-12 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 2.586L15.414 5A2 2 0 0116 6.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                                    </svg>
                                @else
                                    {{-- Other Files --}}
                                    <svg class="w-12 h-12 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 2.586L15.414 5A2 2 0 0116 6.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                                    </svg>
                                @endif
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ basename($partisipan->file_karya) }}</p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        @if(str_ends_with(strtolower($partisipan->file_karya), '.jpg') || str_ends_with(strtolower($partisipan->file_karya), '.jpeg') || str_ends_with(strtolower($partisipan->file_karya), '.png') || str_ends_with(strtolower($partisipan->file_karya), '.gif') || str_ends_with(strtolower($partisipan->file_karya), '.webp'))
                                            File gambar submission
                                        @elseif(str_ends_with(strtolower($partisipan->file_karya), '.pdf'))
                                            File PDF submission
                                        @else
                                            File submission
                                        @endif
                                    </p>
                                </div>
                                <a href="{{ asset('storage/' . $partisipan->file_karya) }}" target="_blank" rel="noopener noreferrer"
                                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                    👁️ Lihat
                                </a>
                            </div>

                            {{-- Display Image Preview if it's an image --}}
                            @if(str_ends_with(strtolower($partisipan->file_karya), '.jpg') || str_ends_with(strtolower($partisipan->file_karya), '.jpeg') || str_ends_with(strtolower($partisipan->file_karya), '.png') || str_ends_with(strtolower($partisipan->file_karya), '.gif') || str_ends_with(strtolower($partisipan->file_karya), '.webp'))
                                <div class="mt-4">
                                    <img src="{{ asset('storage/' . $partisipan->file_karya) }}" alt="Karya Submission" 
                                         class="max-w-md h-auto rounded-lg border border-gray-300">
                                </div>
                            @endif
                        </div>
                    @endif

                    @if(!$partisipan->deskripsi_karya && !$partisipan->file_karya)
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 text-center">
                            <p class="text-gray-600">Belum ada karya yang disubmit</p>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Verification Action Form --}}
            @if($partisipan->verification_status === 'pending')
                <div class="border-t pt-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">⚙️ Aksi Verifikasi</h2>
                    
                    <div class="grid grid-cols-2 gap-6">
                        {{-- Approve Form --}}
                        <form action="{{ route('organizer.participants.verify', $partisipan->partisipan_id) }}" method="POST" class="p-6 border-2 border-green-200 bg-green-50 rounded-lg">
                            @csrf
                            <h3 class="text-lg font-semibold text-green-900 mb-4">✓ Approve Peserta</h3>
                            
                            <div class="mb-4">
                                <label for="verify_notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                <textarea name="verification_notes" id="verify_notes" rows="3"
                                          placeholder="Contoh: Bukti pembayaran sudah terverifikasi / Handle sosmed sudah confirm"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                            </div>

                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Approve Pendaftaran</span>
                            </button>
                        </form>

                        {{-- Reject Form --}}
                        <form action="{{ route('organizer.participants.reject', $partisipan->partisipan_id) }}" method="POST" class="p-6 border-2 border-red-200 bg-red-50 rounded-lg">
                            @csrf
                            <h3 class="text-lg font-semibold text-red-900 mb-4">✗ Tolak Peserta</h3>
                            
                            <div class="mb-4">
                                <label for="reject_notes" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan *</label>
                                <textarea name="verification_notes" id="reject_notes" rows="3"
                                          placeholder="Contoh: Bukti pembayaran tidak sesuai / Handle sosmed tidak valid"
                                          class="w-full px-3 py-2 border border-red-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent @error('verification_notes') border-red-500 @enderror"
                                          required></textarea>
                                @error('verification_notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <span>Tolak Pendaftaran</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        {{-- Info Box --}}
        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg mb-6">
            <p class="text-sm text-blue-900">
                <strong>Catatan:</strong> 
                <br>• Verifikasi bukti pembayaran/follow sosmed sebelum peserta dapat submit karya
                <br>• Gunakan catatan verifikasi untuk memberikan feedback kepada peserta
                <br>• Status verifikasi akan mempengaruhi apakah peserta bisa lanjut ke tahap submission
            </p>
        </div>

        {{-- Back Button --}}
        <div class="flex gap-3">
            <a href="{{ route('organizer.participants.index') }}" 
               class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition font-medium">
                ← Kembali ke Daftar Peserta
            </a>
        </div>
    </div>
</div>

@include('components.footer')
@endsection
