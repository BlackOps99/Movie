<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\ImageTypeCast;
use App\Models\Showtime;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'picture',
        'description',
        'active'
    ];

    protected $with = [
        'showTimes'
    ];

    protected $casts = [
        'picture' => ImageTypeCast::class,
    ];

    public function showTimes()
    {
        return $this->hasMany(Showtime::class, 'movie_id');
    }
}
