@extends('constant.content')
@section('title',__('job.job_management'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3>{{__('job.job_management')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('job-controller.index',['filter'=>0,'selectedPage'=>1])}}">{{__('job.jobs')}}</a></li>
              <li class="breadcrumb-item">{{__('job.assign_job')}}</li>
            </ol>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
              <!-- Bookmark Start-->
              <div class="bookmark">
                <ul>
                  <!--<li><a href="#"><i data-feather="plus"></i></a></li>-->
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
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body">
                  <div class="form theme-form">
                    <form class="needs-validation" novalidate="" action="{{ route('job-controller.store') }}" method="POST">
                      @csrf
                      <div class="row">
                        <div class="col">
                          <div class="mb-3">
                            <label class="form-label" for="title">{{__('job.job_title')}}</label><span class="text-danger">*</span>
                            <input class="form-control" id="job_title" name="job_title" type="text" placeholder="{{__('job.job_title')}}" value="{{ old('title') }}" required="required">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('job.job_title_error')}}</div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="col-sm-12">
                              <div class="mb-3">
                                <label class="form-label" for="start_date">{{__('job.start_date')}}</label>
                                <input class="datepicker-here form-control digits" type="text" data-language="tr" id="start_date" name="start_date" readonly
                                placeholder="{{__('job.job_start_date')}}" data-alt-input="true" autocomplete="off" data-date-format="dd MM yyyy" data-alt-format="j F Y" value="{{ old('start_date') }}">
                                <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                              </div>
                          </div>
                          <div class="col-sm-12">
                              <div class="mb-3">
                                <label class="form-label" for="start_date">{{__('job.end_date')}}</label>
                                <input class="datepicker-here form-control digits" type="text" data-language="tr" id="end_date" name="end_date" readonly
                                placeholder="{{__('job.job_end_date')}}" data-alt-input="true" autocomplete="off" data-date-format="dd MM yyyy" data-alt-format="j F Y" value="{{ old('end_date') }}">
                                <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                              </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="mb-3">
                              <label class="form-label" for="selected_users">{{__('job.person_to_assign')}}</label><span class="text-danger">*</span>
                              <select class="form-select digits" id="selected_users[]" name="selected_users[]" multiple required="required">
                                @foreach ($users as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                              </select>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('job.person_to_assign_error')}}</div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="mb-3">
                            <label class="form-label p-0" for="job_context">{{__('job.job_context')}}</label><span class="text-danger">*</span>
                            <textarea class="form-control" id="job_context" name="job_context" rows="8" placeholder="{{__('job.job_context_placeholder')}}" required="required">{{ old('context') }}</textarea>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('job.job_context_error')}}</div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="text-end mt-2">
                            <button class="btn btn-primary" id="create_job" name="create_job" type="submit">{{__('job.create_job')}}</button>
                            <a class="btn btn-danger" href="{{route('job-controller.index',['filter'=>0,'selectedPage'=>1])}}">{{__('constant.back')}}</a>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    <!-- Container-fluid Ends-->
</div>
@endsection
