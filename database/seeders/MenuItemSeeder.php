<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['label' => 'Discover', 'url' => '/discover', 'location' => 'header', 'icon' => '🔍', 'sort_order' => 1],
            ['label' => 'Tracks', 'url' => '/tracks', 'location' => 'header', 'icon' => '🎵', 'sort_order' => 2],
            ['label' => 'Artists', 'url' => '/artists', 'location' => 'header', 'icon' => '🎤', 'sort_order' => 3],
            ['label' => 'Albums', 'url' => '/albums', 'location' => 'header', 'icon' => '💿', 'sort_order' => 4],
            ['label' => 'Genres', 'url' => '/genres', 'location' => 'header', 'icon' => '🎸', 'sort_order' => 5],
            ['label' => 'Channels', 'url' => '/channels', 'location' => 'header', 'icon' => '📡', 'sort_order' => 6],
            ['label' => 'Upload Track', 'url' => '/upload', 'location' => 'header', 'icon' => '⬆️', 'sort_order' => 7],
            ['label' => 'About', 'url' => '/#about', 'location' => 'footer', 'sort_order' => 1],
            ['label' => 'Contact', 'url' => '/#contact', 'location' => 'footer', 'sort_order' => 2],
            ['label' => 'Privacy Policy', 'url' => '/privacy', 'location' => 'footer', 'sort_order' => 3],
            ['label' => 'Terms of Service', 'url' => '/terms', 'location' => 'footer', 'sort_order' => 4],
        ];
        foreach ($items as $item) {
            MenuItem::create(array_merge($item, ['is_active' => true, 'target' => '_self']));
        }
    }
}