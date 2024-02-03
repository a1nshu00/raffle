@include('layouts.header')

    <section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <h2>Sign Up</h2>
            <ul class="breadcrumb">
            <li><a href="{{route('landing')}}">Home</a></li>
            <li>Sign up</li>
        </ul>
        </div>
        </div>
    </div>
    </section>


    <section class="main-sec loginpage">
    <div class="container">    

        <div class="row">      
        <div class="col-md-12">
            <div class="carddesign cardbox">         


            <div class="loginbox">
                <div class="loginpage-hading">
                <h2>Create an account</h2>
                <p>Create an account free and enjoy it</p>
                </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf   
                        <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        </div>
                            </div>
                            <div class="form-group form-check checkdesign">
                            <label class="form-check-label">
                            <input class="form-check-input" type="checkbox">I agree to Ending.biz <a href="#">Terms of Service</a>.
                            </label>
                        </div>
                        <div class="form-group loginboxbtn">
                            <input type="submit" value="Create Account" class="btn btn-info">
                        </div>
                    </form>
                    <div class="signinaccount">
                        <p>Already have an account? <a href="{{route('login')}}">Sign in</a></p>
                    </div>
            </div>

            


            </div>
        
        </div>
        </div>
    </div>
    </section>
@include('layouts.footer')








