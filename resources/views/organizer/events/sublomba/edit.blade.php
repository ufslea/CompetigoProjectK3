@extends('layouts.organizer')

@section('content')
<div class="flex">
    @include('components.sidebar-organizer')

    <div class="flex-1 px-8 py-6">
        @include('components.navbar')

        <h1 class="text-2xl font-bold text-[#1D3557] mb-6">Edit Sub Lomba</h1>

        <div class="bg-white p-6 rounded-lg shadow">

            <form action="{{ route('organizer.events.sublomba.update', [$event->events_id, $subLomba->sublomba_id]) }}" 
                  method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-[#1D3557]">Nama Sub Lomba</label>
                    <input type="text" name="nama"
                           value="{{ $subLomba->nama }}"
                           class="w-full p-3 border rounded focus:ring-[#1D3557] @error('nama') border-red-500 @enderror"
                           required>
                    @error('nama')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-[#1D3557]">Kategori</label>
                    <input type="text" name="kategori"
                           value="{{ $subLomba->kategori }}"
                           class="w-full p-3 border rounded focus:ring-[#1D3557] @error('kategori') border-red-500 @enderror"
                           required>
                    @error('kategori')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-[#1D3557]">Deskripsi</label>
                    <textarea name="deskripsi"
                              class="w-full p-3 border rounded h-32 focus:ring-[#1D3557] @error('deskripsi') border-red-500 @enderror"
                              required>{{ $subLomba->deskripsi }}</textarea>
                    @error('deskripsi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-[#1D3557]">Link</label>
                    <input type="url" name="link"
                           value="{{ $subLomba->link }}"
                           class="w-full p-3 border rounded focus:ring-[#1D3557] @error('link') border-red-500 @enderror"
                           placeholder="https://example.com">
                    @error('link')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-[#1D3557]">Deadline</label>
                    <input type="date" name="deadline"
                           value="{{ is_string($subLomba->deadline) ? $subLomba->deadline : $subLomba->deadline?->format('Y-m-d') }}"
                           class="w-full p-3 border rounded focus:ring-[#1D3557] @error('deadline') border-red-500 @enderror"
                           required>
                    @error('deadline')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-[#1D3557]">Status</label>
                    <select name="status"
                            class="w-full p-3 border rounded focus:ring-[#1D3557] @error('status') border-red-500 @enderror"
                            required>
                        <option value="open" @selected($subLomba->status == 'open')>Open</option>
                        <option value="closed" @selected($subLomba->status == 'closed')>Closed</option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('organizer.events.show', $event->events_id) }}"
                       class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Kembali
                    </a>

                    <button type="submit"
                        class="px-4 py-2 bg-[#1D3557] text-white rounded hover:bg-[#457B9D] transition">
                        Update
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@include('components.footer')
@endsection
