@extends('admin.app')

@section('title', trans('occasions.create'))
@section('title_page', trans('occasions.create'))

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 m-3">
                <div class="row mb-3 text-end">
                    <div>
                        <a

                            @if(request()->occ_type == "products" )
                            href="{{ route('admin.occasions_products_index.index') }}"
                            @elseif(request()->occ_type == "services")
                            href="{{ route('admin.occasions_services_index.index') }}"
                            @else
                            href="{{ route('admin.occasions.index') }}"
                            @endif
                            class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.occasions.store') }}" method="post" enctype="multipart/form-data">
                            @csrf


                            <div class="row">
                                <div class="col-md-8">

                                    @foreach ($languages as $key => $locale)

                                        <div class="accordion mt-4 mb-4 bg-primary" id="accordionExample{{$locale}}">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOne{{$locale}}">

                                                    <button class="accordion-button fw-medium " type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne{{$locale}}"
                                                            aria-expanded="true"
                                                            aria-controls="collapseOne{{$locale}}">
                                                        {{ __('occasions.' . $locale )  }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne{{$locale}}"
                                                     class="accordion-collapse collapse show mt-3"
                                                     aria-labelledby="headingOne{{$locale}}"
                                                     data-bs-parent="#accordionExample{{$locale}}">
                                                    <div class="accordion-body">


                                                        {{-- title ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                   class="col-sm-2 col-form-label">{{ trans('admin.title_in') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text"
                                                                       name="{{ $locale }}[title]"
                                                                       value="{{ old($locale . '.title') }}">
                                                            </div>
                                                            @if ($errors->has($locale . '.title'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                            @endif
                                                        </div>


                                                        {{-- description ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                   class="col-sm-2 col-form-label">{{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-10 mb-2">
                                                                <textarea id="description{{ $key }}"
                                                                          name="{{ $locale }}[description]">  {{ old($locale . '.description')}} </textarea>
                                                                @if ($errors->has($locale . '.description'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                                @endif
                                                            </div>

                                                            <script type="text/javascript">
                                                                $(function () {
                                                                    CKEDITOR.replace('description{{ $key }}');
                                                                    $('.textarea').wysihtml5()
                                                                })
                                                            </script>

                                                        </div>


                                                        {{--                                                        --}}{{-- slug ------------------------------------------------------------------------------------- --}}
                                                        {{--                                                        <div class="row mb-3">--}}
                                                        {{--                                                            <label for="example-text-input"--}}
                                                        {{--                                                                   class="col-sm-2 col-form-label">{{ trans('occasions.slug') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>--}}
                                                        {{--                                                            <div class="col-sm-10">--}}

                                                        {{--                                                                <input class="form-control"--}}
                                                        {{--                                                                          name="{{ $locale }}[slug]"--}}
                                                        {{--                                                                value="{{ old($locale . '.slug') }}" >--}}

                                                        {{--                                                            </div>--}}
                                                        {{--                                                            @if ($errors->has($locale . '.slug'))--}}
                                                        {{--                                                                <span--}}
                                                        {{--                                                                    class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>--}}
                                                        {{--                                                            @endif--}}
                                                        {{--                                                        </div>--}}


                                                        {{-- meta_title ------------------------------------------------------------------------------------- --}}
                                                        {{--                                                        <div class="row mb-3">--}}
                                                        {{--                                                            <label for="example-text-input"--}}
                                                        {{--                                                                   class="col-sm-2 col-form-label">{{ trans('occasions.meta_title') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>--}}
                                                        {{--                                                            <div class="col-sm-10">--}}

                                                        {{--                                                                <input class="form-control"--}}
                                                        {{--                                                                          name="{{ $locale }}[meta_title]"--}}
                                                        {{--                                                                value="{{ old($locale . '.meta_title') }} ">--}}


                                                        {{--                                                            </div>--}}
                                                        {{--                                                            @if ($errors->has($locale . '.meta_title'))--}}
                                                        {{--                                                                <span--}}
                                                        {{--                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>--}}
                                                        {{--                                                            @endif--}}
                                                        {{--                                                        </div>--}}


                                                        {{-- meta_desc ------------------------------------------------------------------------------------- --}}
                                                        {{--                                                        <div class="row mb-3">--}}
                                                        {{--                                                            <label for="example-text-input"--}}
                                                        {{--                                                                   class="col-sm-2 col-form-label">{{ trans('occasions.meta_desc') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>--}}
                                                        {{--                                                            <div class="col-sm-10">--}}

                                                        {{--                                                                <textarea class="form-control" id="meta_description{{$key}}"--}}
                                                        {{--                                                                          name="{{ $locale }}[meta_desc]">--}}
                                                        {{--                                                                {{ old($locale . '.meta_desc') }}--}}
                                                        {{--                                                                </textarea>--}}


                                                        {{--                                                                <script type="text/javascript">--}}
                                                        {{--                                                                    CKEDITOR.replace('meta_description{{ $key }}', {--}}
                                                        {{--                                                                        filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"--}}
                                                        {{--                                                                        , filebrowserUploadMethod: 'form'--}}
                                                        {{--                                                                    });--}}

                                                        {{--                                                                </script>--}}


                                                        {{--                                                            </div>--}}
                                                        {{--                                                            @if ($errors->has($locale . '.meta_desc'))--}}
                                                        {{--                                                                <span--}}
                                                        {{--                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_desc') }}</span>--}}
                                                        {{--                                                            @endif--}}
                                                        {{--                                                        </div>--}}


                                                        {{--                                                        --}}{{-- meta_key ------------------------------------------------------------------------------------- --}}
                                                        {{--                                                        <div class="row mb-3">--}}
                                                        {{--                                                            <label for="example-text-input"--}}
                                                        {{--                                                                   class="col-sm-2 col-form-label">{{ trans('occasions.meta_key') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>--}}
                                                        {{--                                                            <div class="col-sm-10">--}}

                                                        {{--                                                                <textarea class="form-control"--}}
                                                        {{--                                                                          name="{{ $locale }}[meta_key]">--}}
                                                        {{--                                                                {{ old($locale . '.meta_key') }}--}}
                                                        {{--                                                                </textarea>--}}

                                                        {{--                                                            </div>--}}
                                                        {{--                                                            @if ($errors->has($locale . '.meta_key'))--}}
                                                        {{--                                                                <span--}}
                                                        {{--                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>--}}
                                                        {{--                                                            @endif--}}
                                                        {{--                                                        </div>--}}


                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    @endforeach


                                    @if(request()->occ_type == "services")
                                        <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample_image">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingImage">
                                                    <button class="accordion-button fw-medium" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseImage"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                        @lang('admin.update_gallerys')
                                                    </button>
                                                </h2>
                                                <div id="collapseImage" class="accordion-collapse collapse show mt-3"
                                                     aria-labelledby="headingImage"
                                                     data-bs-parent="#accordionExample_image">
                                                    <div class="accordion-body">
                                                        <div class="row mb-3">
                                                            @foreach(config('translatable.locales') as $lang)
                                                                <div class="mb-3 col-sm-2 col-form-label">  <label >@lang('admin.group_title_' . $lang)</label> </div>
                                                                <div class="mb-3 col-sm-10 "> <input class="form-control" type="text" value="" name="gallery[{{$lang}}][title]" > </div>
                                                            @endforeach


                                                            <div id="images_section"></div>
                                                            <button type="button"
                                                                    class="btn btn-success form-control mt-3"
                                                                    id="add_images_section">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endif
                                </div>


                                <div class="col-md-4">

                                    <div class="accordion mt-4 mb-4" id="accordionExample1">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingtwo">
                                                <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                        aria-expanded="true"
                                                        aria-controls="collapseTwo">
                                                    {{ trans('admin.settings') }}
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse show"
                                                 aria-labelledby="headingtwo" data-bs-parent="#accordionExample1">
                                                <div class="accordion-body">

                                                    
                                            {{-- image ------------------------------------------------------------------------------------- --}}

                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label for="example-number-input"> @lang('admin.image'):</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="file" name="image">
                                                    </div>
                                                </div>
                                                @if ($errors->has('image'))
                                                    <span class="missiong-spam">{{ $errors->first('image') }}</span>
                                                @endif
                                            </div>


                                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                               class="col-sm-2 col-form-label">{{ trans('occasions.sort')  }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="number"
                                                                   name="sort"
                                                                   value="{{ old( 'sort') }}">
                                                        </div>
                                                        @if ($errors->has($locale . '.sort'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first($locale . '.sort') }}</span>
                                                        @endif
                                                    </div>
                                                    {{-- type ------------------------------------------------------------------------------------- --}}


                                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label"
                                                               for="available">{{ trans('admin.feature') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch" name="featured"
                                                                   type="checkbox" id="switch1" switch="success"
                                                                   {{ old('featured') == 1 ? 'checked' : '' }} value="1">
                                                            <label class="form-label" for="switch1"
                                                                   data-on-label=" @lang('admin.yes') "
                                                                   data-off-label=" @lang('admin.no')"></label>
                                                        </div>
                                                    </div>
                                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label"
                                                               for="available">{{ trans('admin.status') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch" name="status"
                                                                   type="checkbox" id="switch3" switch="success"
                                                                   {{old('status') == 1 ? 'checked' : '' }} value="1">
                                                            <label class="form-label" for="switch3"
                                                                   data-on-label=" @lang('admin.yes') "
                                                                   data-off-label=" @lang('admin.no')"></label>
                                                        </div>
                                                    </div>

                                                    <br>

                                                    {{-- type ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3 d-none">
                                                        <label for="example-text-input"
                                                               class="col-sm-2 col-form-label">{{ trans('admin.type')  }}</label>
                                                        <div class="col-sm-10">
                                                            <div class="col-sm-10">
                                                                <select class="form-control " name="type"
                                                                >
                                                                    @if(request()->occ_type == "products")
                                                                        <option
                                                                            value="0"> @lang('admin.product')</option>
                                                                    @elseif(request()->occ_type == "services")
                                                                        <option
                                                                            value="1">  @lang('admin.service_category') </option>
                                                                    @else
                                                                        <option
                                                                            value="0"> @lang('admin.product')</option>
                                                                        <option
                                                                            value="1">  @lang('admin.service_category') </option>

                                                                    @endif


                                                                </select>
                                                            </div>
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
                                        <a
                                            @if(request()->occ_type == "products" )
                                            href="{{ route('admin.occasions_products_index.index') }}"
                                            @elseif(request()->occ_type == "services")
                                            href="{{ route('admin.occasions_services_index.index') }}"
                                            @else
                                            href="{{ route('admin.occasions.index') }}"
                                            @endif
                                            class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                        <button type="submit"
                                                class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
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
        $(document).ready(function () {
            $('#add_images_section').on('click', function () {

                $('#images_section').append(
                    `
                    <div class="images ">
                        <div class="row">
                            <div class="col-12">
                                    <label for="example-number-input"  > @lang("admin.image"):</label>
                                <input type="file" name="gallery_image[]"   class="form-control" required>
                            </div>
                            <div class="col-3">
                                <label for="example-number-input"  > @lang("admin.sort"):</label>
                                <input type="number" name="gallery_sort[]"  required value="0"   class="form-control"  >
                            </div>

                    <div class="col-3">
                        <label for="example-number-input"  > @lang("admin.feature"):</label>
                                <select  name="gallery_feature[]"  class="form-control"  >
                                       <option value="1">{{__("admin.yes")}}</option>
                                       <option value="0">{{__("admin.no")}}</option>
                                </select>
                            </div>

                            <div class="col-12 mt-3">
                                <button class="btn btn-danger delete_img form-control"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        <hr>
                    </div>
                    `
                )

            });

            {{--$('#add_images_section').on('click', function () {--}}
            {{--    $('#images_section').append(--}}
            {{--        `--}}
            {{--        <div class="images ">--}}
            {{--            <div class="row">--}}
            {{--                <div class="col-12">--}}
            {{--                        <label for="example-number-input"  > @lang("admin.image"):</label>--}}
            {{--                    <input type="file" name="gallery[][image]"   class="form-control" required>--}}
            {{--                </div>--}}
            {{--                <div class="col-6">--}}
            {{--                    <label for="example-number-input"  > @lang("admin.sort"):</label>--}}
            {{--                    <input type="number" name="gallery[][sort]"  class="form-control"  >--}}
            {{--                </div>--}}
            {{--                <div class="col-12 mt-3">--}}
            {{--                    <button class="btn btn-danger delete_img form-control"><i class="fa fa-trash"></i></button>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--            <hr>--}}
            {{--        </div>--}}
            {{--        `--}}
            {{--    )--}}

            {{--});--}}


            $('#images_section').on('click', '.delete_img', function (e) {
                $(this).parent().parent().parent().remove();
            })
        });
    </script>


@endsection
