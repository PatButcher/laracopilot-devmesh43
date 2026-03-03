<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Genre;
use App\Models\Channel;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    public function index()
    {
        $featuredTracks = Track::with(['artist', 'genre'])
            ->where('is_published', true)
            ->orderBy('play_count', 'desc')
            ->take(8)->get();

        $latestTracks = Track::with(['artist', 'genre'])
            ->where('is_published', true)
            ->latest()->take(12)->get();

        $featuredArtists = Artist::withCount('tracks')
            ->orderBy('tracks_count', 'desc')
            ->take(8)->get();

        $featuredAlbums = Album::with('artist')
            ->withCount('tracks')
            ->latest()->take(6)->get();

        $genres = Genre::withCount('tracks')
            ->orderBy('tracks_count', 'desc')
            ->take(8)->get();

        $channels = Channel::where('is_active', true)
            ->orderBy('sort_order')
            ->take(4)->get();

        $settings = SiteSetting::getSettings();

        return view('welcome', compact(
            'featuredTracks', 'latestTracks', 'featuredArtists',
            'featuredAlbums', 'genres', 'channels', 'settings'
        ));
    }
}