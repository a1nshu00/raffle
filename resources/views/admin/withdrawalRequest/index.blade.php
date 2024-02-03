@include('admin.layout.header')
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
                <div class="page-header header_btn">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title">
                                <h3>Withdrawal Request Management</h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="account-settings-container layout-top-spacing">
                    <div class="general-info">
                       <div class="info filterform filterbtnbottom">
                            <form action="{{route('withdrawal-request')}}" method="get" id="fltr_frm">
                                <input type="hidden" name="view_all" id="view_al">
                                <input type="hidden" name="tab_active" id="tb_act" value="{{@$_GET['tab_active'] ?  @$_GET['tab_active'] : '#pending'}}">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            @if(@$_GET['tab_active'] == '#approve')
                                                <label for="">Total Approved Withdrawal Amount<strong class="amountd">${{$approved_withdrawal_amount}}</strong></label>
                                            @elseif(@$_GET['tab_active'] == '#rejected')
                                                <label for="">Total Rejected Withdrawal Amount<strong class="amountd">${{$rejected_withdrawal_amount}}</strong></label>
                                            @else
                                                <label for="">Total Pending Withdrawal Amount<strong class="amountd">${{$pending_withdrawal_amount}}</strong></label>
                                            @endif
                                            
                                        </div>
                                    </div>
                               </div>
                                <div class="row">
                                   <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="from_date">From Date</label>
                                            <input type="date" class="form-control" id="from_date" name="from_date"  value="{{@$_GET['from_date']}}"> 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="to_date">To Date</label>
                                            <input type="date" class="form-control" id="to_date" name="to_date" value="{{@$_GET['to_date']}}">  
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="withdrawal_methods">Withdrawal Methods</label>
                                            <select name="withdrawal_methods" id="withdrawal_methods" class="form-control">
                                                <option value="">Please select...</option>
                                                @if(count($withdrawal_methods))
                                                    @foreach($withdrawal_methods as $key => $value)
                                                        <option value="{{$value->id}}" {{(@$_GET['withdrawal_methods'] == $value->id) ? 'selected' : ''}}>{{$value->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        <div class="form-group filterformbtn">
                                            <input type="submit" class="btn btn-success" value="Apply"> 
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        <div class="form-group filterformbtn">
                                            <input type="button" class="btn btn-success viewall" id="view_all" name="view_all" value="View All"> 
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        <div class="form-group filterformbtn">
                                            <a href="{{route('withdrawal-request')}}" class="btn btn-success resetall">Reset All</a> 
                                        </div>
                                    </div>
                               </div>
                               
                            </form>
                       </div>
                    </div>
                </div>
                           
                <div class="account-settings-container layout-top-spacing">
                    <div class="section general-info">
                        <div class="info tabdesign">
                           
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link {{$tab_active ? ($tab_active == '#pending') ? 'active' : ''  : 'active'}} tabs_btn" data-toggle="tab" href="#pending">Pending</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link {{$tab_active ? ($tab_active == '#approve') ? 'active' : ''  : ''}} tabs_btn" data-toggle="tab" href="#approve">Approved</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link {{$tab_active ? ($tab_active == '#rejected') ? 'active' : ''  : ''}} tabs_btn" data-toggle="tab" href="#rejected">Rejected </a>
                                </li>
                            </ul>
                             <div class="tab-content">
                                <div id="pending" class="tab-pane {{$tab_active ? ($tab_active == '#pending') ? 'active' : ''  : 'active'}}">
                                   <div class="table-responsive">
                                        <table class="table table-bordered" id="withdrawalRequestManagement_pending">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th style="min-width: 120px;">Name</th>
                                                    <th style="min-width: 120px;">Email</th>
                                                    <th style="min-width: 120px;">Account Name</th>
                                                    <th style="min-width: 150px;">Account Number</th>
                                                    <!-- <th style="min-width: 120px;">QR Code</th> -->
                                                    <th style="min-width: 120px;">Bank Name</th>
                                                    <th style="min-width: 150px;">Wallet Balance</th>
                                                    <th style="min-width: 150px;">Amount</th>
                                                    <th style="min-width: 178px;">Withdrawal Method</th>
                                                    <th style="min-width: 165px;">Request Time</th>
                                                    <th style="min-width: 165px;">Updated Time</th>
                                                    <th style="min-width: 130px; width: 120px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($withdrawal_request_pending) > 0)
                                                    @foreach($withdrawal_request_pending as $key => $value)
                                                        <tr>
                                                            <td class="text-center">{{$key+1}}</td>
                                                            <td>{{$value->first_name}}</td>
                                                            <td>{{$value->email}}</td>
                                                            <td>{{$value->account_name}}</td>
                                                            <td>{{$value->account_number}}</td>
                                                            <!-- <td><div class="depositscreenshot"><img data-bs-toggle="modal" data-bs-target="#image_preview" class="img_pre" src="{{$value->qr_code ? url('/').'/'.$value->qr_code : ''}}" alt="" height="50px"></div></td> -->
                                                            <td>{{$value->bank_name}}</td>
                                                            <td>{{$value->wallet_balance}}</td>
                                                            <td>{{$value->amount}}</td>
                                                            <td>{{ $value->name}}</td>
                                                            <td>{{ \Carbon\Carbon::parse($value->created_at)->format('M d-Y h:i A')}}</td>
                                                            <td>{{ \Carbon\Carbon::parse($value->updated_at)->format('M d-Y h:i A')}}</td>
                                                            <td>
                                                                <ul class="table-controls"> 
                                                                    @if($value->wallet_balance >= $value->amount)
                                                                        <li>
                                                                            <form method="post" action="{{ route('update-withdrawal-request', $value->id) }}" id="approve_frm_{{$value->id}}">
                                                                                @csrf
                                                                                <button type="submit"  class="aprv_ dlt_btn" data-id="{{$value->id}}" name="approve" value="Approve" data-toggle="tooltip" data-placement="top" title="Approve">
                                                                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                                                </button>
                                                                            </form>
                                                                        </li>
                                                                    @endif
                                                                    <li>
                                                                        <button type="button"  data-bs-toggle="modal" data-action="{{ route('update-withdrawal-request', $value->id) }}" data-bs-target="#exampleModal"  class="rejct_ dlt_btn" data-id="{{$value->id}}" name="reject" value="rejected" data-toggle="tooltip" data-placement="top" title="reject" >
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                                        </button>
                                                                    </li>
                                                                    
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="approve" class="tab-pane {{$tab_active ? ($tab_active == '#approve') ? 'active' : ''  : ''}}">
                                   <div class="table-responsive">
                                        <table class="table table-bordered" id="withdrawalRequestManagement">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th style="min-width: 120px;">Name</th>
                                                    <th style="min-width: 120px;">Email</th>
                                                    <th style="min-width: 120px;">Account Name</th>
                                                    <th style="min-width: 150px;">Account Number</th>
                                                    <!-- <th style="min-width: 120px;">QR Code</th> -->
                                                    <th style="min-width: 120px;">Bank Name</th>
                                                    <th style="min-width: 150px;">Wallet Balance</th>
                                                    <th style="min-width: 150px;">Amount</th>
                                                    <th style="min-width: 128px;">Withdrawal Method</th>
                                                    <th style="min-width: 165px;">Request Time</th>
                                                    <th style="min-width: 165px;">Updated Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($withdrawal_request_approved) > 0)
                                                    @foreach($withdrawal_request_approved as $key => $value)
                                                        <tr>
                                                            <td class="text-center">{{$key+1}}</td>
                                                            <td>{{$value->first_name}}</td>
                                                            <td>{{$value->email}}</td>
                                                            <td>{{$value->account_name}}</td>
                                                            <td>{{$value->account_number}}</td>
                                                            <!-- <td><div class="depositscreenshot"><img data-bs-toggle="modal" data-bs-target="#image_preview" class="img_pre" src="{{$value->qr_code ? url('/').'/'.$value->qr_code : ''}}" alt="" height="50px"></div></td> -->
                                                            <td>{{$value->bank_name}}</td>
                                                            <td>{{$value->wallet_balance}}</td>
                                                            <td>{{$value->amount}}</td>
                                                            <td>{{ $value->name}}</td>
                                                            <td>{{ \Carbon\Carbon::parse($value->created_at)->format('M d-Y h:i A')}}</td>
                                                            <td>{{ \Carbon\Carbon::parse($value->updated_at)->format('M d-Y h:i A')}}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="rejected" class="tab-pane fade {{$tab_active ? ($tab_active == '#rejected') ? 'active show' : ''  : ''}}">
                                     <div class="table-responsive">
                                         <table class="table table-bordered" id="withdrawalRequestManagement_rejected">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th style="min-width: 120px;">Name</th>
                                                    <th style="min-width: 120px;">Email</th>
                                                    <th style="min-width: 120px;">Account Name</th>
                                                    <th style="min-width: 150px;">Account Number</th>
                                                    <!-- <th style="min-width: 120px;">QR Code</th> -->
                                                    <th style="min-width: 120px;">Bank Name</th>
                                                    <th style="min-width: 150px;">Wallet Balance</th>
                                                    <th style="min-width: 150px;">Amount</th>
                                                    <th style="min-width: 128px;">Withdrawal Method</th>
                                                    <th style="min-width: 165px;">Request Time</th>
                                                    <th style="min-width: 165px;">Updated Time</th>
                                                    <th style="min-width: 130px; width: 120px;">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($withdrawal_request_rejected) > 0)
                                                    @foreach($withdrawal_request_rejected as $key => $value)
                                                        <tr>
                                                            <td class="text-center">{{$key+1}}</td>
                                                            <td>{{$value->first_name}}</td>
                                                            <td>{{$value->email}}</td>
                                                            <td>{{$value->account_name}}</td>
                                                            <td>{{$value->account_number}}</td>
                                                            <!-- <td><div class="depositscreenshot"><img data-bs-toggle="modal" data-bs-target="#image_preview" class="img_pre" src="{{$value->qr_code ? url('/').'/'.$value->qr_code : ''}}" alt="" height="50px"></div></td> -->
                                                            <td>{{$value->bank_name}}</td>
                                                            <td>{{$value->wallet_balance}}</td>
                                                            <td>{{$value->amount}}</td>
                                                            <td>{{ $value->name}}</td>
                                                            <td>{{ \Carbon\Carbon::parse($value->created_at)->format('M d-Y h:i A')}}</td>
                                                            <td>{{ \Carbon\Carbon::parse($value->updated_at)->format('M d-Y h:i A')}}</td>
                                                            <td>{{$value->remarks}}</td>
                                                            
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
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reject Remark</h5>
                        </div>
                        <form method="post" action id="remarks_form">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="message-text" class="col-form-label">Remark:</label>
                                    <textarea class="form-control remarks" name="remarks" id="message-text"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close_model" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="reject" value="rejected" class="btn btn-primary">Send message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="image_preview" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Image</h5>
                        </div>
                       
                        <div class="modal-body">
                            <div class="mb-3">
                                <image src="" id="preview_img" style="height: 427px; width: -webkit-fill-available;" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary close_preview_img" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.layout.footer')
        </div>
    </div>
<!--  END CONTENT AREA  -->
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<!-- Bootstrap model  script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        toastr.options.timeOut = 10000;
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif
     
      
        $('#withdrawalRequestManagement').DataTable();
        $('#withdrawalRequestManagement_pending').DataTable();
        $('#withdrawalRequestManagement_rejected').DataTable();

        $('.aprv_').click(function(e){
            var id = $(this).data('id');
            if(confirm('Are you sure?')){
                $('#approve_frm_'+id).submit();
            }else{
                e.preventDefault();
            }
        });

        $('.rejct_').click(function(){
           $('#remarks_form').attr('action', $(this).data('action'));
        });
        

        $('.close_model').click(function(e){
            $('#remarks_form').attr('action', '');
            $('.remarks').val('');
        });
        
        
    });
    
    $('body').delegate('#view_all', 'click', function(){
        $('#from_date').val('');
        $('#to_date').val('');
        $('#view_al').val(1);
        $('#withdrawal_methods').val('');
        $('#fltr_frm').submit();
    });

    $('body').delegate('.tabs_btn', 'click', function(){
        $('#tb_act').val($(this).attr('href'));
    });
    
    $('body').delegate('.img_pre', 'click', function(){
        $('#preview_img').attr('src', $(this).attr('src'));
    });
    
    $('body').delegate('.close_preview_img', 'click', function(){
        $('#preview_img').attr('src', '');
    });
  
</script>