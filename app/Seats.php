<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Seats extends Model
{
    public function reservations()

    {

        return $this->belongsToMany(Reservations::class, 'reserved_seats');
    }

    public function halls()
    {
        return $this->belongsTo(Hall::class);
    }

    public function getData($screening_id)  // funkcia pre zistenie haly v ktorej sa ma hrat film o danom case z id zo screeningu
    {
        $seatsInfo = DB::table('seats')
            ->leftJoin('reserved_seats', function ($join) use ($screening_id) {
                $join->on('reserved_seats.seat_id', '=', 'seats.id')->where('reserved_seats.screening_id', '=', $screening_id);
            })
            ->orderBy('row', 'asc')
            ->orderBy('number', 'asc')
            ->get();

        return $seatsInfo;
    }
}
