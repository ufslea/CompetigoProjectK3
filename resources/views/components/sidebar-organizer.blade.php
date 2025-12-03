<aside class="w-64 bg-white shadow-xl h-screen fixed top-0 left-0 pt-24 px-4 border-r overflow-y-auto">

    <h2 class="text-gray-700 text-sm font-semibold mb-4 uppercase">Organizer Menu</h2>

    <ul class="space-y-2">

        <li>
            <a href="{{ route('organizer.dashboard') }}"
               class="sidebar-item {{ request()->is('organizer/dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('organizer.events.index') }}"
               class="sidebar-item {{ request()->is('organizer/events*') ? 'active' : '' }}">
                Event
            </a>
        </li>

        <li>
            <a href="{{ route('organizer.participants.index') }}"
               class="sidebar-item {{ request()->is('organizer/participants*') ? 'active' : '' }}">
                Peserta
            </a>
        </li>

        <li>
            <a href="{{ route('organizer.announcements.index') }}"
               class="sidebar-item {{ request()->is('organizer/announcements*') ? 'active' : '' }}">
                Pengumuman
            </a>
        </li>

        <li>
            <a href="{{ route('organizer.results.index') }}"
               class="sidebar-item {{ request()->is('organizer/results*') ? 'active' : '' }}">
                Hasil Lomba
            </a>
        </li>

        <li>
            <a href="{{ route('profile.show') }}"
               class="sidebar-item {{ request()->is('profile*') ? 'active' : '' }}">
                Profil
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
