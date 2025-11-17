@extends('layouts.participant')

@section('title', 'Edit Submission')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit Submission</h1>
    <p class="text-gray-600 mt-1">Ubah submission Anda untuk event: {{ $event->nama }}</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('participant.competitions.update', ['competition' => $event->events_id, 'submission' => $partisipan->partisipan_id]) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Event</label>
            <p class="text-gray-900">{{ $event->nama }}</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sub Lomba</label>
            <p class="text-gray-900">{{ $partisipan->sublomba->nama ?? '-' }}</p>
        </div>

        <div class="mb-4">
            <label for="institusi" class="block text-sm font-medium text-gray-700 mb-2">Institusi</label>
            <input type="text" name="institusi" id="institusi" value="{{ old('institusi', $partisipan->institusi) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            @error('institusi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="kontak" class="block text-sm font-medium text-gray-700 mb-2">Kontak</label>
            <input type="text" name="kontak" id="kontak" value="{{ old('kontak', $partisipan->kontak) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            @error('kontak')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="file_karya" class="block text-sm font-medium text-gray-700 mb-2">File Karya (URL/Link)</label>
            <input type="text" name="file_karya" id="file_karya" value="{{ old('file_karya', $partisipan->file_karya) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="https://example.com/karya.pdf">
            @error('file_karya')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <p class="text-gray-900">
                @if($partisipan->status == 'pending')
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">Pending</span>
                @elseif($partisipan->status == 'submitted')
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Submitted</span>
                @elseif($partisipan->status == 'approved')
                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-sm">Approved</span>
                @else
                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-sm">Rejected</span>
                @endif
            </p>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('participant.competitions.show', $event->events_id) }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update Submission</button>
        </div>
    </form>
</div>
@endsection

