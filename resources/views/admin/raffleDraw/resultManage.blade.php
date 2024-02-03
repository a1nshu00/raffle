@include('admin.layout.header')
<link rel="stylesheet" type="text/css" href="{{asset('admin/plugins/dropify/dropify.min.css')}}">
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
                <div class="page-header">
                    <div class="page-title">
                        <h3>Manage Result</h3>
                    </div>
                </div>
                <div class="account-settings-container layout-top-spacing">
                    <div class="account-content">
                        <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">

                            <!-- Prize Information  -->
                            <form id="result_form" method="POST" action="{{route('store-result', $id)}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="raffle_id" id="raffle_id" value="{{$id}}">
                                <input type="hidden" name="result_id"  id="result_id">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                        <div class="section work-experience" id="work-experience">
                                            <div class="info">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5 class="">Manage Result</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group" id="err_add_result_err" style="display:none;">
                                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                                <strong id="add_prize_err">Please add atleast one result!</strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="winning_ball">Winning Ball</label>
                                                            <input type="number" placeholder="Winning Ball" class="form-control" id="winning_ball">
                                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                                <strong id="winning_ball_err"></strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="prize_name">Prizes</label>
                                                            <select name="prize_id" id="prize_id" class="form-control">
                                                                <option value="">Please select...</option>
                                                                @if($raffle_prizes)
                                                                    @foreach($raffle_prizes as $key => $value)
                                                                        <option value="{{$value->id}}">{{$value->prize_name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                                <strong id="prize_err"></strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mobile-left">
                                                        <button type="button" id="add_result" data-index="" class="btn btn-primary">Add Result</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <input type="hidden" name="prize_id" id="prize_id_inp">
                                <input type="hidden" name="winning_ball" id="winning_ball_inp">
                            </form>

                            <!-- Result List -->
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <div class="section work-experience" id="work-experience">
                                        <div class="info">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5 class="">Result List</h5>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="raffle_drawTBL">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Winning Ball</th>
                                                            <th style="min-width: 150px;">Prize</th>
                                                            <th style="min-width: 130px; width: 120px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="result_tbl_body">

                                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="account-settings-footer">
                        <div class="as-footer-container">
                            <button id="multiple-messages" type="button"  class="btn btn-primary submit_btn">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.layout.layout_scripts')
        </div>
    </div>
    
<!--  END CONTENT AREA  -->
<script>

    // At first remove session key
    sessionStorage.removeItem('winning_ball');
    sessionStorage.removeItem('prize_name');
    sessionStorage.removeItem('prize_id');
    sessionStorage.removeItem('result_id');

    // Get Session Items...
    var winning_ball = JSON.parse(sessionStorage.getItem("winning_ball"));
    var prize_name = JSON.parse(sessionStorage.getItem("prize_name"));
    var prize_id = JSON.parse(sessionStorage.getItem("prize_id"));
    var result_id = JSON.parse(sessionStorage.getItem("result_id"));

    if(!winning_ball){
        var winning_ball = [];
    }
    if(!prize_name){
        var prize_name = [];
    }
    if(!prize_id){
        var prize_id = [];
    }
    if(!result_id){
        var result_id = [];
    }
    $(document).ready(function(e) {
        
        toastr.options.timeOut = 10000;
        @if (Session::has('error'))
        toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
        toastr.success('{{ Session::get('success') }}');
        @endif
        
        var  raffle_result = <?php echo json_encode($raffle_result); ?>;
        if(raffle_result.length > 0 ){
            for (let i = 0; i < raffle_result.length; i++) {

                winning_ball.push(raffle_result[i].winning_ball);
                prize_name.push(raffle_result[i].prize_name);
                prize_id.push(raffle_result[i].prize_id);
                result_id.push(raffle_result[i].id);

                sessionStorage.setItem("prize_name", JSON.stringify(prize_name));
                sessionStorage.setItem("winning_ball", JSON.stringify(winning_ball));
                sessionStorage.setItem("prize_id", JSON.stringify(prize_id));
                sessionStorage.setItem("result_id", JSON.stringify(result_id));
            }
        }
        PrizeTableAppend();
    });

    //Add results 
    $('body').delegate('#add_result', 'click', function(){

        
        var index = $(this).attr('data-index');
        let prize_html = $('#prize_id option:selected').html();
        let priz_id = $('#prize_id option:selected').val();
        let w_ball = $('#winning_ball').val();
        // Error handling....
        if(w_ball == ''){
            $('#winning_ball_err').html('Winning ball is required!');
            return false;
        }else{
            $('#winning_ball_err').html('');
        } 

        if(priz_id == ''){
            $('#prize_err').html('Prize name is required!');
            return false;
        }else{
            $('#prize_err').html('');
        }
       
        if(index == ''){
            // let raffle_id = $('#raffle_id').val();
            // let fd = new FormData();
            // fd.append('ball_number', w_ball);
            // fd.append('raffle_id', raffle_id);
            // $.ajax({
            //     url: "{{route('check-valid-ball')}}",
            //     type: 'POST',
            //     data: fd,
            //     processData: false,
            //     contentType: false,
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            //     success:function(response){
            //         if(response.status == 200){
                        prize_name.push(prize_html);
                        prize_id.push(priz_id);
                        winning_ball.push(w_ball);
                
                        sessionStorage.setItem("prize_name", JSON.stringify(prize_name));
                        sessionStorage.setItem("prize_id", JSON.stringify(prize_id));
                        sessionStorage.setItem("winning_ball", JSON.stringify(winning_ball));
                        PrizeTableAppend();
            //         }else{
            //             toastr.error('This ball has not been bought yet.');
            //         }
            //     }

            // });
        }else{

            // let raffle_id = $('#raffle_id').val();
            // let fd = new FormData();
            // fd.append('ball_number', $('#winning_ball').val());
            // fd.append('raffle_id', raffle_id);
            // $.ajax({
            //     url: "{{route('check-valid-ball')}}",
            //     type: 'POST',
            //     data: fd,
            //     processData: false,
            //     contentType: false,
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     },
            //     success:function(response){
            //         if(response.status == 200){
                        prize_name[index] = prize_html;
                        prize_id[index] = priz_id;
                        winning_ball[index] = w_ball;

                        sessionStorage.setItem("prize_name", JSON.stringify(prize_name));
                        sessionStorage.setItem("prize_id", JSON.stringify(prize_id));
                        sessionStorage.setItem("winning_ball", JSON.stringify(winning_ball));
                        PrizeTableAppend();
            //         }else{
            //             toastr.error('This ball has not been bought yet.');
            //         }
            //     }

            // });
          
        }


        $('#prize_id').val('');
        $('#winning_ball').val('');
    
    });
    // Delete result table 
    $('body').delegate('.dlt_btn', 'click', function(){
        var indexToRemove = $(this).data("index");
        prize_name.splice(indexToRemove, 1); 
        prize_id.splice(indexToRemove, 1); 
        winning_ball.splice(indexToRemove, 1); 
        result_id.splice(indexToRemove, 1); 

        sessionStorage.setItem("prize_name", JSON.stringify(prize_name));
        sessionStorage.setItem("prize_id", JSON.stringify(prize_id));
        sessionStorage.setItem("winning_ball", JSON.stringify(winning_ball));
        sessionStorage.setItem("result_id", JSON.stringify(result_id));
        PrizeTableAppend();
    }); 

    // Edit data show
    $('body').delegate('#edit_r', 'click', function(){
      
        var index = $(this).data('index');
        var prize_id = JSON.parse(sessionStorage.getItem('prize_id'))[index];
        var winning_ball = JSON.parse(sessionStorage.getItem("winning_ball"))[index];

        $('#prize_id').val(prize_id).attr('selected', 'selected');
        $('#winning_ball').val(winning_ball);
        
        $('#add_result').attr('data-index', index);
        $('#add_result').html('Update Result');

    });

    // General form submit
    $('body').delegate('#multiple-messages', 'click', function(e){
       
        // Data session set to form 1 input fields  
        $('#prize_id_inp').val(JSON.parse(sessionStorage.getItem('prize_id')));
        $('#winning_ball_inp').val(JSON.parse(sessionStorage.getItem('winning_ball')));
        $('#result_id').val(JSON.parse(sessionStorage.getItem('result_id')));
        
        // Error handling
        if($('#raffle_drawTBL >tbody >tr').length > 0 && $('#raffle_drawTBL >tbody >tr').attr('class') != 'no-record'){
            $('#result_form').submit();
            $('#err_add_result_err').hide();
        }else{
            $('#err_add_result_err').show();
            e.preventDefault();
        }


    });

    // create table > tbody using loop 
    function PrizeTableAppend(){
        $('#result_tbl_body').html('');
        if(prize_name && winning_ball.length > 0 ){
            for (var i = 0; i < prize_name.length; i++) {      
                var row =   `<tr>
                                <td>${i+1}</td>
                                <td>${winning_ball[i] ? winning_ball[i] : '-'}</td>
                                <td>${prize_name[i] ? prize_name[i] : '-' }</td>
                                <td>
                                    <ul class="table-controls">
                                        <li><button class="edit_btn edit_btn_draw" id="edit_r" data-index=${i}  data-toggle="tooltip" data-placement="top" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></button></li>
                                        <li>
                                            <button type="button"  class="dlt_btn" data-index="${i}" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>`;
                $('#raffle_drawTBL').append(row);
            }
        }else{
            $('#raffle_drawTBL').append(`<tr class="no-record"><td colspan="7" style="text-align:center;">No prize added</td></tr>`);
        }
    }

</script>