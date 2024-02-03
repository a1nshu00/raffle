@include('layouts.header')
<section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
  <div class="container">
     <div class="row">
      <div class="col-md-12">
        <h2>Reset Password</h2>
        <ul class="breadcrumb">
        <li><a href="{{route('landing')}}">Home</a></li>
        <li>Reset Password</li>
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
              <h2>Reset your password</h2>
            </div>
                <form method="POST" action="{{ route('email-notification') }}">   
                    @csrf
                    <div class="form-group">
                        <label for="email" >Email</label>
                        <input id="email" name="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        @if (\Session::has('error'))
                            <span class="invalid-feedback" role="alert" style="display: block;">
                                <strong>{!! \Session::get('error') !!}</strong>
                            </span>
                        @endif
                    </div>
                    
                   
                    <div class="form-group loginboxbtn">
                        <input type="submit" value="Send Mail" class="btn btn-info">
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






