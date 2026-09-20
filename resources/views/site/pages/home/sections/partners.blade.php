@if($partners->isNotEmpty())
    @php($partnersSection = $homeSections->get('partners')?->transNow)

    @include('site.includes.swiper-assets')

    <section class="section section--compact home-partners-section">
        <div class="container">
            <div class="section-head" data-reveal>
                <span class="eyebrow">{{ $partnersSection->sub_title ?? __('athar.home.partners_kicker') }}</span>
                <h2>{{ $partnersSection->title ?? __('athar.home.partners_title') }}</h2>
                <p>{{ strip_tags($partnersSection->description ?? '') }}</p>
            </div>

            <div class="partners-slider" data-partners-swiper data-prev-label="{{ __('athar.previous') }}" data-next-label="{{ __('athar.next') }}">
                <div class="swiper" aria-label="{{ $partnersSection->title ?? __('athar.home.partners_title') }}">
                    <div class="swiper-wrapper">
                        @foreach($partners as $partner)
                            <div class="swiper-slide">
                                @if($partner->url)
                                    <a class="partner-card" href="{{ $partner->url }}" target="_blank" rel="noopener" aria-label="{{ $partner->title ?: __('athar.home.partners_kicker') }}">
                                        <img src="{{ media_asset($partner->pathInView()) }}" alt="{{ $partner->title ?? '' }}" loading="lazy" draggable="false">
                                    </a>
                                @else
                                    <div class="partner-card">
                                        <img src="{{ media_asset($partner->pathInView()) }}" alt="{{ $partner->title ?? '' }}" loading="lazy" draggable="false">
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <button class="slider-arrow slider-arrow--prev" type="button" data-swiper-prev aria-label="{{ __('athar.previous') }}">@include('site.includes.icon', ['name' => 'chevron-left'])</button>
                <button class="slider-arrow slider-arrow--next" type="button" data-swiper-next aria-label="{{ __('athar.next') }}">@include('site.includes.icon', ['name' => 'chevron-right'])</button>
            </div>
        </div>
    </section>
@endif
