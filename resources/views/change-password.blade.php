@include('layouts.header')
<section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
  <div class="container">
     <div class="row">
      <div class="col-md-12">
        <h2>Change Password</h2>
        <ul class="breadcrumb">
        <li><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li>Change Password</li>
      </ul>
      </div>
     </div>
  </div>
</section>
<section class="main-sec loginpage">
  <div class="container">
    <form action="{{route('update-password')}}" method="post" enctype='multipart/form-data'> 
        @csrf
        <div class="col-md-12">
            <div class="carddesign cardbox">
               
              <div class="loginbox">
                  <div class="loginpage-hading">
                          <h2>Reset Password</h2>
                          <p>Your new password must be different from previous used passwords.</p>
                        </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="password">New Password</label>
                              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                              @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                            <label for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                          </div>
                      </div>
                  </div>
                  <div class="form-group loginboxbtn">
                      <input type="submit" value="Submit" class="btn btn-info">
                  </div>
              </div>
            </div>
        
        </div>
    </form>

  


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