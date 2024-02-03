@include('admin.layout.header')
<link rel="stylesheet" type="text/css" href="{{asset('admin/plugins/dropify/dropify.min.css')}}">
<!-- BEGIN LOADER -->
<div id="load_screen"> <div class="loader"> <div class="loader-content">
    <div class="spinner-grow align-self-center"></div>
</div></div></div>
<!--  END LOADER -->
<!--  BEGIN CONTENT AREA  -->
<div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        @include('admin.layout.sidebar')          
        <!--  END SIDEBAR  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="page-header">
                    <div class="page-title">
                        <h3>Create Page</h3>
                    </div>
                </div>
                <div class="account-settings-container layout-top-spacing">
                    <form id="general-info" class="section general-info" method="POST" action="{{route('pages.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="account-content">
                            <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                        <div class="info">
                                            <h6 class="">General Information</h6>
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="form">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="page_name">Page Name</label>
                                                                    <select name="page_name" class="form-control" id="">
                                                                        <option value="">Please select...</option>
                                                                        <option value="About">About</option>
                                                                        <option value="FAQ">FAQ</option>
                                                                        <option value="How to Play">How to Play</option>
                                                                        <option value="Privacy Policy">Privacy Policy</option>
                                                                        <option value="Disclaimer">Disclaimer</option>
                                                                        <option value="Terms of Use">Terms of Use</option>
                                                                    </select>
                                                                    @error('page_name')
                                                                        <span class="invalid-feedback" role="alert" style="display:block;">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="title">Page Title</label>
                                                                    <input type="text" class="form-control"  id="title" placeholder="Page Title" name="title" value="{{ old('title') }}" >
                                                                    @error('title')
                                                                        <span class="invalid-feedback" role="alert" style="display:block;">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="body">Body</label>
                                                                    <textarea  class="form-control"  id="editor" name="body" value="{{ old('body') }}" ></textarea>
                                                                    @error('body')
                                                                          <span class="invalid-feedback" role="alert" style="display:block;">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                        <div class="account-settings-footer">
                            <div class="as-footer-container">
                                <button id="multiple-messages" type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @include('admin.layout.layout_scripts')
        </div>
    </div>
<!--  END CONTENT AREA  -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    $(document).ready(function(e) {
        toastr.options.timeOut = 10000;
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif
        CKEDITOR.replace('editor', {
            // Your other CKEditor configuration options here

            // Allow specific HTML tags and attributes
            autoParagraph: false,
            removePlugins: 'div,enterkey,entities',
            extraAllowedContent: '*(*)[*]{*}',
            fillEmptyBlocks: false
        });
    }); 
   
</script>