@include('layouts.header')

<section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
  <div class="container">
     <div class="row">
      <div class="col-md-12">
        <h2>Claim Prize</h2>
        <ul class="breadcrumb">
        <li><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li>Claim Prize</li>
      </ul>
      </div>
     </div>
  </div>
</section>


<section class="main-sec">
    <div class="container">
    
        @if($prize->physical_prize && $prize->cash_prize != '0.00')
            <form action="{{route('save-claim-prize', $prize->id)}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-4">       
                        <div class="carddesign cardbox profileimg">
                            <h2>Choose Prize</h2>
                              <div class="checkdesign">
                                <ul class="claim-prizecheck">
                                    <li>
                                        <label class="form-check-label" for="cash_prize">
                                        <input type="radio" class="form-check-input prize_ch" name="prize_choose" value="Cash" id="cash_prize" checked>Cash Prize</label>
                                     </li>
                               <li>
                                 <label class="form-check-label" for="physical_prize">
                                        <input type="radio" class="form-check-input prize_ch" name="prize_choose" value="Physical Prize" id="physical_prize">Physical Prize</label>
                                         </li>
                                    </ul>
                                
                            </div>
                        </div>
                    </div>
    
                    <!-- Cash Prize -->
                    <div class="col-md-8" id="cashP" >
                        <div class="carddesign cardbox">
                        <h2>Cash Prize Details</h2> 
                        <div class="loginbox addfunds">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Prize Name</label>
                                        <span class="form-control">{{$prize->prize_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cash Prize</label>
                                        <span class="form-control">{{$prize->cash_prize}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="admin_fee">Fee</label>
                                        <span class="form-control">{{$prize->admin_fee}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group loginboxbtn">
                                <input type="submit" value="Submit" class="btn btn-info">
                            </div>
                        </div>
                         </div>
                    </div>
    
                    <!-- Physical Prize -->
                    <div class="col-md-8" style="display:none" id="physicalP">
                        <div class="carddesign cardbox">
                        <h2>Physical Prize Details</h2> 
                        <div class="loginbox addfunds">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Prize Name</label>
                                        <span class="form-control">{{$prize->prize_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Prize Image</label>
                                        <span class="physicalprizeimg"><img class="profile-pic" src="{{env('BASE_URL').$prize->physical_prize_image}}"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Physical Prize</label>
                                        <span class="form-control">{{$prize->physical_prize}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group loginboxbtn">
                                <input type="submit" value="Submit" class="btn btn-info">
                            </div>
                        </div>
                         </div>
                    </div>
                </div>
            </form>
        @else
            @if($prize->cash_prize != 0.00)
                <form action="{{route('save-claim-prize', $prize->id)}}" method="post">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="prize_choose" value="Cash">
                        
                        <div class="col-md-12" >
                           <div class="carddesign cardbox"> 
                            <h2>Cash Prize Details</h2> 
                            <div class="loginbox addfunds">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Prize Name</label>
                                            <span class="form-control">{{$prize->prize_name}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cash Prize</label>
                                            <span class="form-control">{{$prize->cash_prize}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="admin_fee">Fee</label>
                                            <span class="form-control">{{$prize->admin_fee}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group loginboxbtn">
                                    <input type="submit" value="Submit" class="btn btn-info">
                                </div>
                            </div>
                        </div>
                        </div>
                        
                    </div>
                </form>
            @endif
            @if($prize->physical_prize)
                <form action="{{route('save-claim-prize', $prize->id)}}" method="post">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="prize_choose" value="Physical Prize">
                        <div class="col-md-12" >
                            <div class="carddesign cardbox">
                            <h2>Physical Prize Details</h2> 
                            <div class="loginbox addfunds">
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Prize Name</label>
                                            <span class="form-control">{{$prize->prize_name}}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Prize Image</label>
                                            <span class="physicalprizeimg"><img class="profile-pic" src="{{env('BASE_URL').$prize->physical_prize_image}}"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Physical Prize</label>
                                            <span class="form-control">{{$prize->physical_prize}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group loginboxbtn">
                                    <input type="submit" value="Submit" class="btn btn-info">
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </form>
            @endif
        @endif


    </div>
</section>
@include('layouts.footer')
<script>
    $(document).ready(function(){
        
        toastr.options.timeOut = 10000;
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif
        

    });

    $('body').delegate('.prize_ch', 'change', function(){
        if($('input[type="radio"][name="prize_choose"]:checked').val() == 'Physical Prize'){
            $('#cashP').hide();
            $('#physicalP').show();
        }else{
            $('#cashP').show();
            $('#physicalP').hide();
        }
    });


</script>