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
                                <h3>Deposit Channel</h3>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-right">
                                <a class="btn btn-success" href="{{route('deposit-channel.create')}}">Create</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="account-settings-container layout-top-spacing">
                    <div class="section general-info">
                        <div class="info">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="DepositChannelTBL">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Name</th>
                                            <th>Channel Type</th>
                                            <th style="min-width: 150px;">Fee</th>
                                            <th style="min-width: 130px; width: 120px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($DepositChannel) > 0)
                                            @foreach($DepositChannel as $key => $value)
                                                <tr>
                                                    <td class="text-center">{{$key+1}}</td>
                                                    <td>{{$value->name}}</td>
                                                    <td>{{$value->channel_type}}</td>
                                                    <td>{{$value->fee}}</td>
                                                    <td>
                                                        <ul class="table-controls">
                                                            <li><a class="edit_btn" href="{{ route('deposit-channel.edit', $value->id) }}"  data-toggle="tooltip" data-placement="top" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a></li>
                                                             <li>
                                                                <form method="post" action="{{route('deposit-channel.destroy',$value->id)}}" id="deleteForm_{{$value->id}}">
                                                                    @method('delete')
                                                                    @csrf
                                                                    <button type="submit"  class="dlt_btn" data-id="{{$value->id}}" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </td>
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
            $('#DepositChannelTBL').DataTable();
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