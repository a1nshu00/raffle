@include('layouts.header')
<section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
  <div class="container">
     <div class="row">
      <div class="col-md-12">
        <h2>Dashboard</h2>
        <ul class="breadcrumb">
        <li>Dashboard</li>
      </ul>
      </div>
     </div>
  </div>
</section>

<section class="main-sec">
  <div class="container"> 
    <div class="row dashboardcard">  
     <div class="col-lg-3 col-md-6">
        <div class="carddesign">
          <h2>{{$total_raffle}}</h2>
          <h3>Total Raffle Draws</h3>
          <span><img src="{{asset('assets/images/dicon1.png')}}" class="img-fluid" alt=""></span>
        </div>       
      </div>    
      <div class="col-lg-3 col-md-6">
        <div class="carddesign">
          <h2>${{auth()->guard('web')->user()->wallet_balance}}</h2>
          <h3>Total Balance</h3>
          <span><img src="{{asset('assets/images/dicon2.png')}}" class="img-fluid" alt=""></span>
        </div>       
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="carddesign">
          <h2>${{$total_deposit}}</h2>
          <h3>Total Deposit</h3>
          <span><img src="{{asset('assets/images/dicon3.png')}}" class="img-fluid" alt=""></span>
        </div>       
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="carddesign">
          <h2>${{$total_withdrawal}}</h2>
          <h3>Total Withdraw</h3>
          <span><img src="{{asset('assets/images/dicon4.png')}}" class="img-fluid" alt=""></span>
        </div>       
      </div>      
    </div>


    <div class="row">
     <div class="col-md-12">
      <h2 class="headingbox">Recent Activity</h2>
      <div class="carddesign cardbox">
                
        <div class="table-responsive tabledesign">
             <table class="table dt-responsive categories_table">
              <thead>
                <tr>
                  <th>Transection ID</th>
                  <th>Transection Type</th>
                  <th style="min-width: 170px;">Date</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>   
                @if(count($transactions) > 0)
                  @foreach($transactions as $key => $value)
                    <tr>
                      <td>{{$value->transaction_id}}</td>
                      <td>{{$value->type}}</td>
                      <td>{{$value->created_at ? date_format(date_create($value->created_at), 'M d-Y h:i A') : ''}}</td>
                      <td><span class="fee">${{$value->amount}}</span></td>
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