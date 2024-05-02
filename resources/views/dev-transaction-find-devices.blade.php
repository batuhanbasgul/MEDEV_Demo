@extends('constant.content')
@section('title',__('transaction.forms'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3>{{__('transaction.technical_service')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('corporation-controller.index')}}">{{__('transaction.devices')}}</a></li>
              <li class="breadcrumb-item">{{__('transaction.find_device')}}</li>
            </ol>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
              <!-- Bookmark Start-->
              <div class="bookmark">
                <ul>
                  <!--<li><a href="#"><i data-feather="plus"></i></a></li>-->
                  <li><a href="{{route('dev-transaction-controller.index')}}"><button class="btn btn-primary" type="button">{{__('constant.back')}}</button></a></li>
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
                    <form class="needs-validation" novalidate="" action="{{ route('dev-transaction-controller.fetch-devices') }}" method="POST">
                      @csrf
                      <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="corporation_id">{{__('transaction.corporation_name')}}<span class="text-danger">*</span></label>
                            <select class="form-select digits" id="corporation_id" name="corporation_id" required="required">
                              <option value="" disabled selected>{{__('constant.choose')}}</option>
                              @php $i=0 @endphp
                              @foreach ($corporations as $item)
                              <option value="{{$item->id}}">{{$item->name}}</option>
                              @php $i=$i+1; @endphp
                              @endforeach
                            </select>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('transaction.choose_corporation')}}</div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="department_id">{{__('transaction.department_name')}}<span class="text-danger">*</span></label>
                            <select class="form-select digits" id="department_id" name="department_id" required="required">
                              <option value="" disabled selected>{{__('constant.choose')}}</option>
                              @php $i=0 @endphp
                              @foreach ($departments as $item)
                              <option value="{{$item->id}}">{{$item->name}}</option>
                              @php $i=$i+1; @endphp
                              @endforeach
                            </select>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('transaction.choose_department')}}</div>
                        </div>
                      </div>
                      <div class="row mb-4">
                        <div class="col">
                            <label class="form-label" for="product_id">{{__('transaction.product_name')}}<span class="text-danger">*</span></label>
                            <select class="form-select digits" id="product_id" name="product_id" required="required">
                              <option value="" disabled selected>{{__('constant.choose')}}</option>
                              @php $i=0 @endphp
                              @foreach ($products as $item)
                              <option value="{{$item->id}}">{{$item->name}}</option>
                              @php $i=$i+1; @endphp
                              @endforeach
                            </select>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('transaction.choose_product')}}</div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="text-end">
                            <button class="btn btn-primary" id="find_devices" name="find_devices" type="submit">{{__('transaction.fetch_devices')}}</button>
                            <a class="btn btn-danger" href="{{route('dev-transaction-controller.index')}}">{{__('constant.back')}}</a>
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
