@extends('admin.app')

@section('title', 'Dashboard')

@section('content')

    <div class="container-fluid">
        <div class="row">


            {{-- <h4 class="page-title navbar-custom-color">@lang('admin.orders')</h4> --}}
            {{-- ---------------------------------------------start orders---------------------------------------------------------------------- --}}
            {{-- <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.orders.index') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-purple me-0 float-end"><i class="fas fa-shopping-bag"></i></span>
                                <div class="mini-stat-info ">
                                    <div class="d-flex">
                                        <span
                                            class="counter text-brown col  text-left ">{{__('admin.count')}} : {{ $data['orders']['orders_count']  }} </span>
                                        <span
                                            class="counter text-brown col text-left">{{__('admin.sum')}} : {{ $data['orders']['orders_total_of_sum']  }} @lang('admin.egp')</span>
                                    </div>
                                    @lang('admin.orders')
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.orders.index') . "?status=pending" }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-warning me-0 float-end"><i class="fas fa-shopping-bag"></i></span>
                                <div class="mini-stat-info">
                                    <div class="d-flex">
                                        <span
                                            class="counter text-brown col">{{__('admin.count')}}  : {{$data['orders']['pending_orders_count'] }}</span>
                                        <span
                                            class="counter text-brown col">{{__('admin.sum')}}  : {{$data['orders']['pending_orders_total_of_sum'] }} @lang('admin.egp')</span>
                                    </div>

                                    @lang('admin.pending_orders')
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.orders.index')  . "?shipped_status=delivered"  }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-success me-0 float-end"><i class="fas fa-shopping-bag"></i></span>
                                <div class="mini-stat-info">
                                    <div class="d-flex">
                                        <span
                                            class="counter text-brown col">{{__('admin.count')}}  : {{$data['orders']['delivered_orders_count'] }}</span>
                                        <span
                                            class="counter text-brown col">{{__('admin.sum')}}  : {{$data['orders']['delivered_orders_total_of_sum'] }} @lang('admin.egp')</span>
                                    </div>

                                    @lang('admin.delivered_orders')
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> --}}
            {{-- ---------------------------------------------end orders---------------------------------------------------------------------- --}}





            {{-- ---------------------------------------------products---------------------------------------------------------------------- --}}
            <h4 class="page-title navbar-custom-color">@lang('admin.products')</h4>
            {{-- <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.product_category.index') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-teal me-0 float-end"><i
                                        class="fa fa-sitemap"></i></span>
                                <div class="mini-stat-info">
                                    <span class="counter text-teal">{{ App\Models\ProductCategory::count() }}</span>
                                    @lang('admin.product_categories')
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.products.index') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-primary me-0 float-end"><i class="fab fa-pagelines"
                                        aria-hidden="true"></i>


                                </span>
                                <div class="mini-stat-info">
                                    <span class="counter text-primary">{{ App\Models\Product::count() }}</span>
                                    @lang('admin.products')
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ url( app()->getLocale() . '/admin/occasions_products') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-danger me-0 float-end"> <i
                                        class="fas fa-hand-holding-usd"></i> </span>
                                <div class="mini-stat-info">
                                    <span
                                        class="counter text-danger">{{ App\Models\Occasion::where('type' , 0)->count() }}</span>
                                    {{ trans('admin.occasions_products') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> --}}
            <!-- End col -->

            {{-- ---------------------------------------------end products---------------------------------------------------------------------- --}}





            {{--            /******************************services part *****************/ --}}
            {{-- <h4 class="page-title navbar-custom-color">
                @lang('admin.services')
            </h4> --}}

            {{-- <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ url(app()->getLocale() . '/admin/events') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-brown me-0 float-end"><i class="fa fa-calendar"
                                        aria-hidden="true"></i>
                                </span>
                                <div class="mini-stat-info">
                                    <span class="counter text-brown">1</span>
                                    {{ trans('admin.events') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> --}}
             <!-- End col -->
            {{-- <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ url(app()->getLocale() . '/admin/landscape') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-success me-0 float-end"><i class="fa fa-tree"></i></span>
                                <div class="mini-stat-info">
                                    <span class="counter text-success">1</span>
                                    {{ trans('admin.landscape') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>  --}}
            <!-- End col -->
            {{-- <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ url(app()->getLocale() . '/admin/occasions_services') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-primary me-0 float-end"> <i class="fas fa-smile"></i> </span>
                                <div class="mini-stat-info">
                                    <span
                                        class="counter text-primary">{{ App\Models\Occasion::where('type', 1)->count() }}</span>
                                    {{ trans('admin.occasions_services') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> --}}
             <!-- End col -->

            {{-- <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.rates.index') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-primary me-0 float-end"> <i class="fas fa-star"></i> </span>
                                <div class="mini-stat-info">
                                    <span class="counter text-primary">{{ App\Models\Rate::count() }}</span>
                                    {{ trans('admin.rates') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> --}}
             <!-- End col -->
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.reviews.index') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-brown me-0 float-end"><i
                                        class="fas fa-user-check"></i></span>
                                <div class="mini-stat-info">
                                    <span class="counter text-brown">{{ App\Models\Review::count() }}</span>
                                    @lang('admin.total_reviews')
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.blogs.index') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-brown me-0 float-end"><i
                                        class="fas fa-newspaper"></i></span>
                                <div class="mini-stat-info">
                                    <span class="counter text-brown">{{ App\Models\Blog::count() }}</span>
                                    @lang('admin.total_blogs')
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.jobs.index') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-brown me-0 float-end"><i
                                        class="fas fa-briefcase"></i></span>
                                <div class="mini-stat-info">
                                    <span class="counter text-brown">{{ App\Models\Job::count() }}</span>
                                    @lang('admin.total_jobs')
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.partners.index') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-brown me-0 float-end"><i
                                        class="fas fa-handshake"></i></span>
                                <div class="mini-stat-info">
                                    <span class="counter text-brown">{{ App\Models\Partner::count() }}</span>
                                    @lang('admin.total_partners')
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.news.index') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-brown me-0 float-end"><i
                                        class="fas fa-newspaper"></i></span>
                                <div class="mini-stat-info">
                                    <span class="counter text-brown">{{ App\Models\News::count() }}</span>
                                    @lang('admin.total_new')
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            {{--            <div class="col-md-6 col-xl-4"> --}}
            {{--                <div class="card"> --}}
            {{--                    <div class="card-body"> --}}
            {{--                        <a href="{{ route('admin.gallery.index') }}"> --}}
            {{--                            <div class="mini-stat"> --}}
            {{--                                <span class="mini-stat-icon bg-brown me-0 float-end"><i --}}
            {{--                                        class="fas fa-images"></i></span> --}}
            {{--                                <div class="mini-stat-info"> --}}
            {{--                                    <span class="counter text-brown">{{ App\Models\Gallery::count() }}</span> --}}
            {{--                                    @lang('admin.total_galleries') --}}
            {{--                                </div> --}}
            {{--                            </div> --}}
            {{--                        </a> --}}
            {{--                    </div> --}}
            {{--                </div> --}}
            {{--            </div> --}}


            {{--            /******************************end blog part *****************/ --}}














            {{--            /******************************system part *****************/ --}}
            <h4 class="page-title navbar-custom-color">@lang('admin.system')</h4>
            {{-- <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.whatsapp-contact.index') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-success me-0 float-end"><i class="fab fa-whatsapp"
                                        aria-hidden="true"></i>
                                </span>
                                <div class="mini-stat-info">
                                    <span class="counter text-success">{{ App\Models\WhatsAppContact::count() }}</span>
                                    @lang('admin.whats_app_contacts')
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> --}}

            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.users.index') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-purple me-0 float-end"><i
                                        class="fas fas fa-users"></i></span>
                                <div class="mini-stat-info">
                                    <span class="counter text-purple">{{ App\Models\User::count() }}</span>
                                    {{ trans('admin.total_users') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!--End col -->
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.contact-us.index') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-blue-grey me-0 float-end"><i
                                        class="mdi mdi-email-outline"></i></span>
                                <div class="mini-stat-info">
                                    <span class="counter text-blue-grey">{{ App\Models\Contactus::all()->count() }}</span>
                                    {{ trans('admin.total_meassges') }}
                                </div>

                            </div>
                        </a>
                    </div>
                </div>
            </div> <!-- End col -->
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.menus.index') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-brown me-0 float-end"><i class="fa fa-sitemap"></i></span>
                                <div class="mini-stat-info">
                                    <span class="counter text-brown">{{ App\Models\Menue::main()->count() }}</span>
                                    {{ trans('admin.total_menues') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> <!-- End col -->
            {{-- <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.pages.index') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-teal me-0 float-end"> <i class="fas fa-pager"></i></span>
                                <div class="mini-stat-info">
                                    <span class="counter text-teal">{{ App\Models\Pages::count() }}</span>
                                    {{ trans('admin.total_pages') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div> --}}
            <!--end col -->
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.slider.index') }}">
                            <div class="mini-stat">
                                <span class="mini-stat-icon bg-purple me-0 float-end"><i
                                        class="fa fa-sliders-h"></i></span>
                                <div class="mini-stat-info">
                                    <span class="counter text-purple">{{ App\Models\Slider::count() }}</span>
                                    {{ trans('admin.total_slider') }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!--End col -->
            {{--            /******************************end system part *****************/ --}}


        </div> <!-- end row-->

    </div>

@endsection
