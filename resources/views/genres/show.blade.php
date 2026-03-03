@extends('layouts.app')
@section('title', $genre->name)
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <!-- Genre Header -->
    <div class="p-8 rounded-3xl border border-white/10 mb-8" style="background: linear-gradient(135deg, {{ $genre->color }}20, #1A1A2E);">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-4xl" style="background: {{ $genre->color }}30;">{{ $genre->icon }}</div>
            <div>
                <h1 class="text-4xl font-bold text-white">{{ $genre->name }}</h1>
                @if($genre->description)<p class="text-gray-400 mt-2">{{ $genre->description }}</p>@endif
                <p class="text-sm mt-2" style="color: {{ $genre->color }};">{{ $tracks->total() }} tracks</p>
            </div>
        </div>
    </div>

    <!-- Track List -->
    <div class="space-y-2">
        @forelse($tracks as $track)
        <div class="group flex items-center space-x-4 p-4 rounded-2xl border border-transparent hover:border-white/10 transition cursor-pointer" style="background: #1A1A2E;" onclick="playTrack('{{ $track->audio_url }}', '{{ addslashes($track->title) }}', '{{ addslashes($track->artist?->name ?? 'Unknown') }}', '{{ $track->cover_url }}', {{ $track->id }})">
            <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0" style="background: rgba(139,92,246,0.2);">
                @if($track->cover_image)<img src="{{ $track->cover_url }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center">🎵</div>@endif
            </div>
            <div class="flex-1 min-w-0">
                <a href="/tracks/{{ $track->slug }}" onclick="event.stopPropagation()" class="font-medium text-white hover:text-purple-400 transition truncate block">{{ $track->title }}</a>
                @if($track->artist)<a href="/artists/{{ $track->artist->slug }}" onclick="event.stopPropagation()" class="text-sm text-gray-400 hover:text-white transition truncate block">{{ $track->artist->name }}</a>@endif
            </div>
            @if($track->album)<span class="hidden md:block text-xs text-gray-500 truncate">{{ $track->album->title }}</span>@endif
            <div class="text-sm text-gray-500">{{ $track->formatted_duration }}</div>
            <div class="hidden md:block text-xs text-gray-600">{{ number_format($track->play_count) }} ▶</div>
        </div>
        @empty
        <div class="text-center py-16">
            <div class="text-5xl mb-4">{{ $genre->icon }}</div>
            <p class="text-gray-400">No tracks in this genre yet.</p>
        </div>
        @endforelse
    </div>
    <div class="mt-6">{{ $tracks->links() }}</div>
</div>
@endsection
