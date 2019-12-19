@extends('layouts.app')

@section('content')
<div class="container">
  @if (session()->has('success_message'))
  <div class="alert alert-success">
    {{ session()->get('success_message') }}
  </div>
  @endif
  @if (session()->has('danger_message'))
  <div class="alert alert-danger">
    {{ session()->get('danger_message') }}
  </div>
  @endif
  @include('notification')
  @if(count($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <div class="row">
    <div class="col-12 col-md-4">
      <img src="/storage/images/{{$products->photo1}}" class="img-fluid rounded mx-auto d-block" alt="">
    </div>
    <div class="col-12 col-md-4">
      <div class="row">

      </div>
      <hr>
      <h3 class="text-capitalize">{{ $products->title }} </h3>
      <h6 class="text-capitalize">Author- {{ $products->author }}</h6>
      <h6 class="text-capitalize">Stock- {{ $stock }}</h6>
      @if($linkedstorename[0]=='0')
      <h6 class="text-capitalize">
        <?php 
        $storename=$products->user->username->username;
        $temp_storename=$products->user->username->temp_username;
        ?>
        @if($storename==null)
        <a href="{{ route('userstore',$temp_storename) }}">{{ $temp_storename }}</a>        
        @else
        <a href="{{ route('userstore',$storename) }}">{{ $storename }}</a>
        @endif
        </h6>
      @else
      
      @if (count($linkedstorename)==1)
      <a href="{{ route('userstore',$linkedstorename[0]) }}">{{ $linkedstorename[0] }}</a>
             
      @else

      <div class="btn-group">
          <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            {{ $linkedstorename[0] }}
          </button>
          
          <div class="dropdown-menu">
            
            @foreach ($linkedstorename as $linkedstore)
            <a class="dropdown-item" href="{{ route('userstore', $linkedstore) }}">{{ $linkedstore }}</a> 
            @endforeach
            
          </div>
        </div>
        @endif
      @endif
      <a target="_blank" href="{{ route('userstore', $linkedstorename[0]) }}"><i
        class="fa fa-external-link-square" style="font-size:18px;"></i></a>
    </div>
    <div class="col-12 col-md-4 ">
      <div class="card " style="width: 18rem;">
        <div class="card-body">
          <h4>Buy New Price {{ $products->sellingprice }}</h4>
          <form method="POST" action="{{ route('cart.additem') }}">
            @csrf
           <input type="hidden" name="store_name" value="{{ $linkedstorename[0] }}">
           <input type="hidden" name="product_id" value="{{ $products->id }}">
           @if($linkedstorename[0]=='0')
           <button class="btn btn-danger btn-block" type="button" >Out Of Stock</button>
      @else
      <button class="btn btn-success btn-block" type="submit">Add To Cart</button>
      @endif
           
          </form>
          <div class="text-center">
              <a  href="{{ route('sell.AddUsersProduct',$products->id) }}">Sell This Product</a>
          </div>
          
        </div>

      </div>
    </div>

  </div>
  @endsection