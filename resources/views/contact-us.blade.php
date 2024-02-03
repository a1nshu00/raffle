@include('layouts.header')

<section class="breadcrumbsec" style="background: url('{{asset('assets/images/breadcrumb-bg.jpg')}}');">
  <div class="container">
     <div class="row">
      <div class="col-md-12">
        <h2>Contact Us</h2>
        <ul class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Contact Us</li>
      </ul>
      </div>
     </div>
  </div>
</section>
<section class="main-sec contactpage">
  <div class="container">
   
   <div class="row">      
      <div class="col-md-12">
        <div class="carddesign cardbox">         


          <div class="loginbox">
            <div class="loginpage-hading">
              <h2>Get in touch with us</h2>
              <p>Fill up the form and our team will get back to you within 24 hours</p>
            </div>
             <div class="contact-form">         
          
            
             <form action="store-contact-us" method="post" >
              @csrf
               <div class="row">
                   <div class="col-lg-6">
                       <div class="form-group">
                         <label>First Name</label>
                         <input type="text" class="form-control" name="first_name" id="fname" placeholder="First Name">
                         @error('first_name')
                              <span class="invalid-feedback" role="alert" style="display:block">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                       <div class="form-group">
                         <label>Last Name</label>
                         <input type="text" class="form-control" name="last_name" id="" placeholder="Last Name">
                         @error('last_name')
                              <span class="invalid-feedback" role="alert" style="display:block">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                   <div class="col-lg-6">
                         <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
                            @error('email')
                              <span class="invalid-feedback" role="alert" style="display:block">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                          </div>
                    </div>
                    <div class="col-lg-6">
                       <div class="form-group">
                         <label>Subject</label>
                         <input type="text" class="form-control" name="subject" id="" placeholder="Subject">
                         @error('subject')
                              <span class="invalid-feedback" role="alert" style="display:block">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                    </div>                    
                </div>
                
                <div class="row">
                   <div class="col-lg-12">
                       <div class="form-group">
                             <label for="comment">Your Message</label>
                             <textarea class="form-control" rows="5" name="message" id="comment" placeholder="Your Message"></textarea>
                             @error('message')
                              <span class="invalid-feedback" role="alert" style="display:block">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                         </div>
                    </div>
                </div>
                
                <div class="row">
                   <div class="col-lg-12">
                       <div class="form-group">
                             <button type="submit" class="btn btn-info width100">Submit</button>
                        </div>
                    </div>
                </div>


            </form>
        </div>
                
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
</script>