@include('layouts.header')
<section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
  <div class="container">
     <div class="row">
      <div class="col-md-12">
        <h2>Confirm Reset Password</h2>
        <ul class="breadcrumb">
        <li><a href="{{route('landing')}}">Home</a></li>
        <li>Confirm Reset Password</li>
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
              <h2>Confirm Reset your password</h2>
            </div>
                <form method="POST" action="{{ route('password.update') }}">   
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <label for="email" >Email</label>
                        <input id="email" type="email" readonly class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" >Password</label>
                        <input id="password" placeholder="Password" autofocus type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm" >Confirm Password</label>
                        <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                    </div>
                   
                    <div class="form-group loginboxbtn">
                        <input type="submit" value="Reset Password" class="btn btn-info">
                    </div>
                </form>
          </div>

         


        </div>
       
      </div>
    </div>
  </div>
</section>

@include('layouts.footer')
<script>
    $(document).ready(function(){
        
        toastr.options.timeOut = 10000;
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif
    });

    
</script>






