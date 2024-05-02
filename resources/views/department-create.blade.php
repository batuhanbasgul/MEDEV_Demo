@extends('constant.content')
@section('title',__('department.departments'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3>{{__('department.departments')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('department-controller.index')}}">{{__('department.departments')}}</a></li>
              <li class="breadcrumb-item">{{__('department.create_department')}}</li>
            </ol>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
              <!-- Bookmark Start-->
              <div class="bookmark">
                <ul>
                  <!--<li><a href="#"><i data-feather="plus"></i></a></li>-->
                  <li><a href="{{route('department-controller.index')}}"><button class="btn btn-primary" type="button">{{__('constant.back')}}</button></a></li>
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
  @endif
    <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body">
                  <div class="form theme-form">
                    <form class="needs-validation" novalidate="" action="{{ route('department-controller.store') }}" method="POST">
                      @csrf
                      <div class="row">
                        <div class="row mb-3">
                          <label class="form-label" for="corporation_id">{{__('department.corporation_name')}}<span class="text-danger">*</span></label>
                          <div class="col col-12 col-sm-8 col-md-9 col-xl-10 mt-2">
                            <select class="form-select digits" id="corporation_id" name="corporation_id" required="required">
                              <option value="" disabled selected>{{__('department.choose')}}</option>
                              @foreach ($corporations as $item)
                              <option value="{{$item->id}}">{{$item->name}}</option>
                              @endforeach
                            </select>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('department.choose_or_create_corporation')}}</div>
                          </div>
                          <div class="col col-12 col-sm-4 col-md-3 col-xl-2 mt-2">
                              <a href="{{route('corporation-controller.create')}}"><button class="btn btn-primary" style="width: 100%" type="button">{{__('department.new_corporation')}}</button></a>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col col-12 col-md-4 col-xl-6">
                          <div class="mb-3">
                            <label class="form-label" for="name">{{__('department.department_name')}}</label><span class="text-danger">*</span>
                            <input class="form-control" id="name" name="name" type="text" required="required" placeholder="{{__('department.enter_department_name')}}" value="{{ old('name') }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('department.enter_department_name')}}</div>
                          </div>
                        </div>
                        <div class="col col-12 col-md-4 col-xl-3">
                          <div class="mb-3">
                            <label class="form-label" for="person">{{__('department.person_name')}}</label><span class="text-danger">*</span>
                            <input class="form-control" id="person" name="person" type="text" placeholder="{{__('department.department_person')}}" required="required" value="{{ old('person') }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('department.enter_person_name')}}</div>
                          </div>
                        </div>
                        <div class="col col-12 col-md-4 col-xl-3">
                          <div class="mb-3">
                            <label class="form-label" for="contact">{{__('department.person_contact')}}</label><span class="text-danger">*</span>
                            <input class="form-control" id="contact" name="contact" type="tel" pattern="[0-9]+" placeholder="{{__('department.person_contact_placeholder')}}" value="{{ old('contact') }}" required="required">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('department.proper_phone')}}</div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="text-end mt-2">
                            <button class="btn btn-primary" id="create_department" name="create_department" type="submit">{{__('department.create_department')}}</button>
                            <a class="btn btn-danger" href="{{route('department-controller.index')}}">{{__('constant.back')}}</a>
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
