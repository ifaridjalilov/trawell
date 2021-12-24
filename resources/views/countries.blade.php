@extends('layout')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="card">
            <ul class="list-group list-group-flush">
                @foreach($countries as $country)
                    <a href="{{ route('countries_show', $country->id) }}" class="list-group-item list-group-item-action">{{ $country->display_name }}</a>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
