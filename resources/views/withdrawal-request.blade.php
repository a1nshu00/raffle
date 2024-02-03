@include('layouts.header')
    
    <section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Withdrawal</h2>
                    <ul class="breadcrumb">
                        <li><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li>Withdrawal</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="main-sec">
        <div class="container">
    
            <form action="{{route('store-withdrawal-request')}}" method="post" id="detail_sbtm" enctype='multipart/form-data'>
                @csrf 
                <input type="hidden" name="method_name" id="method_name">
                <input type="hidden" name="fee" id="fee_hdn">
                <input type="hidden" name="wallet_balance" id="wallet_address" value="{{auth()->guard('web')->user()->wallet_balance}}">
                <input type="hidden" name="min_amount" id="min_amnt">
                <input type="hidden" name="qr_preview" id="image_prv" value="{{auth()->guard('web')->user()->qr_code}}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="carddesign cardbox cardbox2">
                            <h2>Wallet Balance</h2>
                            <h4>${{auth()->guard('web')->user()->wallet_balance}}</h4>
                        </div>
                        <!-- <div class="carddesign cardbox cardbox2">
                            <h2>Amount Add</h2>
                            <h4></h4>
                        </div> -->
                        <div class="carddesign cardbox cardbox2">
                            <h2>Payment Method</h2>
                            <span class="invalid-feedback" role="alert" style="display:block;">
                                    <strong id="withdrawal_management_err"></strong>
                            </span>
                            <div class="form-group">
                                <select class="form-control" name="channel_id" id="withdrawal_management" required>
                                    @if($withdrawal_management)
                                        <option value="" >Please select</option>
                                        @foreach($withdrawal_management as $key => $value)
                                            <option data-value="{{$value->name}}" value="{{$value->id}}" >{{$value->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="carddesign cardbox">
                            <h2>Bank Information</h2>    
                            <div class="loginbox addfunds" >
                                

                                <div class="row" id="b_fld" style="display:none;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fee</label>
                                            <h6 id="fee"></h6>
                                        </div>
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Minimum Amount</label>
                                            <h6 id="min_amount"></h6>
                                        </div> 
                                    </div>
                                </div>

                                <!-- User Bank detail -->
                                <div class="row bank_detail">
                                    <div class="col-md-6">
                                        <div class="form-group"> 
                                            <label for="account_name">Account Name</label>
                                            <input type="text" id="account_name" class="form-control" value=""  name="account_name">
                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                <strong id="account_name_err"></strong>
                                            </span>
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="account_number">Account Number</label>
                                            <input type="text" id="account_number" value="" class="form-control"  name="account_number">
                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                <strong id="account_number_err"></strong>
                                            </span>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row bank_detail">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="bank_name">Bank Name</label>
                                            <input type="text" id="bank_name" value="" class="form-control"  name="bank_name">
                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                <strong id="bank_err"></strong>
                                            </span>
                                        </div> 
                                    </div> 
                                </div>
                                <!-- User QR Detail -->
                                <div class="row qr_detail" style="display:none;">
                                    <div class="col-md-6">
                                        <div class="form-group"> 
                                            <label for="account_name_">Account Name</label>
                                            <input type="text" id="account_name_" class="form-control" value=""  name="account_name_">
                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                <strong id="account_name__err"></strong>
                                            </span>
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group"> 
                                            <label for="account_number_">E-wallet Number</label>
                                            <input type="text" id="account_number_" class="form-control" value=""  name="e_wallet_account_number">
                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                <strong id="account_number__err"></strong>
                                            </span>
                                        </div> 
                                    </div> 
                                </div>
                                <!-- <div class="row qr_detail" style="display:none;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>QR Code</label>
                                            <div class="codeqr">                                                
                                                <img src="{{asset('assets/images/no-preview.png')}}" id="qr_img_preview" alt="" height="50px">
                                            </div> 
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>QR Code</label>
                                            <div class="box" >
                                                <input type="file" name="qr_code" id="file-6" class="inputfile inputfile-4 file-5 qr_code_" data-multiple-caption="{count} files selected" multiple />
                                                <label for="file-6">
                                                <figure><img src="assets/images/fileup.png" class="img-fluid" alt=""></figure>
                                                <span>Upload QR</span></label>
                                            </div>
                                        </div> 
                                    </div>   
                                </div> -->
                                <!-- Amount and proof -->
                                <div class="row" >
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="text" id="amount" class="form-control" value=""  name="amount">
                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                <strong id="amount_er"></strong>
                                            </span>
                                        </div> 
                                    </div> 
                                    <!--<div class="col-md-6">-->
                                    <!--    <div class="form-group">-->
                                    <!--        <label>Attach Screenshot</label>-->
                                    <!--        <div class="box" >-->
                                    <!--            <input type="file" name="screenshot" id="file-5" class="inputfile inputfile-4 file-5 ss_" data-multiple-caption="{count} files selected" multiple />-->
                                    <!--            <label for="file-5">-->
                                    <!--            <figure><img src="assets/images/fileup.png" class="img-fluid" alt=""></figure>-->
                                    <!--            <span>Upload Screenshot</span></label>-->
                                    <!--        </div>-->
                                    <!--        @error('screenshot')-->
                                    <!--            <span class="invalid-feedback" role="alert" style="display:block;">-->
                                    <!--                <strong id="screenshot_err">{{ $message }}</strong>-->
                                    <!--            </span>-->
                                    <!--        @enderror-->
                                    <!--        <span class="invalid-feedback" role="alert" style="display:block;">-->
                                    <!--            <strong id="screenshot_err"></strong>-->
                                    <!--        </span>-->
                                    <!--    </div> -->
                                    <!--</div> -->
                                </div> 

                                <div id="ttl0" style="display:none;" class="infotext">
                                    <label id="ttl_pmnt"></label>
                                </div>
                                <div class="form-group loginboxbtn" id="usr_cnfrm" style="display:none;">
                                    <input type="button" value="Confirm" id="sbt_button" class="btn btn-info">
                                    <input type="button" value="Cancel" id="cnl_button" class="btn btn-info cancelbtn">
                                </div>
                                <div class="form-group loginboxbtn cont_btn">
                                    <input type="button" value="Continue" id="check_cnfrm" class="btn btn-info">
                                </div>
                                <h2>Instrucations</h2>
                                <div class="exinfo">
                                    <ul>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod Lorem ipsum dolor sit amet,</li>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</li>
                                        <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod Lorem ipsum dolor sit amet, consectetur</li>
                                    </ul>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </form> 

            <div class="fundsrequest">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="headingbox">Withdrawal Requests</h2>
                        <div class="carddesign cardbox">
                            
                            <div class="table-responsive tabledesign">
                                <table class="table dt-responsive categories_table">
                                    <thead>
                                        <tr>
                                            <th>Payment Method</th>
                                            <th>Amount</th>
                                            <th>Fee</th>
                                            <!--<th>Screenshot</th>-->
                                            <th>Status</th>                    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($withdrawal_requests)
                                            @foreach($withdrawal_requests as $key => $value)
                                                <tr>
                                                    <td>{{$value->name}}</td>
                                                    <td><span class="fee">${{$value->amount}}</span></td>
                                                    <td>{{$value->fee.'%'}}</td>
                                                    <!--<td class="fundsscreenshot"><img src="{{env('BASE_URL').$value->screenshot}}"></td>-->
                                                    @if($value->status == 'Rejected')
                                                        <td><span class="statusdesign reject">{{$value->status}}</span></td>                    
                                                    @elseif($value->status == 'Approved')
                                                        <td><span class="statusdesign confirm">{{$value->status}}</span></td>                    
                                                    @else
                                                        <td><span class="statusdesign pending">{{$value->status}}</span></td>                    
                                                    @endif                 
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@include('layouts.footer')
<script type="text/javascript"src="https://code.jquery.com/jquery-3.5.1.js"> </script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"> </script>
<script>
    $('.categories_table').DataTable();
    $(document).ready(function(){
        toastr.options.timeOut = 10000;
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif
    });
    $('body').delegate('#withdrawal_management', 'change', function(){
       
        var channel_id = $(this).val();
        var method_type = $(this).find(':selected').data('value');
        $('#method_name').val(method_type);
        if(channel_id){
            $('#withdrawal_management_err').html('')
            $.ajax({
            url: "{{ route('withdrawal-management-detail')}}?channel_id="+channel_id,
            type: 'get',
            data: {'channel_id':channel_id},
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if(data.status == 200){
                    $('#account_name').val('');
                    $('#account_number').val('');
                    $('#bank_name').val('');

                    $('#account_name_').val('');
                    $('#account_number_').val('');
                    $('#qr_img_preview').attr('src', '');
                    if(method_type == 'Bank'){
                        if(data.user_withdrawal_detail){
                            $('#account_name').val(data.user_withdrawal_detail.account_name);
                            $('#account_number').val(data.user_withdrawal_detail.account_number);
                            $('#bank_name').val(data.user_withdrawal_detail.bank_name);
                        }
                       $('.bank_detail').show();
                       $('.qr_detail').hide();
                    }else{
                        if(data.user_withdrawal_detail){
                            $('#account_name_').val(data.user_withdrawal_detail.account_name);
                            $('#account_number_').val(data.user_withdrawal_detail.account_number);
                            $('#qr_img_preview').attr('src',  location.origin+'/'+data.user_withdrawal_detail.qr_code);
                        }
                        $('.bank_detail').hide();
                        $('.qr_detail').show();
                    }
                    $('#b_fld').show();
                    $('#fee').html(data.data.fee+' %');
                    $('#min_amount').html('$'+data.data.min_amount);
                    $('#fee_hdn').val(data.data.fee);
                    $('#min_amnt').val(data.data.min_amount)



                }
            },
        });
        } 
    });
    
    $('body').delegate('#check_cnfrm', 'click', function(){
        var amount = $('#amount').val();
        // var screenshot =    $(".ss_")[0].files.length;
        var withdrawal_management = $('#withdrawal_management').val();
        if(!withdrawal_management){
            $('#withdrawal_management_err').html('The withdrawal field is required.')
            return false;
        }else{
            $('#withdrawal_management_err').html('')
        }
        
        if($('#withdrawal_management option:selected').html() == 'Bank'){

            let account_name = $('#account_name').val();
            let account_number = $('#account_number').val();
            let bank_name = $('#bank_name').val();
            

            if(!account_name){
                $('#account_name_err').html('The account name field is required.')
                return false;
            }else{
                $('#account_name_err').html('')
            }
            if(!account_number){
                $('#account_number_err').html('The account number field is required.')
                return false;
            }else{
                $('#account_number_err').html('')
            }
            if(!bank_name){
                $('#bank_err').html('The bank name field is required.')
                return false;
            }else{
                $('#bank_err').html('')
            }

        }else{
            
            let account_name = $('#account_name_').val();
            let account_number = $('#account_number_').val();
            // let qr_code = $(".qr_code_")[0].files.length;
            let qr_preview = $("#image_prv").val();
            if(!account_name){
                $('#account_name__err').html('The account name field is required.')
                return false;
            }else{
                $('#account_name__err').html('')
            }
            if(!account_number){
                $('#account_number__err').html('The e-wallet account number field is required.')
                return false;
            }else{
                $('#account_number__err').html('')
            }
            // if(qr_code || qr_preview){
            //     $('#qr_code_err').html('')
            // }else{
            //     $('#qr_code_err').html('The QR code field is required.')
            //     return false;
            // }
        }
        
        if(!amount){
            $('#amount_er').html('The amount field is required.')
            return false;
        }else{
            $('#amount_er').html('')
        }
        // if(!screenshot){
        //     $('#screenshot_err').html('The screenshot field is required.')
        //     return false;
        // }else{
        //     $('#screenshot_err').html('')
        // }
        if(amount && withdrawal_management){
            let fee_amnt = parseInt($('#fee').html())*parseInt(amount)/100;
            let txt = `Total amount is $${parseInt(amount)} and its ${parseInt($('#fee').html())}% is $${fee_amnt} so amount payable is $${parseInt(amount)}-$${fee_amnt} = $${parseInt(amount) - fee_amnt}.`;
            $('#ttl_pmnt').html(txt);
            $('#ttl0').show();
            $('#usr_cnfrm').show();
            $('.cont_btn').hide();
            $('#amount').attr('disabled',true);
        }
    });

    $('body').delegate('#cnl_button', 'click', function(){
        
        $('#ttl_pmnt').html('');
        $('#ttl0').hide();
        $('#usr_cnfrm').hide();
        $('.cont_btn').show();
        $('#amount').attr('disabled',false);
        
    });

    $('body').delegate('#sbt_button', 'click', function(e){
        
        $('#amount').attr('disabled',false);
        var amount = $('#amount').val();
        // var screenshot =    $(".ss_")[0].files.length;
        var withdrawal_management = $('#withdrawal_management').val();
        
        if(amount && withdrawal_management ){
            $('#detail_sbtm').submit();
        }else{
            toastr.error('Please try again, something went wrong.');
        }
    });

    

  </script>

