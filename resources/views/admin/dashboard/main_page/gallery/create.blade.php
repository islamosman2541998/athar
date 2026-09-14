@extends('admin.app')

@section('title', trans('admin.create_main_page_gallery'))
@section('title_page', trans('admin.create_main_page_gallery'))

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 m-3">
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.main_page_gallery.index') }}"
                           class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.main_page_gallery.store') }}" method="post" enctype="multipart/form-data">
                            @csrf


                            <div class="row">
                                <div class="col-md-8">

                                    <hr>








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



                                {{-- Butoooons ------------------------------------------------------------------------- --}}
                                <div class="row mb-3 text-end">
                                    <div>
                                        <a href="{{ route('admin.main_page_gallery.index') }}"
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
                                <input type="number" required name="gallery_sort[]"  class="form-control"  >
                            </div>
                            {{--                            <div class="col-3">--}}
                            {{--    <label for="example-number-input"  > @lang("admin.image_title_ar"):</label>--}}
                            {{--    <input type="text" name="gallery_title[]"  class="form-control"  >--}}
                            {{--</div>--}}

                              {{--<div class="col-3">--}}
                              {{--  <label for="example-number-input"  > @lang("admin.image_title_en"):</label>--}}
                              {{--  <input type="text" name="gallery_title_en[]"  class="form-control"  >--}}
                              {{--  </div>--}}



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
