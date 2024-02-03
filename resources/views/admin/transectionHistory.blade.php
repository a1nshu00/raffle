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
                                <h3>Transaction History</h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="account-settings-container layout-top-spacing">
                    <div class="section general-info">
                        <div class="info filterform filterbtnbottom">
                             <form action="{{route('transaction-history')}}" method="get">
                                @csrf 
                                 @if(@$_GET['transaction_type'])
                                    @if($_GET['transaction_type'] == 'Purchased')
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group">
                                                    <label for="">Total Purchased Amount<strong class="amountd">${{$transaction_type_amount}}</strong></label>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($_GET['transaction_type'] == 'Deposit')
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group">
                                                    <label for="">Total Deposit Amount<strong class="amountd">${{$transaction_type_amount}}</strong></label>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3">
                                                <div class="form-group">
                                                    <label for="">Total Withdrawal Amount<strong class="amountd">${{$transaction_type_amount}}</strong></label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                @else
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label for="">Total Purchased Amount<strong class="amountd">${{$purchased_amount}}</strong></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label for="">Total Deposit Amount<strong class="amountd">${{$deposit_amount}}</strong></label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label for="">Total Withdrawal Amount<strong class="amountd">${{$withdrawal_amount}}</strong></label>
                                            </div> 
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                   <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="from_date">From Date</label>
                                            <input type="date" class="form-control" name="from_date"  value="{{@$_GET['from_date']}}"> 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="to_date">To Date</label>
                                            <input type="date" class="form-control" name="to_date" value="{{@$_GET['to_date']}}">  
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group">
                                            <label for="transaction_type">Transaction Type</label>
                                            <select name="transaction_type" id="transaction_type" class="form-control">
                                                <option value="">Please select...</option>
                                                <option value="Purchased" {{(@$_GET['transaction_type'] == 'Purchased') ? 'selected' : ''}}>Purchased</option>
                                                <option value="Deposit" {{(@$_GET['transaction_type'] == 'Deposit') ? 'selected' : ''}}>Deposit</option>
                                                <option value="Withdrawal" {{(@$_GET['transaction_type'] == 'Withdrawal') ? 'selected' : ''}}>Withdrawal</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="form-group filterformbtn">
                                            <input type="submit" class="btn btn-success" value="Apply"> 
                                        </div>
                                    </div>
                               </div>
                               
                            </form>
                        </div>
                    </div>
                </div>   
                <div class="account-settings-container layout-top-spacing">
                    <div class="section general-info">
                        <div class="info">
                           
                            <div class="table-responsive">
                                <table class="table table-bordered" id="transaction_historyTBL">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Transaction ID</th>
                                            <th>Type</th>
                                            <th style="min-width: 150px;">Amount($)</th>
                                            <th style="min-width: 280px;">Date</th>
                                            <th style="min-width: 150px;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($transaction_history) > 0)
                                            @foreach($transaction_history as $key => $value)
                                                <tr>
                                                    <td class="text-center">{{$key+1}}</td>
                                                    <td>{{$value->transaction_id}}</td>
                                                    <td>{{$value->type}}</td>
                                                    <td>{{$value->amount}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($value->created_at)->format('M d-Y h:i A')}}</td>
                                                    <td><span class="badge {{$value->status == 'Pending' ? 'outline-badge-danger' : 'outline-badge-success' }}">{{$value->status == 0 ? 'Pending' : 'Completed'}}</span></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <td colspan="5" style="text-align:center;">No Record Found</td>
                                        @endif
                                    
                                    </tbody>
                                </table>
                            </div>
                           
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

<script>
      $(document).ready(function() {
            $('#transaction_historyTBL').DataTable();
        } );
</script>
