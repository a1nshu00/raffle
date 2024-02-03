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
                                <h3>Staff Log</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="account-settings-container layout-top-spacing">
                    <div class="section general-info">
                        <div class="info filterform">
                            <form action="{{route('staff-management-log', request()->route('id'))}}" method="get">
                                @csrf 
                                <div class="row">
                                   <div class="col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label for="from_date">From Date</label>
                                            <input type="date" class="form-control" name="from_date"  value="{{@$_GET['from_date']}}"> 
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label for="to_date">To Date</label>
                                            <input type="date" class="form-control" name="to_date" value="{{@$_GET['to_date']}}">  
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group filterformbtn">
                                            <input type="submit" class="btn btn-success" value="Apply"> 
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group filterformbtn">
                                            <a class="btn btn-success resetall" href="{{route('staff-management-log', request()->route('id'))}}">Reset All</a> 
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
                                <table class="table table-bordered" id="staff_TBL">
                                   <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Activity Name</th>
                                            <th>Message</th>
                                            <th style="">Log Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($logs) > 0)
                                            @foreach($logs as $key => $value)
                                                <tr>
                                                    <td class="text-center">{{$key+1}}</td>
                                                    <td>{{$value->activity_name}}</td>
                                                    <td>{{$value->message}}</td>
                                                    <td>{{$value->log_time ? Carbon\Carbon::parse($value->log_time)->format('M d-Y h:i A') : ''}}</td>
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
        toastr.options.timeOut = 10000;
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif
     
        $(document).ready(function() {
            $('#staff_TBL').DataTable();
        });
    });
</script>