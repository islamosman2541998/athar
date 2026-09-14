@php
    $portfolioTrans = $portfolio->transNow;
    $portfolioType = in_array($portfolio->type, ['image', 'video', 'pdf'], true) ? $portfolio->type : 'image';
    $portfolioMedia = $portfolio->pathInView();
    $portfolioPoster = $portfolio->posterInView();
    $portfolioCover = $portfolioType === 'image' ? $portfolioMedia : $portfolioPoster;
    $portfolioCover = $portfolioCover !== '/attachments/no_image/no_image.png'
        ? $portfolioCover
        : '/site/images/athar-devices.png';
    $portfolioUrl = route('site.portfolio.show', $portfolioTrans->slug ?? $portfolio->id);
    $portfolioTitle = $portfolioTrans->title ?? __('athar.fallback.portfolio');
@endphp

<article class="portfolio-showcase-card" data-category="{{ $portfolio->tag_id }}" data-reveal>
    <a class="portfolio-card-detail" href="{{ $portfolioUrl }}" aria-label="{{ $portfolioTitle }}">
        <img src="{{ asset($portfolioCover) }}" alt="{{ $portfolioTitle }}" loading="lazy" decoding="async">
        <span class="portfolio-card-shade"></span>
        <span class="portfolio-card-copy">
            <small>{{ optional(optional($portfolio->tag)->transNow)->title ?? __('athar.nav.work') }}</small>
            <strong>{{ $portfolioTitle }}</strong>
            <em>{{ __('athar.more') }}</em>
        </span>
    </a>

    @if(in_array($portfolioType, ['video', 'pdf'], true) && $portfolioMedia !== '/attachments/no_image/no_image.png')
        <button type="button" class="portfolio-media-action portfolio-media-action--{{ $portfolioType }}"
            data-media-open data-media-type="{{ $portfolioType }}" data-media-src="{{ asset($portfolioMedia) }}"
            aria-label="{{ $portfolioType === 'video' ? (app()->getLocale() === 'ar' ? 'تشغيل الفيديو' : 'Play video') : (app()->getLocale() === 'ar' ? 'فتح ملف PDF' : 'Open PDF') }}">
            <span>{{ $portfolioType === 'video' ? '▶' : 'PDF' }}</span>
        </button>
    @endif
</article>
