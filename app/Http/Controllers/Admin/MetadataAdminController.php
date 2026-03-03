<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class MetadataAdminController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $settings = SiteSetting::getSettings();
        return view('admin.metadata.index', compact('settings'));
    }

    public function update(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'twitter_handle' => 'nullable|string|max:100',
            'google_analytics' => 'nullable|string|max:50',
            'favicon_url' => 'nullable|string|max:255',
        ]);
        $fields = ['site_name', 'site_tagline', 'meta_description', 'meta_keywords',
                   'og_title', 'og_description', 'twitter_handle', 'google_analytics', 'favicon_url'];
        foreach ($fields as $field) {
            SiteSetting::updateSetting($field, $request->input($field, ''));
        }
        return redirect()->route('admin.metadata.index')->with('success', 'Metadata updated!');
    }
}