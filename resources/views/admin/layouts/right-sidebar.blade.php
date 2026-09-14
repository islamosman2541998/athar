<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title px-3 py-4">
            <a href="javascript:void(0);" class="right-bar-toggle float-end">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
            <h5 class="m-0">@lang('admin.settings')</h5>
        </div>

        <!-- Settings -->
        <hr class="mt-0">
        
        <div class="d-flex  justify-content-center">
            <div class="dropdown d-mobile-display">
                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="font-size-16 navbar-custom-color"> @lang('admin.languages') </span> <img class="ms-2"
                        src="{{ admin_path('images/flags/'. app()->getLocale() .'_flag.jpg')}}" alt="Header Language" height="20">
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                @foreach($locals as $local)
                <li>
                    <a href="{{ \LaravelLocalization::getLocalizedURL($local , \Request::fullUrl() ) }}" class="dropdown-item notify-item">
                        <img src="{{ admin_path('images/flags/'. $local .'_flag.jpg')}}" alt="{{ $local }}" height="13">
                         <span class="align-middle"> {{ Locale::getDisplayName($local) }}</span>
                    </a>
                </li> 
                @endforeach
                </div>
            </div>
        </div>
        
        <h6 class="text-center mb-0">@lang('admin.choose_layouts')</h6>

        <div class="p-4">
            <div class="mb-2">
                <img src="{{ admin_path('images/layouts/layout-1.jpg') }}" class="img-fluid img-thumbnail" alt="Layouts-1">
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch">
                <label class="form-check-label" for="light-mode-switch">@lang('admin.light_mode')</label>
            </div>

            <div class="mb-2">
                <img src="{{ admin_path('/images/layouts/layout-2.jpg') }}" class="img-fluid img-thumbnail" alt="Layouts-2">
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css">
                <label class="form-check-label" for="dark-mode-switch">@lang('admin.dark_mode')</label>
            </div>


        </div>

    </div> <!-- end slimscroll-menu-->
</div>


