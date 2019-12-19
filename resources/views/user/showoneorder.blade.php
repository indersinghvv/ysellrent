@extends('layouts.app')

@section('content')
<div class="container">
    @include('user.navitem')
    <div class="card-body">
        <h5 class="card-title">Orders Details</h5>
        <p class="card-text">
            <div class="row">
                <div class="col-sm-3">
                    ordered on {{ $order->created_at }}
                </div>
                <div class="col-sm-3">
                    <p>| order# {{ $order->id }} </p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="row ">
                            <div class="col-sm-4 text-left">
                                <p class="font-weight-bold">&nbsp;&nbsp;Shipping Address</p>
                                <h5 class="card-title">{{ $order->billing_name }}</h5>
                                
                                <p class="card-text">{{ $order->billing_address }}<br>
                                    {{ $order->billing_city }}, {{ $order->billing_province }} {{ $order->billing_postalcode }}<br>
                                {{ $order->billing_country }}</p>
                            </div>
                            <div class="col-sm-4 text-left">
                                <p class="font-weight-bold">&nbsp;&nbsp;Shipping Address</p>
                                <p class="card-body">{{ $order->user->name }}
                                </p>
                            </div>
                            <div class="col-sm-4 text-left">
                                <p class="font-weight-bold">&nbsp;&nbsp;Shipping Address</p>
                                <p class="card-body">{{ $order->user->name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </p>
    </div>
</div>
</div>
@endsection