<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;

class Showtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'datetime',
        'time',
        'movie_id',
        'active'
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }
}
