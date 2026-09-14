@php
    $settings = \App\Settings\SettingSingleton::getInstance();
    $phones =  $settings->getItem('mobile_ksa');
    $email = $settings->getItem('email') ?: 'info@athar.com';
    $address = $settings->getItem('address_ksa');
    $whatsapp = preg_replace('/\D+/', '', (string) ($settings->getItem('whatsapp') ?: $phones));
    $footerLogo = $settings->getItem(app()->getLocale() === 'en' ? 'logo_en' : 'logo_ar') ?: $settings->getItem('logo');

    // Flatten the dashboard footer menu (parents + their children) and drop repeated links.
    $flattenMenu = function ($items) use (&$flattenMenu) {
        return $items->flatMap(fn ($item) => collect([$item])->merge($flattenMenu($item->childrenRecursive ?? collect())));
    };
    $footerLinks = $flattenMenu($footerMenus)
        ->filter(fn ($item) => $item->current_title !== '' && $item->resolved_url !== '#')
        ->unique(fn ($item) => $item->resolved_url)
        ->values();
@endphp
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            {{-- Brand --}}
            <div class="footer-col footer-col--brand">
                <a class="brand footer-brand" href="{{ route('site.home') }}" aria-label="{{ __('athar.brand') }}">
                    @if($footerLogo)
                        <img src="{{ asset($footerLogo) }}" alt="{{ __('athar.brand') }}">
                    @else
                        <span class="brand-fallback"><span class="brand-symbol">↗</span><span>{{ __('athar.brand') }}<small>{{ __('athar.tagline') }}</small></span></span>
                    @endif
                </a>
                <p class="footer-about">{{ __('athar.footer.about') }}</p>
                <a class="btn btn--gold footer-cta" href="{{ route('site.service_request.index') }}">{{ __('athar.start') }}</a>
            </div>

            {{-- Contact --}}
            <div class="footer-col footer-col--contact">
                <h3 class="footer-title">{{ __('athar.footer.contact') }}</h3>
                <ul class="footer-contact">
                    @if($email)
                        <li><span class="footer-contact__icon">@include('site.includes.icon', ['name' => 'mail'])</span><a href="mailto:{{ $email }}" dir="ltr">{{ strtolower($email) }}</a></li>
                    @endif
                    @if($phones)
                        <li><span class="footer-contact__icon">@include('site.includes.icon', ['name' => 'phone'])</span><a href="tel:{{ $phones }}" dir="ltr">{{ $phones }}</a></li>
                    @endif                          
                    @if($address)
                        <li><span class="footer-contact__icon">@include('site.includes.icon', ['name' => 'map-pin'])</span><span>{{ $address }}</span></li>
                    @endif
                   
                </ul>
                @include('site.includes.socials')
            </div>

            {{-- Dashboard footer menu --}}
            <div class="footer-col">
                <h3 class="footer-title">{{ __('athar.footer.links') }}</h3>
                <ul class="footer-list">
                    @forelse($footerLinks as $link)
                        <li><a href="{{ $link->resolved_url }}">{{ $link->current_title }}</a></li>
                    @empty
                        <li><a href="{{ route('site.home') }}">{{ __('athar.nav.home') }}</a></li>
                        <li><a href="{{ route('site.about-us') }}">{{ __('athar.nav.about') }}</a></li>
                        <li><a href="{{ route('site.portfolio.index') }}">{{ __('athar.nav.work') }}</a></li>
                        <li><a href="{{ route('site.contact-us') }}">{{ __('athar.nav.contact') }}</a></li>
                    @endforelse
                </ul>
            </div>

            {{-- Services --}}
            <div class="footer-col">
                <h3 class="footer-title">{{ __('athar.footer.services') }}</h3>
                <ul class="footer-list">
                    @foreach($footerServices as $service)
                        @php($trans = $service->transNow)
                        <li><a href="{{ route('site.services.show', $trans->slug ?? $service->id) }}">{{ $trans->title ?? __('athar.fallback.service') }}</a></li>
                    @endforeach
                    <li><a class="footer-list__more" href="{{ route('site.services.index') }}">{{ __('athar.home.all_services') }}</a></li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            <span>© {{ date('Y') }} {{ __('athar.brand') }} — {{ __('athar.footer.rights') }}</span>
            <span>{{ __('athar.tagline') }}</span>
        </div>
    </div>
</footer>
@if($whatsapp)
<a class="floating-contact" href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener" aria-label="WhatsApp">
    <svg viewBox="0 0 32 32" aria-hidden="true" focusable="false">
        <path fill="currentColor" d="M16.04 3A12.9 12.9 0 0 0 5.1 22.73L3.4 29l6.42-1.68A12.96 12.96 0 1 0 16.04 3Zm0 2.18a10.77 10.77 0 1 1-5.49 20.04l-.39-.23-3.8 1 1.01-3.7-.25-.4a10.76 10.76 0 0 1 8.92-16.71Zm-5.08 4.78c-.25 0-.66.1-1 .48-.35.38-1.32 1.29-1.32 3.14s1.35 3.64 1.54 3.9c.19.25 2.65 4.05 6.43 5.68.9.39 1.6.62 2.15.79.9.28 1.72.24 2.37.15.72-.11 2.22-.91 2.53-1.79.31-.88.31-1.64.22-1.79-.09-.16-.34-.25-.72-.44-.38-.19-2.22-1.1-2.56-1.22-.35-.13-.6-.19-.85.19-.25.38-.97 1.22-1.19 1.47-.22.25-.44.28-.82.09-.38-.19-1.6-.59-3.05-1.88a11.43 11.43 0 0 1-2.11-2.63c-.22-.38-.02-.59.17-.78.17-.17.38-.44.57-.66.19-.22.25-.38.38-.63.12-.25.06-.47-.03-.66-.1-.19-.85-2.06-1.17-2.82-.3-.74-.62-.64-.85-.65h-.72Z"/>
    </svg>
</a>
@endif
