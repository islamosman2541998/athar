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
                                enctype="multipart/form-data" role="form">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">

                                        {{-- -------------------------------- --}}
                                        <div class="accordion mt-4 mb-4" id="couponSettingsAccordion">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingCouponSettings">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseCouponSettings"
                                                        aria-expanded="true" aria-controls="collapseCouponSettings">
                                                        @lang('settings.home')
                                                    </button>
                                                </h2>
                                                <div id="collapseCouponSettings"
                                                    class="accordion-collapse collapse show mt-3"
                                                    aria-labelledby="headingCouponSettings"
                                                    data-bs-parent="#couponSettingsAccordion">
                                                    <div class="accordion-body">
                                                        @foreach ($languages as $lang)
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label">
                                                                    {{ trans('admin.coupon_title_in') . trans('lang.' . Locale::getDisplayName($lang)) }}

                                                                </label>
                                                                <div class="col-sm-10">
                                                                    <input type="text"
                                                                        name="coupon_title_{{ $lang }}"
                                                                        value="{{ old("coupon_title_$lang", $settings["coupon_title_$lang"] ?? '') }}"
                                                                        class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label">
                                                                    {{ trans('admin.coupon_desc_in') . trans('lang.' . Locale::getDisplayName($lang)) }}
                                                                </label>
                                                                <div class="col-sm-10">
                                                                    <textarea name="coupon_description_{{ $lang }}" class="form-control" rows="4">{{ old("coupon_description_$lang", $settings["coupon_description_$lang"] ?? '') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label">
                                                {{ __('settings.show_popup') }} 
                                            </label>
                                            <div class="col-sm-10 d-flex align-items-center">
                                                @php
                                                    $showPopup = (int) ($settings['coupon_show_popup'] ?? 0);
                                                @endphp
                                                <input type="hidden" name="coupon_show_popup" value="0">
                                                <input type="checkbox" name="coupon_show_popup" value="1"
                                                    id="coupon_show_popup" {{ $showPopup ? 'checked' : '' }}>
                                                <label for="coupon_show_popup" class="ms-2">
                                                    {{ __('settings.enable_coupon_popup') }} 
                                                </label>
                                            </div>
                                        </div>

                                        {{-- --------------------------------------------------- --}}
                                        <div class="row mb-4">
                                            <label class="col-sm-2 col-form-label">
                                                {{ __('admin.select_coupon') }}
                                            </label>
                                            <div class="col-sm-10">
                                                <select name="welcome_coupon_id"
                                                    class="form-select @error('welcome_coupon_id') is-invalid @enderror">
                                                    @foreach ($allCoupons as $coupon)
                                                        <option value="{{ $coupon->id }}"
                                                            {{ old('welcome_coupon_id', $settings['welcome_coupon_id'] ?? '') == $coupon->id ? 'selected' : '' }}>
                                                            {{ $coupon->code }}
                                                            —
                                                            @if ($coupon->type === 'percent')
                                                                {{ $coupon->value }}%
                                                            @else
                                                                {{ number_format($coupon->value, 2) }}
                                                            @endif
                                                            ({{ optional($coupon->transNow)->title ?? '-' }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('welcome_coupon_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- /.card-body -->
                                <div class="card-footer text-end">
                                    <a href="{{ route('admin.settings.index') }}"
                                        class="btn btn-outline-danger waves-effect waves-light ml-3">@lang('button.cancel')</a>
                                    <button type="submit" class="btn btn-success">@lang('button.save')</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div> <!-- container-fluid -->

@endsection

@section('script')
    {{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
@endsection
