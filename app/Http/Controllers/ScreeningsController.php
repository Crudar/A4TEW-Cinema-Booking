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
        $store = Screenings::validate_store($request);

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
