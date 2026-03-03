<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artist;

class ArtistSeeder extends Seeder
{
    public function run(): void
    {
        $artists = [
            ['name' => 'Nova Echo', 'slug' => 'nova-echo', 'bio' => 'Electronic music producer from Berlin known for deep atmospheric soundscapes.', 'country' => 'Germany', 'is_verified' => true],
            ['name' => 'Kai Rivers', 'slug' => 'kai-rivers', 'bio' => 'Hip hop artist blending storytelling with modern trap production.', 'country' => 'United States', 'is_verified' => true],
            ['name' => 'Luna Solis', 'slug' => 'luna-solis', 'bio' => 'Indie pop singer-songwriter with ethereal vocals and dreamy production.', 'country' => 'United Kingdom', 'is_verified' => true],
            ['name' => 'The Midnight Grove', 'slug' => 'the-midnight-grove', 'bio' => 'Jazz fusion quartet pushing the boundaries of contemporary jazz.', 'country' => 'France', 'is_verified' => false],
            ['name' => 'Axel Storm', 'slug' => 'axel-storm', 'bio' => 'Rock guitarist and vocalist leading the new wave of alternative rock.', 'country' => 'Australia', 'is_verified' => true],
            ['name' => 'Priya Nair', 'slug' => 'priya-nair', 'bio' => 'R&B vocalist weaving soulful melodies with modern production.', 'country' => 'India', 'is_verified' => false],
            ['name' => 'Static Pulse', 'slug' => 'static-pulse', 'bio' => 'Techno and industrial electronic project from Tokyo.', 'country' => 'Japan', 'is_verified' => true],
            ['name' => 'Ella Forrest', 'slug' => 'ella-forrest', 'bio' => 'Folk artist with haunting acoustic compositions and lyrical storytelling.', 'country' => 'Canada', 'is_verified' => false],
            ['name' => 'Ironwave', 'slug' => 'ironwave', 'bio' => 'Progressive metal band redefining the boundaries of heavy music.', 'country' => 'Sweden', 'is_verified' => false],
            ['name' => 'Cello Collective', 'slug' => 'cello-collective', 'bio' => 'Contemporary classical ensemble bringing orchestral music to new audiences.', 'country' => 'Austria', 'is_verified' => true],
            ['name' => 'Dusk Garden', 'slug' => 'dusk-garden', 'bio' => 'Ambient producer creating meditative soundscapes for mind and body.', 'country' => 'Netherlands', 'is_verified' => false],
            ['name' => 'Rio Vibes', 'slug' => 'rio-vibes', 'bio' => 'Reggae and funk fusion artist spreading positive rhythms worldwide.', 'country' => 'Brazil', 'is_verified' => false],
        ];
        foreach ($artists as $artist) {
            Artist::updateOrCreate(['slug' => $artist['slug']], $artist);
        }
    }
}