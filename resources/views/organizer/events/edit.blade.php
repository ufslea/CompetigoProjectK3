@extends('layouts.organizer')

@section('content')
<div class="flex">
    @include('components.sidebar-organizer')

    <div class="flex-1 px-8 py-6">

        @include('components.navbar')

        <h1 class="text-3xl font-bold mb-6">Edit Event</h1>

        <form action="{{ route('organizer.events.update', $event->events_id) }}" method="POST"
              class="bg-white shadow-md rounded-2xl p-8">
            @csrf @method('PUT')

            <input type="hidden" name="organizer_id" value="{{ auth()->id() }}">

            <div class="mb-4">
                <label class="font-semibold">Nama Event</label>
                <input type="text" name="nama" value="{{ $event->nama }}" 
                       class="w-full mt-1 p-3 rounded-xl border" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Deskripsi</label>
                <textarea name="deskripsi" rows="5"
                          class="w-full mt-1 p-3 rounded-xl border" required>{{ $event->deskripsi }}</textarea>
            </div>

            <div class="mb-4">
                <label class="font-semibold">URL Event</label>
                <input type="url" name="url" value="{{ $event->url }}"
                       class="w-full mt-1 p-3 rounded-xl border" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="font-semibold">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ $event->tanggal_mulai?->format('Y-m-d') }}"
                           class="w-full p-3 rounded-xl border" required>
                </div>
                <div>
                    <label class="font-semibold">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" value="{{ $event->tanggal_akhir?->format('Y-m-d') }}"
                           class="w-full p-3 rounded-xl border" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="font-semibold">Status</label>
                <select name="status" class="w-full mt-1 p-3 rounded-xl border">
                    <option value="draft" @selected($event->status == 'draft')>Draft</option>
                    <option value="active" @selected($event->status == 'active')>Active</option>
                    <option value="finished" @selected($event->status == 'finished')>Finished</option>
                    
                </select>
            </div>

            <button type="submit" class="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow hover:scale-105 transition">
                Update Event
            </button>
        </form>

    </div>
</div>

@include('components.footer')
@endsection
