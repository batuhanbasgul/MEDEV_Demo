@extends('constant.content')
@section('title',__('transaction.forms'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3>{{__('transaction.new_technical_service_form')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('device-controller.index')}}">{{__('transaction.forms')}}</a></li>
              <li class="breadcrumb-item">{{__('transaction.technical_service')}}</li>
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
    @elseif(session('create_device_error'))
    <script>swal("{{__('transaction.create_device')}}", "{{__('transaction.create_device_error')}}", "error");</script>
    @endif
    <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body">
                  <div class="form theme-form">
                    <form class="needs-validation" novalidate="" action="{{ route('dev-transaction-controller.transact-device-save') }}" method="POST">
                      @csrf
                      <div class="row">
                        <div class="row mb-3">
                          <div class="col col-12 col-sm-4 mt-3">
                            <label class="form-label" for="corporation_name">{{__('transaction.corporation_name')}}</label>
                            <input class="form-control" id="corporation_name" name="corporation_name" type="text" placeholder="{{__('transaction.corporation_name_placeholder')}}" required="required" value="{{$device->corporation_name}}" readonly>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('transaction.corporation_name_error')}}</div>
                          </div>
                          <div class="col col-12 col-sm-4 mt-3">
                            <label class="form-label" for="department_name">{{__('transaction.department_name')}}</label>
                            <input class="form-control" id="department_name" name="department_name" type="text" placeholder="{{__('transaction.department_name_placeholder')}}" required="required" value="{{$device->department_name}}" readonly>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('transaction.department_name_error')}}</div>
                          </div>
                          <div class="col col-12 col-sm-4 mt-3">
                            <label class="form-label" for="device_name">{{__('transaction.device_name')}}</label>
                            <input class="form-control" id="device_name" name="device_name" type="text" placeholder="{{__('transaction.device_name_placeholder')}}" required="required" value="{{$device->name}}" readonly>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('transaction.device_name_error')}}</div>
                          </div>
                          <div class="col col-12 col-sm-4 mt-3">
                            <label class="form-label" for="device_brand">{{__('transaction.device_brand')}}</label>
                            <input class="form-control" id="device_brand" name="device_brand" type="text" placeholder="{{__('transaction.device_brand_placeholder')}}" required="required" value="{{$device->brand}}" readonly>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('transaction.device_brand_error')}}</div>
                          </div>
                          <div class="col col-12 col-sm-4 mt-3">
                            <label class="form-label" for="device_model">{{__('transaction.device_model')}}</label>
                            <input class="form-control" id="device_model" name="device_model" type="text" placeholder="{{__('transaction.device_model_placeholder')}}" required="required" value="{{$device->model}}" readonly>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('transaction.device_model_error')}}</div>
                          </div>
                          <div class="col col-12 col-sm-4 mt-3">
                            <label class="form-label" for="transactions">{{__('transaction.transactions')}}<span class="text-danger">*</span></label>
                            <input class="form-control" id="transactions" name="transactions" type="text" placeholder="{{__('transaction.transactions_placeholder')}}" required="required" value="{{ old('transactions') }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('transaction.transactions_error')}}</div>
                          </div>
                          <div class="col col-12 col-sm-4 mt-3">
                            <label class="form-label" for="personel_id">{{__('transaction.personel')}}<span class="text-danger">*</span></label>
                            <select class="form-select digits" id="personel_id" name="personel_id" required="required">
                                <option value="" disabled selected>{{__('constant.choose')}}</option>
                              @foreach ($users as $item)
                              <option value="{{$item->id}}" @if ($item->id == Auth::id()) selected @endif>{{$item->name}}</option>
                              @endforeach
                            </select>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('transaction.personel_error')}}</div>
                          </div>
                          <div class="col col-12 col-sm-4 mt-3">
                            <label class="form-label" for="record_no_to">{{__('transaction.record_no_to')}}</label>
                            <input class="form-control" id="record_no_to" name="record_no_to" type="text" placeholder="{{__('transaction.record_no_to_placeholder')}}" value="{{ old('record_no_to') }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                          </div>
                          <div class="col col-12 col-sm-4 mt-3">
                            <label class="form-label" for="record_no_from">{{__('transaction.record_no_from')}}</label>
                            <input class="form-control" id="record_no_from" name="record_no_from" type="text" placeholder="{{__('transaction.record_no_from_placeholder')}}" value="{{ old('record_no_from') }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                          </div>
                          <div class="col col-12 col-sm-4 mt-3">
                            <label class="form-label" for="calibration_tag_date">{{__('transaction.calibration_tag_date')}}</label>
                            <input class="form-control" id="calibration_tag_date" name="calibration_tag_date" type="text" placeholder="{{__('transaction.calibration_tag_date_placeholder')}}" value="{{ old('calibration_tag_date') }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                          </div>
                          <div class="col col-12 col-sm-4 mt-3">
                            <label class="form-label" for="service_in_date">{{__('transaction.service_in_date')}}</label>
                            <input class="datepicker-here form-control digits" type="text" data-language="tr" id="service_in_date" name="service_in_date" readonly
                            placeholder="{{__('transaction.service_in_date_placeholder')}}" data-alt-input="true" autocomplete="off" data-date-format="dd MM yyyy" data-alt-format="j F Y" value="{{ old('service_in_date') }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                          </div>
                          <div class="col col-12 col-sm-4 mt-3">
                            <label class="form-label" for="service_out_date">{{__('transaction.service_out_date')}}</label>
                            <input class="datepicker-here form-control digits" type="text" data-language="tr" id="service_out_date" name="service_out_date" readonly
                            placeholder="{{__('transaction.service_out_date_placeholder')}}" data-alt-input="true" autocomplete="off" data-date-format="dd MM yyyy" data-alt-format="j F Y" value="{{ old('service_out_date') }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                          </div>
                          <div class="col col-12 mt-3">
                            <label class="form-label" for="note">{{__('transaction.note')}}</label>
                            <input class="form-control" id="note" name="note" type="text" placeholder="{{__('transaction.note_placeholder')}}" maxlength="100" value="{{ old('note') }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                          </div>
                          <div class="mt-3">
                            <label class="form-label p-0" for="description">{{__('transaction.description')}}</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="{{__('transaction.description_placeholder')}}"></textarea>
                          </div>
                          <div class="col col-12 col-sm-6 mt-3">
                            <label class="form-label" for="verifier_name">{{__('transaction.verifier_name')}}</label>
                            <input class="form-control" id="verifier_name" name="verifier_name" type="text" placeholder="{{__('transaction.verifier_name_placeholder')}}" required="required" value="{{$department->person}}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('transaction.verifier_name_error')}}</div>
                          </div>
                          <div class="col col-12 col-sm-6 my-3">
                            <label class="form-label" for="verifier_tel">{{__('transaction.verifier_tel')}}</label>
                            <input class="form-control" id="verifier_tel" name="verifier_tel" type="tel" pattern="[0-9]+" placeholder="{{__('transaction.verifier_tel_placeholder')}}" required="required" value="{{$department->contact}}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('transaction.verifier_tel_error')}}</div>
                          </div>
                        </div>
                      </div>
                      <input type="hidden" id="device_id" name="device_id" value="{{$device->id}}">
                      <div class="row">
                        <div class="col">
                          <div class="text-end">
                            <button class="btn btn-primary" id="create_transact" name="create_transact" type="submit">{{__('transaction.save_form')}}</button>
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
