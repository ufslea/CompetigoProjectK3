@extends('layouts.organizer')

@section('title', 'Edit Hasil Lomba')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Edit Hasil Lomba</h1>
    <p class="text-gray-600 mt-1">Ubah data hasil lomba untuk peserta.</p>
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
    <form action="{{ route('organizer.results.update', $hasil->hasil_id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Sublomba (Read-only) --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-900 mb-2">Sub-Lomba</label>
            <div class="px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-700">
                {{ $hasil->sublomba->nama_sublomba ?? 'N/A' }}
            </div>
            <p class="text-xs text-gray-500 mt-1">Tidak dapat diubah setelah dibuat</p>
        </div>

        {{-- Partisipan (Read-only) --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-900 mb-2">Peserta</label>
            <div class="px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-700">
                {{ $hasil->partisipan->user->nama ?? 'N/A' }} - {{ $hasil->partisipan->sublomba->nama_sublomba ?? 'N/A' }}
            </div>
            <p class="text-xs text-gray-500 mt-1">Tidak dapat diubah setelah dibuat</p>
        </div>

        {{-- Rank --}}
        <div class="mb-6">
            <label for="rank" class="block text-sm font-medium text-gray-900 mb-2">Peringkat <span class="text-red-600">*</span></label>
            <input type="number" name="rank" id="rank" value="{{ old('rank', $hasil->rank) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('rank') border-red-500 @enderror" required min="1">
            @error('rank')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-6">
            <label for="deskripsi" class="block text-sm font-medium text-gray-900 mb-2">Deskripsi (Opsional)</label>
            <textarea name="deskripsi" id="deskripsi" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror" placeholder="Catatan atau deskripsi tentang hasil...">{{ old('deskripsi', $hasil->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('organizer.results.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Batal
            </a>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Update Hasil
            </button>
        </div>
    </form>
</div>
@endsection
