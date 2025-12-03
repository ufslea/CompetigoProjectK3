<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <a href="/" class="flex items-center justify-center mb-6">
                    <img src="{{ asset('images/logo.png') }}" alt="Competigo Logo" class="w-16 h-16">
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Competigo</h1>
                <p class="text-gray-600">Daftar untuk mulai mengikuti atau mengelola kompetisi</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    {{-- Nama --}}
                    <div>
                        <x-input-label for="nama" value="Nama Lengkap" class="text-gray-700 font-semibold" />
                        <x-text-input id="nama" class="block mt-2 w-full px-4 py-3 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500"
                            type="text" name="nama" value="{{ old('nama') }}" required autofocus placeholder="Masukkan nama lengkap" />
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <x-input-label for="email" value="Email" class="text-gray-700 font-semibold" />
                        <x-text-input id="email" class="block mt-2 w-full px-4 py-3 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500"
                            type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Role --}}
                    <div>
                        <x-input-label for="role" value="Daftar Sebagai" class="text-gray-700 font-semibold" />
                        <select id="role" name="role" class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 bg-white">
                            <option value="participant" {{ old('role') == 'participant' ? 'selected' : '' }}>Peserta</option>
                            <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }}>Organizer</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    {{-- No HP --}}
                    <div>
                        <x-input-label for="no_hp" value="Nomor HP (Opsional)" class="text-gray-700 font-semibold" />
                        <x-text-input id="no_hp" class="block mt-2 w-full px-4 py-3 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500"
                            type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx" />
                        <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                    </div>

                    {{-- Institusi --}}
                    <div>
                        <x-input-label for="institusi" value="Institusi (Opsional)" class="text-gray-700 font-semibold" />
                        <x-text-input id="institusi" class="block mt-2 w-full px-4 py-3 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500"
                            type="text" name="institusi" value="{{ old('institusi') }}" placeholder="Universitas/Sekolah" />
                        <x-input-error :messages="$errors->get('institusi')" class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <x-input-label for="password" value="Password" class="text-gray-700 font-semibold" />
                        <x-text-input id="password" class="block mt-2 w-full px-4 py-3 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500"
                            type="password" name="password" required placeholder="Minimal 8 karakter" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-gray-700 font-semibold" />
                        <x-text-input id="password_confirmation" class="block mt-2 w-full px-4 py-3 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500"
                            type="password" name="password_confirmation" required placeholder="Konfirmasi password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="w-full mt-6 px-4 py-3 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold hover:shadow-lg transition duration-200 flex items-center justify-center">
                        Daftar
                    </button>
                </form>

                {{-- Login Link --}}
                <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600">Sudah punya akun? 
                        <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="mt-8 text-center text-sm text-gray-600">
                <p>Dengan mendaftar, Anda menyetujui <a href="#" class="text-indigo-600 hover:text-indigo-700">Syarat & Ketentuan</a></p>
            </div>
        </div>
    </div>
</x-guest-layout>
