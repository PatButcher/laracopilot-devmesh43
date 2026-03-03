@extends('layouts.app')
@section('title', 'Genres')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">🎸 Browse Genres</h1>
        <p class="text-gray-400 mt-1">Explore music by style</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($genres as $genre)
        <a href="/genres/{{ $genre->slug }}" class="group p-6 rounded-2xl border border-white/10 hover:border-white/30 transition-all" style="background: linear-gradient(135deg, {{ $genre->color }}15, #1A1A2E);">
            <div class="text-4xl mb-3">{{ $genre->icon }}</div>
            <h3 class="font-bold text-white text-xl mb-1 group-hover:text-purple-400 transition">{{ $genre->name }}</h3>
            <p class="text-sm text-gray-400 mb-3">{{ $genre->tracks_count }} tracks</p>
            @if($genre->description)<p class="text-xs text-gray-500 leading-relaxed">{{ Str::limit($genre->description, 80) }}</p>@endif
            <div class="mt-4 h-1 rounded-full" style="background: {{ $genre->color }}44;">
                <div class="h-full rounded-full" style="background: {{ $genre->color }}; width: 100%;"></div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection
