@extends('layouts.organizer')

@section('content')
<div class="flex">
    @include('components.sidebar-organizer')

    <div class="flex-1 px-8 py-6">

        @include('components.navbar')

        <h1 class="text-3xl font-bold mb-6">Tambah Event</h1>

        <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white shadow-md rounded-2xl p-8">
            @csrf

            <input type="hidden" name="organizer_id" value="{{ auth()->id() }}">

            <div class="mb-4">
                <label class="font-semibold">Nama Event</label>
                <input type="text" name="nama" class="w-full mt-1 p-3 rounded-xl border @error('nama') border-red-500 @enderror"
                       value="{{ old('nama') }}" required>
                @error('nama')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="font-semibold">Gambar Banner Event</label>
                <input type="file" name="gambar" id="gambarInput" accept="image/*" class="w-full mt-1 p-3 rounded-xl border @error('gambar') border-red-500 @enderror">
                <p class="text-gray-500 text-sm mt-1">Format: JPEG, PNG, JPG, GIF. Max: 2MB</p>
                <div id="gambarError" class="text-red-500 text-sm mt-2 font-semibold" style="display:none;"></div>
                @error('gambar')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
                <script>
                    document.getElementById('gambarInput').addEventListener('change', function(e) {
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

            <div class="mb-4">
                <label class="font-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="w-full mt-1 p-3 rounded-xl border @error('deskripsi') border-red-500 @enderror" 
                          rows="5" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="font-semibold">URL Event</label>
                <input type="url" name="url" class="w-full mt-1 p-3 rounded-xl border @error('url') border-red-500 @enderror"
                       placeholder="https://example.com" value="{{ old('url') }}" required>
                @error('url')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="font-semibold">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="w-full p-3 rounded-xl border @error('tanggal_mulai') border-red-500 @enderror" 
                           value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="w-full p-3 rounded-xl border @error('tanggal_akhir') border-red-500 @enderror" 
                           value="{{ old('tanggal_akhir') }}" required>
                    @error('tanggal_akhir')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="font-semibold">Status</label>
                <select name="status" class="w-full mt-1 p-3 rounded-xl border @error('status') border-red-500 @enderror" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="draft" @selected(old('status') == 'draft')>Draft</option>
                    <option value="active" @selected(old('status') == 'active')>Active</option>
                    <option value="finished" @selected(old('status') == 'finished')>Finished</option>
                    
                </select>
                @error('status')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow hover:scale-105 transition">
                    Simpan Event
                </button>
                <a href="{{ route('organizer.events.index') }}" class="flex-1 py-3 bg-gray-400 text-white rounded-xl shadow hover:scale-105 transition text-center">
                    Batal
                </a>
            </div>
        </form>

    </div>
</div>

@include('components.footer')
@endsection
