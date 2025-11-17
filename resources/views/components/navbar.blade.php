<nav class="w-full bg-white shadow-md fixed top-0 left-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" class="w-10" alt="Competigo Logo">
            <span class="text-xl font-bold text-indigo-700">Competigo</span>
        </a>

        {{-- User Nav --}}
        <div class="flex items-center gap-6">

            {{-- Role Badge --}}
            @auth
                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm capitalize">
                    {{ Auth::user()->role }}
                </span>
            @endauth

            {{-- Logout --}}
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        class="px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold hover:scale-105 transition">
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<div class="h-20"></div>
