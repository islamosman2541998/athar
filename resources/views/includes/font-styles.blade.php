{{-- Fonts chosen in Dashboard > Settings > Fonts. Usage: @include('includes.font-styles', ['scope' => 'site'|'admin']) --}}
@php
    $selectedFonts = \App\Support\FontOptions::selected();
    $fontStack = \App\Support\FontOptions::stack($selectedFonts);
@endphp
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="{{ \App\Support\FontOptions::stylesheetUrl($selectedFonts) }}">
<style>
    :root { --app-font: {!! $fontStack !!}; --bs-font-sans-serif: var(--app-font); --bs-body-font-family: var(--app-font); }
    @if(($scope ?? 'site') === 'admin')
    body, h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, p, a, label, button, input, select, textarea, table, th, td, .btn, .form-control, .form-select, .dropdown-menu, .tooltip, .popover, .modal, .page-title, .card-title, .select2-container, .select2-results, .navbar-custom, .vertical-menu, #sidebar-menu, .mini-stat-info span { font-family: var(--app-font) !important; }
    @else
    body { font-family: var(--app-font); }
    @endif
</style>
