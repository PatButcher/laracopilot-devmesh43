<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Playlist;

class PlaylistAdminController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $playlists = Playlist::with(['user'])->withCount('tracks')->latest()->paginate(20);
        return view('admin.playlists.index', compact('playlists'));
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Playlist::findOrFail($id)->delete();
        return redirect()->route('admin.playlists.index')->with('success', 'Playlist deleted.');
    }
}