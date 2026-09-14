@extends('admin.app')

@section('title', __('faq.view'))
@section('title_page', __('faq.view'))

@section('content')
<div class="container-fluid">
    <div class="row mb-3 text-end">
        <div>
            <a href="{{ route('admin.faqs.index') }}" class="btn btn-primary btn-sm">@lang('admin.back')</a>
            <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-success btn-sm">@lang('button.edit')</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            {{-- Basic info --}}
            <div class="mb-3">
                <strong>@lang('faq.category'):</strong>
                {{ optional($faq->category->translate(app()->getLocale()))->title
                    ?? optional($faq->category->translate(config('app.fallback_locale')))->title
                    ?? '-' }}
            </div>

            <div class="mb-3">
                <strong>@lang('admin.status'):</strong>
                @if($faq->status)
                    <span class="badge bg-success">@lang('admin.active')</span>
                @else
                    <span class="badge bg-warning">@lang('admin.dis_active')</span>
                @endif
            </div>

            <div class="mb-3">
                <strong>@lang('admin.sort'):</strong> {{ $faq->sort }}
            </div>

            <hr>

            @foreach($languages as $key => $locale)
                @php
                    $trans = $faq->translate($locale);
                @endphp

                <div class="accordion mb-3" id="accordionShow{{ $key }}">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingShow{{ $key }}">
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapseShow{{ $key }}" aria-expanded="false" aria-controls="collapseShow{{ $key }}">
                                {{ trans('lang.' . \Locale::getDisplayName($locale)) }}
                            </button>
                        </h2>
                        <div id="collapseShow{{ $key }}" class="accordion-collapse collapse show" aria-labelledby="headingShow{{ $key }}" data-bs-parent="#accordionShow{{ $key }}">
                            <div class="accordion-body">
                                <p><strong>@lang('faq.question'):</strong> {{ optional($trans)->question ?? '-' }}</p>
                                <p><strong>@lang('faq.answer'):</strong></p>
                                <div>{!! optional($trans)->answer ?? '-' !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>
@endsection
