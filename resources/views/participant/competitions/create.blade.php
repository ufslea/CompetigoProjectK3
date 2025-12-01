@extends('layouts.participant')

@section('title', 'Submit Karya')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    {{-- Header dengan Step Indicator --}}
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-4">
            {{-- Step 1 --}}
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-500 text-white font-bold text-sm">
                    ✓
                </div>
                <div class="hidden sm:block ml-3">
                    <p class="text-xs text-gray-500 font-medium">STEP 1</p>
                    <p class="text-sm font-semibold text-gray-700">Pendaftaran</p>
                </div>
            </div>

            {{-- Arrow --}}
            <div class="flex-1 h-0.5 bg-green-500 hidden sm:block"></div>

            {{-- Step 2 --}}
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-500 text-white font-bold text-sm">
                    2
                </div>
                <div class="hidden sm:block ml-3">
                    <p class="text-xs text-gray-500 font-medium">STEP 2</p>
                    <p class="text-sm font-semibold text-gray-700">Submit Karya</p>
                </div>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-gray-900">Submit Karya Anda</h1>
        <p class="text-gray-600 mt-2">Event: <span class="font-semibold">{{ $event->nama }}</span></p>
    </div>

    {{-- Success Alert --}}
    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
            <svg class="h-5 w-5 text-green-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
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
        <form action="{{ route('participant.competitions.store', $event->events_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- Hidden input untuk track step 2 submission --}}
            <input type="hidden" name="is_submission" value="1">

            {{-- Sub Lomba Selection --}}
            <div class="mb-8 pb-8 border-b">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-600 text-xs font-bold">A</span>
                    Pilih Sub Lomba
                </h2>
                
                <div class="mb-4">
                    <label for="sublomba_id" class="block text-sm font-medium text-gray-700 mb-2">Sub Lomba</label>
                    <select name="sublomba_id" id="sublomba_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sublomba_id') border-red-500 @enderror"
                            required>
                        <option value="">-- Pilih Sub Lomba --</option>
                        @foreach($sublomba as $sub)
                            <option value="{{ $sub->sublomba_id }}" {{ old('sublomba_id') == $sub->sublomba_id ? 'selected' : '' }}>
                                {{ $sub->nama }} 
                                <span class="text-gray-500">({{ $sub->jenis_sublomba === 'berbayar' ? 'Berbayar' : 'Gratis' }})</span>
                            </option>
                        @endforeach
                    </select>
                    @error('sublomba_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <p class="text-xs text-gray-500 bg-gray-50 p-3 rounded">
                    ℹ️ Pastikan Anda sudah menyelesaikan Step 1 (Pendaftaran) untuk sub lomba yang dipilih sebelum submit karya
                </p>
            </div>

            {{-- Submission Details --}}
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 text-blue-600 text-xs font-bold">B</span>
                    Detail Karya
                </h2>

                {{-- File Karya / Link --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Karya Anda</label>
                    
                    <div class="mb-3 flex gap-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="karya_type" value="file" 
                                   {{ old('karya_type') !== 'link' ? 'checked' : '' }}
                                   class="w-4 h-4">
                            <span class="text-sm text-gray-700">Upload File</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="karya_type" value="link"
                                   {{ old('karya_type') === 'link' ? 'checked' : '' }}
                                   class="w-4 h-4">
                            <span class="text-sm text-gray-700">Link URL</span>
                        </label>
                    </div>

                    {{-- File Upload --}}
                    <div id="file_karya_section" class="mb-4 {{ old('karya_type') === 'link' ? 'hidden' : '' }}">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 hover:bg-blue-50 transition cursor-pointer"
                             onclick="document.getElementById('file_karya').click()">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="text-sm font-medium text-gray-700">Klik atau drag file karya</p>
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG, ZIP (Maks. 50MB)</p>
                        </div>
                        <input type="file" id="file_karya" name="file_karya" accept=".pdf,.jpg,.jpeg,.png,.zip"
                               class="hidden @error('file_karya') border-red-500 @enderror">
                        <div id="file_karya_preview" class="mt-2"></div>
                        @error('file_karya')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- URL Input --}}
                    <div id="link_karya_section" class="{{ old('karya_type') === 'link' ? '' : 'hidden' }}">
                        <input type="url" name="file_karya" id="link_karya"
                               value="{{ old('file_karya') }}"
                               placeholder="https://example.com/karya.pdf"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('file_karya') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-2">Contoh: Google Drive link, Dropbox, atau platform hosting lainnya</p>
                        @error('file_karya')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi Karya --}}
                <div class="mb-4">
                    <label for="deskripsi_karya" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Karya</label>
                    <textarea name="deskripsi_karya" id="deskripsi_karya"
                              rows="4"
                              placeholder="Jelaskan singkat tentang karya Anda, fitur utama, teknologi yang digunakan, dll."
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('deskripsi_karya') border-red-500 @enderror">{{ old('deskripsi_karya') }}</textarea>
                    @error('deskripsi_karya')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex justify-between items-center gap-4 pt-6 border-t">
                <a href="{{ route('participant.competitions.show', $event->events_id) }}"
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">
                    Kembali
                </a>

                <button type="submit"
                    class="px-8 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Selesaikan Submit Karya</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Info Box --}}
    <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <h3 class="font-semibold text-blue-900 mb-2">Checklist Sebelum Submit</h3>
        <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
            <li>Anda sudah menyelesaikan pendaftaran peserta (Step 1)</li>
            <li>File atau link karya sudah siap dan dapat diakses</li>
            <li>Deskripsi karya sudah lengkap dan jelas</li>
            <li>Tidak ada informasi sensitif dalam karya Anda</li>
        </ul>
    </div>
</div>

{{-- Scripts untuk toggle file/link --}}
<script>
    const karyaTypeRadios = document.querySelectorAll('input[name="karya_type"]');
    const fileSection = document.getElementById('file_karya_section');
    const linkSection = document.getElementById('link_karya_section');
    const fileInput = document.getElementById('file_karya');
    const linkInput = document.getElementById('link_karya');

    karyaTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'file') {
                fileSection.classList.remove('hidden');
                linkSection.classList.add('hidden');
                linkInput.removeAttribute('required');
                fileInput.setAttribute('required', 'required');
            } else {
                fileSection.classList.add('hidden');
                linkSection.classList.remove('hidden');
                fileInput.removeAttribute('required');
                linkInput.setAttribute('required', 'required');
            }
        });
    });

    // File preview
    document.getElementById('file_karya')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const preview = document.getElementById('file_karya_preview');
            const size = (file.size / 1024 / 1024).toFixed(2);
            preview.innerHTML = `
                <div class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900">${file.name}</p>
                            <p class="text-xs text-gray-500">${size} MB</p>
                        </div>
                    </div>
                    <button type="button" onclick="document.getElementById('file_karya').value=''; this.parentElement.parentElement.remove();" 
                            class="text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            `;
        }
    });
</script>
@endsection

