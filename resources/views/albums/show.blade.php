@extends('layouts.app')
@section('title', $album->title)
@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <!-- Album Header -->
    <div class="flex flex-col md:flex-row gap-8 mb-10">
        <div class="w-full md:w-56 flex-shrink-0">
            <div class="w-full md:w-56 h-56 rounded-2xl overflow-hidden shadow-2xl" style="background: linear-gradient(135deg, #2D1B69, #1A1A2E);">
                @if($album->cover_image)
                <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-7xl">💿</div>
                @endif
            </div>
        </div>
        <div class="flex-1">
            <p class="text-sm text-gray-400 mb-1">Album</p>
            <h1 class="text-4xl font-bold text-white mb-2">{{ $album->title }}</h1>
            <a href="/artists/{{ $album->artist->slug }}" class="text-purple-400 hover:text-purple-300 transition font-medium text-lg">{{ $album->artist->name }}</a>
            <div class="flex items-center gap-4 mt-3 text-sm text-gray-400">
                @if($album->release_year)<span>📅 {{ $album->release_year }}</span>@endif
                <span>🎵 {{ $tracks->count() }} tracks</span>
            </div>
            @if($album->description)<p class="mt-4 text-gray-300 leading-relaxed">{{ $album->description }}</p>@endif
            @if($tracks->count())
            <button onclick="playTrack('{{ $tracks->first()->audio_url }}', '{{ addslashes($tracks->first()->title) }}', '{{ addslashes($album->artist->name) }}', '{{ $album->cover_url }}', {{ $tracks->first()->id }})" class="mt-5 px-6 py-3 rounded-full font-semibold text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">▶ Play Album</button>
            @endif
        </div>
    </div>

    <!-- Track List -->
    <div class="space-y-1">
        @foreach($tracks as $i => $track)
        <div class="group flex items-center space-x-4 p-3 rounded-xl hover:border-white/10 border border-transparent transition cursor-pointer" style="background: #1A1A2E;" onclick="playTrack('{{ $track->audio_url }}', '{{ addslashes($track->title) }}', '{{ addslashes($album->artist->name) }}', '{{ $album->cover_url }}', {{ $track->id }})">
            <div class="w-6 text-center text-sm text-gray-500 group-hover:hidden">{{ $i + 1 }}</div>
            <div class="w-6 text-center hidden group-hover:block text-purple-400">▶</div>
            <div class="flex-1">
                <span class="text-white font-medium">{{ $track->title }}</span>
            </div>
            @if($track->genre)<span class="text-xs text-gray-500 hidden md:block">{{ $track->genre->name }}</span>@endif
            <span class="text-sm text-gray-500">{{ $track->formatted_duration }}</span>
            <span class="text-xs text-gray-600 hidden md:block">{{ number_format($track->play_count) }} ▶</span>
        </div>
        @endforeach
    </div>
</div>
@endsection
