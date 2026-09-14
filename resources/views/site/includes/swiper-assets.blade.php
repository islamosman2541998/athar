@once
    @push('head')
        <link rel="stylesheet" href="{{ asset('site/vendor/swiper/swiper-bundle.min.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('site/vendor/swiper/swiper-bundle.min.js') }}" defer></script>
    @endpush
@endonce
