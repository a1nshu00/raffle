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
                                <h3>Orders</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="account-settings-container layout-top-spacing">
                    <div class="section general-info">
                        <div class="info filterform">
                            <form action="{{route('my-orders-adm')}}" method="get"  id="fltr_frm">
                                <input type="hidden" name="view_all" id="view_al" value="">
                               <div class="row">
                                   <div class="col-lg-4 col-md-3">
                                        <div class="form-group">
                                            <label for="from_date">From Date</label>
                                            <input type="date" class="form-control" id="from_date" name="from_date" value="{{@$_GET['from_date']}}"> 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-3">
                                        <div class="form-group">
                                            <label for="to_date">To Date</label>
                                            <input type="date" class="form-control" id="to_date" name="to_date"  placeholder="To Date" value="{{@$_GET['to_date']}}"> 
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group filterformbtn">
                                            <input type="submit" class="btn btn-success" value="Apply"> 
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3">
                                        <div class="form-group filterformbtn">
                                            <input type="button" class="btn btn-success viewall" id="view_all" name="view_all" value="View All"> 
                                        </div>
                                    </div>
                               </div>
                           </form>
                        </div>
                      </div>
                 </div>           
                <div class="account-settings-container layout-top-spacing">
                    <div class="section general-info">
                        <div class="info ">
                           
                            <div class="table-responsive">
                                <table class="table table-bordered" id="transaction_historyTBL">
                                    <thead>
                                        <tr>
                                          <th>Raffle Name</th>
                                          <th>Ball Number</th>
                                          <th style="min-width: 280px;">Order Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($orders)
                                          @foreach($orders as $key => $value)
                                            <tr>
                                              <td>{{$value->draw_title}}</td>
                                              <td>{{$value->ball_number}}</td>
                                              <td>{{ \Carbon\Carbon::parse($value->created_at)->format('M d-Y h:i A')}}</td>
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

            @include('admin.layout.footer')
        </div>
    </div>
<!--  END CONTENT AREA  -->
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#transaction_historyTBL').DataTable();
    });

    $('body').delegate('#view_all', 'click', function(){
        $('#from_date').val('');
        $('#to_date').val('');
        $('#view_al').val(1);
        $('#fltr_frm').submit();
    });
</script>
