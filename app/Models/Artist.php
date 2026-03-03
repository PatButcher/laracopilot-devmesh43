<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'bio', 'country', 'website', 'image', 'is_verified'];

    protected $casts = ['is_verified' => 'boolean'];

    public function tracks() { return $this->hasMany(Track::class); }
    public function albums() { return $this->hasMany(Album::class); }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('images/default-artist.svg');
    }
}