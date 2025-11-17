@extends('layouts.organizer')

@section('content')
<div class="flex">
    @include('components.sidebar-organizer')

    <div class="flex-1 px-8 py-6">
        @include('components.navbar')

        <h1 class="text-2xl font-bold text-[#1D3557] mb-6">Edit Pengumuman</h1>

        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow">
            <form action="{{ route('organizer.announcements.update', $pengumuman->pengumuman_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-semibold text-[#1D3557] mb-2">Event</label>
                    <select name="events_id" 
                            class="w-full p-3 border rounded focus:ring-[#1D3557] @error('events_id') border-red-500 @enderror"
                            required>
                        <option value="">-- Pilih Event --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->events_id }}" @selected($pengumuman->events_id == $event->events_id)>
                                {{ $event->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('events_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold text-[#1D3557] mb-2">Judul</label>
                    <input type="text" name="judul" 
                           value="{{ $pengumuman->judul }}"
                           class="w-full p-3 border rounded focus:ring-[#1D3557] @error('judul') border-red-500 @enderror"
                           required>
                    @error('judul')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold text-[#1D3557] mb-2">Isi Pengumuman</label>
                    <textarea name="isi" 
                              class="w-full p-3 border rounded h-32 focus:ring-[#1D3557] @error('isi') border-red-500 @enderror"
                              required>{{ $pengumuman->isi }}</textarea>
                    @error('isi')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button class="px-4 py-2 bg-[#1D3557] text-white rounded hover:bg-[#457B9D] transition" type="submit">
                        Update
                    </button>
                    <a href="{{ route('organizer.announcements.index') }}" 
                       class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@include('components.footer')
@endsection
