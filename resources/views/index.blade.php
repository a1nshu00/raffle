@include('layouts.header')

    <section class="mainbanner" style="background: url('{{asset('assets/images/bg.png')}}');">
        <div class="container">



            <div class="row">
            <div class="col-md-12">
                <div class="mainbanner-text">
                <h1>A referral draw game is a <span>promotional activity designed</span> to encourage individuals to refer others to a particular product, service, or event.</h1>
                
                <a href="{{route('raffle-draws')}}" class="btn btn-info">Play Now</a>
                </div>
            </div>      
            </div>   
            
            <img src="{{asset('assets/images/effect1.png')}}" class="img-fluid effect1" alt="">
            <img src="{{asset('assets/images/effect2.png')}}" class="img-fluid effect2" alt="">
            <img src="{{asset('assets/images/banner-obj-1.png')}}" class="img-fluid banner-obj-1" alt="">
            <img src="{{asset('assets/images/banner-obj-2.png')}}" class="img-fluid banner-obj-2" alt="">
            <img src="{{asset('assets/images/banner-obj-3.png')}}" class="img-fluid banner-obj-3" alt="">
        </div>
    </section>



    <section class="aboutsec">
        <div class="container">
            <div class="row">
            <div class="col-md-12">
                <div class="headingsec">
                <h2>About Ending.biz</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Pulvinar sapien et ligula ullamcorper malesuada.</p>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-6">
                <div class="about-left">
                <h3>In this game, participants are typically given a unique referral link or code that they can share with their friends, family, or social network. When someone uses their referral link or code to sign up, make a purchase, or take any desired action, both the referrer and the new user are entered into a draw or raffle for a chance to win prizes or rewards.</h3>
                <p>The objective of a referral draw game is to incentivize word-of-mouth marketing and increase the reach of a brand or offer. By offering rewards for successful referrals, companies can tap into the personal networks of their existing customers or supporters and potentially acquire new customers through trusted recommendations.</p>
                <p>Participants in the referral draw game usually have an increased chance of winning based on the number of successful referrals they make. The more people they refer, the more entries they receive into the draw, thus increasing their probability of winning. This creates a sense of competition and motivation for participants to actively promote the product or service to their networks.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="about-right">
                <img src="{{asset('assets/images/about.png')}}" class="img-fluid" alt="">
                </div>
            </div>
            </div>
        </div>
    </section>

    <section class="banner" style="background: url('{{asset('assets/images/cta-2.png')}}');">
        <div class="container">
            <div class="row">
            <div class="col-md-12">
                <div class="headingsec">
                <h2>Next Available Raffle</h2>
                <a href="{{route('raffle-draws')}}" class="btn btn-info">Play now</a>
                </div>
            </div>
            </div>
        </div>
    </section>

    <section class="latest-sec" style="background: url('{{asset('assets/images/bg3.jpg')}}');">
        <div class="container">
            <div class="row">
            <div class="col-md-12">
                <div class="headingsec">
                <h2>Latest Results</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Pulvinar sapien et ligula ullamcorper malesuada.</p>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12">
                <div id="demos">
                    <div id="owl-demo1" class="">
                        @if(count($result))
                            @foreach($result as $key => $value)
                                @php 
                                   $name = $value['first_name'].' '.$value['last_name'];
                                    $firstTwo = substr($name, 0, 2);
                                    $lastTwo = substr($name, -2);
                                    $maskedMiddle = str_repeat('*', 5);
                                    $maskedName = $firstTwo . $maskedMiddle . $lastTwo;
                                    
                                @endphp
                                <div class="item">
                                    <div class="carouselitem-desc">
                                        <div class="item-img">
                                        <div class="itemimgbox"><img src="{{$value['profile_image'] ? url('/').'/'.$value['profile_image'] : ''}}" class="img-fluid" alt="">
                                        <h5>${{$value['cash_prize'] ? $value['cash_prize'] : '0.00'}}</h5></div>
                                        <h4>{{$maskedName}}</h4>                    
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12">
                <div class="carouselibtn">
                <a href="{{route('results')}}" class="btn btn-info">View All</a>
            </div>
            </div>
            </div>
        </div>
    </section>


    <section class="howsec" style="background: url('{{asset('assets/images/bg2.jpg')}}');">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="headingsec">
                    <h2>How To Play</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Pulvinar sapien et ligula ullamcorper malesuada.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul>
                        <li>
                            <div class="howseccard">
                            <div class="howsecbox">
                            <i class="la la-pencil"></i><span>01</span>
                            </div>
                            <h3>Select Your Draw</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,</p>
                            </div>
                        </li>
                        <li>
                            <div class="howseccard">
                            <div class="howsecbox">
                            <i class="la la-hand-pointer-o"></i><span>02</span>
                            </div>
                            <h3>Choose Your Ball</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,</p>
                            </div>
                        </li>
                        <li>
                            <div class="howseccard">
                            <div class="howsecbox">
                            <i class="la la-credit-card"></i><span>03</span>
                            </div>
                            <h3>Make Payment</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,</p>
                            </div>
                        </li>
                        <li>
                            <div class="howseccard">
                            <div class="howsecbox">
                            <i class="la la-trophy"></i><span>04</span>
                            </div>
                            <h3>Claim Your Reward</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>



    <section class="upcomingsec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="headingsec">
                    <h2>Upcoming Draws</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Pulvinar sapien et ligula ullamcorper malesuada.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @if($raffle_draw)
                    @foreach($raffle_draw as $key => $value)
                        <div class="col-md-3">
                            <div class="upcomingcard">
                                <h3>{{$value->draw_title}}</h3>
                                <h4>{{$value->type}}</h4>
                                <h5><span>Draw End:</span>{{ \Carbon\Carbon::parse($value->draw_time)->format('M d-Y h:i A')}}</h5>
                                <a href="{{route('raffle-draw-detail', $value->id)}}" class="btn btn-info">Play Now</a>
                            </div>
                        </div>
                        @if($key === 3)
                            @break
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </section>


<footer class="footerbox" style="background: url('{{asset('assets/images/bg2.jpg')}}');">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="footercard">
          <a href="{{route('landing')}}" class="footerlogo"><img src="{{asset('assets/images/logo.png')}}" class="img-fluid" alt=""></a>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="footercard">
          <h2>Information</h2>
          <ul class="footerlink">
            <li><a href="{{route('about')}}">About</a></li>
            <li><a href="{{route('how_to_play')}}">How to Play</a></li>
            <li><a href="{{route('FAQ')}}">FAQs</a></li>
            <li><a href="{{route('contact-us')}}">Contact Us</a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-3">
        <div class="footercard">
          <h2>Site Policy</h2>
          <ul class="footerlink">
            <li><a href="{{route('privacy-policy')}}">Privacy Policy</a></li>
            <li><a href="{{route('desclimer')}}">Disclaimer</a></li>
            <li><a href="{{route('terms-of-use')}}">Terms of Use</a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-3">
        <div class="footercard">
          <h2>Join Our Community</h2>
          <ul class="social-link">
            <li><a href="#"><i class="la la-facebook"></i></a></li>
            <li><a href="#"><i class="la la-twitter"></i></a></li>
            <li><a href="#"><i class="la la-linkedin"></i></a></li>
            <li><a href="#"><i class="la la-instagram"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="copyright">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <p>Copyright © 2022 all rights reserved Ending.biz</p>
        </div>
      </div>
    </div>
  </div>
</footer>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
 <script src="{{asset('assets/js/owl.carousel.js')}}"></script>
<script type="text/javascript">
    
    $(document).ready(function() {

        $("#owl-demo1aa").owlCarousel({
        autoPlay : true,    
        items : 2,
        loop:false,
        autoplayTimeout:13000, 
        autoplayHoverPause:true,
        lazyLoad : true,
        navigation : true,
        responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 5
                }
            }
        });
        $( ".owl-prev").html('<i class="fa fa-angle-left" aria-hidden="true"></i>');
        $( ".owl-next").html('<i class="fa fa-angle-right" aria-hidden="true"></i>');
    });
</script>

