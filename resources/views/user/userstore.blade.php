@extends('layouts.app')
@section('content')
<div class="container">


    <div class="row">
        <div class=" mt-n4 ">
            <img style="width:1375px; height:150px;"
                src="https://newwallpaperdownload.com/wallpapers/Black-Wallpaper-On-Wallpaper-Hd-30.jpg"
                class="img-fluid" alt="Responsive image">
        </div>
    </div>
    <div class="row">
        <div class="col-4 col-sm-2 mt-n4">
            <img src="https://instantglamour.com/wp-content/uploads/photo-gallery/Passport%20photo/pp-1.jpg"
                alt="Responsive image" width="100px" height="100px"
                class="img-thumbnail-fluid ml-5 mt-3 ml-n2 rounded-circle">
        </div>
        <div class="col-6 mt-2 col-sm-7">
            <h2>{{ $storename }} <i class="fa fa-check-circle"></i></h2>
            <h6>1000 followers </h6>
        </div>
        <div class="col-12 mt-2 col-sm-3">
            <button class="btn btn-danger btn-block">Follow</button><br>
            <div class="row">
                <div class="col-10">
                    <!-- Search form -->
                    <div class="md-form active-pink active-pink-2 mb-3 mt-0">
                        <input role="combobox" class="form-control border-top-0" type="text"
                            placeholder="Search in store" aria-label="Search">

                    </div>
                </div>
                <div class="col-2">
                    <button class="btn btn-danger align-right"><i class="fa fa-search"></i></button>
                </div>
            </div>

        </div>
    </div>
    <hr>
    <div class="container">
        <div class="row">
            @if($productlists->count()==null)
 no product is added
@else
            @foreach ($productlists as $productlist)
            <div class="col-sm-2">
                <div class="card">
                    <img src="{{ URL::to('/') .'/storage/thumbnails/'. $productlist->photo1 }}" class="card-img-top"
                        alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card with stretched link</h5>
                        <p class="card-text">Some quick example
                            cards content </p>
                        <a href="{{ URL::to('/') .'/p/'. $productlist->slug }}"
                            class="btn btn-primary stretched-link">Go somewhere</a>
                    </div>
                </div>
            </div>
            @endforeach
@endif
        </div>
    </div>



</div>
@endsection