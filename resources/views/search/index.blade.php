@extends('layouts.app')
@section('title', $query ? "Search: $query" : 'Search')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <!-- Search Bar -->
    <form action="/search" method="GET" class="mb-10">
        <div class="relative">
            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 text-xl">🔍</span>
            <input type="text" name="q" value="{{ $query }}" autofocus placeholder="Search tracks, artists, albums, genres..."
                class="w-full pl-14 pr-6 py-5 rounded-2xl text-white placeholder-gray-500 focus:outline-none border transition text-xl"
                style="background: #1A1A2E; border-color: rgba(255,255,255,0.15); font-size: 1.1rem;">
        </div>
    </form>

    @if($query)
        @if($tracks->isEmpty() && $artists->isEmpty() && $albums->isEmpty() && $genres->isEmpty())
        <div class="text-center py-20">
            <div class="text-5xl mb-4">😔</div>
            <p class="text-white text-xl font-semibold mb-2">No results for "{{ $query }}"</p>
            <p class="text-gray-400">Try a different search term</p>
        </div>
        @endif

        @if($tracks->count())
        <section class="mb-10">
            <h2 class="text-xl font-bold text-white mb-4">🎵 Tracks</h2>
            <div class="space-y-2">
                @foreach($tracks as $track)
                <div class="group flex items-center gap-4 p-3 rounded-xl border border-transparent hover:border-white/10 transition cursor-pointer" style="background: #1A1A2E;" onclick="playTrack('{{ $track->audio_url }}', '{{ addslashes($track->title) }}', '{{ addslashes($track->artist?->name ?? 'Unknown') }}', '{{ $track->cover_url }}', {{ $track->id }})">
                    <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0" style="background: rgba(139,92,246,0.2);">
                        @if($track->cover_image)<img src="{{ $track->cover_url }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center">🎵</div>@endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-white truncate">{{ $track->title }}</div>
                        <div class="text-sm text-gray-400">{{ $track->artist?->name ?? 'Unknown' }}</div>
                    </div>
                    @if($track->genre)<span class="text-xs px-2 py-1 rounded-full hidden md:block" style="background: rgba(139,92,246,0.2); color: #A78BFA;">{{ $track->genre->name }}</span>@endif
                    <span class="text-sm text-gray-500">{{ $track->formatted_duration }}</span>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        @if($artists->count())
        <section class="mb-10">
            <h2 class="text-xl font-bold text-white mb-4">🎤 Artists</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($artists as $artist)
                <a href="/artists/{{ $artist->slug }}" class="group flex items-center gap-3 p-4 rounded-xl border border-white/10 hover:border-white/25 transition" style="background: #1A1A2E;">
                    <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">
                        @if($artist->image)<img src="{{ $artist->image_url }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center">🎤</div>@endif
                    </div>
                    <div class="min-w-0">
                        <div class="font-medium text-white truncate group-hover:text-purple-400 transition text-sm">{{ $artist->name }}</div>
                        @if($artist->country)<div class="text-xs text-gray-400">{{ $artist->country }}</div>@endif
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        @if($albums->count())
        <section class="mb-10">
            <h2 class="text-xl font-bold text-white mb-4">💿 Albums</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($albums as $album)
                <a href="/albums/{{ $album->slug }}" class="group">
                    <div class="w-full aspect-square rounded-xl overflow-hidden mb-2" style="background: linear-gradient(135deg, #2D1B69, #1A1A2E);">
                        @if($album->cover_image)<img src="{{ $album->cover_url }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center text-3xl">💿</div>@endif
                    </div>
                    <div class="text-sm font-medium text-white truncate group-hover:text-purple-400 transition">{{ $album->title }}</div>
                    <div class="text-xs text-gray-400">{{ $album->artist->name }}</div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

        @if($genres->count())
        <section>
            <h2 class="text-xl font-bold text-white mb-4">🎸 Genres</h2>
            <div class="flex flex-wrap gap-3">
                @foreach($genres as $genre)
                <a href="/genres/{{ $genre->slug }}" class="flex items-center gap-2 px-4 py-2 rounded-full border border-white/20 hover:border-white/40 transition" style="background: {{ $genre->color }}15;">
                    <span>{{ $genre->icon }}</span>
                    <span class="text-sm text-white">{{ $genre->name }}</span>
                </a>
                @endforeach
            </div>
        </section>
        @endif
    @else
    <div class="text-center py-16">
        <div class="text-6xl mb-4">🔍</div>
        <p class="text-gray-400 text-lg">Start typing to search for music</p>
    </div>
    @endif
</div>
@endsection
