<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Track extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'user_id', 'artist_id', 'album_id', 'genre_id',
        'description', 'audio_path', 'cover_image', 'duration',
        'play_count', 'tags', 'is_published', 'track_number', 'lyrics',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'play_count' => 'integer',
        'duration' => 'integer',
        'track_number' => 'integer',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function artist() { return $this->belongsTo(Artist::class); }
    public function album() { return $this->belongsTo(Album::class); }
    public function genre() { return $this->belongsTo(Genre::class); }
    public function playlists() { return $this->belongsToMany(Playlist::class, 'playlist_tracks')->withPivot('sort_order')->withTimestamps(); }
    public function favourites() { return $this->hasMany(Favourite::class); }

    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) return '0:00';
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        return $minutes . ':' . str_pad($seconds, 2, '0', STR_PAD_LEFT);
    }

    public function getCoverUrlAttribute()
    {
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : asset('images/default-cover.svg');
    }

    public function getAudioUrlAttribute()
    {
        return $this->audio_path ? asset('storage/' . $this->audio_path) : null;
    }
}