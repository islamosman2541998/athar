@extends('admin.app')

@section('title', __('about.page'))
@section('title_page', __('about.page'))

@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.about.update') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-9">
                    @foreach ($languages as $key => $locale)
                        <div class="accordion mt-3" id="acc{{ $locale }}">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="h{{ $locale }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#c{{ $locale }}" aria-expanded="true">
                                        {{ trans('lang.' . \Locale::getDisplayName($locale)) }} ({{ strtoupper($locale) }})
                                    </button>
                                </h2>
                                <div id="c{{ $locale }}" class="accordion-collapse collapse show"
                                    aria-labelledby="h{{ $locale }}">
                                    <div class="accordion-body">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label">@lang('about.title')</label>
                                            <input type="text" name="{{ $locale }}[title]"
                                                class="col-sm-10 mb-2 form-control"
                                                value="{{ old($locale . '.title', optional($about->translate($locale))->title) }}">
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label">@lang('about.subtitle')</label>
                                            <input type="text" name="{{ $locale }}[subtitle]"
                                                class="col-sm-10 mb-2 form-control"
                                                value="{{ old($locale . '.subtitle', optional($about->translate($locale))->subtitle) }}">
                                        </div>

                                        {{-- description ------------------------------------------------------------------------------------- --}}
                                        <div class="row mb-3">
                                            <label for="example-text-input"
                                                class="col-sm-2 col-form-label">{{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                            </label>
                                            <div class="col-sm-10 mb-2">
                                                <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ @$about->trans->where('locale', $locale)->first()->description }} </textarea>
                                                @if ($errors->has($locale . '.description'))
                                                    <span
                                                        class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                @endif
                                            </div>

                                            <script type="text/javascript">
                                                CKEDITOR.replace('description{{ $key }}', {
                                                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                    filebrowserUploadMethod: 'form'
                                                });
                                            </script>
                                        </div>
                                        {{-- vision ------------------------------------------------------------------------------------- --}}
                                        <div class="row mb-3">
                                            <label for="example-text-input"
                                                class="col-sm-2 col-form-label">{{ trans('admin.vision_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                            </label>
                                            <div class="col-sm-10 mb-2">
                                                <textarea id="vision{{ $key }}" name="{{ $locale }}[vision]"> {{ @$about->trans->where('locale', $locale)->first()->vision }} </textarea>
                                                @if ($errors->has($locale . '.vision'))
                                                    <span
                                                        class="missiong-spam">{{ $errors->first($locale . '.vision') }}</span>
                                                @endif
                                            </div>

                                            <script type="text/javascript">
                                                CKEDITOR.replace('vision{{ $key }}', {
                                                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                    filebrowserUploadMethod: 'form'
                                                });
                                            </script>
                                        </div>
                                        {{-- mission ------------------------------------------------------------------------------------- --}}
                                        <div class="row mb-3">
                                            <label for="example-text-input"
                                                class="col-sm-2 col-form-label">{{ trans('admin.mission_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                            </label>
                                            <div class="col-sm-10 mb-2">
                                                <textarea id="mission{{ $key }}" name="{{ $locale }}[mission]"> {{ @$about->trans->where('locale', $locale)->first()->mission }} </textarea>
                                                @if ($errors->has($locale . '.mission'))
                                                    <span
                                                        class="missiong-spam">{{ $errors->first($locale . '.mission') }}</span>
                                                @endif
                                            </div>
                                            <script type="text/javascript">
                                                CKEDITOR.replace('mission{{ $key }}', {
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
                    <div class="card p-3">
                        <h5>@lang('admin.settings')</h5>

                        {{-- <div class="mb-3">
                            <label class="form-label">@lang('about.image1')</label>
                            @if ($about->ceo_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $about->ceo_image) }}"
                                        style="width:100%; max-height:150px; object-fit:cover;">
                                </div>
                            @endif
                            <input type="file" name="ceo_image" class="form-control" accept="ceo_image/*">
                        </div> --}}
                        <div class="mb-3">
                            <label class="form-label">@lang('about.image2')</label>
                            @if ($about->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $about->image) }}"
                                        style="width:100%; max-height:150px; object-fit:cover;">
                                </div>
                            @endif
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label">@lang('about.image3')</label>
                            @if ($about->image_background)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $about->image_background) }}"
                                        style="width:100%; max-height:120px; object-fit:cover;">
                                </div>
                            @endif
                            <input type="file" name="image_background" class="form-control" accept="image/*">
                        </div> --}}
                    </div>
                </div>
                <div class="row mb-3 text-end">
                    <div>

                        <button type="submit"
                            class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
@endsection
