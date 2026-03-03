<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - SoundWave Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0F0F1A; color: #F9FAFB; font-family: 'Inter', system-ui, sans-serif; }
        .sidebar-link { display: flex; align-items: center; padding: 0.6rem 1rem; border-radius: 0.5rem; font-size: 0.875rem; color: #9CA3AF; transition: all 0.2s; margin-bottom: 2px; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(139,92,246,0.15); color: #A78BFA; }
        .gradient-text { background: linear-gradient(135deg, #8B5CF6, #EC4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        ::-webkit-scrollbar { width: 4px; } ::-webkit-scrollbar-thumb { background: #8B5CF6; border-radius: 2px; }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

<!-- Sidebar -->
<div class="w-64 flex-shrink-0 flex flex-col border-r border-white/10 overflow-y-auto" style="background: #1A1A2E;">
    <div class="p-4 border-b border-white/10">
        <a href="/" class="flex items-center space-x-2">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">SW</div>
            <span class="font-bold gradient-text">SoundWave</span>
        </a>
        <div class="mt-2 text-xs text-gray-500">Admin Panel · {{ session('admin_user', 'admin') }}</div>
    </div>

    <nav class="flex-1 p-3">
        <div class="text-xs text-gray-600 uppercase tracking-wider mb-2 px-2">Overview</div>
        <a href="/admin/dashboard" class="sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"><span class="mr-2">📊</span> Dashboard</a>

        <div class="text-xs text-gray-600 uppercase tracking-wider mb-2 mt-4 px-2">Music</div>
        <a href="/admin/tracks" class="sidebar-link {{ request()->is('admin/tracks*') ? 'active' : '' }}"><span class="mr-2">🎵</span> Tracks</a>
        <a href="/admin/artists" class="sidebar-link {{ request()->is('admin/artists*') ? 'active' : '' }}"><span class="mr-2">🎤</span> Artists</a>
        <a href="/admin/albums" class="sidebar-link {{ request()->is('admin/albums*') ? 'active' : '' }}"><span class="mr-2">💿</span> Albums</a>
        <a href="/admin/genres" class="sidebar-link {{ request()->is('admin/genres*') ? 'active' : '' }}"><span class="mr-2">🎸</span> Genres</a>
        <a href="/admin/playlists" class="sidebar-link {{ request()->is('admin/playlists*') ? 'active' : '' }}"><span class="mr-2">📋</span> Playlists</a>

        <div class="text-xs text-gray-600 uppercase tracking-wider mb-2 mt-4 px-2">Discovery</div>
        <a href="/admin/channels" class="sidebar-link {{ request()->is('admin/channels*') ? 'active' : '' }}"><span class="mr-2">📡</span> Channels</a>

        <div class="text-xs text-gray-600 uppercase tracking-wider mb-2 mt-4 px-2">Platform</div>
        <a href="/admin/users" class="sidebar-link {{ request()->is('admin/users*') ? 'active' : '' }}"><span class="mr-2">👥</span> Users</a>
        <a href="/admin/landing-page" class="sidebar-link {{ request()->is('admin/landing*') ? 'active' : '' }}"><span class="mr-2">🏠</span> Landing Page</a>
        <a href="/admin/theme" class="sidebar-link {{ request()->is('admin/theme*') ? 'active' : '' }}"><span class="mr-2">🎨</span> Theme & Colors</a>
        <a href="/admin/menu" class="sidebar-link {{ request()->is('admin/menu*') ? 'active' : '' }}"><span class="mr-2">📌</span> Menu Manager</a>
        <a href="/admin/metadata" class="sidebar-link {{ request()->is('admin/metadata*') ? 'active' : '' }}"><span class="mr-2">🔖</span> Metadata</a>
    </nav>

    <div class="p-3 border-t border-white/10">
        <a href="/" class="sidebar-link"><span class="mr-2">🌐</span> View Site</a>
        <form method="POST" action="/admin/logout">
            @csrf
            <button class="sidebar-link w-full text-left text-red-400 hover:bg-red-500/10"><span class="mr-2">🚪</span> Logout</button>
        </form>
    </div>
</div>

<!-- Main Content -->
<div class="flex-1 flex flex-col overflow-hidden">
    <!-- Top Bar -->
    <header class="flex-shrink-0 h-14 border-b border-white/10 flex items-center justify-between px-6" style="background: rgba(26,26,46,0.8);">
        <h1 class="font-semibold text-white">@yield('page-title', 'Dashboard')</h1>
        <div class="flex items-center space-x-3">
            <a href="/" class="text-sm text-gray-400 hover:text-white transition">← View Site</a>
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">{{ strtoupper(substr(session('admin_user', 'A'), 0, 2)) }}</div>
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="mx-6 mt-4 bg-green-500/20 border border-green-500/40 text-green-300 px-4 py-3 rounded-lg text-sm">✓ {{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="mx-6 mt-4 bg-red-500/20 border border-red-500/40 text-red-300 px-4 py-3 rounded-lg text-sm">
        @foreach($errors->all() as $error)<div>✗ {{ $error }}</div>@endforeach
    </div>
    @endif

    <!-- Page Content -->
    <main class="flex-1 overflow-y-auto p-6">
        @yield('content')
    </main>
</div>

</body>
</html>
