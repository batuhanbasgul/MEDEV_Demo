@extends('constant.content')
@section('title',__('data_export.data_export'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3>{{__('data_export.data_export')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('corporation-controller.index')}}">{{__('data_export.data_export')}}</a></li>
              <li class="breadcrumb-item">{{__('data_export.data_filter')}}</li>
            </ol>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
              <!-- Bookmark Start-->
              <div class="bookmark">
                <ul>
                  <!--<li><a href="#"><i data-feather="plus"></i></a></li>-->
                  <li><a href="{{route('index')}}"><button class="btn btn-primary" type="button">{{__('constant.back')}}</button></a></li>
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
  @elseif(session('no_data'))
  <script>swal("{{__('constant.error')}}", "{{__('data_export.no_data')}}", "error");</script>
  @endif
    <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body">
                  <div class="form theme-form">
                    <form class="needs-validation" novalidate="" action="{{ route('data-output-controller.store') }}" method="POST">
                      @csrf
                      <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="city">{{__('data_export.city')}}<span class="text-danger">*</span></label>
                            <select class="form-select digits" id="city" name="city" required="required">
                              <option value="0" selected>{{__('data_export.all')}}</option>
                              @php $i=0 @endphp
                              @foreach ($cities as $item)
                              <option value="{{array_keys($cities)[$i]}}">{{$item}}</option>
                              @php $i=$i+1; @endphp
                              @endforeach
                            </select>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('data_export.choose_city')}}</div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="corporation_id">{{__('data_export.corporation_name')}}<span class="text-danger">*</span></label>
                            <select class="form-select digits" id="corporation_id" name="corporation_id" required="required">
                              <option value="0" selected>{{__('data_export.all')}}</option>
                                @foreach ($corporations as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('data_export.choose_corporation')}}</div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="product_id">{{__('data_export.product_name')}}<span class="text-danger">*</span></label>
                            <select class="form-select digits" id="product_id" name="product_id" required="required">
                              <option value="0" selected>{{__('data_export.all')}}</option>
                              @foreach ($products as $item)
                              <option value="{{$item->id}}">{{$item->name}}</option>
                              @endforeach
                            </select>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('data_export.choose_product')}}</div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="personel_id">{{__('data_export.personel')}}<span class="text-danger">*</span></label>
                            <select class="form-select digits" id="personel_id" name="personel_id" required="required">
                              <option value="0" selected>{{__('data_export.all')}}</option>
                              @foreach ($users as $item)
                              <option value="{{$item->id}}">{{$item->name}}</option>
                              @endforeach
                            </select>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('data_export.choose_personel')}}</div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label" for="start_date">{{__('data_export.start_date')}}<span class="text-danger">*</span></label>
                            <input class="datepicker-here form-control digits" type="text" data-language="tr" id="start_date" name="start_date" required="required" readonly disabled
                            placeholder="{{__('data_export.start_date_placeholder')}}" data-alt-input="true" autocomplete="off" data-date-format="dd MM yyyy" data-alt-format="j F Y" value="{{__('data_export.all')}}">
                              <div class="checkbox">
                                <input id="start_checkbox" name="start_checkbox" type="checkbox" checked onclick="selectAllTimesStart()">
                                <label for="start_checkbox">{{__('data_export.all_times')}}</label>
                              </div>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('data_export.choose_date')}}</div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label" for="end_date">{{__('data_export.end_date')}}<span class="text-danger">*</span></label>
                            <input class="datepicker-here form-control digits" type="text" data-language="tr" id="end_date" name="end_date" required="required" readonly disabled
                            placeholder="{{__('data_export.end_date_placeholder')}}" data-alt-input="true" autocomplete="off" data-date-format="dd MM yyyy" data-alt-format="j F Y" value="{{__('data_export.all')}}">
                            <div class="checkbox">
                              <input id="end_checkbox" name="end_checkbox" type="checkbox" checked onclick="selectAllTimesEnd()">
                              <label for="end_checkbox">{{__('data_export.all_times')}}</label>
                            </div>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('data_export.choose_date')}}</div>
                          </div>
                        </div>
                      </div>
                      <script>
                        function selectAllTimesStart(){
                            var checkVal = document.getElementById('start_checkbox').checked;
                            if(checkVal){
                                document.getElementById('start_date').value = 'Hepsi';
                                document.getElementById('start_date').disabled = true;
                            }else{
                                document.getElementById('start_date').value = '';
                                document.getElementById('start_date').disabled = false;
                            }
                        }
                        function selectAllTimesEnd(){
                            var checkVal = document.getElementById('end_checkbox').checked;
                            if(checkVal){
                                document.getElementById('end_date').value = 'Hepsi';
                                document.getElementById('end_date').disabled = true;
                            }else{
                                document.getElementById('end_date').value = '';
                                document.getElementById('end_date').disabled = false;
                            }
                        }
                      </script>
                      <div class="row">
                        <div class="col">
                          <div class="text-end">
                            <button class="btn btn-primary" id="export_data" name="export_data" type="submit">{{__('data_export.download_excel_data')}}</button>
                            <a class="btn btn-danger" href="{{route('index')}}">{{__('constant.back')}}</a>
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
