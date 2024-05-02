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
              <li class="breadcrumb-item">{{__('department.edit_department')}}</li>
            </ol>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
              <!-- Bookmark Start-->
              <div class="bookmark">
                <ul>
                  <!--<li><a href="#"><i data-feather="plus"></i></a></li>-->
                  <li><a href="{{route('department-controller.destroy',$department->id)}}"><button class="btn btn-danger" onclick="return confirm('{{__('department.sure_to_destroy')}}')" type="button">{{__('department.destroy_department')}}</button></a></li>
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
    @elseif(session('auth_error'))
    <script>swal("{{__('constant.error')}}", "{{__('constant.auth_error')}}", "error");</script>
    @elseif(session('device_count'))
    <script>swal("{{__('constant.error')}}", "{{__('department.device_count')}}", "error");</script>
    @endif
    <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body">
                  <div class="form theme-form">
                    <form class="needs-validation" novalidate="" action="{{ route('department-controller.update',$department->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="row">
                        <div class="col-12 col-sm-6">
                          <div class="mb-3">
                            <label class="form-label" for="type">{{__('department.department_name')}}</label><span class="text-danger">*</span>
                            <input class="form-control" id="name" name="name" type="text" placeholder="{{__('department.department_name')}}" required="required" value="{{ $department->name }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('department.enter_department_name')}}</div>
                          </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-3">
                              <label class="form-label" for="corporation_id">{{__('department.corporation_name')}}<span class="text-danger">*</span></label>
                              <div>
                                <select class="form-select digits" id="corporation_id" name="corporation_id" required="required">
                                  <option value="" disabled selected>{{__('constant.choose')}}</option>
                                  @php $i=0 @endphp
                                  @foreach ($corporations as $item)
                                  <option @if($item->id == $department->corporation_id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                  @php $i=$i+1; @endphp
                                  @endforeach
                                </select>
                                <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                                <div class="invalid-feedback px-1">{{__('department.choose_corporation')}}</div>
                              </div>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                          <div class="mb-3">
                            <label class="form-label" for="person">{{__('department.person_name')}}</label><span class="text-danger">*</span>
                            <input class="form-control" id="person" name="person" type="text" placeholder="{{__('department.department_person')}}" required="required" value="{{ $department->person }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('department.department_person')}}</div>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="mb-3">
                            <label class="form-label" for="contact">{{__('department.person_contact')}}</label><span class="text-danger">*</span>
                            <input class="form-control" id="contact" name="contact" type="tel" pattern="[0-9]+" placeholder="{{__('department.person_contact_placeholder')}}" required="required" value="{{ $department->contact }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('department.enter_person_contact')}}</div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="text-end mt-2">
                            <button class="btn btn-primary" id="edit_department" name="edit_department" type="submit">{{__('constant.update')}}</button>
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
