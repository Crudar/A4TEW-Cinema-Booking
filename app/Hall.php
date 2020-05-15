<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    public function screenings()
    {
        return $this->hasMany(Screenings::class);
    }

    public function seats()
    {
        return $this->hasMany(Seats::class);
    }
}
