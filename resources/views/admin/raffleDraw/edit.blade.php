@include('admin.layout.header')
<link rel="stylesheet" type="text/css" href="{{asset('public/admin/plugins/dropify/dropify.min.css')}}">
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
                        <h3>Edit Raffle Draw</h3>
                    </div>
                </div>
                <div class="account-settings-container layout-top-spacing">
                    <div class="account-content">
                        <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                              
                            <!-- General info  -->
                            <form id="raffle_form" class="" method="POST" action="{{route('raffle-draw.update', $raffle_draw->id)}}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                        <div class="section general-info" id="general-info">
                                            
                                            <div class="info">
                                                <h6 class="">General Information</h6>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label for="type">Draw Title</label>
                                                                        <input type="text" name="draw_title" placeholder="Draw Title" value="{{$raffle_draw->draw_title}}" id="draw_title" class="form-control">
                                                                        @error('draw_title')
                                                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div> 
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="type">Draw Type</label>
                                                                        <select name="type" id="type" class="form-control">
                                                                            <option value="Raffle" {{ $raffle_draw->type == 'Raffle' ? 'checked' : '' }} >Raffle</option>
                                                                            <option value="Ending" {{ $raffle_draw->type == 'Ending' ? 'checked' : '' }} >Ending</option>
                                                                        </select>
                                                                        @error('type')
                                                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="total_balls">Total Balls</label>
                                                                        <input type="text" class="form-control "  id="total_balls" placeholder="Total Balls" value="{{ $raffle_draw->total_balls }}" name="total_balls">
                                                                        @error('total_balls')
                                                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="buying_amount">Buying Amount($)</label>
                                                                        <input type="text" value="{{ $raffle_draw->buying_amount }}" class="form-control "  id="buying_amount" placeholder="Buying Amount" name="buying_amount" >
                                                                        @error('buying_amount')
                                                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="draw_time">Draw Time</label>
                                                                        <input type="datetime-local"  min="<?php new DateTime(); ?>" value="{{ $raffle_draw->draw_time }}" class="form-control "  id="draw_time" placeholder="Draw Time" name="draw_time" >
                                                                        @error('draw_time')
                                                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label for="streaming_link">Streaming Link</label>
                                                                        <input type="text" class="form-control"  id="streaming_link" placeholder="Streaming Link" name="streaming_link" value="{{ $raffle_draw->streaming_link }}" >
                                                                        @error('streaming_link')
                                                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="prize_name" id="frm_1_p_name">
                                    <input type="hidden" name="physical_prize_image" id="frm_1_p_image">
                                    <input type="hidden" name="cash_prize" id="frm_1_p_c_prize">
                                    <input type="hidden" name="physical_prize" id="frm_1_p_prize">
                                    <input type="hidden" name="admin_fee" id="frm_1_p_fee">
                                </div>
                            </form>

                            <!-- Prize Information  -->
                            <form id="prize_form" method="POST" action="{{route('prize-store-image')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                        <div class="section work-experience" id="work-experience">
                                            <div class="info">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h5 class="">Prize Information</h5>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group" id="err_add_prize_err" style="display:none;">
                                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                                <strong id="add_prize_err">Please add atleast one prize!</strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="prize_name">Prize Name</label>
                                                            <input type="text" placeholder="Prize Name" class="form-control " id="prize_name">
                                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                                <strong id="prize_err"></strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group" id="physical_prize_image_dv">
                                                            <label for="physical_prize_image">Physical Prize Image</label>
                                                            <input type="file"  class="form-control "  id="physical_prize_image" placeholder="Physical Prize Image" >
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group" id="physical_prize_dv">
                                                            <label for="physical_prize">Physical Prize</label>
                                                            <input type="text" id="physical_prize__" class="form-control "  placeholder="Physical Prize" name="physical_prize" >
                                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                                <strong id="physical_err"></strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group" id="cash_prize_dv">
                                                            <label for="cash_prize">Cash Prize($)</label>
                                                            <input type="text" placeholder="Cash Prize" class="form-control " id="cash_prize">
                                                            <span class="invalid-feedback" role="alert" style="display:block;">
                                                                <strong id="cash_err"></strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group" id="fee_dv">
                                                            <label for="fee">Fee(%)</label>
                                                            <input type="text" id="fee" class="form-control "  placeholder="Fee" name="fee" >
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-6 mobile-left">
                                                        <button type="button" id="add_prize" data-index="" class="btn btn-primary">Add Prizes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </form>

                            <div class="row">
                                <!-- Prize List -->
                                <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                    <div class="section work-experience" id="work-experience">
                                        <div class="info">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5 class="">Prize List</h5>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="raffle_drawTBL">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Prize Name</th>
                                                            <th style="min-width: 150px;">Physical Prize</th>
                                                            <th style="min-width: 150px;">Cash Prize($)</th>
                                                            <th style="min-width: 150px;">Fee(%)</th>
                                                            <th style="min-width: 130px; width: 120px;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="prize_tbl_body">

                                                    
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
                            <!-- <button id="multiple-reset" type="button" class="btn btn-warning">Reset All</button> -->
                            <button id="multiple-messages" type="button"  class="btn btn-primary submit_btn">Save Changes</button>
                            <!-- <div class="blockui-growl-message" style="cursor: default;">
                                <i class="flaticon-double-check"></i>&nbsp; Settings Saved Successfully
                            </div> -->
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
    sessionStorage.removeItem('prize_name');
    sessionStorage.removeItem('prize_image_path');
    sessionStorage.removeItem('cash_prize');
    sessionStorage.removeItem('physical_prize');
    sessionStorage.removeItem('fee');


    // Get Session Items...
    var prize_name = JSON.parse(sessionStorage.getItem("prize_name"));
    var prize_image_path = JSON.parse(sessionStorage.getItem("prize_image_path"));
    var physical_prize = JSON.parse(sessionStorage.getItem("physical_prize"));
    var cash_prize = JSON.parse(sessionStorage.getItem("cash_prize"));
    var fee = JSON.parse(sessionStorage.getItem("fee"));

    if(!prize_name){
        var prize_name = [];
    }
    if(!prize_image_path){
        var prize_image_path = [];
    }
    if(!physical_prize){
        var physical_prize = [];
    }
    if(!cash_prize){
        var cash_prize = [];
    }
    if(!fee){
        var fee = [];
    }
    $(document).ready(function(e) {
        
        let dateInput = document.getElementById("draw_time");
        dateInput.min = new Date().toISOString().slice(0,new Date().toISOString().lastIndexOf(":"));
        
        toastr.options.timeOut = 10000;
        @if (Session::has('error'))
        toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
        toastr.success('{{ Session::get('success') }}');
        @endif
        
        var  raffle_prizes = <?php echo json_encode($raffle_prizes); ?>;
        if(raffle_prizes.length > 0 ){
            for (let i = 0; i < raffle_prizes.length; i++) {

                prize_image_path.push(raffle_prizes[i].physical_prize_image);
                prize_name.push(raffle_prizes[i].prize_name);
                physical_prize.push(raffle_prizes[i].physical_prize);
                cash_prize.push(raffle_prizes[i].cash_prize);
                fee.push(raffle_prizes[i].admin_fee);

                sessionStorage.setItem("prize_name", JSON.stringify(prize_name));
                sessionStorage.setItem("prize_image_path", JSON.stringify(prize_image_path));
                sessionStorage.setItem("physical_prize", JSON.stringify(physical_prize));
                sessionStorage.setItem("cash_prize", JSON.stringify(cash_prize));
                sessionStorage.setItem("fee", JSON.stringify(fee));


            }
        }
        PrizeTableAppend();
    });

    //Add Prizess 
    $('body').delegate('#add_prize', 'click', function(){

        var index = $(this).attr('data-index');
        
        // Error handling....
        if($('#prize_name').val() == ''){
            $('#prize_err').html('Prize name is required!');
            return false;
        }else{
            $('#prize_err').html('');
        }
        
        // if($('#physical_prize__').val() == ''){
        //     $('#physical_err').html('Physical prize is required!');
        //     return false;
        // }else{
        //     $('#physical_err').html('');
        // }
        // if($('#cash_prize').val() == ''){
        //     $('#cash_err').html('Cash amount is required!');
        //     return false;
        // }else{
        //     $('#cash_err').html('');
        // }
        

        if( $('#physical_prize_image')[0].files[0]){
            var fd = new FormData();
            fd.append('image', $('#physical_prize_image')[0].files[0]);
            $.ajax({
                url: '{{route("prize-store-image")}}',
                type: 'POST',
                contentType: 'multipart/form-data',
                data: fd,
                processData: false, 
                contentType: false,
                async: true,
                success: function(response){
                    $('#prize_tbl_body').html('');
                    if(response.status == 200){
                        if(index == ''){
                            prize_image_path.push(response.imagePath);
                            prize_name.push($('#prize_name').val());
                            physical_prize.push($('#physical_prize__').val());
                            cash_prize.push($('#cash_prize').val());
                            fee.push($('#fee').val());

                            sessionStorage.setItem("prize_name", JSON.stringify(prize_name));
                            sessionStorage.setItem("prize_image_path", JSON.stringify(prize_image_path));
                            sessionStorage.setItem("physical_prize", JSON.stringify(physical_prize));
                            sessionStorage.setItem("cash_prize", JSON.stringify(cash_prize));
                            sessionStorage.setItem("fee", JSON.stringify(fee));

                            $('#prize_name').val('');
                            $('#physical_prize_image').val('');
                            $('#physical_prize__').val('');
                            $('#cash_prize').val('');
                            $('#fee').val('');
                            PrizeTableAppend();
                        }else{

                             console.log(index);
                            prize_image_path[index] = response.imagePath;
                            prize_name[index] = $('#prize_name').val();
                            physical_prize[index] = $('#physical_prize__').val();
                            cash_prize[index] = $('#cash_prize').val();
                            fee[index] = $('#fee').val();

                            sessionStorage.setItem("prize_name", JSON.stringify(prize_name));
                            sessionStorage.setItem("prize_image_path", JSON.stringify(prize_image_path));
                            sessionStorage.setItem("physical_prize", JSON.stringify(physical_prize));
                            sessionStorage.setItem("cash_prize", JSON.stringify(cash_prize));
                            sessionStorage.setItem("fee", JSON.stringify(fee));

                            $('#prize_name').val('');
                            $('#physical_prize_image').val('');
                            $('#physical_prize__').val('');
                            $('#cash_prize').val('');
                            $('#fee').val('');
                            $('#add_prize').attr('data-index', '');
                            $('#add_prize').html('Add Prize');
                            PrizeTableAppend();
                        }
                        
                    }
                }
            });
        }else{
            $('#prize_tbl_body').html('');
            if(index == ''){
                prize_image_path.push('');
                prize_name.push($('#prize_name').val());
                physical_prize.push($('#physical_prize__').val());
                cash_prize.push($('#cash_prize').val());
                fee.push($('#fee').val());
        
                sessionStorage.setItem("prize_name", JSON.stringify(prize_name));
                sessionStorage.setItem("prize_image_path", JSON.stringify(prize_image_path));
                sessionStorage.setItem("physical_prize", JSON.stringify(physical_prize));
                sessionStorage.setItem("cash_prize", JSON.stringify(cash_prize));
                sessionStorage.setItem("fee", JSON.stringify(fee));

                $('#prize_name').val('');
                $('#physical_prize_image').val('');
                $('#physical_prize__').val('');
                $('#cash_prize').val('');
                $('#fee').val('');
                PrizeTableAppend();
            }else{
                prize_image_path[index] = '';
                prize_name[index] = $('#prize_name').val();
                physical_prize[index] = $('#physical_prize__').val();
                cash_prize[index] = $('#cash_prize').val();
                fee[index] = $('#fee').val();
        
                sessionStorage.setItem("prize_name", JSON.stringify(prize_name));
                sessionStorage.setItem("prize_image_path", JSON.stringify(prize_image_path));
                sessionStorage.setItem("physical_prize", JSON.stringify(physical_prize));
                sessionStorage.setItem("cash_prize", JSON.stringify(cash_prize));
                sessionStorage.setItem("fee", JSON.stringify(fee));

                $('#prize_name').val('');
                $('#physical_prize_image').val('');
                $('#physical_prize__').val('');
                $('#cash_prize').val('');
                $('#fee').val('');

                $('#add_prize').html('Add Prize');
                $('#add_prize').attr('data-index', '');
                PrizeTableAppend();
            }
            
        } 
       
    });
    // Delete prize table 
    $('body').delegate('.dlt_btn', 'click', function(){
        $('#prize_tbl_body').html('');
        var indexToRemove = $(this).data("index");
        prize_name.splice(indexToRemove, 1); 
        prize_image_path.splice(indexToRemove, 1); 
        physical_prize.splice(indexToRemove, 1); 
        cash_prize.splice(indexToRemove, 1); 
        fee.splice(indexToRemove, 1);

        sessionStorage.setItem("prize_name", JSON.stringify(prize_name));
        sessionStorage.setItem("prize_image_path", JSON.stringify(prize_image_path));
        sessionStorage.setItem("physical_prize", JSON.stringify(physical_prize));
        sessionStorage.setItem("cash_prize", JSON.stringify(cash_prize));
        sessionStorage.setItem("fee", JSON.stringify(fee));
        PrizeTableAppend();
        // $('#tbody').find('tr').each(function(index, elem){
        //     $(this).find('.index').html(index+1);
        // })
    }); 

    // Edit data show
    $('body').delegate('.edit_p', 'click', function(){
        // $('html, body').animate({
        //     scrollTop: 300
        // }, 500);
        var index = $(this).attr('data-index');
        var p_name = JSON.parse(sessionStorage.getItem('prize_name'))[index];
        var p_image_path = JSON.parse(sessionStorage.getItem("prize_image_path"))[index];
        var ph_prize = JSON.parse(sessionStorage.getItem("physical_prize"))[index];
        var c_prize = JSON.parse(sessionStorage.getItem("cash_prize"))[index];
        var p_fee = JSON.parse(sessionStorage.getItem("fee"))[index];

        $('#prize_name').val(p_name);
        $('#physical_prize__').val(ph_prize);
        $('#cash_prize').val(c_prize);
        $('#fee').val(p_fee);
        $('#add_prize').attr('data-index', index);
        $('#add_prize').html('Update Prize');

    });

    // General form submit
    $('body').delegate('#multiple-messages', 'click', function(e){
        
        // Data session set to form 1 input fields  
        $('#frm_1_p_name').val(JSON.parse(sessionStorage.getItem('prize_name')));
        $('#frm_1_p_image').val(JSON.parse(sessionStorage.getItem('prize_image_path')));
        $('#frm_1_p_c_prize').val(JSON.parse(sessionStorage.getItem('cash_prize')));
        $('#frm_1_p_prize').val(JSON.parse(sessionStorage.getItem('physical_prize')));
        $('#frm_1_p_fee').val(JSON.parse(sessionStorage.getItem('fee')));


        // Error handling
        if($('#total_balls').val() != '' && !isNaN($('#total_balls').val()) && $('#buying_amount').val() != '' && !isNaN($('#buying_amount').val() ) && $('#draw_time').val() != '' ){
            if($('#raffle_drawTBL >tbody >tr').length > 0 && $('#raffle_drawTBL >tbody >tr').attr('class') != 'no-record'){
                // Remove session key
                sessionStorage.removeItem('prize_name');
                sessionStorage.removeItem('prize_image_path');
                sessionStorage.removeItem('cash_prize');
                sessionStorage.removeItem('physical_prize');
                sessionStorage.removeItem('fee');
                 $('#err_add_prize_err').hide();
                $('#raffle_form').submit();
            }else{
                $('#err_add_prize_err').show();
                e.preventDefault();
            }
            
        }
        
        if($('#raffle_drawTBL >tbody >tr').length > 0 && $('#raffle_drawTBL >tbody >tr').attr('class') != 'no-record'  ){
             $('#err_add_prize_err').hide();
            $('#raffle_form').submit();
        }else{
             $('#err_add_prize_err').show();
            e.preventDefault();
        }

    });

    // create table > tbody using loop 
    function PrizeTableAppend(){
        if(prize_name && prize_name.length > 0 ){
            for (var i = 0; i < prize_name.length; i++) {      
                var row =   `<tr>
                                <td>${i+1}</td>
                                <td>${prize_name[i] ? prize_name[i] : '-'}</td>
                                <td>
                                ${prize_image_path[i] 
                                ?
                                    `<div class="d-flex">
                                        <div class="usr-img-frame mr-2 rounded-circle">
                                            <img alt="Profile" class="img-fluid rounded-circle" src="${window.location.origin+'/'+prize_image_path[i]}">
                                        </div>
                                        <p class="align-self-center mb-0">${physical_prize[i] }</p>
                                    </div>`
                                :
                                    `${physical_prize[i] ? physical_prize[i] : '-'}`
                                }
                                </td>
                                <td>${cash_prize[i] != 0.00 ? cash_prize[i] : '-' }</td>
                                <td>${fee[i] != 0.00 ? fee[i] : '-'}</td>
                                <td>
                                    <ul class="table-controls">
                                        <li><button class="edit_btn edit_btn_draw edit_p" id="edit_p" data-index=${i}  data-toggle="tooltip" data-placement="top" title="Edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></button></li>
                                        <li>
                                            <button type="button"  class="dlt_btn" data-index="${i}" data-toggle="tooltip" data-placement="top" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>
                                        </li>
                                    </ul>
                                </td>
                            </tr>`;
                $('#prize_tbl_body').append(row);
            }
        }else{
            $('#prize_tbl_body').append(`<tr class="no-record"><td colspan="7" style="text-align:center;">No prize added</td></tr>`);
        }
    }

</script>