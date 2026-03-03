@extends('layouts.app')
@section('title', 'My Tracks')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">🎵 My Tracks</h1>
            <p class="text-gray-400 mt-1">{{ $tracks->total() }} tracks uploaded</p>
        </div>
        <a href="/upload" class="px-5 py-2.5 rounded-full font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">⬆ Upload New</a>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 rounded-xl border border-green-500/30 bg-green-500/10 text-green-300 text-sm">✓ {{ session('success') }}</div>
    @endif

    @forelse($tracks as $track)
    <div class="flex items-center gap-4 p-4 rounded-2xl border border-white/10 hover:border-white/20 transition mb-3" style="background: #1A1A2E;">
        <div class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0" style="background: linear-gradient(135deg, #2D1B69, #1A1A2E);">
            @if($track->cover_image)<img src="{{ $track->cover_url }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center text-2xl">🎵</div>@endif
        </div>
        <div class="flex-1 min-w-0">
            <div class="font-semibold text-white truncate">{{ $track->title }}</div>
            <div class="text-sm text-gray-400">{{ $track->artist?->name ?? 'No artist' }} @if($track->genre)· {{ $track->genre->name }}@endif</div>
            <div class="text-xs text-gray-500 mt-0.5">{{ number_format($track->play_count) }} plays · {{ $track->created_at->diffForHumans() }}</div>
        </div>
        <span class="px-2.5 py-1 rounded-full text-xs flex-shrink-0 {{ $track->is_published ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">{{ $track->is_published ? 'Live' : 'Draft' }}</span>
        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="/tracks/{{ $track->slug }}" class="px-3 py-1.5 rounded-lg text-xs border border-white/20 text-gray-300 hover:text-white transition">View</a>
            <a href="/tracks/{{ $track->id }}/edit" class="px-3 py-1.5 rounded-lg text-xs border border-purple-500/40 text-purple-400 hover:bg-purple-500/10 transition">Edit</a>
            <form action="/tracks/{{ $track->id }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button onclick="return confirm('Delete this track?')" class="px-3 py-1.5 rounded-lg text-xs border border-red-500/30 text-red-400 hover:bg-red-500/10 transition">Delete</button>
            </form>
        </div>
    </div>
    @empty
    <div class="text-center py-20">
        <div class="text-6xl mb-4">🎵</div>
        <p class="text-white text-xl font-semibold mb-2">No tracks yet</p>
        <p class="text-gray-400 mb-6">Share your music with the world</p>
        <a href="/upload" class="px-6 py-3 rounded-full font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Upload Your First Track</a>
    </div>
    @endforelse
    <div class="mt-6">{{ $tracks->links() }}</div>
</div>
@endsection
