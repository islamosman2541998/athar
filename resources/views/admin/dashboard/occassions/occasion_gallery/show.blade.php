@extends('admin.app')

@section('title', trans('group_gallerys.edit'))
@section('title_page', trans('group_gallerys.edit', ['name' =>    @$group_gallery->transNow->title  ?? '']) )

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ url('admin/occasion_group_gallerys' .'/' . $occ_id ) }}"
                               class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">




                            @if($group_gallery && isset($group_gallery->images) && $group_gallery->images->count() )
                                {{-- images Gellary  --}}
                                <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample_image_old">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingImage2">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseImage2" aria-expanded="true" aria-controls="collapseOne">
                                                @lang('admin.current_gallerys')
                                            </button>
                                        </h2>
                                        <div id="collapseImage2" class="accordion-collapse collapse show mt-3" aria-labelledby="headingImage2" data-bs-parent="#accordionExample_image_old">
                                            <div class="accordion-body">
                                                <div class="row mb-3">

                                                    <div class="d-flex">
                                                        @if($group_gallery->count() && isset($group_gallery->images))
                                                            @forelse($group_gallery->images as $image)
                                                                <div class="col">
                                                                    <img style="width: 100px; height:100px" src="{{$image->pathInView('occasions') }}">
                                                                    <h4>{{$image->title}} </h4>
                                                                    <h4>{{$image->title_ar}} </h4>


                                                                    <h6> @lang('products.sort') : {{$image->sort}} </h6>
                                                                    <h6> @lang('products.feature') : <span class="badge bg-warning">{{$image->feature == 1 ? __('admin.yes') : __('admin.no')}}</span> </h6>
                                                                    <h6> @lang('products.status') : <span class="badge bg-primary"> {{$image->status == 1 ? __('admin.yes') : __('admin.no')}} </span> </h6>


{{--                                                                    <a class="btn btn-danger btn-sm" href="{{\LaravelLocalization::localizeURL(route('admin.products.destroy_product_gallery_image' , $image->id))}}">{{__("admin.delete")}}</a> <br>--}}
                                                                </div>
                                                            @empty
                                                            @endforelse
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            @endif



                            <div class="row">





                                {{--                                title and description--}}
                                <div class="col-md-12">

                                    @foreach ($languages as $key => $locale)

                                        @php   $group = $group_gallery->translations()->where('locale' , $locale)->first()  @endphp

                                        @if( $group )
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
                                                                    {{--                                                        <input class="form-control" type="text" name="{{ $locale }}[title]"   value="{{ @$group_gallery->trans->where('locale',$locale)->first()->title}}" id="title{{ $key }}">--}}
                                                                    <input class="form-control" type="text" disabled
                                                                           name="{{ $locale }}[title]"
                                                                           value="{{ $group->title}}"
                                                                           id="title{{ $key }}">
                                                                </div>
                                                                @if($errors->has( $locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first( $locale . '.title') }}</span>
                                                                @endif
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach





                                </div>


                                <div class="row mb-3 text-end">
                                    <div>
{{--                                        <button type="submit"--}}
{{--                                                class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.submit')</button>--}}

                                        <a href="{{ url('admin/occasion_group_gallerys' .'/'. $occ_id  ) }}"
                                           class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                    </div>
                                </div>
                            </div>


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
                                <input type="number" name="gallery_sort[]"  class="form-control"  >
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
