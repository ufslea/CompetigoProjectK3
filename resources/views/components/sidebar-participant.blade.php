<aside class="w-64 bg-white shadow-xl h-screen fixed top-0 left-0 pt-24 px-4 border-r">

    <h2 class="text-gray-700 text-sm font-semibold mb-4 uppercase">Participant Menu</h2>

    <ul class="space-y-2">

        <li>
            <a href="{{ route('participant.dashboard') }}"
               class="sidebar-item {{ request()->is('participant/dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('participant.competitions.index') }}"
               class="sidebar-item {{ request()->is('participant/competitions*') ? 'active' : '' }}">
                Lomba
            </a>
        </li>

        <li>
            <a href="{{ route('profile.show') }}"
               class="sidebar-item {{ request()->is('profile*') ? 'active' : '' }}">
                Profil
            </a>
        </li>

        <li>
            <a href="{{ route('participant.results.index') }}"
               class="sidebar-item {{ request()->is('participant/results*') ? 'active' : '' }}">
                Hasil & Sertifikat
            </a>
        </li>

        <li>
            <a href="{{ route('participant.notifications.index') }}"
               class="sidebar-item {{ request()->is('participant/notifications*') ? 'active' : '' }}">
                Notifikasi
            </a>
        </li>

        <li>
            <a href="{{ route('participant.reports.index') }}"
               class="sidebar-item {{ request()->is('participant/reports*') ? 'active' : '' }}">
                Laporan
            </a>
        </li>

    </ul>
</aside>

<style>
    .sidebar-item {
        @apply block px-4 py-2 text-gray-700 rounded-lg hover:bg-indigo-50 hover:text-indigo-600 transition font-medium;
    }
    .sidebar-item.active {
        @apply bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md;
    }
</style>

<div class="ml-64"></div>
