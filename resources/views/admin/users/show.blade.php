@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800">Detail User</h1>
    <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-800">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="font-semibold text-gray-700 mb-4">Informasi User</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-sm font-medium text-gray-600">Nama</p>
                    <p class="text-gray-900">{{ $user->nama }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Email</p>
                    <p class="text-gray-900">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Role</p>
                    <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">No. HP</p>
                    <p class="text-gray-900">{{ $user->no_hp ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Institusi</p>
                    <p class="text-gray-900">{{ $user->institusi ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div>
            <h3 class="font-semibold text-gray-700 mb-4">Statistik</h3>
            <div class="space-y-3">
                <div class="p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm font-medium text-blue-600">Total Partisipasi</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $user->partisipan->count() ?? 0 }}</p>
                </div>
                @if($user->role == 'organizer')
                    <div class="p-4 bg-green-50 rounded-lg">
                        <p class="text-sm font-medium text-green-600">Total Event</p>
                        <p class="text-2xl font-bold text-green-900">{{ $user->events->count() ?? 0 }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-end space-x-3">
        <a href="{{ route('admin.users.edit', $user->user_id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            Edit User
        </a>
    </div>
</div>
@endsection

