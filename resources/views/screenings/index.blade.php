@extends('layouts.pageLayout')

@section('content')
<div class="d-flex p-2 bd-highlight" style="flex-wrap: wrap">
    @foreach($allMovies as $movie)
    <div class="card" style="max-width: 456px; margin: 10px">
        <div class="d-flex" style="text-align:center">
            <h5 class="card-title" style="margin:auto auto auto 21px">{{ $movie->title }}</h5>
            @if(auth()->user()->is_admin == 1)
            <div class="p-2">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Administrácia
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <form method="post" action="{{ route('movies.destroy', $movie->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger dropdown-item" type="submit">Odstrániť film a premietania</button>
                        </form>
                        <a class="dropdown-item" href="{{ route('movies.edit', $movie->id) }}">Zmena údajov o filme</a>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">Dĺžka filmu: {{$movie->length}} minút</h6>
            <h6 class="card-subtitle mb-2 text-muted">Žáner: {{$movie->genre}}</h6>
            <h6 class="card-subtitle mb-2 text-muted">Krajina: {{$movie->country}}</h6>
            <h6 class="card-subtitle mb-2 text-muted">Režisér/i: {{$movie->directors}}</h6>
            <h6 class="card-subtitle mb-2 text-muted">Scenárista/i: {{$movie->writers}}</h6>
            <h6 class="card-subtitle mb-2 text-muted">Hrajú: {{$movie->actors}}</h6>
            <h6 class="card-subtitle mb-2 text-muted"><b>Časy premietania:</b> </h6>

            @if($movie->screenings->isEmpty())
            <b>PRIPRAVUJEME</b>
            @endif

            @foreach($movie->screenings as $time)
            @if(auth()->user()->is_admin == 1)
            <form method="post" action="{{ route('screenings.destroy', $time->id) }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">{{ \Carbon\Carbon::parse($time->start_time)->format('d.m. - H:i')}}</button>
            </form>
            @else
            <a class="btn btn-primary" href="{{ route('screenings.show', $time->id) }}" role="button">{{ \Carbon\Carbon::parse($time->start_time)->format('d.m. - H:i')}}</a>
            @endif
            @endforeach
        </div>
    </div>
    @endforeach
</div>
@endsection