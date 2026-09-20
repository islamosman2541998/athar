@php
    $portfolioTrans = $portfolio->transNow;
    $isYoutube = $portfolio->isYoutube();
    $portfolioType = $isYoutube
        ? 'video'
        : (in_array($portfolio->type, ['image', 'video', 'pdf'], true) ? $portfolio->type : 'image');
    $portfolioMedia = $portfolio->pathInView();
    $hasMedia = $portfolioMedia !== '/attachments/no_image/no_image.png';
    $portfolioUrl = route('site.portfolio.show', $portfolioTrans->slug ?? $portfolio->id);
    $portfolioTitle = $portfolioTrans->title ?? __('athar.fallback.portfolio');
    // Covers come from the video itself: a YouTube thumbnail, or a still frame (#t=0.5) of an uploaded file.
    $videoFrame = !$isYoutube && $portfolioType === 'video' && $hasMedia ? media_asset($portfolioMedia) . '#t=0.5' : null;
    $imageCover = $isYoutube
        ? $portfolio->youtubeThumbnail('hqdefault') // cards are small: no need for the 1280px cover
        : media_asset($portfolioType === 'image' && $hasMedia ? $portfolioMedia : '/site/images/athar-devices.png');
    $playable = $isYoutube || ($portfolioType === 'video' && $hasMedia) || ($portfolioType === 'pdf' && $hasMedia);
@endphp

<article class="portfolio-showcase-card portfolio-showcase-card--{{ $portfolioType }}" data-category="{{ $portfolio->tag_id }}" data-reveal>
    <a class="portfolio-card-detail" href="{{ $portfolioUrl }}" aria-label="{{ $portfolioTitle }}">
        @if($videoFrame)
            <video class="portfolio-card-media" src="{{ $videoFrame }}" muted playsinline preload="metadata" tabindex="-1" aria-hidden="true"></video>
        @else
            <img class="portfolio-card-media" src="{{ $imageCover }}" alt="{{ $portfolioTitle }}" loading="lazy" decoding="async"
                @if($isYoutube) onerror="this.onerror=null;this.src='{{ $portfolio->youtubeThumbnail('hqdefault') }}'" @endif>
        @endif
        <span class="portfolio-card-shade"></span>
        <span class="portfolio-card-copy">
            <small>{{ optional(optional($portfolio->tag)->transNow)->title ?? __('athar.nav.work') }}</small>
            <strong>{{ $portfolioTitle }}</strong>
            <em>{{ __('athar.more') }}</em>
        </span>
    </a>

    @if($playable)
        @php
            $mediaKind = $isYoutube ? 'youtube' : $portfolioType;
            $mediaSrc = $isYoutube ? $portfolio->youtubeEmbedUrl() : media_asset($portfolioMedia);
        @endphp
        <button type="button" class="portfolio-media-action portfolio-media-action--{{ $portfolioType }}"
            data-media-open data-media-type="{{ $mediaKind }}" data-media-src="{{ $mediaSrc }}"
            aria-label="{{ $portfolioType === 'pdf' ? __('athar.media.open_pdf') : __('athar.media.play') }}">
            @if($portfolioType === 'pdf')
                <span>PDF</span>
            @else
                @include('site.includes.icon', ['name' => 'play', 'class' => ''])
            @endif
        </button>
    @endif
</article>
