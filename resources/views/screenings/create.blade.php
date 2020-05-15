@extends('layouts.pageLayout')

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container">
    <form action="{{ route('screenings.store')}}" method="post">
        @csrf

        <div class="form-group">
            <label for="movie">Film</label>
            <select class="form-control" id="movie" name="movie">
                @foreach($movies as $movie)
                <option value="{{$movie->id}}">{{$movie->title}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="movie">Sála</label>
            <select class="form-control" id="hall" name="hall">
                @foreach($halls as $hall)
                <option value="{{$hall->id}}">{{$hall->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="date">Dátum premietania</label>
            <input type="date" class="form-control" name="date" id="date" aria-describedby="helpId" placeholder="">
        </div>

        <div class="form-group">
            <label for="time">Čas premietania</label>
            <input type="time" class="form-control" name="time" id="time" aria-describedby="helpId" placeholder="">
        </div>

        <button type="submit" class="btn btn-primary">Potvrď</button>
    </form>
</div>
@endsection