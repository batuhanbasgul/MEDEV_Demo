<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" class="custom-scrollbar">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{__('constant.description')}}">
    <meta name="keywords" content="{{__('constant.keywords')}}">
    <meta name="author" content="{{__('constant.author')}}">
    <link rel="icon" href="{{asset('assets/images/logo/icon-logo.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/images/logo/icon-logo.png')}}" type="image/x-icon">
    <title>@yield('title')</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/fontawesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/icofont.css')}}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/themify.css')}}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/flag-icon.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/feather-icon.css')}}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/prism.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/sweetalert2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/date-picker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/image-cropper.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/scrollable.css')}}">
    <!-- Plugins css Ends-->
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{asset('assets/css/color-1.css')}}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/custom.css')}}">
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

  </head>
  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="theme-loader">
        <div class="loader-p"></div>
      </div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      <div class="page-main-header">
        <div class="main-header-right row m-0">
          <div class="main-header-left">
            <div class="logo-wrapper">
              <a href="{{ route('index') }}">
                <img class="img-fluid disappear-500" style="border-radius: 20%; width:50px; height: 50px;" src="{{ asset('assets/images/logo/logo.png') }}" alt=""></a>
                <span class="ms-2" style="font-weight: bold; font-size: large;">PS-MNG</span>
              </a>
            </div>
            <div class="dark-logo-wrapper">
              <img class="img-fluid disappear-500" style="border-radius: 20%; width:50px; height: 50px;" src="{{ asset('assets/images/logo/dark-logo.png') }}" alt=""></a>
              <span class="ms-2" style="font-weight: bold; font-size: large;">PS-MNG</span>
            </div>
            <!--
            <div class="logo-wrapper"><a href="{{route('index')}}"><img class="img-fluid" style="max-height:64px;" src="{{asset('assets/images/logo/logo.png')}}" alt=""></a></div>
            <div class="dark-logo-wrapper">
                <a href="{{route('index')}}">
                    <img class="img-fluid" style="max-height:28px;" src="{{asset('assets/images/logo/dark-logo.png')}}" alt="">
                </a>
            </div>
            <div class="version-text" id="v-text"></div>
            <script>
                let width = screen.width;
                if(width<=767){
                    document.getElementById("v-text").innerHTML = "-V0.0";
                }else{
                    document.getElementById("v-text").innerHTML = "- Version 0.0";
                }

            </script>
        -->
            <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle"></i></div>
          </div>
          <div class="nav-right col pull-right right-menu p-0">
            <ul class="nav-menus">
              <li class="onhover-dropdown">
                <div class="notification-box"><i data-feather="bell"></i>
                    @if(session('job_notification_count') > 0)
                    <span class="dot-animated"></span>
                    @endif
                </div>
                <ul class="notification-dropdown onhover-show-div">
                  <li>
                    <p class="f-w-700 mb-0">
                        @if(session('job_notification_count') > 0)
                        {{__('constant.you_have_assigned_job')}}
                        @else
                        {{__('constant.you_have_not_assigned_job')}}
                        @endif
                        <span class="pull-right badge badge-primary badge-pill">{{session('job_notification_count')}}</span>
                    </p>
                  </li>
                  @foreach (session('job_notifications') as $item)
                  <a href="{{route('job-controller.show',$item->id)}}">
                    <li class="noti-primary">
                      <div class="media"><span class="notification-bg bg-light-primary"><i data-feather="briefcase"></i></span>
                        <div class="media-body">
                          <p>{{$item->job_title}} </p><span>{{$item->start_date}}</span>
                        </div>
                      </div>
                    </li>
                  </a>
                  @endforeach
                </ul>
              </li>
              <li class="onhover-dropdown">
                <div class="notification-box"><i data-feather="message-square"></i>
                    @if(session('message_notification_count') > 0)
                    <span class="dot-animated"></span>
                    @endif
                </div>
                <ul class="chat-dropdown onhover-show-div">
                  <li>
                    <p class="f-w-700 mb-0">
                        @if(session('message_notification_count') > 0)
                        {{__('constant.you_have_unread_messages')}}
                        @else
                        {{__('constant.you_dont_have_unread_messages')}}
                        @endif
                        <span class="pull-right badge badge-primary badge-pill">{{session('message_notification_count')}}</span></p>
                  </li>
                  @foreach (session('message_notifications') as $message)
                    <a href="{{route('message-controller.show',[$message->id])}}">
                      <li>
                          <div class="media"><img class="img-fluid rounded-circle me-3" src="@if(0 == $message->company_id) {{asset('assets/images/logo/icon-logo.png')}} @elseif($message->image) {{asset($message->image)}} @else {{asset('assets/images/constant/user.png')}} @endif" alt="">
                          <div class="media-body" style="color:red"><span>@if(0 == $message->company_id) {{__('constant.system_message')}} @else {{$message->sender_name}} @endif</span>
                              <p class="f-12 light-font">{{$message->title}}</p>
                          </div>
                          <p class="f-12">{{$message->date}}, {{$message->time}}</p>
                          </div>
                      </li>
                    </a>
                  @endforeach
                  <li class="text-center"> <a class="f-w-700" href="{{route('message-controller.index',['filter'=>0,'selectedPage'=>1])}}">{{__('constant.see_all')}}     </a></li>
                </ul>
              </li>
              <li class="text-dark">
                   @if (session('langCode') == 'en')
                   <a @if(Auth::user()->theme) style="font-size:140%; color: black;" @else style="font-size:140%; color: white;" @endif href="{{route('change-language','en')}}">EN</a> | <a @if(Auth::user()->theme) style="color: black;" @else style="color: white;" @endif href="{{route('change-language','tr')}}">TR</a>
                   @elseif (session('langCode') == 'tr')
                   <a @if(Auth::user()->theme) style="color: black;" @else style="color: white;" @endif href="{{route('change-language','en')}}">EN</a> | <a @if(Auth::user()->theme) style="font-size:140%; color: black;" @else style="font-size:140%; color: white;" @endif href="{{route('change-language','tr')}}">TR</a>
                   @else
                   <a @if(Auth::user()->theme) style="font-size:140%; color: black;" @else style="font-size:140%; color: white;" @endif href="{{route('change-language','en')}}">EN</a> | <a @if(Auth::user()->theme) style="color: black;" @else style="color: white;" @endif href="{{route('change-language','tr')}}">TR</a>
                   @endif
              </li>

              <li>
                <form action="{{ route('user-controller.update',[Auth::id()]) }}" method="POST">
                  @csrf
                  @method("PUT")
                  @if (Auth::user()->theme)
                    <input type="hidden" id="theme" name="theme" value="0">
                    <button type="submit" id="updateuserpreferences" name="updateuserpreferences" class="fabutton-light">
                        <i data-feather="moon"></i>
                    </button>
                  @else
                    <input type="hidden" id="theme" name="theme" value="1">
                    <button type="submit" id="updateuserpreferences" name="updateuserpreferences" class="fabutton-dark">
                        <i data-feather="sun"></i>
                    </button>
                  @endif
                </form>
              </li>

              <!--
              <li><a class="text-dark disappear-400" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
              -->

              <li class="onhover-dropdown p-0">
                <li class="p-0">
                  <a class="d-flex align-items-center justify-content-between" href="{{ route('logout') }}"
                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                    </form>
                    <span class="fs-sm fw-medium">
                      <button class="btn btn-primary-light" type="button"><i data-feather="log-out"></i><t class="disappear-400">{{__('constant.logout')}}</t></button>
                    </span>
                  </a>
                </li>
              </li>
            </ul>
          </div>
          <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
        </div>
      </div>
      <!-- Page Header Ends -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper horizontal-menu">
        <!-- Page Sidebar Start-->
        <header class="main-nav">
          <div class="sidebar-user text-center mb-0"><a class="setting-primary" href="{{route('user-controller.edit',Auth::id())}}"><i data-feather="settings"></i></a>
            @if (Auth::user()->p_image)
            <img class="img-90 rounded-circle" src="{{asset( Auth::user()->p_image )}}" alt="">
            @else
            <img class="img-90 rounded-circle" src="{{asset('assets/images/constant/user.png')}}" alt="">
            @endif
            <a href="{{route('user-controller.edit',Auth::id())}}">
              <h6 class="mt-3 f-14 f-w-600">{{Auth::user()->name}}</h6>
            </a>
            <p class="mb-0 font-roboto">{{Auth::user()->department}}</p>
          </div>

          <div class="sidebar-user px-3 mb-0">
            <div class="row">
                <div class="col">
                    <button class="btn btn-lg btn-primary" style="font-size: 2.2em; width: 100%;" onclick="startScan()" data-bs-toggle="modal" data-bs-target="#qrReader"><i class="fa-solid fa-qrcode"></i></button>
                </div>
                <div class="col">
                    <a href="{{route('dev-transaction-controller.find-devices')}}">
                        <button class="btn btn-lg btn-primary" style="font-size: 2.2em; width: 100%;" data-bs-toggle="modal" data-bs-target="#searchDevice"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </a>
                </div>
            </div>
          </div>

          <nav>
            <div class="main-navbar" >
              <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
              <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                  <li class="back-btn">
                    <div class="mobile-back text-end"><span>{{__('constant.back')}}</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                  </li>
                  <li class="sidebar-main-title">
                    <div>
                        <h6>{{__('constant.technical')}}</h6>
                    </div>
                  </li>
                  <li class="dropdown">
                    <a @if (session('selectedSideMenu') == 'dev-transaction-controller') class="nav-link link-nav active selected-menu-item" @else class="nav-link menu-title link-nav" @endif href="{{route('dev-transaction-controller.index')}}">
                      <i data-feather="file-text"></i><span @if (session('selectedSideMenu') == 'dev-transaction-controller') style="color:#D0EFE0" @endif>{{__('constant.technical_form')}}</span>
                    </a>
                  </li>
                  <li class="dropdown">
                    <a @if (session('selectedSideMenu') == 'data-output-controller') class="nav-link link-nav active selected-menu-item" @else class="nav-link menu-title link-nav" @endif href="{{route('data-output-controller.create')}}">
                        <i data-feather="save"></i><span @if (session('selectedSideMenu') == 'data-output-controller') style="color:#D0EFE0" @endif>{{__('constant.documentary')}}</span>
                    </a>
                  </li>
                  <li class="sidebar-main-title">
                    <div>
                      <h6>{{__('constant.general')}}             </h6>
                    </div>
                  </li>
                  <li class="dropdown">
                    <a @if (session('selectedSideMenu') == 'index') class="nav-link link-nav active selected-menu-item" @else class="nav-link menu-title link-nav" @endif href="{{route('index')}}" >
                      <i data-feather="bar-chart-2"></i><span @if (session('selectedSideMenu') == 'index') style="color:#D0EFE0" @endif>{{__('constant.dashboard')}}</span>
                    </a>
                  </li>
                  <li class="dropdown">
                    <a @if (session('selectedSideMenu') == 'user-controller') class="nav-link link-nav active selected-menu-item" @else class="nav-link menu-title link-nav" @endif href="{{route('user-controller.index')}}">
                      <i data-feather="users"></i><span @if (session('selectedSideMenu') == 'user-controller') style="color:#D0EFE0" @endif>{{__('constant.users')}}</span>
                    </a>
                  </li>
                  <li class="dropdown">
                    <a @if (session('selectedSideMenu') == 'job-controller') class="nav-link link-nav active selected-menu-item" @else class="nav-link menu-title link-nav" @endif href="{{route('job-controller.index',['filter'=>0,'selectedPage'=>1])}}">
                      <i data-feather="check-square"></i><span @if (session('selectedSideMenu') == 'job-controller') style="color:#D0EFE0" @endif>{{__('constant.job_management')}}</span>
                    </a>
                  </li>
                  <li class="dropdown">
                    <a @if (session('selectedSideMenu') == 'message-controller') class="nav-link link-nav active selected-menu-item" @else class="nav-link menu-title link-nav" @endif href="{{route('message-controller.index',['filter'=>0,'selectedPage'=>1])}}">
                      <i data-feather="mail"></i><span @if (session('selectedSideMenu') == 'message-controller') style="color:#D0EFE0" @endif>{{__('constant.messages')}}</span>
                    </a>
                  </li>
                  <li class="dropdown">
                    <a @if (session('selectedSideMenu') == 'company-controller') class="nav-link link-nav active selected-menu-item" @else class="nav-link menu-title link-nav" @endif href="{{route('company-controller.edit',[Auth::user()->company_id])}}">
                      <i data-feather="briefcase"></i><span @if (session('selectedSideMenu') == 'company-controller') style="color:#D0EFE0" @endif>{{__('constant.company')}}</span>
                    </a>
                  </li>
                  <li class="sidebar-main-title">
                    <div>
                        <h6>{{__('constant.product_tracking')}}</h6>
                    </div>
                  </li>
                  <li class="dropdown">
                    <a @if (session('selectedSideMenu') == 'corporation-controller') class="nav-link link-nav active selected-menu-item" @else class="nav-link menu-title link-nav" @endif href="{{route('corporation-controller.index')}}">
                      <i data-feather="archive"></i></i><span @if (session('selectedSideMenu') == 'corporation-controller') style="color:#D0EFE0" @endif>{{__('constant.corporations')}}</span>
                    </a>
                  </li>
                  <li class="dropdown">
                    <a @if (session('selectedSideMenu') == 'department-controller') class="nav-link link-nav active selected-menu-item" @else class="nav-link menu-title link-nav" @endif href="{{route('department-controller.index')}}">
                      <i data-feather="book"></i></i><span @if (session('selectedSideMenu') == 'department-controller') style="color:#D0EFE0" @endif>{{__('constant.departments')}}</span>
                    </a>
                  </li>
                  <li class="dropdown">
                    <a @if (session('selectedSideMenu') == 'product-controller') class="nav-link link-nav active selected-menu-item" @else class="nav-link menu-title link-nav" @endif href="{{route('product-controller.index')}}">
                      <i data-feather="box"></i><span @if (session('selectedSideMenu') == 'product-controller') style="color:#D0EFE0" @endif>{{__('constant.products')}}</span>
                    </a>
                  </li>
                  <li class="dropdown" style="margin-bottom:360px;">
                    <a @if (session('selectedSideMenu') == 'device-controller') class="nav-link link-nav active selected-menu-item" @else class="nav-link menu-title link-nav" @endif href="{{route('device-controller.index')}}">
                      <i data-feather="cpu"></i><span @if (session('selectedSideMenu') == 'device-controller') style="color:#D0EFE0" @endif>{{__('constant.devices')}}</span>
                    </a>
                  </li>




                  <!--
                  <li class="sidebar-main-title">
                    <div>
                        @if(session('agent')->isMobile())
                        <h6>Mobil             </h6>
                        @elseif(session('agent')->isTablet())
                        <h6>Tablet             </h6>
                        @else
                        <h6>PC             </h6>
                        @endif
                    </div>
                  </li>
                  <li class="dropdown"><a class="nav-link menu-title link-nav" href="bookmark.html"><i data-feather="heart"></i><span>Bookmarks</span></a></li>
                  <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="box"></i><span>Ui Kits</span></a>
                    <ul class="nav-submenu menu-content">
                      <li><a class="submenu-title" href="javascript:void(0)">Tabs<span class="sub-arrow"><i class="fa fa-chevron-right"></i></span></a>
                        <ul class="nav-sub-childmenu submenu-content">
                          <li><a href="tab-bootstrap.html">Bootstrap Tabs</a></li>
                          <li><a href="tab-material.html">Line Tabs</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                -->

                </ul>
              </div>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </div>
          </nav>
        </header>

    <div class="modal fade modal-bookmark" id="qrReader" tabindex="-1" role="dialog" aria-labelledby="qrReaderLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="qrReaderLabel">{{__('constant.scan_qr')}}</h5>
                <button class="btn-close" type="button" onclick="stopScan()" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="reader" width="600px" height="600px"></div>
                    <script src="{{asset('assets/qr-scan.js')}}"></script>
                </div>
            </div>
        </div>
    </div>
