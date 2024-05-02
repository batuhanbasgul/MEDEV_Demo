@extends('constant.content')
@section('title',__('message.messages'))

@section('content')
<div class="page-body">
  <div class="container-fluid">
    <div class="page-header">
      <div class="row">
        <div class="col-sm-12">
          <h3>{{__('message.messages')}}</h3>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('message-controller.index',['filter'=>0,'selectedPage'=>1])}}">{{__('message.messages')}}</a></li>
            <li class="breadcrumb-item">{{__('message.send_message')}}</li>
          </ol>
        </div>
        <!--
        <div class="col-sm-6">
            <div class="bookmark">
              <ul>
                <li><a href="{{route('user-controller.create')}}"><button class="btn btn-primary" type="button">Seçilillere Gönder</button></a></li>
                <li><a href="{{route('user-controller.create')}}"><button class="btn btn-primary" type="button">Herkese Gönder</button></a></li>
              </ul>
            </div>
        </div>
        -->
      </div>
    </div>
  </div>
  <!-- Sweet Alert -->
  @if(session('success'))
  <script>swal("{{__('constant.success')}}", "{{__('constant.successful')}}", "success");</script>
  @elseif(session('error'))
  <script>swal("{{__('constant.error')}}", "{{__('constant.unsuccessful')}}", "error");</script>
  @endif
  <!-- Container-fluid starts-->
    <div class="container-fluid user-card">
      <div class="row">
        <a href="{{route('message-controller.edit',[0])}}">
            <div class="col-md-3 col-lg-3 col-xl-3 box-col-3">
              <div class="card custom-card">
                <a href="{{route('message-controller.edit',[0])}}">
                    <div class="card-profile mt-2"><img class="rounded-circle" src="{{asset('assets/images/constant/users.png')}}" alt=""></div>
                </a>
                <div class="text-center profile-details mt-2"><a href="{{route('message-controller.edit',[0])}}">
                  <h4>{{__('message.send_everyone')}}</h4></a>
                  <h6>{{__('message.everyone')}}</h6>
                </div>
              </div>
            </div>
        </a>
        @foreach ($users as $user)
        @if($user->id != Auth::id())
        <div class="col-md-3 col-lg-3 col-xl-3 box-col-3">
          <div class="card custom-card">
            <a href="{{route('message-controller.edit',[$user->id])}}">
                @if ($user->p_image)
                <div class="card-profile mt-2"><img class="rounded-circle" src="{{asset($user->p_image)}}" alt=""></div>
                @else
                <div class="card-profile mt-2"><img class="rounded-circle" src="{{asset('assets/images/constant/user.png')}}" alt=""></div>
                @endif
            </a>
            <div class="text-center profile-details mt-2"><a href="{{route('message-controller.edit',[$user->id])}}">
              <h4>{{$user->name}}</h4></a>
              @if ($user->department)
                <h6>{{$user->department}}</h6>
              @else
                  <h6>{{__('message.no_department')}}</h6>
              @endif
            </div>
          </div>
        </div>
        @endif
        @endforeach
      </div>
    </div>
  <!-- Container-fluid Ends-->
</div>
@endsection



