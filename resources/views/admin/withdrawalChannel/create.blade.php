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
                        <h3>Create Withdrawal Channel</h3>
                    </div>
                </div>
                <div class="account-settings-container layout-top-spacing">
                    <form id="general-info" class="section general-info" method="POST" action="{{route('withdrawal-channel.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="account-content">
                            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                        <div class="info">
                                            <h6 class="">General Information</h6>
                                            
                                                    <div class="row">
                                                      
                                                        <div class="col-xl-12 col-lg-12 col-md-12 mt-md-0 mt-4">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="method_name">Method Name</label>
                                                                            <select name="method_name" id="method_name" class="form-control" >
                                                                                <option value="Bank" {{ old('method_name')  == 'Bank' ? 'selected' : ''}}>Bank</option>
                                                                                <option value="Gcash" {{ old('method_name')  == 'Gcash' ? 'selected' : ''}}>Gcash</option> 
                                                                                <option value="paymaya" {{ old('method_name')  == 'Paymaya' ? 'selected' : ''}}>Paymaya</option>
                                                                                <option value="coinph" {{ old('method_name')  == 'Coinph' ? 'selected' : ''}}>Coinph</option>
                                                                            </select>
                                                                            @error('method_name')
                                                                                <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label for="fee">Fee</label>
                                                                            <input type="text" value="{{ old('fee') }}" class="form-control"  id="fee" placeholder="Fee" name="fee" >
                                                                            @error('fee')
                                                                                <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        
                                                                        <div class="form-group">
                                                                            <label for="min_amount">Min Amount</label>
                                                                            <input type="text" class="form-control"  id="min_amount" placeholder="Min Amount" name="min_amount" value="{{ old('min_amount') }}" >
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

       
    }); 
 
    
</script>