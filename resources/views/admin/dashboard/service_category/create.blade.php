@extends('admin.app')

@section('title', trans('service_categories.create'))
@section('title_page', trans('service_categories.create'))

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 m-3">
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.service.index') }}"
                           class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.service.store') }}" method="post" enctype="multipart/form-data">
                            @csrf


                            <div class="row">
                                <div class="col-md-8">

                                    <hr>

                                    @foreach ($languages as $key => $locale)

                                        <div class="accordion mt-4 mb-4 bg-primary" id="accordionExample{{$locale}}">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOne{{$locale}}">
                                                    <button class="accordion-button fw-medium " type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne{{$locale}}"
                                                            aria-expanded="true"
                                                            aria-controls="collapseOne{{$locale}}">
                                                        {{ __('service_categories.' . $locale )  }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne{{$locale}}"
                                                     class="accordion-collapse collapse show mt-3"
                                                     aria-labelledby="headingOne{{$locale}}"
                                                     data-bs-parent="#accordionExample{{$locale}}">
                                                    <div class="accordion-body">


                                                        {{-- title slug livewire ------------------------------------------------------------------------------------- --}}
                                                        @livewireStyles
                                                        @livewire('admin.slug.auto-generate-slug-component'  , ['locale' => $locale ])
                                                        @livewireScripts
                                                        {{-- title slug livewire ------------------------------------------------------------------------------------- --}}


                                                        {{-- description ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                   class="col-sm-2 col-form-label">{{ trans('service_categories.description') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <textarea class="form-control"
                                                                          id="description{{ $key }}"
                                                                          name="{{ $locale }}[description]">
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
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                            @endif
                                                        </div>




                                                        <br>
                                                        <br>
                                                        <br>



                                                        <!--------------------------start middle page ------------------------>
                                                        {{-- middle_title ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                   class="col-sm-2 col-form-label">{{ trans('service_categories.middle_title') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <input class="form-control" value="{{ old($locale . '.middle_title') }}" name="{{ $locale }}[middle_title]" >
                                                            </div>
                                                            @if ($errors->has($locale . '.middle_title'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.middle_title') }}</span>
                                                            @endif
                                                        </div>


                                                        {{-- middle_content ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                   class="col-sm-2 col-form-label">{{ trans('service_categories.middle_content') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <textarea class="form-control"
                                                                          id="middle_content{{ $key }}"
                                                                          name="{{ $locale }}[middle_content]">
                                                                {{ old($locale . '.middle_content') }}
                                                                </textarea>


                                                                <script type="text/javascript">
                                                                    CKEDITOR.replace('middle_content{{ $key }}', {
                                                                        filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                        , filebrowserUploadMethod: 'form'
                                                                    });

                                                                </script>


                                                            </div>
                                                            @if ($errors->has($locale . '.middle_content'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.middle_content') }}</span>
                                                            @endif
                                                        </div>
                                                        <!----------end middle page ------------------------------------------>


                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    @endforeach






                                <!-----start test ------>
                                    <div class="accordion mt-4 mb-4 bg-primary" id="accordionExampleSlugs">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOneSlugs">
                                                <button class="accordion-button fw-medium " type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOneSlugs"
                                                        aria-expanded="true"
                                                        aria-controls="collapseOneSlugs">
                                                    {{ __('service_categories.meta_info'  )  }}
                                                </button>
                                            </h2>
                                            <div id="collapseOneSlugs"
                                                 class="accordion-collapse collapse show mt-3"
                                                 aria-labelledby="headingOneSlugs"
                                                 data-bs-parent="#accordionExampleSlugs">
                                                <div class="accordion-body">

                                                    @foreach ($languages as $key => $locale)


                                                        {{-- meta_title ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                   class="col-sm-2 col-form-label">{{ trans('service_categories.meta_title') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <input class="form-control"
                                                                       name="{{ $locale }}[meta_title]"
                                                                       value="{{ old($locale . '.meta_title') }} ">


                                                            </div>
                                                            @if ($errors->has($locale . '.meta_title'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                            @endif
                                                        </div>


                                                        {{-- meta_desc ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                   class="col-sm-2 col-form-label">{{ trans('service_categories.meta_desc') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <textarea class="form-control"
                                                                          id="meta_description{{$key}}"
                                                                          name="{{ $locale }}[meta_desc]">
                                                                {{ old($locale . '.meta_desc') }}
                                                                </textarea>


                                                                <script type="text/javascript">
                                                                    CKEDITOR.replace('meta_description{{ $key }}', {
                                                                        filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                        , filebrowserUploadMethod: 'form'
                                                                    });

                                                                </script>


                                                            </div>
                                                            @if ($errors->has($locale . '.meta_desc'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_desc') }}</span>
                                                            @endif
                                                        </div>


                                                        {{-- meta_key ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                   class="col-sm-2 col-form-label">{{ trans('service_categories.meta_key') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <textarea class="form-control"
                                                                          name="{{ $locale }}[meta_key]">
                                                                {{ old($locale . '.meta_key') }}
                                                                </textarea>

                                                            </div>
                                                            @if ($errors->has($locale . '.meta_key'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
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
                                    <!----------end test ---------->


                                    {{-- images Gellary  --}}
                                    <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingImage">
                                                <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseImage"
                                                        aria-expanded="true"
                                                        aria-controls="collapseOne">
                                                    @lang('admin.gallerys')
                                                </button>
                                            </h2>
                                            <div id="collapseImage"
                                                 class="accordion-collapse collapse show mt-3"
                                                 aria-labelledby="headingImage"
                                                 data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row mb-3">
{{--                                                        <label>@lang('admin.group_title_ar')</label>--}}
{{--                                                        <input type="text" name="group_title" >--}}
{{--                                                        <label>@lang('admin.group_title_en')</label>--}}
{{--                                                        <input type="text" name="group_title_en" >--}}

                                                        @foreach(config('translatable.locales')   as $lang)

                                                            <div class=" mb-3 col-sm-2 col-form-label">
                                                                <label>@lang('admin.group_title_' . $lang)</label>
                                                            </div>

                                                            <div class=" mb-3 col-sm-10 ">
                                                                <input type="text"
                                                                       class="form-control"
                                                                       value=""
                                                                       name="gallery[{{ $lang }}][title]"
                                                                >
                                                            </div>


                                                        @endforeach

                                                        <br>
                                                        <br>
                                                        <br>


                                                        <div id="images_section"></div>
                                                        <button type="button" class="btn btn-success form-control mt-3"
                                                                id="add_images_section">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

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
                                                            <label for="example-number-input" class='col-form-label'>
                                                                @lang('service_categories.main_image'):</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="file"
                                                                       placeholder="@lang('service_categories.main_image'):"
                                                                       id="example-number-input"
                                                                       name="image" value="{{ old('image') }}">
                                                            </div>
                                                        </div>
                                                    </div>

{{--                                                    resources/views/livewire/admin/calculate-after-sale.blade.php--}}
{{--                                                    //here--}}
{{--                                                    @livewireStyles--}}
{{--                                                    @livewire("admin.calculate-after-sale")--}}
{{--                                                    @livewireScripts--}}

                                                    {{-- code ------------------------------------------------------------------------------------- --}}
{{--                                                    <div class="row mb-3">--}}
{{--                                                        <label for="example-text-input"--}}
{{--                                                               class="col-sm-2 col-form-label">{{ trans('service_categories.code')  }}</label>--}}
{{--                                                        <div class="col-sm-10">--}}
{{--                                                            <input class="form-control" type="text"--}}
{{--                                                                   name="code"--}}
{{--                                                                   value="{{ old( 'code') }}">--}}
{{--                                                        </div>--}}
{{--                                                        @if ($errors->has(  'code'))--}}
{{--                                                            <span--}}
{{--                                                                class="missiong-spam">{{ $errors->first($locale . '.code') }}</span>--}}
{{--                                                        @endif--}}
{{--                                                    </div>--}}


                                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                               class="col-sm-2 col-form-label">{{ trans('service_categories.sort')  }}</label>
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



                                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label"
                                                               for="available">{{ trans('admin.feature') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch" name="feature"
                                                                   type="checkbox" id="switch1" switch="success"
                                                                   value="1">
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
                                                                   value="1">
                                                            <label class="form-label" for="switch3"
                                                                   data-on-label=" @lang('admin.yes') "
                                                                   data-off-label=" @lang('admin.no')"></label>
                                                        </div>
                                                    </div>



                                              




{{--                                                    cats--}}
{{--                                                    <div class="row mb-3">--}}
{{--                                                        <label for="example-text-input"--}}
{{--                                                               class="col-sm-2 col-form-label">{{ trans('service_categories.categories')   }}</label>--}}
{{--                                                        <div class="col-sm-10">--}}
{{--                                                            --}}{{--                                                            <input class="form-control" type="number"--}}
{{--                                                            --}}{{--                                                                   name="status"--}}
{{--                                                            --}}{{--                                                                   value="{{old('status')}}">--}}


{{--                                                            <select   class="form-select form-select-sm select2"--}}
{{--                                                                    name="product_category_id">--}}
{{--                                                                --}}{{--                                                                <option value="" selected--}}
{{--                                                                --}}{{--                                                                        disabled> {{ trans('service_categories.occasions') }}</option>--}}

{{--                                                                @forelse($cats as $key2 => $val2)--}}
{{--                                                                    <option--}}
{{--                                                                        value="{{$val2->id}}" {{ old('product_category_id' ) == $val2->id   ? 'selected' : '' }}>--}}
{{--                                                                        {{   isset($val2->trans[0])  ?  $val2->trans[0]->title : ''}}--}}
{{--                                                                    </option>--}}
{{--                                                                @empty--}}
{{--                                                                @endforelse--}}

{{--                                                            </select>--}}

{{--                                                        </div>--}}
{{--                                                        @if ($errors->has('product_category_id'))--}}
{{--                                                            <span--}}
{{--                                                                class="missiong-spam">{{ $errors->first($locale . 'product_category_id') }}</span>--}}
{{--                                                        @endif--}}
{{--                                                    </div>--}}

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                {{-- Butoooons ------------------------------------------------------------------------- --}}
                                <div class="row mb-3 text-end">
                                    <div>
                                        <a href="{{ route('admin.service.index') }}"
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
                                <input type="number" name="gallery_sort[]"  value="0" class="form-control"  >
                            </div>






                              <div class="col-3">
                                <label for="example-number-input"  > @lang("admin.feature"):</label>
                                <input  style="    margin-top: 28px;"  type="checkbox" name="gallery_feature[]"   value="1"    >
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


            $('#images_section').on('click', '.delete_img', function (e) {
                $(this).parent().parent().parent().remove();
            })
        });
    </script>

 @endsection
