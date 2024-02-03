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
                        <h3>Wallet Balance Management</h3>
                    </div>
                </div>
                <div class="account-settings-container layout-top-spacing">
                    <form id="general-info" class="section general-info" method="POST" action="{{route('update-wallet-balance', $wallet->id)}}" enctype="multipart/form-data">
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
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="">Current Wallet Balance <strong>${{$wallet->wallet_balance}}</strong></label>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="method_name">Choose Method</label>
                                                                    <select name="method_name" id="method_name" class="form-control" >
                                                                        <option value="Deposit" {{ old('method_name')  == 'Deposit' ? 'selected' : ''}}>Deposit</option>
                                                                        <option value="Withdraw" {{ old('method_name')  == 'Withdraw' ? 'selected' : ''}}>Withdraw</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="wallet_balance">Amount</label>
                                                                    <input type="text" value="{{ old('wallet_balance') }}" class="form-control"  id="wallet_balance" placeholder="Wallet Balance" name="wallet_balance" >
                                                                    @error('wallet_balance')
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
                                <button id="multiple-messages" type="submit" class="btn btn-primary">Save Changes</button>
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