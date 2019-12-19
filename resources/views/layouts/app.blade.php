<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/myjs.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'YSellBook') }}
                </a>

                <a href="{{ route('cart.index') }}"><span class="badge badge-light" style="font-size: 15px;">Cart<i
                            class="fa fa-shopping-cart"></i> &nbsp;@if(Auth::check())
                        {{ Cart::session(Auth::id())->getTotalQuantity() }}
                        @else
                        0
                        @endif</span></a>



                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="d-flex justify-content-center pl-4 pt-1 d-inline">
                <form class=" search" action="{{ route('search') }}" method="get">
                        
                    <div class="input-group form-row">
                            
                            <input type="text" maxlength="30" id="search" name="query"
                                class="form-control border-right-0" placeholder="Search for Books, Authors and More"
                                size="40" @isset($searchterm) value="{{ $searchterm }}" @endisset required>
                            <span position="absolute">
                                <div id="searchresultlist">
                                </div>
                                </span>
                        
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary ml-n1 border-left-0">SEARCH</button>
                        </div>
                    </div>
                </form>
                </div>
                <script>
                    $(document).ready(function(){
                            
                             $('#search').keyup(function(){ 
                                    var query = $(this).val();
                                    var maxlength=30;
                                    var filter = /^([a-zA-Z0-9\- ]{3,30})+$/;
                                    if(query.length!=maxlength)
                                        {

                                            if(!filter.test(query ))
                                    { 
                                    }
                                    else{
                                        if(query != '')
                                        {
                                         var _token = $('input[name="_token"]').val();
                                         $.ajax({
                                          url:"{{ route('autocomplete') }}",
                                          method:"POST",
                                          data:{query:query, _token:_token},
                                          success:function(data){
                                           $('#searchresultlist').fadeIn();  
                                                    $('#searchresultlist').html(data);
                                             
                                          }                                        
                                         });
                                        }
                                    }
                                }
                                    });
                                     
                                $(document).on('click', function(){  
                                    $('#searchresultlist').fadeOut();  
                                });  
                            });
                </script>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->

                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Welcome {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    {{ __('Dashboard') }}
                                </a>


                                <!-- Button trigger modal -->
                                <button type="button" class="dropdown-item btn btn-primary" data-toggle="modal"
                                    data-target="#logoutModal">
                                    Logout
                                </button>



                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <!-- Modal -->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="logoutModalLabel">Logout</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Bye Bye We Will C U Soon!!
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>

                            <button type="button" class="btn btn-danger" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">Logout</button>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
        </main>
    </div>
    @yield('extra-js')
    
</body>

</html>