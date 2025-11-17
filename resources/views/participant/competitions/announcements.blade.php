@extends('layouts.participant')

@section('content')
<div class="container mt-4">

    <h2>Pengumuman untuk {{ $event->nama }}</h2>

    @foreach($pengumumans as $pengumuman)
    <div class="card mb-3">
        <div class="card-body">
            <h4>{{ $pengumuman->judul }}</h4>
            <p>{{ $pengumuman->isi }}</p>
            <small class="text-muted">
                Dipublikasikan: {{ $pengumuman->created_at->format('d M Y H:i') }}
            </small>
        </div>
    </div>
    @endforeach

    @if ($pengumumans->isEmpty())
        <p class="text-muted">Belum ada pengumuman.</p>
    @endif

</div>
@endsection
