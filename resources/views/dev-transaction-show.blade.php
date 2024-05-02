@extends('constant.content')
@section('title',__('transaction.forms'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-12 col-sm-8">
            <h3>{{__('transaction.technical_service')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">{{__('transaction.technical_service')}}</a></li>
              <li class="breadcrumb-item">{{$transaction->device_name}}</li>
            </ol>
          </div>
          <div class="col-12 col-sm-4 d-flex justify-content-end mt-2">
            <div class="form-group mb-0 me-2"><a class="btn btn-danger" href="{{route('dev-transaction-controller.destroy',$transaction->id)}}" onclick="return confirm('{{__('transaction.destroy_form_question')}}')">{{__('transaction.destroy_form')}}</a></div>
            <div class="form-group mb-0 me-0"><a class="btn btn-primary" href="{{route('dev-transaction-controller.edit',$transaction->id)}}">{{__('constant.edit')}}</a></div>
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
      <div class="learning-block">
        <div class="card p-4">
          <div class="blog-box blog-list">
              <div class="blog-details">
                <div class="blog-date mb-2">
                    <span>
                        {{$transaction->device_name}}
                    </span>
                </div>
                <ul class="blog-social mb-2">
                  <li>{{$transaction->corporation_name}}</li>
                  <li>{{$transaction->department_name}}</li>
                </ul>
                <div class="blog-bottom-content">
                  <h6>{{__('transaction.personel')}} : {{$transaction->personal_name}}</h6>
                  <hr>
                  <h6 class="mt-0">{{__('transaction.info')}}</h6>
                  <div class="row mb-3">
                    <div class="col-4 col-sm-5 col-md-4">
                        <p class="mt-0">{{__('transaction.corporation_name')}}</p>
                        <p class="mt-0">{{__('transaction.department_name')}}</p>
                        <p class="mt-0">{{__('transaction.product_name')}}</p>
                        <p class="mt-0">{{__('transaction.device_name')}}</p>
                        <p class="mt-0">{{__('transaction.device_brand')}}</p>
                        <p class="mt-0">{{__('transaction.device_model')}}</p>
                        <p class="mt-0">{{__('transaction.device_serial_no')}}</p>
                        <p class="mt-0">{{__('transaction.personel')}}</p>
                        <p class="mt-0">{{__('template.verifier_name')}}</p>
                        <p class="mt-0">{{__('transaction.verifier_tel')}}</p>
                    </div>
                    <div class="col-1">
                        <p class="mt-0">-</p>
                        <p class="mt-0">-</p>
                        <p class="mt-0">-</p>
                        <p class="mt-0">-</p>
                        <p class="mt-0">-</p>
                        <p class="mt-0">-</p>
                        <p class="mt-0">-</p>
                        <p class="mt-0">-</p>
                        <p class="mt-0">-</p>
                        <p class="mt-0">-</p>
                    </div>
                    <div class="col-6 col-sm-6 col-md-7">
                        <p class="mt-0">{{$transaction->corporation_name}}</p>
                        <p class="mt-0">{{$transaction->department_name}}</p>
                        <p class="mt-0">{{$transaction->product_name}}</p>
                        <p class="mt-0">{{$transaction->device_name}}</p>
                        <p class="mt-0">{{$transaction->device_brand}}</p>
                        <p class="mt-0">{{$transaction->device_model}}</p>
                        <p class="mt-0">{{$transaction->device_serial_no}}</p>
                        <p class="mt-0">{{$transaction->personal_name}}</p>
                        <p class="mt-0">{{$transaction->verifier_name}}</p>
                        <a href="tel:{{$transaction->verifier_tel}}"><p class="mt-0">{{$transaction->verifier_tel}}</p></a>
                    </div>
                  </div>
                  <h6 class="mt-0">{{__('transaction.description')}}</h6>
                  <p class="mt-0">{{$transaction->description}}</p>
                  @if (!Gate::allows('temporary') && !$transaction->controller_id)
                  <div class="d-flex flex-row-reverse">
                    <div class="form-group mb-0 me-0"><a class="btn btn-primary" href="{{route('dev-transaction-controller.verify-transaction',$transaction->id)}}" onclick="return confirm('{{__('transaction.verify_form_question')}}')">{{__('transaction.verify_form')}}</a></div>
                  </div>
                  @endif
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
@endsection
