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
                        <h3>Create Deposit Channel</h3>
                    </div>
                </div>
                <div class="account-settings-container layout-top-spacing">
                    <form id="general-info" class="section general-info" method="POST" action="{{route('deposit-channel.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="account-content">
                            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                        <div class="info">
                                            <h6 class="">General Information</h6>
                                            
                                                    <div class="row">
                                                        <!-- QR Code Image -->
                                                        <div class="col-xl-12 col-lg-12 col-md-12 e-wallet" style="display:none;">
                                                            <div class="upload mb-4 pr-md-4">
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
                                                                    <input type="file" name="qr_code"  id="input-file-max-fs" class="dropify qr_code"  data-default-file="admin/assets/img/200x200.jpg" data-max-file-size="2M">
                                                                    <button type="button" class="dropify-clear">
                                                                        <i class="flaticon-close-fill"></i>
                                                                    </button>
                                                                    <div class="dropify-preview" style="display: block;">
                                                                    <span class="dropify-render">
                                                                        <img src="" id="category-img-tag">
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
                                                            <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload QR</p>
                                                            @error('qr_code')
                                                                <span class="invalid-feedback" role="alert" style="display:block; text-align:center;">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        </div>
                                                        <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="name">Channel Name</label>
                                                                            <input type="text" class="form-control"  id="name" placeholder="Channel Name" name="name" value="{{ old('name') }}" >
                                                                            @error('name')
                                                                                <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="channel_type">Channel Type</label>
                                                                            <select name="channel_type" id="channel_tye" class="form-control" >
                                                                                <option value="Bank" {{ old('channel_type')  == 'Bank' ? 'selected' : ''}}>Bank</option>
                                                                                <option value="E-wallet" {{ old('channel_type')  == 'E-wallet' ? 'selected' : ''}}>E-wallet</option>
                                                                            </select>
                                                                            @error('channel_type')
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
                                                                            <label for="account_name">Account Name</label>
                                                                            <input type="text" value="{{ old('account_name') }}" class="form-control account-name"  id="account_name" placeholder="Account Name" name="account_name" >
                                                                            @error('account_name')
                                                                                <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 bnk_ac">
                                                                        <div class="form-group">
                                                                            <label for="account_number">Account Number</label>
                                                                            <input type="text" value="{{ old('account_number') }}" class="form-control"  id="account_number" placeholder="Account Number" name="account_number" >
                                                                            @error('account_number')
                                                                                <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-sm-6 e_wlt_ac" style="display:none;">
                                                                        <div class="form-group">
                                                                            <label for="e_wallet_account_number">E-wallet Number</label>
                                                                            <input type="text" value="{{ old('e_wallet_account_number') }}" class="form-control"  id="e_wallet_account_number" placeholder="E-wallet Number" name="e_wallet_account_number" >
                                                                            @error('e_wallet_account_number')
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
                                                                            <label>Fee Type</label> 
                                                                            <ul class="form-checkul">
                                                                                <li>
                                                                                   <div class="form-check">
                                                                                   <input type="radio" class="form-check-input"  id="Percentage" placeholder="Percentage" name="fee_type" value="Percentage" checked >
                                                                                   <label for="Percentage">Percentage</label>
                                                                                   </div>
                                                                                </li>
                                                                                <li>
                                                                                   <div class="form-check">
                                                                                   <input type="radio" class="form-check-input"  id="Fixed" placeholder="Fixed" name="fee_type" value="Fixed" >
                                                                                   <label for="Fixed">Fixed</label>  
                                                                                   </div>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="fee">Fee</label>
                                                                            <input type="text" class="form-control "  id="fee" placeholder="Fee" name="fee" value="{{ old('fee') }}" >
                                                                            @error('fee')
                                                                                <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                
                                                               <div class="bank">
                                                                   <div class="row">
                                                                       <div class="col-sm-12">
                                                                           <div class="form-group">
                                                                               <label for="bank_name">Bank Name</label>
                                                                               <input type="text" value="{{ old('bank_name') }}" class="form-control bank-name"  id="bank_name" placeholder="Bank Name" name="bank_name" >
                                                                               @error('bank_name')
                                                                                   <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                       <strong>{{ $message }}</strong>
                                                                                   </span>
                                                                               @enderror 
                                                                           </div>
                                                                       </div>
                                                                       <!--<div class="col-sm-6">-->
                                                                       <!--    <div class="form-group">-->
                                                                       <!--         <label for="IFSC_code">IFSC Code</label>-->
                                                                       <!--         <input type="text" value="{{ old('IFSC_code') }}" class="form-control "  id="IFSC_code" placeholder="IFSC Code" name="IFSC_code" >-->
                                                                       <!--         @error('IFSC_code')-->
                                                                       <!--             <span class="invalid-feedback" role="alert" style="display:block;">-->
                                                                       <!--                 <strong>{{ $message }}</strong>-->
                                                                       <!--             </span>-->
                                                                       <!--         @enderror-->
                                                                       <!--     </div>-->
                                                                          
                                                                       <!--</div>-->
                                                                   </div>
                                                                  
                                                               </div>
                                                               <div class="row">
                                                                   <div class="col-sm-12">
                                                                       
                                                                        <div class="form-group">
                                                                            <label for="min_amount">Min Amount</label>
                                                                            <input type="text" class="form-control "  id="min_amount" placeholder="Min Amount" name="min_amount" value="{{ old('min_amount') }}" >
                                                                            @error('min_amount')
                                                                                <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
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
                        <div class="account-settings-footer">
                            <div class="as-footer-container">
                                <!-- <button id="multiple-reset" type="button" class="btn btn-warning">Reset All</button> -->
                                <button id="multiple-messages" type="submit" class="btn btn-primary">Save Changes</button>
                                <!-- <div class="blockui-growl-message" style="cursor: default;">
                                    <i class="flaticon-double-check"></i>&nbsp; Settings Saved Successfully
                                </div> -->
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

        $('.qr_code').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => { 
              $('#category-img-tag').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
           
        });
        if($('#channel_tye').val() == 'Bank'){
            $('.bnk_ac').show();
            $('.e_wlt_ac').hide();
            $('.bank').show();
            $('.e-wallet').hide();
        }else{
            $('.bnk_ac').hide();
            $('.e_wlt_ac').show();
            $('.bank').hide();
            $('.e-wallet').show();
        }
        $('.bank-name,.account-name').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z ]+$");
        var strigChar = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(strigChar)) {
            return true;
        }
        return false

    }); 
    $('body').delegate('#channel_tye', 'change', function(){
        console.log($(this).val());
        if($(this).val() == 'Bank'){
            $('.bnk_ac').show();
            $('.e_wlt_ac').hide();
            $('.bank').show();
            $('.e-wallet').hide();
        }else{
            $('.bnk_ac').hide();
            $('.e_wlt_ac').show();
            $('.bank').hide();
            $('.e-wallet').show();
        }
    });
   
  });
</script>