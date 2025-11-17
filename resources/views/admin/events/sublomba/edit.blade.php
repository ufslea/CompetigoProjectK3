@extends('layouts.admin')

@section('title', 'Edit Sub Lomba')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit Sub Lomba</h1>
    <p class="text-gray-600 mt-1">Event: {{ $subLomba->event->nama ?? '-' }}</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.events.sublomba.update', ['event_id' => $subLomba->event_id, 'id' => $subLomba->sublomba_id]) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $subLomba->nama) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <input type="text" name="kategori" id="kategori" value="{{ old('kategori', $subLomba->kategori) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                @error('kategori')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">Deadline</label>
                <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $subLomba->deadline) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                @error('deadline')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <option value="open" {{ $subLomba->status == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ $subLomba->status == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('deskripsi', $subLomba->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.events.sublomba.index', $subLomba->event_id) }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update Sub Lomba</button>
        </div>
    </form>
</div>
@endsection

