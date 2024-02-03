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
                        <h1 class="mb-4">Change password<a><span class="brand-name"> E-mail</span></a></h1>
                        <!-- <p class="signup-link">New Here? <a href="{{ route('adminRegister') }}">Create an account</a></p> -->
                        <form class="text-left" method="POST" action="{{ route('admin.password.notify-email') }}">
                            @csrf
                            <div class="form">

                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
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
                                <div class="d-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">Send Mail</button>
                                    </div>
                                    <div class="field-wrapper">
                                        <a href="{{route('adminLogin')}}"><button type="button" class="btn btn-primary" value="">Back</button></a>
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







