@extends('layouts.app')
@section('title', 'All Tracks')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white">🎵 All Tracks</h1>
            <p class="text-gray-400 mt-1">{{ $tracks->total() }} tracks available</p>
        </div>
        @auth
        <a href="/upload" class="inline-flex items-center px-5 py-2.5 rounded-full font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">⬆ Upload Track</a>
        @endauth
    </div>

    <!-- Genre Filter -->
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="/tracks" class="px-4 py-1.5 rounded-full text-sm border {{ !request('genre') ? 'text-white border-purple-500' : 'border-white/20 text-gray-400 hover:text-white hover:border-white/40' }} transition"
            style="{{ !request('genre') ? 'background: rgba(139,92,246,0.2);' : '' }}">All</a>
        @foreach($genres as $genre)
        <a href="/tracks?genre={{ $genre->slug }}" class="px-4 py-1.5 rounded-full text-sm border {{ request('genre') === $genre->slug ? 'text-white border-purple-500' : 'border-white/20 text-gray-400 hover:text-white hover:border-white/40' }} transition"
            style="{{ request('genre') === $genre->slug ? 'background: rgba(139,92,246,0.2);' : '' }}">{{ $genre->icon }} {{ $genre->name }}</a>
        @endforeach
    </div>

    <!-- Track List -->
    <div class="space-y-2">
        @forelse($tracks as $index => $track)
        <div class="group flex items-center space-x-4 p-4 rounded-2xl border border-transparent hover:border-white/10 transition-all cursor-pointer" style="background: #1A1A2E;" onclick="playTrack('{{ $track->audio_url }}', '{{ addslashes($track->title) }}', '{{ addslashes($track->artist?->name ?? 'Unknown') }}', '{{ $track->cover_url }}', {{ $track->id }})">
            <!-- Index / Play -->
            <div class="w-8 text-center flex-shrink-0">
                <span class="text-gray-500 text-sm group-hover:hidden">{{ ($tracks->currentPage() - 1) * $tracks->perPage() + $loop->iteration }}</span>
                <span class="hidden group-hover:block text-purple-400 text-lg">▶</span>
            </div>
            <!-- Cover -->
            <div class="w-12 h-12 rounded-xl overflow-hidden flex-shrink-0" style="background: linear-gradient(135deg, #2D1B69, #1A1A2E);">
                @if($track->cover_image)
                <img src="{{ $track->cover_url }}" alt="" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-xl">🎵</div>
                @endif
            </div>
            <!-- Info -->
            <div class="flex-1 min-w-0">
                <a href="/tracks/{{ $track->slug }}" onclick="event.stopPropagation()" class="font-semibold text-white hover:text-purple-400 transition truncate block">{{ $track->title }}</a>
                <div class="text-sm text-gray-400 truncate">{{ $track->artist?->name ?? 'Unknown Artist' }}</div>
            </div>
            <!-- Genre -->
            @if($track->genre)
            <span class="hidden md:block text-xs px-3 py-1 rounded-full" style="background: rgba(139,92,246,0.2); color: #A78BFA;">{{ $track->genre->name }}</span>
            @endif
            <!-- Duration -->
            <div class="text-sm text-gray-500 flex-shrink-0">{{ $track->formatted_duration }}</div>
            <!-- Plays -->
            <div class="hidden md:block text-sm text-gray-500 flex-shrink-0 w-20 text-right">{{ number_format($track->play_count) }} ▶</div>
        </div>
        @empty
        <div class="text-center py-20">
            <div class="text-6xl mb-4">🎵</div>
            <p class="text-gray-400 text-lg">No tracks found.</p>
            @auth<a href="/upload" class="mt-4 inline-block text-purple-400 hover:underline">Be the first to upload →</a>@endauth
        </div>
        @endforelse
    </div>
    <div class="mt-8">{{ $tracks->links() }}</div>
</div>
@endsection
