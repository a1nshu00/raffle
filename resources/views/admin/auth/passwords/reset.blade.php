@include('admin.layout.layout_login.links')
<body class="form">
    <div class="form-container loginform-design">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-error" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <h1 class="mb-4">Reset you'r<a><span class="brand-name"> Password</span></a></h1>
                        <!-- <p class="signup-link">New Here? <a href="{{ route('adminRegister') }}">Create an account</a></p> -->
                        <form class="text-left" method="POST" action="{{ route('admin.password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form">

                                <div id="email-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign"><circle cx="12" cy="12" r="4"></circle><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path></svg>
                                    <input id="email" type="email" readonly class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div id="password-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="password" placeholder="Password" autofocus type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div id="password-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">{{ __('Reset Password') }}</button>
                                    </div>
                                    <div class="field-wrapper">
                                        <a href="{{route('adminLogin')}}"><button type="button" class="btn btn-primary" value="">Login</button></a>
                                    </div>
                                </div>
                            </div>
                        </form>                      
                    </div>                    
                </div>
            </div>
        </div>
        <div class="form-image">
            <div class="l-image" style="background-image:url('{{asset('public/admin/assets/img/loginbg.jpg')}}')">
                <div class="loginlogo"><a href="#"><img src="{{asset('public/admin/assets/img/logo.png')}}" class="img-fluid" alt="logo"></a></div>
            </div>
        </div>
    </div>
    @include('admin.layout.layout_login.scripts')

    
</body>








