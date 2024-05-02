
@extends('constant.content')
@section('title',__('constant.main_page'))

@section('content')

<!-- Sweet Alert -->
@if(session('success'))
<script>swal("{{__('constant.success')}}", "{{__('constant.successful')}}", "success");</script>
@elseif(session('error'))
<script>swal("{{__('constant.error')}}", "{{__('constant.unsuccessful')}}", "error");</script>
@elseif(session('auth_error'))
<script>swal("{{__('constant.error')}}", "{{__('constant.auth_error')}}", "error");</script>
@elseif(session('no_transaction_error'))
<script>swal("{{__('constant.error')}}", "{{__('index.no_transaction_error')}}", "error");</script>
@endif
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid dashboard-default-sec">
      <div class="row">
        <div class="col-xl-6 box-col-12 des-xl-100">
          <div class="row">
            <div class="col-xl-12 col-md-12 box-col-6 des-xl-50">
              <div class="card profile-greeting">
                <div class="card-header">
                  <div class="header-top">
                    <div class="setting-list bg-primary position-unset">
                    </div>
                  </div>
                </div>
                <div class="card-body text-center p-t-0">
                  <h3 @if(!Auth::user()->theme) class="font-light" @endif>{{__('index.welcome')}}, {{Auth::user()->name}}!!</h3>
                  <p @if(Auth::user()->theme) style="color:black" @endif>{{__('index.welcome_text')}}
                    {{__('index.have_fun')}}.</p>
                  <a href="{{route('instructions')}}"><button class="btn btn-light">{{__('index.instructions')}}</button></a>
                </div>
                <div class="confetti">
                  <div class="confetti-piece"></div>
                  <div class="confetti-piece"></div>
                  <div class="confetti-piece"></div>
                  <div class="confetti-piece"></div>
                  <div class="confetti-piece"></div>
                  <div class="confetti-piece"></div>
                  <div class="confetti-piece"></div>
                  <div class="confetti-piece"></div>
                  <div class="confetti-piece"></div>
                  <div class="confetti-piece"></div>
                  <div class="confetti-piece"></div>
                  <div class="confetti-piece"></div>
                  <div class="confetti-piece"></div>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-md-6 col-sm-6 box-col-3 des-xl-25 rate-sec">
              <div class="card income-card card-primary">
                <div class="card-body text-center" style="min-height:211px">
                  <div class="round-box">
                    <i class="fa-solid fa-microchip"></i>
                  </div>
                  <h5>{{$activeDeviceCount}}</h5>
                  <p>{{__('index.active_device_count')}}</p><a class="btn-arrow arrow-primary" href="javascript:void(0)"></a>
                  <div class="parrten">
                    <i data-feather="target"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-md-6 col-sm-6 box-col-3 des-xl-25 rate-sec">
              <div class="card income-card card-secondary">
                <div class="card-body text-center" style="min-height:211px">
                  <div class="round-box">
                    <i class="fa-solid fa-paste"></i>
                  </div>
                  <h5>{{$transactionCount}}</h5>
                  <p>{{__('index.service_form_count')}}</p><a class="btn-arrow arrow-secondary" href="javascript:void(0)"></a>
                  <div class="parrten">
                    <i data-feather="target"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-50 box-col-6 des-xl-50">
            <div class="card latest-update-sec" style="min-height: 474px">
              <div class="card-header">
                <div class="header-top d-sm-flex align-items-center">
                  <h5>{{__('index.job_notifications')}}</h5>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordernone">
                    <tbody>
                        @if(count($uncompletedJobs) == 0)
                            <tr>
                                <div class="media index-m-info">
                                    <div class="media-body"><span>{{__('index.no_new_notification')}}</span>
                                    </div>
                                </div>
                            </tr>
                        @else
                            @foreach ($uncompletedJobs as $item)
                            <tr>
                                <td class="p-0">
                                    <a href="{{route('job-controller.show',$item->id)}}">
                                        <div class="media">
                                            <div class="media-body mb-1"><span>{{$item->job_title}}</span>
                                                <p>{{__('index.end_date')}} : {{$item->end_date}}</p>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="px-0 py-2">
                                    <a href="{{route('job-controller.my-jobs')}}">
                                        <div class="media index-m-info">
                                            <div class="media-body"><span>{{__('index.assigned_jobs')}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-50 box-col-6 des-xl-50">
              <div class="card latest-update-sec" style="min-height: 474px">
                <div class="card-header">
                  <div class="header-top d-sm-flex align-items-center">
                    <h5>{{__('index.message_notifications')}}</h5>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordernone">
                      <tbody>
                          @if(count($messageNotifications) == 0)
                              <tr>
                                <div class="media index-m-info">
                                    <div class="media-body"><span>{{__('index.no_new_message')}}</span>
                                    </div>
                                </div>
                              </tr>
                          @else
                              @foreach ($messageNotifications as $item)
                              <tr>
                                  <td class="p-0">
                                      <a href="{{route('message-controller.show',$item->id)}}">
                                          <div class="media">
                                              <div class="media-body mb-1"><span>{{$item->title}}</span>
                                                  <p>{{__('index.sender')}} : {{$item->sender_name}}</p>
                                              </div>
                                          </div>
                                      </a>
                                  </td>
                              </tr>
                              @endforeach
                              <tr>
                                  <td class="px-0 py-2">
                                      <a href="{{route('message-controller.index',['filter'=>0,'selectedPage'=>1])}}">
                                          <div class="media index-m-info">
                                              <div class="media-body"><span>{{__('index.all_messages')}}</span>
                                              </div>
                                          </div>
                                      </a>
                                  </td>
                              </tr>
                          @endif
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

        <div class="col-xl-12 box-col-12 des-xl-100 recent-order-sec">
            <div class="card">
              <div class="card-body" style="min-height:812px">
                <div class="table-responsive">
                  <h5 class="mb-4">{{__('index.last_transactions')}}</h5>
                  <table class="table table-bordernone">
                    <thead>
                      <tr>
                        <th>{{__('index.device')}}</th>
                        <th class="disappear-600">{{__('index.date')}}</th>
                        <th class="disappear-500">{{__('index.corporation')}}</th>
                        <th class="disappear-1250">{{__('index.department')}}</th>
                        <th class="disappear-800">{{__('index.personel')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $item)
                        <tr class="custom-cursor" onclick="document.location = '{{route('dev-transaction-controller.show',$item->id)}}';">
                          <td>
                            <p>{{$item->device_name}}</p>
                          </td>
                          <td class="disappear-600">
                            <p>{{$item->created_at}}</p>
                          </td>
                          <td class="disappear-500">
                            <p>{{$item->corporation_name}}</p>
                          </td>
                          <td class="disappear-1250">
                            <p>{{$item->department_name}}</p>
                          </td>
                          <td class="disappear-800">
                            <p>{{$item->personel_name}}</p>
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
        <div class="col-xl-12 box-col-12 des-xl-100 recent-order-sec">
            <div class="card">
              <div class="card-body" style="min-height:812px">
                <div class="table-responsive">
                  <h5 class="mb-4">{{__('index.last_products')}}</h5>
                  <table class="table table-bordernone">
                    <thead>
                      <tr>
                        <th>{{__('index.product_name')}}</th>
                        <th class="disappear-500">{{__('index.corporation')}}</th>
                        <th class="disappear-800">{{__('index.device_count')}}</th>
                        <th class="disappear-600">{{__('index.end_date')}}</th>
                        <th class="disappear-1250">{{__('index.status')}}</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $item)
                        <tr class="custom-cursor" onclick="document.location = '{{route('product-controller.edit',$item->id)}}';">
                          <td>
                            <div class="media">
                              <div class="media-body"><span>{{$item->name}}</span></div>
                            </div>
                          </td>
                          <td class="disappear-500">
                            <p>{{$item->corporation_name}}</p>
                          </td>
                          <td class="disappear-800">
                            <p>{{$item->device_count}}</p>
                          </td>
                          <td class="disappear-600">
                            <p>{{$item->end_date}}</p>
                          </td>
                          <td class="disappear-1250">
                            <p>
                            @if ($item->is_active)
                                <p>{{__('index.active')}}</p>
                            @else
                                <p>{{__('index.passive')}}</p>
                            @endif
                            </p>
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>

      </div>
    </div>
    <!-- Container-fluid Ends-->
  </div>
@endsection
