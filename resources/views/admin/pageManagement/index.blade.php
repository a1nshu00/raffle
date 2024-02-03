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
                                <h3>Page Management</h3>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-right">
                                <a class="btn btn-success" href="{{route('pages.create')}}">Create</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="account-settings-container layout-top-spacing">
                    <div class="section general-info">
                        <div class="info">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="pageID">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Page Title</th>
                                            <th style="min-width: 150px;">Status</th>
                                            <th style="min-width: 150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($pages) > 0)
                                            @foreach($pages as $key => $value)
                                                <tr>
                                                    <td class="text-center">{{$key+1}}</td>
                                                    <td>{{$value->title}}</td>
                                                    <td> <span class="badge {{$value->status == 'Active' ? 'outline-badge-primary' : 'outline-badge-danger'}}">{{$value->status}}</span></td>
                                                    <td>
                                                        <ul class="table-controls">
                                                            <li><a class="edit_btn" href="{{ route('pages.edit', $value->id) }}"  data-toggle="tooltip" data-placement="top" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a></li>
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
            $('#pageID').DataTable();
        } );
    });
</script>