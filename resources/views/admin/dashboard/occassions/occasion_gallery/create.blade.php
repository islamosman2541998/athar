@extends('admin.app')

@section('title', trans('occasion_group_gallerys.create'))
@section('title_page', trans('occasion_group_gallerys.create'))

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 m-3">
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ url('admin/occasion_group_gallerys/' . $occ_id) }}"
                           class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ url('admin/occasion_group_gallerys/'.$occ_id) }}" method="post" enctype="multipart/form-data">
                            @csrf


                            <div class="row">
                                <div class="col-md-12">

                                    @foreach ($languages as $key => $locale)

                                        <div class="accordion mt-4 mb-4 bg-primary" id="accordionExample{{$locale}}">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOne{{$locale}}">

                                                    <button class="accordion-button fw-medium " type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne{{$locale}}"
                                                            aria-expanded="true"
                                                            aria-controls="collapseOne{{$locale}}">
                                                        {{ __('occasion_group_gallerys.' . $locale )  }}
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



                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    @endforeach


                                        <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample_image">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingImage">
                                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseImage" aria-expanded="true" aria-controls="collapseOne">
                                                        @lang('admin.update_gallerys')
                                                    </button>
                                                </h2>
                                                <div id="collapseImage" class="accordion-collapse collapse show mt-3" aria-labelledby="headingImage" data-bs-parent="#accordionExample_image">
                                                    <div class="accordion-body">
                                                        <div class="row mb-3">

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

                                 {{-- Butoooons ------------------------------------------------------------------------- --}}
                                <div class="row mb-3 text-end">
                                    <div>
                                        <a href="{{ url('admin/occasion_group_gallerys/' . $occ_id) }}"
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
                            {{--                            <div class="col-3">--}}
                            {{--    <label for="example-number-input"  > @lang("admin.image_title_ar"):</label>--}}
                            {{--    <input type="number" name="gallery_title[]"  class="form-control"  >--}}
                            {{--</div>--}}


                              {{--<div class="col-3">--}}
                              {{--  <label for="example-number-input"  > @lang("admin.image_title_en"):</label>--}}
                              {{--  <input type="text" name="gallery_title_en[]"  class="form-control"  >--}}
                              {{--  </div>--}}


                            {{--  <div class="col-3">--}}
                            {{--    <label for="example-number-input"  > @lang("admin.feature"):</label>--}}
                            {{--    <input type="number" name="gallery_feature[]"  class="form-control"   >--}}
                            {{--</div>--}}

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
