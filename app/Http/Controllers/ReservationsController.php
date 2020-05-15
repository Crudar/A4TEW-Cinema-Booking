<?php

namespace App\Http\Controllers;

use App\Hall;
use Illuminate\Http\Request;
use App\Reservations;
use App\Reserved_seats;
use App\Movies;

class ReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $finalInfo = Reservations::reservationToDisplay();

        return view('reservations.index', ['reservationInfo' => $finalInfo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newReservation = new Reservations();
        $newReservation->user_id = auth()->user()->id;
        $newReservation->save();

        foreach ($request->seats as $seatId) {
            $newReservedSeats = new Reserved_seats();
            $newReservedSeats->reservation_id = $newReservation->id;
            $newReservedSeats->screening_id = $request->screening_id;
            $newReservedSeats->seat_id = $seatId;
            $newReservedSeats->save();
        }

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
        return view('reservations.show');
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
        $seatsToDelete = Reserved_seats::where('reservation_id', $id)->delete();
        $reservationToDelete = Reservations::destroy($id);

        return redirect(route('reservations.index'));
    }
}
