@extends('admin.app')

@section('title', __('faq.edit'))
@section('title_page', __('faq.edit'))

@section('content')
    <div class="container-fluid">
        <div class="row mb-3 text-end">
            <div>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-primary btn-sm">@lang('button.cancel')</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row">
                        <div class="col-md-9">
                            @foreach ($languages as $key => $locale)
                                <div class="accordion mt-4 mb-4" id="accordionFaq{{ $key }}">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingFaq{{ $key }}">
                                            <button class="accordion-button fw-medium" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseFaq{{ $key }}"
                                                aria-expanded="true" aria-controls="collapseFaq{{ $key }}">
                                                {{ trans('lang.' . \Locale::getDisplayName($locale)) }}
                                            </button>
                                        </h2>
                                        <div id="collapseFaq{{ $key }}"
                                            class="accordion-collapse collapse show mt-3"
                                            aria-labelledby="headingFaq{{ $key }}"
                                            data-bs-parent="#accordionFaq{{ $key }}">
                                            <div class="accordion-body">
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label">@lang('faq.question')
                                                        ({{ strtoupper($locale) }})</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text"
                                                            name="{{ $locale }}[question]"
                                                            value="{{ old($locale . '.question', optional($faq->translate($locale))->question) }}">
                                                        @error($locale . '.question')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label">@lang('faq.answer')
                                                        ({{ strtoupper($locale) }})</label>
                                                    <div class="col-sm-10">
                                                        <textarea id="answer{{ $key }}" name="{{ $locale }}[answer]" class="form-control" rows="6">{{ old($locale . '.answer', optional($faq->translate($locale))->answer) }}</textarea>
                                                        @error($locale . '.answer')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-3">
                            <div class="accordion mt-4 mb-4" id="settingsAccordionFaq">
                                <div class="accordion-item border rounded">
                                    <h2 class="accordion-header" id="headingSettingsFaq">
                                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseSettingsFaq" aria-expanded="true"
                                            aria-controls="collapseSettingsFaq">
                                            {{ trans('admin.settings') }}
                                        </button>
                                    </h2>
                                    <div id="collapseSettingsFaq" class="accordion-collapse collapse show"
                                        aria-labelledby="headingSettingsFaq" data-bs-parent="#settingsAccordionFaq">
                                        <div class="accordion-body">
                                            <div class="row mb-3">
                                                <label class="col-sm-12 col-form-label">@lang('faq.category')</label>
                                                <div class="col-sm-12">
                                                    <select name="faq_category_id" class="form-control">
                                                        <option value="">- @lang('admin.select') -</option>
                                                        @foreach ($categories as $cat)
                                                            <option value="{{ $cat->id }}"
                                                                {{ old('faq_category_id', $faq->faq_category_id) == $cat->id ? 'selected' : '' }}>
                                                                {{ optional($cat->translate(app()->getLocale()))->title ?? optional($cat->translate(config('app.fallback_locale')))->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Status --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-12 col-form-label">@lang('admin.status')</label>
                                                <div class="col-sm-12">
                                                    <input type="checkbox" name="status" value="1"
                                                        class="form-check-input" {{ $faq->status ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            {{-- Sort --}}
                                            <div class="row mb-3">
                                                <label class="col-sm-12 col-form-label">@lang('admin.sort')</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="number" name="sort"
                                                        value="{{ old('sort', $faq->sort) }}">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 text-end mt-3">
                            <div>
                                <a href="{{ route('admin.faqs.index') }}"
                                    class="btn btn-primary btn-sm">@lang('button.cancel')</a>
                                <button type="submit" class="btn btn-success btn-sm">@lang('button.save')</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(function() {
            @foreach ($languages as $key => $locale)
                CKEDITOR.replace('answer{{ $key }}', {
                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                    filebrowserUploadMethod: 'form'
                });
            @endforeach
        });
    </script>
@endsection
