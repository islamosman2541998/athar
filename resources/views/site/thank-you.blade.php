@extends('site.layouts.app')
@section('title', app()->getLocale()==='ar'?'شكرًا لك':'Thank you')
@section('content')
<section class="hero page-hero" style="background-image:url('{{ asset('site/images/athar-hero.png') }}')"><div class="container"><div class="hero-content" style="text-align:center;margin-inline:auto"><span class="hero-kicker">✓</span><h1>{{ app()->getLocale()==='ar'?'شكرًا لتواصلك معنا':'Thank you for contacting us' }}</h1><p>{{ session('success',__('athar.form.success')) }}</p><a class="btn btn--gold" href="{{ route('site.home') }}">{{ __('athar.nav.home') }}</a></div></div></section>
@endsection
