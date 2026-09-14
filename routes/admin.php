<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MenueController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\RateConteroller;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ThemesController;
use App\Http\Controllers\Admin\AdminCvController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\MainPageController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\WhatsAppController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OccasionsController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\SubscribesController;
use App\Http\Controllers\Admin\imageUploadController;
use App\Http\Controllers\Admin\SpecialtiesController;
use App\Http\Controllers\Admin\PortfolioTagController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\CareerCategoryController;
use App\Http\Controllers\Admin\ClientsReportsController;
use App\Http\Controllers\Admin\OccasionGallerController;
use App\Http\Controllers\Admin\ServiceRequestController;
use App\Http\Controllers\Admin\HomeSettingPageController;
use App\Http\Controllers\Admin\MainPageGalleryController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\MeetingRequestController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\WhatsAppContactController;
use App\Http\Controllers\Admin\ShowInCartProductController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Admin\Authorizations\RolesController;
use App\Http\Controllers\Admin\ServiceCategoryEventsController;
use App\Http\Controllers\Admin\Authorizations\PermissionsController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//   prefix Languages
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'], // Route translate middleware
], function () {

    Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {

        Route::get('/', function () {
            return redirect()->route('admin.login');
        });

        // AUTH PAGE ---------------------------------------------------------------
        Route::group(['middleware' => 'RedirectDashboard'], function () {
            Route::controller(AuthController::class)->group(function () {
                Route::get('login', 'showLogin')->name('login');
                Route::POST('post-login', 'login')->name('post-login');
            });
        });

        Route::delete('pockets/delete-image/{pocket}/{image}', [ProductController::class, 'deletePocketImage'])
            ->name('admin.pockets.delete-image');

        Route::get('admin/products/export', [ProductController::class, 'export'])
            ->name('admin.products.export');
        // Dashboard Pages ---------------------------------------------------------------
        Route::group(['middleware' => 'CheckAdminAuth'], function () {

            Route::controller(AuthController::class)->group(function () {
                Route::post('logout', 'logout')->name('logout');
            });
            Route::group(['middleware' => 'CheckPermissionRoute'], function () {

                /************************** start old ************************************/
                Route::controller(DashboardController::class)->group(function () {
                    Route::get('dashboard', 'home')->name('home');
                });

                // ---------------------- Profile -----------------------------//
                Route::resource('profile', ProfileController::class)->only(['edit', 'update']);
                // ---------------------- End Profile -----------------------------//

                // ----- Admins -----------------------------------------------
                Route::resource('users', AdminController::class);
                Route::post('users/actions', [AdminController::class, 'actions'])->name('users.actions');
                Route::get('users/update-status/{id}', [AdminController::class, 'update_status'])->name('users.update-status');
                //--------------- End Admins ----------//

                // ----- Authorization -----------------------------------------------
                Route::resource('permissions', PermissionsController::class);
                Route::resource('roles', RolesController::class);
                // Route::get('permissions/restore', [PermissionsController::class, 'RestoreAllRoutes'])->name('permissions.restore');
                // ----- End Authorization -------------------------------------------

                //--------------- Start Menus -----------------------------------------------------------------------//
                Route::resource('menus', MenueController::class);
                Route::get('show-menu-tree', [MenueController::class, 'show_tree'])->name('menus.show_tree');
                Route::post('menus/actions', [MenueController::class, 'actions'])->name('menus.actions');
                Route::get('menus/update-status/{id}', [MenueController::class, 'update_status'])->name('menus.update-status');
                Route::get('tree/get-urls', [MenueController::class, 'getUrl'])->name('menus.getUrl');
                Route::get('get-menus', [MenueController::class, 'getMenus'])->name('menus.getMenus');
                //--------------- End Menus -----------------------------------------------------------------------//

                // ----- Pages -----------------------------------------------
                Route::resource('pages', PagesController::class);
                Route::get('pages/update-status/{id}', [PagesController::class, 'update_status'])->name('pages.update-status');
                Route::post('pages/actions', [PagesController::class, 'actions'])->name('pages.actions');
                // ----- End Pages -------------------------------------------

                //----------------Start Sliders----------------------------//
                Route::resource('slider', SliderController::class);
                Route::get('slider/update-status/{id}', [SliderController::class, 'update_status'])->name('slider.update-status');
                Route::post('slider/actions', [SliderController::class, 'actions'])->name('slider.actions');
                //----------------End Sliders----------------------------//

                // ----- ContactUs -----------------------------------------------
                Route::resource('contact-us', ContactUsController::class);
                Route::post('contact-us/read', [ContactUsController::class, 'read'])->name('contact-us.read');
                Route::get('/notifications/markAll', [ContactUsController::class, 'markAll'])->name('notification.read');
                //--------------- End ContactUs ---------------------------------

                Route::resource('filters', FilterController::class)
                    ->except(['show']);
                Route::get('filters/{filter}/products', [FilterController::class, 'products'])
                    ->name('filters.products');

                Route::post('filters/{filter}/products', [FilterController::class, 'updateProducts'])
                    ->name('filters.products.update');

                Route::resource('blogs', BlogController::class);
                Route::get('blogs-update-featured/{id}', [BlogController::class, 'updateFeature'])->name('blogs.update-featured');
                Route::get('blogs-update-status/{id}', [BlogController::class, 'updateStatus'])->name('blogs.update-status');

                Route::get('about', [AboutController::class, 'edit'])->name('about.edit');
                Route::post('about', [AboutController::class, 'update'])->name('about.update');
                // ----- subscribes -----------------------------------------------
                Route::resource('subscribes', SubscribesController::class);
                //--------------- End subscribes ---------------------------------
Route::get('meeting-requests', [MeetingRequestController::class, 'index'])
    ->name('meeting_request.index');

Route::delete('meeting-requests/{meetingRequest}', [MeetingRequestController::class, 'destroy'])
    ->name('meeting_request.destroy');
                // ----- Jobs -----------------------------------------------
                Route::resource('jobs', App\Http\Controllers\Admin\JobController::class);
                Route::get('jobs/{job}/toggle-status', [App\Http\Controllers\Admin\JobController::class, 'toggleStatus'])->name('jobs.toggle-status');
                Route::get('jobs/{job}/toggle-feature', [App\Http\Controllers\Admin\JobController::class, 'toggleFeature'])->name('jobs.toggle-feature');

 /************************** start CareerCategory ************************************/
                Route::resource('career_category', CareerCategoryController::class);
                Route::get('career_category-update-featured/{id}', [CareerCategoryController::class, 'update_featured'])->name('career_category.update-featured');
                Route::get('career_category-update-status/{id}', [CareerCategoryController::class, 'update_status'])->name('career_category.update-status');
                Route::post('career_category/actions', [CareerCategoryController::class, 'actions'])->name('career_category.actions');

                /************************** end CareerCategory ************************************/
                // ----- Partners -----------------------------------------------
                Route::resource('partners', PartnerController::class);
                Route::get('partners/{partner}/toggle-status', [PartnerController::class, 'toggleStatus'])->name('partners.toggle-status');


                // ----- Specialties -----------------------------------------------
                Route::resource('specialties', SpecialtiesController::class);
                Route::post('specialties/actions', [SpecialtiesController::class, 'actions'])->name('specialties.actions');
                Route::get('specialties/update-status/{id}', [SpecialtiesController::class, 'update_status'])->name('specialties.update-status');
                Route::get('specialties/update-featured/{id}', [SpecialtiesController::class, 'update_featured'])->name('specialties.update-featured');
                //--------------- End Specialties ---------------------------------

                // ----- doctors -----------------------------------------------
                Route::resource('doctors', DoctorController::class);
                Route::post('doctors/actions', [DoctorController::class, 'actions'])->name('doctors.actions');
                Route::get('doctors/update-status/{id}', [DoctorController::class, 'update_status'])->name('doctors.update-status');
                Route::get('doctors/update-featured/{id}', [DoctorController::class, 'update_featured'])->name('doctors.update-featured');
                //--------------- End doctors ---------------------------------

                // ----- booking -----------------------------------------------
                Route::resource('booking', BookingController::class);
                Route::post('booking/actions', [BookingController::class, 'actions'])->name('booking.actions');
                Route::get('booking/update-status/{id}', [BookingController::class, 'update_status'])->name('booking.update-status');
                Route::get('booking/update-featured/{id}', [BookingController::class, 'update_featured'])->name('booking.update-featured');
                //--------------- End booking ---------------------------------

                // ----- reviews -----------------------------------------------
                Route::resource('reviews', ReviewsController::class);
                Route::post('reviews/actions', [ReviewsController::class, 'actions'])->name('reviews.actions');
                Route::get('reviews/update-status/{id}', [ReviewsController::class, 'update_status'])->name('reviews.update-status');
                Route::get('reviews/update-featured/{id}', [ReviewsController::class, 'update_featured'])->name('reviews.update-featured');
                //--------------- End reviews ---------------------------------

                // ----- gallery -----------------------------------------------
                Route::resource('gallery', GalleryController::class);

                Route::post('gallery/actions', [GalleryController::class, 'actions'])->name('gallery.actions');
                Route::get('gallery/update-status/{id}', [GalleryController::class, 'update_status'])->name('gallery.update-status');
                Route::get('gallery/update-featured/{id}', [GalleryController::class, 'update_featured'])->name('gallery.update-featured');
                //--------------- End gallery ---------------------------------

                // ----- videos -----------------------------------------------
                Route::resource('videos', VideoController::class);
                Route::post('videos/actions', [VideoController::class, 'actions'])->name('videos.actions');
                Route::get('videos/update-status/{id}', [VideoController::class, 'update_status'])->name('videos.update-status');
                Route::get('videos/update-featured/{id}', [VideoController::class, 'update_featured'])->name('videos.update-featured');
                //--------------- End videos ---------------------------------

                // ----- Services -----------------------------------------------
                Route::resource('services', ServicesController::class);
                Route::get('services/update-status/{id}', [ServicesController::class, 'update_status'])->name('services.update-status');
                Route::post('services/actions', [ServicesController::class, 'actions'])->name('services.actions');
                Route::get('services/update-featured/{id}', [ServicesController::class, 'update_featured'])->name('services.update-featured');
                // ----- End Services -------------------------------------------

                // ----- Cv -----------------------------------------------
                Route::get('/cvs', [AdminCvController::class, 'index'])->name('cvs.index');
               
                Route::delete('/cvs/{cv}', [AdminCvController::class, 'destroy'])->name('cvs.destroy');

                // ----- End ServiceRequest -------------------------------------------
                // ----- Cv -----------------------------------------------
                Route::get('/service_request', [ServiceRequestController::class, 'index'])->name('service_request.index');
               
                Route::delete('/service_request/{service_request}', [ServiceRequestController::class, 'destroy'])->name('service_request.destroy');

                // ----- End ServiceRequest -------------------------------------------

                // ----- faqs -----------------------------------------------
                Route::resource('faqs', App\Http\Controllers\Admin\FaqController::class);
                Route::get('faqs/{faq}/toggle-status', [App\Http\Controllers\Admin\FaqController::class, 'toggleStatus'])->name('faqs.toggle-status');

                Route::resource('faq-categories', App\Http\Controllers\Admin\FaqCategoryController::class);
                Route::get('faq-categories/{id}/toggle-status', [App\Http\Controllers\Admin\FaqCategoryController::class, 'toggleStatus'])->name('faq-categories.toggle-status');

                // ----- offers -----------------------------------------------
                Route::resource('news', NewsController::class);
                Route::post('news/actions', [NewsController::class, 'actions'])->name('news.actions');
                Route::get('news/update-status/{id}', [NewsController::class, 'update_status'])->name('news.update-status');
                Route::get('news/update-featured/{id}', [NewsController::class, 'update_featured'])->name('news.update-featured');
                //--------------- End offers ---------------------------------

                // ---------- settings --------------------------------------------
                Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
                Route::get('settings/{key}', [SettingsController::class, 'form'])->name('settings.form');
                Route::post('settings-update/{id}', [SettingsController::class, 'form_update'])->name('settings.update');
                Route::post('settings-update-custom/{slug}', [SettingsController::class, 'form_update_custom'])->name('settings.update-custom');
                // ----- End settings -------------------------------------------

                // ----- Themes -----------------------------------------------
                Route::get('themes/dashboard', [ThemesController::class, 'dashboardTheme'])->name('themes.dashboard');
                Route::post('themes/dashboard', [ThemesController::class, 'Themes_update'])->name('themes.update');
                Route::post('themes/reset', [ThemesController::class, 'Themes_reset'])->name('themes.reset');
                Route::get('themes/site', [ThemesController::class, 'siteTheme'])->name('themes.site');
                // ----- End Themes -------------------------------------------

                // ----- SettingHome -----------------------------------------------
                Route::resource('home-settings', HomeSettingPageController::class);
                Route::get('home-settings/update-status/{id}', [HomeSettingPageController::class, 'update_status'])->name('home-settings.update-status');
                Route::post('home-settings/upload', [imageUploadController::class, 'upload'])->name('ckeditor.upload');


                /************************** end old ************************************/


                /************************** start products ************************************/
                Route::resource('products', ProductController::class);
                Route::get('products-update-featured/{id}', [ProductController::class, 'updateFeature'])->name('products.update-featured');
                Route::get('products-update-status/{id}', [ProductController::class, 'updateStatus'])->name('products.update-status');
                Route::post('products/actions', [ProductController::class, 'actions'])->name('products.actions');

                /************************** end products ************************************/

                /************************** start portfolio ************************************/
                Route::resource('portfolio', PortfolioController::class);
                Route::get('portfolio-update-featured/{id}', [PortfolioController::class, 'update_featured'])->name('portfolio.update-featured');
                Route::get('portfolio-update-status/{id}', [PortfolioController::class, 'update_status'])->name('portfolio.update-status');
                Route::post('portfolio/actions', [PortfolioController::class, 'actions'])->name('portfolio.actions');
Route::get('destroy_portfolio_gallery_image/{id}', [PortfolioController::class, 'destroyImage'])
    ->name('portfolio.destroy_portfolio_gallery_image');
                /************************** end portfolio ************************************/
                /************************** start statistic  ************************************/
                Route::resource('statistic', StatisticController::class);
                Route::get('statistic-update-featured/{id}', [StatisticController::class, 'update_featured'])->name('statistic.update-featured');
                Route::get('statistic-update-status/{id}', [StatisticController::class, 'update_status'])->name('statistic.update-status');
                Route::post('statistic/actions', [StatisticController::class, 'actions'])->name('statistic.actions');

                /************************** end statistic ************************************/


                /************************** start tags ************************************/
                Route::resource('portfolio-tags', PortfolioTagController::class);
                Route::get('portfolio-tags-update-featured/{id}', [PortfolioTagController::class, 'update_featured'])->name('portfolio-tags.update-featured');
                Route::get('portfolio-tags-update-status/{id}', [PortfolioTagController::class, 'update_status'])->name('portfolio-tags.update-status');
                Route::post('portfolio-tags/actions', [PortfolioTagController::class, 'actions'])->name('portfolio-tags.actions');

                /************************** end portfolio tags ************************************/



                /************************** start products gallery ************************************/
                Route::get('destroy_product_gallery_image/{id}', [ProductController::class, 'destroyImage'])->name('products.destroy_product_gallery_image');
                /************************** end products  gallery************************************/


                /************************** start occasions ************************************/
                Route::resource('occasions', OccasionsController::class);
                Route::get('occasions-update-featured/{id}', [OccasionsController::class, 'updateFeature'])->name('occasions.update-featured');
                Route::get('occasions-update-status/{id}', [OccasionsController::class, 'updateStatus'])->name('occasions.update-status');
                Route::post('occasions/actions', [OccasionsController::class, 'actions'])->name('occasions.actions');


                Route::get('occasions_services', [OccasionsController::class, 'occasions_services'])->name('occasions_services_index.index');
                Route::get('occasions_products', [OccasionsController::class, 'occasions_products'])->name('occasions_products_index.index');

                Route::get('occasions_services_create', [OccasionsController::class, 'create'])->name('occasions.create.services');
                Route::get('occasions_products_create', [OccasionsController::class, 'create'])->name('occasions.create.products');


                /************************** start occasions ************************************/


                /************************** start product_category ************************************/
                Route::resource('product_category', ProductCategoryController::class);
                Route::get('product-category-update-featured/{id}', [ProductCategoryController::class, 'updateFeature'])->name('product_category.update-featured');
                Route::get('product-category-update-status/{id}', [ProductCategoryController::class, 'updateStatus'])->name('product_category.update-status');
                Route::post('product_category/actions', [ProductCategoryController::class, 'actions'])->name('product_category.actions');

                /************************** start product_category ************************************/

                /************************** start products gallery ************************************/
                Route::get('destroy_product_category_gallery_image/{id}', [ProductCategoryController::class, 'destroyImage'])->name('product_category.destroy_product_gallery_image');
                /************************** end products  gallery************************************/


                Route::get('/auto-generate-slug', \App\Http\Livewire\Admin\Slug\AutoGenerateSlugComponent::class)->name('name.appGenerateSlug');


                /************************** start main_page ************************************/
                Route::resource('main_page', MainPageController::class);
                Route::get('main_page/update-status/{id}', [MainPageController::class, 'updateStatus'])->name('main_page.update-status');

                /************************** end main_page   ************************************/




                /************************** start service categories ************************************/
                Route::resource('service', ServiceCategoryController::class);


                Route::get('service-update-featured/{id}', [ServiceCategoryController::class, 'updateFeature'])->name('service.update-featured');
                Route::get('service-update-status/{id}', [ServiceCategoryController::class, 'updateStatus'])->name('service.update-status');
                Route::post('service/actions', [ServiceCategoryController::class, 'actions'])->name('service.actions');

                Route::get('service/gallery_image/{id}', [ServiceCategoryController::class, 'destroyImage'])->name('service.gallery.delete');
                Route::get('service/following/{id}', [ServiceCategoryController::class, 'destroyFollowing'])->name('service.following.delete');


                /************************** end  service categories ************************************/

                /***********************start group gallery ************/
                //                Route::resource('occasion_group_gallerys/{occ_id}', OccasionGallerController::class);
                Route::get('occasion_group_gallerys/{occ_id}', [OccasionGallerController::class, 'index'])->name('occasion_gallery.index');
                Route::get('occasion_group_gallerys/{occ_id}/create', [OccasionGallerController::class, 'create'])->name('occasion_gallery.create');
                Route::post('occasion_group_gallerys/{occ_id}', [OccasionGallerController::class, 'store'])->name('occasion_gallery.store');
                Route::get('occasion_group_gallerys/{occ_id}/{id}', [OccasionGallerController::class, 'show'])->name('occasion_gallery.show');
                Route::get('occasion_group_gallerys/{occ_id}/{id}/edit', [OccasionGallerController::class, 'edit'])->name('occasion_gallery.edit');
                Route::put('occasion_group_gallerys/{occ_id}/{id}', [OccasionGallerController::class, 'update'])->name('occasion_gallery.update');
                Route::delete('occasion_group_gallerys/{occ_id}/{id}', [OccasionGallerController::class, 'destroy'])->name('occasion_gallery.destroy');


                Route::get('occasion_group_gallerys-update-featured/{occ_id}', [OccasionGallerController::class, 'updateFeature'])->name('occasion_group_gallerys.update-featured');
                Route::get('occasion_group_gallerys-update-status/{occ_id}', [OccasionGallerController::class, 'updateStatus'])->name('occasion_group_gallerys.update-status');

                Route::post('occasion_group_gallerys/actions/{occ_id}', [OccasionGallerController::class, 'actions'])->name('occasion_group_gallerys.actions');

                //                Route::get('products-update-featured/{id}', [ProductController::class, 'updateFeature'])->name('products.update-featured');
                //                Route::get('products-update-status/{id}', [ProductController::class, 'updateStatus'])->name('products.update-status');

                Route::get('delete-album/{id}', [OccasionGallerController::class, 'delete_album'])->name('delete_album');

                /*********************end group gallery **************/


                /************************** start categories ************************************/
                Route::resource('events', ServiceCategoryEventsController::class);
                Route::get('events-update-featured/{id}', [ServiceCategoryEventsController::class, 'updateFeature'])->name('events.update-featured');
                Route::get('events-update-status/{id}', [ServiceCategoryEventsController::class, 'updateStatus'])->name('events.update-status');
                /************************** start categories ************************************/


                Route::resource('main_page_gallery', MainPageGalleryController::class);
                Route::post('main_page_gallery/actions', [MainPageGalleryController::class, 'actions'])->name('main_page_gallery.actions.now');

                //
                Route::get(
                    'admin/service/following/{id}',
                    [ServiceCategoryEventsController::class, 'destroyFollowing']
                )->name('service.events.following.delete');

                Route::delete('main_page_gallery_delete/{id}', [\App\Http\Controllers\Admin\MainPageGalleryController::class, 'destroyImage'])->name('main_page_gallery_delete.destroy');


                /************************** start products ************************************/
                Route::resource('orders', OrderController::class);
                Route::get('orders-update-featured/{id}', [OrderController::class, 'updateFeature'])->name('orders.update-featured');
                Route::get('orders-update-status/{id}', [OrderController::class, 'updateStatus'])->name('orders.update-status');
                Route::post('orders/actions', [OrderController::class, 'actions'])->name('orders.actions');

                /************************** end products ************************************/


                Route::get('whatsapp', [WhatsAppController::class, 'showForm']);
                Route::get("/send", [WhatsappController::class, 'send'])->name("send");


                /**********************************************************/


                Route::post('customer_action', [WhatsAppController::class, 'handleAction']);


                Route::get('order_email/{id}', [OrderController::class, 'sendOrderConfirmation']);
                Route::get('customer_action/{order_id}/{order_status_id}', [OrderController::class, 'deleteOrderStatus'])->name('deleteOrderStatus');
                Route::get('customer_action_shipping/{order_id}/{shipping_order_status_id}', [OrderController::class, 'deleteShippingOrderStatus'])->name('deleteShippingOrderStatus');


                Route::resource('rates', RateConteroller::class);

                /************whatsapp contacts*******/
                Route::resource('whatsapp-contact', WhatsAppContactController::class);
                Route::get('whatsapp-contact-update-featured/{id}', [WhatsAppContactController::class, 'update_feature'])->name('whatsapp-contact.update-featured');
                Route::get('whatsapp-contact-update-status/{id}', [WhatsAppContactController::class, 'update_status'])->name('whatsapp-contact.update-status');
                Route::post('whatsapp-contact/actions', [WhatsAppContactController::class, 'actions'])->name('whatsapp-contact.actions');
                /************whatsapp contacts*******/


                Route::prefix('show-in-cart-products')->group(function () {
                    Route::controller(ShowInCartProductController::class)->group(function () {
                        Route::get('list', 'index')->name('show_in_cart_product_list');
                        Route::get('create', 'create')->name('show_in_cart_product_create');
                        Route::post('add', 'store')->name('show_in_cart_product_store');
                        Route::get('edit/{id}', 'edit')->name('show_in_cart_product_edit');
                        Route::put('update/{id}', 'update')->name('show_in_cart_product_update');
                        Route::get('show/{id}', 'show')->name('show_in_cart_product_show');
                    });
                });


                Route::resource('payment-methods', PaymentMethodController::class);
                Route::post('payment-methods/actions', [PaymentMethodController::class, 'actions'])->name('payment-methods.actions');
                Route::get('payment-methods/update-status/{id}', [PaymentMethodController::class, 'update_status'])->name('payment-methods.update-status');



                Route::get('products_reports', [ProductController::class, 'reports'])->name('products_reports.reports');
                Route::get('clients_reports', [ClientsReportsController::class, 'reports'])->name('clients_reports.reports');




                // Route::prefix('promocodes')->group(function () {
                //     Route::controller(PromoController::class)->group(function () {
                //         Route::get('list', 'index')->name('promocodes.index');
                //         Route::get('create', 'create')->name('promocodes.create');
                //         Route::post('add', 'store')->name('promocodes.store');
                //         Route::get('edit/{id}', 'edit')->name('promocodes.edit');
                //         Route::put('update/{id}', 'update')->name('promocodes.update');
                //         Route::get('show/{id}', 'show')->name('promocodes.show');
                //         Route::post('actions', 'actions')->name('promocodes.actions');
                //         Route::get('update-status/{id}',  'update_status')->name('promocodes.update-status');
                //         Route::get('update-featured', 'update_feature')->name('promocodes.update-featured');
                //     });
                // });
                Route::prefix('promocodes')->group(function () {
                    // GET /admin/promocodes/list
                    Route::get('list', [PromoController::class, 'index'])->name('promocodes.index');

                    // GET /admin/promocodes/create
                    Route::get('create', [PromoController::class, 'create'])->name('promocodes.create');

                    // POST /admin/promocodes/store
                    Route::post('store', [PromoController::class, 'store'])->name('promocodes.store');

                    // GET /admin/promocodes/edit/{id}
                    Route::get('edit/{id}', [PromoController::class, 'edit'])->name('promocodes.edit');

                    // PUT /admin/promocodes/update/{id}
                    Route::put('update/{id}', [PromoController::class, 'update'])->name('promocodes.update');

                    // DELETE /admin/promocodes/delete/{id}
                    Route::delete('delete/{id}', [PromoController::class, 'destroy'])->name('promocodes.destroy');

                    // GET /admin/promocodes/toggle-status/{id}
                    Route::get('toggle-status/{id}', [PromoController::class, 'updateStatus'])
                        ->name('promocodes.toggle-status');
                });



                //                /************   *******/
                //                Route::resource('whatsapp-contact', WhatsAppContactController::class);
                //                Route::get('whatsapp-contact-update-featured/{id}', [WhatsAppContactController::class, 'update_feature'])->name('whatsapp-contact.update-featured');
                //                Route::get('whatsapp-contact-update-status/{id}', [WhatsAppContactController::class, 'update_status'])->name('whatsapp-contact.update-status');
                //                Route::post('whatsapp-contact/actions', [WhatsAppContactController::class, 'actions'])->name('whatsapp-contact.actions');
                //                /************whatsapp contacts*******/


            });
        });
    });
});
// require __DI
