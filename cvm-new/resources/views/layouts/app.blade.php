<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <title>Master - Industries - CV Manager</title>
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel='stylesheet' href="{{ asset('css/bootstrap.min.css') }}">
    <link rel='stylesheet' href="{{ asset('css/style.css') }}">

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" />

    <!-- select2 -->
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />

    <!-- select2-bootstrap4-theme -->
    <link href="{{ asset('css/select2-bootstrap4.css') }}" rel="stylesheet" />

    <!-- Icons css -->
    {{-- <link rel="stylesheet" href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.7/css/dataTables.checkboxes.css"/> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

    <!-- select2 -->
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />

    <!-- select2-bootstrap4-theme -->
    <link href="{{ asset('css/select2-bootstrap4.css') }}" rel="stylesheet" />
</head>

<body>
    <style>
        .error {
            color: red !important;
        }
    </style>
    @include('layouts.header')
    <div id="res_message"></div>
    @if ($message = Session::get('success'))
        <div class="toast active">
            <div class="toast-content">
                <i class="fa fa-solid fa-check check"></i>

                <div class="message">
                    <span class="text text-2">{{ $message }}</span>
                </div>
            </div>
            <i class="fa fa-times close"></i>
            <div class="progress active"></div>
        </div>
    @endif

    @yield('content')
</body>
@include('layouts.footer')
@stack('scripts')
<script>
    $(document).ready(function() {
        $('.toast').fadeIn().delay(4000).fadeOut();
    });
</script>

</html>
