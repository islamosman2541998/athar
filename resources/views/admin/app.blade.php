<!doctype html>
<html lang="en" @if($current_lang == "ar") dir="rtl" @else  dir="ltr"  @endif>
    @include('admin.layouts.header')


    <body data-sidebar="dark" @if($current_lang == "ar") dir="rtl" @else  dir="ltr"  @endif>

        <!-- Loader -->
            {{-- <div id="preloader"><div id="status"><div class="spinner"></div></div></div> --}}

        <!-- Begin page -->
        <div id="layout-wrapper">

            <!-- Navbar ---- -->
            @include('admin.layouts.navbar')


            <!-- ========== Left Sidebar Start ========== -->
            @include('admin.layouts.sidebar')
            <!-- Left Sidebar End -->




            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">


                <div class="page-content">
                    {{-- Messages  --}}
                    @include('admin.layouts.message')

                    @yield('content')

                    <!-- End Page-content -->

                    <!-- footer -->
                    @include('admin.layouts.footer')
                </div>

            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        @include('admin.layouts.right-sidebar')

        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>


        <!-- JAVASCRIPT -->
        @include('admin.layouts.script')


        @stack('scripts')
    </body>
</html>
