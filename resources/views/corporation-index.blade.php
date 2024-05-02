@extends('constant.content')
@section('title',__('corporation.corporations'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-12 col-sm-8">
            <h3>{{__('corporation.corporations')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">{{__('corporation.corporations')}}</a></li>
              <li class="breadcrumb-item">{{__('corporation.show_corporations')}}</li>
            </ol>
          </div>
          @if (Auth::user()->authority == 'client' || Auth::user()->authority == 'subclient')
          <div class="col-12 col-sm-4 d-flex justify-content-end mt-2">
            <div class="form-group mb-0 me-0"></div><a class="btn btn-primary" href="{{route('corporation-controller.create')}}">{{__('corporation.create_new_corporation')}}</a>
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
                            <th>{{__('corporation.corp_name')}}</th>
                            <th class="disappear-1250">{{__('corporation.city')}}</th>
                            <th class="disappear-1250">{{__('corporation.province')}}</th>
                            <th class="disappear-700">{{__('corporation.product_count')}}</th>
                            <th class="disappear-700">{{__('corporation.device_count')}}</th>
                            <th class="disappear-1100">{{__('corporation.spendable_sum')}}</th>
                            <th class="disappear-500">{{__('constant.action')}}</th>
                            <th>{{__('constant.download')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($corporations as $item)
                        <tr>
                            <td class="custom-cursor" onclick="document.location = '{{route('corporation-controller.edit',$item->id)}}';"><a href="{{route('corporation-controller.edit',$item->id)}}"
                                @if(Auth::user()->theme) style="color: black" @else style="color: white" @endif
                                >{{$item->name}}</a></td>
                            <td class="disappear-1250 custom-cursor" onclick="document.location = '{{route('corporation-controller.edit',$item->id)}}';">{{$cities[$item->city]}}</td>
                            <td class="disappear-1250 custom-cursor" onclick="document.location = '{{route('corporation-controller.edit',$item->id)}}';">{{$item->province}}</td>
                            <td class="disappear-700 custom-cursor" onclick="document.location = '{{route('corporation-controller.edit',$item->id)}}';">{{$item->product_count}}</td>
                            <td class="disappear-700 custom-cursor" onclick="document.location = '{{route('corporation-controller.edit',$item->id)}}';">{{$item->device_count}}</td>
                            <td class="disappear-1100 custom-cursor" onclick="document.location = '{{route('corporation-controller.edit',$item->id)}}';">{{$item->spendable_count}}</td>
                            <td class="disappear-500" style="width: 120px;"><a class="btn btn-primary" href="{{route('corporation-controller.edit',$item->id)}}">{{__('constant.edit')}}</a></td>
                            <td style="width: 40px;">
                                <a href="{{route('corporation-controller.download',$item->id)}}">
                                    <button class="btn btn-primary py-1" type="button" style="color:white"><i data-feather="download"></i></button>
                                </a>
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
