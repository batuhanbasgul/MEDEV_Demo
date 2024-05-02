<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{__('constant.description')}}">
    <meta name="keywords" content="{{__('constant.keywords')}}">
    <meta name="author" content="{{__('constant.author')}}">
    <link rel="icon" href="{{ asset('assets/images/logo/icon-logo.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/icon-logo.png') }}" type="image/x-icon">
    <title>{{__('login.login_title')}}</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/fontawesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/feather-icon.css') }}">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.css') }}">
    <script src="https://www.google.com/recaptcha/api.js"></script>
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
    <section>
      <div class="container-fluid p-0" style="background-image:url('{{asset('assets/images/background/login.jpg')}}');">
        <div class="row">
          <div class="col-12">
            <div class="login-card">
              <form id="login-form" class="theme-form login-form" action="{{ route('login') }}" method="POST">
                <div class="d-flex justify-content-center" style="width: 100%;">
                    <img style="max-width:200px; margin-bottom:32px; margin-left: 20px; max-width:25%; border-radius:5%;" src="{{asset('assets/images/logo/logo.png')}}" alt="">
                </div>
                @csrf
                <h4>{{__('login.login')}}</h4>
                <h6>{{__('login.login_to_account')}}</h6>
                <div class="form-group">
                  <label>{{__('login.email_address')}}</label>
                  <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                    <input class="form-control" id="email" name="email" type="email" value="admin@demo.com" required autocomplete="email" autofocus placeholder="{{ __('login.email_placeholder') }}">
                  </div>
                </div>
                <div class="form-group">
                  <label>{{__('login.password')}}</label>
                  <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                    <input class="form-control" id="password" name="password" type="password" required autocomplete="current-password" placeholder="{{__('login.password_placeholder')}}" value="demodemo">
                    <!--<div class="show-hide"><input type="checkbox" onclick="myFunction()"></span></div>-->
                  </div>
                </div>
                <div class="form-group">
                  <div class="checkbox">
                    @if (Route::has('password.request'))
                      <a class="link" href="{{ route('password.request') }}">{{__('login.forgot_password')}}</a>
                    @endif
                  </div>
                </div>

                @error('email')
                <div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>{{__('login.login_error')}}</strong>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @enderror
                @error('password')
                <div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>{{__('login.login_error')}}</strong>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @enderror

                <div class="form-group">
                  <button class="btn btn-primary btn-block" type="submit">{{__('login.sign_in')}}</button>
                </div>

                <div style="color:rgb(128, 128, 128); font-size:80%; margin-bottom:0%; padding:0%" >
                    <span style="font-size: 128%">©</span><span>{{__('constant.copyright')}} <script>document.write(/\d{4}/.exec(Date())[0])</script> {{__('constant.all_rights_reserved')}}.</span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- page-wrapper end-->
    <!-- latest jquery-->
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <!-- Bootstrap js-->
    <script src="{{ asset('assets/js/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('assets/js/height-equal.js') }}"></script>
    <script src="{{ asset('assets/js/tooltip-init.js') }}"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/custom.js') }}"></script>
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>
<script>
    function onSubmit(token) {
      document.getElementById("login-form").submit();
    }
</script>

<!--
@error('email') is-invalid @enderror
@error('password') is-invalid @enderror
@error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
@error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
-->
<!-- <p>Don't have account?<a class="ms-2" href="{{ route('register') }}">Create Account</a></p> -->

<!--

                  <button class="btn btn-primary btn-block g-recaptcha"
                  data-sitekey="reCAPTCHA_site_key"
                  data-callback='onSubmit'
                  data-action='submit' type="submit">{{__('account.sign_in')}}</button>
-->
