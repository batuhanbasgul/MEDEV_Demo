@extends('constant.content')
@section('title',__('department.departments'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-12 col-sm-8">
            <h3>{{__('department.departments')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">{{__('department.departments')}}</a></li>
              <li class="breadcrumb-item">{{__('department.show_departments')}}</li>
            </ol>
          </div>
          @if (Auth::user()->authority == 'client' || Auth::user()->authority == 'subclient')
          <div class="col-12 col-sm-4 d-flex justify-content-end mt-2">
            <div class="form-group mb-0 me-0"></div><a class="btn btn-primary" href="{{route('department-controller.create')}}">{{__('department.new_department')}}</a>
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
                            <th>{{__('department.department_name')}}</th>
                            <th class="disappear-600">{{__('department.corporation_name')}}</th>
                            <th class="disappear-700">{{__('department.person_name')}}</th>
                            <th class="disappear-500">{{__('department.contact')}}</th>
                            <th class="disappear-500">{{__('constant.action')}}</th>
                            <th>{{__('department.download')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departments as $item)
                        <tr>
                            <td class="custom-cursor" onclick="document.location = '{{route('department-controller.edit',$item->id)}}';"><a href="{{route('department-controller.edit',$item->id)}}"
                                @if(Auth::user()->theme) style="color: black" @else style="color: white" @endif
                                >{{$item->name}}</a></td>
                            <td class="disappear-600 custom-cursor" onclick="document.location = '{{route('department-controller.edit',$item->id)}}';">{{$item->corporation_name}}</td>
                            <td class="disappear-700 custom-cursor" onclick="document.location = '{{route('department-controller.edit',$item->id)}}';">{{$item->person}}</td>
                            <td class="disappear-500 custom-cursor" onclick="document.location = '{{route('department-controller.edit',$item->id)}}';"><a href="tel:{{$item->contact}}">{{$item->contact}}</a></td>
                            <td class="disappear-500" style="width: 120px;"><a class="btn btn-primary" href="{{route('department-controller.edit',$item->id)}}">{{__('constant.edit')}}</a></td>
                            <td style="width: 40px;">
                                <a href="{{route('department-controller.download',$item->id)}}">
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
