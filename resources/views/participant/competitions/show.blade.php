@extends('layouts.participant')

@section('content')
<div class="container mt-4">

    <h2 class="text-lg font-semibold text-gray-900 mb-1">{{ $event->nama }}</h2>
    <p class="text-gray-500 text-sm mb-3">{{ $event->deskripsi }}</p>

    <div class="mb-3">
        <a href="{{ $event->url }}" target="_blank" class="btn btn-info">Kunjungi Website Event</a>
    </div>

    <h4 class="text-lg font-semibold text-gray-900 mb-1">Sub Lomba</h4>
    <ul>
        @foreach($event->subLombas as $sublomba)
            <li>{{ $sublomba->nama }}</li>
        @endforeach
    </ul>

    <div class="mt-4">
        

        <a href="{{ route('participant.competitions.create', $event->events_id) }}"
           class="px-4 py-2 rounded-md text-white text-sm"
                           style="background:#003366;">Upload Karya</a>

        <a href="{{ route('participant.competitions.announcement', $event->events_id) }}"
           class="px-4 py-2 rounded-md text-white text-sm"
                           style="background:#003366;">Lihat Pengumuman</a>
    </div>

</div>
@endsection
