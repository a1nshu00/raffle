@include('layouts.header')
  <section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>My Results</h2>
          <ul class="breadcrumb">
          <li><a href="{{route('dashboard')}}">Dashboard</a></li>
          <li>My Results</li>
        </ul>
        </div>
      </div>
    </div>
  </section>

  
  <section class="main-sec">
    <div class="container"> 
       
      <div class="row">
      <div class="col-md-12">
        <h2 class="headingbox">My Results</h2>
        <div class="carddesign cardbox ">
          <form action="{{route('raffle-winner')}}" method="get">
            <div class="row myresults">
              <div class="col-lg-4 col-md-3">
                  <div class="form-group">
                      <label for="from_date">From Date</label>
                      <input type="datetime-local" class="form-control" name="from_date"  value="{{@$_GET['from_date']}}"> 
                  </div>
              </div>
              <div class="col-lg-4 col-md-3">
                  <div class="form-group">
                      <label for="to_date">To Date</label>
                      <input type="datetime-local" class="form-control" name="to_date" value="{{@$_GET['to_date']}}">  
                  </div>
              </div>
              <div class="col-lg-2 col-md-3">
                  <div class="form-group filterformbtn">
                      <input type="submit" class="btn btn-info" value="Apply"> 
                  </div>
              </div>
              <div class="col-lg-2 col-md-3">
                <div class="form-group filterformbtn">
                  <a href="{{route('raffle-winner')}}" class="btn btn-info resetall">Reset All</a> 
                </div>
              </div>
            </div>
          </form>
                  
          <div class="table-responsive tabledesign">
              <table class="table dt-responsive categories_table">
                <thead>
                    <tr>
                      <th>Title</th>
                      <th>Prize Title</th>
                      <th>Prize</th>
                      <th>Winning Amount</th>
                      <th>Winning Ball</th>
                      <th>Draw Time</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($raffle_results)
                      @foreach($raffle_results as $key => $value)
                        <tr>
                          <td>{{$value->draw_title}}</td>
                          <td>{{$value->prize_name}}</td>
                          <td>
                              <div class="prize-img">
                                 
                                      <img alt="Profile" height="35px" width="35px" class="img-fluid" src="{{$value->physical_prize_image ? url('/').'/'.$value->physical_prize_image : ''}}" >
                                
                                  <span class="prizephysical">{{$value->physical_prize}}</span>
                              </div>
                          </td>
                          <td><span class="fee">{{$value->cash_prize}}</span></td>
                          <td>{{$value->winning_ball}}</td>
                          <td>{{ \Carbon\Carbon::parse($value->draw_time)->format('M d-Y h:i A')}}</td>

                          <td>
                            @if(!$value->user_choice)
                              <ul class="table-controls">
                                <li><a class="btn btn-info" href="{{ route('claim-prize', $value->prize_id) }}"  data-toggle="tooltip" data-placement="top" title="Claim Prize">Claim Prize</a></li>
                              </ul>
                            @else
                              <ul class="table-controls">
                                <li><span class="claimedsuccessfully">Claimed Successfully</span></li>
                              </ul>
                            @endif
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

  $('.categories_table').DataTable();
</script>