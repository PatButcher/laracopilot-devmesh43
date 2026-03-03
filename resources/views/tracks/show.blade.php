@extends('layouts.app')
@section('title', $track->title)
@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <!-- Track Hero -->
    <div class="p-8 rounded-3xl border border-white/10 mb-8" style="background: linear-gradient(135deg, #1A1A2E, #0F0F1A);">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Cover Art -->
            <div class="w-full md:w-64 flex-shrink-0">
                <div class="w-full md:w-64 h-64 rounded-2xl overflow-hidden shadow-2xl" style="background: linear-gradient(135deg, #2D1B69, #1A1A2E);">
                    @if($track->cover_image)
                    <img src="{{ $track->cover_url }}" alt="{{ $track->title }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-7xl">🎵</div>
                    @endif
                </div>
            </div>
            <!-- Info -->
            <div class="flex-1">
                @if($track->genre)<span class="inline-block text-xs px-3 py-1 rounded-full mb-3" style="background: rgba(139,92,246,0.2); color: #A78BFA;">{{ $track->genre->name }}</span>@endif
                <h1 class="text-4xl font-bold text-white mb-2">{{ $track->title }}</h1>
                @if($track->artist)
                <a href="/artists/{{ $track->artist->slug }}" class="text-xl text-purple-400 hover:text-purple-300 transition font-medium">{{ $track->artist->name }}</a>
                @endif
                @if($track->album)<div class="text-sm text-gray-400 mt-1">from <a href="/albums/{{ $track->album->slug }}" class="hover:text-white transition">{{ $track->album->title }}</a></div>@endif

                <!-- Waveform Player -->
                <div class="mt-6 p-4 rounded-2xl border border-white/10" style="background: rgba(0,0,0,0.3);">
                    <!-- Waveform bars -->
                    <div class="flex items-end space-x-0.5 h-16 mb-3 overflow-hidden cursor-pointer" id="track-waveform" onclick="seekWaveform(event)">
                        @for($i = 0; $i < 80; $i++)
                        <div class="waveform-bar flex-1" style="height:{{ rand(8, 56) }}px; background: {{ $i < 20 ? 'linear-gradient(to top, #8B5CF6, #EC4899)' : 'rgba(255,255,255,0.15)' }}; border-radius:2px; transition:background 0.1s;" data-bar="{{ $i }}"></div>
                        @endfor
                    </div>
                    <div class="flex items-center space-x-4">
                        <button id="main-play-btn" onclick="playTrack('{{ $track->audio_url }}', '{{ addslashes($track->title) }}', '{{ addslashes($track->artist?->name ?? 'Unknown') }}', '{{ $track->cover_url }}', {{ $track->id }}); updateMainPlayBtn();" class="w-14 h-14 rounded-full flex items-center justify-center text-white text-2xl flex-shrink-0" style="background: linear-gradient(135deg, #8B5CF6, #EC4899);">▶</button>
                        <div class="flex-1">
                            <div class="flex justify-between text-xs text-gray-400 mb-1">
                                <span>{{ $track->formatted_duration }}</span>
                                <span>{{ number_format($track->play_count) }} plays</span>
                            </div>
                            <div class="w-full h-1 rounded-full" style="background: rgba(255,255,255,0.1);">
                                <div class="h-full rounded-full" style="background: linear-gradient(to right, #8B5CF6, #EC4899); width: 0%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-wrap items-center gap-3 mt-5">
                    @auth
                    <button id="fav-btn" onclick="toggleFavourite({{ $track->id }})" class="flex items-center space-x-2 px-4 py-2 rounded-full border transition-all {{ $isFavourited ? 'border-pink-500 text-pink-400' : 'border-white/20 text-gray-400 hover:border-pink-500 hover:text-pink-400' }}">
                        <span id="fav-icon">{{ $isFavourited ? '❤️' : '🤍' }}</span>
                        <span class="text-sm">{{ $isFavourited ? 'Favourited' : 'Favourite' }}</span>
                    </button>
                    @endauth
                    @if($track->tags)
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $track->tags) as $tag)
                        <span class="text-xs px-3 py-1 rounded-full" style="background: rgba(255,255,255,0.05); color: #9CA3AF;">#{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    @if($track->description)
    <div class="p-6 rounded-2xl border border-white/10 mb-6" style="background: #1A1A2E;">
        <h3 class="font-semibold text-white mb-3">About this track</h3>
        <p class="text-gray-300 leading-relaxed">{{ $track->description }}</p>
    </div>
    @endif

    <!-- Related Tracks -->
    @if($relatedTracks->count())
    <div class="mt-8">
        <h2 class="text-xl font-bold text-white mb-4">Related Tracks</h2>
        <div class="space-y-2">
            @foreach($relatedTracks as $related)
            <div class="group flex items-center space-x-4 p-3 rounded-xl border border-transparent hover:border-white/10 transition-all cursor-pointer" style="background: #1A1A2E;" onclick="playTrack('{{ $related->audio_url }}', '{{ addslashes($related->title) }}', '{{ addslashes($related->artist?->name ?? 'Unknown') }}', '{{ $related->cover_url }}', {{ $related->id }})">
                <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0" style="background: linear-gradient(135deg, #2D1B69, #1A1A2E);">
                    @if($related->cover_image)<img src="{{ $related->cover_url }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center">🎵</div>@endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-white truncate group-hover:text-purple-400 transition">{{ $related->title }}</div>
                    <div class="text-xs text-gray-400 truncate">{{ $related->artist?->name ?? 'Unknown' }}</div>
                </div>
                <div class="text-xs text-gray-500">{{ $related->formatted_duration }}</div>
                <div class="w-6 h-6 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition" style="background: rgba(139,92,246,0.3);">▶</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@push('scripts')
<script>
function updateMainPlayBtn() {
    document.getElementById('main-play-btn').textContent = '⏸';
}
function toggleFavourite(trackId) {
    fetch('/favourites/' + trackId, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1] || '', 'Content-Type': 'application/json' }
    }).then(r => r.json()).then(data => {
        const btn = document.getElementById('fav-btn');
        const icon = document.getElementById('fav-icon');
        if (data.status === 'added') { icon.textContent = '❤️'; btn.classList.add('border-pink-500', 'text-pink-400'); }
        else { icon.textContent = '🤍'; btn.classList.remove('border-pink-500', 'text-pink-400'); }
    });
}
</script>
@endpush
@endsection
