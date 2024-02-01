<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EventMovies;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'event_time',
        'active'
    ];

    public function event_movies()
    {
        return $this->hasMany(EventMovies::class, 'event_id');
    }
}
