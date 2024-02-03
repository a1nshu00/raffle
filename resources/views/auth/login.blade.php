@include('layouts.header')
<section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
  <div class="container">
     <div class="row">
      <div class="col-md-12">
        <h2>Log In</h2>
        <ul class="breadcrumb">
        <li><a href="{{route('landing')}}">Home</a></li>
        <li>Log In</li>
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
              <h2>Login to your account</h2>
              <p>Log in to continue in our website</p>
            </div>
                <form method="POST" action="{{ route('login') }}">   
                    @csrf
                    <div class="form-group">
                        <label  for="email" >Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"  required autocomplete="email" autofocus>
                        @if(session('email'))
                          <span class="invalid-feedback" role="alert" style="display:block;">
                              <strong>{{ session('email') }}</strong>
                          </span>
                        @endif
                    </div>                      
                    <div class="form-group">
                        <label for="password" >Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @if(session('password'))
                          <span class="invalid-feedback" role="alert" style="display:block;">
                              <strong>{{ session('password') }}</strong>
                          </span>
                        @endif
                    </div>
                    <div class="form-group forgotpassword">
                        <a href="{{ route('reset-password') }}">Forgot your Password?</a>
                    </div>
                    <div class="form-group loginboxbtn">
                        <input type="submit" value="Sign In" class="btn btn-info">
                    </div>
                </form>
                <div class="signinaccount">
                    <p>Don't have a Ending.biz account? <a href="{{route('register')}}">Register for free</a></p>
                </div>
          </div>

         


        </div>
       
      </div>
    </div>
  </div>
</section>

@include('layouts.footer')







