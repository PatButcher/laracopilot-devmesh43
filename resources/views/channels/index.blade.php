@extends('layouts.app')
@section('title', 'Channels')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">📡 Channels</h1>
        <p class="text-gray-400 mt-1">Curated music collections for every mood and moment</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($channels as $channel)
        <a href="/channels/{{ $channel->slug }}" class="group block p-6 rounded-2xl border border-white/10 hover:border-white/25 transition-all" style="background: linear-gradient(135deg, {{ $channel->color }}18, #1A1A2E);">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl" style="background: {{ $channel->color }}25;">📡</div>
                <span class="text-xs px-2.5 py-1 rounded-full capitalize" style="background: {{ $channel->color }}25; color: {{ $channel->color }};">{{ $channel->type }}</span>
            </div>
            <h3 class="font-bold text-xl text-white mb-2 group-hover:text-purple-400 transition">{{ $channel->name }}</h3>
            @if($channel->description)<p class="text-gray-400 text-sm mb-4 leading-relaxed">{{ $channel->description }}</p>@endif
            <div class="text-sm font-medium transition" style="color: {{ $channel->color }};">Explore →</div>
        </a>
        @empty
        <div class="col-span-3 text-center py-20">
            <div class="text-5xl mb-4">📡</div>
            <p class="text-gray-400">No channels available yet.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
