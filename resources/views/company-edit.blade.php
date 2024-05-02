@extends('constant.content')
@section('title',__('company.company_info'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-12">
            <h3>{{__('company.update_company')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('company-controller.edit',Auth::user()->company_id)}}">{{__('company.company_info')}}</a></li>
              <li class="breadcrumb-item">{{__('company.update_company')}}</li>
            </ol>
          </div>
          <!--
          <div class="col-sm-6">
              <div class="bookmark">
                <ul>
                  <li><a href="{{route('user-controller.index')}}"><button class="btn btn-primary" type="button">{{__('constant.back')}}</button></a></li>
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
    @elseif(session('no_company_error'))
    <script>swal("{{__('constant.error')}}", "{{__('company.no_company_error')}}", "error");</script>
    @elseif(session('has_already_company'))
    <script>swal("{{__('constant.error')}}", "{{__('company.has_already_company')}}", "error");</script>
    @elseif(session('auth_error'))
    <script>swal("{{__('constant.error')}}", "{{__('constant.auth_error')}}", "error");</script>
    @endif
    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div class="edit-profile">
        <div class="row">
          <div class="col-xl-12">
            <form class="card needs-validation" novalidate="" action="{{ route('company-controller.update',[$company->id]) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="card-header pb-0">
                <h4 class="card-title mb-0">{{__('company.update_company')}}</h4>
                <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label class="form-label" for="company_name">{{__('company.company_name')}}</label><span class="text-danger">*</span>
                      <input class="form-control" id="company_name" name="company_name" type="text" placeholder="{{__('company.company_name_placeholder')}}" value="{{ $company->company_name }}" required="required">
                      <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                    </div>
                  </div>
                <div class="card-footer text-end">
                <button class="btn btn-primary" id="update_company" name="update_company" type="submit">{{__('constant.save')}}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
</div>
</div>
@endsection
