@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-5 text-center">
        <h2>Checkout</h2>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div><br />
    @endif
    <div class="row">

        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill">{{ Cart::getTotalQuantity() }}</span>
            </h4>
            <ul class="list-group mb-3">
                @foreach($data as $pro)
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">{{ucwords($pro->name)}} * {{ $pro->quantity }}</h6>
                        <small class="text-muted">Brief description</small>
                    </div>
                    <span class="text-muted">${{ $pro->quantity * $pro->price }}</span>
                </li>
                @endforeach
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">Tax</h6>
                        <small class="text-muted">included all GST {{ Cart::getCondition('tax')->getValue() }}</small>
                    </div>
                    <span class="text-muted">{{ Cart::getCondition('tax')->getCalculatedValue(Cart::getSubTotal()) }}</span>
                </li>


                <li class="list-group-item d-flex justify-content-between bg-light">
                    <div class="text-success">
                        <h6 class="my-0">Promo code</h6>
                        <small>EXAMPLECODE</small>
                    </div>
                    <span class="text-success">-$5</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (USD)</span>
                    <strong>${{Cart::getTotal()}}</strong>
                </li>
            </ul>

            <form class="card p-2">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Promo code">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary">Redeem</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-8">
            <div class="card-columns">
                @foreach ($myaddresses as $address)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $address->fullname }}</h5>
                        {{ $address->fullAddress }}<br>
                        {{ $address->city }}, {{ $address->state }},
                        {{ $address->country }}-{{ $address->zip }}<br>
                        Phone-{{ $address->phone }}<br><br>

                        <a href="{{ url('go/placeorder/addressid=') }}{{ $address->id }}"
                            class="btn btn-success btn-sm btn-block" role="button" aria-pressed="true">Deliver
                            To this Address</a>
                        <br>
                        <a href="{{ url('go/checkout/delete/addressid=') }}{{ $address->id }}"
                            class="btn btn-outline-primary btn-sm" role="button" aria-pressed="true">Edit</a>

                        <a href="{{ url('go/checkout/delete/addressid=') }}{{ $address->id }}"
                            class="btn btn-outline-danger btn-sm" role="button" aria-pressed="true">Delete</a>

                        <p class="card-text"><small class="text-muted">Your Saved Address</small></p>
                    </div>
                </div>
                @endforeach
            </div>
            <h4 class="mb-3">Billing address</h4>
            <form class="needs-validation" method="POST" action="{{ route('checkout.placeorder') }}">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="fullname">Full Name</label>
                        <input value="{{ old('fullName') }}" type="text" class="form-control" name="fullname"
                            id="fullName" placeholder="" value="" required>
                        <div class="invalid-feedback">
                            Valid first name is required.
                        </div>
                    </div>

                </div>

                {{--  <div class="mb-3">
            <label for="username">Username</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">@</span>
              </div>
              <input type="text" class="form-control" id="username" placeholder="Username" required>
              <div class="invalid-feedback" style="width: 100%;">
                Your username is required.
              </div>
            </div>
          </div>  --}}
                <div class="mb-3">
                    <label for="phone">Phone <span class="text-muted">*</span></label>
                    <input type="number" value="{{ old('phone') }}"
                        class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" required
                        placeholder="9999999999">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email">Email <span class="text-muted"></span></label>
                    <input type="email" required class="form-control @error('email') is-invalid @enderror" name="email"
                        id="email" value="{{ Auth::user()->email }}" readonly>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="fullAddress">Address</label>
                    <input type="text" name="fullAddress" value="{{ old('fullAddress') }}" class="form-control"
                        id="fullAddress" placeholder="1234 Main city" required>
                    <div class="invalid-feedback">
                        Please enter your shipping address.
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="country">Country</label>
                        <select name="country" class="custom-select d-block w-100 @error('email') is-invalid @enderror" id="country" required>
                            <option value="">Choose...</option>
                            <option value="usa">United States</option>
                            <option value="india">India</option>
                            <option value="pakistan">Pakistan</option>
                        </select>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="state">State</label>
                        <select name="state" class="custom-select d-block w-100" id="state" required>
                            <option value="">Choose...</option>
                            <option value="delhi">Delhi</option>
                        </select>
                        <div class="invalid-feedback">
                            Please provide a valid state.
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="city">City</label>
                        <select name="city" class="custom-select d-block w-100" id="city" required>
                            <option value="">Choose...</option>
                            <option value="delhi">Delhi</option>
                        </select>
                        <div class="invalid-feedback">
                            Please provide a valid City.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="zip">Zip/Pin Code</label>
                        <input type="number" class="form-control" id="zip" name="zip" placeholder="" required>
                        <div class="invalid-feedback">
                            Zip code required.
                        </div>
                    </div>
                </div>

                <hr class="mb-4">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="same-address">
                    <label class="custom-control-label" for="same-address">Shipping address is the same as my billing
                        address</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="save-info">
                    <label class="custom-control-label" for="save-info">Save this information for next time</label>
                </div>
                <hr class="mb-4">

                {{--  <h4 class="mb-3">Payment</h4>

                <div class="d-block my-3">
                    <div class="custom-control custom-radio">
                        <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked
                            required>
                        <label class="custom-control-label" for="credit">Credit card</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required>
                        <label class="custom-control-label" for="debit">Debit card</label>
                    </div>
                    <div class="custom-control custom-radio">
                        <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required>
                        <label class="custom-control-label" for="paypal">PayPal</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cc-name">Name on card</label>
                        <input type="text" class="form-control" id="cc-name" placeholder="" required>
                        <small class="text-muted">Full name as displayed on card</small>
                        <div class="invalid-feedback">
                            Name on card is required
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cc-number">Credit card number</label>
                        <input type="text" class="form-control" id="cc-number" placeholder="" required>
                        <div class="invalid-feedback">
                            Credit card number is required
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="cc-expiration">Expiration</label>
                        <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                        <div class="invalid-feedback">
                            Expiration date required
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cc-cvv">CVV</label>
                        <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                        <div class="invalid-feedback">
                            Security code required
                        </div>
                    </div>
                </div>  --}}
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
            </form>
        </div>
    </div>
    @endsection