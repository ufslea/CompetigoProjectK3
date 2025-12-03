@extends('layouts.participant')

@section('title', 'Notifikasi')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Notifikasi Saya</h1>
        @if($notifikasi->isNotEmpty())
            <button onclick="markAllAsRead()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Tandai Semua Dibaca
            </button>
        @endif
    </div>
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

{{-- Empty State --}}
@if ($notifikasi->isEmpty())
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada notifikasi</h3>
        <p class="mt-2 text-sm text-gray-600">Anda akan menerima notifikasi di sini.</p>
    </div>
@else
    {{-- Notifications List --}}
    <div class="space-y-3">
        @foreach ($notifikasi as $item)
            <div class="bg-white rounded-lg shadow-sm border {{ $item->is_read ? 'border-gray-100 bg-white' : 'border-blue-200 bg-blue-50' }} p-4">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <h3 class="text-sm font-semibold {{ $item->is_read ? 'text-gray-900' : 'text-blue-900' }}">
                                {{ $item->judul }}
                            </h3>
                            @if (!$item->is_read)
                                <span class="px-2 py-1 bg-blue-600 text-white text-xs rounded-full">Baru</span>
                            @endif
                        </div>
                        <p class="text-sm {{ $item->is_read ? 'text-gray-600' : 'text-blue-800' }} mt-2">
                            {{ $item->pesan }}
                        </p>
                        <p class="text-xs text-gray-500 mt-2">
                            {{ $item->created_at?->format('d M Y H:i') }}
                        </p>
                    </div>

                    <div class="flex gap-2 ml-4">
                        @if (!$item->is_read)
                            <button onclick="markAsRead({{ $item->notifikasi_id }})" 
                                    class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition">
                                Tandai Dibaca
                            </button>
                        @endif
                        <form action="{{ route('participant.notifications.destroy', $item->notifikasi_id) }}" 
                              method="POST" 
                              style="display:inline;"
                              onsubmit="return confirm('Hapus notifikasi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700 transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6 flex justify-center">
        {{ $notifikasi->links() }}
    </div>
@endif

<script>
    function markAsRead(notifikasiId) {
        fetch(`/participant/notifications/${notifikasiId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function markAllAsRead() {
        fetch('/participant/notifications/mark-all-as-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection
