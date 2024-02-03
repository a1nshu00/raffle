@include('layouts.header')
    
    <section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Add Funds</h2>
                    <ul class="breadcrumb">
                        <li><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li>Add funds</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="main-sec">
        <div class="container">
    
            <form action="{{route('store-funds')}}" method="post" id="detail_sbtm" enctype='multipart/form-data'>
                @csrf 
                <input type="hidden" name="hidden_fee" value="" id="fee_hdn">
                <input type="hidden" name="min_amount"  id="min_amnt">
                <input type="hidden" name="raffle_id" value="{{isset($data['raffle_id']) ?$data['raffle_id'] : '' }}" >
                <div class="row">
                    <div class="col-md-4">
                        <div class="carddesign cardbox cardbox2">
                            <h2>Wallet Balance</h2>
                            <h4>${{auth()->guard('web')->user()->wallet_balance}}</h4>
                        </div>
                        @if(isset($data['total_buying_amount']))
                            <div class="carddesign cardbox cardbox2">
                                <h2>Amount Add</h2>
                                <h4>{{$data['total_buying_amount']}}</h4>
                            </div>
                        @endif
                        <div class="carddesign cardbox cardbox2">
                            <h2>Payment Method</h2>
                            <div class="form-group">
                                <select class="form-control" name="channel_id" id="deposit_channel">
                                    @if($deposit_channel)
                                        <option value="" >Please select</option>
                                        @foreach($deposit_channel as $key => $value)
                                            <option data-id="{{$value->channel_type}}" value="{{$value->id}}">Name: {{$value->name}} Method: {{$value->channel_type}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="invalid-feedback" role="alert" style="display:block;">
                                    <strong id="deposit_channel_err"></strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="carddesign cardbox">
                            <h2>Bank Information</h2>    
                            <div class="loginbox addfunds" >
                                
                                <div class="row" id="qr_code_" style="display:none;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Qr code</label>
                                            <div class="codeqr add-fundsqu"><img height="50px" id="qr_code"  src=""></div>
                                        </div>
                                    </div>    
                                </div>

                                <div class="row ext_fld" style="display:none;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Account Name</label>
                                            <h6 id="bank_account_name"></h6>
                                        </div>
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Account Number</label>
                                            <h6 id="bank_account_number"></h6>
                                        </div> 
                                    </div>
                                </div>

                                <div class="row" id="bnk_ifsc" style="display:none;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Bank Name</label>
                                            <h6 id="bank_bank_name"></h6>
                                        </div>
                                    </div> 
                                    <!--<div class="col-md-6">-->
                                    <!--    <div class="form-group">-->
                                    <!--        <label>Ifsc Code</label>-->
                                    <!--        <h6 id="bank_ifsc"></h6>-->
                                    <!--    </div>-->
                                    <!--</div> -->
                                   
                                </div> 

                                <div class="row ext_fld" style="display:none;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fee</label>
                                            <h6 id="bank_fee"></h6>
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Minimum Amount</label>
                                            <h6 id="bank_min_amount"></h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="row addfundsrow">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="text" class="form-control"  name="amount" id="bank_amount">
                                            @error('amount')
                                                <span class="invalid-feedback" role="alert" style="display:block;">
                                                    <strong id="amount_er">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                <strong id="amount_er"></strong>
                                            </span>
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Attach Screenshot</label>
                                            <div class="box" >
                                                <input type="file" name="screenshot" id="file-5" class="inputfile inputfile-4 bank_prffo_img ss_" data-multiple-caption="{count} files selected" multiple />
                                                <label for="file-5">
                                                <figure><img src="assets/images/fileup.png" class="img-fluid" alt=""></figure>
                                                <span>Upload Screenshot</span></label>
                                            </div>
                                            @error('screenshot')
                                                <span class="invalid-feedback" role="alert" style="display:block;">
                                                    <strong id="screenshot_err">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                <strong id="screenshot_err"></strong>
                                            </span>
                                        </div> 
                                    </div> 
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
                        <h2 class="headingbox">Funds Request</h2>
                        <div class="carddesign cardbox">
                            
                            <div class="table-responsive tabledesign">
                                <table class="table dt-responsive categories_table">
                                    <thead>
                                        <tr>
                                            <th>Payment Method</th>
                                            <th>Amount</th>
                                            <th>Fee</th>
                                            <th>Screenshot</th>
                                            <th>Status</th>                    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($deposit_requests)
                                            @foreach($deposit_requests as $key => $value)
                                                <tr>
                                                    <td>{{$value->channel_type}}</td>
                                                    <td><span class="fee">${{$value->amount}}</span></td>
                                                    <td>{{$value->fee_type == 'Percentage' ? $value->fee.'%' : '$'.$value->fee}}</td>
                                                    <td class="fundsscreenshot"><img src="{{env('BASE_URL').$value->screenshot}}" class="img-fluid prizeimage"></td>
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

    $(document).ready(function(){
       toastr.options.timeOut = 10000;
      @if (Session::has('error'))
          toastr.error('{{ Session::get('error') }}');
      @elseif(Session::has('success'))
          toastr.success('{{ Session::get('success') }}');
      @endif 
    });
    $('.categories_table').DataTable();
   
    $('body').delegate('#deposit_channel', 'change', function(){
       
        var channel_id = $(this).val();
        var method_type = $(this).find(':selected').data('id');
        if(channel_id){
            $('#deposit_channel_err').html('')
            $.ajax({
            url: "{{ route('deposit-channel-detail')}}?channel_id="+channel_id,
            type: 'get',
            data: {'channel_id':channel_id},
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if(data.status == 200){
                    $('#bank_account_name').html(data.data.account_name);
                    $('#bank_account_number').html(data.data.account_number? data.data.account_number : data.data.e_wallet_account_number);
                    $('#bank_fee').html(data.data.fee_type == 'Percentage' ? data.data.fee + ' %' : '$ ' + data.data.fee);
                    $('#bank_min_amount').html(data.data.min_amount);
                    $('#fee_hdn').val(data.data.fee);
                    $('#min_amnt').val(data.data.min_amount)
                    if(method_type == 'Bank'){
                        $('.ext_fld').show();
                        $('#bnk_ifsc').show();
                        $('#qr_code_').hide();

                        $('#bank_bank_name').html(data.data.bank_name);
                        $('#bank_ifsc').html(data.data.IFSC_code);
                    }else{

                        $('.ext_fld').show();
                        $('#bnk_ifsc').hide();
                        $('#qr_code_').show();
                        $('#qr_code').attr('src', window.location.origin+'/'+data.data.qr_code);
                    }
                   
                }
            },
        });
        } 
    });
    
    $('body').delegate('#check_cnfrm', 'click', function(){
        var amount = $('#bank_amount').val();
        var screenshot =    $(".ss_")[0].files.length;
        
        var deposit_channel = $('#deposit_channel').val();

        if(!deposit_channel){
            $('#deposit_channel_err').html('The payment method field is required.')
            return false;
        }else{
            $('#deposit_channel_err').html('')
        }
        if(!amount){
            $('#amount_er').html('The amount field is required.')
            return false;
        }else{
            $('#amount_er').html('')
        }
        if(!screenshot){
            $('#screenshot_err').html('The screenshot field is required.')
            return false;
        }else{
            $('#screenshot_err').html('')
        }
        if(amount && screenshot && deposit_channel){
            let fee_amnt = parseInt($('#bank_fee').html())*parseInt(amount)/100;
            let txt = `Total amount is $${parseInt(amount)} and its ${$('#bank_fee').html()} is $${fee_amnt} so amount payable is $${parseInt(amount)}-$${fee_amnt} = $${parseInt(amount) - fee_amnt}.`;
            $('#ttl_pmnt').html(txt);
            $('#ttl0').show();
            $('#usr_cnfrm').show();
            $('.cont_btn').hide();
            $('#bank_amount').attr('disabled',true);
        }
    });

    $('body').delegate('#cnl_button', 'click', function(){
        
        $('#ttl_pmnt').html('');
        $('#ttl0').hide();
        $('#usr_cnfrm').hide();
        $('.cont_btn').show();
        $('#bank_amount').attr('disabled',false);
        
    });

    $('body').delegate('#sbt_button', 'click', function(e){
        $('#bank_amount').attr('disabled',false);
        var amount = $('#bank_amount').val();
        var screenshot =    $(".ss_")[0].files.length;

        var deposit_channel = $('#deposit_channel').val();

        if(!deposit_channel){
            $('#deposit_channel_err').html('The payment method field is required.')
            return false;
        }else{
            $('#deposit_channel_err').html('')
        }
        if(!amount){
            $('#amount_er').html('The amount field is required.')
            return false;
        }else{
            $('#amount_er').html('')
        }
        if(!screenshot){
            $('#screenshot_err').html('The screenshot field is required.')
            return false;
        }else{
            $('#screenshot_err').html('')
        }

        if(amount && screenshot && deposit_channel){
            console.log('ok');
            $('#detail_sbtm').submit();
        }

    });
  </script>

