@extends('layouts.app')
@section('content')
<script>
    $(document).ready(function(){
         var searchRequest = null;
         var maxlength=30;
         $('#username').keyup(function(){
          var error_username = '';
          var username = $('#username').val();
          
          var filter = /^([a-zA-Z0-9\-]{6,20})+$/;
          if(username.length!=maxlength)
            {

                if(!filter.test(username ))
          {    
           $('#error_username').html('<label class="text-danger">Invalid Store Name: minimum length should be 6 for example : indiabookstore, india-book-store, india-99 </label>');
           $('#username').addClass('has-error');
           $('#register').attr('disabled', 'disabled');
          }
          else
          {
            if (searchRequest != null) 
            searchRequest.abort();
            
            searchRequest = $.ajax({
            url:"{{ route('username.check') }}",
            method:"POST",
            data:{username:username},
            success:function(result)
            {
             if(result == 'unique')
             {
              $('#error_username').html('<label class="text-success">Storename Available</label>');
              $('#username').removeClass('has-error');
              $('#register').attr('disabled', false);
             }
             else
             {
              $('#error_username').html('<label class="text-danger">Storename not Available</label>');
              $('#username').addClass('has-error');
              $('#register').attr('disabled', 'disabled');
             }
            }
           });
          }
            }
          
         });
         
        });
</script>

<div class="container">
    @include('user.navitem')
    <div class="card-body">
        <h5 class="card-title">Profile</h5>
        <p class="card-text">Name- {{ Auth::user()->name }}</p>
        <p class="card-text">Email- {{ Auth::user()->email }}</p>
        <p class="card-text">Temp_username- <a
                href="{{ route('userstore',[ $temp_username]) }}">{{ $temp_username }}</a> <a href="#"
                class="btn  btn-outline-dark btn-sm" role="button">edit</a></p>

        <form method="POST" id="update-form" action="{{ route('username.update') }}">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username"
                            id="username" placeholder="Recipient's username" required autofocus maxlength="30">
                        <input type="hidden" name="temp_username" value="{{ $temp_username }}">
                        <div class="input-group-append">
                            <!-- Button trigger modal -->
                            <button class="btn btn-outline-secondary" data-toggle="modal" name="register" id="register"
                                type="button" data-target="#updatemodel">
                                Change
                            </button>
                        </div>
                        @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col">
                    <div class="spinner-border" id="loading-image" role="status" style="display:none;">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span id="error_username"></span>
                </div>
            </div>


        </form>
        <!-- Modal -->
        <div class="modal fade" id="updatemodel" tabindex="-1" role="dialog" aria-labelledby="updatemodelLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updatemodelLabel">Warning For Store Name</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        You can change store name only once !! Check again before save
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>

                        <button type="button" class="btn btn-danger" onclick="event.preventDefault();
                    document.getElementById('update-form').submit();">Save</button>

                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('myaddress') }}" class="btn btn-primary">My Address</a>
    </div>
</div>
</div>
@endsection