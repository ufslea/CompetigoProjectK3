<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Competigo - Platform Kompetisi Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hover-scale {
            transition: transform 0.3s ease;
        }
        .hover-scale:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-white text-gray-900">

    {{-- Navbar --}}
    <nav class="w-full bg-white shadow-sm fixed top-0 left-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" class="w-10" alt="Competigo Logo">
                <span class="text-2xl font-bold gradient-text">Competigo</span>
            </a>

            {{-- Auth Buttons --}}
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('login') }}"
                    " class="px-4 py-2 text-indigo-600 hover:text-indigo-700 font-semibold transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold hover:shadow-lg transition hover-scale">
                        Daftar
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2 text-indigo-600 hover:text-indigo-700 font-semibold transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold hover:shadow-lg transition hover-scale">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="pt-32 pb-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                {{-- Left Content --}}
                <div class="space-y-6">
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight">
                        Platform Kompetisi
                        <span class="gradient-text"> Online Terpercaya</span>
                    </h1>
                    <p class="text-xl text-gray-600 leading-relaxed">
                        Bergabunglah dengan ribuan peserta dalam kompetisi online terbaik. Tunjukkan kemampuan Anda, raih prestasi, dan dapatkan sertifikat resmi.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        @auth
                            <a href="{{ route('register') }}" class="px-8 py-4 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold hover:shadow-lg transition hover-scale text-center">
                                Daftar Sekarang
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="px-8 py-4 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold hover:shadow-lg transition hover-scale text-center">
                                Daftar Sekarang
                            </a>
                            <a href="{{ route('login') }}" class="px-8 py-4 rounded-lg border-2 border-indigo-600 text-indigo-600 font-semibold hover:bg-indigo-50 transition text-center">
                                Login
                            </a>
                        @endauth
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-4 pt-8">
                        <div>
                            <p class="text-3xl font-bold text-indigo-600">1000+</p>
                            <p class="text-gray-600 text-sm">Peserta Aktif</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-indigo-600">50+</p>
                            <p class="text-gray-600 text-sm">Kompetisi</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-indigo-600">100%</p>
                            <p class="text-gray-600 text-sm">Aman</p>
                        </div>
                    </div>
                </div>

                {{-- Right Image --}}
                <div class="hidden md:flex items-center justify-center">
                    <div class="relative w-full">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/20 to-purple-500/20 rounded-3xl blur-3xl"></div>
                        <div class="relative bg-gradient-to-br from-indigo-100 to-purple-100 rounded-3xl p-12 text-center">
                            <div class="text-6xl mb-4">🏆</div>
                            <h3 class="text-2xl font-bold text-indigo-900 mb-2">Raih Prestasi Terbaik</h3>
                            <p class="text-indigo-700">Kompetisi fair dengan penilai profesional dan sertifikat terpercaya</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="py-20 px-6 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">Mengapa Memilih Competigo?</h2>
                <p class="text-lg text-gray-600">Platform kompetisi dengan fitur lengkap dan mudah digunakan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg transition hover-scale">
                    <div class="text-4xl mb-4">📋</div>
                    <h3 class="text-xl font-bold mb-2">Berbagai Kompetisi</h3>
                    <p class="text-gray-600">Pilih dari berbagai kategori kompetisi sesuai dengan minat dan kemampuan Anda</p>
                </div>

                {{-- Feature 2 --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg transition hover-scale">
                    <div class="text-4xl mb-4">✅</div>
                    <h3 class="text-xl font-bold mb-2">Hasil & Sertifikat</h3>
                    <p class="text-gray-600">Dapatkan sertifikat resmi untuk setiap kompetisi yang Anda menangkan</p>
                </div>

                {{-- Feature 3 --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg transition hover-scale">
                    <div class="text-4xl mb-4">👥</div>
                    <h3 class="text-xl font-bold mb-2">Komunitas Aktif</h3>
                    <p class="text-gray-600">Bergabung dengan komunitas peserta dan organizer yang berpengalaman</p>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">Cara Kerja Competigo</h2>
                <p class="text-lg text-gray-600">Tiga langkah mudah untuk memulai perjalanan kompetisi Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Step 1 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        1
                    </div>
                    <h3 class="text-xl font-bold mb-2">Daftar & Buat Akun</h3>
                    <p class="text-gray-600">Daftar dengan mudah dan buat profil Anda di Competigo</p>
                </div>

                {{-- Step 2 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        2
                    </div>
                    <h3 class="text-xl font-bold mb-2">Pilih Kompetisi</h3>
                    <p class="text-gray-600">Jelajahi berbagai kompetisi dan daftar yang Anda minati</p>
                </div>

                {{-- Step 3 --}}
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-2xl font-bold">
                        3
                    </div>
                    <h3 class="text-xl font-bold mb-2">Kirim & Menang</h3>
                    <p class="text-gray-600">Kirimkan karya Anda dan dapatkan hadiah serta sertifikat</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 px-6 bg-gradient-to-r from-indigo-600 to-purple-600">
        <div class="max-w-4xl mx-auto text-center text-white">
            <h2 class="text-4xl font-bold mb-4">Siap Memulai Perjalanan Anda?</h2>
            <p class="text-lg mb-8 opacity-90">Bergabunglah dengan ribuan peserta lain dan tunjukkan kemampuan terbaik Anda</p>
            
            @auth
                <a href="
                    @if (Auth::user()->role === 'participant')
                        {{ route('participant.competitions.index') }}
                    @elseif (Auth::user()->role === 'organizer')
                        {{ route('organizer.events.index') }}
                    @elseif (Auth::user()->role === 'admin')
                        {{ route('admin.dashboard') }}
                    @endif
                " class="inline-block px-8 py-4 rounded-lg bg-white text-indigo-600 font-semibold hover:shadow-lg transition hover-scale">
                    Mulai Sekarang
                </a>
            @else
                <a href="{{ route('register') }}" class="inline-block px-8 py-4 rounded-lg bg-white text-indigo-600 font-semibold hover:shadow-lg transition hover-scale">
                    Daftar Gratis Sekarang
                </a>
            @endauth
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white py-12 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                {{-- About --}}
                <div>
                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" class="w-8" alt="Competigo">
                        Competigo
                    </h3>
                    <p class="text-gray-400 text-sm">Platform kompetisi online terpercaya dengan ribuan peserta</p>
                </div>

                {{-- Links --}}
                <div>
                    <h4 class="font-bold mb-4">Platform</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition">Kompetisi</a></li>
                        <li><a href="#" class="hover:text-white transition">Peserta</a></li>
                    </ul>
                </div>

                {{-- Support --}}
                <div>
                    <h4 class="font-bold mb-4">Bantuan</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition">Kontak</a></li>
                        <li><a href="#" class="hover:text-white transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                {{-- Social --}}
                <div>
                    <h4 class="font-bold mb-4">Ikuti Kami</h4>
                    <div class="flex gap-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">Facebook</a>
                        <a href="#" class="text-gray-400 hover:text-white transition">Instagram</a>
                        <a href="#" class="text-gray-400 hover:text-white transition">Twitter</a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2025 Competigo. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

</body>
</html>
