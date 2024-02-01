<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;
use App\Models\Event;

class Attende extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'event_id',
        'movie_id',
        'show_time'
    ];

    protected $with = [
        'movie',
        'event'
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
