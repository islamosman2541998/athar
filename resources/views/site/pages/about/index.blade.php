@extends('site.layouts.app')
@php($trans=$about?->transNow)
@section('title', $trans->title ?? __('athar.about.title'))
@section('content')
@include('site.includes.page-hero',['title'=>__('athar.about.title'),'kicker'=>__('athar.about.kicker'),'intro'=>strip_tags($trans->sub_description ?? __('athar.home.why_copy')),'image'=>asset('site/images/athar-team.png')])
<section class="section"><div class="container split"><div class="feature-copy" data-reveal><span class="eyebrow">{{ __('athar.about.story') }}</span><h2>{{ $trans->our_story_title ?? $trans->subtitle ?? __('athar.home.why') }}</h2><div class="rich-text">{!! $trans->our_story_description ?? $trans->description ?? __('athar.home.why_copy') !!}</div></div><div class="feature-image" data-reveal><img src="{{ asset($about?->imageInView() ?? 'site/images/athar-devices.png') }}" alt="{{ $trans->title ?? __('athar.about.title') }}"></div></div></section>
<section class="section section--dark about-pillars-section">
    <div class="container">
        <div class="about-pillars">
            @foreach([
                ['icon' => 'eye', 'title' => __('athar.about.vision'), 'content' => $trans->vision ?? __('athar.home.why_copy')],
                ['icon' => 'target', 'title' => __('athar.about.mission'), 'content' => $trans->mission ?? __('athar.home.services_copy')],
            ] as $pillar)
                <article class="pillar-card" data-reveal>
                    <div class="pillar-card__head">
                        <span class="pillar-card__icon">@include('site.includes.icon', ['name' => $pillar['icon'], 'class' => ''])</span>
                        <h2>{{ $pillar['title'] }}</h2>
                    </div>
                    <div class="pillar-card__text">{!! $pillar['content'] !!}</div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
