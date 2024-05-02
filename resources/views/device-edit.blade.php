@extends('constant.content')
@section('title',__('constant.devices'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3>{{__('constant.devices')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('device-controller.index')}}">{{__('constant.devices')}}</a></li>
              <li class="breadcrumb-item">{{__('constant.edit_device')}}</li>
            </ol>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
              <!-- Bookmark Start-->
              <div class="bookmark">
                <ul>
                  <!--<li><a href="#"><i data-feather="plus"></i></a></li>-->
                  <li><a href="{{route('department-controller.create')}}"><button class="btn btn-primary" style="width: 100%" type="button">{{__('device.new_department')}}</button></a></li>
                  <li><a href="{{route('device-controller.index')}}"><button class="btn btn-primary" type="button">{{__('constant.back')}}</button></a></li>
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
                    <form class="needs-validation" novalidate="" action="{{ route('device-controller.update',$device->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="row">
                        <div class="row mb-3">
                          <div class="col col-12 col-sm-3">
                            <label class="form-label" for="department_id">{{__('device.department')}}<span class="text-danger">*</span></label>
                            <select class="form-select digits" id="department_id" name="department_id" required="required">
                              <option value="" disabled selected>{{__('constant.choose')}}</option>
                              @foreach ($corpDepartments as $item)
                              <option @if($device->department_id==$item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                              @endforeach
                            </select>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('device.choose_department')}}</div>
                          </div>
                          <div class="col col-12 col-sm-3 mt-2">
                            <label class="form-label" for="name">{{__('device.device_name')}}<span class="text-danger">*</span></label>
                            <input class="form-control" id="name" name="name" type="text" placeholder="{{__('device.device_name_placeholder')}}" required="required" value="{{ $device->name }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('device.device_name_error')}}</div>
                          </div>
                          <div class="col col-12 col-sm-3 mt-2">
                            <label class="form-label" for="brand">{{__('device.device_brand')}}<span class="text-danger">*</span></label>
                            <input class="form-control" id="brand" name="brand" type="text" placeholder="{{__('device.device_brand_placeholder')}}" required="required" value="{{ $device->brand }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('device.device_brand_error')}}</div>
                          </div>
                          <div class="col col-12 col-sm-3 mt-2">
                            <label class="form-label" for="model">{{__('device.device_model')}}<span class="text-danger">*</span></label>
                            <input class="form-control" id="model" name="model" type="text" placeholder="{{__('device.device_model_placeholder')}}" required="required" value="{{ $device->model }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('device.device_model_error')}}</div>
                          </div>
                          <div class="col col-12 col-sm-3 mt-2">
                            <label class="form-label" for="serial_no">{{__('device.device_serial_no')}}<span class="text-danger">*</span></label>
                            <input class="form-control" id="serial_no" name="serial_no" type="text" placeholder="{{__('device.device_serial_no_placeholder')}}" required="required" value="{{ $device->serial_no }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('device.device_serial_no_error')}}</div>
                          </div>
                          <div class="col col-12 col-sm-3 mt-2">
                            <label class="form-label" for="ern_code">{{__('device.device_ern_code')}}<span class="text-danger">*</span></label>
                            <input class="form-control" id="ern_code" name="ern_code" type="text" placeholder="{{__('device.device_ern_code_placeholder')}}" required="required" value="{{ $device->ern_code }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('device.device_ern_code_error')}}</div>
                          </div>
                          <div class="col col-12 col-sm-3 mt-2">
                            <label class="form-label" for="bill_no">{{__('device.device_bill_no')}}</label>
                            <input class="form-control" id="bill_no" name="bill_no" type="text" placeholder="{{__('device.device_bill_no_placeholder')}}" value="{{ $device->bill_no }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                          </div>
                          <div class="col col-12 col-sm-3 mt-2">
                            <label class="form-label" for="accessory">{{__('device.device_accessory')}}</label>
                            <input class="form-control" id="accessory" name="accessory" type="text" placeholder="{{__('device.device_accessory_placeholder')}}" value="{{ $device->accessory }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                          </div>
                          <div class="col col-12 col-sm-3 mt-2">
                            <label class="form-label" for="spendable_count">{{__('device.spendable_count')}}</label>
                            <input class="form-control" id="spendable_count" name="spendable_count" type="number" min="0" placeholder="{{__('device.spendable_count_placeholder')}}" required="required" value="{{ $device->spendable_count }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('device.spendable_count_error')}}</div>
                          </div>
                          <div class="col col-12 col-sm-9 mb-3 mt-2">
                            <label class="form-label p-0" for="spendable_description">{{__('device.spendable_description')}}</label>
                            <textarea class="form-control" id="spendable_description" name="spendable_description" rows="2" placeholder="{{__('device.spendable_description_placeholder')}}">{{ $device->spendable_description }}</textarea>
                          </div>
                          <div class="col col-12 col-sm-12 mb-3">
                            <label class="form-label p-0" for="note">{{__('device.device_note')}}</label>
                            <textarea class="form-control" id="note" name="note" rows="4" placeholder="{{__('device.device_note_placeholder')}}">{{ $device->note }}</textarea>
                          </div>
                        </div>
                      </div>
                      <input type="hidden" id="product_id" name="product_id" value="{{$product->id}}">
                      <div class="row">
                        <div class="col">
                          <div class="text-end">
                            <button class="btn btn-primary" id="edit_device" name="edit_device" type="submit">{{__('constant.update')}}</button>
                            <a class="btn btn-danger" href="{{route('device-controller.index')}}">{{__('constant.back')}}</a>
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
