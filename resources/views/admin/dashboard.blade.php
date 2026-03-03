@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('content')

<div class="space-y-6">
    <!-- Welcome -->
    <div class="p-6 rounded-2xl border border-white/10" style="background: linear-gradient(135deg, rgba(139,92,246,0.2), rgba(236,72,153,0.1));">
        <h2 class="text-xl font-bold text-white">Welcome back, {{ ucfirst(session('admin_user')) }}! 👋</h2>
        <p class="text-gray-400 mt-1 text-sm">Here's what's happening on SoundWave today.</p>
    </div>

    <!-- KPI Grid -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        @foreach([
            ['label' => 'Total Tracks', 'value' => $stats['total_tracks'], 'icon' => '🎵', 'color' => '#8B5CF6'],
            ['label' => 'Artists', 'value' => $stats['total_artists'], 'icon' => '🎤', 'color' => '#EC4899'],
            ['label' => 'Albums', 'value' => $stats['total_albums'], 'icon' => '💿', 'color' => '#06B6D4'],
            ['label' => 'Users', 'value' => $stats['total_users'], 'icon' => '👥', 'color' => '#10B981'],
            ['label' => 'Total Plays', 'value' => number_format($stats['total_plays']), 'icon' => '▶️', 'color' => '#F59E0B'],
        ] as $kpi)
        <div class="p-4 rounded-xl border border-white/10" style="background: #1A1A2E;">
            <div class="text-2xl mb-1">{{ $kpi['icon'] }}</div>
            <div class="text-2xl font-bold text-white">{{ $kpi['value'] }}</div>
            <div class="text-xs text-gray-400 mt-0.5">{{ $kpi['label'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="p-4 rounded-xl border border-white/10" style="background: #1A1A2E;">
            <div class="text-sm text-gray-400">Published Tracks</div>
            <div class="text-xl font-bold text-green-400">{{ $stats['published_tracks'] }}</div>
        </div>
        <div class="p-4 rounded-xl border border-white/10" style="background: #1A1A2E;">
            <div class="text-sm text-gray-400">Draft Tracks</div>
            <div class="text-xl font-bold text-yellow-400">{{ $stats['draft_tracks'] }}</div>
        </div>
        <div class="p-4 rounded-xl border border-white/10" style="background: #1A1A2E;">
            <div class="text-sm text-gray-400">Genres</div>
            <div class="text-xl font-bold text-purple-400">{{ $stats['total_genres'] }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Tracks -->
        <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-white">Recent Tracks</h3>
                <a href="/admin/tracks" class="text-xs text-purple-400 hover:underline">View all →</a>
            </div>
            <div class="space-y-3">
                @foreach($recentTracks as $track)
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background: rgba(139,92,246,0.2);">🎵</div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-white truncate">{{ $track->title }}</div>
                        <div class="text-xs text-gray-400">{{ $track->artist?->name ?? 'Unknown' }}</div>
                    </div>
                    <span class="text-xs {{ $track->is_published ? 'text-green-400' : 'text-yellow-400' }}">{{ $track->is_published ? 'Live' : 'Draft' }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Tracks -->
        <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-white">🔥 Top Tracks by Plays</h3>
                <a href="/tracks" class="text-xs text-purple-400 hover:underline">View site →</a>
            </div>
            <div class="space-y-3">
                @foreach($topTracks as $i => $track)
                <div class="flex items-center space-x-3">
                    <div class="w-6 text-center text-xs font-bold" style="color: {{ $i < 3 ? '#F59E0B' : '#6B7280' }}">#{{ $i+1 }}</div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-white truncate">{{ $track->title }}</div>
                        <div class="text-xs text-gray-400">{{ $track->artist?->name ?? 'Unknown' }}</div>
                    </div>
                    <span class="text-xs text-purple-400">{{ number_format($track->play_count) }} plays</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="p-6 rounded-2xl border border-white/10" style="background: #1A1A2E;">
        <h3 class="font-semibold text-white mb-4">Quick Actions</h3>
        <div class="flex flex-wrap gap-3">
            <a href="/admin/tracks/create" class="px-4 py-2 rounded-lg text-sm font-medium text-white transition" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">+ Add Track</a>
            <a href="/admin/artists/create" class="px-4 py-2 rounded-lg text-sm font-medium border border-white/20 text-gray-300 hover:text-white hover:border-white/40 transition">+ Add Artist</a>
            <a href="/admin/albums/create" class="px-4 py-2 rounded-lg text-sm font-medium border border-white/20 text-gray-300 hover:text-white hover:border-white/40 transition">+ Add Album</a>
            <a href="/admin/genres/create" class="px-4 py-2 rounded-lg text-sm font-medium border border-white/20 text-gray-300 hover:text-white hover:border-white/40 transition">+ Add Genre</a>
            <a href="/admin/channels/create" class="px-4 py-2 rounded-lg text-sm font-medium border border-white/20 text-gray-300 hover:text-white hover:border-white/40 transition">+ Add Channel</a>
        </div>
    </div>
</div>
@endsection
