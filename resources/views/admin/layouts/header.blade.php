<head>
    <meta charset="utf-8">

    <title> {{ config('app.name')  }} | @yield('title', 'Athar')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ @$adminDashboardTheme->icon != null ?  asset(@$adminDashboardTheme->icon ) : admin_path('images/logos/icon-light.png') }}">

    <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/c3/c3.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Bootstrap Css -->
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css">

    <!-- App Css-->
    @if(app()->getLocale()== "ar")
        <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/app-rtl.min.css') }}" id="app-style" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/custom-rtl.css') }}" id="app-style" rel="stylesheet" type="text/css">
    @else
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css">
    @endif

    <link href="{{ asset('assets/css/custom.css') }}" id="app-style" rel="stylesheet" type="text/css">

    @include('includes.font-styles', ['scope' => 'admin'])

    @yield('style')

    <style>
         .navbar-custom-color {
            color: <?php echo @$adminDashboardTheme->navbar_color  ?> !important ;
        };

        .side-navbar-custom-color a, .side-navbar-custom-color  i, .side-navbar-custom-color span, .side-navbar-custom-color p {
            color: <?php echo @$adminDashboardTheme->side_navbar_color  ?> !important ;
        };







    </style>
</head>
