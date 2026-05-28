<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') — Invitaciones Digitales</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#f0f4f8',
                            100: '#d9e2ec',
                            500: '#1e3a5f',
                            600: '#162d4a',
                            700: '#0e2035',
                            accent: '#c9a84c',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .sidebar-link { @apply flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors; }
        .sidebar-link:hover { @apply bg-white/10; }
        .sidebar-link.active { @apply bg-white/15 text-white; }
    </style>
</head>
<body class="h-full" x-data="{ sidebarOpen: false }">

<div class="flex h-full">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 transform transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           style="background-color: #1e3a5f">

        <!-- Logo -->
        <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-lg" style="background-color: #c9a84c">♥</div>
            <div>
                <p class="text-white font-bold text-sm leading-tight">Invitaciones</p>
                <p class="text-white/50 text-xs">Panel Admin</p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="px-3 py-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link text-white/80 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.events.index') }}"
               class="sidebar-link text-white/80 {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Eventos
            </a>

            <a href="{{ route('admin.themes.index') }}"
               class="sidebar-link text-white/80 {{ request()->routeIs('admin.themes.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
                Temas
            </a>
        </nav>

        <!-- User -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/10">
            <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 mb-3 hover:opacity-80 transition-opacity">
                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-white text-sm font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-white/50 text-xs truncate">{{ auth()->user()->email }}</p>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left sidebar-link text-white/60 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- Backdrop mobile -->
    <div class="fixed inset-0 z-40 bg-black/50 lg:hidden"
         x-show="sidebarOpen"
         @click="sidebarOpen = false"
         x-cloak></div>

    <!-- Main -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Top bar -->
        <header class="bg-white border-b border-gray-200 px-4 py-3 flex items-center gap-4">
            <button class="lg:hidden p-1 rounded text-gray-500 hover:text-gray-700" @click="sidebarOpen = !sidebarOpen">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <h1 class="text-lg font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
            <div class="ml-auto flex items-center gap-3">
                @yield('header-actions')
            </div>
        </header>

        <!-- Flash messages -->
        <div class="px-6 pt-4">
            @if(session('success'))
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 rounded-lg px-4 py-3 text-green-800 text-sm mb-2">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="flex items-center gap-3 bg-red-50 border border-red-200 rounded-lg px-4 py-3 text-red-800 text-sm mb-2">
                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
            @endif
        </div>

        <!-- Page content -->
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
