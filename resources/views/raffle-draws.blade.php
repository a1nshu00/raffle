@include('layouts.header')
  <section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>Raffle Draws</h2>
          <ul class="breadcrumb">
          <li><a href="{{route('dashboard')}}">Dashboard</a></li>
          <li>Raffle Draws</li>
        </ul>
        </div>
      </div>
    </div>
  </section>
  
  <section class="main-sec raffledrawspage">
    <div class="container">
      <div class="row">
        @if($raffle_draw)
          @foreach($raffle_draw as $key => $value)
            <div class="col-md-3">
              <div class="upcomingcard">
                <h3>{{$value->draw_title}}</h3>
                <h4>{{$value->type}}</h4>
                <h5><span>Draw End:</span> {{ \Carbon\Carbon::parse($value->draw_time)->format('M d-Y h:i A')}}</h5>
                <a href="{{route('raffle-draw-detail', $value->id)}}" class="btn btn-info">Play Now</a>
              </div>
            </div>
          @endforeach
        @endif
       
      </div>
    </div>
  </section>

@include('layouts.footer')
