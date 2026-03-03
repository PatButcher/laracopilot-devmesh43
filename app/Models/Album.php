<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Album extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'artist_id', 'release_year', 'description', 'cover_image'];

    protected $casts = ['release_year' => 'integer'];

    public function artist() { return $this->belongsTo(Artist::class); }
    public function tracks() { return $this->hasMany(Track::class); }

    public function getCoverUrlAttribute()
    {
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : asset('images/default-cover.svg');
    }
}