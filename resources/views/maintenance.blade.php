<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{__('constant.description')}}">
    <meta name="keywords" content="{{__('constant.keywords')}}">
    <meta name="author" content="{{__('constant.author')}}">
    <link rel="icon" href="{{asset('assets/images/logo/icon-logo.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/images/logo/icon-logo.png')}}" type="image/x-icon">
    <title>{{__('maintenance.maintenance')}}</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/fontawesome.css')}} ">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/icofont.css')}} ">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/themify.css')}} ">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/flag-icon.css')}} ">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/feather-icon.css')}} ">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.css')}} ">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}} ">
    <link id="color" rel="stylesheet" href="{{asset('assets/css/color-1.css')}} " media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/responsive.css')}} ">
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
      <!-- Page Body Start-->
      <div class="container-fluid p-0">
        <div class="comingsoon">
          <div class="comingsoon-inner text-center"><a href="index.html"><img style="max-width:100px;" src="{{asset('assets/images/logo/icon-logo.png')}}" alt=""></a>
            <h5>{{__('maintenance.under_maintenance')}}</h5>
            <div class="countdown" id="clockdiv">
              <ul>
                <li><span class="time digits" id="days"></span><span class="title">{{__('maintenance.day')}}</span></li>
                <li><span class="time digits" id="hours"></span><span class="title">{{__('maintenance.hour')}}</span></li>
                <li><span class="time digits" id="minutes"></span><span class="title">{{__('maintenance.minute')}}</span></li>
                <li><span class="time digits" id="seconds"></span><span class="title">{{__('maintenance.second')}}</span></li>
              </ul>
            </div>
            <div style="visibility: hidden;" id="date">{{$date}}</div>
          </div>
        </div>
      </div>
    </div>
    <!-- latest jquery-->
    <script src="{{asset('assets/js/jquery-3.5.1.min.js')}} "></script>
    <!-- feather icon js-->
    <script src="{{asset('assets/js/icons/feather-icon/feather.min.js')}} "></script>
    <script src="{{asset('assets/js/icons/feather-icon/feather-icon.js')}} "></script>
    <!-- Sidebar jquery-->
    <script src="{{asset('assets/js/sidebar-menu.js')}} "></script>
    <script src="{{asset('assets/js/config.js')}} "></script>
    <!-- Bootstrap js-->
    <script src="{{asset('assets/js/bootstrap/popper.min.js')}} "></script>
    <script src="{{asset('assets/js/bootstrap/bootstrap.min.js')}} "></script>
    <!-- Theme js-->
    <script src="{{asset('assets/js/script.js')}} "></script>
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>

<script>
    // Countdown js
    const second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;

    var countDown = new Date(document.getElementById('date').innerHTML).getTime(),
        x = setInterval(function() {

        var now = new Date().getTime(),
            distance = countDown - now;
            document.getElementById('days').innerText = Math.floor(distance / (day)),
            document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
            document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
            document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);
        }, second);
</script>
