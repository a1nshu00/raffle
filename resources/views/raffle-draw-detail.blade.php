@include('layouts.header')

  <section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>Raffle Draws Detail</h2>
          <ul class="breadcrumb">
          <li><a href="{{route('dashboard')}}">Dashboard</a></li>
          <li><a href="{{route('raffle-draws')}}">Raffle Draws</a></li>
          <li>Raffle Draws Detail</li>
        </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="main-sec">
    <div class="container">
      <form method="post" action="{{route('choose-balls')}}" id="detail_frm">
        <div class="row">
          <div class="col-md-4">
            <div class="carddesign cardbox">
              <h2>Title<span>{{$raffle_draw['draw_title']}}</span></h2>
              <h2>Type<span>{{$raffle_draw['type']}}</span></h2>
              <h2>Total Balls<span>{{$raffle_draw['total_balls']}}</span></h2>
            </div>
            <div class="carddesign cardbox cardbox2">
              <h2>Buying Amount</h2>
              <h4>{{$raffle_draw['buying_amount'] ? '$'.$raffle_draw['buying_amount'] : ''}}</h4>
            </div>
            <div class="carddesign cardbox cardbox2">
              <h2>Streaming Link</h2>
              <h4><a href="{{$raffle_draw['streaming_link']}}">Click Here to stream</a></h4>
            </div>
          </div>
          <div class="col-md-8">
            <div class="carddesign cardbox">
              <h2>Draw End<span>{{ $raffle_draw['draw_time'] ? \Carbon\Carbon::parse($raffle_draw['draw_time'])->format('M d-Y h:i A') : ''}}</span></h2>
            </div>
            
            <div class="carddesign cardbox">
              <h2>Balls</h2>
              <ul class="drawcheckbox">
                <input type="hidden" name="buying_amount" value="{{$raffle_draw['buying_amount']}}">
                <input type="hidden" name="raffle_id" value="{{$raffle_draw['id']}}">
                @for($i = 1; $i <= $raffle_draw['total_balls']; $i++)
                  @if(in_array($i, $disbaled_balls))
                    <li>
                      <label class="form-check-label">
                        <input class="form-check-input balls-check" style="background:#ccc" disabled value="{{$i}}" type="checkbox" name="check_ball[]">{{$i}}
                      </label>
                    </li>
                  @else
                    <li>
                      <label class="form-check-label">
                        <input class="form-check-input balls-check" value="{{$i}}" type="checkbox" name="check_ball[]">{{$i}}
                      </label>
                    </li>
                  @endif
                @endfor
              </ul>
              <div class="continuebtn">
                <button type="submit" class="btn btn-info" id="continue_btn" {{(\Carbon\Carbon::now() >= \Carbon\Carbon::parse($raffle_draw['draw_time'])) ? 'disabled': '' }} >{{(\Carbon\Carbon::now() >= \Carbon\Carbon::parse($raffle_draw['draw_time'])) ? 'Raffle Expired': 'Continue'}}</button>
                <span class="invalid-feedback" role="alert" id="cont_error" style="display:none">
                  <strong id="continue_err">Please choose atleast one ball.</strong>
                </span>
              </div>
            
              <h2>Prizes</h2>
              <div class="table-responsive tabledesign">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Prize Image</th>
                      <th>Prize Name</th>
                      <th>Physical Prize</th>
                      <th>Cash Prize</th>
                      <th>Admin Fee</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(@$raffle_draw['prizes'])
                      @foreach($raffle_draw['prizes'] as $key => $value)
                          <tr>
                              <td><img height="30px" class="img-fluid prizeimage" src="{{$value['physical_prize_image'] ? env('BASE_URL').$value['physical_prize_image'] : ''}}" ></td>
                              <td>{{$value['prize_name']}}</td>
                              <td>{{$value['physical_prize']}}</td>
                              <td>{{$value['cash_prize']}}</td>
                              <td><span class="fee">{{$value['admin_fee']}}</span></td>
                          </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>

@include('layouts.footer')

<script>
  $(document).ready(function(){
   
  });
  $('body').delegate('#continue_btn', 'click', function(){
    console.log($('input[name="check_ball[]"]:checked').length);
    if($('input[name="check_ball[]"]:checked').length > 0){
      $('#cont_error').hide();
      $('#detail_frm').submit();
    }else{
      $('#cont_error').show();
      return false
    }
  });
</script>