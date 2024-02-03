@include('layouts.header')
  <section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>Orders</h2>
          <ul class="breadcrumb">
          <li><a href="{{route('dashboard')}}">Dashboard</a></li>
          <li>Orders</li>
        </ul>
        </div>
      </div>
    </div>
  </section>

  
  <section class="main-sec">
    <div class="container"> 
      <div class="row">
      <div class="col-md-12">
        <h2 class="headingbox">My Orders</h2>
        <div class="carddesign cardbox">
                  
          <div class="table-responsive tabledesign">
              <table class="table dt-responsive categories_table">
                <thead>
                    <tr>
                      <th>Raffle Name</th>
                      <th>Ball Number</th> 
                      <th style="min-width: 180px;">Order Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($orders)
                      @foreach($orders as $key => $value)
                        <tr>
                          <td>{{$value->draw_title}}</td>
                          <td>{{$value->ball_number}}</td>
                          <td>{{ \Carbon\Carbon::parse($value->created_at)->format('M d-Y h:i A')}}</td>
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