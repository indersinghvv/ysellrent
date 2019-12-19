@extends('layouts.app')

@section('content')
<div class="container">
        
                @if (session()->has('success_message'))
                <div class="alert alert-success">
                  {{ session()->get('success_message') }}
                </div>
                @endif
                @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                  @endif
        
        @if ($searchResults-> isEmpty())
        <h2>Sorry, no results found for the term <b>"{{ $searchterm }}"</b>.</h2>
    @else
    <h6>There are {{ $searchResults->count() }} results for the term <b>"{{ $searchterm }}"</b></h6>
                    <hr />
                    <div class="row ">

                        @foreach ($searchResults as $productlist)
                        <div class="col-6 col-sm-4 col-md-2 col-lg-2">
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
                        {{ $searchResults->onEachSide(5)->links() }}
                        </div>
              @endif

    
</div>
@endsection