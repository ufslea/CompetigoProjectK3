@extends('layouts.admin')

@section('title', 'Edit Hasil')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit Hasil</h1>
    <p class="text-gray-600 mt-1">Ubah informasi hasil kompetisi</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.results.update', $hasil->hasil_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Partisipan</label>
            <p class="text-gray-900">{{ $hasil->partisipan->user->nama ?? '-' }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sub Lomba</label>
            <p class="text-gray-900">{{ $hasil->sublomba->nama ?? '-' }}</p>
        </div>

        <div class="mb-4">
            <label for="rank" class="block text-sm font-medium text-gray-700 mb-2">Rank</label>
            <input type="number" name="rank" id="rank" value="{{ old('rank', $hasil->rank) }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            @error('rank')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('deskripsi', $hasil->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.results.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update Hasil</button>
        </div>
    </form>
</div>
@endsection

