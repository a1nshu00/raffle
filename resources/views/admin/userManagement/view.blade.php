@include('admin.layout.header')
<link rel="stylesheet" type="text/css" href="{{asset('public/admin/plugins/dropify/dropify.min.css')}}">
<!-- BEGIN LOADER -->
<div id="load_screen"> <div class="loader"> <div class="loader-content">
    <div class="spinner-grow align-self-center"></div>
</div></div></div>
<!--  END LOADER -->
<!--  BEGIN CONTENT AREA  -->
<div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        @include('admin.layout.sidebar')          
        <!--  END SIDEBAR  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="page-header">
                    <div class="page-title">
                        <h3>User Details</h3>
                    </div>
                </div>
                <div class="account-settings-container layout-top-spacing">
                    <form id="general-info" class="section general-info" >
                      
                        <div class="account-content">
                            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                        <div class="info">
                                            <h6 class="">User Information</h6>
                                           
                                                    <div class="row">
                                                        <div class="col-xl-2 col-lg-12 col-md-4">
                                                            <div class="upload mt-4 pr-md-4">
                                                                <div class="dropify-wrapper has-preview">
                                                                    <div class="dropify-message">
                                                                        <span class="file-icon"></span> 
                                                                        <p>Click to Upload or Drag n Drop</p>
                                                                        <p class="dropify-error">Ooops, something wrong appended.</p>
                                                                    </div>
                                                                    <div class="dropify-loader" style="display: none;">
                                                                    </div>
                                                                    <div class="dropify-errors-container">
                                                                        <ul></ul>
                                                                    </div>
                                                                    <!--<input type="file" value="{{$user->profile_image}}" name="profile_image"  id="input-file-max-fs" class="dropify profile_image" data-default-file="admin/assets/img/200x200.jpg" data-max-file-size="2M">-->
                                                                    <button type="button" class="dropify-clear">
                                                                        <i class="flaticon-close-fill"></i>
                                                                    </button>
                                                                    <div class="dropify-preview" style="display: block;">
                                                                    <span class="dropify-render">
                                                                        <img src="{{$user->profile_image ? env('BASE_URL').$user->profile_image:''}}" id="category-img-tag">
                                                                    </span>
                                                                    <div class="dropify-infos">
                                                                        <div class="dropify-infos-inner">
                                                                            <p class="dropify-filename">
                                                                                <span class="file-icon"></span> 
                                                                                <span class="dropify-filename-inner">200x200.jpg</span>
                                                                            </p>
                                                                            <p class="dropify-infos-message">Upload or Drag n Drop</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @error('profile_image')
                                                                <span class="invalid-feedback" role="alert" style="display:block;">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <!--<p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload Picture</p>-->
                                                        </div>
                                                        </div>
                                                        <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="name">First Name</label>
                                                                            <input type="text" class="form-control " readonly  id="name" placeholder="First Name" name="first_name" value="{{$user->first_name}}">
                                                                            @error('first_name')
                                                                                <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="lastname">Last Name</label>
                                                                            <input type="text" class="form-control "  readonly id="lastname" placeholder="Last Name" name="last_name" value="{{$user->last_name}}">
                                                                            @error('last_name')
                                                                                <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="email">Email</label>
                                                                            <input type="text" readonly class="form-control "  id="email" placeholder="Email" name="email" value="{{$user->email}}">
                                                                            @error('email')
                                                                                <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="phone_number">Phone Number</label>
                                                                            <input type="text" value="{{ $user->phone_number }}" readonly class="form-control "  id="phone_number" placeholder="Phone Number" name="phone_number" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="viber">Viber</label>
                                                                            <input type="text"  value="{{ $user->viber }}" readonly class="form-control "  id="viber" name="viber" placeholder="Viber">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="fb_messenger">FB Messenger</label>
                                                                            <input id="fb_messenger"  value="{{ $user->fb_messenger }}" readonly type="text" class="form-control " name="fb_messenger" placeholder="FB Messenger">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="account-settings-container layout-top-spacing">
                    <form id="general-info" class="section general-info" >
                      
                        <div class="account-content">
                            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                        <div class="info">
                                            <h6 class="">Bank Information</h6>
                                           
                                                    <div class="row">
                                                        <div class="col-xl-2 col-lg-12 col-md-4">
                                                            <div class="upload mt-4 pr-md-4">
                                                                <div class="dropify-wrapper has-preview">
                                                                    <div class="dropify-message">
                                                                        <span class="file-icon"></span> 
                                                                        <p>Click to Upload or Drag n Drop</p>
                                                                        <p class="dropify-error">Ooops, something wrong appended.</p>
                                                                    </div>
                                                                    <div class="dropify-loader" style="display: none;">
                                                                    </div>
                                                                    <div class="dropify-errors-container">
                                                                        <ul></ul>
                                                                    </div>
                                                                    <!--<input type="file" value="{{$user->profile_image}}" name="profile_image"  id="input-file-max-fs" class="dropify profile_image" data-default-file="admin/assets/img/200x200.jpg" data-max-file-size="2M">-->
                                                                    <button type="button" class="dropify-clear">
                                                                        <i class="flaticon-close-fill"></i>
                                                                    </button>
                                                                    <div class="dropify-preview" style="display: block;">
                                                                    <span class="dropify-render">
                                                                        <img src="{{$user->qr_code ? env('BASE_URL').$user->qr_code:''}}" id="category-img-tag">
                                                                    </span>
                                                                    <div class="dropify-infos">
                                                                        <div class="dropify-infos-inner">
                                                                            <p class="dropify-filename">
                                                                                <span class="file-icon"></span> 
                                                                                <span class="dropify-filename-inner">200x200.jpg</span>
                                                                            </p>
                                                                            <p class="dropify-infos-message">Upload or Drag n Drop</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @error('profile_image')
                                                                <span class="invalid-feedback" role="alert" style="display:block;">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                            <!--<p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload Picture</p>-->
                                                        </div>
                                                        </div>
                                                        <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="name">Account Name</label>
                                                                            <input type="text" class="form-control " readonly  id="name" placeholder="Account Name" value="{{$user->account_name}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="">Account Number</label>
                                                                            <input type="text" class="form-control "  readonly  placeholder="Account Number"  value="{{$user->account_number}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="form-group">
                                                                            <label for="">Bank Name</label>
                                                                            <input type="text" readonly class="form-control "   placeholder="Bank Name" value="{{$user->bank_name}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="account-settings-container layout-top-spacing">
                    <form id="general-info" class="section general-info" >
                      
                        <div class="account-content">
                            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                        <div class="info">
                                            <h6 class="">Other Information</h6>
                                           
                                                    
                                            <div class="">
                                                <div class="form">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="">IP Adderss</label>
                                                                <input type="text" class="form-control " readonly placeholder="IP Address" value="{{$user->ip_address}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="">Last Login Time</label>
                                                                <input type="text" class="form-control "  readonly  placeholder="Last Login Time"  value="{{$user->last_login_time}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="">Total Deposit($)</label>
                                                                <input type="text" readonly class="form-control "   placeholder="Total Deposit" value="{{$ttl_deposit}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="">Total Withdrawal($)</label>
                                                                <input type="text" readonly class="form-control "   placeholder="Total Withdrawal" value="{{$ttl_withdrawal}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label for="">Activities</label>
                                                                <input type="text" readonly class="form-control "   placeholder="Activities" value="{{$order}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                                
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @include('admin.layout.layout_scripts')
        </div>
    </div>
<!--  END CONTENT AREA  -->

<script>
    $(document).ready(function(e) {
        toastr.options.timeOut = 10000;
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif

        $('.profile_image').change(function(){
            
            let reader = new FileReader();
         
            reader.onload = (e) => { 
         
              $('#category-img-tag').attr('src', e.target.result); 
            }
         
            reader.readAsDataURL(this.files[0]); 
           
        });
           
    });   
</script>