@extends('layouts.admin')
@section('title', 'Edit Channel')
@section('page-title', 'Edit Channel')
@section('content')
<div class="max-w-lg">
    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <form action="{{ route('admin.channels.update', $channel->id) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Channel Name *</label>
            <input type="text" name="name" value="{{ old('name', $channel->name) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500"></div>
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Content Type *</label>
            <select name="type" required class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500">
                @foreach(['tracks','albums','artists','playlists','genres','mixed'] as $t)
                <option value="{{ $t }}" {{ old('type', $channel->type) === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                @endforeach
            </select></div>
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Filter by Genre</label>
            <select name="genre_id" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500">
                <option value="">— All Genres —</option>
                @foreach($genres as $g)<option value="{{ $g->id }}" {{ old('genre_id', $channel->genre_id) == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>@endforeach
            </select></div>
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Description</label>
            <textarea name="description" rows="2" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500">{{ old('description', $channel->description) }}</textarea></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Color</label>
                <input type="color" name="color" value="{{ old('color', $channel->color) }}" class="w-full h-10 rounded-xl bg-white/5 border border-white/10 cursor-pointer"></div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $channel->sort_order) }}" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500"></div>
            </div>
            <div class="flex items-center space-x-3">
                <input type="checkbox" name="is_active" id="is_active" class="w-4 h-4" {{ old('is_active', $channel->is_active) ? 'checked' : '' }}>
                <label for="is_active" class="text-sm text-gray-300">Active</label>
            </div>
            <div class="flex space-x-3 pt-2">
                <a href="{{ route('admin.channels.index') }}" class="px-5 py-2.5 rounded-xl text-sm border border-white/20 text-gray-300">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Update Channel</button>
            </div>
        </form>
    </div>
</div>
@endsection
