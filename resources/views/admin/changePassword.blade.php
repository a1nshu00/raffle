@include('admin.layout.header')
<!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
        </div></div></div>
    <!--  END LOADER -->
<!--  BEGIN CONTENT AREA  -->
    <div class="main-container" id="container">
        <div class="overlay" ></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        @include('admin.layout.sidebar')          
        <!--  END SIDEBAR  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="page-header">
                    <div class="page-title">
                        <h3>Account Setting</h3>
                    </div>
                </div>
                <form id="form_submit" class="section contact" action="{{route('update-password-ad')}}" method="post">
                    @csrf
                    <div class="account-settings-container layout-top-spacing">
                        <div class="info">
                            <h5 class="">Change password</h5>
                            
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">New Password</label>
                                                <input id="password" name="password"  type="password" value="" placeholder="Password" class="@error('password') is-invalid @enderror form-control mb-4">
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
                                                <input id="password-confirm" type="password" class="form-control mb-4" name="password_confirmation" placeholder="Confirm Password"  autocomplete="new-password">
                                            </div>
                                        </div>
                                    </div>
                               
                        </div>
                
                    </div>


                    <div class="account-settings-footer">
                        <div class="as-footer-container">
                            <!-- <button id="multiple-reset" class="btn btn-warning">Reset All</button> -->
                            <div class="blockui-growl-message">
                                <i class="flaticon-double-check"></i>&nbsp; Settings Saved Successfully
                            </div>
                            <button type="submit" id="button-submit" class="btn btn-primary">Save Changes</button>

                        </div>

                    </div>
                </form>
            </div>
            @include('admin.layout.layout_scripts')
        </div>
    </div>
<!--  END CONTENT AREA  -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
<script>
    $(document).ready(function(e) {
        toastr.options.timeOut = 10000;
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif

        // $('#button-submit').click(function(e){
        //     var password = $('#password').val();
        //     var confirmPassword = $('#confirmPassword').val();
        //     if(password  == confirmPassword){
        //         $('#form_submit').submit();
        //     }else{
        //         toastr.error('Password not matched!');
        //     }
        // });
    }); 
</script>