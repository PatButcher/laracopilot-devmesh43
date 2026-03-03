@extends('layouts.admin')
@section('title', 'Add Album')
@section('page-title', 'Add New Album')
@section('content')
<div class="max-w-2xl">
    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <form action="{{ route('admin.albums.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Album Title *</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500"></div>
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Artist *</label>
            <select name="artist_id" required class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500">
                <option value="">Select Artist</option>
                @foreach($artists as $a)<option value="{{ $a->id }}" {{ old('artist_id') == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>@endforeach
            </select></div>
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Release Year</label>
            <input type="number" name="release_year" value="{{ old('release_year', date('Y')) }}" min="1900" max="2099" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500"></div>
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Description</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500">{{ old('description') }}</textarea></div>
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Cover Image</label>
            <input type="file" name="cover_image" accept="image/*" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-gray-300"></div>
            <div class="flex space-x-3 pt-2">
                <a href="{{ route('admin.albums.index') }}" class="px-5 py-2.5 rounded-xl text-sm border border-white/20 text-gray-300">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Create Album</button>
            </div>
        </form>
    </div>
</div>
@endsection
