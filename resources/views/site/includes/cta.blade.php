@unless(request()->routeIs('site.service_request.*'))
<section class="cta" style="--cta-background:url('{{ asset(app()->getLocale() === 'ar' ? 'site/images/cta-impact-ar.webp' : 'site/images/cta-impact-en.webp') }}')">
    <div class="container">
        <div class="cta__copy"><span class="eyebrow">{{ $ctaSection->sub_title ?? __('athar.home.kicker') }}</span><h2>{{ $ctaSection->title ?? __('athar.tagline') }}</h2><p>{{ strip_tags($ctaSection->description ?? __('athar.home.services_copy')) }}</p></div>
        <div class="hero-actions"><a class="btn btn--gold" href="{{ route('site.service_request.index') }}">{{ __('athar.start') }}</a><a class="btn btn--outline" href="{{ route('site.contact-us') }}">{{ __('athar.nav.contact') }}</a></div>
    </div>
</section>
@endunless
