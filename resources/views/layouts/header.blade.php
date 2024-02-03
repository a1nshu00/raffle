 <!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ending</title>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/responsive.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/owl.carousel.min.css')}}"> 
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/line-awesome.min.css')}}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
        
        <!-- Alert Message
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">-->

        <!-- Data table  -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" /> 
    </head>
    <body class="homepage">
        <header class="header-sec">
        
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg navbar-dark">
                            <a class="navbar-brand" href="{{route('landing')}}"><img src="{{asset('assets/images/logo.png')}}" class="img-fluid" alt=""></a>

                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                                <ul class="navbar-nav ml-auto" id="myNavbar">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="{{route('landing')}}"><i class="la la-home"></i></a>
                                    </li>  
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('about')}}">About</a>
                                    </li>  
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('FAQ')}}">FAQ</a>
                                    </li>
                                    @if(auth()->guard('web')->check()) 
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('raffle-winner')}}">My Results</a>
                                    </li>   
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('contact-us')}}">Contact US</a>
                                    </li>
                                    @if(auth()->guard('web')->check())      
                                        <li class="nav-item dropdown profiledrop">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown" aria-expanded="false">
                                            <img src="{{auth()->guard('web')->user()->profile_image? env('BASE_URL').auth()->guard('web')->user()->profile_image : asset('assets/images/images.png')}}" class="img-fluid" alt="">
                                            </a>
                                            <div class="dropdown-menu">
                                            <ul>
                                                <li class="dropdown-menu-list"><a class="dropdown-item username" href="#">{{auth()->guard('web')->user()->first_name}}</a></li>
                                            
                                                <li class="dropdown-menu-list"><a href="{{route('dashboard')}}"><i class="la la-dashboard"></i>Dashboard</a></li>
                                                <li class="dropdown-menu-list"><a href="{{route('my-profile')}}"><i class="la la-user"></i>My Profile</a></li>
                                                <li class="dropdown-menu-list"><a href="{{route('change-password')}}"><i class="la la-key"></i>Change Password</a></li>
                                                <li class="dropdown-menu-list"><a href="{{route('raffle-draws')}}"><i class="la la-bars"></i>Active Raffles</a></li>
                                                <li class="dropdown-menu-list"><a href="{{route('user-withdrawal-request')}}"><i class="la la-external-link-square"></i>Withdraw Request</a></li>
                                                <li class="dropdown-menu-list"><a href="{{route('add-funds')}}"><i class="la la-money"></i>Deposit</a></li>
                                                <li class="dropdown-menu-list"><a href="{{route('transactions')}}"><i class="la la-exchange"></i>Transactions</a></li>
                                                <li class="dropdown-menu-list"><a href="{{route('my-orders')}}"><i class="la la-shopping-cart"></i>Orders</a></li>
                                                <li class="dropdown-menu-list"><a href="{{route('logout')}}"><i class="la la-sign-out"></i>Logout</a></li>
                                            </ul>             
                                            </div>
                                        </li>
                                    @else
                                        <li class="nav-item loginlink">
                                            <a class="nav-link" href="{{route('login')}}">Login</a>
                                        </li>
                                        <li class="nav-item loginlink">
                                            <a class="nav-link" href="{{route('register')}}">Register</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>  
                        </nav>
                    </div>
                </div>
            </div>
        </header>
    </body>
</html>