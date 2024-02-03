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
                                <h3>Raffle Bets</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="account-settings-container layout-top-spacing">
                    <div class="section general-info">
                        <div class="info">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="raffle_drawTBL">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>User name</th>
                                            <th>User email</th>
                                            <th style="min-width: 150px;">Ball number</th>
                                            <th style="min-width: 150px;">Order date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($raffle_draw) > 0)
                                            @foreach($raffle_draw as $key => $value)
                                                <tr>
                                                    <td class="text-center">{{$key+1}}</td>
                                                    <td>{{$value->first_name}}</td>
                                                    <td>{{$value->email}}</td>
                                                    <td>{{$value->ball_number}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($value->created_at)->format('M d-Y h:i A')}}</td>
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
        toastr.options.timeOut = 10000;
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif
     
        $(document).ready(function() {
            $('#raffle_drawTBL').DataTable();
        } );


        $('.dlt_btn').click(function(e){
            var id = $(this).data('id');
            if(confirm('Are you sure?')){
                $('#deleteForm_'+id).submit();
            }else{
                e.preventDefault();
            }
        });

        
    });
</script>