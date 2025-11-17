<aside class="w-64 bg-white shadow-xl h-screen fixed top-0 left-0 pt-24 px-4 border-r overflow-y-auto">

    <h2 class="text-gray-700 text-sm font-semibold mb-4 uppercase">Admin Menu</h2>

    <ul class="space-y-2">

        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>

        {{-- Users --}}
        <li>
            <a href="{{ route('admin.users.index') }}"
               class="sidebar-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                Kelola User
            </a>
        </li>

        {{-- Events Verification --}}
        <li>
            <a href="{{ route('admin.events.index') }}"
               class="sidebar-item {{ request()->is('admin/events*') ? 'active' : '' }}">
                Verifikasi Event
            </a>
        </li>

        {{-- Announcements --}}
        <li>
            <a href="{{ route('admin.announcements.index') }}"
               class="sidebar-item {{ request()->is('admin/announcements*') ? 'active' : '' }}">
                Pengumuman
            </a>
        </li>

        {{-- Results --}}
        <li>
            <a href="{{ route('admin.results.index') }}"
               class="sidebar-item {{ request()->is('admin/results*') ? 'active' : '' }}">
                Hasil Lomba
            </a>
        </li>

        {{-- Reports --}}
        <li>
            <a href="{{ route('admin.reports.index') }}"
               class="sidebar-item {{ request()->is('admin/reports*') ? 'active' : '' }}">
                Laporan
            </a>
        </li>

        {{-- Profile --}}
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
