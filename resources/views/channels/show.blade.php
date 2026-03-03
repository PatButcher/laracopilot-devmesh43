@extends('layouts.app')
@section('title', $channel->name)
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <!-- Channel Header -->
    <div class="p-8 rounded-3xl border border-white/10 mb-8" style="background: linear-gradient(135deg, {{ $channel->color }}20, #1A1A2E);">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl" style="background: {{ $channel->color }}30;">📡</div>
            <div>
                <span class="text-sm capitalize mb-1 block" style="color: {{ $channel->color }};">{{ $channel->type }} channel</span>
                <h1 class="text-3xl font-bold text-white">{{ $channel->name }}</h1>
                @if($channel->description)<p class="text-gray-400 mt-1">{{ $channel->description }}</p>@endif
            </div>
        </div>
    </div>

    <!-- Channel Content -->
    @if($channel->type === 'tracks' && $items instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="space-y-2">
            @foreach($items as $track)
            <div class="group flex items-center space-x-4 p-4 rounded-2xl border border-transparent hover:border-white/10 transition cursor-pointer" style="background: #1A1A2E;" onclick="playTrack('{{ $track->audio_url }}', '{{ addslashes($track->title) }}', '{{ addslashes($track->artist?->name ?? 'Unknown') }}', '{{ $track->cover_url }}', {{ $track->id }})">
                <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0" style="background: rgba(139,92,246,0.2);">
                    @if($track->cover_image)<img src="{{ $track->cover_url }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center">🎵</div>@endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-white truncate">{{ $track->title }}</div>
                    <div class="text-sm text-gray-400">{{ $track->artist?->name ?? 'Unknown' }}</div>
                </div>
                <div class="text-sm text-gray-500">{{ $track->formatted_duration }}</div>
                <div class="text-xs text-gray-600">{{ number_format($track->play_count) }} ▶</div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $items->links() }}</div>
    @elseif($channel->type === 'albums')
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($items as $album)
            <a href="/albums/{{ $album->slug }}" class="group">
                <div class="w-full aspect-square rounded-xl overflow-hidden mb-2" style="background: linear-gradient(135deg, #2D1B69, #1A1A2E);">
                    @if($album->cover_image)<img src="{{ $album->cover_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">@else<div class="w-full h-full flex items-center justify-center text-4xl">💿</div>@endif
                </div>
                <div class="text-sm font-medium text-white truncate">{{ $album->title }}</div>
                <div class="text-xs text-gray-400">{{ $album->artist->name }}</div>
            </a>
            @endforeach
        </div>
    @elseif($channel->type === 'artists')
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($items as $artist)
            <a href="/artists/{{ $artist->slug }}" class="group text-center p-5 rounded-2xl border border-white/10 hover:border-white/25 transition" style="background: #1A1A2E;">
                <div class="w-16 h-16 rounded-full mx-auto mb-3 overflow-hidden" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">
                    @if($artist->image)<img src="{{ $artist->image_url }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center text-2xl">🎤</div>@endif
                </div>
                <div class="font-medium text-white text-sm truncate">{{ $artist->name }}</div>
                <div class="text-xs text-purple-400 mt-0.5">{{ $artist->tracks_count }} tracks</div>
            </a>
            @endforeach
        </div>
    @elseif($channel->type === 'genres')
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($items as $genre)
            <a href="/genres/{{ $genre->slug }}" class="p-5 rounded-2xl border border-white/10 hover:border-white/25 transition" style="background: {{ $genre->color }}15;">
                <div class="text-3xl mb-2">{{ $genre->icon }}</div>
                <div class="font-semibold text-white">{{ $genre->name }}</div>
                <div class="text-xs text-gray-400 mt-1">{{ $genre->tracks_count }} tracks</div>
            </a>
            @endforeach
        </div>
    @elseif($channel->type === 'playlists')
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($items as $playlist)
            <a href="/playlists/{{ $playlist->id }}" class="p-5 rounded-2xl border border-white/10 hover:border-white/25 transition" style="background: #1A1A2E;">
                <div class="text-2xl mb-2">📋</div>
                <div class="font-semibold text-white">{{ $playlist->name }}</div>
                <div class="text-xs text-gray-400 mt-1">by {{ $playlist->user->name }}</div>
            </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
