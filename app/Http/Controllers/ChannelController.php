<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Track;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use App\Models\Playlist;

class ChannelController extends Controller
{
    public function index()
    {
        $channels = Channel::where('is_active', true)->orderBy('sort_order')->get();
        return view('channels.index', compact('channels'));
    }

    public function show($slug)
    {
        $channel = Channel::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $items = collect();

        switch ($channel->type) {
            case 'tracks':
                $items = Track::with(['artist', 'genre'])
                    ->where('is_published', true)
                    ->when($channel->genre_id, fn($q) => $q->where('genre_id', $channel->genre_id))
                    ->orderBy('play_count', 'desc')->paginate(20);
                break;
            case 'albums':
                $items = Album::with('artist')->withCount('tracks')->latest()->paginate(20);
                break;
            case 'artists':
                $items = Artist::withCount('tracks')->orderBy('name')->paginate(24);
                break;
            case 'playlists':
                $items = Playlist::with('user')->where('is_public', true)->latest()->paginate(20);
                break;
            case 'genres':
                $items = Genre::withCount('tracks')->orderBy('name')->get();
                break;
        }

        return view('channels.show', compact('channel', 'items'));
    }
}