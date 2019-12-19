@extends('layouts.app')

@section('content')
@component('components.breadcrumbs')
<a href="{{ route('dashboard') }}">Dashboard</a>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<a href="{{ route('myorder.all') }}">My Order</a>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<span>Buy</span>
@endcomponent
<div class="container">
  @include('user.navitem')

  <div class="card-body">
    <div class="row">

      @foreach ($orders as $order)
      <div class="col-sm-12 mb-3">

        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-6 col-sm-2">
                <div class=" text-left " style="font: 12px arial, sans-serif;">ORDER PLACED<br>{{ $order->created_at->format('d M Y') }}</div>
              </div>
              <div class="col-6 col-sm-2 ">
                  <div class=" text-left" style="font: 12px arial, sans-serif;">TOTAL<br>{{ $order->billing_total }}</div>
                </div>
              <div class="col-6 col-sm-6 ">
                  
                      <div class=" text-left" style="font: 12px arial, sans-serif;">SHIP TO<br>
                        <span class="d-inline-block" data-html="true" data-trigger="hover" data-placement="bottom" data-toggle="popover" data-content="<b>{{ $order->billing_name }}</b><br>{{ $order->billing_address}}<br>{{ $order->billing_city }}<br>{{ $order->billing_privince }} {{ $order->billing_postalcode }}<br>{{ $order->billing_country }}">
                            <a href="#" style="pointer-events: none;"  >{{ $order->billing_name }}</a><i class="fa fa-chevron-down" aria-hidden="true"></i>
                          </span>
                      </div>
                    
              </div>
              <div class="col-6 col-sm-2">
                  <div class=" text-left" style="font: 12px arial, sans-serif;">ORDER #{{ $order->id }}<br><a href="{{ route('myorder.onebuyorder',$order->id) }}">Order Details | fgdg</a></div>
              </div>
            </div>
          </div>
          <ul class="list-group list-group-flush">
            @foreach ($order->userproduct as $item)
            <li class="list-group-item">
              <div class="row">
                <div class="col-6 col-sm-2">
                    <img src="{{ url('/storage/thumbnails') }}/{{ $item->photo1  }}" class="img-fluid" style="width:65px; height:100px " alt="Responsive image">
                </div>
                <div class="col-6 col-sm-6 text-left">
                  <a href="{{ url('/p') }}/{{ $item->slug }}">{{ $item->title }}</a>
                   <?php $userid=Userproduct::find($item->id)->user->id;
                   $username=Username::where('user_id',$userid)->value('username');
                   if($username==null){
                    $username=Username::where('user_id',$userid)->value('temp_username');
                   }
                   ?>
                  <p>Sold by-<a href="{{ route('/') }}/{{ $username }}">{{$username }}</a></p>
                  
                </div>
                <div class="col-12 col-sm-4">
                  <a class="btn btn-outline-dark btn-block btn-sm" role="button" href="#">Write a product review</a>
                </div>
              </div>


            </li>
            @endforeach
          </ul>


        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
</div>
@endsection