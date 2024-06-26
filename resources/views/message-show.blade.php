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
            <li class="breadcrumb-item">{{$message->sender_name}}</li>
            <li class="breadcrumb-item">{{$message->title}}</li>
          </ol>
        </div>
        <div class="col-sm-6 d-flex justify-content-end">
            <!-- Bookmark Start-->
            <div class="bookmark">
              <ul>
                <!--<li><a href="#"><i data-feather="plus"></i></a></li>-->
                <li><a href="{{route('message-controller.index',['filter'=>0,'selectedPage'=>1])}}"><button class="btn btn-primary" type="button">{{__('message.inbox')}}</button></a></li>
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
  @elseif(session('cannot_sent_himself'))
  <script>swal("{{__('constant.error')}}", "{{__('message.cannot_sent_himself')}}", "error");</script>
  @elseif (session('auth_error'))
  <script>swal("{{__('constant.error')}}", "{{__('constant.auth_error')}}", "error")</script>
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
                  <div class="email-right-aside">
                    <div class="email-body">
                      <div class="email-content">
                        <div class="email-top">
                          <div class="row">
                            <div class="col-xl-12">
                              <div class="media">
                                @if ($message->image)
                                <img class="me-3 rounded-circle" style="max-width: 50px;" src="{{asset($message->image)}}" alt="">
                                @else
                                <img class="me-3 rounded-circle" style="max-width: 50px;" src="{{asset('assets/images/constant/user.png')}}" alt="">
                                @endif
                                <div class="media-body">
                                  <h6 class="d-block">{{$message->sender_name}}</h6>
                                  @if ($message->sender_department)
                                  <p>{{$message->sender_department}}</p>
                                  @else
                                  <p>{{__('message.no_department')}}</p>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="email-wrapper">
                          <div class="emailread-group">
                            <div class="read-group">
                              <h5>{{$message->title}}</h5>
                              <p>{{$message->context}}</p>
                            </div>
                          </div>
                          <!--
                          <div class="emailread-group">
                            <h6 class="text-muted mb-0"><i class="icofont icofont-clip"></i> ATTACHMENTS</h6><a class="text-muted text-end right-download font-primary f-w-600" href="#"><i class="fa fa-long-arrow-down me-2"></i>Download All</a>
                            <div class="clearfix"></div>
                            <div class="attachment">
                              <ul>
                                <li><img class="img-fluid" src="../assets/images/email/1.jpg" alt=""></li>
                                <li><img class="img-fluid" src="../assets/images/email/2.jpg" alt=""></li>
                                <li><img class="img-fluid" src="../assets/images/email/3.jpg" alt=""></li>
                              </ul>
                            </div>
                          </div>
                          -->
                          <div class="emailread-group">
                            <div class="action-wrapper">
                              <ul class="actions">
                                <li><a class="btn btn-primary" href="{{route('message-controller.edit',[$message->sender_id])}}"><i class="fa fa-reply me-2"></i>{{__('message.reply')}}</a></li>
                              </ul>
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
    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>
@endsection



