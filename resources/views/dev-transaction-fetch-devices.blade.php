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
              <li class="breadcrumb-item"><a href="{{route('corporation-controller.index')}}">{{__('transaction.forms')}}</a></li>
              <li class="breadcrumb-item">{{__('transaction.founded_devices')}}</li>
            </ol>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
              <!-- Bookmark Start-->
              <div class="bookmark">
                <ul>
                  <!--<li><a href="#"><i data-feather="plus"></i></a></li>-->
                  <li><a href="{{route('dev-transaction-controller.find-devices')}}"><button class="btn btn-primary" type="button">{{__('constant.back')}}</button></a></li>
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
      <!-- ribbon left (default) side-->
      <div class="row">
        <div class="col-sm-12 col-xl-12">
          <div class="card">
            <div class="card-header">
              <h5>{{__('transaction.founded_devices')}}</h5><span>{{__('transaction.choose_device_to_transact')}}</span>
            </div>
            <div class="card-body">
              <div class="row">
                @foreach ($devices as $item)
                <a href="{{route('dev-transaction-controller.transact-device',$item->id)}}">
                    <div class="col-sm-12 col-md-6">
                      <div class="card ribbon-wrapper">
                        <div class="card-body">
                          <div class="ribbon ribbon-primary ribbon-space-bottom">{{$item->name}}</div>
                          <div class="row">
                            <div class="col">
                                <p>{{$item->brand}}</p>
                                <p>{{$item->model}}</p>
                                <p>{{$item->serial_no}}</p>
                            </div>
                            <div class="col">
                                <p>{{$item->product_name}}</p>
                                <p>{{$item->corporation_name}}</p>
                                <p>{{$item->department_name}}</p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </a>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
@endsection
