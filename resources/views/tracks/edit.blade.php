@extends('layouts.app')
@section('title', 'Edit Track')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">✏️ Edit Track</h1>
        <p class="text-gray-400 mt-1">Update your track information</p>
    </div>
    <div class="p-8 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <form action="/tracks/{{ $track->id }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            @if($errors->any())
            <div class="p-4 rounded-xl border border-red-500/30 bg-red-500/10 text-red-300 text-sm space-y-1">
                @foreach($errors->all() as $e)<div>✗ {{ $e }}</div>@endforeach
            </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Track Title *</label>
                <input type="text" name="title" value="{{ old('title', $track->title) }}" required
                    class="w-full px-4 py-3 rounded-xl text-white focus:outline-none focus:border-purple-500 border transition"
                    style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Artist</label>
                    <select name="artist_id" class="w-full px-4 py-3 rounded-xl text-white border transition" style="background: #0F0F1A; border-color: rgba(255,255,255,0.1);">
                        <option value="">— No Artist —</option>
                        @foreach($artists as $a)<option value="{{ $a->id }}" {{ old('artist_id', $track->artist_id) == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Genre</label>
                    <select name="genre_id" class="w-full px-4 py-3 rounded-xl text-white border transition" style="background: #0F0F1A; border-color: rgba(255,255,255,0.1);">
                        <option value="">— No Genre —</option>
                        @foreach($genres as $g)<option value="{{ $g->id }}" {{ old('genre_id', $track->genre_id) == $g->id ? 'selected' : '' }}>{{ $g->icon }} {{ $g->name }}</option>@endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Album</label>
                <select name="album_id" class="w-full px-4 py-3 rounded-xl text-white border transition" style="background: #0F0F1A; border-color: rgba(255,255,255,0.1);">
                    <option value="">— No Album —</option>
                    @foreach($albums as $al)<option value="{{ $al->id }}" {{ old('album_id', $track->album_id) == $al->id ? 'selected' : '' }}>{{ $al->title }}</option>@endforeach
                </select>
            </div>
            @if($track->cover_image)
            <div>
                <p class="text-xs text-gray-400 mb-2">Current cover:</p>
                <img src="{{ $track->cover_url }}" class="w-20 h-20 rounded-xl object-cover">
            </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">{{ $track->cover_image ? 'Replace Cover Image' : 'Cover Image' }}</label>
                <input type="file" name="cover_image" accept="image/*" class="w-full px-4 py-3 rounded-xl text-gray-300 border transition cursor-pointer" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl text-white focus:outline-none focus:border-purple-500 border transition resize-none" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">{{ old('description', $track->description) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Tags</label>
                <input type="text" name="tags" value="{{ old('tags', $track->tags) }}" class="w-full px-4 py-3 rounded-xl text-white focus:outline-none focus:border-purple-500 border transition" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>
            <div class="flex items-center space-x-3">
                <input type="checkbox" name="is_published" id="is_pub" class="w-4 h-4 rounded" {{ old('is_published', $track->is_published) ? 'checked' : '' }}>
                <label for="is_pub" class="text-sm text-gray-300 cursor-pointer">Published (visible to public)</label>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="/my-tracks" class="flex-1 text-center py-3 rounded-xl border border-white/20 text-gray-300 hover:text-white transition">Cancel</a>
                <button type="submit" class="flex-1 py-3 rounded-xl font-semibold text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Update Track</button>
            </div>
        </form>
    </div>
</div>
@endsection
