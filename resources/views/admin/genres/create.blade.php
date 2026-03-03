@extends('layouts.admin')
@section('title', 'Add Genre')
@section('page-title', 'Add New Genre')
@section('content')
<div class="max-w-lg">
    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <form action="{{ route('admin.genres.store') }}" method="POST" class="space-y-5">
            @csrf
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Genre Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500"></div>
            <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Description</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500">{{ old('description') }}</textarea></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Color</label>
                <input type="color" name="color" value="{{ old('color', '#8B5CF6') }}" class="w-full h-10 rounded-xl bg-white/5 border border-white/10 cursor-pointer"></div>
                <div><label class="block text-sm font-medium text-gray-300 mb-1.5">Icon (emoji)</label>
                <input type="text" name="icon" value="{{ old('icon', '🎵') }}" class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white focus:outline-none focus:border-purple-500"></div>
            </div>
            <div class="flex space-x-3 pt-2">
                <a href="{{ route('admin.genres.index') }}" class="px-5 py-2.5 rounded-xl text-sm border border-white/20 text-gray-300">Cancel</a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">Create Genre</button>
            </div>
        </form>
    </div>
</div>
@endsection
