@extends('layouts.organizer')

@section('title', 'Tambah Hasil Lomba')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Tambah Hasil Lomba</h1>
    <p class="text-gray-600 mt-1">Isi data hasil lomba untuk peserta.</p>
</div>

{{-- Error Alert --}}
@if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-start">
            <svg class="h-5 w-5 text-red-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <div class="text-sm text-red-800">
                <p class="font-medium">Ada kesalahan pada form:</p>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
    <form action="{{ route('organizer.results.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Sublomba --}}
        <div class="mb-6">
            <label for="sublomba_id" class="block text-sm font-medium text-gray-900 mb-2">Sub-Lomba <span class="text-red-600">*</span></label>
            <select name="sublomba_id" id="sublomba_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('sublomba_id') border-red-500 @enderror" required>
                <option value="">-- Pilih Sub-Lomba --</option>
                @foreach($sublombas as $s)
                    <option value="{{ $s->sublomba_id }}" {{ old('sublomba_id') == $s->sublomba_id ? 'selected' : '' }}>
                        {{ $s->nama }}
                    </option>
                @endforeach
            </select>
            @error('sublomba_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Partisipan --}}
        <div class="mb-6">
            <label for="partisipan_id" class="block text-sm font-medium text-gray-900 mb-2">Peserta <span class="text-red-600">*</span></label>
            <select name="partisipan_id" id="partisipan_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('partisipan_id') border-red-500 @enderror" required>
                <option value="">-- Pilih Peserta --</option>
                @foreach($partisipans as $p)
                    <option value="{{ $p->partisipan_id }}" {{ old('partisipan_id') == $p->partisipan_id ? 'selected' : '' }}>
                        {{ $p->user->nama ?? 'N/A' }} - {{ $p->sublomba?->nama ?? 'N/A' }}
                    </option>
                @endforeach
            </select>
            @error('partisipan_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Rank --}}
        <div class="mb-6">
            <label for="rank" class="block text-sm font-medium text-gray-900 mb-2">Peringkat <span class="text-red-600">*</span></label>
            <input type="number" name="rank" id="rank" value="{{ old('rank') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('rank') border-red-500 @enderror" required min="1">
            @error('rank')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-6">
            <label for="deskripsi" class="block text-sm font-medium text-gray-900 mb-2">Deskripsi (Opsional)</label>
            <textarea name="deskripsi" id="deskripsi" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror" placeholder="Catatan atau deskripsi tentang hasil...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Gambar (Sertifikat) --}}
        <div class="mb-6">
            <label for="gambar" class="block text-sm font-medium text-gray-900 mb-2">Gambar Sertifikat (Opsional)</label>
            <input type="file" name="gambar" id="gambar" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('gambar') border-red-500 @enderror">
            <p class="text-gray-500 text-sm mt-1">Format: JPEG, PNG, JPG, GIF. Max: 2MB</p>
            <div id="gambarError" class="text-red-500 text-sm mt-2 font-semibold" style="display:none;"></div>
            @error('gambar')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <script>
                document.getElementById('gambar').addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    const errorDiv = document.getElementById('gambarError');
                    const maxSize = 2 * 1024 * 1024; // 2MB
                    
                    if (file && file.size > maxSize) {
                        errorDiv.textContent = '❌ File terlalu besar! Maksimal 2MB. File Anda: ' + (file.size / (1024 * 1024)).toFixed(2) + 'MB';
                        errorDiv.style.display = 'block';
                        this.value = '';
                    } else {
                        errorDiv.style.display = 'none';
                    }
                });
            </script>
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('organizer.results.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Batal
            </a>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Simpan Hasil
            </button>
        </div>
    </form>
</div>
@endsection
