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
              <li class="breadcrumb-item">{{__('transaction.technical_service_forms')}}</li>
            </ol>
          </div>
          <div class="col-12 col-sm-4 d-flex justify-content-end mt-2">
            <div class="form-group mb-0 me-0"></div><a class="btn btn-primary" href="{{route('dev-transaction-controller.find-devices')}}">{{__('transaction.new_transaction')}}</a>
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
    @elseif(session('no_data'))
    <script>swal("{{__('constant.error')}}", "{{__('constant.no_data')}}", "error");</script>
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
                            <th>{{__('transaction.device_name')}}</th>
                            <th class="disappear-500">{{__('transaction.corporation_name')}}</th>
                            <th class="disappear-700">{{__('transaction.department_name')}}</th>
                            <th class="disappear-1250">{{__('transaction.personel')}}</th>
                            <th class="disappear-1250">{{__('transaction.verifier')}}</th>
                            <th>{{__('constant.action')}}</th>
                            <th>{{__('constant.pdf')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $item)
                        <tr>
                            <td class="custom-cursor" onclick="document.location = '{{route('dev-transaction-controller.show',$item->id)}}';"><a href="{{route('dev-transaction-controller.show',$item->id)}}"
                                @if(Auth::user()->theme) style="color: black" @else style="color: white" @endif
                                >{{$item->device_name}}</a></td>
                            <td class="disappear-500 custom-cursor" onclick="document.location = '{{route('dev-transaction-controller.show',$item->id)}}';">{{$item->corporation_name}}</td>
                            <td class="disappear-700 custom-cursor" onclick="document.location = '{{route('dev-transaction-controller.show',$item->id)}}';">{{$item->department_name}}</td>
                            <td class="disappear-1250 custom-cursor" onclick="document.location = '{{route('dev-transaction-controller.show',$item->id)}}';">{{$item->personel_name}}</td>
                            <td class="disappear-1250 custom-cursor" onclick="document.location = '{{route('dev-transaction-controller.show',$item->id)}}';">{{$item->verifier_name}}</td>
                            <td style="width: 80px;"><a class="btn btn-primary" href="{{route('dev-transaction-controller.show',$item->id)}}">{{__('constant.show')}}</a></td>
                            <td style="width: 32px;"><a class="btn btn-primary px-2 pt-2 pb-1" href="{{route('dev-transaction-controller.download-form',['id' => $item->id, 'select' => 'single'])}}"><i data-feather="download"></i></a></td>
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
