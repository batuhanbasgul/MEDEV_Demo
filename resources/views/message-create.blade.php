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
            <li class="breadcrumb-item">{{__('message.send_message')}}</li>
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
      <form action="{{ route('message-controller.store') }}" method="POST">
        @csrf
        <input type="hidden" name="publish" value="{{ $publish }}">
        @if ($publish)
        <input type="hidden" name="sent_to" value="0">
        @else
        <input type="hidden" name="sent_to" value="{{ $sent_to->id }}">
        @endif
        <div class="row">
          <div class="col-xl-3 col-md-6 xl-30">
            <div class="email-left-aside">
              <div class="card">
                <div class="card-body">
                  <div class="email-app-sidebar">
                    <div class="media">
                        @if ($publish)
                            <div class="media-size-email">
                                @if ($current_user->p_image)
                                <img class="me-3 rounded-circle" style="max-width:52px;" src="{{asset($current_user->p_image)}}" alt="">
                                @else
                                <img class="me-3 rounded-circle" style="max-width:52px;" src="{{asset('assets/images/constant/user.png')}}" alt="">
                                @endif
                            </div>
                            <div class="media-body">
                            <h6 class="f-w-600">{{$current_user->name}}</h6>
                            <p>{{$current_user->email}}</p>
                            </div>
                        @else
                            <div class="media-size-email">
                                @if ($sent_to->p_image)
                                <img class="me-3 rounded-circle" style="max-width:52px;" src="{{asset($sent_to->p_image)}}" alt="">
                                @else
                                <img class="me-3 rounded-circle" style="max-width:52px;" src="{{asset('assets/images/constant/user.png')}}" alt="">
                                @endif
                            </div>
                            <div class="media-body">
                            <h6 class="f-w-600">{{$sent_to->name}}</h6>
                            <p>{{$sent_to->email}}</p>
                            </div>
                        @endif
                    </div>
                    @if (!$publish)
                    <div class="card-header py-3 px-0">
                      <a href="{{route('message-controller.edit',[0])}}"><button class="btn btn-primary" type="button" style="width: 100%">{{__('message.send_everyone')}}</button></a>
                    </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-9 col-md-12 xl-70">
            <div class="email-right-aside">
              <div class="card email-body">
                <div class="email-profile">
                  <div class="email-body">
                    <div class="email-compose">
                      <div class="email-top compose-border">
                        <div class="compose-header">
                          <h4 class="mb-0">{{__('message.new_message')}}</h4>
                        </div>
                      </div>
                      <div class="email-wrapper">
                        <div class="form-group">
                          <label class="col-form-label pt-0" for="exampleInputEmail1">{{__('message.send_to')}}</label>
                          @if ($publish)
                          <input class="form-control" id="exampleInputEmail1" type="text" value="{{__('message.everyone')}}">
                          @else
                          <input class="form-control" id="exampleInputEmail1" type="text" value="{{$sent_to->name}}">
                          @endif
                        </div>
                        <div class="form-group">
                          <label class="form-label" for="title">{{__('message.title')}}</label>
                          <input class="form-control" id="title" name="title" type="text" placeholder="{{__('message.message_title')}}" value="{{ old('title') }}">
                        </div>
                        <div class="mb-4">
                          <label class="form-label p-0" for="context">{{__('message.context')}}</label>
                          <textarea class="form-control" id="context" name="context" rows="8" placeholder="{{__('message.write_message')}}">{{ old('context') }}</textarea>
                        </div>
                        <div class="action-wrapper">
                          <ul class="actions">
                            <li><button class="btn btn-primary" id="create_message" name="create_message" type="submit">{{__('message.send')}}</button></li>
                            <li><a class="btn btn-danger" href="{{route('message-controller.index',['filter'=>0,'selectedPage'=>1])}}">{{__('constant.delete')}}</a></li>
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
      </form>
    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>
@endsection



