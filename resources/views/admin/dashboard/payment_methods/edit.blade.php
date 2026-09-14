@extends('admin.app')

@section('title', trans('admin.payment_methods'))
@section('title_page', trans('payment_methods.edit', ['name' => @$paymentMethod?->transNow?->title ]) )

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a
                                href="{{ route('admin.payment-methods.index') }}"

                                class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm
                                btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('admin.payment-methods.update', $paymentMethod->id)  }}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
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
                                                                           value="{{ @$paymentMethod->trans->where('locale', $locale)->first()->title }}"
                                                                           id="title{{ $key }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- Start Slug --}}
                                                            <div class="row mb-3 slug-section">

                                                                <div class="row mt-3">
                                                                    <label for="example-text-input"
                                                                           class="col-sm-2 col-form-label">
                                                                        {{ trans('admin.content_in') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                                                    <div class="col-sm-10 mb-2">
                                                                        <textarea id="content{{ $key }}" name="{{ $locale }}[description]" class="m-auto form-control "
                                                                                  style="margin-top: 10px">  {{ $paymentMethod->trans->where('locale', $locale)->first()->description   ?? old($locale . '.description') }} </textarea>
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
                                                @endforeach


{{--                                                <div class="accordion mt-4 mb-4" id="accordionExample">--}}
{{--                                                    <div class="accordion-item border rounded">--}}
{{--                                                        <h2 class="accordion-header" id="headingTwo{{ $key }}">--}}
{{--                                                            <button class="accordion-button fw-medium" type="button"--}}
{{--                                                                    data-bs-toggle="collapse"--}}
{{--                                                                    data-bs-target="#collapseTwo{{ $key }}"--}}
{{--                                                                    aria-expanded="true"--}}
{{--                                                                    aria-controls="collapseTwo{{ $key }}">--}}
{{--                                                                @lang('admin.meta')--}}
{{--                                                            </button>--}}
{{--                                                        </h2>--}}
{{--                                                        <div id="collapseTwo{{ $key }}"--}}
{{--                                                             class="accordion-collapse collapse show mt-3"--}}
{{--                                                             aria-labelledby="headingTwo{{ $key }}"--}}
{{--                                                             data-bs-parent="#accordionExample">--}}
{{--                                                            <div class="accordion-body">--}}

{{--                                                                @foreach ($languages as $key => $locale)--}}
{{--                                                                    --}}{{-- meta_title_ ------------------------------------------------------------------------------------- --}}
{{--                                                                    <div class="row mb-3">--}}
{{--                                                                        <label for="example-text-input"--}}
{{--                                                                               class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>--}}
{{--                                                                        <div class="col-sm-10">--}}
{{--                                                                            <input class="form-control" type="text"--}}
{{--                                                                                   name="{{ $locale }}[meta_title]"--}}
{{--                                                                                   value="{{ @$paymentMethod->trans->where('locale', $locale)->first()->meta_title }}"--}}
{{--                                                                                   id="title{{ $key }}">--}}
{{--                                                                        </div>--}}
{{--                                                                        @if ($errors->has($locale . '.meta_title'))--}}
{{--                                                                            <span--}}
{{--                                                                                class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>--}}
{{--                                                                        @endif--}}
{{--                                                                    </div>--}}

{{--                                                                    --}}{{-- meta_description_ ------------------------------------------------------------------------------------- --}}
{{--                                                                    <div class="row mb-3">--}}
{{--                                                                        <label for="example-text-input"--}}
{{--                                                                               class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}--}}
{{--                                                                        </label>--}}
{{--                                                                        <div class="col-sm-10 mb-2">--}}
{{--                                                                            <textarea--}}
{{--                                                                                name="{{ $locale }}[meta_description]"--}}
{{--                                                                                class="form-control description"> {{ @$paymentMethod->trans->where('locale', $locale)->first()->meta_description }} </textarea>--}}
{{--                                                                            @if ($errors->has($locale . '.meta_description'))--}}
{{--                                                                                <span--}}
{{--                                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>--}}
{{--                                                                            @endif--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}

{{--                                                                    --}}{{-- meta_key_ ------------------------------------------------------------------------------------- --}}
{{--                                                                    <div class="row mb-3">--}}
{{--                                                                        <label for="example-text-input"--}}
{{--                                                                               class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}--}}
{{--                                                                        </label>--}}
{{--                                                                        <div class="col-sm-10 mb-2">--}}
{{--                                                                            <textarea name="{{ $locale }}[meta_key]"--}}
{{--                                                                                      class="form-control description"> {{ @$paymentMethod->trans->where('locale', $locale)->first()->meta_key }} </textarea>--}}
{{--                                                                            @if ($errors->has($locale . '.meta_key'))--}}
{{--                                                                                <span--}}
{{--                                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>--}}
{{--                                                                            @endif--}}
{{--                                                                        </div>--}}
{{--                                                                    </div>--}}
{{--                                                                    <hr>--}}
{{--                                                                @endforeach--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                            </div>
                                    </div>


                                </div>


                                <div class="col-md-4">

                                    <div class="accordion mt-4 mb-4" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                        aria-expanded="true"
                                                        aria-controls="collapseOne">
                                                    {{ trans('admin.settings') }}
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show"
                                                 aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="col-md-3 col-sm-12 mb-3  d-inline-block">
                                                        <img src="{{ asset($paymentMethod->path() . $paymentMethod->logo)  }}" alt=""
                                                             style="width:100%">

                                                    </div>
                                                    <div class="col-md-3 col-sm-12 mb-3 d-inline-block">

                                                        <img src="{{ asset($paymentMethod->path() . $paymentMethod->qr_image)  }}" alt=""
                                                             style="width:100%">

                                                    </div>

                                                    {{--                                                    <div class="col-sm-3 mb-3">--}}

{{--                                                        <img src="{{ asset($paymentMethod->path() . $paymentMethod->logo)  }}" alt=""--}}
{{--                                                             style="width:100%">--}}



{{--                                                            <img src="{{ asset($paymentMethod->path() . $paymentMethod->qr_image)  }}" alt=""--}}
{{--                                                                 style="width:100%">--}}


{{--                                                    </div>--}}


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
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="unique_name"
                                                                   type="text" id="unique_name" disabled
                                                                   value="{{$paymentMethod->unique_name ?? old('unique_name')}}"
                                                            >

                                                        </div>
                                                    </div>


                                                    {{--   user_name   ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label"
                                                               for="user_name">{{ trans('admin.user_name') }}</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="user_name"
                                                                   type="text"   id="user_name"
                                                                   value="{{$paymentMethod->user_name ?? old('user_name')}}"
                                                            >

                                                        </div>
                                                    </div>

                                                    {{--   number   ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label"
                                                               for="number">{{ trans('admin.number') }}</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="number"
                                                                   type="text"   id="number"
                                                                   value="{{$paymentMethod->number ?? old('number')}}"
                                                            >

                                                        </div>
                                                    </div>





                                                    {{--   mininmum price ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label"
                                                               for="minimum_price">{{ trans('admin.minimum_price') }}</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" name="minimum_price"
                                                                   type="number" step="any" id="minimum_price"
                                                                   value="{{$paymentMethod->minimum_price ?? old('minimum_price')}}"
                                                            >

                                                        </div>
                                                    </div>




                                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label"
                                                               for="available">{{ trans('admin.status') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch" name="status"
                                                                   type="checkbox"
                                                                   id="switch3" switch="success"
                                                                   {{ @$paymentMethod->status == 'active' ? 'checked' : '' }} value="active">
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
                                {{-- Butoooons ------------------------------------------------------------------------- --}}
                                <div class="row mb-3 text-end">
                                    <div>
                                        {{--                            <a href="{{ route('admin.$paymentMethods.index') }}"--}}
                                        <a
                                             href="{{ route('admin.payment-methods.index') }}"

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
@endsection
