@extends('admin.app')

@section('title', trans('menus.edit_menus'))
@section('title_page', trans('menus.edit', ['name' => @$menu->trans->where('locale', $current_lang)->first()->title]))

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="row">
            <div class="col-12 m-3">
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        {{-- <h2 class="card-title">@lang('admin.page_create')</h2> --}}
                        <form action="{{ route('admin.menus.update', $menu->id) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-9">
                                    {{-- Start Input Name Arabic   --}}


                                    @foreach ($languages as $key => $locale)
                                    <div class="accordion mt-4 mb-4" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                </button>
                                            </h2>
                                            <div id="collapseOne{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne{{ $key }}" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">



                                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control title" type="text" name="{{ $locale }}[title]" value="{{ @$menu->trans->where('locale', $locale)->first()->title }}" id="title{{ $key }}">

                                                        </div>
                                                        @if ($errors->has($locale . '.title'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                        @endif
                                                    </div>

                                                    {{-- slug ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3 slug-section">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="{{ $locale }}[slug]" value="{{ @$menu->trans->where('locale', $locale)->first()->slug }}" id="slug{{ $key }}" class="form-control slug" required>
                                                        </div>
                                                        @if ($errors->has($locale . '.slug'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                        @endif

                                                        @include('admin.layouts.scriptSlug')
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach








                                </div>
                                <div class="col-md-3">
                                    <div class="card-body">

                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        {{ trans('menus.Settings') }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">

                                                        {{-- type menu ------------------------------------------------------------------------------------- --}}
                                                        <div class=" row mb-3">
                                                            <label for="example-number-input"> @lang('menus.position'):
                                                            </label>
                                                            <div class="col-sm-12">
                                                                @foreach (App\Enums\MenuPositionEnums::values() as $pos)
                                                                <input type="radio" {{ $pos == @$menu->position ? 'checked' : '' }} class="position" id="position" name="position" value="{{ $pos }}" required>
                                                                <label for="html">{{ $pos }}</label><br>
                                                                @endforeach

                                                                @error('position')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class=" row mb-3">
                                                            <label for="example-number-input">
                                                                @lang('menus.parent'):</label>
                                                            <div class="col-sm-12">
                                                                <select class="form-select form-select-sm select2" id="parents" name="parent_id">
                                                                    <option value="" selected>
                                                                        {{ trans('menus.select_parent') }}</option>
                                                                    @foreach ($menus as $menuItem)
                                                                    <option value="{{ $menuItem->id }}" {{ $menuItem->id == $menu->parent_id ? 'selected' : '' }}>
                                                                        @if ($menuItem->level != null)
                                                                        {{ str_repeat('ـــ ', $menuItem->level - 1) }}
                                                                        @endif
                                                                        {{ @$menuItem->trans->where('locale', $current_lang)->first()->title }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('parent_id')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        {{-- sort ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('admin.sort'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="number" id="example-number-input" name="sort" value="{{ @$menu->sort }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3 title-section">
                                                            <label for="example-text-input" class="col-sm-6 col-form-label">{{ trans('menus.type') }}</label>
                                                            <div class="col-sm-12">
                                                                <select class="form-select form-select-sm" name="type" id="type" aria-label=".form-select-sm example">
                                                                    <option value="" selected>@lang('menus.type')
                                                                    </option>
                                                                    @foreach (App\Enums\MunesEnums::values() as $ee)
                                                                    <option {{ $ee == @$menu->type ? 'selected' : '' }}>
                                                                        {{ $ee }} </option>
                                                                    @endforeach
                                                                </select>
                                                                @if ('type')
                                                                <span class="missiong-spam">{{ $errors->first('type') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3 title-section" id="static-url" @if (@$menu->type != App\Enums\MunesEnums::STATIC) style="display: none;" @endif>
                                                            <label for="example-text-input" class="col-sm-6 col-form-label">{{ trans('menus.url') }}</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" id="static_url" type="text" name="url" value="{{ @$menu->url ?? old('url') }}">
                                                                @if ('url')
                                                                <span class="missiong-spam">{{ $errors->first('url') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>


                                                        <div id="dynamic-url" @if (@$menu->type != App\Enums\MunesEnums::DYNAMIC) style="display: none;" @endif>
                                                            <div class="row mb-3 title-section">
                                                                <label for="example-text-input" class="col-sm-6 col-form-label">{{ trans('menus.type_url') }}</label>
                                                                <div class="col-sm-12">
                                                                    <select class="form-select form-select-sm" id="dynamic-type" name="dynamic_table" aria-label=".form-select-sm example">
                                                                        <option value=""> @lang('menus.select_url')
                                                                        </option>
                                                                        @foreach (App\Enums\UrlTypesEnum::values() as $enumTypes)
                                                                        <option value="{{ $enumTypes }}" {{ $enumTypes == @$menu->dynamic_table ? 'selected' : '' }}>
                                                                            {{ $enumTypes }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if ('type')
                                                                    <span class="missiong-spam">{{ $errors->first('dynamic_table') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3 title-section">
                                                                <label for="example-text-input" class="col-sm-6 col-form-label">{{ trans('menus.url') }}</label>
                                                                <div class="col-sm-12">
                                                                    <select class="form-select form-select-sm" name="dynamic_url" id="get-dynamic-urls" aria-label=".form-select-sm example">
                                                                        <option value="{{ @$menu->dynamic_url }}">
                                                                            {{ @$menu->dynamic_url }}</option>
                                                                    </select>
                                                                    @if ('type')
                                                                    <span class="missiong-spam">{{ $errors->first('dynamic_url') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label class="col-sm-3 col-form-label" for="available">{{ trans('menus.status') }}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-check form-switch" name="status" type="checkbox" id="switch4" switch="success" {{ $menu->status == '1' ? 'checked' : '' }} value="{{ $menu->status }}">
                                                                    <label class="form-label" for="switch4" data-on-label="{{ trans('admin.yes') }}" data-off-label="{{ trans('admin.no') }}"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row mb-3 text-end">
                                    <div>
                                        <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
                                        <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3">@lang('button.save')</button>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div> <!-- end row-->

</div> <!-- container-fluid -->

@endsection
@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <<script src="https://cdn.ckeditor.com/4.5.6/full/ckeditor.js"></script>
@endsection
@section('script')
    <script>//here
        $(document).ready(function() {
            $("#type").on('change', function() {
                var val = $(this).val();
                if (val == "static") {
                    $('#static-url').show();
                    $('#dynamic-url').hide();

                    $("#static_url").prop('required', true);
                    $("#dynamic-type").prop('required', false);
                    $("#get-dynamic-urls").prop('required', false);

                } else {
                    $('#static-url').hide();
                    $('#dynamic-url').show();
                    $('#get-dynamic-urls').find('option').remove().end();

                    $("#static_url").prop('required', false);
                    $("#dynamic-type").prop('required', true);
                    $("#get-dynamic-urls").prop('required', true);
                }
            });

            $("#dynamic-type").on('change', function() {   //here
                let val = $(this).val();
                if (val == "about-us") {
                    $('#get-dynamic-urls').find('option').remove().end();
                    $("#get-dynamic-urls").append('<option selected value="/about-us">/about-us</option>');
                } else if (val == "contact-us") {
                    $('#get-dynamic-urls').find('option').remove().end();
                    $("#get-dynamic-urls").append('<option selected value="/contact-us">/contact-us</option>');
                } else if (val == "all-categories") {
                    $('#get-dynamic-urls').find('option').remove().end();
                    $("#get-dynamic-urls").append('<option selected value="/categories">/categories</option>');
                } else if (val == "all-products") {
                    $('#get-dynamic-urls').find('option').remove().end();
                    $("#get-dynamic-urls").append('<option selected value="/products">/products</option>');
                } else if (val == "all-blogs") {
                    $('#get-dynamic-urls').find('option').remove().end();
                    $("#get-dynamic-urls").append('<option selected value="/blogs">/blogs</option>');
                } else if (val == "all-news") {
                    $('#get-dynamic-urls').find('option').remove().end();
                    $("#get-dynamic-urls").append('<option selected value="/news">/news</option>');
                } else if (val == "all-jobs") {
                    $('#get-dynamic-urls').find('option').remove().end();
                    $("#get-dynamic-urls").append('<option selected value="/jobs">/jobs</option>');
                } else if (val == "faq-questions") {
                    $('#get-dynamic-urls').find('option').remove().end();
                    $("#get-dynamic-urls").append('<option selected value="/faq-questions">/faq-questions</option>');
                } else {
                    var url = "{{ route('admin.menus.getUrl') }}"; //here
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data: {
                            "name": val,
                        },
                        success: function(data) {
                            $('#get-dynamic-urls').find('option').remove().end();
                            $("#get-dynamic-urls").append('<option value=""></option>');

                            $.each(data, function(key, item) {
                                $("#get-dynamic-urls").append('<option value="' + item +
                                    '">' + item + '</option>');
                            });
                        }
                    });
                }

            });


            $(".position").change(function() {
                var url = "{{ route('admin.menus.getMenus') }}";
                var position = $(this).val();
                var text = "ـــ ";
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        "position": position,
                    },
                    success: function(data) {
                        $('#parents').find('option').remove().end();
                        $("#parents").append('<option value="">@lang('menus.select_parent')</option>');
                        $.each(data, function(key, item) {
                            console.log();
                            $("#parents").append('<option value="' + item.id + '">' +
                                text.repeat(item.level - 1) + item.name +
                                '</option>');
                        });

                    }
                });
            });

        });
    </script>

@endsection
