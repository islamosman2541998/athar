<section class="hero page-hero" style="background-image:url('{{ media_asset('site/images/athar-team.png') }}')">
    <div class="container">
        <div class="hero-content" data-reveal>
            <nav class="breadcrumbs" aria-label="Breadcrumb"><a href="{{ route('site.home') }}">{{ __('athar.nav.home') }}</a><span>/</span><span>{{ $title }}</span></nav>
            @isset($kicker)<span class="hero-kicker">{{ $kicker }}</span>@endisset
            <h1>{{ $title }}</h1>
            @isset($intro)<p>{{ $intro }}</p>@endisset
        </div>
    </div>
</section>
