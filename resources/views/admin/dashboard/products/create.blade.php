@extends('admin.app')

@section('title', trans('admin.create') . ' ' . trans('admin.product'))
@section('title_page', trans('admin.create') . ' ' . trans('admin.product'))

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12 m-3">
            <div class="row mb-3 text-end">
                <div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-8">

                                @foreach ($languages as $key => $locale)
                                <div class="accordion mt-4 mb-4 bg-primary" id="accordionExample{{ $locale }}">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingOne{{ $locale }}">
                                            <button class="accordion-button fw-medium " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $locale }}" aria-expanded="true" aria-controls="collapseOne{{ $locale }}">
                                                {{ __('products.' . $locale) }}
                                            </button>
                                        </h2>
                                        <div id="collapseOne{{ $locale }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne{{ $locale }}" data-bs-parent="#accordionExample{{ $locale }}">
                                            <div class="accordion-body">


                                                {{-- title ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" required name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}" id="title{{ $key }}">
                                                        @if ($errors->has($locale . '.title'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- slug ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3 slug-section">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <input type="text" id="slug{{ $key }}" name="{{ $locale }}[slug]" value="{{ old($locale . '.slug') }}" class="form-control slug">
                                                        @if ($errors->has($locale . '.slug'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                        @endif
                                                    </div>
                                                    @include('admin.layouts.scriptSlug')
                                                </div>

                                                {{-- description ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('products.description') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">

                                                        <textarea class="form-control" id="description{{ $key }}" name="{{ $locale }}[description]">
                                                        {{ old($locale . '.description') }}
                                                        </textarea>


                                                        <script type="text/javascript">
                                                            CKEDITOR.replace('description{{ $key }}', {
                                                                filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                , filebrowserUploadMethod: 'form'
                                                            });

                                                        </script>


                                                    </div>
                                                    @if ($errors->has($locale . '.description'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                    @endif
                                                </div>




                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @endforeach

                                <!-----start meta ------>
                                <div class="accordion mt-4 mb-4 bg-primary" id="accordionExampleSlugs">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingOneSlugs">
                                            <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOneSlugs" aria-expanded="false" aria-controls="collapseOneSlugs">
                                                {{ __('products.meta_info') }}
                                            </button>
                                        </h2>
                                        <div id="collapseOneSlugs" class="accordion-collapse collapse  mt-3" aria-labelledby="headingOneSlugs" data-bs-parent="#accordionExampleSlugs">
                                            <div class="accordion-body">

                                                @foreach ($languages as $key => $locale)
                                                {{-- meta_title ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('products.meta_title') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">

                                                        <input class="form-control" name="{{ $locale }}[meta_title]" value="{{ old($locale . '.meta_title') }} ">


                                                    </div>
                                                    @if ($errors->has($locale . '.meta_title'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                    @endif
                                                </div>


                                                {{-- meta_desc ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('products.meta_desc') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">

                                                        <textarea class="form-control" id="meta_description{{ $key }}" name="{{ $locale }}[meta_desc]">
                                                        {{ old($locale . '.meta_desc') }}
                                                        </textarea>


                                                    </div>
                                                    @if ($errors->has($locale . '.meta_desc'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.meta_desc') }}</span>
                                                    @endif
                                                </div>


                                                {{-- meta_key ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('products.meta_key') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">

                                                        <textarea class="form-control" name="{{ $locale }}[meta_key]">
                                                        {{ old($locale . '.meta_key') }}
                                                        </textarea>

                                                    </div>
                                                    @if ($errors->has($locale . '.meta_key'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
                                                    @endif
                                                </div>

                                                <br>
                                                <hr>
                                                <br>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!----------end meta ---------->


                                {{-- images Gellary  --}}
                                <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingImage">
                                            <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseImage" aria-expanded="false" aria-controls="collapseOne">
                                                @lang('admin.gallerys')
                                            </button>
                                        </h2>
                                        <div id="collapseImage" class="accordion-collapse collapse mt-3" aria-labelledby="headingImage" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="row mb-3">

                                                    <input type="hidden" class="form-control" value="0" name="gallery[type]">

                                                    @foreach (config('translatable.locales') as $lang)
                                                    <div class=" mb-3 col-sm-2 col-form-label">
                                                        <label>@lang('admin.group_title_' . $lang)</label>
                                                    </div>

                                                    <div class=" mb-3 col-sm-10 ">
                                                        <input type="text" class="form-control" value="" name="gallery[{{ $lang }}][title]">
                                                    </div>
                                                    @endforeach

                                                    <br>
                                                    <br>
                                                    <br>

                                                    <div id="images_section"></div>
                                                    <button type="button" class="btn btn-success form-control mt-3" id="add_images_section">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>


                            <div class="col-md-4">

                                {{-- Main Settings --}}
                                <div class="accordion mt-4 mb-4" id="accordionExample1">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingtwo">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                {{ trans('admin.settings') }}
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingtwo" data-bs-parent="#accordionExample1">
                                            <div class="accordion-body">

                                                {{-- image --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <div class="col-sm-4"><label for="example-number-input" class='col-form-label'>
                                                                @lang('products.main_image'):</label></div>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="file" id="example-number-input" name="image" value="{{ old('image') }}">
                                                            <span class="text-danger"> Size: 358 x 360</span>

                                                        </div>
                                                    </div>
                                                    @if ($errors->has('image'))
                                                    <span class="missiong-spam">{{ $errors->first('image') }}</span>
                                                    @endif
                                                </div>

                                                {{-- cats --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-4 col-form-label">{{ trans('products.categories') }}</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-select form-select-sm select2" multiple name="categories[]" required>
                                                            <option value="" disabled> </option>
                                                            @forelse($cats as $key2 => $cat)
                                                            <option value="{{ $cat->id }}" {{ in_array($cat->id ,  old('categories') ?? [] )  ? 'selected' : '' }}>
                                                                {{ isset($cat->trans[0]) ? $cat->trans[0]->title : '' }}
                                                            </option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                    @if ($errors->has('categories'))
                                                    <span class="missiong-spam">{{ $errors->first('categories') }}</span>
                                                    @endif
                                                </div>

                                                {{-- code ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-4 col-form-label">{{ trans('products.code') }}</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="text" name="code" value="{{ old('code') }}">
                                                    </div>
                                                    @if ($errors->has('code'))
                                                    <span class="missiong-spam">{{ $errors->first('code') }}</span>
                                                    @endif
                                                </div>

                                                {{-- sort ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-4 col-form-label">{{ trans('products.sort') }}</label>
                                                    <div class="col-sm-8">
                                                        <input class="form-control" type="number" name="sort" value="{{ old('sort') }}">
                                                    </div>
                                                    @if ($errors->has('sort'))
                                                    <span class="missiong-spam">{{ $errors->first('sort') }}</span>
                                                    @endif
                                                </div>


                                                {{-- resources/views/livewire/admin/calculate-after-sale.blade.php --}}
                                                {{-- //here --}}
                                                @livewireStyles
                                                @livewire('admin.calculate-after-sale')


                                                {{-- feature ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12 col-sm-12">
                                                    <label class="col-sm-12 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-check form-switch" name="feature" type="checkbox" id="switch1" switch="success" {{ old('feature') == 'on' ? 'checked' : '' }}>
                                                        <label class="form-label" for="switch1" data-on-label=" @lang('admin.yes') " data-off-label=" @lang('admin.no')"></label>
                                                    </div>
                                                </div>
                                                @if ($errors->has('feature'))
                                                <span class="missiong-spam">{{ $errors->first('feature') }}</span>
                                                @endif
                                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <label class="col-sm-12 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-check form-switch" name="status" type="checkbox" id="switch3" switch="success" {{ old('status') == 'on' ? 'checked' : '' }}>
                                                        <label class="form-label" for="switch3" data-on-label=" @lang('admin.yes') " data-off-label=" @lang('admin.no')"></label>
                                                    </div>
                                                    @if ($errors->has('status'))
                                                    <span class="missiong-spam">{{ $errors->first('status') }}</span>
                                                    @endif
                                                </div>

                                                <hr>
                                                {{-- has_pockets --}}
                                                <div class="col-12">
                                                    <label class="col-sm-12 col-form-label"
                                                        for="has_pockets">{{ trans('products.medicine_feature') }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-check form-switch" name="has_pockets"
                                                            type="checkbox" id="switch_has_pockets" switch="success"
                                                            {{ old('has_pockets') == 'on' ? 'checked' : '' }}>
                                                        <label class="form-label" for="switch_has_pockets"
                                                            data-on-label="@lang('admin.yes')"
                                                            data-off-label="@lang('admin.no')"></label>
                                                    </div>
                                                    @if ($errors->has('has_pockets'))
                                                        <span
                                                            class="missiong-spam">{{ $errors->first('has_pockets') }}</span>
                                                    @endif
                                                </div>
                                                <div class="col-12 col-sm-12">
                                                    <div id="pockets_section" style="display: none;">
                                                        <h4>{{ trans('products.medicine_feature') }}</h4>
                                                        <div id="pockets_inputs"></div>
                                                        <button type="button" class="btn btn-success mt-3"
                                                            id="add_pocket">
                                                            <i class="fa fa-plus"></i> {{ trans('products.add_feature') }}
                                                        </button>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-12">
                                    <div class="accordion mt-4 mb-4" id="accordionSetting2">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingSetting2">
                                                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting2" aria-expanded="true" aria-controls="collapseSetting2">
                                                    {{ trans('admin.payment_lines') }}
                                                </button>
                                            </h2>
                                            <div id="collapseSetting2" class="accordion-collapse collapse" aria-labelledby="headingSetting2" data-bs-parent="#accordionSetting2">
                                                <div class="accordion-body">
                                                    {{-- has_payment_lines --}}
                                                    <div id="payment_lines_section">
                                                        <h4>{{ trans('products.payment_lines') }}</h4>
                                                        <div id="payment_lines_section_inputs"></div>
                                                        <button type="button" class="btn btn-success mt-3" id="add_payment_lines_section">
                                                            <i class="fa fa-plus"></i> {{ trans('products.payment_lines') }}
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="accordion mt-4 mb-4" id="accordionSetting3">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingSetting3">
                                                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting3" aria-expanded="true" aria-controls="collapseSetting3">
                                                    {{ trans('admin.product_tips') }}
                                                </button>
                                            </h2>
                                            <div id="collapseSetting3" class="accordion-collapse collapse" aria-labelledby="headingSetting3" data-bs-parent="#accordionSetting3">
                                                <div class="accordion-body">

                                                    {{-- has_product_tips --}}
                                                    <div id="product_tips_section">
                                                        <h4>{{ trans('products.product_tips') }}</h4>
                                                        <div id="product_tips_section_inputs"></div>
                                                        <button type="button" class="btn btn-success mt-3" id="add_product_tips_section">
                                                            <i class="fa fa-plus"></i> {{ trans('products.product_tips') }}
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="accordion mt-4 mb-4" id="accordionSetting4">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingSetting4">
                                                <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting4" aria-expanded="true" aria-controls="collapseSetting4">
                                                    {{ trans('admin.product_info') }}
                                                </button>
                                            </h2>
                                            <div id="collapseSetting4" class="accordion-collapse collapse " aria-labelledby="headingSetting4" data-bs-parent="#accordionSetting4">
                                                <div class="accordion-body">

                                                    {{-- has_product_tips --}}
                                                    <div id="product_info_section">
                                                        <h4>{{ trans('products.product_info') }}</h4>
                                                        <div id="product_info_section_inputs"></div>
                                                        <button type="button" class="btn btn-success mt-3" id="add_product_info_section">
                                                            <i class="fa fa-plus"></i> {{ trans('products.product_info') }}
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- Butoooons ------------------------------------------------------------------------- --}}
                            <div class="row mb-3 text-end">
                                <div>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                    <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                                </div>
                            </div>
                        </div>
                </div>

                </form>

            </div>
        </div>
    </div> <!-- end col -->
</div>
</div> <!-- container-fluid -->

@endsection


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
<script>
    $(document).ready(function() {

        $('#add_images_section').on('click', function() {
            $('#images_section').append(`
            <div class="images">
                <div class="row">
                    <div class="col-12">
                        <label>@lang('admin.image'):</label>
                        <input type="file" name="gallery_image[]" class="form-control" required>
                    </div>
                    <div class="col-3">
                        <label>@lang('admin.sort'):</label>
                        <input type="number" name="gallery_sort[]" class="form-control" required>
                    </div>
                    <div class="col-3">
                        <label>@lang('admin.feature'):</label>
                        <input type="checkbox" name="gallery_feature[]" value="1" style="margin-top:28px;">
                    </div>
                    <div class="col-12 mt-3">
                        <button type="button" class="btn btn-danger delete_img form-control">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
                <hr>
            </div>
            `);
        });

        $('#images_section').on('click', '.delete_img', function() {
            $(this).closest('.images').remove();
        });


        //  START Payment Lines -----------------------------------------------------------------------------------------------------------------------------
        let paymentLineIndex = 0;
        $('#add_payment_lines_section').on('click', function() {
            // Ensure paymentLineIndex is defined and available in the scope (e.g., let paymentLineIndex = 0;)
            const currentaymentLineIndex = paymentLineIndex++;

            // Use a multi-column grid for better layout
            $('#payment_lines_section_inputs').append(`
                <div class="payment_lines-row mb-4 p-4 border border-gray-200 rounded-xl shadow-sm bg-white transition duration-150 ease-in-out">
                    <div class="row g-3">
                        
                        <!-- Multilingual Titles (Full Width) -->
                        <div class="col-md-12">
                            <label class="form-label text-sm font-semibold mb-1">Titles</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-indigo-50 border-r-0">EN</span>
                                <input type="text" name="lines[${currentaymentLineIndex}][title][en]" class="form-control" placeholder="{{ trans('products.feature_name_en') }}" required >
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-50 border-r-0">AR</span>
                                <input type="text" name="lines[${currentaymentLineIndex}][title][ar]" class="form-control" placeholder="{{ trans('products.feature_name_ar') }}" required >
                            </div>
                        </div>

                        <!-- Static Fields (Split Layout) -->
                        <div class="col-md-12">
                            <label class="form-label text-sm mb-1">links</label>
                            <input type="text" name="lines[${currentaymentLineIndex}][links]" class="form-control" required>
                        </div>
                        <!-- Static Fields (Split Layout) -->
                        <div class="col-md-4">
                            <label class="form-label text-sm mb-1">Sort Order</label>
                            <input type="number" name="lines[${currentaymentLineIndex}][sort]" class="form-control" placeholder="e.g., 10" value="${currentaymentLineIndex + 1}" min="1" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label text-sm mb-1">Color</label>
                            <input type="color" name="lines[${currentaymentLineIndex}][color]" class="form-control form-control-color w-full h-10 cursor-pointer" required value="#374151" title="Choose tip color">
                        </div>

                        <div class="col-md-3 text-end align-self-end">
                            <label class="form-label text-sm mb-1 opacity-0">Action</label>
                            <button type="button" class="btn btn-danger remove_paymentLine w-full">
                                <i class="fa fa-trash me-1"></i> Remove
                            </button>
                        </div>

                        <div class="col-md-3 pt-2 border-t border-gray-100 mt-2">
                            <label class="form-label text-sm font-semibold me-4">Status:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="lines[${currentaymentLineIndex}][status]" id="status_active_${currentaymentLineIndex}" value="1" checked>
                                <label class="form-check-label" for="status_active_${currentaymentLineIndex}"> Active </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="lines[${currentaymentLineIndex}][status]" id="status_inactive_${currentaymentLineIndex}" value="0">
                                <label class="form-check-label" for="status_inactive_${currentaymentLineIndex}"> Inactive </label>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            // Auto-scroll to the new element
            $('#payment_lines_section_inputs').find('.payment_lines-row').last()[0].scrollIntoView({
                behavior: 'smooth'
            });
        });
        // Required listener for the remove button
        $(document).on('click', '.remove_paymentLine', function() {
            $(this).closest('.payment_lines-row').remove();
        });
        //  END payment Lines -----------------------------------------------------------------------------------------------------------------------------



        //  START Payment Tips -----------------------------------------------------------------------------------------------------------------------------
        let productTipsIndex = 0;
        $('#add_product_tips_section').on('click', function() {
            // Ensure productTipsIndex is defined and available in the scope (e.g., let productTipsIndex = 0;)
            const currentProductTipsIndex = productTipsIndex++;

            // Use a multi-column grid for better layout
            $('#product_tips_section_inputs').append(`
                <div class="payment_tips-row mb-4 p-4 border border-gray-200 rounded-xl shadow-sm bg-white transition duration-150 ease-in-out">
                    <div class="row g-3">
                        
                        <!-- Multilingual Titles (Full Width) -->
                        <div class="col-md-12">
                            <label class="form-label text-sm font-semibold mb-1">Titles</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-indigo-50 border-r-0">EN</span>
                                <input type="text" name="tips[${currentProductTipsIndex}][title][en]" class="form-control" placeholder="{{ trans('products.feature_name_en') }}" required >
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-50 border-r-0">AR</span>
                                <input type="text" name="tips[${currentProductTipsIndex}][title][ar]" class="form-control" placeholder="{{ trans('products.feature_name_ar') }}" required >
                            </div>
                        </div>

                        <div class="col-md-12 pt-3">
                            <label class="form-label text-sm font-semibold mb-1">Descriptions</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-indigo-50 border-r-0">EN Desc</span>
                                <textarea name="tips[${currentProductTipsIndex}][description][en]" class="form-control" rows="2" placeholder="English description/details" required></textarea>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-50 border-r-0">AR Desc</span>
                                <textarea name="tips[${currentProductTipsIndex}][description][ar]" class="form-control" rows="2" placeholder="Arabic description/details" required></textarea>
                            </div>
                        </div>

                        <!-- Static Fields (Split Layout) -->
                        <div class="col-md-4">
                            <label class="form-label text-sm mb-1">Sort Order</label>
                            <input type="number" name="tips[${currentProductTipsIndex}][sort]" class="form-control" placeholder="e.g., 10" value="${currentProductTipsIndex + 1}" min="1" required>
                        </div>

                        <div class="col-md-3 text-end align-self-end">
                            <label class="form-label text-sm mb-1 opacity-0">Action</label>
                            <button type="button" class="btn btn-danger remove_product_tips w-full">
                                <i class="fa fa-trash me-1"></i> Remove
                            </button>
                        </div>

                        <div class="col-md-3 pt-2 border-t border-gray-100 mt-2">
                            <label class="form-label text-sm font-semibold me-4">Status:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tips[${currentProductTipsIndex}][status]" id="status_active_${currentProductTipsIndex}" value="1" checked>
                                <label class="form-check-label" for="status_active_${currentProductTipsIndex}"> Active </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tips[${currentProductTipsIndex}][status]" id="status_inactive_${currentProductTipsIndex}" value="0">
                                <label class="form-check-label" for="status_inactive_${currentProductTipsIndex}"> Inactive </label>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            // Auto-scroll to the new element
            $('#product_tips_section_inputs').find('.payment_tips-row').last()[0].scrollIntoView({
                behavior: 'smooth'
            });

        });
        // Required listener for the remove button
        $(document).on('click', '.remove_product_tips', function() {
            $(this).closest('.payment_tips-row').remove();
        });
        //  END Payment Tips -----------------------------------------------------------------------------------------------------------------------------



        //  START Payment info -----------------------------------------------------------------------------------------------------------------------------
        let productInfoIndex = 0;
        $('#add_product_info_section').on('click', function() {
            // Ensure productInfoIndex is defined and available in the scope (e.g., let productInfoIndex = 0;)
            const currentProductInfoIndex = productInfoIndex++;

            // Use a multi-column grid for better layout
            $('#product_info_section_inputs').append(`
                <div class="payment_info-row mb-4 p-4 border border-gray-200 rounded-xl shadow-sm bg-white transition duration-150 ease-in-out">
                    <div class="row g-3">
                        
                        <!-- Multilingual Titles (Full Width) -->
                        <div class="col-md-12">
                            <label class="form-label text-sm font-semibold mb-1">Titles</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-indigo-50 border-r-0">EN</span>
                                <input type="text" name="info[${currentProductInfoIndex}][title][en]" class="form-control" placeholder="{{ trans('products.feature_name_en') }}" required >
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-50 border-r-0">AR</span>
                                <input type="text" name="info[${currentProductInfoIndex}][title][ar]" class="form-control" placeholder="{{ trans('products.feature_name_ar') }}" required >
                            </div>
                        </div>

                        <div class="col-md-12 pt-3">
                            <label class="form-label text-sm font-semibold mb-1">Descriptions</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-indigo-50 border-r-0">EN Desc</span>
                                <textarea name="info[${currentProductInfoIndex}][description][en]" class="form-control" rows="2" placeholder="English description/details" required></textarea>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-50 border-r-0">AR Desc</span>
                                <textarea name="info[${currentProductInfoIndex}][description][ar]" class="form-control" rows="2" placeholder="Arabic description/details" required></textarea>
                            </div>
                        </div>

                        <!-- Static Fields (Split Layout) -->
                        <div class="col-md-4">
                            <label class="form-label text-sm mb-1">Sort </label>
                            <input type="number" name="info[${currentProductInfoIndex}][sort]" class="form-control" placeholder="e.g., 10" value="${currentProductInfoIndex + 1}" min="1" required>
                        </div>

                        <div class="col-md-3 text-end align-self-end">
                            <label class="form-label text-sm mb-1 opacity-0">Action</label>
                            <button type="button" class="btn btn-danger remove_product_info w-full">
                                <i class="fa fa-trash me-1"></i> Remove
                            </button>
                        </div>

                        <div class="col-md-3 pt-2 border-t border-gray-100 mt-2">
                            <label class="form-label text-sm font-semibold me-4">Status:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="info[${currentProductInfoIndex}][status]" id="status_active_${currentProductInfoIndex}" value="1" checked>
                                <label class="form-check-label" for="status_active_${currentProductInfoIndex}"> Active </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="info[${currentProductInfoIndex}][status]" id="status_inactive_${currentProductInfoIndex}" value="0">
                                <label class="form-check-label" for="status_inactive_${currentProductInfoIndex}"> Inactive </label>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            // Auto-scroll to the new element
            $('#product_info_section_inputs').find('.payment_info-row').last()[0].scrollIntoView({
                behavior: 'smooth'
            });

        });
        // Required listener for the remove button
        $(document).on('click', '.remove_product_info', function() {
            $(this).closest('.payment_info-row').remove();
        });
        //  END Payment INFO -----------------------------------------------------------------------------------------------------------------------------
        
        
        
        //  Start Pockets  -----------------------------------------------------------------------------------------------------------------------------
        let pocketIndex = 0;
        $('#switch_has_pockets').on('change', function() {
            $('#pockets_section').toggle(this.checked);
        });

        $('#has_pockets').on('change', function() {
            togglePocketsSection();
        });

        // Add new pocket section
        $('#add_pocket').on('click', function() {
            const currentIndex = pocketIndex++;
            $('#pockets_inputs').append(`
                <div class="pocket-row mb-3 p-3 border rounded">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <input
                                type="text"
                                name="pockets[en][${currentIndex}]"
                                class="form-control col-md-12"
                                placeholder="{{ trans('products.feature_name_en') }}"
                                required
                            >
                        </div>
                        <div class="col-md-12 mb-2">
                            <input
                                type="text"
                                name="pockets[ar][${currentIndex}]"
                                class="form-control"
                                placeholder="{{ trans('products.feature_name_ar') }}"
                                required
                            >
                        </div>
                    
                    
                        <div class="col-md-12 text-end align-self-end mb-2">
                            <button type="button" class="btn btn-danger remove_pocket">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `);
        });

        // Remove pocket section
        $('#pockets_section').on('click', '.delete_pocket', function() {
            $(this).closest('.pocket').remove();
        });
        //  End Pockets -----------------------------------------------------------------------------------------------------------------------------


    });

</script>

@endsection
