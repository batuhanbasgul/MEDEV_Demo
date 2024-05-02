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
    <title>{{__('user.passive_account')}}</title>
    <!-- CSS only -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Staatliches&display=swap');
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

    <style>
        .box {
            color: black;
            font-family: 'Staatliches', cursive;
            text-align: center;
            font-size: 40px;
            margin: 5% auto auto auto;
        }
        .text-box{
            background-color:rgba(255, 255, 255, 0.33);
            border-radius: 50%;
        }
        .icon{
            margin-top: 5%;
            margin-bottom: 5%;
            border-radius: 5%;
            max-width: 150px;
        }
    </style>
</head>
<body style="background-color: whitesmoke; background-image:url({{ asset('assets/images/background/snow.png') }});">
    <div class="row">
        <div class="col-1 col-xl-2"></div>
        <div class="col-10 col-xl-8">
            <div class="box">
                <img class="icon" src="{{ asset('assets/images/logo/icon-logo.png') }}" alt="">
                <h1 class="text-box">{{__('user.passive_title')}}</h1>
                <h3 class="text-box">{{__('user.passive_text')}}</h3>
                <a href="{{ route('index') }}"><button type="button" class="btn btn-lg btn-secondary mt-4" style="padding: 1% 10% 1% 10%">{{__('user.login_page')}}</button></a>
            </div>
        </div>
        <div class="col-1 col-xl-2"></div>
    </div>
</body><!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</html>
