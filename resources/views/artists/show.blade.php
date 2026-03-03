@extends('layouts.app')
@section('title', $artist->name)
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <!-- Artist Header -->
    <div class="p-8 rounded-3xl border border-white/10 mb-8" style="background: linear-gradient(135deg, #1A1A2E, #0F0F1A);">
        <div class="flex flex-col md:flex-row gap-8 items-start">
            <div class="w-32 h-32 rounded-full overflow-hidden flex-shrink-0 shadow-2xl" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">
                @if($artist->image)
                <img src="{{ $artist->image_url }}" alt="{{ $artist->name }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-5xl">🎤</div>
                @endif
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-4xl font-bold text-white">{{ $artist->name }}</h1>
                    @if($artist->is_verified)<span class="text-blue-400 text-sm">✓ Verified</span>@endif
                </div>
                @if($artist->country)<p class="text-gray-400 mb-2">📍 {{ $artist->country }}</p>@endif
                @if($artist->bio)<p class="text-gray-300 leading-relaxed max-w-2xl mb-4">{{ $artist->bio }}</p>@endif
                <div class="flex flex-wrap items-center gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">{{ $tracks->total() }}</div>
                        <div class="text-xs text-gray-400">Tracks</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-white">{{ $albums->count() }}</div>
                        <div class="text-xs text-gray-400">Albums</div>
                    </div>
                    @if($artist->website)
                    <a href="{{ $artist->website }}" target="_blank" class="text-sm text-purple-400 hover:text-purple-300 transition">🔗 Website</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Albums -->
    @if($albums->count())
    <section class="mb-10">
        <h2 class="text-xl font-bold text-white mb-4">💿 Albums</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($albums as $album)
            <a href="/albums/{{ $album->slug }}" class="group">
                <div class="w-full aspect-square rounded-xl overflow-hidden mb-2" style="background: linear-gradient(135deg, #2D1B69, #1A1A2E);">
                    @if($album->cover_image)<img src="{{ $album->cover_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">@else<div class="w-full h-full flex items-center justify-center text-3xl">💿</div>@endif
                </div>
                <div class="text-sm font-medium text-white truncate group-hover:text-purple-400 transition">{{ $album->title }}</div>
                <div class="text-xs text-gray-400">{{ $album->release_year }} · {{ $album->tracks_count }} tracks</div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Tracks -->
    <section>
        <h2 class="text-xl font-bold text-white mb-4">🎵 Tracks</h2>
        <div class="space-y-2">
            @foreach($tracks as $track)
            <div class="group flex items-center space-x-4 p-4 rounded-2xl border border-transparent hover:border-white/10 transition cursor-pointer" style="background: #1A1A2E;" onclick="playTrack('{{ $track->audio_url }}', '{{ addslashes($track->title) }}', '{{ addslashes($artist->name) }}', '{{ $track->cover_url }}', {{ $track->id }})">
                <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0" style="background: rgba(139,92,246,0.2);">
                    @if($track->cover_image)<img src="{{ $track->cover_url }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center">🎵</div>@endif
                </div>
                <div class="flex-1 min-w-0">
                    <a href="/tracks/{{ $track->slug }}" onclick="event.stopPropagation()" class="font-medium text-white hover:text-purple-400 transition truncate block">{{ $track->title }}</a>
                    @if($track->album)<div class="text-xs text-gray-400">{{ $track->album->title }}</div>@endif
                </div>
                @if($track->genre)<span class="hidden md:block text-xs px-2 py-1 rounded-full" style="background: rgba(139,92,246,0.2); color: #A78BFA;">{{ $track->genre->name }}</span>@endif
                <div class="text-sm text-gray-500">{{ $track->formatted_duration }}</div>
                <div class="hidden md:block text-xs text-gray-500">{{ number_format($track->play_count) }} ▶</div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $tracks->links() }}</div>
    </section>
</div>
@endsection
