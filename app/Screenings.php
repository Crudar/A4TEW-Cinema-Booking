<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public static function validate_store($request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'time' => 'date_format:H:i'
        ]);

        $screenings = DB::table('screenings')->select('start_time', 'hall_id', 'movies.length')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->whereRaw(DB::raw('date(start_time) = ? '))
            ->setBindings([$request->date, $request->date])
            ->get();

        foreach ($screenings as $screening) {
            $maxScreening_start = Carbon::parse($screening->start_time);

            $maxScreening_end = Carbon::parse($screening->start_time);

            $maxScreening_end->addMinutes($screening->length);  // priratanie dlzky filmu
            $maxScreening_end->addMinutes(30);  // priratanie dlzky upratovania cca

            $insertedScreeningToParse = $request->date . ' ' . $request->time;

            $insertedScreeningDateTime_start = Carbon::parse($insertedScreeningToParse);
            $insertedScreeningDateTime_end = Carbon::parse($insertedScreeningToParse);

            $insertedMovieLength = Movies::select('length')->where('id', $request->movie)->first();

            $insertedScreeningDateTime_end->addMinutes($insertedMovieLength->length);
            $insertedScreeningDateTime_end->addMinutes(30);

            //dd($maxScreening_start, $maxScreening_end, $insertedScreeningDateTime_start, $insertedScreeningDateTime_end);
            if (($maxScreening_start <= $insertedScreeningDateTime_end) && ($maxScreening_end >= $insertedScreeningDateTime_start) && ((intval($request->hall)) == $screening->hall_id)) {
                throw ValidationException::withMessages(['time' => 'Čas medzi dvomi premietaniami musí byť väčší ako 30 minút.']);
            }
        }

        $screening = new Screenings();

        $screening->movie_id = $request->movie;
        $screening->start_time = $insertedScreeningDateTime_start;
        $screening->hall_id = $request->hall;

        $screening->save();
    }

    public $timestamps = false;
}
