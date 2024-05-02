@extends('constant.content')
@section('title',__('constant.devices'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-12 col-sm-8">
            <h3>{{__('constant.devices')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">{{__('constant.devices')}}</a></li>
              <li class="breadcrumb-item">{{__('device.show_devices')}}</li>
            </ol>
          </div>
          <!--
          @if (Auth::user()->authority == 'client' || Auth::user()->authority == 'subclient')
          <div class="col-12 col-sm-4 d-flex justify-content-end mt-2">
            <div class="form-group mb-0 me-0"></div><a class="btn btn-primary" href="{{route('device-controller.create')}}">{{__('device.create_new_device')}}</a>
          </div>
          @endif
          -->
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
    @elseif(session('no_transaction_error'))
    <script>swal("{{__('constant.error')}}", "{{__('device.no_transaction_error')}}", "error");</script>
    @endif
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
          <!-- Zero Configuration  Starts-->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-body">
                <table id="productTable" class="display">
                    <thead>
                        <tr>
                            <th>{{__('device.device_name')}}</th>
                            <th class="disappear-500">{{__('device.corporation')}}</th>
                            <th class="disappear-500">{{__('device.department')}}</th>
                            <th class="disappear-700">{{__('device.product')}}</th>
                            <th class="disappear-1250">{{__('device.brand')}}</th>
                            <th class="disappear-1250">{{__('device.model')}}</th>
                            <th class="disappear-500">{{__('constant.action')}}</th>
                            <th>{{__('constant.download')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($devices as $item)
                        <tr>
                            <td class="custom-cursor" onclick="document.location = '{{route('device-controller.edit',$item->id)}}';"><a href="{{route('device-controller.edit',$item->id)}}"
                                @if(Auth::user()->theme) style="color: black" @else style="color: white" @endif
                                >{{$item->name}}</a></td>
                            <td class="disappear-500 custom-cursor" onclick="document.location = '{{route('device-controller.edit',$item->id)}}';">{{$item->corporation_name}}</td>
                            <td class="disappear-500 custom-cursor" onclick="document.location = '{{route('device-controller.edit',$item->id)}}';">{{$item->department_name}}</td>
                            <td class="disappear-700 custom-cursor" onclick="document.location = '{{route('device-controller.edit',$item->id)}}';">{{$item->product_name}}</td>
                            <td class="disappear-1250 custom-cursor" onclick="document.location = '{{route('device-controller.edit',$item->id)}}';">{{$item->brand}}</td>
                            <td class="disappear-1250 custom-cursor" onclick="document.location = '{{route('device-controller.edit',$item->id)}}';">{{$item->model}}</td>
                            <td class="disappear-500" style="width: 120px;"><a class="btn btn-primary" href="{{route('device-controller.edit',$item->id)}}">{{__('constant.edit')}}</a></td>
                            <td style="width: 40px;">
                                <button class="btn btn-primary py-1" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$item->id}}" style="color:white"><i data-feather="download"></i></button>
                                <div class="modal fade modal-bookmark" id="exampleModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$item->id}}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel{{$item->id}}">{{$item->name}}</h5>
                                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col"></div>
                                                <div class="col">
                                                    <img style="width: 250px; height: 250px;" src="{{$item->qr_code_path}}" alt="">
                                                </div>
                                                <div class="col mb-4"></div>
                                            </div>
                                            <br>
                                            <di v class="row">
                                                <div class="col-4">
                                                    {{__('device.corporation')}}<br>
                                                    {{__('device.department')}}<br>
                                                    {{__('device.product')}}<br>
                                                    {{__('device.brand')}}<br>
                                                    {{__('device.model')}}<br>
                                                </div>
                                                <div class="col-1">
                                                    -<br>
                                                    -<br>
                                                    -<br>
                                                    -<br>
                                                    -<br>
                                                </div>
                                                <div class="col-7">
                                                    {{$item->corporation_name}} <br>
                                                    {{$item->department_name}} <br>
                                                    {{$item->product_name}} <br>
                                                    {{$item->brand}} <br>
                                                    {{$item->model}} <br>
                                                </div>
                                                <div class="col-12">
                                                    <a class="btn btn-primary mt-4" style="width: 100%" href="{{$item->qr_code_path}}" download="{{$item->name.'-'.$item->department_name}}">{{__('device.download_qr_code')}}</a>
                                                    <a class="btn btn-primary mt-2" style="width: 100%" href="{{route('dev-transaction-controller.download-form',['id' => $item->id, 'select' => 'device'])}}">{{__('device.download_forms')}}</a>
                                                    <a class="btn btn-primary mt-2" style="width: 100%" href="{{route('dev-transaction-controller.transact-device',$item->id)}}">{{__('device.transact')}}</a>
                                                    <a class="btn btn-primary mt-2" style="width: 100%" href="tel:{{$item->department_contact}}">{{__('device.call_department')}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- Zero Configuration  Ends-->
        </div>
      </div>
    <!-- Container-fluid Ends-->
</div>
@endsection
