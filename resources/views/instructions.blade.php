@extends('constant.content')
@section('title',__('instructions.instructions'))

@section('content')

<!-- Sweet Alert -->
@if(session('success'))
<script>swal("{{__('constant.success')}}", "{{__('constant.successful')}}", "success");</script>
@elseif(session('error'))
<script>swal("{{__('constant.error')}}", "{{__('constant.unsuccessful')}}", "error");</script>
@elseif(session('auth_error'))
<script>swal("{{__('constant.error')}}", "{{__('constant.auth_error')}}", "error");</script>
@elseif(session('no_transaction_error'))
<script>swal("{{__('constant.error')}}", "{{__('instructions.no_form_found')}}", "error");</script>
@endif
<div class="page-body">
    <div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3>{{__('instructions.instructions')}}</h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('corporation-controller.index')}}">{{__('constant.main_page')}}</a></li>
              <li class="breadcrumb-item">{{__('instructions.instructions')}}</li>
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
    <!-- Container-fluid starts-->
    <div class="container-fluid dashboard-default-sec">
      <div class="row">

        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="card profile-greeting" style="min-height:450px;">
              <div class="card-header">
                <div class="header-top">
                  <div class="setting-list bg-primary position-unset">
                  </div>
                </div>
              </div>
              <div class="card-body text-center p-t-0">
                <h3 @if(!Auth::user()->theme) class="font-light mb-4" @endif style="text-align:left;">{{__('instructions.users')}}</h3>
                <p @if(Auth::user()->theme) style="color:black; text-align:left;" @else style="text-align:left;" @endif>
                  - {{__('instructions.users1')}}. <br>
                  - {{__('instructions.users2')}}. <br>
                  - {{__('instructions.users3')}}. <br>
                  - {{__('instructions.users4')}}. <br>
                  - {{__('instructions.users5')}}. <br>
                  - {{__('instructions.users6')}}. <br>
                  - {{__('instructions.users7')}}. <br>
                  - {{__('instructions.users8')}}. <br>
                  - {{__('instructions.users9')}}. <br>
                  - {{__('instructions.users10')}}. <br>
                </p>
                <a href="{{route('user-controller.index')}}"><button class="btn btn-light" style="margin-top:32px">{{__('instructions.go_to_page')}}</button></a>
              </div>
            </div>
        </div>
        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="card profile-greeting" style="min-height:450px;">
              <div class="card-header">
                <div class="header-top">
                  <div class="setting-list bg-primary position-unset">
                  </div>
                </div>
              </div>
              <div class="card-body text-center p-t-0">
                <h3 @if(!Auth::user()->theme) class="font-light mb-4" @endif style="text-align:left;">{{__('instructions.jobs')}}</h3>
                <p @if(Auth::user()->theme) style="color:black; text-align:left;" @else style="text-align:left;" @endif>
                  - {{__('instructions.jobs1')}}. <br>
                  - {{__('instructions.jobs2')}}. <br>
                  - {{__('instructions.jobs3')}}. <br>
                  - {{__('instructions.jobs4')}}. <br>
                  - {{__('instructions.jobs5')}}. <br>
                  - {{__('instructions.jobs6')}}. <br>
                  - {{__('instructions.jobs7')}}. <br>
                </p>
                <a href="{{route('job-controller.index',['filter'=>0,'selectedPage'=>1])}}"><button class="btn btn-light" style="margin-top:107px">{{__('instructions.go_to_page')}}</button></a>
              </div>
            </div>
        </div>
        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="card profile-greeting" style="min-height:450px;">
              <div class="card-header">
                <div class="header-top">
                  <div class="setting-list bg-primary position-unset">
                  </div>
                </div>
              </div>
              <div class="card-body text-center p-t-0">
                <h3 @if(!Auth::user()->theme) class="font-light mb-4" @endif style="text-align:left;">{{__('instructions.messages')}}</h3>
                <p @if(Auth::user()->theme) style="color:black; text-align:left;" @else style="text-align:left;" @endif>
                  - {{__('instructions.messages1')}}. <br>
                  - {{__('instructions.messages2')}}. <br>
                  - {{__('instructions.messages3')}}. <br>
                  - {{__('instructions.messages4')}}. <br>
                  - {{__('instructions.messages5')}}. <br>
                </p>
                <a href="{{route('message-controller.index',['filter'=>0,'selectedPage'=>1])}}"><button class="btn btn-light" style="margin-top:157px">{{__('instructions.go_to_page')}}</button></a>
              </div>
            </div>
        </div>
        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="card profile-greeting" style="min-height:450px;">
              <div class="card-header">
                <div class="header-top">
                  <div class="setting-list bg-primary position-unset">
                  </div>
                </div>
              </div>
              <div class="card-body text-center p-t-0">
                <h3 @if(!Auth::user()->theme) class="font-light mb-4" @endif style="text-align:left;">{{__('instructions.corporation_info')}}</h3>
                <p @if(Auth::user()->theme) style="color:black; text-align:left;" @else style="text-align:left;" @endif>
                  - {{__('instructions.corporation_info1')}}. <br>
                  - {{__('instructions.corporation_info2')}}. <br>
                </p>
                <a href="{{route('company-controller.edit',[Auth::user()->company_id])}}"><button class="btn btn-light" style="margin-top:232px">{{__('instructions.go_to_page')}}</button></a>
              </div>
            </div>
        </div>
        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="card profile-greeting" style="min-height:450px;">
              <div class="card-header">
                <div class="header-top">
                  <div class="setting-list bg-primary position-unset">
                  </div>
                </div>
              </div>
              <div class="card-body text-center p-t-0">
                <h3 @if(!Auth::user()->theme) class="font-light mb-4" @endif style="text-align:left;">{{__('instructions.transactions')}}</h3>
                <p @if(Auth::user()->theme) style="color:black; text-align:left;" @else style="text-align:left;" @endif>
                  - {{__('instructions.transactions1')}}. <br>
                  - {{__('instructions.transactions2')}}. <br>
                  - {{__('instructions.transactions3')}}. <br>
                  - {{__('instructions.transactions4')}}. <br>
                  - {{__('instructions.transactions5')}}. <br>
                  - {{__('instructions.transactions6')}}. <br>
                </p>
                <a href="{{route('dev-transaction-controller.index')}}"><button class="btn btn-light" style="margin-top:107px">{{__('instructions.go_to_page')}}</button></a>
              </div>
            </div>
        </div>
        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="card profile-greeting" style="min-height:450px;">
              <div class="card-header">
                <div class="header-top">
                  <div class="setting-list bg-primary position-unset">
                  </div>
                </div>
              </div>
              <div class="card-body text-center p-t-0">
                <h3 @if(!Auth::user()->theme) class="font-light mb-4" @endif style="text-align:left;">{{__('instructions.data')}}</h3>
                <p @if(Auth::user()->theme) style="color:black; text-align:left;" @else style="text-align:left;" @endif>
                  - {{__('instructions.data1')}}. <br>
                  - {{__('instructions.data2')}}. <br>
                </p>
                <a href="{{route('data-output-controller.create')}}"><button class="btn btn-light" style="margin-top:227px">{{__('instructions.go_to_page')}}</button></a>
              </div>
            </div>
        </div>
        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="card profile-greeting" style="min-height:450px;">
              <div class="card-header">
                <div class="header-top">
                  <div class="setting-list bg-primary position-unset">
                  </div>
                </div>
              </div>
              <div class="card-body text-center p-t-0">
                <h3 @if(!Auth::user()->theme) class="font-light mb-4" @endif style="text-align:left;">{{__('instructions.corporations')}}</h3>
                <p @if(Auth::user()->theme) style="color:black; text-align:left;" @else style="text-align:left;" @endif>
                  - {{__('instructions.corporations1')}}. <br>
                  - {{__('instructions.corporations2')}}. <br>
                  - {{__('instructions.corporations3')}}. <br>
                  - {{__('instructions.corporations4')}}. <br>
                  - {{__('instructions.corporations5')}} ,<br>
                  - {{__('instructions.corporations6')}} ,<br>
                  - {{__('instructions.corporations7')}}. <br>
                </p>
                <a href="{{route('corporation-controller.index')}}"><button class="btn btn-light" style="margin-top:107px">{{__('instructions.go_to_page')}}</button></a>
              </div>
            </div>
        </div>
        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="card profile-greeting" style="min-height:450px;">
              <div class="card-header">
                <div class="header-top">
                  <div class="setting-list bg-primary position-unset">
                  </div>
                </div>
              </div>
              <div class="card-body text-center p-t-0">
                <h3 @if(!Auth::user()->theme) class="font-light mb-4" @endif style="text-align:left;">{{__('instructions.departments')}}</h3>
                <p @if(Auth::user()->theme) style="color:black; text-align:left;" @else style="text-align:left;" @endif>
                    - {{__('instructions.departments1')}}. <br>
                    - {{__('instructions.departments2')}}. <br>
                    - {{__('instructions.departments3')}}. <br>
                    - {{__('instructions.departments4')}}. <br>
                    - {{__('instructions.departments5')}}. <br>
                    - {{__('instructions.departments6')}}. <br>
                    - {{__('instructions.departments7')}} ,<br>
                    - {{__('instructions.departments8')}} ,<br>
                    - {{__('instructions.departments9')}}. <br>
                </p>
                <a href="{{route('department-controller.index')}}"><button class="btn btn-light" style="margin-top:57px">{{__('instructions.go_to_page')}}</button></a>
              </div>
            </div>
        </div>
        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="card profile-greeting" style="min-height:450px;">
              <div class="card-header">
                <div class="header-top">
                  <div class="setting-list bg-primary position-unset">
                  </div>
                </div>
              </div>
              <div class="card-body text-center p-t-0">
                <h3 @if(!Auth::user()->theme) class="font-light mb-4" @endif style="text-align:left;">{{__('instructions.products')}}</h3>
                <p @if(Auth::user()->theme) style="color:black; text-align:left;" @else style="text-align:left;" @endif>
                  - {{__('instructions.products1')}}. <br>
                  - {{__('instructions.products2')}}. <br>
                  - {{__('instructions.products3')}}. <br>
                  - {{__('instructions.products4')}}. <br>
                  - {{__('instructions.products5')}}. <br>
                  - {{__('instructions.products6')}} ,<br>
                  - {{__('instructions.products7')}} ,<br>
                  - {{__('instructions.products8')}}. <br>
                </p>
                <a href="{{route('product-controller.index')}}"><button class="btn btn-light" style="margin-top:32px">{{__('instructions.go_to_page')}}</button></a>
              </div>
            </div>
        </div>
        <div class="col-xl-6 box-col-12 des-xl-100">
            <div class="card profile-greeting" style="min-height:450px;">
              <div class="card-header">
                <div class="header-top">
                  <div class="setting-list bg-primary position-unset">
                  </div>
                </div>
              </div>
              <div class="card-body text-center p-t-0">
                <h3 @if(!Auth::user()->theme) class="font-light mb-4" @endif style="text-align:left;">{{__('instructions.devices')}}</h3>
                <p @if(Auth::user()->theme) style="color:black; text-align:left;" @else style="text-align:left;" @endif>
                  - {{__('instructions.devices1')}}. <br>
                  - {{__('instructions.devices2')}}. <br>
                  - {{__('instructions.devices3')}}. <br>
                  - {{__('instructions.devices4')}}. <br>
                  - {{__('instructions.devices5')}}. <br>
                  - {{__('instructions.devices6')}}. <br>
                  - {{__('instructions.devices7')}} ,<br>
                  - {{__('instructions.devices8')}} ,<br>
                  - {{__('instructions.devices9')}}. <br>
                </p>
                <a href="{{route('device-controller.index')}}"><button class="btn btn-light" style="margin-top:7px">{{__('instructions.go_to_page')}}</button></a>
              </div>
            </div>
        </div>


      </div>
    </div>
    <!-- Container-fluid Ends-->
  </div>
@endsection
