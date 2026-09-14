@extends('admin.app')

@section('title', __('faq_category.view'))
@section('title_page', __('faq_category.view'))

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12 text-end">
            <a href="{{ route('admin.faq-categories.index') }}" class="btn btn-primary btn-sm">@lang('admin.back')</a>
            <a href="{{ route('admin.faq-categories.edit', $category->id) }}" class="btn btn-success btn-sm">@lang('button.edit')</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h2>@lang('faq_category.title')</h2>
            <ul class="list-unstyled">
                @foreach(config('translatable.locales') as $locale)
                    <li><strong>{{ strtoupper($locale) }}:</strong> {{ optional($category->translate($locale))->title ?? '-' }}</li>
                @endforeach
            </ul>

            <hr>

            <p><strong>@lang('admin.status'):</strong> {{ $category->status ? 'Active' : 'Inactive' }}</p>
            <p><strong>@lang('admin.sort'):</strong> {{ $category->sort }}</p>
        </div>
    </div>
</div>
@endsection
