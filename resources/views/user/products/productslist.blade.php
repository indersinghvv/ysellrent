@extends('layouts.app')

@section('content')
<div class="container">
  @if (session()->has('success_message'))
  <div class="alert alert-success">
    {{ session()->get('success_message') }}
  </div>
  @endif
  @include('notification')
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  @include('user.navitem')
  <div class="card-body">
    <h5 class="card-title">Sell And Earn </h5>
    <a href="{{ route('sell.add') }}" class="btn btn-primary">Add New Product</a>
    <div class="row">
      <div class="col-12">

        @foreach ($userproductslists as $userproductslist)
        <div id="{{ $userproductslist->id }}" class="row p-2 mb-1 bg-white rounded shadow-sm">

          <div class="col-3 col-sm-2">
            <img src="{{ URL::to('/') .'/storage/thumbnails/'. $userproductslist->photo1 }}"
              class="img-fluid rounded shadow-sm" alt="..." width="60" height="70">
          </div>
          <div class="col-9 col-sm-10">


            <div class="row">
              <div class="col-8 col-sm-3 text-truncate">
                <div class="row">
                  <div class="col">
                    <button type="button" class="btn btn-link" data-toggle="modal" data-target="#productEditModal"
                    data-formaction="@if ($userproductslist->check_linked==1)
                    {{ route('sell.linkedupdate') }}
                    @else
                    {{ route('sell.update') }}
                    @endif"  
                    data-title="{{ $userproductslist->title }}"  
                     data-author="{{ $userproductslist->author }}"
                      data-productid="{{ $userproductslist->id }}"
                      data-originalprice="{{ $userproductslist->original_price }}"
                      data-sellingprice="{{ $userproductslist->selling_price }}"
                      data-stock="{{ $userproductslist->stock }}">@if ( $userproductslist->check_linked==1)
                      <i class="fa fa-chain"></i>
                      @endif{{ $userproductslist->title }}</button>
                    &nbsp;
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    Author-{{ $userproductslist->author }}
                  </div>
                </div>

              </div>
              <div class="col-1 col-sm-1">
                <a target="_blank" href="{{ URL::to('/') .'/p/'. $userproductslist->slug }}"><i
                    class="fa fa-external-link-square" style="font-size:18px;"></i></a>
              </div>


              <div class="col-12 col-sm-2">

                <div class="btn-group">
                  <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">

                    @if($userproductslist->check_public==1)
                    public
                    @else
                    private
                    @endif
                  </button>

                  <div class="dropdown-menu">
                    @if($userproductslist->check_public==1)
                    <form id="public_status_form{{ $userproductslist->id }}" method="POST"
                      action="@if ($userproductslist->check_linked==1)
                      {{ route('sell.updateLinkedPublic') }}
                      @else
                      {{ route('sell.updatePublic') }}
                      @endif">
                      @csrf
                      <input type="hidden" name="productid" value="{{ $userproductslist->id }}">
                      <input type="hidden" name="public_status" value="0">

                    </form>
                    <button type="button" class="dropdown-item btn btn-primary" onclick="event.preventDefault();
                document.getElementById('public_status_form{{ $userproductslist->id }}').submit();">private</button>
                    @else
                    <form id="public_status_form{{ $userproductslist->id }}" method="POST"
                      action="@if ($userproductslist->check_linked==1)
                      {{ route('sell.updateLinkedPublic') }}
                      @else
                      {{ route('sell.updatePublic') }}
                      @endif">
                      @csrf
                      <input type="hidden" name="productid" value="{{ $userproductslist->id }}">
                      <input type="hidden" name="public_status" value="1">

                    </form>

                    <button type="button" class="dropdown-item btn btn-primary"
                      onclick="event.preventDefault();
                  document.getElementById('public_status_form{{ $userproductslist->id }}').submit();">public</button>@endif
                  </div>
                </div>

              </div>
              <div class="col-6 col-sm-6">
                <div class="row">
                  <div class="col">
                    Stock-{{ $userproductslist->stock }}
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    Original Price-{{ $userproductslist->original_price }}
                  </div>
                </div>

              </div>
              <div class="col-6 col-sm-6">
                <div class="row">
                  <div class="col-12 col-sm-12">
                    sold-{{ $userproductslist->sold_unit }}
                  </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-12">
                    Selling Price-{{ $userproductslist->selling_price }}
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-4">

                Comments-0
                @if ( $userproductslist->check_linked==1)
                
                <a href="{{ route('sell.deletelinkedproduct',$userproductslist->id) }}">Delete</a>

                @else
                <a href="{{ route('sell.delete',$userproductslist->id) }}">Delete</a>

                @endif

              </div>
            </div>
          </div>

        </div>
        @endforeach

        <div class="modal fade" id="productEditModal" tabindex="-1" role="dialog"
          aria-labelledby="productEditModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="productEditModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="productEditForm" method="POST" action="">
                  @csrf
                  <input type="hidden" name="productid" class="form-control" id="inputProductid" value="">
                  <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Title:</label>
                    <input type="text" name="title" class="form-control" id="inputTitle" required>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-5">
                      <label for="inputAuthor">Author</label>
                      <input type="text" name="author" class="form-control" id="inputAuthor" required>
                    </div>
                    <div class="form-group col-6 col-md-4">
                      <label for="inputPrice">Original Price (INR)</label>
                      <input type="number" name="value" class="form-control" id="inputPrice" required>
                    </div>
                    <div class="form-group col-6 col-md-3">
                      <label for="inputSellingPrice">Selling Price</label>
                      <input type="number" name="sellingprice" class="form-control" id="inputSellingPrice" required>
                    </div>

                  </div>
                  <div class="form-group">
                    <label for="inputStock">Stock</label>
                    <input type="number" name="stock" class="form-control" id="inputStock" required>
                  </div>




                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="event.preventDefault();
                document.getElementById('productEditForm').submit();">Save</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="pagination" class="pagination justify-content-center mt-3">
    {{ $userproductslists->fragment('pagination')->onEachSide(5)->links() }}
  </div>
</div>
@endsection