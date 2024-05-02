@extends('constant.content')
@section('title',__('message.messages'))

@section('content')
<div class="page-body">
  <div class="container-fluid">
    <div class="page-header">
      <div class="row">
        <div class="col-sm-6">
          <h3>{{__('message.messages')}}</h3>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('message-controller.index',['filter'=>0,'selectedPage'=>1])}}">{{__('message.messages')}}</a></li>
            <li class="breadcrumb-item">{{__('message.inbox')}}</li>
          </ol>
        </div>
        <!--
        <div class="col-sm-6">
            <div class="bookmark">
              <ul>
                <li><a href="{{route('message-controller.index')}}"><button class="btn btn-primary" type="button">{{__('message.inbox')}}</button></a></li>
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
  @elseif(session('auth_error'))
  <script>swal("{{__('constant.error')}}", "{{__('constant.auth_error')}}", "error");</script>
  @elseif (session('cannot_sent_himself'))
  <script>swal("{{__('constant.error')}}", "{{__('message.cannot_sent_himself')}}", "error")</script>
  @elseif (session('url_error'))
  <script>swal("{{__('constant.error')}}", "{{__('constant.url_error')}}", "error")</script>
  @endif
  <!-- Container-fluid starts-->
  <div class="container-fluid">
    <div class="email-wrap">
      <div class="row">
        <div class="col-xl-3 col-md-6 xl-30">
            <div class="email-left-aside">
              <div class="card">
                <div class="card-body">
                  <div class="email-app-sidebar">
                    <div class="media">
                      <div class="media-size-email">
                        @if ($user->p_image)
                        <img class="me-3 rounded-circle" style="max-width:52px;" src="{{asset($user->p_image)}}" alt="">
                        @else
                        <img class="me-3 rounded-circle" style="max-width:52px;" src="{{asset('assets/images/constant/user.png')}}" alt="">
                        @endif

                      </div>
                      <div class="media-body">
                        <h6 class="f-w-600">{{$user->name}}</h6>
                        <p>{{$user->email}}</p>
                      </div>
                    </div>
                    <ul class="nav main-menu" role="tablist">
                      <li class="nav-item"><a class="btn-primary btn-block btn-mail w-100" href="{{route('message-controller.create')}}"><i class="icofont icofont-envelope"></i>{{__('message.new_message')}}</a></li>
                        <li class="nav-item"><a href="{{route('message-controller.index',['filter'=>0,'selectedPage'=>1])}}" type="submit" id="create_user" name="create_user"><span class="title"><i class="icon-import"></i> {{__('message.all')}}</span><span class="badge pull-right">({{$allCount}})</span></a></li>
                        <li class="nav-item"><a href="{{route('message-controller.index',['filter'=>1,'selectedPage'=>1])}}"><span class="title"><i class="icon-email"></i> {{__('message.unread')}}</span><span class="badge pull-right">({{$unreadCount}})</span></a></li>
                        <li class="nav-item"><a href="{{route('message-controller.index',['filter'=>2,'selectedPage'=>1])}}"><span class="title"><i class="icon-new-window"></i> {{__('message.sent')}}</span><span class="badge pull-right">({{$sentCount}})</span></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="col-xl-9 col-md-12 xl-70">
          <div class="email-right-aside">
            <div class="card email-body">
              <div class="email-profile">
                <div>
                  <div class="pe-0 b-r-light"></div>
                  <div class="email-top">
                    <div class="row">
                      <div class="col-12">
                        <div class="media">
                          <div class="media-body">
                            <div class="dropdown">
                                @if (1 == $filter)
                                <h3 class="mb-1">{{__('message.unread_messages')}}</h3>
                                @elseif(2 == $filter)
                                <h3 class="mb-1">{{__('message.sent_messages')}}</h3>
                                @else
                                <h3 class="mb-1">{{__('message.all_messages')}}</h3>
                                @endif
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="inbox">
                    @foreach ($messages as $message)
                    <a href="{{route('message-controller.show',[$message->id])}}">
                        <div class="media">
                            @if (!$message->is_read)
                            <span class="status-circle online"></span>
                            @endif
                        <div class="media-size-email">
                            @if ($message->image)
                            <img class="me-3 rounded-circle" src="{{$message->image}}" alt="">
                            @else
                            <img class="me-3 rounded-circle" src="{{asset('assets/images/constant/user.png')}}" alt="">
                            @endif
                        </div>
                        <div class="media-body">
                            <h6 @if(!$message->is_read) style="font-weight: 800;@if(0 == $message->company_id)color:red;@endif" @else style="font-weight: 400;@if(0 == $message->company_id)color:red;@endif" @endif>{{$message->title}}</h6>
                            <p @if(!Auth::user()->theme) style="color:grey" @elseif($message->is_read) style="color: rgb(32, 32, 32)" @else style="color:rgb(199, 199, 199)" @endif>{{$message->context}}</p><span>{{$message->date}}, {{$message->time}}</span>
                        </div>
                        </div>
                    </a>
                    @endforeach
                  </div>
                  <div class="col-xl-12">
                    <div class="card mb-0 d-flex justify-content-center">
                        <nav class="my-2" aria-label="Page navigation example">
                          <ul class="pagination justify-content-center pagination-primary">
                            <li class="page-item"><a class="page-link" href="{{route('message-controller.index',['filter'=>$filter,'selectedPage'=>$selectedPage-1])}}" aria-label="Previous"><span aria-hidden="true">«</span><span class="sr-only">{{__('constant.previous')}}</span></a></li>
                            @for ($i = 1; $i <= $pageCount; $i++)
                            <li class="page-item @if ($i == $selectedPage) active @endif"><a class="page-link" href="{{route('message-controller.index',['filter'=>$filter,'selectedPage'=>$i])}}">{{$i}}</a></li>
                            @endfor
                            <li class="page-item"><a class="page-link" href="{{route('message-controller.index',['filter'=>$filter,'selectedPage'=>$selectedPage+1])}}" aria-label="Next"><span aria-hidden="true">»</span><span class="sr-only">{{__('constant.next')}}</span></a></li>
                          </ul>
                        </nav>
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
  <!-- Container-fluid Ends-->
</div>
@endsection



