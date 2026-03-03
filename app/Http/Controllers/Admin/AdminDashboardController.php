<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Track;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Genre;
use App\Models\User;
use App\Models\Playlist;
use App\Models\Channel;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $stats = [
            'total_tracks' => Track::count(),
            'total_artists' => Artist::count(),
            'total_albums' => Album::count(),
            'total_users' => User::count(),
            'total_genres' => Genre::count(),
            'total_playlists' => Playlist::count(),
            'total_channels' => Channel::count(),
            'total_plays' => Track::sum('play_count'),
            'published_tracks' => Track::where('is_published', true)->count(),
            'draft_tracks' => Track::where('is_published', false)->count(),
        ];

        $recentTracks = Track::with(['artist', 'user'])->latest()->take(8)->get();
        $topTracks = Track::with('artist')->orderBy('play_count', 'desc')->take(8)->get();
        $recentUsers = User::latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentTracks', 'topTracks', 'recentUsers'));
    }
}