@extends('constant.content')
@section('title',__('device.devices'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3>{{__('device.devices')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('device-controller.index')}}">{{__('device.devices')}}</a></li>
              <li class="breadcrumb-item">{{__('device.device-adddrop')}}</li>
            </ol>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
              <!-- Bookmark Start-->
              <div class="bookmark">
                <ul>
                  <!--<li><a href="#"><i data-feather="plus"></i></a></li>-->
                  <li><a href="{{route('department-controller.create')}}"><button class="btn btn-primary" style="width: 100%" type="button">{{__('device.new_department')}}</button></a></li>
                  <li><a href="{{route('product-controller.edit',$product_id)}}"><button class="btn btn-primary" type="button">{{__('constant.back')}}</button></a></li>
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
                  <div class="card-header pb-0">
                    <h5>{{__('device.adddrop_for_choosed_product')}}</h5>
                  </div>
                  <hr>
                  <div class="card-header py-0">
                    <p>{{__('device.enter_amount_for_add')}}</p>
                  </div>
                  <form class="needs-validation" novalidate="" action="{{ route('device-controller.add-drop-save') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col col-sm-6 col-lg-4">
                            <div class="ms-4 mb-1">
                              <input class="form-control" id="count" name="count" type="number" min="0" placeholder="{{__('device.new_device_amount')}}" required="required" value="{{ old('count') }}">
                              <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                              <div class="invalid-feedback px-1">{{__('device.enter_amount')}}</div>
                            </div>
                        </div>
                        <input type="hidden" id="product_id" name="product_id" value="{{$product_id}}">
                        <div class="col col-sm-6 col-lg-8">
                            <button class="btn btn-primary" id="add_device" name="add_device" type="submit">{{__('device.add_device')}}</button>
                        </div>
                    </div>
                  </form>
                  <hr>
                  <div class="card-header py-0">
                    <h5>{{__('device.choose_to_delete')}}</h5>
                  </div>
                  @if(count($devices) > 0)
                  <form class="needs-validation" novalidate="" action="{{ route('device-controller.add-drop-save') }}" method="POST">
                    @csrf
                    <div class="card-body animate-chk">
                        <div class="row">
                        <div class="col">
                            @foreach ($devices as $item)
                            <label class="d-block" for="device{{$item->id}}">
                            <input class="checkbox_animated" id="device{{$item->id}}" name="device{{$item->id}}" type="checkbox">{{$item->name}} - {{$item->brand}} - {{$item->model}}
                            </label>
                            @endforeach
                        </div>
                        </div>
                    </div>
                    <input type="hidden" id="product_id" name="product_id" value="{{$product_id}}">
                    <div class="row">
                        <div class="col">
                          <div class="text-start m-4">
                            <button class="btn btn-danger" onclick="return confirm('{{__('device.delete_question')}}')" id="drop_device" name="drop_device" type="submit">{{__('device.delete_choosed_devices')}}</button>
                          </div>
                        </div>
                      </div>
                  </form>
                  @else
                  <div class="text-start m-4">
                    {{__('device.no_device_found')}}
                  </div>
                  @endif
                </div>
            </div>
          </div>
        </div>
    <!-- Container-fluid Ends-->
</div>
@endsection
