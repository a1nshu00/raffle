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
                        <div class="info">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="transaction_historyTBL">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Transaction ID</th>
                                            <th>Type</th>
                                            <th style="min-width: 150px;">Amount($)</th>
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
                                                    <td>{{$value->status}}</td>
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
