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
            <li class="breadcrumb-item"><a href="{{route('job-controller.index',['filter'=>0,'selectedPage'=>1])}}">{{__('job.assigned_jobs')}}</a></li>
            <li class="breadcrumb-item">{{__('job.all_jobs')}}</li>
          </ol>
        </div>
        <div class="col-sm-6">
            <div class="bookmark">
              <ul>
                <li><a href="{{route('job-controller.my-jobs')}}"><button class="btn btn-primary" type="button">{{__('job.my_jobs')}}</button></a></li>
              </ul>
            </div>
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
    <div class="row project-cards">
      <div class="col-md-12 project-list">
        <div class="card">
          <div class="row">
            <div class="col-md-6 p-0">
              <ul class="nav nav-tabs border-tab">
                <li class="nav-item"><a class="nav-link @if (0 == $filter) active @endif" href="{{route('job-controller.index',['filter'=>0,'selectedPage'=>$selectedPage])}}" @if (0 == $filter) aria-selected="true" @else aria-selected="false" @endif><i data-feather="target"></i>{{__('job.all')}}</a></li>
                <li class="nav-item"><a class="nav-link @if (1 == $filter) active @endif" href="{{route('job-controller.index',['filter'=>1,'selectedPage'=>$selectedPage])}}" @if (1 == $filter) aria-selected="true" @else aria-selected="false" @endif><i data-feather="info"></i>{{__('job.continuous')}}</a></li>
                <li class="nav-item"><a class="nav-link @if (2 == $filter) active @endif" href="{{route('job-controller.index',['filter'=>2,'selectedPage'=>$selectedPage])}}" @if (2 == $filter) aria-selected="true" @else aria-selected="false" @endif><i data-feather="check-circle"></i>{{__('job.completed')}}</a></li>
              </ul>
            </div>
            @if (Auth::user()->authority == 'client')
            <div class="col-md-6 p-0">
              <div class="form-group mb-0 me-0"></div><a class="btn btn-primary" href="{{route('job-controller.create')}}"> <i data-feather="plus-square"> </i>{{__('job.create_new_job')}}</a>
            </div>
            @endif
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              @foreach ($jobs as $item)
              <div class="col-xxl-4 col-lg-6">
                <a href="{{route('job-controller.show',$item->id)}}">
                    <div class="project-box" style="height: 90%">
                        @if ($item->status)
                            @if ($item->is_success)
                            <span class="badge badge-primary">{{__('job.successful')}}</span>
                            @else
                            <span class="badge badge-danger">{{__('job.not_successful')}}</span>
                            @endif
                        @else
                        <span class="badge badge-secondary">{{__('job.continuous')}}</span>
                        @endif
                        @if ($item->status)
                            @if ($item->is_success)
                            <h6>{{$item->job_title}}</h6>
                            @else
                            <h6 class="text-danger">{{$item->job_title}}</h6>
                            @endif
                        @else
                        <h6 class="text-secondary">{{$item->job_title}}</h6>
                        @endif
                      <p>{{$item->job_context}}@if(Str::length($item->job_context)>63)... @endif</p>
                      <div class="customers">
                        <ul>
                          @php $userCounter = 0; @endphp
                          @foreach ($item->users as $user)
                            @if($user->image)
                            <li class="d-inline-block"><img class="img-30 rounded-circle" src="{{$user->image}}" alt="" data-original-title="" title=""></li>
                            @else
                            <li class="d-inline-block"><img class="img-30 rounded-circle" src="{{asset('assets/images/constant/user.png')}}" alt="" data-original-title="" title=""></li>
                            @endif
                            @php $userCounter++ @endphp
                            @if($userCounter == 3)
                            @break
                            @endif
                          @endforeach
                          <li class="d-inline-block ms-2">
                            <p class="f-12">{{count($item->users)}} {{__('job.person')}}</p>
                          </li>
                        </ul>
                      </div>
                      @if ($item->status)
                      <div class="project-status mt-4">
                        <div class="media mb-2">
                          @if ($item->is_success)
                          <div class="media-body text-end"><span>{{__('job.completed')}}</span></div>
                          @else
                          <div class="media-body text-end text-danger"><span>{{__('job.completed')}}</span></div>
                          @endif
                        </div>
                        <div class="progress" style="height: 5px">
                            @if ($item->is_success)
                            <div class="progress-bar-animated bg-primary" role="progressbar" style="width: 100%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                            @else
                            <div class="progress-bar-animated bg-danger" role="progressbar" style="width: 100%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                            @endif
                        </div>
                      </div>
                      @else
                      <div class="project-status mt-4">
                        <div class="media mb-2">
                          <div class="media-body text-end text-secondary"><span>{{__('job.continuous')}}</span></div>
                        </div>
                        <div class="progress" style="height: 5px">
                          <div class="progress-bar-animated bg-secondary progress-bar-striped" role="progressbar" style="width: 100%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      @endif
                    </div>
                </a>
              </div>
              @endforeach
            </div>
            <div class="col-xl-12">
              <div class="card mb-0 d-flex justify-content-center">
                  <nav class="my-2" aria-label="Page navigation example">
                    <ul class="pagination justify-content-center pagination-primary">
                      <li class="page-item"><a class="page-link" href="{{route('job-controller.index',['filter'=>$filter,'selectedPage'=>$selectedPage-1])}}" aria-label="Previous"><span aria-hidden="true">«</span><span class="sr-only">{{__('constant.previous')}}</span></a></li>
                      @for ($i = 1; $i <= $pageCount; $i++)
                      <li class="page-item @if ($i == $selectedPage) active @endif"><a class="page-link" href="{{route('job-controller.index',['filter'=>$filter,'selectedPage'=>$i])}}">{{$i}}</a></li>
                      @endfor
                      <li class="page-item"><a class="page-link" href="{{route('job-controller.index',['filter'=>$filter,'selectedPage'=>$selectedPage+1])}}" aria-label="Next"><span aria-hidden="true">»</span><span class="sr-only">{{__('constant.next')}}</span></a></li>
                    </ul>
                  </nav>
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



