<!doctype html>
<html lang="en" @if ($current_lang == 'ar') dir="rtl" @else  dir="ltr" @endif>

<head>
    <meta charset="utf-8">
    <title> {{ config('app.name') }} | @lang('admin.login') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ @$adminDashboardTheme->icon ? asset($adminDashboardTheme->icon) : admin_path('images/logos/icon-light.png') }}">

    <!-- App Css-->
    @if ($current_lang == 'ar')
        <link href="{{ asset('assets/css/bootstrap-rtl.min.css') }}" id="bootstrap-style" rel="stylesheet"
            type="text/css">
        <link href="{{ asset('assets/css/app-rtl.min.css') }}" id="app-style" rel="stylesheet" type="text/css">
    @else
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css">
    @endif
    <link href="{{ asset('assets/css/custom.css?v=0.0.1') }}" rel="stylesheet" type="text/css">
    @include('includes.font-styles', ['scope' => 'admin'])


</head>

<body>

   

    <!-- Begin page -->
    <div class="accountbg"
        style="background: url('{{ @$adminLoginTheme->background != null ? asset(@$adminLoginTheme->background) : admin_path('images/background.jpg') }}');background-size: cover;background-position: center;">
    </div>

    <div class="flower-login account-pages mt-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-5 col-xl-4">
                    <div class="card  border-0">
                        <div class="logo-box card-body border-0"
                            style="background-color:{{ @$adminLoginTheme->box_color }}; color:{{ @$adminLoginTheme->font_color }}">
                            <div class="text-center">
                                <div class="col-md-12" style="margin-top: 42px;">
                                    <a href="{{ route('admin.login') }}">
                                        <img src="{{ @$adminLoginTheme->logo_image != null ? asset(@$adminLoginTheme->logo_image) : admin_path('images/logos/logoLightF.png') }}"
                                            height="100" width="200" alt="logo"></a>
                                </div>
                                @include('admin.layouts.message')
                            </div>
                            <div class="p-3"
                                style="margin-top: 89px;">
                                <h4 class="text-center">
                                @lang('admin.welcome_back') </h4>
                                <p class="text-muted text-center mb-4"
                                    style="color:{{ @$adminLoginTheme->font_color }} !important"> @lang('admin.sign_in')
                                </p>

                                <form class="form-horizontal" method="POST" action="{{ route('admin.post-login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="username"> @lang('admin.email') </label>
                                        <input id="email" class="form-control bg-transparent" type="email"
                                            name="email" value="{{ old('email') }}" required autofocus>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="userpassword"> @lang('admin.password') </label>
                                        <input id="password" class="form-control bg-transparent" type="password"
                                            name="password" required autocomplete="current-password">
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-sm-12 text-center">
                                            <button
                                                class="btn btn-primary w-md waves-effect waves-light border-0 hover-cutom"
                                                type="submit"
                                                style=" background-color:{{ @$adminLoginTheme->button_color }};">
                                                @lang('admin.login') </button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
