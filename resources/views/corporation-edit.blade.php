@extends('constant.content')
@section('title',__('corporation.corporations'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3>{{__('corporation.corporations')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('corporation-controller.index')}}">{{__('corporation.corporations')}}</a></li>
              <li class="breadcrumb-item">{{__('corporation.edit_corporation')}}</li>
            </ol>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
              <!-- Bookmark Start-->
              <div class="bookmark">
                <ul>
                  <!--<li><a href="#"><i data-feather="plus"></i></a></li>-->
                  <li><a href="{{route('corporation-controller.index')}}"><button class="btn btn-primary" type="button">{{__('constant.back')}}</button></a></li>
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
  @endif
    <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body">
                  <div class="form theme-form">
                    <form class="needs-validation" novalidate="" action="{{ route('corporation-controller.update',$corporation->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="row">
                        <div class="col-12">
                          <div class="mb-3">
                            <label class="form-label" for="type">{{__('corporation.corp_name')}}</label><span class="text-danger">*</span>
                            <input class="form-control" id="name" name="name" type="text" placeholder="{{__('corporation.corp_name_placeholder')}}" required="required" value="{{ $corporation->name }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('corporation.corp_name_error')}}</div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                            <div class="row mb-3">
                              <label class="form-label" for="city">{{__('corporation.city')}}<span class="text-danger">*</span></label>
                              <div class="col col-12 col-sm-8 col-md-9 col-xl-10">
                                <select class="form-select digits" id="city" name="city" required="required">
                                  <option value="" disabled selected>{{__('constant.choose')}}</option>
                                  @php $i=0 @endphp
                                  @foreach ($cities as $item)
                                  <option @if($corporation->city == array_keys($cities)[$i]) selected @endif value="{{array_keys($cities)[$i]}}">{{$item}}</option>
                                  @php $i=$i+1; @endphp
                                  @endforeach
                                </select>
                                <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                                <div class="invalid-feedback px-1">{{__('corporation.choose_city')}}</div>
                              </div>
                            </div>
                        </div>
                        <div class="col-6">
                          <div class="mb-3">
                            <label class="form-label" for="spendable_count">{{__('corporation.province')}}</label><span class="text-danger">*</span>
                            <input class="form-control" id="province" name="province" type="text" placeholder="{{__('corporation.province_placeholder')}}" required="required" value="{{ $corporation->province }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('corporation.enter_province_name')}}</div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="text-end mt-2">
                            <button class="btn btn-primary" id="edit_corporation" name="edit_corporation" type="submit">{{__('constant.update')}}</button>
                            <a class="btn btn-danger" href="{{route('product-controller.index')}}">{{__('constant.back')}}</a>
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
