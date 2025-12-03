@extends('layouts.organizer')

@section('content')
<div class=flex>  @include('components.sidebar-organizer')

    <div class="flex-1 px-8 py-6">
        @include('components.navbar')

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-[#1D3557]">Daftar Sub Lomba</h1>
                <p class="text-gray-600 text-sm mt-1">Event: <strong>{{ $event->nama }}</strong></p>
            </div>

            <a href="{{ route('organizer.events.sublomba.create', $event->id) }}" 
               class="px-4 py-2 bg-[#1D3557] text-white rounded-lg shadow hover:bg-[#457B9D] transition">
                + Tambah Sub Lomba
            </a>
        </div>

        {{-- Search & Filter Section --}}
        <div class="mb-6 bg-white rounded-lg shadow-md p-4">
            <form method="GET" action="{{ route('organizer.events.sublomba.index', $event->id) }}" class="flex items-end gap-4">
                {{-- Search Input --}}
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Sub Lomba</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Nama atau kategori..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                </div>

                {{-- Status Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Semua</option>
                        <option value="open" {{ $status_filter === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="closed" {{ $status_filter === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-2">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Cari
                    </button>
                    <a href="{{ route('organizer.events.sublomba.index', $event->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#1D3557] text-white">
                        <th class="p-3 text-left text-sm font-semibold">Nama</th>
                        <th class="p-3 text-left text-sm font-semibold">Kategori</th>
                        <th class="p-3 text-left text-sm font-semibold">Status</th>
                        <th class="p-3 text-left text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($subLombas as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 text-sm">{{ $item->nama_sublomba }}</td>
                        <td class="p-3 text-sm">{{ $item->kategori ?? '-' }}</td>
                        <td class="p-3 text-sm">
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $item->status === 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="p-3 text-sm flex gap-1">
                            <a href="{{ route('organizer.events.sublomba.edit', [$event->id, $item->id]) }}"
                               class="px-2 py-1 bg-[#457B9D] text-white rounded hover:bg-[#1D3557] text-xs">
                                Edit
                            </a>

                            <form action="{{ route('organizer.events.sublomba.destroy', [$event->id, $item->id]) }}" 
                                  method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs"
                                    onclick="return confirm('Hapus sub lomba ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500 text-sm">
                            Belum ada sub lomba.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($subLombas->count() > 0)
            <div class="mt-6">
                {{ $subLombas->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>

@include('components.footer')
@endsection
