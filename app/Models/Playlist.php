<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id', 'is_public', 'cover_image'];

    protected $casts = ['is_public' => 'boolean'];

    public function user() { return $this->belongsTo(User::class); }
    public function tracks() { return $this->belongsToMany(Track::class, 'playlist_tracks')->withPivot('sort_order')->withTimestamps()->orderBy('pivot_sort_order'); }
}