<section class="section section--dark home-portfolio-section">
    <div class="container">
        <div class="section-heading-row section-heading-row--dark" data-reveal>
            <div class="section-head">
                <span class="eyebrow">{{ __('athar.nav.work') }}</span>
                <h2>{{ __('athar.home.work_title') }}</h2>
            </div>
            <a class="section-inline-link" href="{{ route('site.portfolio.index') }}">{{ __('athar.home.all_work') }}</a>
        </div>

        <div class="portfolio-home-grid">
            @forelse($portfolios->take(9) as $portfolio)
                @include('site.includes.portfolio-card', ['portfolio' => $portfolio])
            @empty
                @foreach(range(1, 9) as $item)
                    <article class="portfolio-showcase-card" data-reveal>
                        <span class="portfolio-card-detail">
                            <img src="{{ asset('site/images/athar-devices.png') }}" alt="">
                            <span class="portfolio-card-shade"></span>
                            <span class="portfolio-card-copy">
                                <small>{{ __('athar.nav.work') }}</small>
                                <strong>{{ __('athar.fallback.portfolio') }}</strong>
                            </span>
                        </span>
                    </article>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

@if($portfolios->isNotEmpty())
    @include('site.includes.media-viewer')
@endif
