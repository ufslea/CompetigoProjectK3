@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Pengumuman</h1>
            <p class="text-gray-600 mt-2">Manajemen dan publikasi pengumuman untuk semua event</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Pengumuman
        </a>
    </div>
</div>

{{-- Success Alert --}}
@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
        <svg class="h-5 w-5 text-green-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <div>
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
@endif

{{-- Error Alert --}}
@if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
        <svg class="h-5 w-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <div>
            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
        </div>
    </div>
@endif

{{-- Empty State --}}
@if($pengumumans->isEmpty())
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.961 1.961 0 01-2.756-1.735V5.882m0 0a2 2 0 00-2-2H3a2 2 0 00-2 2v12a2 2 0 002 2h1.841c.026.04.112.034.113.06V5.882m0 0V5C1.094 2.476.838 1.5 2.747 1.5h2.383c2.908 0 2.653.94 2.653 3.382v12.357c0 2.441.255 3.382-2.653 3.382H2.747C.838 21 1.094 20.024 1.094 17.5V5.882"/>
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada pengumuman</h3>
        <p class="mt-2 text-sm text-gray-600">Mulai dengan membuat pengumuman pertama Anda.</p>
        <a href="{{ route('admin.announcements.create') }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            Buat Pengumuman Pertama
        </a>
    </div>
@else
    {{-- Announcements Table --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Event</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Isi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($pengumumans as $pengumuman)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $pengumuman->judul }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">{{ $pengumuman->event->nama ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600">{{ Str::limit($pengumuman->isi, 60) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-600">{{ $pengumuman->created_at->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.announcements.show', $pengumuman->pengumuman_id) }}" 
                                       class="inline-flex items-center px-3 py-1 text-sm text-indigo-600 hover:text-indigo-900 hover:bg-indigo-50 rounded transition">
                                        Lihat
                                    </a>
                                    <a href="{{ route('admin.announcements.edit', $pengumuman->pengumuman_id) }}" 
                                       class="inline-flex items-center px-3 py-1 text-sm text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.announcements.destroy', $pengumuman->pengumuman_id) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1 text-sm text-red-600 hover:text-red-900 hover:bg-red-50 rounded transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada data pengumuman
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($pengumumans->hasPages())
        <div class="mt-6">
            {{ $pengumumans->links() }}
        </div>
    @endif
@endif
@endsection

