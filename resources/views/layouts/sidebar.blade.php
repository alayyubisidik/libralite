<div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-30 bg-gray-900/50 lg:hidden" @click="sidebarOpen = false"></div>

<aside
    class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col border-r border-gray-200 bg-white transition-transform duration-200 lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
>
    <!-- Brand -->
    <div class="flex h-16 shrink-0 items-center gap-2.5 border-b border-gray-200 px-6">
        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 text-base font-bold text-white">
            L
        </span>
        <span class="text-lg font-semibold tracking-tight text-blue-950">
            {{ config('app.name', 'LibraLite') }}
        </span>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
        <p class="px-3 pb-2 text-xs font-semibold uppercase tracking-wider text-gray-400">Menu</p>

        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition
                {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            Dashboard
        </a>
    </nav>

    <!-- Sidebar Footer -->
    <div class="shrink-0 border-t border-gray-200 px-6 py-4">
        <p class="text-xs text-gray-400">{{ config('app.name', 'LibraLite') }} v1.0</p>
    </div>
</aside>
