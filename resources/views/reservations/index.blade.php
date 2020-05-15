@extends('layouts.pageLayout')

@section('content')
<div class="d-flex p-2 bd-highlight" style="flex-wrap: wrap">

    @foreach($reservationInfo as $info)

    <div class="card" style="margin: 10px">
        <div class="card-body">
            <div class="d-flex">
                <h5 class="card-title" style="margin:auto auto auto 0px">ID rezervácie: {{ $info["reservation_id"] }}</h5>
                <div class="p-2">
                    <form method="post" action="{{ route('reservations.destroy', $info['reservation_id']) }}">
                        @csrf
                        @method('DELETE')
                        <button class=" btn btn-danger" type="submit">X</button>
                    </form>
                </div>
            </div>
            <h6 class="card-title">Film: {{ $info["title"] }}</h6>
            <h6 class="card-title">Čas premietania: {{ \Carbon\Carbon::parse($info["screening_time"])->format('d.m. - H:i')}}</h6>
            <h6 class="card-title">Sála: {{$info["hall"]}}</h6>
            <h6 class="card-title">Miesta </h6>

            @foreach($info[0] as $seat)
            <h6 class="card-subtitle mb-2 text-muted">{{$seat["row"]}}. rada, číslo sedadla - {{$seat["number"]}}</h6>
            @endforeach
        </div>
    </div>
    @endforeach
</div>
@endsection