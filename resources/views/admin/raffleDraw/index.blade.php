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
                        <div class="col-md-6">
                            <div class="page-title">
                                <h3>Raffle Draw Management</h3>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-right">
                                <a class="btn btn-success" id="crt-btn" href="{{route('raffle-draw.create')}}">Create</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="account-settings-container layout-top-spacing">
                    <div class="general-info">
                       <div class="info filterform">
                           
                            <form action="{{route('raffle-draw.index')}}" method="get" id="fltr_frm">
                                <input type="hidden" name="view_all" id="view_al">
                                <div class="row">
                                   <div class="col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label for="from_date">From Date</label>
                                            <input type="datetime-local" class="form-control" id="from_date" name="from_date"  value="{{@$_GET['from_date']}}"> 
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label for="to_date">To Date</label>
                                            <input type="datetime-local" class="form-control" id="to_date" name="to_date" value="{{@$_GET['to_date']}}">  
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
                                            <a href="{{route('raffle-draw.index')}}" class="btn btn-success resetall">Reset All</a> 
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
                                <table class="table table-bordered" id="raffle_drawTBL">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Draw Type</th>
                                            <th>Total Ball</th>
                                            <th style="min-width: 150px;">Buying Amount($)</th>
                                            <th style="min-width: 150px;">Draw Time</th>
                                            <th style="min-width: 150px; width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($raffle_draw) > 0)
                                            @foreach($raffle_draw as $key => $value)
                                                <tr>
                                                    <td class="text-center">{{$key+1}}</td>
                                                    <td>{{$value->type}}</td>
                                                    <td>{{$value->total_balls}}</td>
                                                    <td>{{$value->buying_amount}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($value->draw_time)->format('M d-Y h:i A')}}</td>
                                                    <td>
                                                        <ul class="table-controls">
                                                            <li>
                                                                <a class="results" href="{{ route('raffle-draw-details', $value->id) }}"  data-toggle="tooltip" data-placement="top" title="View Bets">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                                </a>
                                                            </li>
                                                            <li><a class="edit_btn" href="{{ route('raffle-draw.edit', $value->id) }}"  data-toggle="tooltip" data-placement="top" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a></li>
                                                            <li>
                                                                <form method="post" action="{{route('raffle-draw.destroy',$value->id)}}" id="deleteForm_{{$value->id}}">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="submit"  class="dlt_btn" data-id="{{$value->id}}" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <a class="result_manage" href="{{ route('raffle-draw.result_manage', $value->id) }}"  data-toggle="tooltip" data-placement="top" title="Result Management">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="results" href="{{ route('raffle-draw.results', $value->id) }}"  data-toggle="tooltip" data-placement="top" title="Results">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                                                                </a>
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
    $('body').delegate('#crt-btn', 'click', function(){
        // At first remove session key
        sessionStorage.removeItem('prize_name');
        sessionStorage.removeItem('prize_image_path');
        sessionStorage.removeItem('cash_prize');
        sessionStorage.removeItem('physical_prize');
        sessionStorage.removeItem('fee');
        sessionStorage.removeItem('prize_type');
    });

    $('body').delegate('#view_all', 'click', function(){
        $('#from_date').val('');
        $('#to_date').val('');
        $('#view_al').val(1);
        $('#fltr_frm').submit();
    });
</script>