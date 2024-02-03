@include('layouts.header')
  <section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>Results</h2>
          <ul class="breadcrumb">
          <li><a href="{{route('dashboard')}}">Dashboard</a></li>
          <li>Results</li>
        </ul>
        </div>
      </div>
    </div>
  </section>

  
  <section class="main-sec">
    <div class="container"> 
       
      <div class="row">
      <div class="col-md-12">
        <h2 class="headingbox">Results</h2>
        <div class="carddesign cardbox">
                  
          <div class="table-responsive tabledesign">
              <table class="table dt-responsive categories_table">
                <thead>
                    <tr>
                      <th>Name</th>
                      <th>Raffle Title</th>
                      <th>Prize Title</th>
                      <th>Prize</th>
                      <th>Winning Amount</th>
                      <th>Winning Ball</th>
                      <th>Draw Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($raffle_results)
                      @foreach($raffle_results as $key => $value)
                        @php 
                           $name = $value->first_name.' '.$value->last_name;
                            $firstTwo = substr($name, 0, 2);
                            $lastTwo = substr($name, -2);
                            $maskedMiddle = str_repeat('*', 5);
                            $maskedName = $firstTwo . $maskedMiddle . $lastTwo;
                            
                        @endphp
                        <tr>
                            <td>{{$maskedName}}</td>
                            <td>{{$value->draw_title}}</td>
                            <td>{{$value->prize_name}}</td>
                            <td>
                                <div class="prize-img">
                                   
                                        <img alt="Profile" height="35px" width="35px" class="img-fluid prizeimage" src="{{$value->physical_prize_image ? url('/').'/'.$value->physical_prize_image : ''}}" >
                                    
                                    <span class="prizephysical">{{$value->physical_prize}}</span>
                                </div>
                            </td>
                            <td><span class="fee">{{$value->cash_prize}}</span></td>
                            <td>{{$value->winning_ball}}</td>
                            <td>{{ \Carbon\Carbon::parse($value->draw_time)->format('M d-Y h:i A')}}</td>
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
  $('.categories_table').DataTable();
</script>