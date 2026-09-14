@extends('admin.app')

@section('title', __('faq_category.edit'))
@section('title_page', __('faq_category.edit'))

@section('content')
<div class="container-fluid">
    <div class="row mb-3 text-end">
        <div>
            <a href="{{ route('admin.faq-categories.index') }}" class="btn btn-primary btn-sm">@lang('button.cancel')</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.faq-categories.update', $faqCategory->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-9">
                        @foreach($languages as $key => $locale)
                            <div class="accordion mt-4 mb-4" id="accordionCat{{ $key }}">
                                <div class="accordion-item border rounded">
                                    <h2 class="accordion-header" id="headingCat{{ $key }}">
                                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCat{{ $key }}" aria-expanded="true" aria-controls="collapseCat{{ $key }}">
                                            {{ trans('lang.' . \Locale::getDisplayName($locale)) }}
                                        </button>
                                    </h2>
                                    <div id="collapseCat{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingCat{{ $key }}" data-bs-parent="#accordionCat{{ $key }}">
                                        <div class="accordion-body">
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label">@lang('faq_category.title') ({{ strtoupper($locale) }})</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ old($locale . '.title', optional($faqCategory->translate($locale))->title) }}">
                                                    @error($locale . '.title') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-md-3">
                        <div class="accordion mt-4 mb-4" id="settingsAccordionCat">
                            <div class="accordion-item border rounded">
                                <h2 class="accordion-header" id="headingSettingsCat">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSettingsCat" aria-expanded="true" aria-controls="collapseSettingsCat">
                                        {{ trans('admin.settings') }}
                                    </button>
                                </h2>
                                <div id="collapseSettingsCat" class="accordion-collapse collapse show" aria-labelledby="headingSettingsCat" data-bs-parent="#settingsAccordionCat">
                                    <div class="accordion-body">
                                        <div class="row mb-3">
                                            <label class="col-sm-12 col-form-label">@lang('admin.status')</label>
                                            <div class="col-sm-12">
                                                <input type="checkbox" name="status" class="form-check-input" value="1" {{ $faqCategory->status ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-12 col-form-label">@lang('admin.sort')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" name="sort" value="{{ old('sort', $faqCategory->sort) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 text-end mt-3">
                        <div>
                            <a href="{{ route('admin.faq-categories.index') }}" class="btn btn-primary btn-sm">@lang('button.cancel')</a>
                            <button type="submit" class="btn btn-success btn-sm">@lang('button.save')</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
