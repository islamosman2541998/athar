@extends('admin.app')

@section('title', trans('admin.payment-methods'))
@section('title_page', trans('admin.payment-methods_create'))

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.payment-methods.index') }}"
                                class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('admin.payment-methods.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        @foreach ($languages as $key => $locale)
                                            <div class="accordion mt-4 mb-4" id="accordionExample">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                        <button class="accordion-button fw-medium" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne{{ $key }}"
                                                            aria-expanded="true"
                                                            aria-controls="collapseOne{{ $key }}">
                                                            {{ trans('lang.' .Locale::getDisplayName($locale))   }}
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
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text"
                                                                        name="{{ $locale }}[title]"
                                                                        value="{{ old($locale . '.title') }}"
                                                                        id="title{{ $key }}">
                                                                        @if ($errors->has($locale . '.title'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                    @endif
                                                                </div>

                                                            </div>

                                                            {{-- description ------------------------------------------------------------------------------------- --}}
                                                            {{-- Start description --}}
                                                            <div class="row mb-3 slug-section">

                                                                <div class="row mt-3">
                                                                    <label for="example-text-input"
                                                                        class="col-sm-2 col-form-label">
                                                                        {{ trans('admin.content_in') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                                                    <div class="col-sm-10 mb-2">
                                                                        <textarea id="content{{ $key }}" name="{{ $locale }}[description]" class="m-auto form-control "
                                                                            style="margin-top: 10px">  {{ old($locale . '.description') }} </textarea>
                                                                        @if ($errors->has($locale . '.description'))
                                                                            <span
                                                                                class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                                        @endif
                                                                    </div>


                                                                    <script type="text/javascript">
                                                                        CKEDITOR.replace('content{{ $key }}', {
                                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                            filebrowserUploadMethod: 'form'
                                                                        });
                                                                    </script>

                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
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

                                                        {{-- logo_image ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input"
                                                                       class="col-sm-12 col-form-label"l>
                                                                    @lang('admin.logo') : </label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="file"
                                                                           placeholder="@lang('admin.logo'):"
                                                                           id="example-number-input" name="logo"
                                                                           value="{{ old('logo') }}">
                                                                </div>
                                                            </div>
                                                        </div>



                                                        {{-- qr_image ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input"
                                                                    class="col-sm-12 col-form-label"l>
                                                                    @lang('admin.qr_image') : </label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="file"
                                                                        placeholder="@lang('admin.qr_image'):"
                                                                        id="example-number-input" name="qr_image"
                                                                        value="{{ old('qr_image') }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- unique name ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <label class="col-sm-12 col-form-label"
                                                                   for="unique_name">{{ trans('admin.unique_name') }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-check form-switch" name="unique_name"
                                                                       type="text" id="unique_name"
                                                                       value="">

                                                            </div>
                                                        </div>


                                                        {{--   user_name   ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <label class="col-sm-12 col-form-label"
                                                                   for="user_name">{{ trans('admin.user_name') }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-check form-switch" name="user_name"
                                                                       type="text"   id="user_name"
                                                                       value="">

                                                            </div>
                                                        </div>

                                                        {{--   number   ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <label class="col-sm-12 col-form-label"
                                                                   for="number">{{ trans('admin.number') }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-check form-switch" name="number"
                                                                       type="text"   id="number"
                                                                       value="">

                                                            </div>
                                                        </div>





                                                        {{--   mininmum price ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <label class="col-sm-12 col-form-label"
                                                                   for="minimum_price">{{ trans('admin.minimum_price') }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-check form-switch" name="minimum_price"
                                                                       type="number" step="any" id="minimum_price"
                                                                       value="">

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
                                        <a href="{{ route('admin.payment-methods.index') }}"
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
    </div> <!-- end row-->

    </div> <!-- container-fluid -->

@endsection


@section('style')
    <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection
