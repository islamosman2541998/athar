@extends('site.layouts.app')
@php
    $trans = $portfolio->transNow;
    $mainMedia = $portfolio->pathInView();
    $mainPoster = $portfolio->posterInView();
    $gallery = $portfolio->galleryMedia ?? collect();
    $mediaCount = 1 + $gallery->count();
    $title = $trans->title ?? __('athar.fallback.portfolio');
@endphp
@section('title', $trans->meta_title ?? $title)
@section('meta_description', strip_tags($trans->meta_description ?? $trans->description ?? __('athar.portfolio.intro')))
@section('content')
@include('site.includes.page-hero', [
    'title' => $title,
    'kicker' => optional(optional($portfolio->tag)->transNow)->title ?? __('athar.portfolio.kicker'),
    'intro' => \Illuminate\Support\Str::limit(strip_tags($trans->description ?? ''), 190),
    'image' => $portfolio->type === 'image' ? asset($mainMedia) : asset($mainPoster !== '/attachments/no_image/no_image.png' ? $mainPoster : 'site/images/athar-devices.png'),
])

<section class="section">
    <div class="container portfolio-detail">
        <div class="portfolio-intro" data-reveal>
            <div><span class="eyebrow">{{ __('athar.nav.work') }}</span><h2>{{ $title }}</h2></div>
            <div class="rich-text">{!! $trans->description ?? '' !!}</div>
        </div>

        <div class="project-media-carousel" data-project-carousel data-reveal aria-label="{{ app()->getLocale() === 'ar' ? 'معرض المشروع' : 'Project gallery' }}">
            <div class="project-media-stage">
                <article class="project-media-slide is-active" data-project-slide aria-hidden="false">
                    @if($portfolio->type === 'video')
                        <video controls playsinline preload="metadata" poster="{{ $mainPoster !== '/attachments/no_image/no_image.png' ? asset($mainPoster) : '' }}" data-project-video data-src="{{ asset($mainMedia) }}"></video>
                    @elseif($portfolio->type === 'pdf')
                        <div class="project-document-stage" @if($mainPoster !== '/attachments/no_image/no_image.png') style="background-image:linear-gradient(rgba(5,28,24,.55),rgba(5,28,24,.82)),url('{{ asset($mainPoster) }}')" @endif>
                            <span>PDF</span><strong>{{ app()->getLocale() === 'ar' ? 'ملف المشروع الرئيسي' : 'Main project document' }}</strong>
                            <a class="btn btn--gold" href="{{ asset($mainMedia) }}" target="_blank" rel="noopener">{{ app()->getLocale() === 'ar' ? 'فتح الملف' : 'Open document' }}</a>
                        </div>
                    @else
                        <img src="{{ asset($mainMedia) }}" alt="{{ $title }}" fetchpriority="high">
                    @endif
                </article>

                @foreach($gallery as $media)
                    @php
                        $mediaUrl = asset($media->pathInView('portfolios'));
                        $mediaType = in_array($media->type, ['image', 'video', 'pdf'], true)
                            ? $media->type
                            : (strtolower(pathinfo($media->image, PATHINFO_EXTENSION)) === 'pdf' ? 'pdf' : 'image');
                    @endphp
                    <article class="project-media-slide" data-project-slide aria-hidden="true">
                        @if($mediaType === 'video')
                            <video controls playsinline preload="none" data-project-video data-src="{{ $mediaUrl }}"></video>
                        @elseif($mediaType === 'pdf')
                            <div class="project-document-stage"><span>PDF</span><strong>{{ basename($media->image) }}</strong><a class="btn btn--gold" href="{{ $mediaUrl }}" target="_blank" rel="noopener">{{ app()->getLocale() === 'ar' ? 'فتح الملف' : 'Open document' }}</a></div>
                        @else
                            <img src="{{ $mediaUrl }}" alt="{{ $title }} — {{ $loop->iteration + 1 }}" loading="lazy" decoding="async">
                        @endif
                    </article>
                @endforeach

                @if($mediaCount > 1)
                    <button class="project-carousel-arrow project-carousel-arrow--prev" type="button" data-project-prev aria-label="{{ app()->getLocale() === 'ar' ? 'السابق' : 'Previous' }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg></button>
                    <button class="project-carousel-arrow project-carousel-arrow--next" type="button" data-project-next aria-label="{{ app()->getLocale() === 'ar' ? 'التالي' : 'Next' }}"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg></button>
                @endif
            </div>

            @if($mediaCount > 1)
                <div class="project-media-thumbs" role="tablist">
                    <button class="project-media-thumb is-active" type="button" data-project-thumb="0" aria-selected="true">
                        @if($portfolio->type === 'image')
                            <img src="{{ asset($mainMedia) }}" alt="">
                        @elseif($mainPoster !== '/attachments/no_image/no_image.png')
                            <img src="{{ asset($mainPoster) }}" alt=""><span class="thumb-type">{{ $portfolio->type === 'video' ? '▶' : 'PDF' }}</span>
                        @else
                            <span class="thumb-placeholder">{{ $portfolio->type === 'video' ? '▶' : 'PDF' }}</span>
                        @endif
                    </button>
                    @foreach($gallery as $media)
                        @php
                            $thumbType = in_array($media->type, ['image', 'video', 'pdf'], true) ? $media->type : 'image';
                            $thumbUrl = asset($media->pathInView('portfolios'));
                        @endphp
                        <button class="project-media-thumb" type="button" data-project-thumb="{{ $loop->iteration }}" aria-selected="false">
                            @if($thumbType === 'image')<img src="{{ $thumbUrl }}" alt="" loading="lazy">
                            @else<span class="thumb-placeholder">{{ $thumbType === 'video' ? '▶' : 'PDF' }}</span>@endif
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        @if($portfolio->link && !str_starts_with($portfolio->link, '#'))
            <div class="section-action"><a class="btn btn--green" href="{{ $portfolio->link }}" target="_blank" rel="noopener">{{ app()->getLocale()==='ar' ? 'زيارة المشروع' : 'Visit project' }}</a></div>
        @endif
    </div>
</section>

@if($related->isNotEmpty())
<section class="section section--dark"><div class="container"><div class="section-head"><span class="eyebrow">{{ app()->getLocale()==='ar' ? 'أعمال مشابهة' : 'Related work' }}</span><h2>{{ app()->getLocale()==='ar' ? 'اكتشف المزيد من مشاريعنا' : 'Explore more projects' }}</h2></div><div class="portfolio-home-grid">
@foreach($related as $portfolio)
    @include('site.includes.portfolio-card', ['portfolio' => $portfolio])
@endforeach
</div></div></section>
@include('site.includes.media-viewer')
@endif
@endsection
