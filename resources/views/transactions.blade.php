@include('layouts.header')
  <section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>Transactions</h2>
          <ul class="breadcrumb">
          <li><a href="{{route('dashboard')}}">Dashboard</a></li>
          <li>Transactions</li>
        </ul>
        </div>
      </div>
    </div>
  </section>

  
  <section class="main-sec">
    <div class="container"> 
       
     

      <div class="row">
      <div class="col-md-12">
        <h2 class="headingbox">Transaction History</h2>
        <div class="carddesign cardbox">
                  
          <div class="table-responsive tabledesign">
              <table class="table dt-responsive categories_table">
                <thead>
                    <tr>
                      <th>Transection ID</th>
                      <th>Transection Type</th>
                      <th>Amount</th>
                      <th style="min-width: 180px;">Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($transaction)
                      @foreach($transaction as $key => $value)
                        <tr>
                          <td>{{$value->transaction_id}}</td>
                          <td>{{$value->type}}</td>
                          <td><span class="fee">{{$value->amount}}</span></td>
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