@extends('site.layouts.app')
@php
    $trans = $portfolio->transNow;
    $mainMedia = $portfolio->pathInView();
    $hasMainMedia = $mainMedia !== '/attachments/no_image/no_image.png';
    $gallery = $portfolio->galleryMedia ?? collect();
    $mediaCount = 1 + $gallery->count();
    $title = $trans->title ?? __('athar.fallback.portfolio');
    // Videos preview a still frame from the file itself (#t=0.5) instead of an uploaded cover.
    $frame = fn (string $url) => $url . '#t=0.5';
    $isYoutube = $portfolio->isYoutube();
@endphp
@section('title', $trans->meta_title ?? $title)
@section('meta_description', strip_tags($trans->meta_description ?? $trans->description ?? __('athar.portfolio.intro')))
@section('content')
@include('site.includes.page-hero', [
    'title' => $title,
    'kicker' => optional(optional($portfolio->tag)->transNow)->title ?? __('athar.portfolio.kicker'),
    'intro' => \Illuminate\Support\Str::limit(strip_tags($trans->description ?? ''), 190),
    'image' => $isYoutube
        ? $portfolio->youtubeThumbnail()
        : asset($portfolio->type === 'image' && $hasMainMedia ? $mainMedia : 'site/images/athar-devices.png'),
])

<section class="section">
    <div class="container portfolio-detail">
        <div class="portfolio-intro" data-reveal>
            <div><span class="eyebrow">{{ __('athar.nav.work') }}</span><h2>{{ $title }}</h2></div>
            <div class="rich-text">{!! $trans->description ?? '' !!}</div>
        </div>

        <div class="project-media-carousel" data-project-carousel data-reveal aria-label="{{ __('athar.media.gallery') }}">
            <div class="project-media-stage {{ $portfolio->isYoutubeShort() ? 'project-media-stage--portrait' : '' }}">
                <article class="project-media-slide is-active" data-project-slide aria-hidden="false">
                    @if($isYoutube)
                        <iframe class="project-media-embed" data-project-embed data-src="{{ $portfolio->youtubeEmbedUrl() }}"
                            title="{{ $title }}" loading="lazy" allowfullscreen
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin"></iframe>
                    @elseif($portfolio->type === 'video')
                        <video controls playsinline preload="metadata" data-project-video data-src="{{ $frame(asset($mainMedia)) }}"></video>
                    @elseif($portfolio->type === 'pdf')
                        <div class="project-document-stage">
                            <span>PDF</span><strong>{{ __('athar.media.main_document') }}</strong>
                            <a class="btn btn--gold" href="{{ asset($mainMedia) }}" target="_blank" rel="noopener">{{ __('athar.media.open_file') }}</a>
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
                            <video controls playsinline preload="none" data-project-video data-src="{{ $frame($mediaUrl) }}"></video>
                        @elseif($mediaType === 'pdf')
                            <div class="project-document-stage"><span>PDF</span><strong>{{ basename($media->image) }}</strong><a class="btn btn--gold" href="{{ $mediaUrl }}" target="_blank" rel="noopener">{{ __('athar.media.open_file') }}</a></div>
                        @else
                            <img src="{{ $mediaUrl }}" alt="{{ $title }} — {{ $loop->iteration + 1 }}" loading="lazy" decoding="async">
                        @endif
                    </article>
                @endforeach

                @if($mediaCount > 1)
                    <button class="project-carousel-arrow project-carousel-arrow--prev" type="button" data-project-prev aria-label="{{ __('athar.previous') }}">@include('site.includes.icon', ['name' => 'chevron-left', 'class' => ''])</button>
                    <button class="project-carousel-arrow project-carousel-arrow--next" type="button" data-project-next aria-label="{{ __('athar.next') }}">@include('site.includes.icon', ['name' => 'chevron-right', 'class' => ''])</button>
                @endif
            </div>

            @if($mediaCount > 1)
                <div class="project-media-thumbs" role="tablist">
                    <button class="project-media-thumb is-active" type="button" data-project-thumb="0" aria-selected="true">
                        @if($isYoutube)
                            <img src="{{ $portfolio->youtubeThumbnail('hqdefault') }}" alt="">
                            <span class="thumb-type">@include('site.includes.icon', ['name' => 'play', 'class' => ''])</span>
                        @elseif($portfolio->type === 'image')
                            <img src="{{ asset($mainMedia) }}" alt="">
                        @elseif($portfolio->type === 'video' && $hasMainMedia)
                            <video src="{{ $frame(asset($mainMedia)) }}" muted playsinline preload="metadata" tabindex="-1" aria-hidden="true"></video>
                            <span class="thumb-type">@include('site.includes.icon', ['name' => 'play', 'class' => ''])</span>
                        @else
                            <span class="thumb-placeholder">PDF</span>
                        @endif
                    </button>
                    @foreach($gallery as $media)
                        @php
                            $thumbType = in_array($media->type, ['image', 'video', 'pdf'], true) ? $media->type : 'image';
                            $thumbUrl = asset($media->pathInView('portfolios'));
                        @endphp
                        <button class="project-media-thumb" type="button" data-project-thumb="{{ $loop->iteration }}" aria-selected="false">
                            @if($thumbType === 'image')
                                <img src="{{ $thumbUrl }}" alt="" loading="lazy">
                            @elseif($thumbType === 'video')
                                <video src="{{ $frame($thumbUrl) }}" muted playsinline preload="metadata" tabindex="-1" aria-hidden="true"></video>
                                <span class="thumb-type">@include('site.includes.icon', ['name' => 'play', 'class' => ''])</span>
                            @else
                                <span class="thumb-placeholder">PDF</span>
                            @endif
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="section-action">
            @if($isYoutube)
                <a class="btn btn--green btn--youtube" href="{{ $portfolio->youtubeWatchUrl() }}" target="_blank" rel="noopener">
                    @include('site.includes.icon', ['name' => 'youtube', 'class' => ''])
                    {{ __('athar.media.watch_on_youtube') }}
                </a>
            @endif
            @if($portfolio->link && !str_starts_with($portfolio->link, '#') && $portfolio->link !== $portfolio->youtubeSource())
                <a class="btn btn--green" href="{{ $portfolio->link }}" target="_blank" rel="noopener">{{ app()->getLocale()==='ar' ? 'زيارة المشروع' : 'Visit project' }}</a>
            @endif
        </div>
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
