@extends('layouts.organizer')

@section('content')
<div class="flex">
    @include('components.sidebar-organizer')

    <div class="flex-1 px-8 py-6">
        @include('components.navbar')

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-[#1D3557]">Daftar Pengumuman</h1>

            <a href="{{ route('organizer.announcements.create') }}"
               class="px-4 py-2 bg-[#1D3557] text-white rounded-lg hover:bg-[#457B9D] transition">
               + Tambah Pengumuman
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow">
            @forelse($pengumumans as $pengumuman)
                <div class="border-b py-4 last:border-b-0">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-[#1D3557]">{{ $pengumuman->judul }}</h2>
                            <p class="text-sm text-gray-500 mb-2">
                                Event: <strong>{{ $pengumuman->event->nama ?? 'N/A' }}</strong>
                            </p>
                            <p class="text-gray-600">{{ Str::limit($pengumuman->isi, 150) }}</p>
                            <p class="text-xs text-gray-400 mt-2">
                                {{ $pengumuman->created_at?->format('d M Y H:i') ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-3 flex gap-3">
                        

                        <a href="{{ route('organizer.announcements.edit', $pengumuman->pengumuman_id) }}"
                           class="px-3 py-1 text-yellow-600 hover:text-yellow-800 underline text-sm">
                            Edit
                        </a>

                        <form action="{{ route('organizer.announcements.destroy', $pengumuman->pengumuman_id) }}" 
                              method="POST" class="inline"
                              onsubmit="return confirm('Hapus pengumuman ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1 text-red-600 hover:text-red-800 underline text-sm">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

            @empty
                <div class="text-center py-8">
                    <p class="text-gray-500 mb-4">Belum ada pengumuman.</p>
                    <a href="{{ route('organizer.announcements.create') }}"
                       class="inline-block px-4 py-2 bg-[#1D3557] text-white rounded hover:bg-[#457B9D] transition">
                        Buat Pengumuman Pertama
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

@include('components.footer')
@endsection
