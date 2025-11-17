@extends('layouts.admin')

@section('title', 'Edit Laporan')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit Laporan</h1>
    <p class="text-gray-600 mt-1">Update status dan tanggapan laporan</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <h3 class="font-semibold text-gray-700 mb-2">Informasi Laporan</h3>
        <p class="text-sm text-gray-600"><strong>Pelapor:</strong> {{ $report->pelapor->nama ?? '-' }}</p>
        <p class="text-sm text-gray-600"><strong>Event:</strong> {{ $report->event->nama ?? '-' }}</p>
        <p class="text-sm text-gray-600"><strong>Judul:</strong> {{ $report->judul }}</p>
        <p class="text-sm text-gray-600 mt-2"><strong>Deskripsi:</strong></p>
        <p class="text-sm text-gray-700 mt-1">{{ $report->deskripsi }}</p>
        @if($report->bukti)
            <p class="text-sm text-gray-600 mt-2"><strong>Bukti:</strong> <a href="{{ $report->bukti }}" target="_blank" class="text-blue-600 hover:underline">{{ $report->bukti }}</a></p>
        @endif
    </div>

    <form action="{{ route('admin.reports.update', $report->laporan_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processed" {{ $report->status == 'processed' ? 'selected' : '' }}>Diproses</option>
                <option value="finished" {{ $report->status == 'finished' ? 'selected' : '' }}>Selesai</option>
                <option value="refused" {{ $report->status == 'refused' ? 'selected' : '' }}>Ditolak</option>
            </select>
            @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="tanggapan" class="block text-sm font-medium text-gray-700 mb-2">Tanggapan</label>
            <textarea name="tanggapan" id="tanggapan" rows="5" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Berikan tanggapan untuk laporan ini...">{{ old('tanggapan', $report->tanggapan) }}</textarea>
            @error('tanggapan')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update Laporan</button>
        </div>
    </form>
</div>
@endsection

