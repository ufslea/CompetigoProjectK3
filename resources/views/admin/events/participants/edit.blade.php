@extends('layouts.admin')

@section('title', 'Edit Participant')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit Participant</h1>
    <p class="text-gray-600 mt-1">Ubah status partisipan</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <h3 class="font-semibold text-gray-700 mb-2">Informasi Participant</h3>
        <p class="text-sm text-gray-600"><strong>Nama:</strong> {{ $partisipan->user->nama ?? '-' }}</p>
        <p class="text-sm text-gray-600"><strong>Sub Lomba:</strong> {{ $partisipan->sublomba->nama ?? '-' }}</p>
        <p class="text-sm text-gray-600"><strong>Institusi:</strong> {{ $partisipan->institusi ?? '-' }}</p>
    </div>

    <form action="{{ route('admin.events.participants.update', ['event_id' => $partisipan->sublomba->event_id, 'id' => $partisipan->partisipan_id]) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                <option value="pending" {{ $partisipan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="submitted" {{ $partisipan->status == 'submitted' ? 'selected' : '' }}>Submitted</option>
                <option value="approved" {{ $partisipan->status == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ $partisipan->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.events.participants.index', ['event_id' => $partisipan->sublomba->event_id]) }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update Status</button>
        </div>
    </form>
</div>
@endsection

