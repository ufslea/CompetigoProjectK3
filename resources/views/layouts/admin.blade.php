<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - CompetiGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FFF2EF;
        }
        .transition-base {
            transition: all 0.3s ease;
        }
        .shadow-soft {
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    {{-- Navbar --}}
    @include('components.navbar')

    <div class="flex flex-1">
        {{-- Sidebar Admin --}}
        @include('components.sidebar-admin')

        {{-- Main Content --}}
        <main class="flex-1 bg-[#FFF7F4] p-8 overflow-y-auto">
            {{-- Header Title --}}
            <div class="mb-6 border-b-2 border-indigo-200 pb-3 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-[#5D688A]">@yield('title', 'Dashboard Admin')</h1>
            </div>

            {{-- Konten Dinamis --}}
            <div class="bg-white rounded-xl p-6 shadow-soft">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Footer --}}
    @include('components.footer')

</body>
</html>

