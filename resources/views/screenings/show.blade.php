@extends('layouts.pageLayout')

@section('content')
<div class="container">
    <form action="{{ route('reservations.store') }}" method="post">
        @csrf
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="hidden" id="" name='screening_id' value="{{$screening_id}}">
        </div>
        <label> Výber sedadiel: </label>
        @foreach($screening as $screening)
        <div>
            @foreach($screening as $row)
            @if($row->reservation_id == null)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="{{ $row->row }}-{{ $row->number }}" name='seats[]' value='{{$row->id}}'>
                <label class="form-check-label" for="{{ $row->row }}-{{ $row->number }}" style="background-color:  #48e90c">{{ $row->row }} - {{ $row->number }}</label>
            </div>
            @else
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="{{ $row->row }}-{{ $row->number }}" name='seats[]' value="{{$row->id}}" disabled>
                <label class="form-check-label" for="{{ $row->row }}-{{ $row->number }}" style="background-color: #f25153">{{ $row->row }} - {{ $row->number }}</label>
            </div>
            @endif
            </label>
            @endforeach
        </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Potvrď</button>
    </form>
</div>
@endsection