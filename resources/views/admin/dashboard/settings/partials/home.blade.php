@extends('admin.app')

@section('title', trans('settings.settings'))
@section('title_page', trans('settings.edit', ['name' => @$settingMain->key]))

@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.5.6/full/ckeditor.js"></script>
@endsection
@section('content')
    <div class="container-fluid">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="card">
                        <div class="card-body">

                            <!-- form start -->
                            <form class="form-horizontal"
                                action="{{ route('admin.settings.update-custom', $settingMain->key) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="accordion mt-4 mb-4" id="upperNotifyAccordion">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingUpperNotify">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseUpperNotify"
                                                        aria-expanded="true" aria-controls="collapseUpperNotify">
                                                        {{ __('settings.home_setting') }}
                                                    </button>
                                                </h2>
                                                <div id="collapseUpperNotify" class="accordion-collapse collapse show mt-3"
                                                    aria-labelledby="headingUpperNotify"
                                                    data-bs-parent="#upperNotifyAccordion">
                                                    <div class="accordion-body">
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                {{ __('settings.show_slider') }}
                                                            </label>
                                                            <div class="col-sm-10 d-flex align-items-center">
                                                                @php
                                                                    $show_slider =
                                                                        (int) ($settings['show_slider'] ?? 0);
                                                                @endphp


                                                                <input type="hidden" name="show_slider" value="0">

                                                                <!-- Bootstrap Custom Switch -->
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="show_slider" value="1"
                                                                        id="show_slider"
                                                                        {{ $show_slider ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="show_slider">
                                                                        <span class="switch-text-on">ON</span>
                                                                        <span class="switch-text-off">OFF</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                {{ __('settings.show_about_us') }}
                                                            </label>
                                                            <div class="col-sm-10 d-flex align-items-center">
                                                                @php
                                                                    $show_about_us =
                                                                        (int) ($settings['show_about_us'] ?? 0);
                                                                @endphp


                                                                <input type="hidden" name="show_about_us" value="0">

                                                                <!-- Bootstrap Custom Switch -->
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="show_about_us" value="1"
                                                                        id="show_about_us"
                                                                        {{ $show_about_us ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="show_about_us">
                                                                        <span class="switch-text-on">ON</span>
                                                                        <span class="switch-text-off">OFF</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                         <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                {{ __('settings.show_statistics') }}
                                                            </label>
                                                            <div class="col-sm-10 d-flex align-items-center">
                                                                @php
                                                                    $show_statistics =
                                                                        (int) ($settings['show_statistics'] ?? 0);
                                                                @endphp


                                                                <input type="hidden" name="show_statistics" value="0">

                                                                <!-- Bootstrap Custom Switch -->
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="show_statistics" value="1"
                                                                        id="show_statistics"
                                                                        {{ $show_statistics ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="show_statistics">
                                                                        <span class="switch-text-on">ON</span>
                                                                        <span class="switch-text-off">OFF</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                {{ __('settings.show_product') }}
                                                            </label>
                                                            <div class="col-sm-10 d-flex align-items-center">
                                                                @php
                                                                    $show_product =
                                                                        (int) ($settings['show_product'] ?? 0);
                                                                @endphp


                                                                <input type="hidden" name="show_product" value="0">

                                                                <!-- Bootstrap Custom Switch -->
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="show_product" value="1"
                                                                        id="show_product"
                                                                        {{ $show_product ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="show_product">
                                                                        <span class="switch-text-on">ON</span>
                                                                        <span class="switch-text-off">OFF</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                {{ __('settings.show_category') }}
                                                            </label>
                                                            <div class="col-sm-10 d-flex align-items-center">
                                                                @php
                                                                    $show_category =
                                                                        (int) ($settings['show_category'] ?? 0);
                                                                @endphp


                                                                <input type="hidden" name="show_category" value="0">

                                                                <!-- Bootstrap Custom Switch -->
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="show_category" value="1"
                                                                        id="show_category"
                                                                        {{ $show_category ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="show_category">
                                                                        <span class="switch-text-on">ON</span>
                                                                        <span class="switch-text-off">OFF</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                {{ __('settings.show_career') }}
                                                            </label>
                                                            <div class="col-sm-10 d-flex align-items-center">
                                                                @php
                                                                    $show_career =
                                                                        (int) ($settings['show_career'] ?? 0);
                                                                @endphp


                                                                <input type="hidden" name="show_career" value="0">

                                                                <!-- Bootstrap Custom Switch -->
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="show_career" value="1"
                                                                        id="show_career"
                                                                        {{ $show_career ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="show_career">
                                                                        <span class="switch-text-on">ON</span>
                                                                        <span class="switch-text-off">OFF</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                {{ __('settings.show_blogs') }}
                                                            </label>
                                                            <div class="col-sm-10 d-flex align-items-center">
                                                                @php
                                                                    $show_blogs =
                                                                        (int) ($settings['show_blogs'] ?? 0);
                                                                @endphp


                                                                <input type="hidden" name="show_blogs" value="0">

                                                                <!-- Bootstrap Custom Switch -->
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="show_blogs" value="1"
                                                                        id="show_blogs"
                                                                        {{ $show_blogs ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="show_blogs">
                                                                        <span class="switch-text-on">ON</span>
                                                                        <span class="switch-text-off">OFF</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                {{ __('settings.show_partners') }}
                                                            </label>
                                                            <div class="col-sm-10 d-flex align-items-center">
                                                                @php
                                                                    $show_partners =
                                                                        (int) ($settings['show_partners'] ?? 0);
                                                                @endphp


                                                                <input type="hidden" name="show_partners" value="0">

                                                                <!-- Bootstrap Custom Switch -->
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="show_partners" value="1"
                                                                        id="show_partners"
                                                                        {{ $show_partners ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="show_partners">
                                                                        <span class="switch-text-on">ON</span>
                                                                        <span class="switch-text-off">OFF</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                {{ __('settings.show_news') }}
                                                            </label>
                                                            <div class="col-sm-10 d-flex align-items-center">
                                                                @php
                                                                    $show_news =
                                                                        (int) ($settings['show_news'] ?? 0);
                                                                @endphp


                                                                <input type="hidden" name="show_news" value="0">

                                                                <!-- Bootstrap Custom Switch -->
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="show_news" value="1"
                                                                        id="show_news"
                                                                        {{ $show_news ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="show_news">
                                                                        <span class="switch-text-on">ON</span>
                                                                        <span class="switch-text-off">OFF</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                {{ __('settings.show_contact_us') }}
                                                            </label>
                                                            <div class="col-sm-10 d-flex align-items-center">
                                                                @php
                                                                    $show_contact_us =
                                                                        (int) ($settings['show_contact_us'] ?? 0);
                                                                @endphp


                                                                <input type="hidden" name="show_contact_us" value="0">

                                                                <!-- Bootstrap Custom Switch -->
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="show_contact_us" value="1"
                                                                        id="show_contact_us"
                                                                        {{ $show_contact_us ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="show_contact_us">
                                                                        <span class="switch-text-on">ON</span>
                                                                        <span class="switch-text-off">OFF</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                         <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                {{ __('settings.show_reviews') }}
                                                            </label>
                                                            <div class="col-sm-10 d-flex align-items-center">
                                                                @php
                                                                    $show_reviews =
                                                                        (int) ($settings['show_reviews'] ?? 0);
                                                                @endphp


                                                                <input type="hidden" name="show_reviews" value="0">

                                                                <!-- Bootstrap Custom Switch -->
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="show_reviews" value="1"
                                                                        id="show_reviews"
                                                                        {{ $show_reviews ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="show_reviews">
                                                                        <span class="switch-text-on">ON</span>
                                                                        <span class="switch-text-off">OFF</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                         <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                {{ __('settings.show_faq') }}
                                                            </label>
                                                            <div class="col-sm-10 d-flex align-items-center">
                                                                @php
                                                                    $show_faq =
                                                                        (int) ($settings['show_faq'] ?? 0);
                                                                @endphp


                                                                <input type="hidden" name="show_faq" value="0">

                                                                <!-- Bootstrap Custom Switch -->
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="show_faq" value="1"
                                                                        id="show_faq"
                                                                        {{ $show_faq ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="show_faq">
                                                                        <span class="switch-text-on">ON</span>
                                                                        <span class="switch-text-off">OFF</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                         <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                {{ __('settings.show_footer') }}
                                                            </label>
                                                            <div class="col-sm-10 d-flex align-items-center">
                                                                @php
                                                                    $show_footer =
                                                                        (int) ($settings['show_footer'] ?? 0);
                                                                @endphp


                                                                <input type="hidden" name="show_footer" value="0">

                                                                <!-- Bootstrap Custom Switch -->
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        role="switch" name="show_footer" value="1"
                                                                        id="show_footer"
                                                                        {{ $show_footer ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="show_footer">
                                                                        <span class="switch-text-on">ON</span>
                                                                        <span class="switch-text-off">OFF</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer text-end">
                                    <a href="{{ route('admin.settings.index') }}"
                                        class="btn btn-outline-danger waves-effect waves-light ml-3">
                                        @lang('button.cancel')
                                    </a>
                                    <button type="submit" class="btn btn-success">@lang('button.save')</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>
    </div> <!-- container-fluid -->
@endsection

@section('script')

@endsection
<style>
    .form-switch .form-check-input {
        width: 3.5em !important;
        height: 1.75em !important;
        margin-right: 0.5em !important;
    }

    .form-switch .form-check-label {
        display: flex;
        align-items: center;
        font-weight: 500;
        color: #555;
    }

    .switch-text-on,
    .switch-text-off {
        font-size: 0.8em;
        font-weight: bold;
        color: white;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        transition: opacity 0.2s;
        pointer-events: none;
    }

    .switch-text-on {
        left: 0.5em;
        opacity: 0;
    }

    .switch-text-off {
        right: 0.5em;
        opacity: 1;
    }

    .form-check-input:checked~.form-check-label .switch-text-on {
        opacity: 1;
    }

    .form-check-input:checked~.form-check-label .switch-text-off {
        opacity: 0;
    }


    .form-check-input:checked {
        background-color: #04a133 !important;
        border-color: #04a133 !important;
    }
</style>
