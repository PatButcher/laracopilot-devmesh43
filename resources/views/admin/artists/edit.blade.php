@extends('layouts.admin')
@section('title', 'Edit Artist')
@section('page-title', 'Edit Artist')
@section('content')
<div class="max-w-2xl">
    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <form action="{{ route('admin.artists.update', $artist->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Artist Name *</label>
            <input type="text" name="name" value="{{ old('name', $artist->name) }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500"></div>
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Country</label>
            <input type="text" name="country" value="{{ old('country', $artist->country) }}" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500"></div>
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Website</label>
            <input type="url" name="website" value="{{ old('website', $artist->website) }}" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500"></div>
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Biography</label>
            <textarea name="bio" rows="4" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500">{{ old('bio', $artist->bio) }}</textarea></div>
            @if($artist->image)<div><p class="text-xs text-gray-400 mb-1">Current photo:</p><img src="{{ asset('storage/' . $artist->image) }}" class="w-16 h-16 rounded-full object-cover"></div>@endif
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">New Photo</label>
            <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-gray-300 focus:outline-none focus:border-purple-500"></div>
            <div class="flex space-x-3 pt-2">
                <a href="{{ route('admin.artists.index') }}" class="px-5 py-2.5 rounded-xl text-sm border border-white/20 text-gray-300 hover:text-white transition">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Update Artist</button>
            </div>
        </form>
    </div>
</div>
@endsection
