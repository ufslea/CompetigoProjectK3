@extends('layouts.organizer')

@section('content')
<div class="flex">
    @include('components.sidebar-organizer')

    <div class="flex-1 px-8 py-6">

        @include('components.navbar')

        <h1 class="text-3xl font-bold mb-6">Edit Event</h1>

        <form action="{{ route('organizer.events.update', $event->events_id) }}" method="POST" enctype="multipart/form-data"
              class="bg-white shadow-md rounded-2xl p-8">
            @csrf @method('PUT')

            <input type="hidden" name="organizer_id" value="{{ auth()->id() }}">

            <div class="mb-4">
                <label class="font-semibold">Nama Event</label>
                <input type="text" name="nama" value="{{ $event->nama }}" 
                       class="w-full mt-1 p-3 rounded-xl border" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Gambar Banner Event</label>
                @if($event->gambar)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $event->gambar) }}" alt="Event Banner" class="max-w-xs rounded-xl shadow">
                    </div>
                @endif
                <input type="file" name="gambar" id="gambarEditInput" accept="image/*" class="w-full mt-1 p-3 rounded-xl border">
                <p class="text-gray-500 text-sm mt-1">Format: JPEG, PNG, JPG, GIF. Max: 2MB. Biarkan kosong untuk tidak mengubah gambar.</p>
                <div id="gambarEditError" class="text-red-500 text-sm mt-2 font-semibold" style="display:none;"></div>
                <script>
                    document.getElementById('gambarEditInput').addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        const errorDiv = document.getElementById('gambarEditError');
                        const maxSize = 2 * 1024 * 1024; // 2MB
                        
                        if (file && file.size > maxSize) {
                            errorDiv.textContent = '❌ File terlalu besar! Maksimal 2MB. File Anda: ' + (file.size / (1024 * 1024)).toFixed(2) + 'MB';
                            errorDiv.style.display = 'block';
                            this.value = '';
                        } else {
                            errorDiv.style.display = 'none';
                        }
                    });
                </script>
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
