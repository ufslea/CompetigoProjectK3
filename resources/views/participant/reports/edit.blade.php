@extends('layouts.participant')

@section('title', 'Edit Laporan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit Laporan</h1>
    <p class="text-gray-600 mt-1">Ubah informasi laporan Anda</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('participant.reports.update', $laporan->laporan_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="events_id" class="block text-sm font-medium text-gray-700 mb-2">Event</label>
            <select name="events_id" id="events_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                <option value="">Pilih Event</option>
                @foreach($events as $event)
                    <option value="{{ $event->events_id }}" {{ $laporan->events_id == $event->events_id ? 'selected' : '' }}>{{ $event->nama }}</option>
                @endforeach
            </select>
            @error('events_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Judul Laporan</label>
            <input type="text" name="judul" id="judul" value="{{ old('judul', $laporan->judul) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            @error('judul')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="5" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="bukti" class="block text-sm font-medium text-gray-700 mb-2">Bukti (URL/Link)</label>
            <input type="text" name="bukti" id="bukti" value="{{ old('bukti', $laporan->bukti) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="https://example.com/bukti.jpg">
            @error('bukti')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        @if($laporan->tanggapan)
            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-md">
                <label class="block text-sm font-medium text-blue-700 mb-2">Tanggapan Admin</label>
                <p class="text-sm text-blue-900">{{ $laporan->tanggapan }}</p>
            </div>
        @endif

        <div class="flex justify-end space-x-3">
            <a href="{{ route('participant.reports.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update Laporan</button>
        </div>
    </form>
</div>
@endsection

