<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class LandingPageAdminController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $settings = SiteSetting::getSettings();
        return view('admin.landing.index', compact('settings'));
    }

    public function update(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $fields = [
            'hero_title', 'hero_subtitle', 'hero_cta_text', 'hero_cta_url',
            'hero_secondary_cta_text', 'hero_secondary_cta_url',
            'hero_bg_gradient_from', 'hero_bg_gradient_to',
            'features_title', 'features_subtitle',
            'feature_1_title', 'feature_1_desc', 'feature_1_icon',
            'feature_2_title', 'feature_2_desc', 'feature_2_icon',
            'feature_3_title', 'feature_3_desc', 'feature_3_icon',
            'feature_4_title', 'feature_4_desc', 'feature_4_icon',
            'stats_show', 'cta_section_title', 'cta_section_subtitle',
            'show_featured_tracks', 'show_featured_artists',
            'show_channels', 'show_genres',
        ];
        foreach ($fields as $field) {
            SiteSetting::updateSetting($field, $request->input($field, ''));
        }
        return redirect()->route('admin.landing.index')->with('success', 'Landing page updated!');
    }
}