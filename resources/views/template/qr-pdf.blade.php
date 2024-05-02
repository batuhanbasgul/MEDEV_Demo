<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$data[0]->product_name}}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container mt-5" style="display: block; margin-left: 2%; margin-right: 2%; padding-left:0%;">
        <h2 class="text-center" style="margin: auto; width: 675px; margin-bottom: 50px;">{{session('pdf_title')}}</h2>
        <table class="table table-bordered mb-5" style="min-width: 675px;">
            <thead>
                <tr class="table-danger">
                    <th scope="col" style="min-width: 100px">{{__('template.qr')}}</th>
                    <th scope="col" style="min-width: 150px">{{__('template.device')}}</th>
                    <th scope="col" style="min-width: 150px">{{__('template.corporation')}}</th>
                    <th scope="col" style="min-width: 150px">{{__('template.department')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td><img src="{{asset($item->qr_code_path)}}" alt="" style="max-width:100px"></td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->corporation_name}}</td>
                    <td>{{$item->department_name}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/app.js') }}" type="text/js"></script>
</body>
</html>
