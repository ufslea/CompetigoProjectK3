@extends('layouts.participant')

@section('title', 'Daftar Peserta')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-4">
            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-500 text-white font-bold">1</div>
            <h1 class="text-3xl font-bold text-gray-900">Pendaftaran Peserta</h1>
        </div>
        <p class="text-gray-600 ml-14">Event: <span class="font-semibold">{{ $event->nama }}</span></p>
        <p class="text-gray-600 ml-14">Sub Lomba: <span class="font-semibold">{{ $sublomba->nama }}</span></p>
    </div>

    {{-- Success Alert --}}
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
            <svg class="h-5 w-5 text-green-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                <p class="text-xs text-green-700 mt-1">Silakan lanjut ke step berikutnya untuk submit karya Anda</p>
            </div>
        </div>
    @endif

    {{-- Error Alert --}}
    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
            <svg class="h-5 w-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Main Form --}}
    <div class="bg-white rounded-lg shadow-lg p-8 border border-gray-200">
        
        {{-- Jenis Sub Lomba Info --}}
        <div class="mb-8 p-4 rounded-lg {{ $sublomba->jenis_sublomba === 'berbayar' ? 'bg-orange-50 border border-orange-200' : 'bg-blue-50 border border-blue-200' }}">
            <div class="flex items-start gap-3">
                <svg class="h-6 w-6 {{ $sublomba->jenis_sublomba === 'berbayar' ? 'text-orange-500' : 'text-blue-500' }} mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h3 class="font-semibold {{ $sublomba->jenis_sublomba === 'berbayar' ? 'text-orange-900' : 'text-blue-900' }}">
                        @if ($sublomba->jenis_sublomba === 'berbayar')
                            Lomba Berbayar
                        @else
                            Lomba Gratis
                        @endif
                    </h3>
                    <p class="{{ $sublomba->jenis_sublomba === 'berbayar' ? 'text-orange-700' : 'text-blue-700' }} text-sm mt-1">
                        @if ($sublomba->jenis_sublomba === 'berbayar')
                            Pendaftaran lomba ini memerlukan pembayaran. Anda perlu menyertakan bukti transfer untuk menyelesaikan pendaftaran.
                        @else
                            Pendaftaran lomba ini gratis. Anda perlu menunjukkan bukti follow media sosial resmi untuk menyelesaikan pendaftaran.
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <form action="{{ route('participant.competitions.register.store', [$event->events_id, $sublomba->sublomba_id]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Section 1: Data Peserta --}}
            <div class="mb-8 pb-8 border-b">
                <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 text-sm font-bold">A</span>
                    Data Peserta
                </h2>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Peserta</label>
                    <input type="text" value="{{ Auth::user()->nama }}" disabled
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                    <p class="text-xs text-gray-500 mt-1">Menggunakan nama dari akun Anda</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" value="{{ Auth::user()->email }}" disabled
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50">
                </div>

                <div class="mb-4">
                    <label for="institusi" class="block text-sm font-medium text-gray-700 mb-2">Institusi / Sekolah</label>
                    <input type="text" name="institusi" id="institusi"
                           value="{{ old('institusi', Auth::user()->institusi) }}"
                           placeholder="Contoh: Universitas Indonesia"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('institusi') border-red-500 @enderror"
                           required>
                    @error('institusi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="kontak" class="block text-sm font-medium text-gray-700 mb-2">Nomor Kontak</label>
                    <input type="tel" name="kontak" id="kontak"
                           value="{{ old('kontak') }}"
                           placeholder="Contoh: 081234567890"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kontak') border-red-500 @enderror"
                           required>
                    @error('kontak')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Section 2: Bukti Pendaftaran --}}
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 text-sm font-bold">B</span>
                    @if ($sublomba->jenis_sublomba === 'berbayar')
                        Bukti Pembayaran
                    @else
                        Bukti Follow Media Sosial
                    @endif
                </h2>

                @if ($sublomba->jenis_sublomba === 'berbayar')
                    {{-- Berbayar: Upload bukti transfer --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nominal Pembayaran</label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-500 font-medium">Rp</span>
                            <input type="number" name="nominal_bayar" id="nominal_bayar"
                                   value="{{ old('nominal_bayar') }}"
                                   placeholder="100000"
                                   class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nominal_bayar') border-red-500 @enderror"
                                   required>
                        </div>
                        @error('nominal_bayar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="bukti_transfer" class="block text-sm font-medium text-gray-700 mb-2">
                            Screenshot Bukti Transfer
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 hover:bg-blue-50 transition cursor-pointer" 
                             onclick="document.getElementById('bukti_transfer').click()">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-700">Klik atau drag file gambar</p>
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Maks. 5MB)</p>
                        </div>
                        <input type="file" id="bukti_transfer" name="bukti_transfer" accept="image/*"
                               class="hidden @error('bukti_transfer') border-red-500 @enderror"
                               required>
                        <div id="bukti_transfer_preview" class="mt-2"></div>
                        @error('bukti_transfer')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @else
                    {{-- Gratis: Upload bukti follow sosmed --}}
                    <div class="mb-4">
                        <label for="handle_sosmed" class="block text-sm font-medium text-gray-700 mb-2">
                            Username / Handle Media Sosial
                        </label>
                        <p class="text-xs text-gray-500 mb-2">Masukkan username Anda yang sudah follow akun resmi</p>
                        <input type="text" name="handle_sosmed" id="handle_sosmed"
                               value="{{ old('handle_sosmed') }}"
                               placeholder="Contoh: @username_anda"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('handle_sosmed') border-red-500 @enderror"
                               required>
                        @error('handle_sosmed')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="bukti_follow" class="block text-sm font-medium text-gray-700 mb-2">
                            Screenshot Bukti Follow
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 hover:bg-blue-50 transition cursor-pointer"
                             onclick="document.getElementById('bukti_follow').click()">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-700">Klik atau drag file gambar</p>
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Maks. 5MB)</p>
                        </div>
                        <input type="file" id="bukti_follow" name="bukti_follow" accept="image/*"
                               class="hidden @error('bukti_follow') border-red-500 @enderror"
                               required>
                        <div id="bukti_follow_preview" class="mt-2"></div>
                        @error('bukti_follow')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif
            </div>

            {{-- Form Actions --}}
            <div class="flex justify-between items-center gap-4 pt-6 border-t">
                <a href="{{ route('participant.competitions.show', $event->events_id) }}"
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">
                    Kembali
                </a>

                <button type="submit"
                    class="px-8 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium flex items-center gap-2">
                    <span>Selesaikan Pendaftaran</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    {{-- Info Box --}}
    <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <h3 class="font-semibold text-blue-900 mb-2">Informasi Penting</h3>
        <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
            <li>Setelah menyelesaikan pendaftaran, Anda akan diarahkan untuk upload karya</li>
            <li>Pastikan semua data sudah benar sebelum submit</li>
            <li>Anda dapat mengubah data peserta jika belum submit karya</li>
            <li>Bukti pembayaran/follow akan diverifikasi oleh panitia</li>
        </ul>
    </div>
</div>

{{-- File Preview Scripts --}}
<script>
    // Bukti Transfer Preview (Berbayar)
    @if ($sublomba->jenis_sublomba === 'berbayar')
        document.getElementById('bukti_transfer')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('bukti_transfer_preview');
                    preview.innerHTML = `
                        <div class="relative inline-block mt-2">
                            <img src="${event.target.result}" alt="Preview" class="max-h-48 rounded-lg border border-gray-300">
                            <button type="button" onclick="document.getElementById('bukti_transfer').value=''; this.parentElement.remove();" 
                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </button>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    @endif

    // Bukti Follow Preview (Gratis)
    @if ($sublomba->jenis_sublomba === 'gratis')
        document.getElementById('bukti_follow')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('bukti_follow_preview');
                    preview.innerHTML = `
                        <div class="relative inline-block mt-2">
                            <img src="${event.target.result}" alt="Preview" class="max-h-48 rounded-lg border border-gray-300">
                            <button type="button" onclick="document.getElementById('bukti_follow').value=''; this.parentElement.remove();" 
                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                            </button>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    @endif
</script>
@endsection
