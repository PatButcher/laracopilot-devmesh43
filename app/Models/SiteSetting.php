<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'type'];

    protected static $defaults = [
        'site_name' => 'SoundWave',
        'site_tagline' => 'Stream. Discover. Share.',
        'meta_description' => 'The ultimate music streaming platform for artists and fans.',
        'meta_keywords' => 'music, streaming, artists, tracks, playlists',
        'og_title' => 'SoundWave - Music Streaming',
        'og_description' => 'Discover and stream music from independent artists.',
        'twitter_handle' => '@soundwave',
        'google_analytics' => '',
        'favicon_url' => '',
        'primary_color' => '#8B5CF6',
        'secondary_color' => '#EC4899',
        'accent_color' => '#06B6D4',
        'background_color' => '#0F0F1A',
        'text_color' => '#F9FAFB',
        'nav_bg_color' => '#1A1A2E',
        'footer_bg_color' => '#111827',
        'font_family' => 'Inter',
        'border_radius' => 'rounded-xl',
        'player_theme' => 'dark',
        'dark_mode' => '1',
        'hero_title' => 'Stream Music, Discover Artists',
        'hero_subtitle' => 'Explore millions of tracks from independent artists around the world. Upload, share, and discover music like never before.',
        'hero_cta_text' => 'Start Listening',
        'hero_cta_url' => '/discover',
        'hero_secondary_cta_text' => 'Upload Track',
        'hero_secondary_cta_url' => '/upload',
        'hero_bg_gradient_from' => '#0F0F1A',
        'hero_bg_gradient_to' => '#1A0A2E',
        'features_title' => 'Everything You Need',
        'features_subtitle' => 'A complete music platform for artists and listeners',
        'feature_1_title' => 'High Quality Audio',
        'feature_1_desc' => 'Stream in crystal-clear quality up to FLAC lossless audio.',
        'feature_1_icon' => '🎵',
        'feature_2_title' => 'Waveform Player',
        'feature_2_desc' => 'Interactive waveform visualization for the ultimate listening experience.',
        'feature_2_icon' => '〰️',
        'feature_3_title' => 'Smart Playlists',
        'feature_3_desc' => 'Create, curate, and share playlists with your community.',
        'feature_3_icon' => '📋',
        'feature_4_title' => 'Artist Tools',
        'feature_4_desc' => 'Upload tracks, manage your profile, and grow your audience.',
        'feature_4_icon' => '🎤',
        'show_featured_tracks' => '1',
        'show_featured_artists' => '1',
        'show_channels' => '1',
        'show_genres' => '1',
        'cta_section_title' => 'Ready to Share Your Music?',
        'cta_section_subtitle' => 'Join thousands of artists already on SoundWave.',
    ];

    public static function getSettings(): array
    {
        return Cache::remember('site_settings', 3600, function () {
            $dbSettings = self::pluck('value', 'key')->toArray();
            return array_merge(self::$defaults, $dbSettings);
        });
    }

    public static function updateSetting(string $key, string $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('site_settings');
    }

    public static function get(string $key, string $default = ''): string
    {
        $settings = self::getSettings();
        return $settings[$key] ?? $default;
    }
}