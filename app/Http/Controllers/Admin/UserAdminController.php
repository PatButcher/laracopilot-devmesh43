<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserAdminController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $users = User::withCount(['tracks', 'playlists', 'favourites'])->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}