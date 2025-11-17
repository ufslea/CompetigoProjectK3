@extends('layouts.organizer')

@section('title', 'Hasil Lomba')

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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                        Peserta
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                        Sub-Lomba
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                        Peringkat
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                        Deskripsi
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($hasil as $row)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $row->partisipan->user->nama ?? '-' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $row->partisipan->user->institusi ?? '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-700">
                                {{ $row->sublomba->nama ?? '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                @if ($row->rank == 1)
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-bold rounded-full">🥇 1st</span>
                                @elseif ($row->rank == 2)
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm font-bold rounded-full">🥈 2nd</span>
                                @elseif ($row->rank == 3)
                                    <span class="px-3 py-1 bg-orange-100 text-orange-800 text-sm font-bold rounded-full">🥉 3rd</span>
                                @else
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-bold rounded-full">#{{ $row->rank }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600">{{ Str::limit($row->deskripsi, 50) ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                            <a href="{{ route('organizer.results.edit', $row->hasil_id) }}" 
                               class="text-indigo-600 hover:text-indigo-900 font-medium">
                                Edit
                            </a>
                            <form action="{{ route('organizer.results.destroy', $row->hasil_id) }}" 
                                  method="POST" 
                                  style="display:inline;"
                                  onsubmit="return confirm('Yakin hapus hasil ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
