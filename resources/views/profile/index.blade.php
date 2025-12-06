@php
    $user = auth()->user();
    $roleText = match($user->role) {
        'participant' => 'Peserta Kompetisi',
        'organizer' => 'Penyelenggara Event',
        'admin' => 'Administrator Sistem',
        default => 'User'
    };
    $roleBadge = match($user->role) {
        'participant' => 'Peserta',
        'organizer' => 'Penyelenggara',
        'admin' => 'Administrator',
        default => 'User'
    };
@endphp

@extends(in_array($user->role, ['participant', 'organizer', 'admin']) ? 
    ($user->role === 'participant' ? 'layouts.participant' : 
     ($user->role === 'organizer' ? 'layouts.organizer' : 'layouts.admin')) : 'layouts.app')

@section('title', 'Profil Saya')

@section('content')

        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">Profil Saya</h1>
                <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Edit Profil
                </a>
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Profile Card --}}
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="text-center">
                        <div class="h-20 w-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full mx-auto flex items-center justify-center text-white text-2xl font-bold mb-4">
                            {{ substr($user->nama, 0, 1) }}
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $user->nama }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $user->email }}</p>
                        <div class="mt-4">
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded-full">
                                {{ $roleBadge }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Profile Information --}}
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pribadi</h3>
                    
                    <div class="space-y-6">
                        {{-- Full Name --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <p class="text-base text-gray-900">{{ $user->nama }}</p>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <p class="text-base text-gray-900">{{ $user->email }}</p>
                        </div>

                        {{-- Role --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Peran</label>
                            <p class="text-base text-gray-900">{{ $roleText }}</p>
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <p class="text-base text-gray-900">{{ $user->no_hp ?? 'Tidak diisi' }}</p>
                        </div>

                        {{-- Institution --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Institusi</label>
                            <p class="text-base text-gray-900">{{ $user->institusi ?? 'Tidak diisi' }}</p>
                        </div>

                        {{-- Email Verified --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Email</label>
                            @if ($user->email_verified_at)
                                <div class="flex items-center gap-2">
                                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-green-600 font-medium">Terverifikasi</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-red-600 font-medium">Belum Terverifikasi</span>
                                </div>
                            @endif
                        </div>

                        {{-- Member Since --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bergabung Sejak</label>
                            <p class="text-base text-gray-900">{{ $user->created_at?->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('profile.edit') }}" class="p-4 bg-white border border-gray-100 rounded-lg hover:border-indigo-300 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">Edit Profil</p>
                        <p class="text-xs text-gray-500">Ubah informasi pribadi</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('profile.edit') }}#password" class="p-4 bg-white border border-gray-100 rounded-lg hover:border-indigo-300 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">Ubah Password</p>
                        <p class="text-xs text-gray-500">Amankan akun Anda</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('profile.edit') }}#delete" class="p-4 bg-white border border-gray-100 rounded-lg hover:border-red-300 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">Hapus Akun</p>
                        <p class="text-xs text-gray-500">Penghapusan permanen</p>
                    </div>
                </div>
            </a>
        </div>

@endsection
