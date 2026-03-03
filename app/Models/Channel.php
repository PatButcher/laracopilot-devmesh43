<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'type', 'genre_id', 'color', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean', 'sort_order' => 'integer'];

    public function genre() { return $this->belongsTo(Genre::class); }
    public function tracks() { return $this->hasManyThrough(Track::class, Genre::class, 'id', 'genre_id', 'genre_id', 'id'); }
}