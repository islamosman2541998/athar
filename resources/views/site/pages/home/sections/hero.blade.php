<section class="hero-slider" data-hero-slider aria-label="{{ __('athar.brand') }}">
    @forelse($sliders as $slider)
        @php
            $slide = $slider->transNow;
            $slideImage = $slider->pathInView();
            $slideMobileImage = $slider->mobileImageInView();
            $slideVideo = $slider->videoInView();
            $slideUrl = $slider->url
                ? \Mcamara\LaravelLocalization\Facades\LaravelLocalization::localizeURL($slider->url)
                : route('site.service_request.index');
        @endphp
        <article class="hero hero-slide {{ $slider->mobile_image ? 'has-mobile-image' : '' }} {{ $loop->first ? 'is-active' : '' }}" style="--hero-desktop-image:url('{{ asset($slideImage) }}');--hero-mobile-image:url('{{ asset($slideMobileImage) }}')" aria-hidden="{{ $loop->first ? 'false' : 'true' }}">
            @if($slideVideo)
                <video class="hero-media" autoplay muted loop playsinline preload="metadata"><source src="{{ asset($slideVideo) }}"></video>
            @endif
            <div class="container">
                <div class="hero-content">
                    <h1>{{ $slide->title ?? __('athar.home.title') }}</h1>
                    <p>{{ strip_tags($slide->description ?? __('athar.home.intro')) }}</p>
                    <div class="hero-actions">
                        <a class="btn btn--gold" href="{{ $slideUrl }}">{{ __('athar.request') }}</a>
                        <a class="btn btn--outline" href="{{ route('site.portfolio.index') }}">{{ __('athar.nav.work') }}</a>
                    </div>
                </div>
            </div>
        </article>
    @empty
        <article class="hero hero-slide is-active" style="--hero-desktop-image:url('{{ asset('site/images/athar-hero.png') }}');--hero-mobile-image:var(--hero-desktop-image)">
            <div class="container">
                <div class="hero-content">
                    <span class="hero-kicker">{{ __('athar.home.kicker') }}</span>
                    <h1>{!! __('athar.home.title') !!}</h1>
                    <p>{{ __('athar.home.intro') }}</p>
                    <div class="hero-actions">
                        <a class="btn btn--gold" href="{{ route('site.service_request.index') }}">{{ __('athar.request') }}</a>
                        <a class="btn btn--outline" href="{{ route('site.portfolio.index') }}">{{ __('athar.nav.work') }}</a>
                    </div>
                </div>
            </div>
        </article>
    @endforelse

    @if($sliders->count() > 1)
        <div class="slider-controls" aria-label="Slider controls">
            <button type="button" data-slide-prev aria-label="{{ __('athar.previous') }}">‹</button>
            <div class="slider-dots">
                @foreach($sliders as $slider)
                    <button type="button" class="{{ $loop->first ? 'is-active' : '' }}" data-slide-to="{{ $loop->index }}" aria-label="{{ $loop->iteration }}"></button>
                @endforeach
            </div>
            <button type="button" data-slide-next aria-label="{{ __('athar.next') }}">›</button>
        </div>
    @endif
</section>
