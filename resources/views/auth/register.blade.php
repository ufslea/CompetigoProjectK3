<x-guest-layout>

    <div class="text-center mb-8">
        <img src="{{ asset('images/logo.png') }}" alt="Competigo Logo" class="mx-auto w-24 mb-4">
        <h1 class="text-3xl font-bold text-gray-800">Buat Akun Competigo</h1>
        <p class="text-gray-500 mt-1">Daftar untuk mulai mengikuti atau mengelola kompetisi.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <x-input-label for="nama" value="Nama Lengkap" />
            <x-text-input id="nama" class="block mt-1 w-full"
                type="text" name="nama" value="{{ old('nama') }}" required autofocus />
            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full"
                type="email" name="email" value="{{ old('email') }}" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Role --}}
        <div>
            <x-input-label for="role" value="Daftar Sebagai" />
             <select id="role" name="role"
                class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                <option value="participant" {{ old('role') == 'participant' ? 'selected' : '' }}>Peserta</option>
                <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }}>Organizer</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        {{-- No HP --}}
        <div>
            <x-input-label for="no_hp" value="Nomor HP (Opsional)" />
            <x-text-input id="no_hp" class="block mt-1 w-full"
                type="text" name="no_hp" value="{{ old('no_hp') }}" />
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
        </div>

        {{-- Institusi --}}
        <div>
            <x-input-label for="institusi" value="Institusi (Opsional)" />
            <x-text-input id="institusi" class="block mt-1 w-full"
                type="text" name="institusi" value="{{ old('institusi') }}" />
            <x-input-error :messages="$errors->get('institusi')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirm --}}
        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Tombol --}}
        <div class="flex items-center justify-between pt-4">
            <a class="text-sm text-gray-600 hover:text-indigo-600"
               href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <x-primary-button>
                Daftar
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>
