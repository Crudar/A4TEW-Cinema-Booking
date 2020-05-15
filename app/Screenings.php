<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screenings extends Model
{
    public function reservations()
    {
        return $this->hasMany(Reservations::class);
    }

    public function movies()
    {
        return $this->belongsTo(Movies::class, 'movie_id', 'id');
    }

    public function halls()
    {
        return $this->belongsTo(Hall::class);
    }

    public static function delete_($id)
    {
        $reservedSeatsInfo = Reserved_seats::where('screening_id', $id)->get();

        foreach ($reservedSeatsInfo as $reservedSeat) {
            $reservedSeatsToDelete = Reserved_seats::where('seat_id', $reservedSeat->seat_id)->delete();

            $reservedSeatsInfo2 = Reserved_seats::where('reservation_id', $reservedSeat->reservation_id)->count();

            if ($reservedSeatsInfo2 == 0) {
                $reservationToDelete = Reservations::destroy($reservedSeat->reservation_id);
            }
        }

        $screeningDelete = Screenings::destroy($id);
    }
    public $timestamps = false;
}
