<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SoundWave') - Stream Music</title>
    <meta name="description" content="@yield('meta_description', 'Stream, discover and share music on SoundWave.')">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#8B5CF6',
                        secondary: '#EC4899',
                        accent: '#06B6D4',
                        dark: '#0F0F1A',
                        'dark-card': '#1A1A2E',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #0F0F1A; color: #F9FAFB; font-family: 'Inter', system-ui, sans-serif; }
        .gradient-text { background: linear-gradient(135deg, #8B5CF6, #EC4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .glass { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); }
        .waveform-bar { display: inline-block; width: 3px; border-radius: 2px; background: #8B5CF6; animation: wave 1.2s ease-in-out infinite; }
        @keyframes wave { 0%, 100% { transform: scaleY(0.3); } 50% { transform: scaleY(1); } }
        .player-bar { background: linear-gradient(to right, #0F0F1A, #1A0A2E); }
        ::-webkit-scrollbar { width: 6px; } ::-webkit-scrollbar-track { background: #1A1A2E; } ::-webkit-scrollbar-thumb { background: #8B5CF6; border-radius: 3px; }
        .track-progress { -webkit-appearance: none; appearance: none; height: 4px; border-radius: 2px; background: #374151; outline: none; cursor: pointer; }
        .track-progress::-webkit-slider-thumb { -webkit-appearance: none; width: 14px; height: 14px; border-radius: 50%; background: #8B5CF6; cursor: pointer; }
        .nav-link { transition: color 0.2s; } .nav-link:hover { color: #8B5CF6; }
    </style>
    @stack('styles')
</head>
<body class="dark min-h-screen flex flex-col">

<!-- Navigation -->
<nav class="sticky top-0 z-50 border-b border-white/10" style="background: rgba(15,15,26,0.95); backdrop-filter: blur(20px);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">SW</div>
                <span class="font-bold text-xl gradient-text">SoundWave</span>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="/discover" class="nav-link text-gray-300 text-sm font-medium">Discover</a>
                <a href="/tracks" class="nav-link text-gray-300 text-sm font-medium">Tracks</a>
                <a href="/artists" class="nav-link text-gray-300 text-sm font-medium">Artists</a>
                <a href="/albums" class="nav-link text-gray-300 text-sm font-medium">Albums</a>
                <a href="/genres" class="nav-link text-gray-300 text-sm font-medium">Genres</a>
                <a href="/channels" class="nav-link text-gray-300 text-sm font-medium">Channels</a>
            </div>

            <!-- Search + Actions -->
            <div class="flex items-center space-x-3">
                <form action="/search" method="GET" class="hidden md:flex">
                    <input type="text" name="q" placeholder="Search music..." value="{{ request('q') }}" class="w-48 px-3 py-1.5 rounded-full text-sm bg-white/10 border border-white/20 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 transition-all">
                </form>
                @auth
                    <a href="/upload" class="hidden md:flex items-center px-3 py-1.5 rounded-full text-sm font-medium text-white transition-all" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">
                        <span class="mr-1">⬆</span> Upload
                    </a>
                    <div class="relative group">
                        <button class="flex items-center space-x-1 text-gray-300 text-sm">
                            <div class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center text-white text-xs font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                        </button>
                        <div class="absolute right-0 top-10 w-48 glass rounded-xl py-2 hidden group-hover:block shadow-2xl">
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10">👤 My Profile</a>
                            <a href="/my-tracks" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10">🎵 My Tracks</a>
                            <a href="/playlists" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10">📋 Playlists</a>
                            <a href="/favourites" class="block px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-white/10">❤️ Favourites</a>
                            <div class="border-t border-white/10 my-1"></div>
                            <form method="POST" action="/logout">
                                @csrf
                                <button class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-white/10">🚪 Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="/login" class="text-sm text-gray-300 hover:text-white transition">Login</a>
                    <a href="/register" class="px-4 py-1.5 rounded-full text-sm font-medium text-white transition" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Sign Up</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Flash Messages -->
@if(session('success'))
<div class="fixed top-20 right-4 z-50 bg-green-500/20 border border-green-500/50 text-green-300 px-6 py-3 rounded-xl text-sm" id="flash-msg">
    ✓ {{ session('success') }}
</div>
<script>setTimeout(() => { const m = document.getElementById('flash-msg'); if(m) m.remove(); }, 3000);</script>
@endif

<!-- Main Content -->
<main class="flex-1">
    @yield('content')
</main>

<!-- Persistent Audio Player -->
<div id="audio-player" class="fixed bottom-0 left-0 right-0 z-50 player-bar border-t border-white/10 py-3 px-4 hidden">
    <div class="max-w-7xl mx-auto flex items-center space-x-4">
        <!-- Cover -->
        <img id="player-cover" src="" alt="" class="w-12 h-12 rounded-lg object-cover flex-shrink-0" style="background: #1A1A2E;">
        <!-- Info -->
        <div class="flex-shrink-0 min-w-0" style="width: 180px;">
            <div id="player-title" class="text-sm font-semibold text-white truncate"></div>
            <div id="player-artist" class="text-xs text-gray-400 truncate"></div>
        </div>
        <!-- Controls -->
        <div class="flex items-center space-x-4 flex-shrink-0">
            <button onclick="skipBack()" class="text-gray-400 hover:text-white transition text-lg">⏮</button>
            <button id="play-pause-btn" onclick="togglePlay()" class="w-10 h-10 rounded-full flex items-center justify-center text-white text-lg" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">▶</button>
            <button onclick="skipForward()" class="text-gray-400 hover:text-white transition text-lg">⏭</button>
        </div>
        <!-- Progress -->
        <div class="flex items-center space-x-2 flex-1">
            <span id="current-time" class="text-xs text-gray-400 flex-shrink-0">0:00</span>
            <input type="range" id="progress-bar" class="track-progress flex-1" min="0" max="100" value="0" oninput="seekTo(this.value)">
            <span id="duration" class="text-xs text-gray-400 flex-shrink-0">0:00</span>
        </div>
        <!-- Volume -->
        <div class="hidden md:flex items-center space-x-2 flex-shrink-0">
            <span class="text-sm">🔊</span>
            <input type="range" class="track-progress w-20" min="0" max="100" value="80" oninput="setVolume(this.value/100)">
        </div>
        <button onclick="closePlayer()" class="text-gray-500 hover:text-white text-lg ml-2">✕</button>
    </div>
    <!-- Waveform Visualization -->
    <div class="max-w-7xl mx-auto mt-1 flex items-end space-x-0.5 h-6 overflow-hidden px-1" id="waveform-vis" style="width: 100%;">
    </div>
</div>

<audio id="global-audio" preload="none"></audio>

<!-- Footer -->
<footer class="border-t border-white/10 mt-16" style="background: #111827;">
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
            <div class="flex items-center space-x-2 mb-4">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">SW</div>
                <span class="font-bold text-xl gradient-text">SoundWave</span>
            </div>
            <p class="text-gray-400 text-sm">Stream, discover, and share music from independent artists worldwide.</p>
            <div class="flex space-x-3 mt-4">
                <span class="text-gray-400 hover:text-white cursor-pointer transition text-lg">🐦</span>
                <span class="text-gray-400 hover:text-white cursor-pointer transition text-lg">📘</span>
                <span class="text-gray-400 hover:text-white cursor-pointer transition text-lg">📷</span>
            </div>
        </div>
        <div>
            <h4 class="font-semibold text-white mb-4">Discover</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="/tracks" class="hover:text-white transition">All Tracks</a></li>
                <li><a href="/artists" class="hover:text-white transition">Artists</a></li>
                <li><a href="/albums" class="hover:text-white transition">Albums</a></li>
                <li><a href="/genres" class="hover:text-white transition">Genres</a></li>
                <li><a href="/channels" class="hover:text-white transition">Channels</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold text-white mb-4">Community</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="/register" class="hover:text-white transition">Join SoundWave</a></li>
                <li><a href="/upload" class="hover:text-white transition">Upload Music</a></li>
                <li><a href="/playlists" class="hover:text-white transition">Playlists</a></li>
                <li><a href="/favourites" class="hover:text-white transition">Favourites</a></li>
            </ul>
        </div>
        <div>
            <h4 class="font-semibold text-white mb-4">Company</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="#" class="hover:text-white transition">About Us</a></li>
                <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                <li><a href="#" class="hover:text-white transition">Contact</a></li>
                <li><a href="/admin/login" class="hover:text-white transition">Admin Panel</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-white/10 py-6 text-center text-sm text-gray-500">
        <p>© {{ date('Y') }} SoundWave. All rights reserved.</p>
        <p class="mt-1">Made with ❤️ by <a href="https://laracopilot.com/" target="_blank" class="text-purple-400 hover:underline">LaraCopilot</a></p>
    </div>
</footer>

<script>
let audio = document.getElementById('global-audio');
let isPlaying = false;
let currentTrackId = null;

function playTrack(url, title, artist, cover, trackId) {
    const player = document.getElementById('audio-player');
    player.classList.remove('hidden');
    document.getElementById('player-title').textContent = title;
    document.getElementById('player-artist').textContent = artist;
    const coverEl = document.getElementById('player-cover');
    coverEl.src = cover || '';
    coverEl.style.display = cover ? 'block' : 'none';
    audio.src = url;
    audio.play().then(() => {
        isPlaying = true;
        document.getElementById('play-pause-btn').textContent = '⏸';
        buildWaveform();
        if (trackId && trackId !== currentTrackId) {
            currentTrackId = trackId;
            fetch('/tracks/' + trackId + '/play', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]') ? document.querySelector('meta[name=csrf-token]').content : '' } });
        }
    }).catch(() => {});
}

function togglePlay() {
    if (audio.paused) {
        audio.play(); isPlaying = true;
        document.getElementById('play-pause-btn').textContent = '⏸';
    } else {
        audio.pause(); isPlaying = false;
        document.getElementById('play-pause-btn').textContent = '▶';
    }
}

function seekTo(val) {
    audio.currentTime = (val / 100) * audio.duration;
}

function setVolume(val) { audio.volume = val; }

function skipBack() { audio.currentTime = Math.max(0, audio.currentTime - 10); }
function skipForward() { audio.currentTime = Math.min(audio.duration, audio.currentTime + 10); }

function closePlayer() {
    audio.pause(); audio.src = '';
    document.getElementById('audio-player').classList.add('hidden');
    isPlaying = false;
}

function formatTime(s) {
    if (isNaN(s)) return '0:00';
    const m = Math.floor(s / 60);
    const sec = Math.floor(s % 60);
    return m + ':' + String(sec).padStart(2, '0');
}

audio.addEventListener('timeupdate', () => {
    const p = audio.duration ? (audio.currentTime / audio.duration) * 100 : 0;
    document.getElementById('progress-bar').value = p;
    document.getElementById('current-time').textContent = formatTime(audio.currentTime);
    document.getElementById('duration').textContent = formatTime(audio.duration);
});

audio.addEventListener('ended', () => {
    document.getElementById('play-pause-btn').textContent = '▶';
    isPlaying = false;
});

function buildWaveform() {
    const vis = document.getElementById('waveform-vis');
    vis.innerHTML = '';
    const count = 80;
    for (let i = 0; i < count; i++) {
        const bar = document.createElement('div');
        const h = Math.random() * 20 + 4;
        bar.style.cssText = `display:inline-block;width:3px;height:${h}px;border-radius:2px;background:#8B5CF6;margin:0 1px;animation:wave ${(0.8+Math.random()*0.8).toFixed(2)}s ease-in-out infinite;animation-delay:${(Math.random()*0.5).toFixed(2)}s;opacity:0.7;vertical-align:bottom;`;
        vis.appendChild(bar);
    }
}
</script>
<style>@keyframes wave{0%,100%{transform:scaleY(0.3)}50%{transform:scaleY(1)}}</style>
@stack('scripts')
</body>
</html>
