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
    <form action="{{ route('movies.store')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Názov</label>
            <input type="text" class="form-control" name="title" id="title" aria-describedby="helpId" placeholder="">
        </div>

        <div class="form-group">
            <label for="length">Dĺžka filmu</label>
            <input type="text" class="form-control" name="length" id="length" aria-describedby="helpId" placeholder="">
        </div>

        <div class="form-group">
            <label for="genre">Žáner</label>
            <input type="text" class="form-control" name="genre" id="genre" aria-describedby="helpId" placeholder="">
        </div>

        <div class="form-group">
            <label for="country">Krajina</label>
            <input type="text" class="form-control" name="country" id="country" aria-describedby="helpId" placeholder="">
        </div>

        <div class="form-group">
            <label for="directors">Režisér/i</label>
            <input type="text" class="form-control" name="directors" id="directors" aria-describedby="helpId" placeholder="">
        </div>

        <div class="form-group">
            <label for="writers">Scénarista/i</label>
            <input type="text" class="form-control" name="writers" id="writers" aria-describedby="helpId" placeholder="">
        </div>

        <div class="form-group">
            <label for="actors">Hrajú</label>
            <input type="text" class="form-control" name="actors" id="actors" aria-describedby="helpId" placeholder="">
        </div>

        <button type="submit" class="btn btn-primary">Potvrď</button>
    </form>
</div>
@endsection