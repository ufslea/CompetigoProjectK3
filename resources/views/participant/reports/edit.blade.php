@extends('layouts.participant')

@section('title', 'Edit Laporan')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Edit Laporan</h1>
    <p class="text-gray-600 mt-1">Ubah informasi laporan Anda</p>
</div>

{{-- Error Alert --}}
@if ($errors->any())
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
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
    <form action="{{ route('participant.reports.update', $laporan->laporan_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        {{-- Event Selection --}}
        <div class="mb-6">
            <label for="events_id" class="block text-sm font-medium text-gray-900 mb-2">Event <span class="text-red-600">*</span></label>
            <select name="events_id" id="events_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('events_id') border-red-500 @enderror" required>
                <option value="">-- Pilih Event --</option>
                @foreach($events as $event)
                    <option value="{{ $event->events_id }}" {{ $laporan->events_id == $event->events_id ? 'selected' : '' }}>
                        {{ $event->nama }}
                    </option>
                @endforeach
            </select>
            @error('events_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Report Title --}}
        <div class="mb-6">
            <label for="judul" class="block text-sm font-medium text-gray-900 mb-2">Judul Laporan <span class="text-red-600">*</span></label>
            <input type="text" name="judul" id="judul" value="{{ old('judul', $laporan->judul) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('judul') border-red-500 @enderror" required>
            @error('judul')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div class="mb-6">
            <label for="deskripsi" class="block text-sm font-medium text-gray-900 mb-2">Deskripsi <span class="text-red-600">*</span></label>
            <textarea name="deskripsi" id="deskripsi" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror" required>{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Evidence --}}
        <div class="mb-6">
            <label for="bukti" class="block text-sm font-medium text-gray-900 mb-2">Bukti / Lampiran (Opsional)</label>
            <input type="text" name="bukti" id="bukti" value="{{ old('bukti', $laporan->bukti) }}" placeholder="https://example.com/bukti.jpg" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('bukti') border-red-500 @enderror">
            @error('bukti')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Admin Response --}}
        @if($laporan->tanggapan)
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <label class="block text-sm font-medium text-blue-900 mb-2">📝 Tanggapan dari Admin</label>
                <p class="text-sm text-blue-900">{{ $laporan->tanggapan }}</p>
            </div>
        @endif

        {{-- Status Badge --}}
        <div class="mb-8 p-4 bg-gray-50 border border-gray-200 rounded-lg">
            <label class="block text-sm font-medium text-gray-900 mb-2">Status Laporan</label>
            @php
                $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'processed' => 'bg-blue-100 text-blue-800',
                    'finished' => 'bg-green-100 text-green-800',
                    'refused' => 'bg-red-100 text-red-800',
                ];
                $statusTexts = [
                    'pending' => 'Menunggu',
                    'processed' => 'Diproses',
                    'finished' => 'Selesai',
                    'refused' => 'Ditolak',
                ];
            @endphp
            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$laporan->status] ?? 'bg-gray-100 text-gray-800' }}">
                {{ $statusTexts[$laporan->status] ?? 'Unknown' }}
            </span>
        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('participant.reports.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Update Laporan
            </button>
        </div>
    </form>
</div>
@endsection

