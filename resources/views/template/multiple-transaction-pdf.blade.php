<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('template.technical_service_forms')}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container" style="display: block; margin-left: 2%; margin-right: 2%; padding-left:0%;">
        @php $i = 0; @endphp
        @foreach ($data as $item)
        <table class="table table-bordered mb-5" style="min-width: 675px;">
            <tbody>
                <tr>
                    <td style="width:30%; padding:4px; padding-left:8px; font-weight:bold;">{{__('template.corporation_name')}}</td>
                    <td style="width:70%; padding:4px;">{{$item->corporation_name}}</td>
                </tr>
                <tr>
                    <td style="width:30%; padding:4px; padding-left:8px; font-weight:bold;">{{__('template.department_name')}}</td>
                    <td style="width:70%; padding:4px;">{{$item->department_name}}</td>
                </tr>
                <tr>
                    <td style="width:30%; padding:4px; padding-left:8px; font-weight:bold;">{{__('template.service_start_day')}}</td>
                    <td style="width:70%; padding:4px;">{{$item->created_at}}</td>
                </tr>
                <tr>
                    <td style="width:30%; padding:4px; padding-left:8px; font-weight:bold;">{{__('template.device_name')}}</td>
                    <td style="width:70%; padding:4px;">{{$item->device_name}}</td>
                </tr>
                <tr>
                    <td style="width:30%; padding:4px; padding-left:8px; font-weight:bold;">{{__('template.device_brand')}}</td>
                    <td style="width:70%; padding:4px;">{{$item->device_brand}}</td>
                </tr>
                <tr>
                    <td style="width:30%; padding:4px; padding-left:8px; font-weight:bold;">{{__('template.device_model')}}</td>
                    <td style="width:70%; padding:4px;">{{$item->device_model}}</td>
                </tr>
                <tr>
                    <td style="width:30%; padding:4px; padding-left:8px; font-weight:bold;">{{__('template.device_serial_no')}}</td>
                    <td style="width:70%; padding:4px;">{{$item->device_serial_no}}</td>
                </tr>
                <tr>
                    <td style="width:30%; padding:4px; padding-left:8px; font-weight:bold;">{{__('template.personel')}}</td>
                    <td style="width:70%; padding:4px;">{{$item->personel_name}}</td>
                </tr>
                <tr>
                    <td style="width:30%; padding:4px; padding-left:8px; font-weight:bold;">{{__('template.description')}}</td>
                    <td style="width:70%; padding:4px;">{{$item->description}}</td>
                </tr>
                <tr>
                    <td style="width:30%; padding:4px; padding-left:8px; font-weight:bold;">{{__('template.verifier')}}</td>
                    <td style="width:70%; padding:4px;">{{$item->verifier_name}}</td>
                </tr>
                <tr>
                    <td style="width:30%; padding:4px; padding-left:8px; font-weight:bold;">{{__('template.verifier_tel')}}</td>
                    <td style="width:70%; padding:4px;">{{$item->verifier_tel}}</td>
                </tr>
            </tbody>
        </table>
        @php $i++; @endphp
        @if($i == 2)
        <br><br><br><br><br><br><br><br>
        @php $i=0; @endphp
        @endif
        @endforeach
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>
