@extends('layouts.admin')

@section('title', 'Detail Laporan')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Detail Laporan</h1>
    <a href="{{ route('admin.reports.index') }}" class="text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="font-semibold text-gray-700 mb-4">Informasi Pelapor</h3>
            <div class="space-y-2">
                <p class="text-sm"><span class="font-medium text-gray-600">Nama:</span> {{ $laporan->pelapor->nama ?? '-' }}</p>
                <p class="text-sm"><span class="font-medium text-gray-600">Email:</span> {{ $laporan->pelapor->email ?? '-' }}</p>
            </div>
        </div>

        <div>
            <h3 class="font-semibold text-gray-700 mb-4">Informasi Event</h3>
            <div class="space-y-2">
                <p class="text-sm"><span class="font-medium text-gray-600">Nama Event:</span> {{ $laporan->event->nama ?? '-' }}</p>
                <p class="text-sm"><span class="font-medium text-gray-600">Status:</span>
                    @if($laporan->status == 'pending')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                    @elseif($laporan->status == 'processed')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Diproses</span>
                    @elseif($laporan->status == 'finished')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <h3 class="font-semibold text-gray-700 mb-2">Judul Laporan</h3>
        <p class="text-gray-900">{{ $laporan->judul }}</p>
    </div>

    <div class="mt-6">
        <h3 class="font-semibold text-gray-700 mb-2">Deskripsi</h3>
        <p class="text-gray-700 whitespace-pre-wrap">{{ $laporan->deskripsi }}</p>
    </div>

    @if($laporan->bukti)
        <div class="mt-6">
            <h3 class="font-semibold text-gray-700 mb-2">Bukti</h3>
            <a href="{{ $laporan->bukti }}" target="_blank" class="text-blue-600 hover:underline">{{ $laporan->bukti }}</a>
        </div>
    @endif

    @if($laporan->tanggapan)
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <h3 class="font-semibold text-blue-700 mb-2">Tanggapan Admin</h3>
            <p class="text-blue-900 whitespace-pre-wrap">{{ $laporan->tanggapan }}</p>
        </div>
    @endif

    <div class="mt-6 flex justify-end">
        <a href="{{ route('admin.reports.edit', $laporan->laporan_id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            Edit Laporan
        </a>
    </div>
</div>
@endsection

