@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Tambah Pengumuman</h1>
    <p class="text-gray-600 mt-1">Buat pengumuman baru untuk event</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.announcements.store') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label for="events_id" class="block text-sm font-medium text-gray-700 mb-2">Event</label>
            <select name="events_id" id="events_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                <option value="">Pilih Event</option>
                @foreach($events as $event)
                    <option value="{{ $event->events_id }}" {{ old('events_id') == $event->events_id ? 'selected' : '' }}>{{ $event->nama }}</option>
                @endforeach
            </select>
            @error('events_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Judul</label>
            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            @error('judul')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="isi" class="block text-sm font-medium text-gray-700 mb-2">Isi</label>
            <textarea name="isi" id="isi" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>{{ old('isi') }}</textarea>
            @error('isi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan Pengumuman</button>
        </div>
    </form>
</div>
@endsection

