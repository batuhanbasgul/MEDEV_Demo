@extends('constant.content')
@section('title',__('job.jobs'))

@section('content')
<div class="page-body">
  <div class="container-fluid">
    <div class="page-header">
      <div class="row">
        <div class="col-sm-6">
          <h3>{{__('job.jobs')}}</h3>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('job-controller.index',['filter'=>0,'selectedPage'=>1])}}">{{__('job.jobs')}}</a></li>
            <li class="breadcrumb-item">{{__('job.view_job')}}</li>
          </ol>
        </div>
        <div class="col-sm-6">
            <!-- Bookmark Start-->
            <div class="bookmark">
              <ul>
                @if (Auth::id() == $job->assigned_from)
                <li onclick="return confirm('{{__('job.destroy_question')}}')">
                    <a href="{{ route('job-controller.destroy', $job->id) }}">
                      <button type="button" class="btn btn-danger mx-auto">
                        <span>{{__('job.destroy_job')}}</span>
                      </button>
                    </a>
                </li>
                <li><a href="{{route('job-controller.edit',$job->id)}}"><button class="btn btn-secondary" type="button">{{__('job.edit_job')}}</button></a></li>
                @endif
                <li><a href="{{route('job-controller.index',['filter'=>0,'selectedPage'=>1])}}"><button class="btn btn-primary" type="button">{{__('constant.back')}}</button></a></li>
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
  @elseif(session('auth_error'))
  <script>swal("{{__('constant.error')}}", "{{__('constant.auth_error')}}", "error");</script>
  @elseif(session('url_error'))
  <script>swal("{{__('constant.url_error')}}", "{{__('constant.url_error')}}", "error");</script>
  @endif
  <!-- Container-fluid starts-->
  <div class="container-fluid">
    <div class="email-wrap">
      <div class="row">
        <div class="col-xl-12 col-md-12 xl-70">
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
                                @if ($assigned_from->p_image)
                                <img class="me-3 rounded-circle" style="max-width:50px;" src="{{asset($assigned_from->p_image)}}" alt="">
                                @else
                                <img class="me-3 rounded-circle" style="max-width:50px;" src="{{asset('assets/images/constant/user.png')}}" alt="">
                                @endif
                                <div class="media-body">
                                  <h6 class="d-block">{{$assigned_from->name}}</h6>
                                  @if ($assigned_from->department)
                                  <p>{{$assigned_from->department}}</p>
                                  @else
                                  <p>{{__('job.no_department')}}</p>
                                  @endif
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="email-wrapper">
                          <div class="emailread-group">
                            <div class="read-group">
                              <h3 class="mb-4">{{$job->job_title}}</h3>
                              <p class="mb-4">{{$job->job_context}}</p>
                              <p class="mt-2"><span class="text-bold">{{__('job.date_gap')}} : </span>{{$job->start_date}} - {{$job->end_date}}</p>
                              <p class="mt-2"><span class="text-bold">{{__('job.assigned_person_count')}} : </span>{{$user_count}}</p>
                              <p class="mt-2"><span class="text-bold">{{__('job.status')}} : </span> @if ($job->status) {{__('job.completed')}} @else {{__('job.uncompleted')}} @endif </p>
                            </div>
                          </div>
                          @if(!$job->status && $is_assigned_to_user)
                          <div class="emailread-group">
                            <div class="action-wrapper">
                              <ul class="actions">
                                  <div class="row">
                                    <div class="col-sm-6 mb-2">
                                        <form action="{{ route('job-controller.update',[$job->id]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                            <button class="btn btn-primary" style="width: 100%" id="completed" name="completed" type="submit">{{__('job.completed')}}</button>
                                        </form>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <div class="nav-item">
                                            <button class="btn btn-danger" style="width: 100%" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal2">{{__('job.uncompleted')}}</button>
                                            <div class="modal fade modal-bookmark" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel2">{{__('job.unsuccess_reason')}}</h5>
                                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                    <form class="form-bookmark needs-validation" novalidate="" action="{{ route('job-controller.update',[$job->id]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3 col-md-12 mt-0">
                                                            <textarea class="form-control" id="unsuccess_reason" name="unsuccess_reason" rows="8" placeholder="{{__('job.job_context_placeholder')}}" required="required">{{ old('context') }}</textarea>
                                                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                                                        </div>
                                                        <button class="btn btn-primary" type="submit" id="uncompleted" name="uncompleted">{{__('constant.save')}}</button>
                                                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('constant.back')}}</button>
                                                    </form>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                              </ul>
                            </div>
                          </div>
                          @endif
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



