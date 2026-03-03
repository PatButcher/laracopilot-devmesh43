@extends('layouts.admin')
@section('title', 'Tracks')
@section('page-title', 'Manage Tracks')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div class="text-sm text-gray-400">{{ $tracks->total() }} tracks total</div>
    <a href="{{ route('admin.tracks.create') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">+ Add Track</a>
</div>
<div class="rounded-2xl border border-white/10 overflow-hidden" style="background: #1A1A2E;">
    <table class="w-full">
        <thead>
            <tr class="border-b border-white/10">
                <th class="px-4 py-3 text-left text-xs text-gray-400 uppercase">Track</th>
                <th class="px-4 py-3 text-left text-xs text-gray-400 uppercase hidden md:table-cell">Artist</th>
                <th class="px-4 py-3 text-left text-xs text-gray-400 uppercase hidden lg:table-cell">Genre</th>
                <th class="px-4 py-3 text-left text-xs text-gray-400 uppercase hidden md:table-cell">Plays</th>
                <th class="px-4 py-3 text-left text-xs text-gray-400 uppercase">Status</th>
                <th class="px-4 py-3 text-right text-xs text-gray-400 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tracks as $track)
            <tr class="border-b border-white/5 hover:bg-white/5 transition">
                <td class="px-4 py-3">
                    <div class="font-medium text-white text-sm">{{ $track->title }}</div>
                    <div class="text-xs text-gray-500">{{ $track->album?->title }}</div>
                </td>
                <td class="px-4 py-3 hidden md:table-cell text-sm text-gray-300">{{ $track->artist?->name ?? '—' }}</td>
                <td class="px-4 py-3 hidden lg:table-cell text-sm text-gray-300">{{ $track->genre?->name ?? '—' }}</td>
                <td class="px-4 py-3 hidden md:table-cell text-sm text-purple-400">{{ number_format($track->play_count) }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs {{ $track->is_published ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">{{ $track->is_published ? 'Live' : 'Draft' }}</span>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('admin.tracks.edit', $track->id) }}" class="px-3 py-1 rounded text-xs border border-white/20 text-gray-300 hover:text-white hover:border-white/40 transition">Edit</a>
                        <form action="{{ route('admin.tracks.destroy', $track->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this track?')" class="px-3 py-1 rounded text-xs border border-red-500/30 text-red-400 hover:bg-red-500/20 transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $tracks->links() }}</div>
@endsection
