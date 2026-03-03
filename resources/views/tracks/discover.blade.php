@extends('layouts.app')
@section('title', 'Discover Music')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="mb-10">
        <h1 class="text-4xl font-bold text-white">🔍 Discover</h1>
        <p class="text-gray-400 mt-2 text-lg">Find your next favorite track</p>
    </div>

    <!-- Search Bar -->
    <form action="/search" method="GET" class="mb-12">
        <div class="relative max-w-2xl">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg">🔍</span>
            <input type="text" name="q" placeholder="Search tracks, artists, albums..." class="w-full pl-12 pr-4 py-4 rounded-2xl text-white placeholder-gray-500 focus:outline-none border transition text-lg"
                style="background: #1A1A2E; border-color: rgba(255,255,255,0.1);">
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 px-4 py-2 rounded-xl text-sm font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Search</button>
        </div>
    </form>

    <!-- Trending -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-white">🔥 Trending Now</h2>
            <a href="/tracks" class="text-sm text-purple-400">See all →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($trendingTracks->take(10) as $i => $track)
            <div class="group flex items-center space-x-4 p-4 rounded-2xl border border-transparent hover:border-white/10 transition cursor-pointer" style="background: #1A1A2E;" onclick="playTrack('{{ $track->audio_url }}', '{{ addslashes($track->title) }}', '{{ addslashes($track->artist?->name ?? 'Unknown') }}', '{{ $track->cover_url }}', {{ $track->id }})">
                <div class="w-8 text-center font-bold {{ $i < 3 ? 'text-yellow-400' : 'text-gray-600' }} flex-shrink-0">{{ $i + 1 }}</div>
                <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0" style="background: linear-gradient(135deg, #2D1B69, #1A1A2E);">
                    @if($track->cover_image)<img src="{{ $track->cover_url }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center">🎵</div>@endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-white truncate group-hover:text-purple-400 transition">{{ $track->title }}</div>
                    <div class="text-sm text-gray-400 truncate">{{ $track->artist?->name ?? 'Unknown' }}</div>
                </div>
                <div class="text-xs text-gray-500">{{ number_format($track->play_count) }} ▶</div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- New Releases -->
    <section class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-white">✨ New Releases</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($newReleases->take(10) as $track)
            <div class="group cursor-pointer" onclick="playTrack('{{ $track->audio_url }}', '{{ addslashes($track->title) }}', '{{ addslashes($track->artist?->name ?? 'Unknown') }}', '{{ $track->cover_url }}', {{ $track->id }})">
                <div class="relative mb-2">
                    <div class="w-full aspect-square rounded-xl overflow-hidden" style="background: linear-gradient(135deg, #2D1B69, #1A1A2E);">
                        @if($track->cover_image)<img src="{{ $track->cover_url }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center text-3xl">🎵</div>@endif
                    </div>
                    <div class="absolute inset-0 rounded-xl flex items-center justify-center opacity-0 group-hover:opacity-100 transition" style="background: rgba(0,0,0,0.5);">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white" style="background: rgba(139,92,246,0.9);">▶</div>
                    </div>
                </div>
                <div class="text-sm font-medium text-white truncate">{{ $track->title }}</div>
                <div class="text-xs text-gray-400 truncate">{{ $track->artist?->name ?? 'Unknown' }}</div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Genres -->
    <section>
        <h2 class="text-2xl font-bold text-white mb-6">🎸 Browse Genres</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
            @foreach($genres as $genre)
            <a href="/genres/{{ $genre->slug }}" class="p-4 rounded-2xl text-center hover:scale-105 transition-transform" style="background: {{ $genre->color }}22; border: 1px solid {{ $genre->color }}33;">
                <div class="text-3xl mb-1">{{ $genre->icon }}</div>
                <div class="text-sm font-medium text-white">{{ $genre->name }}</div>
                <div class="text-xs mt-0.5" style="color: {{ $genre->color }};">{{ $genre->tracks_count }}</div>
            </a>
            @endforeach
        </div>
    </section>
</div>
@endsection
