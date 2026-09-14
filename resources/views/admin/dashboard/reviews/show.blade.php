@extends('admin.app')

@section('title', trans('reviews.show_reviews'))
@section('title_page', trans('reviews.show', ['name' => @$review->customer_name]) )

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="row">
            <div class="col-12 m-3">
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="accordion mt-4 mb-4" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                        aria-expanded="true" aria-controls="collapseOne">

                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show mt-3"
                                                 aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">


                                                    {{-- customer_name ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                               class="col-sm-2 col-form-label">{{ trans('admin.customer_name')   }}</label>
                                                        <div class="col-sm-10">
                                                            <input disabled class="form-control" type="text"

                                                                   value="{{ @$review->customer_name }}"
                                                                   id="customer_name">
                                                        </div>
                                                     </div>

                                                    {{-- slug ------------------------------------------------------------------------------------- --}}
                                                    {{-- Start Slug --}}
                                                    <div class="row mb-3 slug-section">

                                                        <label for="example-text-input"
                                                               class="col-sm-2 col-form-label">{{ trans('admin.slug_in')  }}
                                                        </label>

                                                        {{-- description ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                   class="col-sm-2 col-form-label"> @lang('admin.description_in')

                                                            </label>
                                                            <div class="col-sm-10 mb-2">
                                                                    <textarea id="description" disabled
                                                                            > {{ @$review->description }} </textarea>


                                                            </div>

                                                            <script type="text/javascript">
                                                                CKEDITOR.replace('description', {
                                                                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                    , filebrowserUploadMethod: 'form'
                                                                });

                                                            </script>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>


                                <div class="col-md-4">

                                    <div class="accordion mt-4 mb-4" id="accordionExample2">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOne2">
                                                <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseOne2"
                                                        aria-expanded="true" aria-controls="collapseOne2">
                                                    {{ trans('admin.settings') }}
                                                </button>
                                            </h2>
                                            <div id="collapseOne2" class="accordion-collapse collapse show"
                                                 aria-labelledby="headingOne2" data-bs-parent="#accordionExample2">
                                                <div class="accordion-body">
                                                    <div class="col-sm-10 mb-3">
                                                        {{--                                                            @if ($review->image != null)--}}
                                                        <img src="{{ asset($review->pathInView()) }}" alt=""
                                                             style="width:100%">
                                                        {{--                                                            @endif--}}
                                                    </div>
                                                      {{-- feature ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label"
                                                               for="available">{{ trans('admin.feature') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch"
                                                                   type="checkbox" id="switch1" switch="success" disabled
                                                                   {{ @$review->feature == 1 ? 'checked' : '' }} value="1">
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
                                                            <input class="form-check form-switch"  disabled
                                                                   type="checkbox" id="switch3" switch="success"
                                                                   {{ @$review->status == 1 ? 'checked' : '' }} value="1">
                                                            <label class="form-label" for="switch3"
                                                                   data-on-label=" @lang('admin.yes') "
                                                                   data-off-label=" @lang('admin.no')"></label>
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
                                    <a href="{{ route('admin.reviews.index') }}"
                                       class="btn btn-outline-danger waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
{{--                                    <button type="submit"--}}
{{--                                            class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>--}}
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
@endsection
