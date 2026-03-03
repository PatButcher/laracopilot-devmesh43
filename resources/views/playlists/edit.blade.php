@extends('layouts.app')
@section('title', 'Edit Playlist')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">✏️ Edit Playlist</h1>
        <p class="text-gray-400 mt-1">{{ $playlist->name }}</p>
    </div>
    <div class="p-8 rounded-2xl border border-white/10 mb-6" style="background: #1A1A2E;">
        <form action="/playlists/{{ $playlist->id }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            @if($errors->any())
            <div class="p-4 rounded-xl border border-red-500/30 bg-red-500/10 text-red-300 text-sm">
                @foreach($errors->all() as $e)<div>✗ {{ $e }}</div>@endforeach
            </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Playlist Name *</label>
                <input type="text" name="name" value="{{ old('name', $playlist->name) }}" required
                    class="w-full px-4 py-3 rounded-xl text-white focus:outline-none focus:border-purple-500 border transition"
                    style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl text-white focus:outline-none focus:border-purple-500 border transition resize-none" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">{{ old('description', $playlist->description) }}</textarea>
            </div>
            <div class="flex items-center space-x-3">
                <input type="checkbox" name="is_public" id="is_public" class="w-4 h-4 rounded" {{ old('is_public', $playlist->is_public) ? 'checked' : '' }}>
                <label for="is_public" class="text-sm text-gray-300 cursor-pointer">Public playlist</label>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="/playlists" class="flex-1 text-center py-3 rounded-xl border border-white/20 text-gray-300">Cancel</a>
                <button type="submit" class="flex-1 py-3 rounded-xl font-semibold text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Save Changes</button>
            </div>
        </form>
    </div>

    <!-- Manage Tracks -->
    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <h3 class="font-semibold text-white mb-4">🎵 Tracks in Playlist ({{ $playlist->tracks->count() }})</h3>
        @forelse($playlist->tracks as $track)
        <div class="flex items-center gap-3 py-2 border-b border-white/5">
            <div class="w-9 h-9 rounded-lg overflow-hidden flex-shrink-0" style="background: rgba(139,92,246,0.2);">
                @if($track->cover_image)<img src="{{ $track->cover_url }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center text-xs">🎵</div>@endif
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-medium text-white truncate">{{ $track->title }}</div>
                <div class="text-xs text-gray-400">{{ $track->artist?->name }}</div>
            </div>
            <form action="/playlists/{{ $playlist->id }}/tracks/{{ $track->id }}" method="POST">
                @csrf @method('DELETE')
                <button class="text-xs text-red-400 hover:text-red-300 transition">Remove</button>
            </form>
        </div>
        @empty
        <p class="text-gray-500 text-sm">No tracks yet. Add some below!</p>
        @endforelse

        <div class="mt-5">
            <h4 class="text-sm font-medium text-gray-300 mb-3">Add a track:</h4>
            <form action="/playlists/{{ $playlist->id }}/tracks" method="POST" class="flex gap-2">
                @csrf
                <select name="track_id" class="flex-1 px-3 py-2 rounded-xl text-white text-sm border" style="background: #0F0F1A; border-color: rgba(255,255,255,0.1);">
                    <option value="">Select a track...</option>
                    @foreach($tracks as $track)
                    <option value="{{ $track->id }}">{{ $track->title }} — {{ $track->artist?->name ?? 'Unknown' }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 rounded-xl text-sm font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Add</button>
            </form>
        </div>
    </div>
</div>
@endsection
