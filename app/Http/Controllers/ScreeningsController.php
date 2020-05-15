<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Movies;
use \App\Hall;
use \App\Reservations;
use App\Reserved_seats;
use \App\Seats;
use \App\Screenings;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class ScreeningsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$allScreenings = Screening::with('movies')->get();

        $allMovies = Movies::with('screenings')->get();

        //dd($allMovies->sortByDesc('id'));
        return view('screenings.index', ['allMovies' => $allMovies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $movies = Movies::all();
        $halls = Hall::all();

        return view('screenings.create', ['movies' => $movies, 'halls' => $halls]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        return redirect(route('screenings.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getScreening = new Seats();

        //$grouped = $getScreening->getData($id)->mapToGroups(function ($item, $key) {
        //return [$item->row => $item->number];
        // });

        //dd($grouped);
        //dd($getScreening->getData($id)->groupBy('row'));

        return view('screenings.show', ['screening' => $getScreening->getData($id)->groupBy('row'), 'screening_id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $screeningsDelete = Screenings::delete_($id);

        return redirect(route('screenings.index'));
    }
}
