@extends('layouts.app')
@section('title', 'My Favourites')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">❤️ My Favourites</h1>
        <p class="text-gray-400 mt-1">{{ $favourites->total() }} liked tracks</p>
    </div>
    <div class="space-y-2">
        @forelse($favourites as $fav)
        @php $track = $fav->track; @endphp
        <div class="group flex items-center space-x-4 p-4 rounded-2xl border border-transparent hover:border-white/10 transition cursor-pointer" style="background: #1A1A2E;" onclick="playTrack('{{ $track->audio_url }}', '{{ addslashes($track->title) }}', '{{ addslashes($track->artist?->name ?? 'Unknown') }}', '{{ $track->cover_url }}', {{ $track->id }})">
            <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0" style="background: rgba(139,92,246,0.2);">
                @if($track->cover_image)<img src="{{ $track->cover_url }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center">🎵</div>@endif
            </div>
            <div class="flex-1 min-w-0">
                <a href="/tracks/{{ $track->slug }}" onclick="event.stopPropagation()" class="font-semibold text-white hover:text-purple-400 transition truncate block">{{ $track->title }}</a>
                <div class="text-sm text-gray-400">{{ $track->artist?->name ?? 'Unknown' }}</div>
            </div>
            @if($track->genre)<span class="hidden md:block text-xs px-2 py-1 rounded-full" style="background: rgba(139,92,246,0.2); color: #A78BFA;">{{ $track->genre->name }}</span>@endif
            <div class="text-sm text-gray-500">{{ $track->formatted_duration }}</div>
            <div class="text-xs text-gray-500">{{ $fav->created_at->diffForHumans() }}</div>
        </div>
        @empty
        <div class="text-center py-20">
            <div class="text-6xl mb-4">🤍</div>
            <p class="text-white text-xl font-semibold mb-2">No favourites yet</p>
            <p class="text-gray-400 mb-6">Like tracks while listening to save them here</p>
            <a href="/discover" class="px-6 py-3 rounded-full font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Discover Music</a>
        </div>
        @endforelse
    </div>
    <div class="mt-6">{{ $favourites->links() }}</div>
</div>
@endsection
