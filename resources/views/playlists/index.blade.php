@extends('layouts.app')
@section('title', 'My Playlists')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white">📋 My Playlists</h1>
            <p class="text-gray-400 mt-1">{{ $playlists->count() }} playlists</p>
        </div>
        <a href="/playlists/create" class="px-5 py-2.5 rounded-full font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">+ New Playlist</a>
    </div>
    @if(session('success'))<div class="mb-6 p-4 rounded-xl border border-green-500/30 bg-green-500/10 text-green-300 text-sm">✓ {{ session('success') }}</div>@endif
    @forelse($playlists as $playlist)
    <div class="flex items-center gap-4 p-5 rounded-2xl border border-white/10 hover:border-white/20 transition mb-3" style="background: #1A1A2E;">
        <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl flex-shrink-0" style="background: linear-gradient(135deg, #8B5CF620, #EC489920);">📋</div>
        <div class="flex-1 min-w-0">
            <div class="font-semibold text-white">{{ $playlist->name }}</div>
            <div class="text-sm text-gray-400 mt-0.5">{{ $playlist->tracks_count }} tracks · {{ $playlist->is_public ? 'Public' : 'Private' }}</div>
            @if($playlist->description)<div class="text-xs text-gray-500 mt-1 truncate">{{ $playlist->description }}</div>@endif
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="/playlists/{{ $playlist->id }}" class="px-3 py-1.5 rounded-lg text-xs border border-white/20 text-gray-300 hover:text-white transition">View</a>
            <a href="/playlists/{{ $playlist->id }}/edit" class="px-3 py-1.5 rounded-lg text-xs border border-purple-500/40 text-purple-400 hover:bg-purple-500/10 transition">Edit</a>
            <form action="/playlists/{{ $playlist->id }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button onclick="return confirm('Delete playlist?')" class="px-3 py-1.5 rounded-lg text-xs border border-red-500/30 text-red-400 hover:bg-red-500/10 transition">Delete</button>
            </form>
        </div>
    </div>
    @empty
    <div class="text-center py-20">
        <div class="text-6xl mb-4">📋</div>
        <p class="text-white text-xl font-semibold mb-2">No playlists yet</p>
        <p class="text-gray-400 mb-6">Create your first playlist and start adding tracks</p>
        <a href="/playlists/create" class="px-6 py-3 rounded-full font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Create Playlist</a>
    </div>
    @endforelse
</div>
@endsection
