<x-guest-layout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Header -->
            <div class="text-center mb-8">
                <a href="/" class="flex items-center justify-center mb-6">
                    <img src="{{ asset('images/logo.png') }}" alt="Competigo Logo" class="w-16 h-16">
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Masuk ke Competigo</h1>
                <p class="text-gray-600">Akses platform kompetisi online terpercaya</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" value="Email" class="text-gray-700 font-semibold" />
                        <x-text-input id="email" class="block mt-2 w-full px-4 py-3 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" value="Password" class="text-gray-700 font-semibold" />
                        <x-text-input id="password" class="block mt-2 w-full px-4 py-3 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <label for="remember_me" class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full mt-6 px-4 py-3 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold hover:shadow-lg transition duration-200 flex items-center justify-center">
                        Masuk
                    </button>
                </form>

                <!-- Forgot Password & Register Links -->
                <div class="mt-6 space-y-3">
                    @if (Route::has('password.request'))
                        <div class="text-center">
                            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                Lupa password?
                            </a>
                        </div>
                    @endif
                    
                    <div class="text-center pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600">Belum punya akun? 
                            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">
                                Daftar di sini
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="mt-8 text-center text-sm text-gray-600">
                <p>Dengan login, Anda menyetujui <a href="#" class="text-indigo-600 hover:text-indigo-700">Syarat & Ketentuan</a></p>
            </div>
        </div>
    </div>
</x-guest-layout>
