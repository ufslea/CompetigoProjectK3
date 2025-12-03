@php
    $user = auth()->user();
@endphp

@extends(in_array($user->role, ['participant', 'organizer', 'admin']) ? 
    ($user->role === 'participant' ? 'layouts.participant' : 
     ($user->role === 'organizer' ? 'layouts.organizer' : 'layouts.admin')) : 'layouts.app')

@section('title', 'Edit Profil')

@section('content')
@if($user->role === 'admin' || $user->role === 'organizer')
<div class="flex">
    @if($user->role === 'admin')
        @include('components.sidebar-admin')
    @else
        @include('components.sidebar-organizer')
    @endif

    <div class="flex-1 px-8 py-6">
        @include('components.navbar')
@endif

        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-900">Edit Profil</h1>
                <a href="{{ route('profile.show') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    Kembali
                </a>
            </div>
        </div>

        {{-- Success Alert --}}
        @if (session('status') === 'profile-updated')
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium text-green-800">Profil berhasil diperbarui</span>
                </div>
            </div>
        @endif

        <div class="space-y-6">
            {{-- Update Profile Information --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Informasi Profil</h2>
                <p class="text-sm text-gray-600 mb-6">Perbarui nama dan email akun Anda</p>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    {{-- Name Field --}}
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-900 mb-2">Nama Lengkap <span class="text-red-600">*</span></label>
                        <input type="text" id="nama" name="name" value="{{ old('name', $user->nama) }}" required autofocus autocomplete="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email Field --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-900 mb-2">Email <span class="text-red-600">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                            <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded">
                                <p class="text-sm text-yellow-800">
                                    Email Anda belum terverifikasi.
                                    <button form="send-verification" class="underline font-semibold hover:text-yellow-900">
                                        Klik di sini untuk mengirim ulang link verifikasi.
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600">
                                        Link verifikasi telah dikirim ke email Anda.
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- No HP Field --}}
                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-900 mb-2">Nomor Telepon</label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" autocomplete="tel" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('no_hp') border-red-500 @enderror">
                        @error('no_hp')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Institution Field --}}
                    <div>
                        <label for="institusi" class="block text-sm font-medium text-gray-900 mb-2">Institusi</label>
                        <input type="text" id="institusi" name="institusi" value="{{ old('institusi', $user->institusi) }}" autocomplete="organization" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('institusi') border-red-500 @enderror">
                        @error('institusi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('profile.show') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Update Password --}}
            <div id="password" class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Ubah Password</h2>
                <p class="text-sm text-gray-600 mb-6">Pastikan akun Anda menggunakan password yang panjang dan acak untuk tetap aman</p>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('patch')

                    {{-- Current Password --}}
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-900 mb-2">Password Saat Ini <span class="text-red-600">*</span></label>
                        <input type="password" id="current_password" name="current_password" autocomplete="current-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-900 mb-2">Password Baru <span class="text-red-600">*</span></label>
                        <input type="password" id="password" name="password" autocomplete="new-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-900 mb-2">Konfirmasi Password Baru <span class="text-red-600">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('password_confirmation') border-red-500 @enderror">
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            {{-- Delete Account --}}
            <div id="delete" class="bg-white rounded-lg shadow-sm border border-red-100 p-6">
                <h2 class="text-lg font-semibold text-red-600 mb-2">Hapus Akun</h2>
                <p class="text-sm text-gray-600 mb-6">Hapus akun Anda secara permanen. Tindakan ini tidak dapat dibatalkan.</p>

                <form method="post" action="{{ route('profile.destroy') }}" class="space-y-6">
                    @csrf
                    @method('delete')

                    {{-- Confirmation Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-900 mb-2">Password <span class="text-red-600">*</span></label>
                        <input type="password" id="password_confirmation" name="password" autocomplete="current-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent @error('password') border-red-500 @enderror" placeholder="Masukkan password untuk konfirmasi">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('profile.show') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition" onclick="return confirm('Anda yakin? Akun Anda akan dihapus secara permanen.')">
                            Hapus Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>

@if($user->role === 'admin' || $user->role === 'organizer')
    </div>
</div>

@include('components.footer')
@endif
@endsection
