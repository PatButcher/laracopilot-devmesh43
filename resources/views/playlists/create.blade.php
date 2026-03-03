@extends('layouts.app')
@section('title', 'Create Playlist')
@section('content')
<div class="max-w-xl mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">📋 Create Playlist</h1>
        <p class="text-gray-400 mt-1">Curate your perfect music collection</p>
    </div>
    <div class="p-8 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <form action="/playlists" method="POST" class="space-y-5">
            @csrf
            @if($errors->any())
            <div class="p-4 rounded-xl border border-red-500/30 bg-red-500/10 text-red-300 text-sm">
                @foreach($errors->all() as $e)<div>✗ {{ $e }}</div>@endforeach
            </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Playlist Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="My Awesome Playlist"
                    class="w-full px-4 py-3 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 border transition"
                    style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea name="description" rows="3" placeholder="What's this playlist about?"
                    class="w-full px-4 py-3 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 border transition resize-none"
                    style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">{{ old('description') }}</textarea>
            </div>
            <div class="flex items-center space-x-3 p-4 rounded-xl" style="background: rgba(139,92,246,0.08); border: 1px solid rgba(139,92,246,0.2);">
                <input type="checkbox" name="is_public" id="is_public" class="w-5 h-5 rounded" {{ old('is_public', true) ? 'checked' : '' }}>
                <label for="is_public" class="cursor-pointer">
                    <div class="text-sm font-medium text-white">Public Playlist</div>
                    <div class="text-xs text-gray-400">Anyone can discover and listen to this playlist</div>
                </label>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="/playlists" class="flex-1 text-center py-3 rounded-xl border border-white/20 text-gray-300 hover:text-white transition">Cancel</a>
                <button type="submit" class="flex-1 py-3 rounded-xl font-semibold text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Create Playlist</button>
            </div>
        </form>
    </div>
</div>
@endsection
