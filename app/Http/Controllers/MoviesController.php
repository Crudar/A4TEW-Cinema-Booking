<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Movies;
use \App\Hall;
use \App\Seats;
use \App\Screenings;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('movies.create');
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
            'title' => 'required|max:255',
            'length' => 'required|int',
            'genre' => 'required|max:255',
            'country' => 'required|max:255',
            'directors' => 'required|max:255',
            'writers' => 'required|max:255',
            'actors' => 'required|max:255',
        ]);

        $movie = new Movies();

        $movie->title = $request->title;
        $movie->length = $request->length;
        $movie->genre = $request->genre;
        $movie->country = $request->country;
        $movie->directors = $request->directors;
        $movie->writers = $request->writers;
        $movie->actors = $request->actors;

        $movie->save();

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $getMovie = Movies::where('id', $id)->get();

        return view('movies.edit', ['movie' => $getMovie]);
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
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'length' => 'required|int',
            'genre' => 'required|max:255',
            'country' => 'required|max:255',
            'directors' => 'required|max:255',
            'writers' => 'required|max:255',
            'actors' => 'required|max:255',
        ]);

        $movie = Movies::find($id);

        $movie->title = $request->title;
        $movie->length = $request->length;
        $movie->genre = $request->genre;
        $movie->country = $request->country;
        $movie->directors = $request->directors;
        $movie->writers = $request->writers;
        $movie->actors = $request->actors;

        $movie->save();

        return redirect(route('screenings.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movieToDelete = Screenings::where('screenings.movie_id', $id)->get();

        foreach ($movieToDelete as $screeningToDelete) {
            $screeningsDelete = Screenings::delete_($screeningToDelete->id);
        }

        $movieDelete = Movies::destroy($id);

        return redirect(route('screenings.index'));
    }
}
