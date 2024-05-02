@extends('constant.content')
@section('title',__('user.create_user'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3>{{__('user.create_user')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('user-controller.index')}}">{{__('user.users')}}</a></li>
              <li class="breadcrumb-item">{{__('user.create_user')}}</li>
            </ol>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
              <!-- Bookmark Start-->
              <div class="bookmark">
                <ul>
                  <!--<li><a href="#"><i data-feather="plus"></i></a></li>-->
                  <li><a href="{{route('user-controller.index')}}"><button class="btn btn-primary" type="button">{{__('constant.back')}}</button></a></li>
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
    @elseif(session('email_error'))
    <script>swal("{{__('constant.error')}}", "{{__('user.email_inuse')}}", "error");</script>
    @elseif(session('password_error'))
    <script>swal("{{__('constant.error')}}", "{{__('user.password_unmatched')}}", "error");</script>
    @endif
    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div class="edit-profile">
        <div class="row">
          <div class="col-xl-12">
            <form class="card needs-validation" novalidate="" action="{{ route('user-controller.store') }}" method="POST">
              @csrf
              <div class="card-header pb-0">
                <h4 class="card-title mb-0">{{__('user.create_user')}}</h4>
                <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label class="form-label" for="email">{{__('user.mail')}}</label><span class="text-danger"> *</span>
                      <input class="form-control" id="email" name="email" type="email" placeholder="{{__('user.mail_placeholder')}}" value="{{ old('email') }}" required="required">
                      <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                      <div class="invalid-feedback px-1">{{__('user.proper_mail')}}</div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label class="form-label" for="password">{{__('user.password')}}</label><span class="text-danger">*</span>
                      <input class="form-control" id="password" name="password" pattern=".{6,12}" type="text" placeholder="{{__('user.password_placeholder')}}" value="{{ old('password') }}" required="required">
                      <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                      <div class="invalid-feedback px-1">{{__('user.proper_password')}}</div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label class="form-label" for="confirm_password">{{__('user.confirm_password')}}</label><span class="text-danger">*</span>
                      <input class="form-control" id="confirm_password" name="confirm_password" pattern=".{6,12}" type="text" placeholder="{{__('user.confirm_password_placeholder')}}" value="{{ old('confirm_password') }}" required="required">
                      <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                      <div class="invalid-feedback px-1">{{__('user.proper_confirm_password')}}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="name">{{__('user.name')}}</label><span class="text-danger"> *</span>
                      <input class="form-control" id="name" name="name" type="text" placeholder="{{__('user.name_placeholder')}}" value="{{ old('name') }}" required="required">
                      <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                      <div class="invalid-feedback px-1">{{__('user.proper_name')}}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="phone">{{__('user.phone')}}</label><span class="text-danger">*</span>
                      <input class="form-control" id="phone" name="phone" type="tel" pattern="[0-9]+" placeholder="{{__('user.phone_placeholder')}}" value="{{ old('phone') }}" required="required">
                      <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                      <div class="invalid-feedback px-1">{{__('user.proper_phone')}}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="department">{{__('user.department')}}</label>
                      <input class="form-control" id="department" name="department" type="text" placeholder="{{__('user.department_placeholder')}}" value="{{ old('department') }}">
                      <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="authority">{{__('user.authority')}}</label><span class="text-danger">*</span>
                      <select class="form-control btn-square" id="authority" name="authority" required="required">
                        <option value="">{{__('user.authority_placeholder')}}</option>
                        <option value="client" @if(old('authority') == 'client') selected @endif >{{__('user.client')}}</option>
                        <option value="subclient" @if(old('authority') == 'subclient') selected @endif >{{__('user.subclient')}}</option>
                        <option value="temporary" @if(old('authority') == 'temporary') selected @endif >{{__('user.temporary')}}</option>
                      </select>
                      <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                      <div class="invalid-feedback px-1">{{__('constant.choose')}}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="start_date">{{__('user.start_date')}}</label>
                      <input class="datepicker-here form-control digits" type="text" data-language="tr" id="start_date" name="start_date" readonly
                      placeholder="{{__('user.start_date_placeholder')}}" data-alt-input="true" autocomplete="off" data-date-format="dd MM yyyy" data-alt-format="j F Y" value="{{ old('start_date') }}">
                      <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                    </div>
                  </div>
                <div class="card-footer text-end">
                <button class="btn btn-primary" id="create_user" name="create_user" type="submit">{{__('user.create_user')}}</button>
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
