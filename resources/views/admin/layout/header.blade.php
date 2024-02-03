<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <link rel="icon" href="data:,">
        <title>ending.biz</title>
        <!-- <link rel="icon" type="image/x-icon" href="{{asset('admin/assets/favicon.ico')}}"/> -->
        <link href="{{asset('admin/assets/css/loader.css')}}" rel="stylesheet" type="text/css" />
        <script src="{{asset('admin/assets/js/loader.js')}}"></script>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
        <link href="{{asset('admin/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/structure.css')}}" rel="stylesheet" type="text/css" class="structure" />
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
        <!-- <link href="{{asset('admin/plugins/apex/apexcharts.css')}}" rel="stylesheet" type="text/css"> -->
        <link href="{{asset('admin/assets/css/dashboard/dash_1.css')}}" rel="stylesheet" type="text/css" class="dashboard-analytics" />
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
        <link href="{{asset('admin/assets/css/users/user-profile.css')}}" rel="stylesheet" type="text/css" />

        <link href="{{asset('admin/assets/css/users/account-setting.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="{{asset('admin/assets/css/tables/table-basic.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('admin/assets/css/elements/custom-pagination.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    </head>
    <body class="dashboard-analytics">
        <!--  BEGIN NAVBAR  -->
        <div class="header-container fixed-top">
            <header class="header navbar navbar-expand-sm">
                <ul class="navbar-item flex-row">
                    <li class="nav-item theme-logo">
                        <a href="{{route('adminDashboard')}}">
                            <img src="{{asset('admin/assets/img/logo.png')}}" class="navbar-logo" alt="logo">
                        </a>
                    </li>
                </ul>

                <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom" id="toggleSlide">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg>
                </a>

                <ul class="navbar-item flex-row search-ul">
                    <li class="nav-item align-self-center search-animated">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <form class="form-inline search-full form-inline search" role="search">
                            <div class="search-bar">
                                <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Search...">
                            </div>
                        </form> -->
                    </li>
                </ul>
                <ul class="navbar-item flex-row navbar-dropdown">
                    <li class="nav-item dropdown notification-dropdown">
                        <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class="badge badge-success"></span>
                        </a>
                        <div class="dropdown-menu position-absolute animated fadeInUp" aria-labelledby="notificationDropdown">
                            <div class="notification-scroll"> 
                                <div class="dropdown-item">
                                    <div class="media server-log">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                                        <div class="media-body">
                                            <span>No Notifications...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                        <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{asset('admin/assets/img/user.jpg')}}" alt="admin-profile" class="img-fluid">
                        </a>
                        <div class="dropdown-menu position-absolute animated fadeInUp" aria-labelledby="userProfileDropdown">
                            <div class="user-profile-section">
                                <div class="media mx-auto">
                                    <!-- <img src="{{asset('admin/assets/img/90x90.jpg')}}" class="img-fluid mr-2" alt="avatar"> -->
                                    <div class="media-body">
                                        <h5>{{auth('admin')->check() ?  auth('admin')->user()->first_name: ''}}</h5>
                                        <p>Project Leader</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="dropdown-item">
                                <a href="{{route('change-password-ad')}}">
                                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"  stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><g id="Change_password"><path d="M464.4326,147.54a9.8985,9.8985,0,0,0-17.56,9.1406,214.2638,214.2638,0,0,1-38.7686,251.42c-83.8564,83.8476-220.3154,83.874-304.207-.0088a9.8957,9.8957,0,0,0-16.8926,7.0049v56.9a9.8965,9.8965,0,0,0,19.793,0v-34.55A234.9509,234.9509,0,0,0,464.4326,147.54Z"/><path d="M103.8965,103.9022c83.8828-83.874,220.3418-83.8652,304.207-.0088a9.8906,9.8906,0,0,0,16.8926-6.9961v-56.9a9.8965,9.8965,0,0,0-19.793,0v34.55C313.0234-1.3556,176.0547,3.7509,89.9043,89.9012A233.9561,233.9561,0,0,0,47.5674,364.454a9.8985,9.8985,0,0,0,17.56-9.1406A214.2485,214.2485,0,0,1,103.8965,103.9022Z"/><path d="M126.4009,254.5555v109.44a27.08,27.08,0,0,0,27,27H358.5991a27.077,27.077,0,0,0,27-27v-109.44a27.0777,27.0777,0,0,0-27-27H153.4009A27.0805,27.0805,0,0,0,126.4009,254.5555ZM328,288.13a21.1465,21.1465,0,1,1-21.1465,21.1464A21.1667,21.1667,0,0,1,328,288.13Zm-72,0a21.1465,21.1465,0,1,1-21.1465,21.1464A21.1667,21.1667,0,0,1,256,288.13Zm-72,0a21.1465,21.1465,0,1,1-21.1465,21.1464A21.1667,21.1667,0,0,1,184,288.13Z"/><path d="M343.6533,207.756V171.7538a87.6533,87.6533,0,0,0-175.3066,0V207.756H188.14V171.7538a67.86,67.86,0,0,1,135.7208,0V207.756Z"/></g></svg>
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>  -->
                                    <span>Change password</span>
                                </a>
                            </div>
                            <div class="dropdown-item">
                                <a href="{{route('adminLogout')}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg> <span>Log Out</span>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </header>
        </div>
        <!--  END NAVBAR  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
         <script> 

            toastr.options.timeOut = 10000;
            var Selector = {
                getBody: 'body',
                mainHeader: '.header.navbar',
                headerhamburger: '.toggle-sidebar',
                fixed: '.fixed-top',
                mainContainer: '.main-container',
                sidebar: '#sidebar',
                sidebarContent: '#sidebar-content',
                sidebarStickyContent: '.sticky-sidebar-content',
                ariaExpandedTrue: '#sidebar [aria-expanded="true"]',
                ariaExpandedFalse: '#sidebar [aria-expanded="false"]',
                contentWrapper: '#content',
                contentWrapperContent: '.container',
                mainContentArea: '.main-content',
                searchFull: '.toggle-search',
                overlay: {
                    sidebar: '.overlay',
                    cs: '.cs-overlay',
                    search: '.search-overlay'
                }
            };

            $('body').delegate('.sidebarCollapse','click', function () {
                get_CompactSubmenuShow = document.querySelector('#smth');
                get_overlay = document.querySelector('.overlay');
                get_mainContainer = document.querySelector('.main-container')
                
                $(Selector.mainContainer).toggleClass("sidebar-closed");
                $(Selector.mainContainer).toggleClass("sbar-open");
                if (window.innerWidth <= 991) {
                    if (get_overlay.classList.contains('show')) {
                        get_overlay.classList.remove('show');
                    } else {
                        get_overlay.classList.add('show');
                    }
                }
                $('html,body').toggleClass('sidebar-noneoverflow');
                $('footer .footer-section-1').toggleClass('f-close');
                
                $('#compact_submenuSidebar').toggleClass('hide-sub');
                $('#compact_submenuSidebar').toggleClass('show');
                if ( window.innerWidth < 700 ) {
                    $(".overlay").toggleClass('show');
                }
            });

           
        </script>
    </body>
</html>