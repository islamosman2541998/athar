@once
    @push('head')
        {{-- Sliders sit below the fold, so their stylesheet must not block the first paint. --}}
        <link rel="stylesheet" href="{{ asset('site/vendor/swiper/swiper-bundle.min.css') }}" media="print" onload="this.media='all';this.onload=null">
        <noscript><link rel="stylesheet" href="{{ asset('site/vendor/swiper/swiper-bundle.min.css') }}"></noscript>
    @endpush
    @push('scripts')
        <script src="{{ asset('site/vendor/swiper/swiper-bundle.min.js') }}" defer></script>
    @endpush
@endonce
