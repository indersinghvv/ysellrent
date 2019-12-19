@extends('layouts.app')

@section('content')

<div class="container">
    
    <div class="card-body">
        <h5 class="card-title">Dasboard</h5>
        <div class="card-deck">
        <div class="card border-danger mb-3" style="max-width: 18rem;">
            <div class="card-header">Buy</div>
            <div class="card-body text-danger">
              <h5 class="card-title">Danger card title</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
          <div class="card border-success mb-3" style="max-width: 18rem;">
              <div class="card-header">Sell</div>
              <div class="card-body text-success">
                <h5 class="card-title">Danger card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              </div>
            </div>
            <div class="card border-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">Rent</div>
                <div class="card-body text-primary">
                  <h5 class="card-title">Danger card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
              </div>
        </div>
        
      
    </div>
</div>
@endsection
