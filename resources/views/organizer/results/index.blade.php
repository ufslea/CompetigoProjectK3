@extends('layouts.organizer')

@section('content')

<div class="mb-8">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Hasil Lomba</h1>
        <a href="{{ route('organizer.results.create') }}" 
           class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            + Tambah Hasil
        </a>
    </div>
    <p class="text-gray-600 mt-1">Kelola peringkat hasil lomba untuk setiap peserta.</p>
</div>

{{-- Success Alert --}}
@if (session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm font-medium text-green-800">{{ session('success') }}</span>
        </div>
    </div>
@endif

{{-- Search & Filter Section --}}
<div class="mb-6 bg-white rounded-lg shadow-md p-4">
    <form method="GET" action="{{ route('organizer.results.index') }}" class="flex items-end gap-4">
        {{-- Search Input --}}
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Hasil</label>
            <div class="relative">
                <svg class="absolute left-3 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Nama peserta atau deskripsi..."
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>
        </div>

        {{-- Sublomba Filter --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Sub-Lomba</label>
            <select name="sublomba" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                <option value="">Semua</option>
                @foreach($sublombas as $sublomba)
                    <option value="{{ $sublomba->sublomba_id }}" {{ $sublomba_filter == $sublomba->sublomba_id ? 'selected' : '' }}>
                        {{ $sublomba->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Buttons --}}
        <div class="flex gap-2">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Cari
            </button>
            <a href="{{ route('organizer.results.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                Reset
            </a>
        </div>
    </form>
</div>

{{-- Empty State --}}
@if ($hasil->isEmpty())
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada hasil</h3>
        <p class="mt-2 text-sm text-gray-600">Mulai dengan menambahkan hasil lomba pertama.</p>
        <a href="{{ route('organizer.results.create') }}" 
           class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            Tambah Hasil Pertama
        </a>
    </div>
@else
    {{-- Results Table --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Peserta</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Sub-Lomba</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Peringkat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($hasil as $row)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($row->gambar)
    <img src="{{ asset('storage/' . $row->gambar) }}" 
         alt="Hasil" class="h-12 w-12 rounded object-cover">
@else
    <div class="h-12 w-12 bg-gray-300 rounded flex items-center justify-center text-gray-500 text-xs">
        No Img
    </div>
@endif


                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $row->partisipan->user->nama ?? '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $row->partisipan->user->institusi ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-700">{{ $row->sublomba->nama ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($row->rank == 1)
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-bold rounded-full">🥇 1st</span>
                            @elseif ($row->rank == 2)
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm font-bold rounded-full">🥈 2nd</span>
                            @elseif ($row->rank == 3)
                                <span class="px-3 py-1 bg-orange-100 text-orange-800 text-sm font-bold rounded-full">🥉 3rd</span>
                            @else
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-bold rounded-full">#{{ $row->rank }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600">{{ Str::limit($row->deskripsi, 50) ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                            <a href="{{ route('organizer.results.edit', $row->hasil_id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                            <form action="{{ route('organizer.results.destroy', $row->hasil_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus hasil ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $hasil->links('pagination::tailwind') }}
    </div>
@endif
@endsection
