<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventMovies extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'movie_id',
        'movie_time'
    ];

    protected $with = [
        'movie',
        'event'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }
}
