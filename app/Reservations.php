<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reservations extends Model
{
    public function seats()
    {
        return $this->belongsToMany(Seats::class, 'reserved_seats', 'reservation_id', 'seat_id');
    }

    public function screenings()
    {
        return $this->belongsToMany(Screenings::class, 'reserved_seats', 'reservation_id', 'screening_id');
    }

    public function getAllReservationsViaUserID($user_id)
    {
        $seatsInfo = DB::table('reservations')
            ->join('reserved_seats', 'reservations.id', '=', 'reserved_seats.reservation_id')
            ->join('seats', 'seats.id', '=', 'reserved_seats.seat_id')
            ->join('screenings', 'screenings.id', '=', 'reserved_seats.screening_id')
            ->join('movies', 'movies.id', '=', 'screenings.movie_id')
            ->where('user_id', $user_id)
            ->get();

        return $seatsInfo;
    }

    public static function reservationToDisplay()
    {
        $getReservations = Reservations::with('seats', 'screenings')->where('user_id', auth()->user()->id)->get();

        $movieInfo = array();
        $temp_ = array();

        $finalInfo = array();

        foreach ($getReservations as $reservation) {
            foreach ($reservation->screenings as $screening) {
                $getMovie = Movies::where('id', $screening->movie_id)->first();
                $hall_name = Hall::select('name')->where('id', $screening->hall_id)->first();
                if (isset($movieInfo)) {
                    $movieInfo[$reservation->id] = array('reservation_id' => $reservation->id, 'title' => $getMovie->title, 'screening_time' => $screening->start_time, 'hall' => $hall_name->name);
                }
            }

            foreach ($reservation->seats as $seats) {
                array_push($temp_, ['reservation_id' => $reservation->id, 'row' => $seats->row, 'number' => $seats->number]);
            }
            $mergeTogether = array_merge($movieInfo[$reservation->id], array($temp_));

            array_push($finalInfo, $mergeTogether);

            $temp_ = array();
        }

        return $finalInfo;
    }
}
