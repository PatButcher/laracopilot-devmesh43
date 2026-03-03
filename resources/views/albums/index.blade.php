@extends('layouts.app')
@section('title', 'Albums')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">💿 Albums</h1>
        <p class="text-gray-400 mt-1">{{ $albums->total() }} albums available</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
        @foreach($albums as $album)
        <a href="/albums/{{ $album->slug }}" class="group">
            <div class="relative w-full aspect-square rounded-2xl overflow-hidden mb-3" style="background: linear-gradient(135deg, #2D1B69, #1A1A2E);">
                @if($album->cover_image)
                <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                <div class="w-full h-full flex items-center justify-center text-5xl">💿</div>
                @endif
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all" style="background: rgba(0,0,0,0.5);">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-white text-xl" style="background: rgba(139,92,246,0.9);">▶</div>
                </div>
            </div>
            <div class="font-semibold text-white truncate group-hover:text-purple-400 transition">{{ $album->title }}</div>
            <div class="text-sm text-gray-400 truncate">{{ $album->artist->name }}</div>
            <div class="text-xs text-gray-500 mt-0.5">{{ $album->release_year }} · {{ $album->tracks_count }} tracks</div>
        </a>
        @endforeach
    </div>
    <div class="mt-8">{{ $albums->links() }}</div>
</div>
@endsection
