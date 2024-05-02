@extends('constant.content')
@section('title',__('user.users'))

@section('content')
<div class="page-body">
  <div class="container-fluid">
    <div class="page-header">
      <div class="row">
        <div class="col-sm-6">
          <h3>{{__('user.users')}}</h3>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('user-controller.index')}}">{{__('user.users')}}</a></li>
            <li class="breadcrumb-item">{{__('user.show_users')}}</li>
          </ol>
        </div>
        <div class="col-sm-6 d-flex justify-content-end">
            <!-- Bookmark Start-->
            <div class="bookmark">
              <ul>
                <!--<li><a href="#"><i data-feather="plus"></i></a></li>-->
                <li><a href="{{route('user-controller.create')}}"><button class="btn btn-primary" type="button">{{__('user.add_new')}}</button></a></li>
              </ul>
            </div>
            <!-- Bookmark Ends-->
        </div>
      </div>
    </div>
  </div>
  <!-- Sweet Alert -->
  @if(session('success'))
  <script>swal("{{__('constant.success')}}", "{{__('constant.successful')}}", "success");</script>
  @elseif(session('error'))
  <script>swal("{{__('constant.error')}}", "{{__('constant.unsuccessful')}}", "error");</script>
  @elseif (session('own'))
  <script>swal("{{__('constant.error')}}", "{{__('user.cannot_freeze_self')}}", "error")</script>
  @elseif (session('role'))
  <script>swal("{{__('constant.error')}}", "{{__('user.cannot_freeze_higher')}}", "error")</script>
  @elseif (session('auth_error'))
  <script>swal("{{__('constant.error')}}", "{{__('constant.auth_error')}}", "error")</script>
  @endif
  <!-- Container-fluid starts-->
    <div class="container-fluid user-card">
      <div class="row">
        @foreach ($users as $user)
        <div class="col-md-6 col-lg-6 col-xl-4 box-col-6">
          <div class="card custom-card">
            <a href="{{route('user-controller.edit',[$user->id])}}">
                @if ($user->p_image)
                <div class="card-profile mt-2"><img class="rounded-circle" src="{{asset($user->p_image)}}" alt=""></div>
                @else
                <div class="card-profile mt-2"><img class="rounded-circle" src="{{asset('assets/images/constant/user.png')}}" alt=""></div>
                @endif
            </a>
            <ul class="card-social">
              <!--<li><a href="#"><i data-feather="book-open"></i></a></li>-->
              @if ($user->id != Auth::id())
              <li><a href="{{route('message-controller.edit',[$user->id])}}"><i data-feather="send"></i></a></li>
              @endif
              <li><a href="mailto:{{$user->email}}"><i data-feather="mail"></i></a></li>
              <li><a href="tel:{{$user->phone}}"><i data-feather="phone"></i></a></li>
              <li><a href="{{route('user-controller.edit',[$user->id])}}"><i data-feather="settings"></i></a></li>
            </ul>
            <div class="text-center profile-details mt-2"><a href="{{route('user-controller.edit',[$user->id])}}">
              <h4>{{$user->name}}</h4></a>
              @if ($user->department)
                <h6>{{$user->department}}</h6>
              @else
                  <h6>{{__('user.no_department')}}</h6>
              @endif
            </div>
            <div class="card-footer row">
              <div class="col-6 col-sm-6">
                <h6>{{__('user.is_active')}}</h6>
                <h3><span>
                    @if ($user->is_active)
                        <div>{{__('user.active')}}</div>
                    @else
                        <div>{{__('user.passive')}}</div>
                    @endif
                </span></h3>
              </div>
              <div class="col-6 col-sm-6">
                <h6>{{__('user.total_activity')}}</h6>
                <h3><span class="counter">{{$user->work_count}}</span></h3>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  <!-- Container-fluid Ends-->
</div>
@endsection



