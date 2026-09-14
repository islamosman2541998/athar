@php
    $settings = \App\Settings\SettingSingleton::getInstance();
    $logo = $settings->getItem(app()->getLocale() === 'en' ? 'logo_en' : 'logo_ar') ?: $settings->getItem('logo');
    $active = fn (...$names) => request()->routeIs($names) ? 'active' : '';
    $companyProfile = $settings->getItem('company_profile');
@endphp
<header class="site-header">
    <div class="container nav">
        <a class="brand" href="{{ route('site.home') }}" aria-label="{{ __('athar.brand') }}">
            @if($logo)
                <img src="{{ asset($logo) }}" alt="{{ __('athar.brand') }}">
            @else
                <span class="brand-fallback"><span class="brand-symbol">↗</span><span>{{ __('athar.brand') }}<small>{{ __('athar.tagline') }}</small></span></span>
            @endif
        </a>
        <button class="menu-toggle" type="button" aria-label="Menu" aria-expanded="false">☰</button>
        <ul class="nav-links">
            @forelse($mainMenus as $menu)
                @include('site.includes.menu-item', ['menu' => $menu])
            @empty
                <li><a class="{{ $active('site.home') }}" href="{{ route('site.home') }}">{{ __('athar.nav.home') }}</a></li>
                <li><a class="{{ $active('site.services.*') }}" href="{{ route('site.services.index') }}">{{ __('athar.nav.services') }}</a></li>
                <li><a class="{{ $active('site.portfolio.*') }}" href="{{ route('site.portfolio.index') }}">{{ __('athar.nav.work') }}</a></li>
            @endforelse
            @if($companyProfile)
                {{-- The only navbar link that opens in a new tab: the uploaded company profile PDF --}}
                <li class="nav-item"><a class="nav-profile" href="{{ asset($companyProfile) }}" target="_blank" rel="noopener">{{ __('athar.nav.profile') }}</a></li>
            @endif
        </ul>
        <div class="nav-actions">
            <a class="btn btn--gold" href="{{ route('site.service_request.index') }}">{{ __('athar.request') }} <span aria-hidden="true">←</span></a>
            <span class="locale-switch">
                @foreach(['ar','en'] as $locale)
                    <a class="{{ app()->getLocale() === $locale ? 'active' : '' }}" href="{{ LaravelLocalization::getLocalizedURL($locale) }}" hreflang="{{ $locale }}">{{ strtoupper($locale) }}</a>
                @endforeach
            </span>
        </div>
    </div>
</header>
