@extends('admin.app')

@section('title', trans('whatsapp_contacts.create'). '  ' .  trans('whatsapp_contacts.whatsapp_contact'))
@section('title_page', trans('whatsapp_contacts.create') . '  ' .  trans('whatsapp_contacts.whatsapp_contact'))

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 m-3">
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.whatsapp-contact.index') }}"
                           class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.whatsapp-contact.store') }}" method="post" enctype="multipart/form-data">
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
                                                        {{ __('products.' . $locale )  }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne{{$locale}}"
                                                     class="accordion-collapse collapse show mt-3"
                                                     aria-labelledby="headingOne{{$locale}}"
                                                     data-bs-parent="#accordionExample{{$locale}}">
                                                    <div class="accordion-body">


                                                        {{-- title slug livewire ------------------------------------------------------------------------------------- --}}
                                                        @livewireStyles
                                                        @livewire('admin.slug.auto-generate-slug-component' , ['locale'
                                                        => $locale ])
                                                        @livewireScripts
                                                        {{-- title slug livewire ------------------------------------------------------------------------------------- --}}


                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    @endforeach






{{--                                <!-----start test ------>--}}
{{--                                    <div class="accordion mt-4 mb-4 bg-primary" id="accordionExampleSlugs">--}}
{{--                                        <div class="accordion-item border rounded">--}}
{{--                                            <h2 class="accordion-header" id="headingOneSlugs">--}}
{{--                                                <button class="accordion-button fw-medium " type="button"--}}
{{--                                                        data-bs-toggle="collapse"--}}
{{--                                                        data-bs-target="#collapseOneSlugs"--}}
{{--                                                        aria-expanded="true"--}}
{{--                                                        aria-controls="collapseOneSlugs">--}}
{{--                                                    {{ __('products.meta_info'  )  }}--}}
{{--                                                </button>--}}
{{--                                            </h2>--}}
{{--                                            <div id="collapseOneSlugs"--}}
{{--                                                 class="accordion-collapse collapse show mt-3"--}}
{{--                                                 aria-labelledby="headingOneSlugs"--}}
{{--                                                 data-bs-parent="#accordionExampleSlugs">--}}
{{--                                                <div class="accordion-body">--}}

{{--                                                    @foreach ($languages as $key => $locale)--}}


{{--                                                        --}}{{-- meta_title ------------------------------------------------------------------------------------- --}}
{{--                                                        <div class="row mb-3">--}}
{{--                                                            <label for="example-text-input"--}}
{{--                                                                   class="col-sm-2 col-form-label">{{ trans('products.meta_title') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>--}}
{{--                                                            <div class="col-sm-10">--}}

{{--                                                                <input class="form-control"--}}
{{--                                                                       name="{{ $locale }}[meta_title]"--}}
{{--                                                                       value="{{ old($locale . '.meta_title') }} ">--}}


{{--                                                            </div>--}}
{{--                                                            @if ($errors->has($locale . '.meta_title'))--}}
{{--                                                                <span--}}
{{--                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>--}}
{{--                                                            @endif--}}
{{--                                                        </div>--}}


{{--                                                        --}}{{-- meta_desc ------------------------------------------------------------------------------------- --}}
{{--                                                        <div class="row mb-3">--}}
{{--                                                            <label for="example-text-input"--}}
{{--                                                                   class="col-sm-2 col-form-label">{{ trans('products.meta_desc') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>--}}
{{--                                                            <div class="col-sm-10">--}}

{{--                                                                <textarea class="form-control"--}}
{{--                                                                          id="meta_description{{$key}}"--}}
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
{{--                                                                   class="col-sm-2 col-form-label">{{ trans('products.meta_key') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>--}}
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

{{--                                                        <br>--}}
{{--                                                        <hr>--}}
{{--                                                        <br>--}}

{{--                                                    @endforeach--}}

{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}
{{--                                    <!----------end test ---------->--}}



                                </div>


                                <div class="col-md-4">

                                    <div class="accordion mt-4 mb-4" id="accordionExample1">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingtwo">
                                                <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                        aria-expanded="true"
                                                        aria-controls="collapseTwo">
                                                    {{ trans('products.settings') }}
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse show"
                                                 aria-labelledby="headingtwo" data-bs-parent="#accordionExample1">
                                                <div class="accordion-body">


                                                    {{-- image ------------------------------------------------------------------------------------- --}}

                                                    <div class="col-12">
                                                        <div class="row mb-3">

                                                            <div class="col-sm-4"><label for="example-number-input"
                                                                                         class='col-form-label'>
                                                                    @lang('products.main_image'):</label></div>
                                                            <div class="col-sm-8">
                                                                <input class="form-control" type="file"
                                                                       placeholder="@lang('products.main_image'):"
                                                                       id="example-number-input"
                                                                       name="image" value="{{ old('image') }}">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    {{-- code ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                               class="col-sm-4 col-form-label">{{ trans('whatsapp_contacts.number')  }}</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="text"
                                                                   name="number"
                                                                   value="{{ old( 'number') }}">
                                                        </div>
                                                        @if ($errors->has(  'number'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first($locale . '.number') }}</span>
                                                        @endif
                                                    </div>




                                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label"
                                                               for="available">{{ trans('products.feature') }}</label>
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
                                                               for="available">{{ trans('products.status') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch" name="status"
                                                                   type="checkbox" id="switch3" switch="success"
                                                                   value="1">
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
                                        <a href="{{ route('admin.whatsapp-contact.index') }}"
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




@endsection
