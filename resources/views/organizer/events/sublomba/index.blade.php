@extends('layouts.organizer')

@section('content')
<div class=flex>  @include('components.sidebar-organizer')

    <div class="flex items-center justify-between mb-6">
            @include('components.navbar')
        <h1 class="text-2xl font-bold text-[#1D3557]">Daftar Sub Lomba</h1>

        <a href="{{ route('organizer.sublomba.create', $event->id) }}" 
           class="px-4 py-2 bg-[#1D3557] text-white rounded-lg shadow hover:bg-[#457B9D] transition">
            + Tambah Sub Lomba
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-[#1D3557] text-white">
                    <th class="p-3 text-left">Nama Sub Lomba</th>
                    <th class="p-3 text-left">Deskripsi</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($sublomba as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $item->nama_sublomba }}</td>
                    <td class="p-3">{{ Str::limit($item->deskripsi, 80) }}</td>
                    <td class="p-3">
                        <a href="{{ route('organizer.sublomba.edit', [$event->id, $item->id]) }}"
                           class="px-3 py-1 bg-[#457B9D] text-white rounded hover:bg-[#1D3557]">
                            Edit
                        </a>

                        <form action="{{ route('organizer.sublomba.destroy', [$event->id, $item->id]) }}" 
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                                onclick="return confirm('Hapus sub lomba ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-500">
                        Belum ada sub lomba.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@include('components.footer')
@endsection
