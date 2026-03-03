@extends('layouts.admin')
@section('title', 'Playlists')
@section('page-title', 'Manage Playlists')
@section('content')
<div class="rounded-2xl border border-white/10 overflow-hidden" style="background: #1A1A2E;">
    <table class="w-full">
        <thead><tr class="border-b border-white/10">
            <th class="px-4 py-3 text-left text-xs text-gray-400">Playlist</th>
            <th class="px-4 py-3 text-left text-xs text-gray-400 hidden md:table-cell">Owner</th>
            <th class="px-4 py-3 text-left text-xs text-gray-400 hidden md:table-cell">Tracks</th>
            <th class="px-4 py-3 text-left text-xs text-gray-400">Visibility</th>
            <th class="px-4 py-3 text-right text-xs text-gray-400">Actions</th>
        </tr></thead>
        <tbody>
            @foreach($playlists as $pl)
            <tr class="border-b border-white/5 hover:bg-white/5">
                <td class="px-4 py-3 font-medium text-white text-sm">{{ $pl->name }}</td>
                <td class="px-4 py-3 hidden md:table-cell text-sm text-gray-300">{{ $pl->user->name }}</td>
                <td class="px-4 py-3 hidden md:table-cell text-sm text-purple-400">{{ $pl->tracks_count }}</td>
                <td class="px-4 py-3"><span class="text-xs {{ $pl->is_public ? 'text-green-400' : 'text-gray-500' }}">{{ $pl->is_public ? 'Public' : 'Private' }}</span></td>
                <td class="px-4 py-3 text-right">
                    <form action="{{ route('admin.playlists.destroy', $pl->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete?')" class="px-3 py-1 rounded text-xs border border-red-500/30 text-red-400 hover:bg-red-500/20 transition">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $playlists->links() }}</div>
@endsection
