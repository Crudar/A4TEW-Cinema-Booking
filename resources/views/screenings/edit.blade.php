@extends('layouts.pageLayout')

@section('content')

@foreach($screening as $screening)
<div class="container">
    <form action="" method="post">
        @csrf

        <div class="form-group">
            <label for="time">Dátum premietania</label>
            <input class="form-control" type="date" id="date" value="{{ \Carbon\Carbon::parse($screening->start_time)->format('d. m. Y')}}">
        </div>
        <div class="form-group">
            <label for="time">Čas premietania</label>
            <input class="form-control" type="time" id="time" value="{{ \Carbon\Carbon::parse($screening->start_time)->format('H:i')}}">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endforeach
@endsection