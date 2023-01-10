<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="{{ url('public/img/fav.png') }}">
<title>{{\Config::get('app.name')}}</title>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{url('public/plugins/fontawesome-free/css/all.min.css')}}">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="{{url('public/css/adminlte.min.css')}}">
<link rel="stylesheet" href="{{url('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{url('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ url('public/plugins/datatables-buttons/css/buttons.bootstrap4.css')}}">
<link rel="stylesheet" type="text/css" href="{{ url('public/plugins/datatables-buttons/css/buttons.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ url('public/css/toastr.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('public/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('public/css/dataTables.checkboxes.css')}}">
<style>
    .dataTables_scroll
    {
        overflow:auto;
    }
    .dataTables_scrollHeadInner, .table{
        width:100%!important
    };
</style>
@stack('css')
