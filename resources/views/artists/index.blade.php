@extends('layouts.app')
@section('title', 'Artists')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">🎤 Artists</h1>
        <p class="text-gray-400 mt-1">{{ $artists->total() }} artists on SoundWave</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
        @foreach($artists as $artist)
        <a href="/artists/{{ $artist->slug }}" class="group text-center p-5 rounded-2xl border border-white/10 hover:border-purple-500/40 transition-all" style="background: #1A1A2E;">
            <div class="w-20 h-20 rounded-full mx-auto mb-3 overflow-hidden" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">
                @if($artist->image)
                <img src="{{ $artist->image_url }}" alt="{{ $artist->name }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-3xl">🎤</div>
                @endif
            </div>
            <div class="font-semibold text-white group-hover:text-purple-400 transition truncate">{{ $artist->name }}</div>
            @if($artist->country)<div class="text-xs text-gray-500 mt-0.5">{{ $artist->country }}</div>@endif
            <div class="text-xs text-purple-400 mt-1">{{ $artist->tracks_count }} tracks</div>
            @if($artist->is_verified)<div class="text-xs text-blue-400 mt-0.5">✓ Verified</div>@endif
        </a>
        @endforeach
    </div>
    <div class="mt-8">{{ $artists->links() }}</div>
</div>
@endsection
