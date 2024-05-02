@extends('constant.content')
@section('title',__('product.products'))

@section('content')
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3>{{__('product.products')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('product-controller.index')}}">{{__('product.products')}}</a></li>
              <li class="breadcrumb-item">{{__('product.update_product')}}</li>
            </ol>
          </div>
          <div class="col-sm-6 d-flex justify-content-end">
              <!-- Bookmark Start-->
              <div class="bookmark">
                <ul>
                  <!--<li><a href="#"><i data-feather="plus"></i></a></li>-->
                  <li><a href="{{route('device-controller.add-drop',$product->id)}}"><button class="btn btn-primary" type="button">{{__('product.add_drop')}}</button></a></li>
                  <li><a href="{{route('product-controller.index')}}"><button class="btn btn-primary" type="button">{{__('constant.back')}}</button></a></li>
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
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body">
                  <div class="form theme-form">
                    <form class="needs-validation" novalidate="" action="{{ route('product-controller.update',$product->id) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="row">
                        <div class="row mb-3">
                          <label class="form-label" for="corporation_id">{{__('product.corporation_name')}}<span class="text-danger">*</span></label>
                          <div class="col col-12 col-sm-8 col-md-9 col-xl-10 mt-2">
                            <select class="form-select digits" id="corporation_id" name="corporation_id" required="required">
                              <option value="" disabled selected>{{__('constant.choose')}}</option>
                              @foreach ($corporations as $item)
                              <option @if($product->corporation_id == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                              @endforeach
                            </select>
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('product.corporation_name_error')}}</div>
                          </div>
                          <div class="col col-12 col-sm-4 col-md-3 col-xl-2 mt-2">
                              <a href="{{route('corporation-controller.create')}}"><button class="btn btn-primary" style="width: 100%" type="button">{{__('product.new_corporation')}}</button></a>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col col-12">
                          <div class="mb-3">
                            <label class="form-label" for="name">{{__('product.product_name')}}</label><span class="text-danger">*</span>
                            <input class="form-control" id="name" name="name" type="text" required="required" placeholder="{{__('product.product_name_placeholder')}}" value="{{ $product->name }}">
                            <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('product.product_name_error')}}</div>
                          </div>
                        </div>
                        <!--
                        <div class="col col-12 col-md-6 col-xl-6">
                          <div class="mb-3">
                            <label class="form-label" for="device_count">{{__('general.device_count')}}</label><span class="text-danger">*</span>
                            <input class="form-control" id="device_count" name="device_count" type="number" min="0" placeholder="{{__('general.device_count_placeholder')}}" required="required" value="{{ $product->device_count }}">
                            <div class="valid-feedback px-1">{{__('general.looks_good')}}</div>
                            <div class="invalid-feedback px-1">{{__('general.device_count_error')}}</div>
                          </div>
                        </div>
                    -->
                      </div>
                      <div class="row">
                        <div class="col col-12 col-md-6">
                          <div class="mb-3">
                            <label class="form-label" for="start_date">{{__('product.start_date')}}</label>
                            <div class="row">
                                <div class="col">
                                    <select class="form-select digits" id="start_date_day" name="start_date_day" required="required">
                                      <option value="" disabled selected>{{__('product.day')}}</option>
                                      @for ($i=1;$i<32;$i++)
                                        <option @if($start_day == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                      @endfor
                                    </select>
                                    <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                                    <div class="invalid-feedback px-1">{{__('product.pick_day')}}</div>
                                </div>
                                <div class="col">
                                    <select class="form-select digits"  id="start_date_month" name="start_date_month" required="required">
                                      <option value="" disabled selected>{{__('product.month')}}</option>
                                      <option @if($start_month == 1) selected @endif value="1">{{__('product.january')}}</option>
                                      <option @if($start_month == 2) selected @endif value="2">{{__('product.february')}}</option>
                                      <option @if($start_month == 3) selected @endif value="3">{{__('product.march')}}</option>
                                      <option @if($start_month == 4) selected @endif value="4">{{__('product.april')}}</option>
                                      <option @if($start_month == 5) selected @endif value="5">{{__('product.may')}}</option>
                                      <option @if($start_month == 6) selected @endif value="6">{{__('product.june')}}</option>
                                      <option @if($start_month == 7) selected @endif value="7">{{__('product.july')}}</option>
                                      <option @if($start_month == 8) selected @endif value="8">{{__('product.august')}}</option>
                                      <option @if($start_month == 9) selected @endif value="9">{{__('product.september')}}</option>
                                      <option @if($start_month == 10) selected @endif value="10">{{__('product.october')}}</option>
                                      <option @if($start_month == 11) selected @endif value="11">{{__('product.november')}}</option>
                                      <option @if($start_month == 12) selected @endif value="12">{{__('product.december')}}</option>
                                    </select>
                                    <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                                    <div class="invalid-feedback px-1">{{__('product.pick_month')}}</div>
                                </div>
                                @php $year=date("Y");@endphp
                                <div class="col">
                                    <select class="form-select digits" id="start_date_year" name="start_date_year" required="required">
                                      <option value="" disabled selected>{{__('product.year')}}</option>
                                      @for($i=1990;$i<=$year;$i++)
                                        <option @if($start_year == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                      @endfor
                                    </select>
                                    <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                                    <div class="invalid-feedback px-1">{{__('product.pick_year')}}</div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="col col-12 col-md-6">
                            <div class="mb-3">
                              <label class="form-label" for="end_date">{{__('product.end_date')}}</label>
                              <div class="row">
                                  <div class="col">
                                      <select class="form-select digits" id="end_date_day" name="end_date_day" required="required">
                                        <option value="" disabled selected>{{__('product.day')}}</option>
                                        @for ($i=1;$i<32;$i++)
                                          <option @if($end_day == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                        @endfor
                                      </select>
                                      <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                                      <div class="invalid-feedback px-1">{{__('product.pick_day')}}</div>
                                  </div>
                                  <div class="col">
                                      <select class="form-select digits" id="end_date_month" name="end_date_month" required="required">
                                        <option value="" disabled selected>{{__('product.month')}}</option>
                                        <option @if($end_month == 1) selected @endif value="1">{{__('product.january')}}</option>
                                        <option @if($end_month == 2) selected @endif value="2">{{__('product.february')}}</option>
                                        <option @if($end_month == 3) selected @endif value="3">{{__('product.march')}}</option>
                                        <option @if($end_month == 4) selected @endif value="4">{{__('product.april')}}</option>
                                        <option @if($end_month == 5) selected @endif value="5">{{__('product.may')}}</option>
                                        <option @if($end_month == 6) selected @endif value="6">{{__('product.june')}}</option>
                                        <option @if($end_month == 7) selected @endif value="7">{{__('product.july')}}</option>
                                        <option @if($end_month == 8) selected @endif value="8">{{__('product.august')}}</option>
                                        <option @if($end_month == 9) selected @endif value="9">{{__('product.september')}}</option>
                                        <option @if($end_month == 10) selected @endif value="10">{{__('product.october')}}</option>
                                        <option @if($end_month == 11) selected @endif value="11">{{__('product.november')}}</option>
                                        <option @if($end_month == 12) selected @endif value="12">{{__('product.december')}}</option>
                                      </select>
                                      <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                                      <div class="invalid-feedback px-1">{{__('product.pick_month')}}</div>
                                  </div>
                                  @php $year=date("Y");@endphp
                                  <div class="col">
                                      <select class="form-select digits" id="end_date_year" name="end_date_year" required="required">
                                        <option value="" disabled selected>{{__('product.year')}}</option>
                                        @for($i=$year;$i<=$year+20;$i++)
                                          <option @if($end_year == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                        @endfor
                                      </select>
                                      <div class="valid-feedback px-1">{{__('constant.looks_good')}}</div>
                                      <div class="invalid-feedback px-1">{{__('product.pick_year')}}</div>
                                  </div>
                              </div>
                              <div class="valid-feedback px-1">{{__('product.looks_good')}}</div>
                              <div class="invalid-feedback px-1">{{__('product.pick_year')}}</div>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col">
                          <div class="text-end mt-2">
                            <button class="btn btn-primary" id="edit_product" name="edit_product" type="submit">{{__('constant.update')}}</button>
                            <a class="btn btn-danger" href="{{route('product-controller.index')}}">{{__('constant.back')}}</a>
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
