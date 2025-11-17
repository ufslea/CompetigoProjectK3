@extends('layouts.participant')

@section('title', 'Submit Karya')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Submit Karya</h1>
    <p class="text-gray-600 mt-1">Kirim karya Anda untuk event: {{ $event->nama }}</p>
</div>

{{-- Success Alert --}}
@if (session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm font-medium text-green-800">{{ session('success') }}</span>
        </div>
    </div>
@endif

{{-- Error Alert --}}
@if (session('error'))
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span class="text-sm font-medium text-red-800">{{ session('error') }}</span>
        </div>
    </div>
@endif

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('participant.competitions.store', $event->events_id) }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Event</label>
            <p class="text-gray-900">{{ $event->nama }}</p>
        </div>

        <div class="mb-4">
            <label for="sublomba_id" class="block text-sm font-medium text-gray-700 mb-2">Sub Lomba</label>
            <select name="sublomba_id" id="sublomba_id"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                <option value="">Pilih Sub Lomba</option>
                @foreach($sublomba as $sub)
                    <option value="{{ $sub->sublomba_id }}" {{ old('sublomba_id') == $sub->sublomba_id ? 'selected' : '' }}>
                        {{ $sub->nama }}
                    </option>
                @endforeach
            </select>
            @error('sublomba_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="institusi" class="block text-sm font-medium text-gray-700 mb-2">Institusi</label>
            <input type="text" name="institusi" id="institusi"
                value="{{ old('institusi') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            @error('institusi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="kontak" class="block text-sm font-medium text-gray-700 mb-2">Kontak</label>
            <input type="text" name="kontak" id="kontak"
                value="{{ old('kontak') }}"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            @error('kontak')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="file_karya" class="block text-sm font-medium text-gray-700 mb-2">File Karya (URL/Link)</label>
            <input type="text" name="file_karya" id="file_karya"
                value="{{ old('file_karya') }}"
                placeholder="https://example.com/karya.pdf"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('file_karya')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('participant.competitions.show', $event->events_id) }}"
                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Batal
            </a>

            <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Kirim Submission
            </button>
        </div>
    </form>
</div>
@endsection
