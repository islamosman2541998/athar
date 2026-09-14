<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title', __('athar.tagline')) | {{ __('athar.brand') }}</title>
    <meta name="description" content="@yield('meta_description', __('athar.home.intro'))">
    <meta name="theme-color" content="#0b3029">
    <link rel="canonical" href="{{ url()->current() }}">
    @php($siteIcon = \App\Settings\SettingSingleton::getInstance()->getItem('icon'))
    @if($siteIcon)
        <link rel="icon" type="image/png" href="{{ asset($siteIcon) }}">
        <link rel="apple-touch-icon" href="{{ asset($siteIcon) }}">
    @endif
    <link rel="preload" as="image" href="{{ asset('site/images/athar-hero.png') }}">
    <link rel="stylesheet" href="{{ asset('site/css/athar.css') }}?v=1.6.7">
    @include('includes.font-styles', ['scope' => 'site'])
    @stack('head')
</head>
<body>
    @include('site.includes.header')
    <main>@yield('content')</main>
    @include('site.includes.cta')
    @include('site.includes.footer')
    <script src="{{ asset('site/js/athar.js') }}?v=1.6.7" defer></script>
    @stack('scripts')
</body>
</html>
