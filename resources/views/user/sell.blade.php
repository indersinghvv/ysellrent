@extends('layouts.app')

@section('content')
<div class="container">
    @include('user.navitem') 
    <div class="card-body">
        <h5 class="card-title">Sell And Earn </h5> 
        <a href="{{ url('user/products/add') }}"class="btn btn-primary">Add New Product</a>
      </div>
    </div>
</div>
@endsection