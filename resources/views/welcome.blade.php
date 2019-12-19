@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        @foreach ($productlists as $productlist)
        <div class="col-6 col-sm-4 col-md-2 col-lg-2 mb-3">
            <div class="card">
                <a href="{{ URL::to('/') .'/p/'. $productlist->slug }}" class="stretched-link">
                <img src="{{ URL::to('/') .'/storage/thumbnails/'. $productlist->photo1 }}" class="img-fluid card-img-top" alt="..."></a>
                <div class="text-center mt-2">
                    <h5 class="card-title font-weight-bolder" style="font-size:16px">{{ $productlist->title }}</h5>
                    <h5 class="card-title font-weight-bolder" style="font-size:12px"> by {{ $productlist->author }}</h5>
                    <p class="card-text"><span class="font-weight-lighter" style="font-size:11px"><strike>₹{{ $productlist->original_price }}&nbsp;</strike></span>
                    <span class="font-weight-bolder" style="font-size:15px"> ₹ {{ $productlist->selling_price }}</span></p>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    <div class="pagination justify-content-center mt-3">
        {{ $productlists->onEachSide(5)->links() }}
        </div>
</div>
@endsection