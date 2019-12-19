@extends('layouts.app')

@section('content')

<div class="container">
  @include('user.navitem')
  <div class="card-body">
    <h5 class="card-title">Sell And Earn </h5>
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div><br />
    @endif
    <a href="{{ route('sell.add') }}" class="btn btn-primary">Add New Product</a>
    
    <form method="POST" enctype="multipart/form-data" action="{{ route('sell.store') }}">
      @csrf
      <div class="form-group">
        <label for="formGroupExampleInput">Title of book</label>
        <input type="text" name="title" class="form-control" id="formGroupExampleInput" placeholder="title" required>
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2">Author</label>
        <input type="text" name="author" class="form-control" id="formGroupExampleInput2" placeholder="Author name" required>
      </div>
      
      <div class="form-group">
        <label for="formGroupExampleInput2">image</label>
        <input type="file" name="photo1" onchange="readURL(this);" class="form-control" placeholder="Stock" required>
        
      </div>
      <img id="photo1" src="#" alt="your image" />
      <div class="form-group">
        <label for="formGroupExampleInput2">Stock</label>
        <input type="number" name="stock" class="form-control" id="formGroupExampleInput2" placeholder="Stock" required>
      </div>
      
      <div class="form-check">
        <label for="formGroupExampleInput2">Shipping Service</label></br>
        <input class="form-check-input" type="radio" name="shippingservice" id="shippingservice1" value="0" checked>
        <label class="form-check-label" for="shippingservice1">
          No
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="shippingservice" id="shippingservice2" value="1">
        <label class="form-check-label" for="shippingservice2">
          Yes
        </label>
      </div>
      
      <div class="form-group">
        <label for="formGroupExampleInput2">Value(orginal Price of Book)</label>
        <input type="number" name="value" class="form-control" id="formGroupExampleInput2" placeholder="Value" required>
      </div>
      <div class="form-group">
          <label for="formGroupExampleInput2">Selling Price</label>
          <input type="number" name="selling_price" class="form-control" id="formGroupExampleInput2" placeholder="Selling Price" required>
        </div>
      <div class="form-check">
        <label for="formGroupExampleInput2">Condition of book</label></br>
        <input class="form-check-input" type="radio" name="Condition" id="Condition1" value="New" checked>
        <label class="form-check-label" for="Condition1">
          New
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="Condition" id="Condition2" value="used">
        <label class="form-check-label" for="Condition2">
          Used
        </label>
      </div>
      <div class="form-check">
        <label for="formGroupExampleInput2">Available for rent/sell</label></br>
        <input class="form-check-input" type="radio" name="Available4sell" id="Available4sell1" value="Both" checked>
        <label class="form-check-label" for="Available4sell1">
          Both
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="Available4sell" id="Available4sell2" value="Sell">
        <label class="form-check-label" for="Available4sell2">
          Sell
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="Available4sell" id="Available4sell2" value="Rent">
        <label class="form-check-label" for="Available4sell2">
          Rent
        </label>
      </div>
      <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
  </div>
</div>
</div>
@endsection