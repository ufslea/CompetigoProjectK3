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

                @error('google')
                    <div class="mt-4 text-sm text-red-600">
                        {{ $message }}
                    </div>
                @enderror
                
                <p class="text-gray-600 text-center mb-5 mt-5">atau</p>

                <!-- Google Login Button -->
                <a href="{{ route('redirect.google') }}" class="w-full mt-4 px-4 py-3 rounded-lg bg-white border-2 border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Login dengan Google
                </a>
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
