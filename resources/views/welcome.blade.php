@extends('layouts.app')

@section('title', 'SoundWave - Stream. Discover. Share.')

@section('content')

<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden" style="background: linear-gradient(135deg, #0F0F1A 0%, #1A0A2E 50%, #0A1628 100%);">
    <!-- Animated background circles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 rounded-full opacity-10" style="background: radial-gradient(circle, #8B5CF6, transparent); animation: pulse 4s ease-in-out infinite;"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 rounded-full opacity-10" style="background: radial-gradient(circle, #EC4899, transparent); animation: pulse 4s ease-in-out infinite 2s;"></div>
        <div class="absolute top-3/4 left-1/2 w-64 h-64 rounded-full opacity-5" style="background: radial-gradient(circle, #06B6D4, transparent); animation: pulse 4s ease-in-out infinite 1s;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 py-24 text-center">
        <!-- Badge -->
        <div class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-medium mb-6 border" style="background: rgba(139,92,246,0.15); border-color: rgba(139,92,246,0.4); color: #A78BFA;">
            <span class="w-2 h-2 rounded-full bg-purple-400 mr-2 animate-pulse"></span>
            Now Streaming — Independent Artists Worldwide
        </div>

        <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
            Stream Music,
            <span class="block" style="background: linear-gradient(135deg, #8B5CF6, #EC4899, #06B6D4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Discover Artists</span>
        </h1>
        <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed">
            Explore millions of tracks from independent artists around the world. Upload, share, and discover music like never before.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
            <a href="/discover" class="px-8 py-4 rounded-full font-semibold text-white text-lg transition-transform hover:scale-105" style="background: linear-gradient(135deg, #8B5CF6, #EC4899); box-shadow: 0 0 40px rgba(139,92,246,0.4);">
                🎵 Start Listening
            </a>
            @guest
            <a href="/register" class="px-8 py-4 rounded-full font-semibold text-white text-lg border border-white/30 hover:border-white/60 transition-all backdrop-blur-sm">
                ✨ Join Free
            </a>
            @else
            <a href="/upload" class="px-8 py-4 rounded-full font-semibold text-white text-lg border border-white/30 hover:border-white/60 transition-all">
                ⬆ Upload Track
            </a>
            @endguest
        </div>

        <!-- Live Waveform Demo -->
        <div class="flex items-end justify-center space-x-1 h-12 mb-4">
            @for($i = 0; $i < 40; $i++)
                <div style="width: 4px; height: {{ rand(8, 44) }}px; background: linear-gradient(to top, #8B5CF6, #EC4899); border-radius: 2px; animation: wave {{ number_format(0.6 + fmod($i * 0.05, 0.8), 2) }}s ease-in-out infinite alternate; animation-delay: {{ number_format(fmod($i * 0.04, 0.5), 2) }}s; opacity: 0.8;"></div>
            @endfor
        </div>
        <p class="text-xs text-gray-500">Live audio visualization</p>

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-8 max-w-md mx-auto mt-16">
            <div class="text-center">
                <div class="text-3xl font-bold text-white">{{ \App\Models\Track::where('is_published',true)->count() }}+</div>
                <div class="text-sm text-gray-400 mt-1">Tracks</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white">{{ \App\Models\Artist::count() }}+</div>
                <div class="text-sm text-gray-400 mt-1">Artists</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white">{{ \App\Models\Genre::count() }}</div>
                <div class="text-sm text-gray-400 mt-1">Genres</div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-24" style="background: #111827;">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white mb-4">Everything You Need</h2>
            <p class="text-gray-400 text-lg">A complete music platform built for artists and listeners</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['icon' => '🎵', 'title' => 'High Quality Audio', 'desc' => 'Stream in crystal-clear quality up to FLAC lossless audio with zero compression artifacts.', 'color' => '#8B5CF6'],
                ['icon' => '〰️', 'title' => 'Waveform Player', 'desc' => 'Interactive waveform visualization for the ultimate listening experience with precise seeking.', 'color' => '#EC4899'],
                ['icon' => '📋', 'title' => 'Smart Playlists', 'desc' => 'Create, curate, and share playlists with the community. Keep your music organized your way.', 'color' => '#06B6D4'],
                ['icon' => '🎤', 'title' => 'Artist Tools', 'desc' => 'Upload tracks, manage your profile, track play counts, and grow your dedicated audience.', 'color' => '#10B981'],
            ] as $feature)
            <div class="p-6 rounded-2xl border border-white/10 hover:border-white/20 transition-all group" style="background: #1A1A2E;">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-4" style="background: {{ $feature['color'] }}22; border: 1px solid {{ $feature['color'] }}44;">{{ $feature['icon'] }}</div>
                <h3 class="font-semibold text-white mb-2">{{ $feature['title'] }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Tracks -->
@if($featuredTracks->count())
<section class="py-20" style="background: #0F0F1A;">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-bold text-white">🔥 Trending Tracks</h2>
                <p class="text-gray-400 mt-1">Most played right now</p>
            </div>
            <a href="/tracks" class="text-sm text-purple-400 hover:text-purple-300 transition">View all →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($featuredTracks->take(8) as $track)
            <div class="group p-4 rounded-2xl border border-white/10 hover:border-purple-500/40 transition-all cursor-pointer" style="background: #1A1A2E;" onclick="playTrack('{{ $track->audio_url }}', '{{ addslashes($track->title) }}', '{{ addslashes($track->artist?->name ?? 'Unknown') }}', '{{ $track->cover_url }}', {{ $track->id }})">
                <div class="relative mb-3">
                    <div class="w-full aspect-square rounded-xl overflow-hidden" style="background: linear-gradient(135deg, #1A1A2E, #2D1B69);">
                        @if($track->cover_image)
                        <img src="{{ $track->cover_url }}" alt="{{ $track->title }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-4xl">🎵</div>
                        @endif
                    </div>
                    <div class="absolute inset-0 rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all" style="background: rgba(0,0,0,0.5);">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-white text-xl" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">▶</div>
                    </div>
                </div>
                <div class="truncate font-semibold text-white text-sm">{{ $track->title }}</div>
                <div class="truncate text-gray-400 text-xs mt-1">{{ $track->artist?->name ?? 'Unknown Artist' }}</div>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-xs text-gray-500">{{ number_format($track->play_count) }} plays</span>
                    @if($track->genre)<span class="text-xs px-2 py-0.5 rounded-full" style="background: rgba(139,92,246,0.2); color: #A78BFA;">{{ $track->genre->name }}</span>@endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Featured Artists -->
@if($featuredArtists->count())
<section class="py-20" style="background: #111827;">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-bold text-white">🎤 Featured Artists</h2>
                <p class="text-gray-400 mt-1">Discover talented musicians</p>
            </div>
            <a href="/artists" class="text-sm text-purple-400 hover:text-purple-300 transition">View all →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($featuredArtists->take(6) as $artist)
            <a href="/artists/{{ $artist->slug }}" class="group text-center p-4 rounded-2xl border border-white/10 hover:border-purple-500/40 transition-all" style="background: #1A1A2E;">
                <div class="w-16 h-16 rounded-full mx-auto mb-3 overflow-hidden" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">
                    @if($artist->image)
                    <img src="{{ $artist->image_url }}" alt="{{ $artist->name }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-2xl">🎤</div>
                    @endif
                </div>
                <div class="font-semibold text-white text-sm truncate">{{ $artist->name }}</div>
                <div class="text-xs text-gray-400 mt-0.5">{{ $artist->tracks_count }} tracks</div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Genres -->
@if($genres->count())
<section class="py-20" style="background: #0F0F1A;">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-bold text-white">🎸 Browse by Genre</h2>
                <p class="text-gray-400 mt-1">Find music in your favorite style</p>
            </div>
            <a href="/genres" class="text-sm text-purple-400 hover:text-purple-300 transition">All genres →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
            @foreach($genres->take(12) as $genre)
            <a href="/genres/{{ $genre->slug }}" class="group flex flex-col items-center p-4 rounded-2xl border border-white/10 hover:border-white/30 transition-all text-center" style="background: #1A1A2E;">
                <div class="text-3xl mb-2">{{ $genre->icon }}</div>
                <div class="font-medium text-white text-sm">{{ $genre->name }}</div>
                <div class="text-xs text-gray-500 mt-0.5">{{ $genre->tracks_count }} tracks</div>
                <div class="w-full h-1 rounded-full mt-2" style="background: {{ $genre->color }}44;"><div class="h-full rounded-full" style="background: {{ $genre->color }}; width: 100%;"></div></div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Channels -->
@if($channels->count())
<section class="py-20" style="background: #111827;">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-bold text-white">📡 Channels</h2>
                <p class="text-gray-400 mt-1">Curated collections for every mood</p>
            </div>
            <a href="/channels" class="text-sm text-purple-400 hover:text-purple-300 transition">All channels →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($channels as $channel)
            <a href="/channels/{{ $channel->slug }}" class="group p-6 rounded-2xl border border-white/10 hover:border-white/30 transition-all" style="background: linear-gradient(135deg, {{ $channel->color }}22, #1A1A2E);">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: {{ $channel->color }}33;">📡</div>
                    <div>
                        <div class="font-semibold text-white">{{ $channel->name }}</div>
                        <div class="text-xs capitalize" style="color: {{ $channel->color }};">{{ $channel->type }}</div>
                    </div>
                </div>
                @if($channel->description)<p class="text-sm text-gray-400">{{ $channel->description }}</p>@endif
                <div class="mt-3 text-xs text-gray-500 group-hover:text-purple-400 transition">Explore channel →</div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-24" style="background: linear-gradient(135deg, #1A0A2E, #0A1628);">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Ready to Share Your Music?</h2>
        <p class="text-gray-300 text-lg mb-10">Join thousands of independent artists already sharing their sound on SoundWave.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            @guest
            <a href="/register" class="px-8 py-4 rounded-full font-bold text-white text-lg transition-transform hover:scale-105" style="background: linear-gradient(135deg, #8B5CF6, #EC4899); box-shadow: 0 0 40px rgba(139,92,246,0.4);">Create Free Account</a>
            <a href="/discover" class="px-8 py-4 rounded-full font-semibold text-white text-lg border border-white/30 hover:border-white/60 transition-all">Explore Music</a>
            @else
            <a href="/upload" class="px-8 py-4 rounded-full font-bold text-white text-lg transition-transform hover:scale-105" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Upload Your Track</a>
            <a href="/discover" class="px-8 py-4 rounded-full font-semibold text-white text-lg border border-white/30 hover:border-white/60 transition-all">Discover Music</a>
            @endguest
        </div>
    </div>
</section>

@push('styles')
<style>@keyframes pulse{0%,100%{transform:scale(1);opacity:0.1}50%{transform:scale(1.2);opacity:0.15}}</style>
@endpush

@endsection
