<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ThemeAdminController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $settings = SiteSetting::getSettings();
        return view('admin.theme.index', compact('settings'));
    }

    public function update(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $fields = [
            'primary_color', 'secondary_color', 'accent_color',
            'background_color', 'text_color', 'nav_bg_color',
            'footer_bg_color', 'font_family', 'border_radius',
            'player_theme', 'dark_mode',
        ];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                SiteSetting::updateSetting($field, $request->input($field));
            }
        }
        return redirect()->route('admin.theme.index')->with('success', 'Theme updated successfully!');
    }
}