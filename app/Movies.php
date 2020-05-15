<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movies extends Model
{
    public function screenings()
    {
        return $this->hasMany(Screenings::class, 'movie_id', 'id')->orderBy('start_time');;
    }
    public $timestamps = false;
}
