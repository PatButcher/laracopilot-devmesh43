<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Track;

class ArtistController extends Controller
{
    public function index()
    {
        $artists = Artist::withCount('tracks')->orderBy('name')->paginate(24);
        return view('artists.index', compact('artists'));
    }

    public function show($slug)
    {
        $artist = Artist::where('slug', $slug)->firstOrFail();
        $tracks = Track::with(['genre', 'album'])
            ->where('artist_id', $artist->id)
            ->where('is_published', true)
            ->latest()->paginate(20);
        $albums = $artist->albums()->withCount('tracks')->latest()->get();
        return view('artists.show', compact('artist', 'tracks', 'albums'));
    }
}