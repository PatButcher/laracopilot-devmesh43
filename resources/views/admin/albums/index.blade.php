@extends('layouts.admin')
@section('title', 'Albums')
@section('page-title', 'Manage Albums')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div class="text-sm text-gray-400">{{ $albums->total() }} albums</div>
    <a href="{{ route('admin.albums.create') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">+ Add Album</a>
</div>
<div class="rounded-2xl border border-white/10 overflow-hidden" style="background: #1A1A2E;">
    <table class="w-full">
        <thead><tr class="border-b border-white/10">
            <th class="px-4 py-3 text-left text-xs text-gray-400">Album</th>
            <th class="px-4 py-3 text-left text-xs text-gray-400 hidden md:table-cell">Artist</th>
            <th class="px-4 py-3 text-left text-xs text-gray-400 hidden md:table-cell">Year</th>
            <th class="px-4 py-3 text-left text-xs text-gray-400 hidden md:table-cell">Tracks</th>
            <th class="px-4 py-3 text-right text-xs text-gray-400">Actions</th>
        </tr></thead>
        <tbody>
            @foreach($albums as $album)
            <tr class="border-b border-white/5 hover:bg-white/5">
                <td class="px-4 py-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-lg overflow-hidden bg-purple-900/30 flex-shrink-0">
                            @if($album->cover_image)<img src="{{ asset('storage/'.$album->cover_image) }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center text-sm">💿</div>@endif
                        </div>
                        <div class="font-medium text-white text-sm">{{ $album->title }}</div>
                    </div>
                </td>
                <td class="px-4 py-3 hidden md:table-cell text-sm text-gray-300">{{ $album->artist->name }}</td>
                <td class="px-4 py-3 hidden md:table-cell text-sm text-gray-300">{{ $album->release_year ?? '—' }}</td>
                <td class="px-4 py-3 hidden md:table-cell text-sm text-purple-400">{{ $album->tracks_count }}</td>
                <td class="px-4 py-3 text-right">
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('admin.albums.edit', $album->id) }}" class="px-3 py-1 rounded text-xs border border-white/20 text-gray-300 hover:text-white transition">Edit</a>
                        <form action="{{ route('admin.albums.destroy', $album->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete?')" class="px-3 py-1 rounded text-xs border border-red-500/30 text-red-400 hover:bg-red-500/20 transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $albums->links() }}</div>
@endsection
