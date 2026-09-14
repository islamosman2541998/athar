@extends('site.layouts.app')
@section('title', __('athar.contact.title'))
@section('content')
@include('site.includes.page-hero',['title'=>__('athar.contact.title'),'kicker'=>__('athar.contact.kicker'),'intro'=>__('athar.contact.intro'),'image'=>asset('site/images/athar-team.png')])
<section class="section"><div class="container split">
<div class="form-card" data-reveal><h2>{{ __('athar.contact.form') }}</h2><p class="muted">{{ __('athar.contact.intro') }}</p>@if(session('success'))<div class="alert alert--success">{{ session('success') }}</div>@endif @if($errors->any())<div class="alert alert--error">{{ $errors->first() }}</div>@endif
<form method="post" action="{{ route('site.contact.store') }}" class="form-grid">@csrf
<div class="field"><label>{{ __('athar.contact.name') }} *</label><input name="name" value="{{ old('name') }}" required autocomplete="name"></div>
<div class="field"><label>{{ __('athar.contact.company') }}</label><input name="company" value="{{ old('company') }}" autocomplete="organization"></div>
<div class="field"><label>{{ __('athar.contact.email') }} *</label><input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"></div>
<div class="field"><label>{{ __('athar.contact.phone') }}</label><input type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel"></div>
<div class="field field--wide"><label>{{ __('athar.contact.subject') }}</label><input name="subject" value="{{ old('subject') }}"></div>
<div class="field field--wide"><label>{{ __('athar.contact.message') }}</label><textarea name="message">{{ old('message') }}</textarea></div>
<div class="field field--wide"><button class="btn btn--green btn--block" type="submit">{{ __('athar.contact.send') }}</button></div>
</form></div>
@php
    $settings = \App\Settings\SettingSingleton::getInstance();
    $contactEmail = $settings->getItem('email') ?: 'info@athar.com';
    $contactPhone = $settings->getItem('mobile_ksa');
    $contactPhoneLink = $contactPhone ? '+' . ltrim(preg_replace('/[^\d+]/', '', $contactPhone), '+') : null;
@endphp
<div data-reveal>
    <div class="section-head" style="text-align:start;margin-inline:0"><span class="eyebrow">{{ __('athar.contact.kicker') }}</span><h2>{{ __('athar.contact.title') }}</h2></div>
    <div class="contact-cards">
        <div class="contact-card">
            <span class="icon-box">@include('site.includes.icon', ['name' => 'mail'])</span>
            <strong>{{ __('athar.contact.email') }}</strong>
            <a href="mailto:{{ $contactEmail }}" dir="ltr">{{ strtolower($contactEmail) }}</a>
        </div>
        @if($contactPhone)
            <div class="contact-card">
                <span class="icon-box">@include('site.includes.icon', ['name' => 'phone'])</span>
                <strong>{{ __('athar.contact.phone') }}</strong>
                <a href="tel:{{ $contactPhoneLink }}" dir="ltr">{{ $contactPhoneLink }}</a>
            </div>
        @endif
    </div>
    @include('site.includes.socials', ['wrapperClass' => 'contact-socials'])
</div>
</div></section>
@endsection
