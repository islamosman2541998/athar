@extends('admin.app')

@section('title', trans('occasions.edit'))
@section('title_page', trans('occasions.edit', ['name' => $occasion->trans ?  @$occasion->trans->where('locale', $current_lang)->first()->title : '']) )

@section('content')

    <div class="container-fluid">

        <div class="row">
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
                            <form class="row" method="post" action="{{route('admin.occasions.update' , $occasion->id)}}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')




                                {{--                                title and description--}}
                                <div class="col-md-8">
                                    @foreach ($languages as $key => $locale)
                                        @php   $trans = $occasion->trans()->where('locale' , $locale)->first()  @endphp
                                        @if( $trans )

                                            <div class="accordion mt-4 mb-4" id="accordionExample">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                        <button class="accordion-button fw-medium" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapseOne{{ $key }}"
                                                                aria-expanded="true"
                                                                aria-controls="collapseOne{{ $key }}">
                                                            {{ trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne{{ $key }}"
                                                         class="accordion-collapse collapse show mt-3"
                                                         aria-labelledby="headingOne{{ $key }}"
                                                         data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">


                                                            {{-- title ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('admin.title_in') .   trans('lang.' .Locale::getDisplayName($locale))}}</label>
                                                                <div class="col-sm-10">
                                                                    {{--                                                        <input class="form-control" type="text" name="{{ $locale }}[title]"   value="{{ @$occasion->trans->where('locale',$locale)->first()->title}}" id="title{{ $key }}">--}}
                                                                    <input class="form-control" type="text"
                                                                           name="{{ $locale }}[title]"
                                                                           value="{{ $trans->title}}"
                                                                           id="title{{ $key }}">
                                                                </div>
                                                                @if($errors->has( $locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first( $locale . '.title') }}</span>
                                                                @endif
                                                            </div>


                                                            {{-- description ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea id="description{{ $key }}"
                                                                              name="{{ $locale }}[description]">  {{$trans->description ??   old($locale . '.description')}} </textarea>
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


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else

                                            <div class="accordion mt-4 mb-4" id="accordionExample">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                        <button class="accordion-button fw-medium" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapseOne{{ $key }}"
                                                                aria-expanded="true"
                                                                aria-controls="collapseOne{{ $key }}">
                                                            {{ trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne{{ $key }}"
                                                         class="accordion-collapse collapse show mt-3"
                                                         aria-labelledby="headingOne{{ $key }}"
                                                         data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">


                                                            {{-- title ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('admin.title_in') .   trans('lang.' .Locale::getDisplayName($locale))}}</label>
                                                                <div class="col-sm-10">
                                                                    {{--                                                        <input class="form-control" type="text" name="{{ $locale }}[title]"   value="{{ @$occasion->trans->where('locale',$locale)->first()->title}}" id="title{{ $key }}">--}}
                                                                    <input class="form-control" type="text"
                                                                           name="{{ $locale }}[title]"
                                                                           value=" "
                                                                           id="title{{ $key }}">
                                                                </div>
                                                                @if($errors->has( $locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first( $locale . '.title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- description ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea id="description{{ $key }}"
                                                                              name="{{ $locale }}[description]">  {{ old($locale . '.description')}}  </textarea> //here
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


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endif
                                    @endforeach


                                        @if(request()->occ_type === "services")
                                        <div class="accordion mt-4 mb-4 bg-success" id="accordionExample_occ">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingTwo_occ">
                                                <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseTwo_occ" aria-expanded="true"
                                                        aria-controls="collapseTwo_occ">
                                                    @lang('admin.galleries')

                                                </button>
                                            </h2>
                                            <div id="collapseTwo_occ"
                                                 class="accordion-collapse collapse show mt-3"
                                                 aria-labelledby="headingTwo_occ"
                                                 data-bs-parent="#accordionExample_occ">
                                                <div class="accordion-body">


                                                    <!----------start -------------------->


                                                    @foreach($occasion->galleryGroup as $group)
                                                        <h4> {{$group?->transNow?->title}}</h4>

                                                        <div class="row">
                                                            @foreach($group->images as $img)

                                                                <div class="col-2">
                                                                    <img width="100" height="100"
                                                                         src="{{asset($img->pathInView('occasions'))}}">

                                                                    <small> @lang('products.sort')
                                                                        : {{$img->sort}} </small>
                                                                    <br>

                                                                    <a class="btn btn-outline-danger btn-sm"
                                                                       href="{{\LaravelLocalization::localizeURL(route('admin.products.destroy_product_gallery_image' , $img->id))}}">
                                                                        <i class="fa fa-trash"></i></a> <br>

                                                                </div>


                                                            @endforeach
                                                        </div>
                                                        <br>
                                                        <br>

                                                    <a class="btn btn-outline-primary" href="{{url( app()->getLocale() . '/admin/occasion_group_gallerys/' .$occasion->id. '/' . $group->id . "/edit")}}">{{__('admin.edit_album')}}</a>
                                                        <a class="btn btn-outline-danger" href="{{route('admin.delete_album' , $group->id)}}">{{__('admin.delete_album')}}</a>

                                                        <br>
                                                        <br>

                                                        <hr>

                                                        <br>
                                                        <br>
{{--                                                        <br>--}}


                                                @endforeach


                                                <!------------end --------------->


                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- images Gellary  --}}

                                        <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample_image">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingImage">
                                                    <button class="accordion-button fw-medium" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseImage"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                        @lang('admin.add_new_album')
                                                    </button>
                                                </h2>
                                                <div id="collapseImage" class="accordion-collapse collapse show mt-3"
                                                     aria-labelledby="headingImage"
                                                     data-bs-parent="#accordionExample_image">
                                                    <div class="accordion-body">
                                                        <div class="row mb-3">
                                                            {{--                                                            <label>@lang('admin.group_title_ar')</label>--}}
                                                            {{--                                                            <input type="text" value="{{$occasion->galleryGroup ? $occasion->galleryGroup->title : ''}}" name="group_title" >--}}
                                                            {{--                                                            <label>@lang('admin.group_title_en')</label>--}}
                                                            {{--                                                            <input type="text"  value="{{$occasion->galleryGroup ? $occasion->galleryGroup->title_en : ''}}" name="group_title_en" >--}}
                                                            @foreach(config('translatable.locales')   as $lang)

                                                                {{--                                                                @if($occasion->galleryGroup?->translate($lang)   && $occasion->galleryGroup?->translate($lang) ->id)--}}
                                                                {{--                                                                    <input class="d-none" type="text"--}}
                                                                {{--                                                                           value="{{$occasion->galleryGroup->translate($lang) ->id  }}"--}}
                                                                {{--                                                                           name="gallery[id]">--}}
                                                                {{--                                                                @endif--}}

                                                                <div class=" mb-3 col-sm-2 col-form-label">
                                                                    <label>@lang('admin.group_title_' . $lang)</label>
                                                                </div>

                                                                <div class=" mb-3 col-sm-10 ">
                                                                    <input type="text"
                                                                           class="form-control"
                                                                           value=""
                                                                           name="gallery[{{ $lang }}][title]">
                                                                </div>

                                                            @endforeach

                                                            <div id="images_section"></div>
                                                            <input type="hidden"
                                                                   class="form-control"
                                                                   value="0"
                                                                   name="gallery[type]">



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


                                {{--                                other info--}}
                                <div class="col-md-4">
                                    <div class="accordion mt-4 mb-4" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                    {{ trans('admin.settings') }}
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show"
                                                 aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">


                                                    @if(request()->occ_type  !== "services")

                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <div class="col-sm-12">
                                                                <a href="{{ $occasion->pathInView() }}" target="_blank">
                                                                    <img src="{{ $occasion->pathInView() }}" alt=""
                                                                         style="width:100%">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>




                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label for="example-number-input"
                                                                   class='col-sm-4 col-form-label'>
                                                                @lang('products.main_image'):</label>
                                                            <div class="col-sm-8">
                                                                <input class="form-control" type="file"
                                                                       placeholder="@lang('products.main_image'):"
                                                                       id="example-number-input"
                                                                       name="image" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif


                                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label for="example-number-address"
                                                                   class="col-sm-4 col-form-label">
                                                                @lang('admin.sort')</label>
                                                            <div class="col-sm-8">
                                                                <input class="form-control" type="number"
                                                                       placeholder="@lang('admin.sort')"
                                                                       name="sort" value="{{ $occasion->sort }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-4 col-form-label"
                                                               for="available">{{ trans('admin.feature') }}</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-check form-switch" name="featured"
                                                                   type="checkbox" id="switch1" switch="success"
                                                                   {{ $occasion->featured == 1 ? 'checked' : '' }} value="1">
                                                            <label class="form-label" for="switch1"
                                                                   data-on-label=" @lang('admin.yes') "
                                                                   data-off-label=" @lang('admin.no')"></label>
                                                        </div>
                                                    </div>
                                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-4 col-form-label"
                                                               for="available">{{ trans('admin.status') }}</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-check form-switch" name="status"
                                                                   type="checkbox" id="switch3" switch="success"
                                                                   {{ $occasion->status == 1 ? 'checked' : '' }} value="1">
                                                            <label class="form-label" for="switch3"
                                                                   data-on-label=" @lang('admin.yes') "
                                                                   data-off-label=" @lang('admin.no')"></label>
                                                        </div>
                                                    </div>


                                                    {{--                                                    --}}{{-- type ------------------------------------------------------------------------------------- --}}
                                                    {{--                                                    <div class="col-12">--}}
                                                    {{--                                                        <label class="col-sm-12 col-form-label"--}}
                                                    {{--                                                               for="available">{{ trans('admin.type') }}</label>--}}
                                                    {{--                                                        <div class="col-sm-10">--}}
                                                    {{--                                                            <select class="form-control " name="type"--}}
                                                    {{--                                                            >--}}
                                                    {{--                                                                <option   value=""> @lang('admin.product')</option>--}}
                                                    {{--                                                                <option  {{ $occasion->type == 1 ? 'checked' : '' }}    value="1">  @lang('admin.service_category') </option>--}}


                                                    {{--                                                            </select>--}}

                                                    {{--                                                        </div>--}}
                                                    {{--                                                    </div>--}}
                                                    <br>
                                                    {{-- type ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3 d-none">
                                                        <label for="example-text-input"
                                                               class="col-sm-2 col-form-label">{{ trans('admin.type')  }}</label>
                                                        <div class="col-sm-10">
                                                            <div class="col-sm-10">
                                                                <select class="form-control " disabled
                                                                >
                                                                    <option value=""> @lang('admin.product')</option>
                                                                    <option
                                                                        {{ $occasion->type == 1 ? 'selected' : '' }}    value="1">  @lang('admin.service_category') </option>


                                                                </select>
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
                                        <button type="submit"
                                                class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.submit')</button>

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
                                <input type="number" name="gallery_sort[]" required value="0" class="form-control"  >
                            </div>


                            {{--                            <div class="col-3">--}}
                    {{--    <label for="example-number-input"  > @lang("admin.image_title_ar"):</label>--}}
                    {{--    <input type="number" name="gallery_title[]"  class="form-control"  >--}}
                    {{--</div>--}}


                    {{--<div class="col-3">--}}
                    {{--  <label for="example-number-input"  > @lang("admin.image_title_en"):</label>--}}
                    {{--  <input type="text" name="gallery_title_en[]"  class="form-control"  >--}}
                    {{--  </div>--}}


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


            $('#images_section').on('click', '.delete_img', function (e) {
                $(this).parent().parent().parent().remove();
            })
        });
    </script>

    {{--    <script>--}}
    {{--        --}}{{--$(document).ready(function () {--}}
    {{--        --}}{{--    $('#add_images_section').on('click', function () {--}}
    {{--        --}}
    {{--        --}}{{--        $('#images_section').append(--}}
    {{--        --}}{{--            `--}}
    {{--        --}}{{--            <div class="images ">--}}
    {{--        --}}{{--                <div class="row">--}}
    {{--        --}}{{--                    <div class="col-12">--}}
    {{--        --}}{{--                            <label for="example-number-input"  > @lang("admin.image"):</label>--}}
    {{--        --}}{{--                        <input type="file" name="gallery_image[]"   class="form-control" required>--}}
    {{--        --}}{{--                    </div>--}}
    {{--        --}}{{--                    <div class="col-3">--}}
    {{--        --}}{{--                        <label for="example-number-input"  > @lang("admin.sort"):</label>--}}
    {{--        --}}{{--                        <input type="number" name="gallery_sort[]"  class="form-control"  >--}}
    {{--        --}}{{--                    </div>--}}
    {{--        --}}{{--                                                <div class="col-3">--}}
    {{--        --}}{{--                        <label for="example-number-input"  > @lang("admin.image_title"):</label>--}}
    {{--        --}}{{--                        <input type="number" name="gallery_title[]"  class="form-control"  >--}}
    {{--        --}}{{--                    </div>--}}
    {{--        --}}
    {{--        --}}{{--                      <div class="col-3">--}}
    {{--        --}}{{--                        <label for="example-number-input"  > @lang("admin.feature"):</label>--}}
    {{--        --}}{{--                        <input type="number" name="gallery_feature[]"  class="form-control"  >--}}
    {{--        --}}{{--                    </div>--}}
    {{--        --}}
    {{--        --}}{{--                    <div class="col-12 mt-3">--}}
    {{--        --}}{{--                        <button class="btn btn-danger delete_img form-control"><i class="fa fa-trash"></i></button>--}}
    {{--        --}}{{--                    </div>--}}
    {{--        --}}{{--                </div>--}}
    {{--        --}}{{--                <hr>--}}
    {{--        --}}{{--            </div>--}}
    {{--        --}}{{--            `--}}
    {{--        --}}{{--        )--}}
    {{--        --}}
    {{--        --}}{{--    });--}}
    {{--        --}}
    {{--        --}}
    {{--        --}}{{--    $('#images_section').on('click', '.delete_img', function (e) {--}}
    {{--        --}}{{--        $(this).parent().parent().parent().remove();--}}
    {{--        --}}{{--    })--}}
    {{--        --}}{{--});--}}
    {{--    </script>--}}


@endsection
