@extends('constant.content')
@section('title',__('product.products'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-12 col-sm-8">
            <h3>{{__('product.products')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">{{__('product.products')}}</a></li>
              <li class="breadcrumb-item">{{__('product.show_products')}}</li>
            </ol>
          </div>
          @if (Auth::user()->authority == 'client' || Auth::user()->authority == 'subclient')
          <div class="col-12 col-sm-4 d-flex justify-content-end mt-2">
            <div class="form-group mb-0 me-0"></div><a class="btn btn-primary" href="{{route('product-controller.create')}}">{{__('product.create_new_product')}}</a>
          </div>
          @endif
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
    <script>swal("{{__('constant.error')}}", "{{__('product.no_transaction_found')}}", "error");</script>
    @elseif(session('no_data'))
    <script>swal("{{__('constant.error')}}", "{{__('constant.no_data')}}", "error");</script>
    @endif
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
          <!-- Zero Configuration  Starts-->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-body dropdown-basic">
                <table id="productTable" class="display">
                    <thead>
                        <tr>
                            <th>{{__('constant.download')}}</th>
                            <th>{{__('product.product_name')}}</th>
                            <th class="disappear-1250">{{__('product.corporation_name')}}</th>
                            <th class="disappear-500">{{__('product.device_count')}}</th>
                            <th class="disappear-700">{{__('product.spendable_count')}}</th>
                            <th class="disappear-1100">{{__('product.start_date')}}</th>
                            <th class="disappear-400">{{__('product.end_date')}}</th>
                            <th class="disappear-500">{{__('product.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $item)
                        <tr @if(!$item->is_active) style="color:red" @endif>
                            <td style="width: 40px;">
                                <div class="dropdown m-0">
                                  <div class="btn-group m-0">
                                    <button class="dropbtn btn-primary px-2 py-2 me-0" style="color:white;" type="button"><span><i data-feather="download"></i></span></button>
                                    <div class="dropdown-content" style="margin-right: 100px;">
                                        <a href="{{route('product-controller.download-qr',['id' => $item->id, 'select' => 'pdf'])}}">{{__('product.download_device_list')}}</a>
                                        <a href="{{route('product-controller.download-qr',['id' => $item->id, 'select' => 'img'])}}">{{__('product.download_qr_codes')}}</a>
                                        <a href="{{route('dev-transaction-controller.download-form',['id' => $item->id, 'select' => 'product'])}}">{{__('product.download_forms')}}</a>
                                  </div>
                                </div>
                            </td>
                            <td class="disappear-1250 custom-cursor" onclick="document.location = '{{route('product-controller.edit',$item->id)}}';"><a href="{{route('product-controller.edit',$item->id)}}"
                                @if(!$item->is_active) style="color: red" @elseif(Auth::user()->theme) style="color: black" @else style="color: white" @endif
                                >{{$item->name}}</a></td>
                            <td>{{$item->corporation_name}}</td>
                            <td class="disappear-500 custom-cursor" onclick="document.location = '{{route('product-controller.edit',$item->id)}}';">{{$item->device_count}}</td>
                            <td class="disappear-700 custom-cursor" onclick="document.location = '{{route('product-controller.edit',$item->id)}}';">{{$item->spendable_count}}</td>
                            <td class="disappear-1100 custom-cursor" onclick="document.location = '{{route('product-controller.edit',$item->id)}}';">{{$item->start_date}}</td>
                            <td class="disappear-400 custom-cursor" onclick="document.location = '{{route('product-controller.edit',$item->id)}}';">{{$item->end_date}}</td>
                            <td class="disappear-500" style="width: 120px;"><a class="btn btn-primary" href="{{route('product-controller.edit',$item->id)}}">{{__('constant.edit')}}</a></td>

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
