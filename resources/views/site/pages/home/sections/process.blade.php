@php($processSection = optional($homeSections->get('process'))->transNow)
<section class="section section--dark home-process-section">
    <div class="container">
        <div class="section-head" data-reveal>
            <span class="eyebrow">{{ $processSection->sub_title ?? __('athar.home.process_title') }}</span>
            <h2>{{ $processSection->title ?? __('athar.home.process_title') }}</h2>
            <p>{{ strip_tags($processSection->description ?? __('athar.home.process_copy')) }}</p>
        </div>

        <div class="steps">
            @forelse($processSteps as $step)
                <article class="step" data-reveal>
                    <strong>{{ $step->sub_title }}</strong>
                    <h3>{{ $step->title }}</h3>
                    <p>{{ strip_tags($step->description) }}</p>
                </article>
            @empty
                @foreach(__('athar.steps') as $step)
                    <article class="step" data-reveal>
                        <strong>0{{ $loop->iteration }}</strong>
                        <h3>{{ $step }}</h3>
                        <p>{{ __('athar.home.services_copy') }}</p>
                    </article>
                @endforeach
            @endforelse
        </div>
    </div>
</section>
