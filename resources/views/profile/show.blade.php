@extends('layouts.app')
@section('title', 'My Profile')
@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <!-- Profile Header -->
    <div class="p-8 rounded-3xl border border-white/10 mb-8" style="background: linear-gradient(135deg, #1A1A2E, #0F0F1A);">
        <div class="flex flex-col md:flex-row items-start gap-6">
            <div class="w-24 h-24 rounded-full flex items-center justify-center text-3xl font-bold text-white flex-shrink-0" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-white">{{ $user->name }}</h1>
                @if($user->username)<p class="text-purple-400 mt-0.5">@{{ $user->username }}</p>@endif
                @if($user->bio)<p class="text-gray-300 mt-3 leading-relaxed">{{ $user->bio }}</p>@endif
                <div class="flex flex-wrap items-center gap-5 mt-4">
                    <div class="text-center">
                        <div class="text-xl font-bold text-white">{{ $tracks->count() }}</div>
                        <div class="text-xs text-gray-400">Tracks</div>
                    </div>
                    <div class="text-center">
                        <div class="text-xl font-bold text-white">{{ $playlists->count() }}</div>
                        <div class="text-xs text-gray-400">Playlists</div>
                    </div>
                    @if($user->website)<a href="{{ $user->website }}" target="_blank" class="text-sm text-purple-400 hover:underline">🔗 {{ $user->website }}</a>@endif
                </div>
            </div>
            <a href="/profile/edit" class="flex-shrink-0 px-4 py-2 rounded-xl border border-white/20 text-gray-300 hover:text-white hover:border-white/40 transition text-sm">✏️ Edit Profile</a>
        </div>
    </div>

    <!-- My Tracks -->
    @if($tracks->count())
    <section class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-white">🎵 My Tracks</h2>
            <a href="/my-tracks" class="text-sm text-purple-400 hover:underline">Manage →</a>
        </div>
        <div class="space-y-2">
            @foreach($tracks->take(5) as $track)
            <div class="group flex items-center gap-4 p-3 rounded-xl border border-transparent hover:border-white/10 transition cursor-pointer" style="background: #1A1A2E;" onclick="playTrack('{{ $track->audio_url }}', '{{ addslashes($track->title) }}', '{{ addslashes($user->name) }}', '{{ $track->cover_url }}', {{ $track->id }})">
                <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0" style="background: rgba(139,92,246,0.2);">
                    @if($track->cover_image)<img src="{{ $track->cover_url }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center">🎵</div>@endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-white truncate">{{ $track->title }}</div>
                    <div class="text-xs text-gray-400">{{ number_format($track->play_count) }} plays · {{ $track->created_at->diffForHumans() }}</div>
                </div>
                <span class="text-xs {{ $track->is_published ? 'text-green-400' : 'text-yellow-400' }}">{{ $track->is_published ? 'Live' : 'Draft' }}</span>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- My Playlists -->
    @if($playlists->count())
    <section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-white">📋 My Playlists</h2>
            <a href="/playlists" class="text-sm text-purple-400 hover:underline">Manage →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($playlists->take(4) as $pl)
            <a href="/playlists/{{ $pl->id }}" class="flex items-center gap-3 p-4 rounded-xl border border-white/10 hover:border-white/25 transition" style="background: #1A1A2E;">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl flex-shrink-0" style="background: rgba(139,92,246,0.2);">📋</div>
                <div class="min-w-0">
                    <div class="font-medium text-white truncate">{{ $pl->name }}</div>
                    <div class="text-xs text-gray-400">{{ $pl->tracks()->count() }} tracks</div>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection
