@extends('layouts.app')
@section('title', 'Upload Track')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">⬆ Upload Track</h1>
        <p class="text-gray-400 mt-2">Share your music with the SoundWave community</p>
    </div>
    <div class="p-8 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <form action="/upload" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if($errors->any())
            <div class="p-4 rounded-xl border border-red-500/30 bg-red-500/10 text-red-300 text-sm space-y-1">
                @foreach($errors->all() as $e)<div>✗ {{ $e }}</div>@endforeach
            </div>
            @endif

            <!-- Audio Upload Zone -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Audio File *</label>
                <div class="border-2 border-dashed rounded-2xl p-8 text-center cursor-pointer hover:border-purple-500 transition-all" style="border-color: rgba(255,255,255,0.15); background: rgba(0,0,0,0.2);" onclick="document.getElementById('audio_file').click()">
                    <div class="text-4xl mb-3">🎵</div>
                    <p class="text-white font-medium">Drop your audio file here or click to browse</p>
                    <p class="text-gray-500 text-sm mt-1">MP3, WAV, OGG, FLAC, AAC — max 50MB</p>
                    <p class="text-purple-400 text-sm mt-1" id="audio-filename">No file selected</p>
                </div>
                <input type="file" id="audio_file" name="audio_file" accept=".mp3,.wav,.ogg,.flac,.aac" required class="hidden" onchange="document.getElementById('audio-filename').textContent = this.files[0]?.name || 'No file selected'">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Track Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Give your track a name"
                    class="w-full px-4 py-3 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 border transition"
                    style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Artist</label>
                    <select name="artist_id" class="w-full px-4 py-3 rounded-xl text-white focus:outline-none focus:border-purple-500 border transition" style="background: #0F0F1A; border-color: rgba(255,255,255,0.1);">
                        <option value="">— Select Artist —</option>
                        @foreach($artists as $a)<option value="{{ $a->id }}" {{ old('artist_id') == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Genre</label>
                    <select name="genre_id" class="w-full px-4 py-3 rounded-xl text-white focus:outline-none focus:border-purple-500 border transition" style="background: #0F0F1A; border-color: rgba(255,255,255,0.1);">
                        <option value="">— Select Genre —</option>
                        @foreach($genres as $g)<option value="{{ $g->id }}" {{ old('genre_id') == $g->id ? 'selected' : '' }}>{{ $g->icon }} {{ $g->name }}</option>@endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Album (optional)</label>
                <select name="album_id" class="w-full px-4 py-3 rounded-xl text-white focus:outline-none focus:border-purple-500 border transition" style="background: #0F0F1A; border-color: rgba(255,255,255,0.1);">
                    <option value="">— No Album —</option>
                    @foreach($albums as $al)<option value="{{ $al->id }}" {{ old('album_id') == $al->id ? 'selected' : '' }}>{{ $al->title }}</option>@endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Cover Image (optional)</label>
                <input type="file" name="cover_image" accept="image/*"
                    class="w-full px-4 py-3 rounded-xl text-gray-300 border transition cursor-pointer"
                    style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
                <p class="text-xs text-gray-500 mt-1">JPEG, PNG, WebP — max 5MB</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea name="description" rows="3" placeholder="Tell listeners about this track..."
                    class="w-full px-4 py-3 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 border transition resize-none"
                    style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Tags (comma-separated)</label>
                <input type="text" name="tags" value="{{ old('tags') }}" placeholder="electronic, chill, midnight"
                    class="w-full px-4 py-3 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 border transition"
                    style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">
            </div>

            <div class="flex items-center space-x-3 p-4 rounded-xl" style="background: rgba(139,92,246,0.1); border: 1px solid rgba(139,92,246,0.2);">
                <input type="checkbox" name="is_published" id="is_published" class="w-5 h-5 rounded" {{ old('is_published') ? 'checked' : '' }}>
                <label for="is_published" class="cursor-pointer">
                    <div class="text-sm font-medium text-white">Publish immediately</div>
                    <div class="text-xs text-gray-400">Your track will be visible to all listeners</div>
                </label>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="/my-tracks" class="flex-1 text-center py-3 rounded-xl border border-white/20 text-gray-300 hover:text-white transition">Cancel</a>
                <button type="submit" class="flex-1 py-3 rounded-xl font-semibold text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Upload Track</button>
            </div>
        </form>
    </div>
</div>
@endsection
