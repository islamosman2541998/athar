<header id="page-topbar" style="background-color:{{ @$adminDashboardTheme->navbar_background }};">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box" style="background-color:{{ @$adminDashboardTheme->side_navbar_background }};">
                <a href="{{ route('site.home') }}" class="logo logo-dark" target="_blank">
                    <span class="logo-sm">
                        {{-- <img src="{{ asset('admin/assets/images/logo.png') }}" alt="" height="22"> --}}
                        <img src="{{ @$adminDashboardTheme->icon != null ?  asset(@$adminDashboardTheme->icon) : admin_path('images/logos/icon-dark.png') }}" alt="" height="34">
                    </span>
                    <span class="logo-lg">
                        {{-- <img src="{{ asset('admin/assets/images/logo-dark.png') }}" alt="" height="17"> --}}
                        <img src="{{@$adminDashboardTheme->logo != null ?  asset(@$adminDashboardTheme->logo) :  admin_path('/images/logos/banner-dark2.png') }}" alt="" height="54">
                    </span>
                </a>

                <a href="{{ route('site.home') }}" class="logo logo-light" target="_blank">
                    <span class="logo-sm">
                        {{-- <img src="{{ asset('admin/assets/images/logo-light.png') }}" alt="" height="22"> --}}
                        <img src="{{ @$adminDashboardTheme->icon != null ?  asset(@$adminDashboardTheme->icon) : admin_path('images/logos/icon-dark.png') }}" alt="" height="34">
                    </span>
                    <span class="logo-lg">
                        {{-- <img src="{{ asset('admin/assets/images/logo-light.png') }}" alt="" height="36"> --}}
                        <img src="{{ @$adminDashboardTheme->logo != null ?  asset(@$adminDashboardTheme->logo) : admin_path('/images/logos/banner-dark2.png') }}" alt="" height="54">

                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-menu navbar-custom-color"></i>
            </button>

            <div class="d-none d-sm-block ms-2">
                <h4 class="page-title navbar-custom-color">@yield('title_page', trans('admin.dashboard'))</h4>
            </div>
        </div> 

        @if(auth()->user())
        <div class="d-flex">
            <div class="dropdown d-none d-lg-inline-block me-2">
                <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen navbar-custom-color"></i>
                </button>
            </div>
            <div class="dropdown d-none d-md-block me-2">
                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="font-size-16 navbar-custom-color"> @lang('admin.languages') </span> <img class="ms-2"
                        src="{{ admin_path('images/flags/'. app()->getLocale() .'_flag.jpg')}}" alt="Header Language" height="20">
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                @foreach($locals as $local)
                   <li>
                    <a href="{{ \LaravelLocalization::getLocalizedURL($local , \Request::fullUrl() ) }}" class="dropdown-item notify-item">
                        <img src="{{ admin_path('images/flags/'. $local .'_flag.jpg')}}" alt="{{ $local }}" height="13"> <span
                            class="align-middle"> {{ \Locale::getDisplayName($local) }}</span>
                    </a>
                </li> 
                @endforeach                 
                </div>
            </div>
            <div class="dropdown d-inline-block me-2">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ion ion-md-notifications navbar-custom-color"></i>
                    <span class="badge bg-danger rounded-pill">{{ Auth::user()->unreadNotifications->count()  }}</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0 font-size-16"> @lang('admin.notifications') ({{ Auth::user()->unreadNotifications->count()  }}) 
                                    @if (Auth::user()->unreadNotifications->count() > 2)
                                        <a href="{{ route('admin.notification.read') }}">{{ trans('admin.Read_Notification') }} </a>      
                                    @endif
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        @foreach (Auth::user()->unreadNotifications  as $notifications )
                        <a href="{{ route('admin.contact-us.show',$notifications->data['contact_id']) }}" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                        <i class="mdi mdi-email-outline"></i>
                                    </span>
                                </div>
                                <div class="flex-1">
                                    <h6 class="mt-0 font-size-15 mb-1">
                                        {{ $notifications->data['email'] }}
                                    </h6>
                                  
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">
                                            {{ $notifications->created_at }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach



                    </div>
                    <div class="p-2 border-top">
                        <div class="d-grid">
                            <a class="btn btn-sm btn-link font-size-14  text-center"  href="{{ route('admin.contact-us.index') }}">
                                @lang('admin.view_all')
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ auth()->user()->image ? asset(auth()->user()->image) : admin_path('images/users/default.png') }}"
                        alt="Header Avatar">
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ route('site.home') }}" target="_blank"> @lang('admin.site')</a>
                    <a class="dropdown-item" href="{{ route('admin.profile.edit',auth()->user()->id) }}"> @lang('admin.profile')</a>
             
                    <a class="dropdown-item d-block" href="{{ route('admin.settings.index') }}">@lang('admin.settings')</a>
                    <div class="dropdown-divider"></div>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <a class="dropdown-item text-danger" href="#"
                            onclick="event.preventDefault();
                        this.closest('form').submit();">@lang('admin.logout')</a>
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="mdi mdi-spin mdi-cog navbar-custom-color"></i>
                </button>
            </div>

        </div>
        @endif
    </div>
</header>
