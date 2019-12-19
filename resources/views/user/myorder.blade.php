@extends('layouts.app')

@section('content')
@component('components.breadcrumbs')
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>My Order</span>
    @endcomponent
<div class="container">
  @include('user.navitem')
  <div class="card-body">
    <h5 class="card-title">Your Latest Orders</h5>
    <p class="card-text">
      <div class="row">
        <div class="col-sm">
          <table class=" table table-bordered table-striped tablemyorder">
            <thead>
              <tr>
                <th colspan="4">Buy &nbsp &nbsp<a href="{{ route('myorder.allbuy') }}">view all</a></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($orders as $order)
                  
              
              <tr>
                <th scope="row">{{ $order->id }}</th>
                <td colspan="2">
                  @foreach ($order->userproduct as $item)
                  {{ $item->title }}
                      
                  @endforeach </td>
                <td>@foreach ($order->userproduct as $item)
                    {{ $item->created_at }}
                        
                    @endforeach</td>

              </tr>
              
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="col-sm">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th colspan="4">Sell &nbsp &nbsp<a href="#">view all</a></th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <th scope="row">1</th>
                <td colspan="2">Mark</td>
                <td>Otto</td>

              </tr>
              <tr>
                <th scope="row">2</th>
                <td colspan="2">Jacob</td>
                <td>Thornton</td>

              </tr>
              <tr>
                <th scope="row">3</th>
                <td colspan="2">Larry the Bird</td>
                <td>@twitter</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="col-sm">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th colspan="4">Rent &nbsp &nbsp<a href="#">view all</a></th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <th scope="row">1</th>
                <td colspan="2">Mark</td>
                <td>Otto</td>

              </tr>
              <tr>
                <th scope="row">2</th>
                <td colspan="2">Jacob</td>
                <td>Thornton</td>

              </tr>
              <tr>
                <th scope="row">3</th>
                <td colspan="2">Larry the Bird</td>
                <td>@twitter</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </p>
  </div>
</div>
</div>
@endsection