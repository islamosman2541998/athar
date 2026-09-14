@php($statisticsSection = $homeSections->get('statistics')?->transNow)
<section class="section section--dark home-statistics-section">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow">{{ $statisticsSection->sub_title ?? __('athar.home.stats_kicker') }}</span>
            <h2>{{ $statisticsSection->title ?? __('athar.home.stats_title') }}</h2>
            <p>{{ strip_tags($statisticsSection->description ?? '') }}</p>
        </div>

        <div class="stats" data-reveal>
            @forelse($statistics->take(4) as $stat)
                <div class="stat">
                    <strong>{{ $stat->count }}</strong>
                    <span>{{ optional($stat->transNow)->title }}</span>
                </div>
            @empty
                @foreach(['clients' => '+250', 'projects' => '+450', 'years' => '+5', 'satisfaction' => '98%'] as $key => $count)
                    <div class="stat">
                        <strong>{{ $count }}</strong>
                        <span>{{ __('athar.stats.' . $key) }}</span>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>
