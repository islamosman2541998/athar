@php
    $servicesSection = $homeSections->get('services')?->transNow;
    $serviceIcons = ['⌘', '◫', '✎', '◉'];
@endphp
<section class="section">
    <div class="container">
        <div class="section-heading-row" data-reveal>
            <div class="section-head">
                <span class="eyebrow">{{ $servicesSection->sub_title ?? __('athar.nav.services') }}</span>
                <h2>{{ $servicesSection->title ?? __('athar.home.services_title') }}</h2>
                <p>{{ strip_tags($servicesSection->description ?? __('athar.home.services_copy')) }}</p>
            </div>
            <a class="section-inline-link" href="{{ route('site.services.index') }}">{{ __('athar.home.all_services') }}</a>
        </div>

        <div class="home-services-grid">
            @forelse($servicesCategories->take(4) as $category)
                @php($trans = $category->transNow)
                <article class="home-service-card" data-reveal>
                    <div class="card-body">
                        <span class="service-line-icon" aria-hidden="true">{{ $serviceIcons[$loop->index] ?? '✦' }}</span>
                        <h3>{{ $trans->title ?? __('athar.fallback.service') }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($trans->description ?? __('athar.fallback.service_copy')), 105) }}</p>
                        <a class="card-link" href="{{ route('site.services.show', $trans->slug ?? $category->id) }}">{{ __('athar.more') }}</a>
                    </div>
                </article>
            @empty
                @foreach($serviceIcons as $icon)
                    <article class="home-service-card" data-reveal>
                        <div class="card-body">
                            <span class="service-line-icon" aria-hidden="true">{{ $icon }}</span>
                            <h3>{{ __('athar.fallback.service') }}</h3>
                            <p>{{ __('athar.fallback.service_copy') }}</p>
                            <a class="card-link" href="{{ route('site.services.index') }}">{{ __('athar.more') }}</a>
                        </div>
                    </article>
                @endforeach
            @endforelse
        </div>
    </div>
</section>
