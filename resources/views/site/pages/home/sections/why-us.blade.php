@php($whySection = optional($homeSections->get('why-us'))->transNow)
<section class="section home-why-section">
    <div class="container split">
        <div class="feature-copy" data-reveal>
            <span class="eyebrow">{{ $whySection->sub_title ?? __('athar.about.kicker') }}</span>
            <h2>{{ $whySection->title ?? __('athar.home.why') }}</h2>
            <p>{{ strip_tags($whySection->description ?? optional($about_us->transNow)->description ?? __('athar.home.why_copy')) }}</p>

            <div class="why-features">
                @forelse($whyFeatures as $feature)
                    <article class="why-feature">
                        <span>{{ $feature->sub_title }}</span>
                        <div>
                            <h3>{{ $feature->title }}</h3>
                            <p>{{ strip_tags($feature->description) }}</p>
                        </div>
                    </article>
                @empty
                    @foreach(__('athar.home.why_features') as $feature)
                        <article class="why-feature">
                            <span>0{{ $loop->iteration }}</span>
                            <div><h3>{{ $feature }}</h3></div>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>

        <div class="feature-image" data-reveal>
            <img src="{{ media_asset('site/images/athar-team.png') }}" alt="{{ __('athar.about.title') }}" loading="lazy">
        </div>
    </div>
</section>
