@extends('layouts.admin')
@section('title', 'Channels')
@section('page-title', 'Manage Channels')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div class="text-sm text-gray-400">{{ $channels->total() }} channels</div>
    <a href="{{ route('admin.channels.create') }}" class="px-4 py-2 rounded-lg text-sm font-medium text-white" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">+ Add Channel</a>
</div>
<div class="rounded-2xl border border-white/10 overflow-hidden" style="background: #1A1A2E;">
    <table class="w-full">
        <thead><tr class="border-b border-white/10">
            <th class="px-4 py-3 text-left text-xs text-gray-400">Channel</th>
            <th class="px-4 py-3 text-left text-xs text-gray-400 hidden md:table-cell">Type</th>
            <th class="px-4 py-3 text-left text-xs text-gray-400 hidden md:table-cell">Order</th>
            <th class="px-4 py-3 text-left text-xs text-gray-400">Status</th>
            <th class="px-4 py-3 text-right text-xs text-gray-400">Actions</th>
        </tr></thead>
        <tbody>
            @foreach($channels as $ch)
            <tr class="border-b border-white/5 hover:bg-white/5">
                <td class="px-4 py-3">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full" style="background: {{ $ch->color }}"></div>
                        <div class="font-medium text-white text-sm">{{ $ch->name }}</div>
                    </div>
                </td>
                <td class="px-4 py-3 hidden md:table-cell"><span class="px-2 py-1 rounded text-xs bg-white/10 text-gray-300 capitalize">{{ $ch->type }}</span></td>
                <td class="px-4 py-3 hidden md:table-cell text-sm text-gray-400">#{{ $ch->sort_order }}</td>
                <td class="px-4 py-3"><span class="text-xs {{ $ch->is_active ? 'text-green-400' : 'text-gray-500' }}">{{ $ch->is_active ? '● Active' : '○ Inactive' }}</span></td>
                <td class="px-4 py-3 text-right">
                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('admin.channels.edit', $ch->id) }}" class="px-3 py-1 rounded text-xs border border-white/20 text-gray-300 hover:text-white transition">Edit</a>
                        <form action="{{ route('admin.channels.destroy', $ch->id) }}" method="POST" class="inline">
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
<div class="mt-4">{{ $channels->links() }}</div>
@endsection
