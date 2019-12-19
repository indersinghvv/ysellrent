@extends('layouts.app')

@section('content')
<div class="container">
  @include('user.navitem')
  <div class="card-body">
    <h5 class="card-title">Profile</h5>
    <p class="card-text">Name- {{ Auth::user()->name }}</p>
    <p class="card-text">Email- {{ Auth::user()->email }}</p>
    <p class="card-text">Your Store Name- <a href="{{ route('userstore',[ $temp_username]) }}" >{{ $temp_username }}</a>   <a href="{{ route('username.update.show') }}" class="btn  btn-outline-dark btn-sm {{ $status }}" role="button">edit</a></p>
    <a href="{{ route('myaddress') }}" class="btn btn-primary">My Address</a>
  </div>
</div>
</div>
@endsection