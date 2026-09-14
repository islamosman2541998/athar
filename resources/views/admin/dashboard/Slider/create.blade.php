@extends('admin.app')

@section('title', trans('slider.slider_create'))
@section('title_page', trans('slider.slider_create'))

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.slider.index') }}"
                                class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('admin.slider.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-9">
                                        @foreach ($languages as $key => $locale)
                                            <div class="accordion mt-4 mb-4" id="accordionExample">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                        <button class="accordion-button fw-medium" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne{{ $key }}"
                                                            aria-expanded="true"
                                                            aria-controls="collapseOne{{ $key }}">
                                                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
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
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text"
                                                                        name="{{ $locale }}[title]"
                                                                        value="{{ old($locale . '.title') }}"
                                                                        id="title{{ $key }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- <div class="row mb-3 slug-section">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>

                                                                <div class="col-sm-10">
                                                                    <input type="text" id="slug{{ $key }}"
                                                                        name="{{ $locale }}[slug]"
                                                                        value="{{ old($locale . '.slug') }}"
                                                                        class="form-control slug" >
                                                                    @if ($errors->has($locale . '.slug'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @include('admin.layouts.scriptSlug') --}}


                                                            {{-- Start Slug --}}


                                                            {{-- description ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea id="description{{ $key }}" name="{{ $locale }}[description]" class="form-control"
                                                                        rows="4"> {{ old($locale . '.description') }} </textarea>
                                                                    @if ($errors->has($locale . '.description'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                                    @endif
                                                                </div>

                                                                {{-- <script type="text/javascript">
                                                                    $(function() {
                                                                        CKEDITOR.replace('description{{ $key }}');
                                                                        $('.textarea').wysihtml5()
                                                                    })
                                                                </script> --}}

                                                                <script type="text/javascript">
                                                                    CKEDITOR.replace('description{{ $key }}', {
                                                                        filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                        filebrowserUploadMethod: 'form'
                                                                    });
                                                                </script>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>


                                    <div class="col-md-3">

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
                                                        {{-- image ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('admin.image'):</label>
                                                                <div class="col-sm-12">
                                                                    <span class="text-danger">@lang('admin.image_site', ['width' => '1600px', 'height' => '900px'])</span>
                                                                    <input class="form-control" type="file"
                                                                        id="example-number-input" name="image"
                                                                        value="{{ old('image') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label class="col-form-label">{{ app()->getLocale() === 'ar' ? 'صورة الموبايل' : 'Mobile image' }}:</label>
                                                                <div class="col-sm-12">
                                                                    <span class="text-muted d-block mb-1">{{ app()->getLocale() === 'ar' ? 'يفضل مقاس رأسي 900 × 1600 بكسل' : 'Portrait 900 × 1600 px recommended' }}</span>
                                                                    <input class="form-control" type="file" name="mobile_image" accept="image/*">
                                                                    @error('mobile_image')<span class="missiong-spam">{{ $message }}</span>@enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- video ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('admin.video'):</label>
                                                                <div class="col-sm-12">
                                                                    {{-- <span class="text-danger">@lang('admin.video_site', ['width' => '1600px', 'height' => '750px'])</span> --}}
                                                                    <input class="form-control" type="file"
                                                                        id="example-number-input" name="video"
                                                                        value="{{ old('video') }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- URL ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('slider.url'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="text"
                                                                        id="example-number-input" name="url"
                                                                        value="{{ old('url') }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- sort ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('slider.sort'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="number"
                                                                        id="example-number-input" name="sort"
                                                                        value="{{ old('sort') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <label class="col-sm-12 col-form-label"
                                                                for="available">{{ trans('admin.status') }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-check form-switch" name="status"
                                                                    type="checkbox" id="switch3" switch="success"
                                                                    checked value="1">
                                                                <label class="form-label" for="switch3"
                                                                    data-on-label=" @lang('admin.yes') "
                                                                    data-off-label=" @lang('admin.yes')"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row mb-3 text-end">
                                        <div>
                                            <a href="{{ route('admin.slider.index') }}"
                                                class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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
        </div> <!-- end row-->

    </div> <!-- container-fluid -->

@endsection


@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
     <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#name_ar").on('keyup', function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g, '-');
                $("#slug_ar").val(Text);
            });


            $("#name_en").on('keyup', function() {
                var Text = $(this).val();
                Text = Text.toLowerCase();
                Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g, '-');
                $("#slug_en").val(Text);
            });
        });
    </script>
@endsection
