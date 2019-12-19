@extends('layouts.app')

@section('content')

<div class="container-fluid">
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
    @if ( !Cart::getTotalQuantity()<=0) @component('components.breadcrumbs') <a href="{{ route('/') }}">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Shopping Cart</span>
        @endcomponent
        <div class="row">
            <div class="col-12 col-sm-8 p-4 bg-white rounded shadow-sm mb-3">
                <!-- Shopping cart table -->

                <?php
                            $disabledcheckout='';
                            $spancheckout='';
                            $spanclose='';?>
                <div class="row">
                    @foreach ($cart as $pro)
                    <div class="col-3 col-sm-2 mb-3">
                        <img src="https://res.cloudinary.com/mhmd/image/upload/v1556670479/product-1_zrifhn.jpg" alt=""
                            width="70" class="img-fluid rounded shadow-sm">
                    </div>
                    <?php $productdetails=Userproduct::find($pro->id);?>
                    <div class="col-7 col-sm-8 mb-3">
                        <?php $slug=Userproduct::where('id', $pro->id)->value('slug'); ?>
                        <h5 class="mb-0"> <a href="{{ route('userproduct.slug',$slug) }}"
                                class="text-dark d-inline-block align-middle">{{ $pro->name }}</a></h5>
                        <span class="text-muted font-weight-normal font-italic d-block">Seller-{{ $pro->attributes->store_name }}
                            
                        </span>
                        <form id="deleteCartItem{{ $pro->id }}" action="{{ route('wishlist.add') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $pro->id }}" name="itemId">
                        </form>

                        @if($productdetails->delete_status==1||$productdetails->checkpublic==0||Userproduct::find($pro->id)->stock
                        <=0||$pro->
                            quantity>Userproduct::find($pro->id)->stock)
                            <span class="jk">out of stock</span>
                            <?php
                            
                            $disabledcheckout='disabled';
                            $spancheckout='<span data-toggle="popover" data-placement="top" data-trigger="hover" data-content="Some Product may be Out of stock ">';
                            
                            ?>
                            @else
                            <?php
                                        if($pro->quantity==Userproduct::find($pro->id)->stock){
                                            $span='<span class="d-inline-block" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="limited stock ">';
                                            $style='style="pointer-events: none;"';
                                            $disabled='disabled';
                                            $spanclose='</span>';
                                        }
                                        else{
                                            $span='';
                                            $style='';
                                            $disabled='';
                                            $spanclose='';
                                        }
                                        ?>
                            <a class="btn btn-primary btn-sm 
                            @if($pro->quantity==1) disabled @endif"
                                href="{{ url('go/cart/update') }}/{{ $pro->id }}/{{ $pro->quantity-1 }}"
                                role="button">-</a>
                            {{ $pro->quantity }}

                            {!! $span !!}
                            <a {{ $style }} class="btn btn-primary btn-sm {{ $disabled }}"
                                href="{{ url('go/cart/update') }}/{{ $pro->id }}/{{ $pro->quantity+1 }}"
                                role="button">+</a>{!! $spanclose !!}
                            @endif
                            <span class="ml-n1"><button type="submit" class="btn btn-link"
                                    onclick="document.getElementById('deleteCartItem{{ $pro->id }}').submit();">Add To
                                    Wishlist</button> | <a href="{{ url('go/cart/remove')}}/{{ $pro->id }}"
                                    class="text-dark"><i class="fa fa-trash"></i>Delete</a></span>

                    </div>
                    <div class="col-2 col-sm-2 mb-3">


                        <strong>$ {{ $pro->price }}</strong>
                    </div>
                    @endforeach
                </div>
                <hr>
                <p class="text-right font-weight-bold text-danger">Subtotal ({{ Cart::getTotalQuantity() }} items): $
                    {{ Cart::getSubTotal()}}</p>
                <!-- End -->
            </div>
            <div class="col-12 col-sm-4 mb-4">
                <div class="card" style="width: 100%">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold text-danger">Subtotal ({{ Cart::getTotalQuantity() }}
                            items): $
                            {{ Cart::getSubTotal()}}</h5>



                        <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg btn-block " role="button"
                            aria-disabled="true">Checkout</a>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-muted">You have to pay security of this book.Dont worry u will
                            get refund after return!! </li>
                    </ul>
                </div>




            </div>
        </div>


        @else
        <h2>Your Cart is Empty</h2>
        @endif
        <div class="row">
            <div class="col-12 col-md-8">
                @if ($wishlist->count() > 0)
                <h2>{{ $wishlist->count() }} item(s) Saved For Later</h2>
                @foreach ($wishlist as $item)
                <div class="row p-2 mb-1 bg-white rounded shadow-sm">
                    <div class="col-2">
                        <img src="https://res.cloudinary.com/mhmd/image/upload/v1556670479/product-1_zrifhn.jpg" alt=""
                            width="70" class="img-fluid rounded shadow-sm">
                    </div>
                    <div class="col-8">
                        <h5 class="text-left">
                            <?php $slug1=Userproduct::where('id', $item->id)->value('slug'); ?>
                            <a href="{{ route('userproduct.slug',$slug1) }}">{{ $item->name }}</a></h5>
                        <div class="row">
                            <div class="col">
                                <form action="{{ route('wishlist.delete', $item->id) }}" method="POST">
                                    {{ csrf_field() }}

                                    <button type="submit" class="btn btn-link">Remove</button>
                                </form>
                            </div>
                            <div class="col">
                                <form method="POST" action="{{ route('wishlist.move2cart') }}" >
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <button type="submit" class="btn btn-link">Move to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <strong>$ {{ $item->price }}</strong>
                    </div>
                </div>
                @endforeach
                @else

                <h3>You have no items Saved for Later.</h3>

                @endif

            </div>
            <div class="col-4">

            </div>
        </div>

</div>
@endsection