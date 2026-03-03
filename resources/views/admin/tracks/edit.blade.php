@extends('layouts.admin')
@section('title', 'Edit Track')
@section('page-title', 'Edit Track')
@section('content')
<div class="max-w-2xl">
    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <form action="{{ route('admin.tracks.update', $track->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Track Title *</label>
                <input type="text" name="title" value="{{ old('title', $track->title) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Artist</label>
                    <select name="artist_id" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500">
                        <option value="">— No Artist —</option>
                        @foreach($artists as $a)<option value="{{ $a->id }}" {{ old('artist_id', $track->artist_id) == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Genre</label>
                    <select name="genre_id" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500">
                        <option value="">— No Genre —</option>
                        @foreach($genres as $g)<option value="{{ $g->id }}" {{ old('genre_id', $track->genre_id) == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>@endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Album</label>
                <select name="album_id" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500">
                    <option value="">— No Album —</option>
                    @foreach($albums as $al)<option value="{{ $al->id }}" {{ old('album_id', $track->album_id) == $al->id ? 'selected' : '' }}>{{ $al->title }}</option>@endforeach
                </select>
            </div>
            @if($track->cover_image)
            <div>
                <p class="text-xs text-gray-400 mb-2">Current cover:</p>
                <img src="{{ asset('storage/' . $track->cover_image) }}" class="w-20 h-20 rounded-lg object-cover">
            </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">New Cover Image (leave empty to keep current)</label>
                <input type="file" name="cover_image" accept="image/*" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-gray-300 focus:outline-none focus:border-purple-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Description</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500">{{ old('description', $track->description) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1.5">Tags</label>
                <input type="text" name="tags" value="{{ old('tags', $track->tags) }}" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500">
            </div>
            <div class="flex items-center space-x-3">
                <input type="checkbox" name="is_published" id="is_pub" class="w-4 h-4 rounded" {{ old('is_published', $track->is_published) ? 'checked' : '' }}>
                <label for="is_pub" class="text-sm text-gray-300">Published (visible to public)</label>
            </div>
            <div class="flex space-x-3 pt-2">
                <a href="{{ route('admin.tracks.index') }}" class="px-5 py-2.5 rounded-xl text-sm border border-white/20 text-gray-300 hover:text-white transition">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Update Track</button>
            </div>
        </form>
    </div>
</div>
@endsection
