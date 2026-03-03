@extends('layouts.admin')
@section('title', 'Users')
@section('page-title', 'Manage Users')
@section('content')
<div class="rounded-2xl border border-white/10 overflow-hidden" style="background: #1A1A2E;">
    <table class="w-full">
        <thead><tr class="border-b border-white/10">
            <th class="px-4 py-3 text-left text-xs text-gray-400">User</th>
            <th class="px-4 py-3 text-left text-xs text-gray-400 hidden md:table-cell">Username</th>
            <th class="px-4 py-3 text-left text-xs text-gray-400 hidden md:table-cell">Tracks</th>
            <th class="px-4 py-3 text-left text-xs text-gray-400 hidden md:table-cell">Playlists</th>
            <th class="px-4 py-3 text-left text-xs text-gray-400 hidden lg:table-cell">Joined</th>
            <th class="px-4 py-3 text-right text-xs text-gray-400">Actions</th>
        </tr></thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b border-white/5 hover:bg-white/5">
                <td class="px-4 py-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                        <div>
                            <div class="font-medium text-white text-sm">{{ $user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-3 hidden md:table-cell text-sm text-gray-300">{{ $user->username ?? '—' }}</td>
                <td class="px-4 py-3 hidden md:table-cell text-sm text-purple-400">{{ $user->tracks_count }}</td>
                <td class="px-4 py-3 hidden md:table-cell text-sm text-purple-400">{{ $user->playlists_count }}</td>
                <td class="px-4 py-3 hidden lg:table-cell text-xs text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                <td class="px-4 py-3 text-right">
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Delete this user and all their data?')" class="px-3 py-1 rounded text-xs border border-red-500/30 text-red-400 hover:bg-red-500/20 transition">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
