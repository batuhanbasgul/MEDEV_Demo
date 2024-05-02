@extends('constant.content')
@section('title',__('user.edit_user'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3>{{__('user.edit_user')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('user-controller.index')}}">{{__('user.users')}}</a></li>
              <li class="breadcrumb-item">{{__('user.edit_user')}}</li>
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
    @elseif (session('own'))
    <script>swal("{{__('constant.error')}}", "{{__('user.cannot_freeze_self')}}", "error")</script>
    @elseif (session('role'))
    <script>swal("{{__('constant.error')}}", "{{__('user.cannot_freeze_higher')}}", "error")</script>
    @elseif (session('error_pwd'))
    <script>swal("{{__('constant.error')}}", "{{__('user.password_unmatched')}}", "error")</script>
    @elseif (session('old_pwd'))
    <script>swal("{{__('constant.error')}}", "{{__('user.wrong_old_password')}}", "error")</script>
    @elseif (session('wrong_pwd'))
    <script>swal("{{__('constant.error')}}", "{{__('user.wrong_password')}}", "error")</script>
    @elseif (session('file_extension_error'))
    <script>swal("{{__('constant.error')}}", "{{__('user.file_extension_error')}}", "error")</script>
    @elseif (session('file_size_error'))
    <script>swal("{{__('constant.error')}}", "{{__('user.file_size_error')}}", "error")</script>
    @endif
    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div class="edit-profile email-wrap bookmark-wrap">
        <div class="row">
            <div class="col-xl-3 xl-30">
                <div class="card">
                  <div class="card-body">
                    <div class="email-app-sidebar left-bookmark">
                      <div class="media">
                        @if ($user->p_image)
                        <div class="media-size-email"><img class="me-3 rounded-circle" style="max-width:52px;" src="{{ asset($user->p_image) }}" alt=""></div>
                        @else
                        <div class="media-size-email"><img class="me-3 rounded-circle" style="max-width:52px;" src="{{asset('assets/images/constant/user.png')}}" alt=""></div>
                        @endif
                        <div class="media-body mb-4">
                            <h6 class="f-w-700">{{$user->name}}</h6>
                            <p>{{$user->email}}</p>
                        </div>
                      </div>
                        <ul class="nav main-menu contact-options" role="tablist">
                            @if (Auth::id() == $user->id)
                                <li class="nav-item">
                                    <button class="badge-light btn-block btn-mail w-100 mb-0" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="me-3" data-feather="image"></i>{{__('user.upload_image')}}</button>
                                    <div class="modal fade modal-bookmark" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{{__('user.upload_image')}}</h5>
                                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('user-controller.update',[$user->id]) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <!-- Image Cropper -->
                                                <div class="row items-push d-flex align-items-stretch">
                                                    <div class="col-xxl-6">
                                                    <h4 class="border-bottom pb-2">{{__('user.profile_image')}}</h4>
                                                    <!--
                                                        RATIO & WIDTH Ayarları.
                                                    -->
                                                    <input type="hidden" class="img-w" value="{{ $imageManager->width }}">
                                                    <input type="hidden" class="img-h" value="{{ $imageManager->height }}">
                                                    <input type="hidden" class="ratio" value="{{ $imageManager->ratio }}">
                                                    <div class="original text-center">
                                                        @if ($user->p_image)
                                                        <img id="js-img-cropper" class="img-fluid" src="{{ asset($user->p_image) }}" alt="photo">
                                                        @else
                                                        <img id="js-img-cropper" class="img-fluid" src="{{ asset('assets/images/constant/user.png') }}" alt="photo">
                                                        @endif
                                                    </div>
                                                    <div class="text-center">
                                                        <p class="my-2" class="fw-ligth">{{ $imageManager->width }}x{{ $imageManager->height }} px</p>
                                                    </div>
                                                    <div id="box" class="block-content text-center d-none cropper-buttons">
                                                        <div class="row">
                                                        <button type="button" class="btn btn-primary crop" data-toggle="cropper"
                                                        data-method="crop">
                                                        {{__('user.crop_image')}}
                                                        </button>
                                                        </div>
                                                    </div>
                                                    <div class="my-4">
                                                        <input type="file" class="form-control" id="image" name="p_image" accept="image/*">
                                                        <small class="fw-light text-gray-dark">{{__('user.file_mimes')}}</small>
                                                        <input type="hidden" name="cropped_data" id="cropped_data"> <!--base64 data transferi-->
                                                    </div>
                                                    </div>

                                                    <div id="box-2" class="col-xxl-6 d-none">
                                                    <h4 class="border-bottom pb-2">{{__('user.preview')}}</h4>
                                                    <!--rightbox-->
                                                    <div class="img-result text-center">
                                                        <!-- result of crop -->
                                                        <img class="cropped img-fluid cropped-preview" src="" alt="">
                                                    </div>
                                                    <div class="row">
                                                        <input type="submit" class="btn btn-lg btn-primary updateimagebutton" id="updatepimage" name="updatepimage" value="{{__('user.upload_image')}}">
                                                    </div>
                                                    </div>
                                                </div>
                                                <!-- END Image Cropper -->
                                                </form>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            <li class="nav-item">
                                <button class="badge-light btn-block btn-mail w-100 mb-0" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="me-3" data-feather="lock"></i>{{__('user.change_password')}}</button>
                                <div class="modal fade modal-bookmark" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel2">{{__('user.change_password')}}</h5>
                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <form class="form-bookmark needs-validation" novalidate="" action="{{ route('user-controller.update',[$user->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row g-2">
                                            <div class="mb-3 col-md-12 mt-0">
                                                <label class="form-label" for="old_password">{{__('user.old_password')}}</label>
                                                <input class="form-control" id="old_password" name="old_password" type="text" pattern=".{6,12}" required="" autocomplete="off" placeholder="{{__('user.old_password_placeholder')}}">
                                                <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                                                <div class="invalid-feedback px-1">{{__('user.enter_old_password')}}</div>
                                            </div>
                                            <div class="mb-3 col-md-12 mt-0">
                                                <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="form-label" for="con-name">{{__('user.new_password')}}</label>
                                                    <input class="form-control" id="password" name="password" type="text" pattern=".{6,12}" required="" placeholder="{{__('user.new_password_placeholder')}}" autocomplete="off">
                                                    <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                                                    <div class="invalid-feedback px-1">{{__('user.proper_password')}}</div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="form-label" for="con-name">{{__('user.confirm_password')}}</label>
                                                    <input class="form-control" id="confirm_password" name="confirm_password" type="text" pattern=".{6,12}" required="" placeholder="{{__('user.confirm_password_placeholder')}}" autocomplete="off">
                                                    <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                                                    <div class="invalid-feedback px-1">{{__('user.proper_confirm_password')}}</div>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                            <button class="btn btn-primary" type="submit" id="change_password" name="change_password">{{__('constant.save')}}</button>
                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('constant.back')}}</button>
                                        </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item">
                                <button class="badge-light btn-block btn-mail w-100" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal3">
                                    @if ($user->is_active)
                                    <i class="me-3" data-feather="thermometer"></i>{{__('user.freeze_user')}}
                                    @else
                                    <i class="me-3" data-feather="sun"></i>{{__('user.activate_user')}}
                                    @endif
                                    </button>
                                <div class="modal fade modal-bookmark" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel3">{{__('user.need_permission')}}</h5>
                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                        <form class="form-bookmark needs-validation" novalidate="" action="{{ route('user-controller.update',[$user->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row g-2">
                                                <div class="mb-3 col-md-12 mt-0">
                                                    <label class="form-label" for="password">{{__('user.enter_account_password')}}</label>
                                                    <input class="form-control" id="password" name="password" type="text" pattern=".{6,12}" required="" autocomplete="off" placeholder="Hesap Şifreniz">
                                                    <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                                                    <div class="invalid-feedback px-1">{{__('user.enter_account_password_placeholder')}}</div>
                                                </div>
                                            </div>
                                            <input id="user_id" name="user_id" type="hidden" value="{{$user->id}}">
                                            <button class="btn btn-primary" type="submit" id="freeze_user" name="freeze_user">{{__('constant.continue')}}</button>
                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{__('constant.back')}}</button>
                                        </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </li>
                            <li class="row mt-2">
                                <div class="col-6" style="font-weight: bold;">{{__('user.is_active')}}</div>
                                    @if ($user->is_active)
                                    <div class="col-6 me-0 pe-0" style="text-align:right; color:green;">{{__('user.active_account')}}</div>
                                    @else
                                    <div class="col-6 me-0 pe-0" style="text-align:right; color:red;">{{__('user.passive_account')}}</div>
                                    @endif
                            </li>
                            @if ($user->authority)
                            <li class="row mt-2">
                                <div class="col-6" style="font-weight: bold;">{{__('user.account_type')}}</div>
                                <div class="col-6 me-0 pe-0" style="text-align:right; ">
                                    @if ($user->authority == 'client')
                                        {{__('user.client')}}
                                    @elseif($user->authority == 'subclient')
                                        {{__('user.subclient')}}
                                    @elseif($user->authority == 'temporary')
                                        {{__('user.temporary')}}
                                    @else
                                        {{$user->authority}}
                                    @endif
                                </div>
                            </li>
                            @endif
                            @if ($user->department)
                            <li class="row mt-2">
                                <div class="col-6" style="font-weight: bold;">{{__('user.department')}}</div>
                                <div class="col-6 me-0 pe-0" style="text-align:right; ">{{$user->department}}</div>
                            </li>
                            @endif
                            @if ($user->idNumber != '000000000')
                            <li class="row mt-2">
                                <div class="col-6" style="font-weight: bold;">{{__('user.company_name')}}</div>
                                <div class="col-6 me-0 pe-0" style="text-align:right; ">{{$companyName}}</div>
                            </li>
                            @endif
                            @if ($user->phone)
                            <li class="row mt-2">
                                <div class="col-6" style="font-weight: bold;">{{__('user.phone')}}</div>
                                <div class="col-6 me-0 pe-0" style="text-align:right; ">{{$user->phone}}</div>
                            </li>
                            @endif
                            @if ($user->start_date)
                            <li class="row mt-2">
                                <div class="col-6" style="font-weight: bold;">{{__('user.start_date')}}</div>
                                <div class="col-6 me-0 pe-0" style="text-align:right; ">{{$user->start_date}}</div>
                            </li>
                            @endif
                            <li class="row mt-2">
                                <div class="col-6" style="font-weight: bold;">{{__('user.total_activity')}}</div>
                                <div class="col-6 me-0 pe-0" style="text-align:right; ">{{$user->work_count}}</div>
                            </li>
                        </ul>
                    </div>
                  </div>
                </div>
            </div>
          <div class="col-xl-9 col-md-12 box-col-8 xl-70">
            <form class="card needs-validation" novalidate="" action="{{ route('user-controller.update',[$user->id]) }}" method="POST">
                @csrf
                @method('PUT')
              <div class="card-header pb-0">
                <h4 class="card-title mb-0">{{__('user.edit_user')}}</h4>
                <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="mb-3">
                      <label class="form-label" for="email">{{__('user.mail')}}</label><span class="text-danger">*</span>
                      <input class="form-control" id="email" name="email" type="text" value="{{$user->email}}" disabled required="required">
                      <div class="invalid-feedback px-1">{{__('user.proper_mail')}}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="name">{{__('user.name')}}</label><span class="text-danger">*</span>
                      <input class="form-control" id="name" name="name" type="text" value="{{$user->name}}" required="required">
                      <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                      <div class="invalid-feedback px-1">{{__('user.proper_name')}}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="phone">{{__('user.phone')}}</label><span class="text-danger">*</span>
                      <input class="form-control" id="phone" name="phone" type="tel" pattern="[0-9]+" value="{{$user->phone}}" required="required">
                      <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                      <div class="invalid-feedback px-1">{{__('user.proper_phone')}}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="department">{{__('user.department')}}</label>
                      <input class="form-control" id="department" name="department" type="text" value="{{$user->department}}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="authority">{{__('user.authority')}}</label><span class="text-danger">*</span>
                      <select class="form-control btn-square" id="authority" name="authority" required="required">
                        <option value="">{{__('user.authority_placeholder')}}</option>
                        <option value="client" @if($user->authority == 'client') selected @endif >{{__('user.client')}}</option>
                        <option value="subclient" @if($user->authority == 'subclient') selected @endif >{{__('user.subclient')}}</option>
                        <option value="temporary" @if($user->authority == 'temporary') selected @endif >{{__('user.temporary')}}</option>
                      </select>
                      <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                      <div class="invalid-feedback px-1">{{__('constant.choose')}}</div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label" for="start_date">{{__('user.start_date')}}</label>
                      <input class="datepicker-here form-control digits" type="text" data-language="tr" id="start_date" name="start_date" readonly
                      placeholder="{{__('user.start_date_placeholder')}}" data-alt-input="true" data-date-format="dd MM yyyy" data-alt-format="j F Y" value="{{ $user->start_date }}">
                    </div>
                  </div>
                  <div class="card-footer text-end py-3"></div>
                  <div class="row">
                    <div class="col-12" style="text-align: right">
                      <button class="btn btn-primary" id="save_user" name="save_user" type="submit">{{__('constant.save')}}</button>
                    </div>
                  </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
</div>
@endsection
