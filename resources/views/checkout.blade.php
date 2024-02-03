@include('layouts.header')
    
    <section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Checkout</h2>
                    <ul class="breadcrumb">
                        <li><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li><a href="{{route('raffle-draws')}}">Raffle Draw</a></li>
                        <li><a href="{{route('raffle-draw-detail', $data['raffle_id'])}}">Raffle Draw Details</a></li>
                        <li>Checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="main-sec">
        <div class="container">
        
            <div class="row">
                <div class="col-md-4">
                    <div class="carddesign cardbox">
                        <h2 class="ballsnumber">Total Selected balls<span>{{count($data['chosen_balls'])}}</span></h2>
                    </div>
                    <div class="carddesign cardbox cardbox2">
                        <h2>Total Buying Amount</h2>
                        <h4>{{@$data['total_amount'] ? '$'.@$data['total_amount'] : ''}}</h4>
                    </div>
                    <div class="carddesign cardbox cardbox2">
                        <h2>Wallet Balance</h2>
                        @if(@$data['wallet_balance'])
                            <h4 id="wallet_blnc" >{{'$'.$data['wallet_balance']}}</h4>
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="carddesign cardbox">
                        <h2>Selected Balls</h2>
                        <ul class="selectedballs">
                            @foreach($data['chosen_balls'] as $key => $value )
                                <li><span>{{$value}}</span></li>
                            @endforeach
                        </ul>


                        <!-- Add funds or pay now forms -->
                        <form action="{{route('order-raffle')}}" method="POST" id="pay_now">
                            @csrf
                            
                            <!--Inputs -->
                            <input type="hidden" name="total_buying_amount"  id="total_buying_amount" value="{{$data['total_amount']}}">
                            <input type="hidden" name="raffle_id" value="{{$data['raffle_id']}}">
                            @foreach($data['chosen_balls'] as $key => $value)
                                <input type="hidden" name="ball_number[]" value="{{$value}}">
                            @endforeach
                            <input type="hidden" name="amount" id="buying_amount" value="{{$data['buying_amount']}}">
                            
                            <div class="continuebtn addfunds" id="pay_fund_button" >
                                <a href="#" id="payment_btn" class="btn btn-info">{{@$data['flag'] == 'add_funds' ? 'Deposit' : 'Pay Now' }}</a>
                            </div>
                        </form>
                        <form action="{{route('add-funds')}}" method="get" id="add_funds">
                            @csrf
                            <!--Inputs -->
                            <input type="hidden" name="total_buying_amount"  id="total_buying_amount" value="{{$data['total_amount']}}">
                            <input type="hidden" name="raffle_id" value="{{$data['raffle_id']}}">
                            @foreach($data['chosen_balls'] as $key => $value)
                                <input type="hidden" name="ball_number[]" value="{{$value}}">
                            @endforeach
                            <input type="hidden" name="amount" id="buying_amount" value="{{$data['buying_amount']}}">
                        </form>


                        @if($data['authenticated'] == 0)
                            <!-- register form -->
                            <div class="loginbox" id="register-container">
                                <h2>Create an account</h2>
                                <form method="POST" action=""> 
                                    @csrf
                                    <input type="hidden" name="check_out" value="check_out" id="check_out">  
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label id="first_name_">First Name</label>
                                                <input type="text" class="form-control" placeholder="First Name" id="first_name">
                                                <span class="invalid-feedback" role="alert" style="display: block;">
                                                    <strong id="register_first_name_err"></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label id="last_name_">Last Name</label>
                                                <input type="text" class="form-control" placeholder="Last Name" id="last_name">
                                                <span class="invalid-feedback" role="alert" style="display: block;">
                                                    <strongn id="register_last_name_err"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label id="register_email_">Email Address</label>
                                        <input type="email" class="form-control" placeholder="Email Address" id="register_email">
                                        <span class="invalid-feedback" role="alert" style="display:block;">
                                            <strong id="register_email_err"></strong>
                                        </span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label id="register_password_">Password</label>
                                                <input type="password" class="form-control" placeholder="Password" id="register_password"> 
                                                <span class="invalid-feedback" role="alert" style="display: block;">
                                                    <strong id="register_password_err"></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label id="password-confirm_">Confirm Password</label>
                                                <input type="password" class="form-control" placeholder="Password" id="password-confirm"> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group loginboxbtn">
                                        <input type="button" value="Create Account" class="btn btn-info"  id="checkout_register">
                                    </div>
                                </form>
                                <div class="signinaccount">
                                    <p>Already have an account? <a href="#" id="login">Sign in</a></p>
                                </div>
                            </div>

                            <!-- Login form -->
                            <div class="loginbox" id="login-container" style="display:none;">
                                <h2>Login to your account</h2>
                                <form method="POST" action="">   
                                    @csrf   
                                    <input type="hidden" name="from_check_out" id="login_checkout" value="check_out">
                                    <div class="form-group">
                                        <label id="login_email_">Email Address</label>
                                        <input type="email" class="form-control" placeholder="Email Address" id="login_email">
                                        <span class="invalid-feedback" role="alert" style="display:block" >
                                            <strong id="login_email_err"></strong>
                                        </span>
                                    </div>                      
                                    <div class="form-group">
                                        <label id="login_password_">Password</label>
                                        <input type="password" class="form-control" placeholder="Password" id="login_password"> 
                                        <span class="invalid-feedback" role="alert" style="display:block">
                                            <strong id="login_password_err"></strong>
                                        </span>
                                    </div>
                                    <div class="form-group loginboxbtn">
                                        <input type="button" value="Sign In" class="btn btn-info" id="login_btn">
                                    </div>
                                </form>
                                <div class="signinaccount">
                                    <p>Don't have a Ending account? <a href="#" id="register">Register for free</a></p>
                                </div>
                            </div>

                            <!-- Forget password
                            <div class="loginbox">
                                <h2>Forgot your Password</h2>
                                <form>      
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control" placeholder="Email Address" id="email">
                                    </div> 
                                    <div class="form-group loginboxbtn">
                                        <input type="submit" value="Submit" class="btn btn-info">
                                    </div>
                                </form>
                            </div> -->
                        @endif
                    </div>
                </div>
                <div class="alert alert-success" id="alert_success" style="display:none;">
                </div>
                <div class="alert alert-danger" id="alert_error" style="display:none;" >
                    <strong>Error!</strong>
                </div>
            </div>
        </div>
    </section>

@include('layouts.footer')
<script type="text/javascript">
    $(document).ready(function() {
        $("#owl-demo1").owlCarousel({
            autoPlay : true,    
            items : 5,
            loop:true,
            autoplayTimeout:13000,
            autoplayHoverPause:true,
            lazyLoad : true,
            navigation : true,
            responsive: {
                0: {
                items: 1
                },
                600: {
                items: 2
                },
                1000: {
                items: 5
                }
            }
        });
        $( ".owl-prev").html('<i class="fa fa-angle-left" aria-hidden="true"></i>');
        $( ".owl-next").html('<i class="fa fa-angle-right" aria-hidden="true"></i>');
    });
</script>
<script>
    
    $(document).ready(function(){
        if(!$('#wallet_blnc').html()){
            $('#payment_btn').hide();
            $('#pay_fund_button').hide();

        }
    });
    
    $('body').delegate('#login', 'click', function(){
        $('#login-container').show();
        $('#register-container').hide();
    });
      $('body').delegate('#register', 'click', function(){
        $('#login-container').hide();
        $('#register-container').show();
    });
    

    // Login....
    $('body').delegate('#login_btn', 'click', function(){
        $('#login_email_err').html('');
        $('#login_password_err').html('');
        
        var email = $('#login_email').val();
        var password = $('#login_password').val();
        var check_out = $('#login_checkout').val();
        var total_buying_amount = $('#total_buying_amount').val();
        
        // Error handing....
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if(!email){
            $('#login_email_err').html('email is required field.');
            return false;
        }
        if(!password){
            $('#login_password_err').html('password is required field.');
            return false;
        } 
        if (!email.match(validRegex)){
            $('#login_email_err').html('Invalid email address.');
            return false;
        }
        
        var formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);
        formData.append('total_buying_amount', total_buying_amount);
        formData.append('check_out', check_out);
        $.ajax({
            
            url: "{{ route('login') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if(data.status == 200){
                    // $('#alert_success').html('<strong>Success!</strong> Login successfully.')
                    // $('#alert_success').show();
                    // let intervalID = setInterval(() => {
                    //     $('#alert_success').hide();
                    // }, 8000);
                    toastr.success('Login successfully.');
                    $('#wallet_blnc').html('$'+data.data.wallet_balance);
                    $('#login-container').hide();
                    $('#payment_btn').show();
                    $('#pay_fund_button').show();
                    $('#payment_btn').html(data.data.btn_txt)
                    window.location.reload();

                }else{
                    // $('#alert_error').html('<strong>Error!</strong> Whoops! invalid email and password.')
                    // $('#alert_error').show();
                    // let intervalID = setInterval(() => {
                    //     $('#alert_error').hide();
                    // }, 8000);
                    toastr.error('Whoops! invalid email and password.');
                }
            },
        });
         
    });

    // Register....
    $('body').delegate('#checkout_register', 'click', function(){
        $('#register_first_name_err').html('');
        $('#register_last_name_err').html('');
        $('#register_email_err').html('');
        $('#register_password_err').html('');

        
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var email = $('#register_email').val();
        var password = $('#register_password').val();
        var confirm_password = $('#password-confirm').val();
        var check_out = $('#check_out').val();
        var total_buying_amount = $('#total_buying_amount').val();
        

        
        // Error handing....
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

        if(!first_name){
            $('#register_first_name_err').html('First name is required field.');
            return false;
        }
        if(!last_name){
            $('#register_last_name_err').html('Last name is required field.');
            return false;
        }
        if(!email) {
            $('#register_email_err').html('email is required field.');
            return false;
        }
        if (!email.match(validRegex)) {
            $('#register_email_err').html('Invalid email address.');
            return false;
        }
        if(!password) {
            $('#register_password_err').html('password is required field.'); 
            return false;
        }
        
        if(password != confirm_password){
            $('#register_password_err').html('The password confirmation does not match.'); 
            return false; 
        }
        
        var formData = new FormData();
        formData.append('first_name', first_name);
        formData.append('last_name', last_name);
        formData.append('email', email);
        formData.append('password', password);
        formData.append('check_out', check_out);
        formData.append('total_buying_amount', total_buying_amount);
        $.ajax({
            
            url: "{{ route('user-register') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if(data.status == 200){
                    // $('#alert_success').html('<strong>Success!</strong> Register successfully.');
                    // $('#alert_success').show();
                    // let intervalID = setInterval(() => {
                    //     $('#alert_success').hide();

                    // }, 8000);

                    toastr.success('Register successfully.');

                    $('#wallet_blnc').html('$'+data.data.wallet_balance);
                    $('#login-container').hide();
                    $('#register-container').hide();
                    $('#payment_btn').show();
                    $('#pay_fund_button').show();
                    $('#payment_btn').html(data.data.btn_txt);
                    window.location.reload();
                }
                if(data.status == 400){
                    $('#register_email_err').html(data.message);
                }
                if(data.status == 401){
                    // $('#alert_error').html('<strong>Error!</strong> Whoops! invalid email and password.')
                    // $('#alert_error').show();
                    // let intervalID = setInterval(() => {
                    //     $('#alert_error').hide();

                    // }, 8000);
                    toastr.error('Whoops! invalid email and password.');


                }
            },
        });
         
    });

    // Form Submit

    $('body').delegate('#payment_btn', 'click', function(){
        var button_type = $(this).text();
        if(button_type == 'Deposit'){
            $('#add_funds').submit();
        }else{
            $('#pay_now').submit();
        }

    });
</script>
