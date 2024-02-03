@include('layouts.header')




<section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
  <div class="container">
     <div class="row">
      <div class="col-md-12">
        <h2>My Profile</h2>
        <ul class="breadcrumb">
        <li><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li>My Profile</li>
      </ul>
      </div>
     </div>
  </div>
</section>


<section class="main-sec my-profile">
  <div class="container">
    <form action="{{route('update-profile')}}" method="post" enctype='multipart/form-data'> 
        @csrf
        <input type="hidden" name="payout_info" value="" id="payout_info">
        <div class="row">
        <div class="col-md-4">       
        <div class="carddesign cardbox profileimg">
            <h2>Profile Picture</h2>
            <div class="profile-img">
            <div class="circle">
                <img class="profile-pic" src="{{auth()->guard('web')->user()->profile_image? env('BASE_URL').auth()->guard('web')->user()->profile_image : asset('assets/images/images.png')}}">
            </div>
            <div class="p-image">
                <i class="la la-camera upload-button"></i>
                <input type="file" name="profile_image" class="file-upload" type="file" accept="image/*">
            </div>
            </div>
        </div>
        <div class="carddesign cardbox cardbox2">
            <h2>Wallet Balance</h2>
            <h4>${{$data->wallet_balance}}</h4>
        </div>
        
        </div>
        <div class="col-md-8">
            <div class="carddesign cardbox">

                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                    <a class="nav-link comman p_file active"  data-toggle="tab"  href="#home">Profile</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link comman b_nk" data-toggle="tab"  href="#menu1">Withdrawal Method</a>
                    </li>    
                </ul>    
                <div class="tab-content">
                    <div id="home" class="tab-pane active">
                        <h2>General Information</h2> 
                        <div class="loginbox addfunds">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" value="{{$data->first_name}}" class="form-control" placeholder="" name="first_name" id="fname">
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" value="{{$data->last_name}}" placeholder="" name="last_name" id="fname">
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <input type="email" class="form-control" value="{{$data->email}}"  readonly placeholder="" id="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" value="{{$data->phone_number}}" name="phone_number" placeholder="" id="number"> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Viber</label>
                                        <input type="text" name="viber" value="{{$data->viber}}" class="form-control" placeholder="" id="viber">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Fb Messenger</label>
                                        <input type="text" name="fb_messenger" value="{{$data->fb_messenger}}" class="form-control" placeholder="" id="manager"> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group loginboxbtn">
                                <input type="submit" value="Submit" class="btn btn-info">
                            </div>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <h2>Withdrawal Methods</h2> 
                        <div class="loginbox addfunds">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Methods</label>
                                        <select name="method_id" id="withdrawal_methods" class="form-control">
                                            @if(count($withdrawal_management) > 0)
                                                @foreach($withdrawal_management as $key => $value)
                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="bnk_">
                                    <div class="form-group">
                                        <label for="bank_name">Bank Name</label>
                                        <input type="text" id="bank_name" value="{{ old('bank_name') ? old('bank_name') : auth()->guard('web')->user()->bank_name }}" class="form-control"  name="bank_name">
                                        @error('bank_name')
                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> 
                                </div>
                                <div class="col-md-6" id="qr_cd" style="display:none;">
                                    <div class="form-group">
                                        <label>QR Code</label>
                                        <div class="box" >
                                            <input type="file" name="qr_code" id="file-6" class="inputfile inputfile-4 file-5" data-multiple-caption="{count} files selected" multiple />
                                            <label for="file-6">
                                            <figure><img src="assets/images/fileup.png" class="img-fluid" alt=""></figure>
                                            <span>Upload QR</span></label>
                                        </div>
                                    </div> 
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account_name">Account Name</label>
                                        <input type="text" id="account_name" class="form-control" value="{{ old('account_name') ? old('account_name') : auth()->guard('web')->user()->account_name }}"  name="account_name">
                                        @error('account_name')
                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> 
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="account_number">Account Number</label>
                                        <input type="text" id="account_number" value="{{ old('account_number') ? old('account_number') : auth()->guard('web')->user()->account_number }}" class="form-control"  name="account_number">
                                        @error('account_number')
                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> 
                                </div> 
                            </div>
                            <div class="form-group loginboxbtn">
                                <input type="submit" value="Submit" class="btn btn-info">
                            </div>
                        </div>
                    </div>
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
        var readURL = function(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.profile-pic').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        $(".file-upload").on('change', function(){
            readURL(this);
        });
        
        $(".upload-button").on('click', function() {
            $(".file-upload").click();
        });

        let method_id = $('#withdrawal_methods').val();
        if(method_id){
            $.ajax({
                url: "{{ route('user-method-detail')}}?method_id="+method_id,
                type: 'get',
                data: '',
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if(data.status == 200){
                        if($('#withdrawal_methods').text() == 'Bank'){
                            $('#bnk_').show();
                            $('#qr_cd').hide();
                        }else{
                            $('#bnk_').hide();
                            $('#qr_cd').show();
                        }
                        if(data.data){
                            $('#account_name').val(data.data.account_name);
                            $('#account_number').val(data.data.account_number);
                            $('#bank_name').val(data.data.bank_name);
                        }
                    }else{
                        toastr.error('something went wrong');
                    }
                },
            });  
        }



    });

    $('body').delegate('.comman', 'click', function(){
        if($(this).hasClass('p_file')){
            $('#payout_info').val('');
        }else{
            $('#payout_info').val('payout_info');
        }
    });


    $('body').delegate('#withdrawal_methods', 'change', function(){
        let method_id = $(this).val();
        if(method_id){
            $.ajax({
                url: "{{ route('user-method-detail')}}?method_id="+method_id,
                type: 'get',
                data: '',
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if(data.status == 200){
                        console.log($('#withdrawal_methods option:selected').text());
                        if($('#withdrawal_methods option:selected').text() == 'Bank'){
                            $('#bnk_').show();
                            $('#qr_cd').hide();
                        }else{
                            $('#bnk_').hide();
                            $('#qr_cd').show();
                        }
                        if(data.data){
                            $('#account_name').val(data.data.account_name);
                            $('#account_number').val(data.data.account_number);
                            $('#bank_name').val(data.data.bank_name);
                        }else{
                            $('#account_name').val('');
                            $('#account_number').val('');
                            $('#bank_name').val('');
                        }
                    }else{
                        toastr.error('something went wrong');
                    }
                    
                },
            });  
        }
    });
</script>