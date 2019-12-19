@extends('layouts.app')

@section('content')
<div class="container">
    @include('user.navitem')
    <div class="card-body">
        <div class="row">
            @foreach ($myaddresses as $address)
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $address->fullname }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $address->fullAddress }}</h6>
                        <p class="card-text">{{ $address->city }}, {{ $address->state }},
                            {{ $address->country }}-{{ $address->zip }} </p>
                        <p class="card-text">Phone-{{ $address->phone }}</p>
                        <a href="{{ url('user/myaddress/delete') }}/{{ $address->id }}" class="btn btn-outline-primary btn-sm" role="button" aria-pressed="true">Edit</a>
                       
                        <a href="{{ url('user/myaddress/delete') }}/{{ $address->id }}" class="btn btn-outline-danger btn-sm" role="button" aria-pressed="true">Delete</a>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</div>
@endsection