@extends('layouts.app')
@section('title', $playlist->name)
@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <!-- Playlist Header -->
    <div class="flex flex-col md:flex-row gap-8 mb-8">
        <div class="w-48 h-48 rounded-2xl flex items-center justify-center text-6xl flex-shrink-0 shadow-2xl" style="background: linear-gradient(135deg, #8B5CF620, #EC489920); border: 1px solid rgba(255,255,255,0.1);">📋</div>
        <div class="flex-1">
            <p class="text-sm text-gray-400 mb-1">Playlist · {{ $playlist->is_public ? 'Public' : 'Private' }}</p>
            <h1 class="text-4xl font-bold text-white mb-2">{{ $playlist->name }}</h1>
            <p class="text-gray-400">by {{ $playlist->user->name }}</p>
            @if($playlist->description)<p class="mt-3 text-gray-300">{{ $playlist->description }}</p>@endif
            <div class="flex items-center gap-2 mt-4 text-sm text-gray-400">
                <span>🎵 {{ $playlist->tracks->count() }} tracks</span>
            </div>
            @if($playlist->tracks->count())
            <button onclick="playTrack('{{ $playlist->tracks->first()->audio_url }}', '{{ addslashes($playlist->tracks->first()->title) }}', '{{ addslashes($playlist->tracks->first()->artist?->name ?? 'Unknown') }}', '{{ $playlist->tracks->first()->cover_url }}', {{ $playlist->tracks->first()->id }})" class="mt-4 px-6 py-3 rounded-full font-semibold text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">▶ Play All</button>
            @endif
        </div>
    </div>

    <!-- Tracks -->
    <div class="space-y-1">
        @forelse($playlist->tracks as $i => $track)
        <div class="group flex items-center space-x-4 p-3 rounded-xl border border-transparent hover:border-white/10 transition cursor-pointer" style="background: #1A1A2E;" onclick="playTrack('{{ $track->audio_url }}', '{{ addslashes($track->title) }}', '{{ addslashes($track->artist?->name ?? 'Unknown') }}', '{{ $track->cover_url }}', {{ $track->id }})">
            <div class="w-6 text-center text-sm text-gray-500 group-hover:hidden">{{ $i + 1 }}</div>
            <div class="w-6 text-center hidden group-hover:block text-purple-400">▶</div>
            <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0" style="background: rgba(139,92,246,0.2);">
                @if($track->cover_image)<img src="{{ $track->cover_url }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center text-xs">🎵</div>@endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-medium text-white truncate">{{ $track->title }}</div>
                <div class="text-xs text-gray-400">{{ $track->artist?->name ?? 'Unknown' }}</div>
            </div>
            @if($track->genre)<span class="hidden md:block text-xs text-gray-500">{{ $track->genre->name }}</span>@endif
            <span class="text-sm text-gray-500">{{ $track->formatted_duration }}</span>
        </div>
        @empty
        <div class="text-center py-12 text-gray-400">
            <div class="text-4xl mb-3">📋</div>
            <p>This playlist is empty.</p>
            @auth @if(Auth::id() === $playlist->user_id)<a href="/playlists/{{ $playlist->id }}/edit" class="text-purple-400 hover:underline mt-2 block">Add tracks →</a>@endif @endauth
        </div>
        @endforelse
    </div>
</div>
@endsection
