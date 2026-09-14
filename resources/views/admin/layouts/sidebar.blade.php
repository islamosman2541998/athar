<div class="vertical-menu side-navbar-custom-color"
    style="background-color:{{ @$adminDashboardTheme->side_navbar_background }};">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                {{-- View  Dashboard --}}
                <li>
                    <a href="{{ route('admin.home') }}" class="waves-effect">
                        <i class="fa fa-home"></i>
                        <span> {{ trans('admin.dashboard') }} </span>
                    </a>
                </li>


                {{-- System ----------------------------------------------------------- --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-th-large"></i>
                        <span> @lang('admin.system')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">

                        {{-- User --------------------------------------------------------------- --}}
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fas fa-users"></i>
                                <span> @lang('admin.users')</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('admin.users.index') }}"> @lang('admin.show_users')</a></li>
                                <li><a href="{{ route('admin.users.create') }}"> @lang('admin.create_user')</a></li>
                            </ul>
                        </li>
                        {{-- End User ----------------------------------------------------------- --}}

                        {{-- Rules  ----------------------------------------------------------- --}}
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa fa-wrench"></i>
                                <span> @lang('admin.roles')</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('admin.roles.index') }}"> @lang('admin.roles_show')</a></li>
                                <li><a href="{{ route('admin.roles.create') }}"> @lang('admin.roles_create')</a></li>
                            </ul>
                        </li>
                        {{-- End Rules ----------------------------------------------------------- --}}

                        {{-- Menus -------------------------------------------------------------- --}}
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa fa-sitemap"></i>
                                <span> @lang('admin.menus')</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('admin.menus.index') }}"> @lang('admin.show_menus')</a></li>
                                <li><a href="{{ route('admin.menus.create') }}"> @lang('admin.create_menus')</a></li>
                            </ul>
                        </li>
                        {{-- End Menus ----------------------------------------------------------- --}}

                        {{-- Pages --------------------------------------------------------------- --}}
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-pager"></i>
                                <span> @lang('admin.pages')</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('admin.pages.index') }}"> @lang('admin.pages_show')</a></li>
                                <li><a href="{{ route('admin.pages.create') }}"> @lang('admin.page_create')</a></li>
                            </ul>
                        </li>
                        {{-- End Pages ------------------------------------------------------------ --}}






                        {{-- subscribes Us ----------------------------------------------------------- --}}
                        <li>
                            <a href="{{ route('admin.subscribes.index') }}" class="waves-effect">
                                <i class="far fa-handshake"></i>
                                <span>{{ trans('admin.subscribes') }}<span>
                            </a>
                        </li>
                        {{-- End subscribes Us ------------------------------------------------------- --}}

                        {{-- whatsapp contacts   ----------------------------------------------------------- --}}
                        {{-- <li><a href="{{ route('admin.whatsapp-contact.index') }}"> <i class="fab  fa-whatsapp"></i>
                                @lang('whatsapp_contacts.show_whatsapp_contacts')</a>
                        </li> --}}

                    </ul>
                </li>
                {{-- End System ----------------------------------------------------------- --}}


                {{--                --}}{{-- Works ----------------------------------------------------------- --}}
                {{--                <li> --}}
                {{--                    <a href="javascript: void(0);" class="has-arrow waves-effect"> --}}
                {{--                        <i class="fas fa-briefcase"></i> --}}
                {{--                        <span> @lang('admin.works')</span> --}}
                {{--                    </a> --}}
                {{--                    <ul class="sub-menu" aria-expanded="false"> --}}

                {{--                        --}}{{-- Specialties --------------------------------------------------------------- --}}
                {{--                        <li> --}}
                {{--                            <a href="javascript: void(0);" class="has-arrow waves-effect"> --}}
                {{--                                <i class="fa fa-sitemap"></i> --}}
                {{--                                <span> @lang('specialties.specialties')</span> --}}
                {{--                            </a> --}}
                {{--                            <ul class="sub-menu" aria-expanded="false"> --}}
                {{--                                <li> --}}
                {{--                                    <a href="{{ route('admin.specialties.index') }}"> @lang('specialties.show_specialties')</a> --}}
                {{--                                </li> --}}
                {{--                                <li> --}}
                {{--                                    <a href="{{ route('admin.specialties.create') }}"> @lang('specialties.create_specialties')</a> --}}
                {{--                                </li> --}}
                {{--                            </ul> --}}
                {{--                        </li> --}}
                {{--                        --}}{{-- End Specialties ----------------------------------------------------------- --}}

                {{--                        --}}{{-- Doctors --------------------------------------------------------------- --}}
                {{--                        <li> --}}
                {{--                            <a href="javascript: void(0);" class="has-arrow waves-effect"> --}}
                {{--                                <i class="fas fa-user-md"></i> --}}
                {{--                                <span> @lang('doctors.doctors')</span> --}}
                {{--                            </a> --}}
                {{--                            <ul class="sub-menu" aria-expanded="false"> --}}
                {{--                                <li><a href="{{ route('admin.doctors.index') }}"> @lang('doctors.show_doctors')</a></li> --}}
                {{--                                <li><a href="{{ route('admin.doctors.create') }}"> @lang('doctors.create_doctor')</a> --}}
                {{--                                </li> --}}
                {{--                            </ul> --}}
                {{--                        </li> --}}
                {{--                        --}}{{-- End Doctors ----------------------------------------------------------- --}}

                {{--                        --}}{{-- booking --------------------------------------------------------------- --}}
                {{--                        <li> --}}
                {{--                            <a href="{{ route('admin.booking.index') }}" class="waves-effect"> --}}
                {{--                                <i class="fas fa-shopping-bag"></i> --}}
                {{--                                <span>{{ trans('admin.booking') }}</span> --}}
                {{--                            </a> --}}
                {{--                        </li> --}}
                {{--                        --}}{{-- End booking ----------------------------------------------------------- --}}

                {{--                    </ul> --}}
                {{--                </li> --}}
                {{--                --}}{{-- End Works -------------------------------------------------------- --}}


                {{--                --}}{{-- Blogs ----------------------------------------------------------- --}}
                {{--                <li> --}}
                {{--                    <a href="javascript: void(0);" class="has-arrow waves-effect"> --}}
                {{--                        <i class="mdi mdi-buffer"></i> --}}
                {{--                        <span> @lang('admin.blogs')</span> --}}
                {{--                    </a> --}}
                {{--                    <ul class="sub-menu" aria-expanded="false"> --}}
                {{--                        --}}
                {{-- services --------------------------------------------------------------- --}}
                {{--                        <li> --}}
                {{--                            <a href="javascript: void(0);" class="has-arrow waves-effect"> --}}
                {{--                                <i class="fa fa-smile"></i> --}}
                {{--                                <span> @lang('services.services')</span> --}}
                {{--                            </a> --}}
                {{--                            <ul class="sub-menu" aria-expanded="false"> --}}
                {{--                                <li><a href="{{ route('admin.services.index') }}"> @lang('services.show_services')</a> --}}
                {{--                                </li> --}}
                {{--                                <li> --}}
                {{--                                    <a href="{{ route('admin.services.create') }}"> @lang('services.create_services')</a> --}}
                {{--                                </li> --}}
                {{--                            </ul> --}}
                {{--                        </li> --}}
                {{--                        --}}{{-- End services ----------------------------------------------------------- --}}

                {{--                        --}}{{-- offers --------------------------------------------------------------- --}}
                {{--                        <li> --}}
                {{--                            <a href="javascript: void(0);" class="has-arrow waves-effect"> --}}
                {{--                                <i class="fas fa-hand-holding-usd"></i> --}}
                {{--                                <span> @lang('offers.offers')</span> --}}
                {{--                            </a> --}}
                {{--                            <ul class="sub-menu" aria-expanded="false"> --}}
                {{--                                <li><a href="{{ route('admin.news.index') }}"> @lang('offers.show_offers')</a></li> --}}
                {{--                                <li><a href="{{ route('admin.news.create') }}"> @lang('news.create_news')</a></li> --}}
                {{--                            </ul> --}}
                {{--                        </li> --}}
                {{--                        --}}{{-- End services ----------------------------------------------------------- --}}


                {{--                        --}}{{-- gallery --------------------------------------------------------------- --}}
                {{--                        <li> --}}
                {{--                            <a href="javascript: void(0);" class="has-arrow waves-effect"> --}}
                {{--                                <i class="fas fa-images"></i> --}}
                {{--                                <span> @lang('gallery.galleries')</span> --}}
                {{--                            </a> --}}
                {{--                            <ul class="sub-menu" aria-expanded="false"> --}}
                {{--                                <li><a href="{{ route('admin.gallery.index') }}"> @lang('gallery.show_gallery')</a></li> --}}
                {{--                                <li><a href="{{ route('admin.gallery.create') }}"> @lang('gallery.create_gallery')</a> --}}
                {{--                                </li> --}}
                {{--                            </ul> --}}
                {{--                        </li> --}}
                {{--                        --}}{{-- End gallery ----------------------------------------------------------- --}}

                {{--                        --}}{{-- videos --------------------------------------------------------------- --}}
                {{--                        <li> --}}
                {{--                            <a href="javascript: void(0);" class="has-arrow waves-effect"> --}}
                {{--                                <i class="fas fa-video"></i> --}}
                {{--                                <span> @lang('videos.videos')</span> --}}
                {{--                            </a> --}}
                {{--                            <ul class="sub-menu" aria-expanded="false"> --}}
                {{--                                <li><a href="{{ route('admin.videos.index') }}"> @lang('videos.show_videos')</a></li> --}}
                {{--                                <li><a href="{{ route('admin.videos.create') }}"> @lang('videos.create_video')</a></li> --}}
                {{--                            </ul> --}}
                {{--                        </li> --}}
                {{--                        --}}{{-- End videos ----------------------------------------------------------- --}}


                {{--                    </ul> --}}
                {{--                </li> --}}
                {{--                --}}{{-- End Blogs -------------------------------------------------------- --}}














                {{-- orders ----------------------------------------------------------- --}}
                {{--                <li> --}}
                {{--                    <a href="javascript: void(0);" class="has-arrow waves-effect"> --}}
                {{--                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> --}}

                {{--                        <span> @lang('admin.orders')</span> --}}
                {{--                    </a> --}}
                {{--                    <ul class="sub-menu" aria-expanded="false"> --}}
                {{-- @php $pending =  \App\Models\Order::where('status' , \App\Enums\OrderStatusEnum::PENDING)->count();  @endphp
                <li><a href="{{ route('admin.orders.index') }}"> <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        @lang('admin.orders')
                        <span data-toggle="tooltip" title="{{ __('admin.pending') . ' : ' . $pending }}"
                            style="
                            border-radius: 100px;
                            /*background-color: rgba(255, 255, 255, 0.3);*/
                            background-color: rgba(255,255,255,0.4);

                            display: inline-block;
                            margin-left: 10px;
                            margin-right: 10px;
                            width: fit-content;
                            padding-left: 5px;
                            padding-right: 5px;
                            font-size: 12px;
                            ">{{ $pending }}</span>
                    </a>
                </li> --}}

                {{--                    </ul> --}}
                {{--                </li> --}}
                {{-- End orders ----------------------------------------------------------- --}}





                {{-- shop ----------------------------------------------------------- --}}
                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                        <span> @lang('admin.shop')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.product_category.index') }}"> @lang('admin.product_category')</a>
                        </li>

                        <li>
                            <a href="{{ route('admin.occasions_products_index.index') }}"> @lang('admin.occasions_products')</a>
                        </li>


                        <li>
                            <a href="{{ url('/admin/settings/view_setting') }}">@lang('admin.veiw_products')</a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/filters') }}">@lang('admin.filters')</a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/promocodes/list') }}">@lang('admin.promocodes')</a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/blogs') }}">@lang('admin.blogs')</a>
                        </li>

                        <li>

                            <a href="{{ route('admin.show_in_cart_product_list') }}"> @lang('admin.products_of_cart_only')</a>
                        </li>
                        <li><a href="{{ route('admin.rates.index') }}"> @lang('admin.rates')</a>
                        </li>
                    </ul>
                </li> --}}
                {{-- End shop ----------------------------------------------------------- --}}









                {{-- reports ----------------------------------------------------------- --}}
                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                        <span> @lang('admin.reports')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.products_reports.reports') }}"> @lang('admin.product_reports')</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.clients_reports.reports') }}"> @lang('admin.client_reports')</a>
                        </li>
                    </ul>
                </li> --}}
                {{-- End reports ----------------------------------------------------------- --}}



                {{-- main_page_gallery ----------------------------------------------------------- --}}
                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                        <span> @lang('admin.main_page_gallery')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">

                        <li>
                            <a href="{{ route('admin.main_page_gallery.index') }}"> @lang('admin.main_page_gallery')</a>
                        </li>
                    </ul>
                </li> --}}
                {{-- End main_page_gallery ----------------------------------------------------------- --}}


                {{--   reviews --------------------------------------------------------------- --}}
                {{--                <li> --}}
                {{--                    <a href="javascript: void(0);" class="has-arrow waves-effect"> --}}
                {{--                        <i class="fas fa-comments"></i> --}}
                {{--                        <span> @lang('reviews.reviews')</span> --}}
                {{--                    </a> --}}
                {{--                    <ul class="sub-menu" aria-expanded="false"> --}}

                {{-- Slider --------------------------------------------------------------- --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-sliders-h"></i>
                        <span> @lang('admin.slider')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.slider.index') }}"> @lang('admin.slider_show')</a></li>
                        <li><a href="{{ route('admin.slider.create') }}"> @lang('admin.slider_create')</a></li>
                    </ul>
                </li>
                {{-- End Slider ----------------------------------------------------------- --}}
                {{-- Slider --------------------------------------------------------------- --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-question"></i>
                        <span> @lang('admin.faqs')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.faqs.index') }}"> @lang('admin.faqs')</a></li>
                        <li><a href="{{ route('admin.faq-categories.index') }}"> @lang('admin.faq-categories')</a></li>
                    </ul>
                </li>
                {{-- End Slider ----------------------------------------------------------- --}}

                {{--                      blog             --}}
                <li>
                    <a href="{{ url('/admin/blogs') }}">
                        <i class="fa-brands fa-microblog"></i>
                        @lang('admin.blogs')</a>
                </li>

                {{--           portfolio             --}}

                <li><a href="{{ route('admin.portfolio.index') }}">
                        <i class="fas fa-images"></i>
                        @lang('admin.portfolio')</a></li>


                {{--           portfolio tags            --}}

                <li><a href="{{ route('admin.portfolio-tags.index') }}">
                        <i class="fas fa-tags"></i>
                        @lang('admin.portfolio-tags')</a></li>


                {{--           products             --}}

                {{-- <li><a href="{{ route('admin.products.index') }}">
                        <i class="fas fa-boxes"></i>
                        @lang('admin.products')</a></li> --}}

                {{--           categories             --}}

                {{-- <li><a href="{{ route('admin.product_category.index') }}">
                        <i class="fas fa-tags"></i>
                        @lang('admin.product_category')</a></li> --}}


                {{-- services --------------------------------------------------------------- --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-smile"></i>
                        <span> @lang('services.services')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.services.index') }}"> @lang('services.show_services')</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.services.create') }}"> @lang('services.create_services')</a>
                        </li>
                    </ul>
                </li>



                {{-- End services ----------------------------------------------------------- --}}
                {{-- services categories --------------------------------------------------------------- --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-smile-beam"></i>
                        <span> @lang('services.services_categories')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.service.index') }}"> @lang('services.show_services_categories')</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.service.create') }}"> @lang('services.create_services_categories')</a>
                        </li>
                    </ul>
                </li>



                {{-- End services ----------------------------------------------------------- --}}

                {{--         News             --}}

                <li><a href="{{ route('admin.news.index') }}">
                        <i class="fas fa-newspaper"></i>
                        @lang('admin.newss')</a></li>


                {{--         jobs             --}}
                <li><a href="{{ route('admin.jobs.index') }}">
                        <i class="fas fa-briefcase"></i>
                        @lang('admin.jobs')</a></li>
                {{--         jobs             --}}

                {{--         career_category             --}}
                <li><a href="{{ route('admin.career_category.index') }}">
                        <i class="fas fa-graduation-cap"></i>
                        @lang('admin.career_category')</a></li>
                {{--         career_category             --}}

                {{--         service_request             --}}
                <li><a href="{{ route('admin.service_request.index') }}">
                        <i class="fas fa-comment"></i>
                        @lang('admin.serviceRequest')</a></li>
                {{--         service_request             --}}
                {{--         meeting_requests             --}}
                <li><a href="{{ route('admin.meeting_request.index') }}">
                        <i class="fas fa-calendar-alt"></i>
                        @lang('admin.meetingRequests')</a></li>
                {{--         meeting_requests             --}}

                <li><a href="{{ route('admin.cvs.index') }}">
                        <i class="fas fa-id-card"></i>
                        @lang('admin.cvs')</a></li>

                {{--         partners             --}}

                <li><a href="{{ route('admin.partners.index') }}">
                        <i class="fas fa-handshake"></i>
                        @lang('admin.partners')</a></li>

                {{--           statistic             --}}

                <li><a href="{{ route('admin.statistic.index') }}">
                        <i class="fas fa-images"></i>
                        @lang('admin.statistic')</a></li>


                {{--  about us --}}

                <li><a href="{{ route('admin.about.edit') }}"><i class="fa fa-address-card" aria-hidden="true"></i>
                        @lang('admin.about')</a></li>

                {{-- Contact Us ----------------------------------------------------------- --}}
                <li>
                    <a href="{{ route('admin.contact-us.index') }}" class="waves-effect">
                        <i class="mdi mdi-email-outline"></i>
                        <span>{{ trans('admin.contact_us') }}</span>
                    </a>
                </li>
                {{-- End Contact Us ------------------------------------------------------- --}}
                {{--   reviews --------------------------------------------------------------- --}}
                <li>
                    <a href="{{ route('admin.reviews.index') }}" class="waves-effect">
                        <i class="fas fa-comments"></i>
                        <span> @lang('reviews.reviews')</span>
                    </a>
                </li>
                {{-- End reviews ------------------------------------------------------- --}}


                {{--                    </ul> --}}
                {{--                </li> --}}
                {{--    End reviews ----------------------------------------------------------- --}}


                {{-- Settings ----------------------------------------------------------- --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-spin mdi-cog "></i>
                        <span> @lang('admin.settings')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-application-cog"></i>
                                <span> @lang('admin.system_settings')</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('admin.settings.index') }}"> @lang('admin.app_setting')</a>
                                </li>
                                {{-- <li><a href="{{ route('admin.payment-methods.index') }}"> @lang('admin.payment_methods')</a>
                                </li> --}}

                                <li>
                                    <a href="{{ route('admin.home-settings.index') }}"> @lang('admin.setting_home')</a>
                                </li>
                            </ul>
                        </li>
                        {{-- Themes --------------------------------------------------------------- --}}
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fa fa-palette"></i>
                                <span> @lang('admin.themes')</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('admin.themes.dashboard') }}"> @lang('admin.dashboard_theme')</a>
                                </li>
                                {{-- <li><a href="{{ route('admin.themes.site') }}"> @lang('admin.site_theme')</a></li> --}}

                            </ul>
                        </li>
                        {{-- End Themes ----------------------------------------------------------- --}}
                    </ul>
                </li>
                {{-- End Settings ----------------------------------------------------------- --}}


            </ul>


            </ul>

        </div>
        <!-- Sidebar -->
    </div>
</div>


<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
