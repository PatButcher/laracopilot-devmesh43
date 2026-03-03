<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'color', 'icon'];

    public function tracks() { return $this->hasMany(Track::class); }
    public function channels() { return $this->hasMany(Channel::class); }
}