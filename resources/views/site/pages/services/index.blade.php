@extends('site.layouts.app')
@section('title', __('athar.services.title'))
@section('content')
@include('site.includes.page-hero',['title'=>__('athar.services.title'),'kicker'=>__('athar.services.kicker'),'intro'=>__('athar.services.intro')])
<section class="section"><div class="container"><div class="section-head"><span class="eyebrow">{{ __('athar.nav.services') }}</span><h2>{{ __('athar.home.services_title') }}</h2><p>{{ __('athar.home.services_copy') }}</p></div><div class="grid grid--4">
@forelse($categories as $category) @php($trans=$category->transNow)
<article class="card service-category-card" data-reveal>@if($category->image)<img src="{{ asset($category->pathInView()) }}" alt="{{ $trans->title ?? '' }}" loading="lazy">@endif<div class="card-body"><span class="icon-box">{{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</span><h3>{{ $trans->title ?? __('athar.fallback.service') }}</h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($trans->description ?? __('athar.fallback.service_copy')),150) }}</p>@if($category->services->isNotEmpty())<ul class="service-list">@foreach($category->services->take(5) as $service)<li>{{ $service->transNow->title ?? '' }}</li>@endforeach</ul>@endif<a class="card-link" href="{{ route('site.services.show',$trans->slug ?? $category->id) }}">{{ app()->getLocale()==='ar' ? 'عرض خدمات التصنيف' : 'View category services' }}</a></div></article>
@empty <div class="empty-state">{{ __('athar.services.empty') }}</div> @endforelse
</div></div></section>
<section class="section section--dark"><div class="container"><div class="section-head"><span class="eyebrow">{{ __('athar.home.process_title') }}</span><h2>{{ __('athar.home.process_title') }}</h2></div><div class="steps">@foreach(__('athar.steps') as $step)<div class="step"><h3>{{ $step }}</h3><p>{{ __('athar.home.process_copy') }}</p></div>@endforeach</div></div></section>
@if($partners->count())<section class="section section--compact"><div class="container"><div class="partners">@foreach($partners as $partner)<img src="{{ asset($partner->pathInView()) }}" alt="{{ $partner->title ?? '' }}" loading="lazy">@endforeach</div></div></section>@endif
@endsection
