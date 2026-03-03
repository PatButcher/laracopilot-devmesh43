@extends('layouts.admin')
@section('title', 'Genres')
@section('page-title', 'Manage Genres')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div class="text-sm text-gray-400">{{ $genres->total() }} genres</div>
    <a href="{{ route('admin.genres.create') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">+ Add Genre</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($genres as $genre)
    <div class="p-4 rounded-xl border border-white/10 hover:border-white/20 transition" style="background: #1A1A2E;">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">{{ $genre->icon }}</span>
                <div>
                    <div class="font-semibold text-white">{{ $genre->name }}</div>
                    <div class="text-xs text-gray-400">{{ $genre->tracks_count }} tracks</div>
                </div>
            </div>
            <div class="w-4 h-4 rounded-full" style="background: {{ $genre->color }}"></div>
        </div>
        <div class="flex space-x-2 mt-3">
            <a href="{{ route('admin.genres.edit', $genre->id) }}" class="flex-1 text-center py-1.5 rounded-lg text-xs border border-white/20 text-gray-300 hover:text-white transition">Edit</a>
            <form action="{{ route('admin.genres.destroy', $genre->id) }}" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button onclick="return confirm('Delete?')" class="w-full py-1.5 rounded-lg text-xs border border-red-500/30 text-red-400 hover:bg-red-500/20 transition">Delete</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
<div class="mt-4">{{ $genres->links() }}</div>
@endsection
