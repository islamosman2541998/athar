@extends('site.layouts.app')
@php($categoryTrans=$category->transNow)
@section('title', $categoryTrans->meta_title ?? $categoryTrans->title ?? __('athar.services.title'))
@section('meta_description', strip_tags($categoryTrans->meta_description ?? $categoryTrans->description ?? __('athar.services.intro')))
@section('content')
@include('site.includes.page-hero',['title'=>$categoryTrans->title ?? __('athar.services.title'),'kicker'=>__('athar.services.kicker'),'intro'=>strip_tags($categoryTrans->description ?? __('athar.services.intro'))])
<section class="section"><div class="container"><div class="section-head"><span class="eyebrow">{{ __('athar.nav.services') }}</span><h2>{{ app()->getLocale()==='ar' ? 'خدمات متكاملة لبناء حضورك الرقمي' : 'Connected services for your digital presence' }}</h2></div><div class="grid grid--3">
@forelse($services as $service) @php($trans=$service->transNow)
<article class="card" data-reveal><div class="card-body"><span class="icon-box">{{ str_pad($loop->iteration,2,'0',STR_PAD_LEFT) }}</span><h3>{{ $trans->title ?? __('athar.fallback.service') }}</h3><div class="rich-text">{!! $trans->description ?? __('athar.fallback.service_copy') !!}</div>@if($trans?->content)<details style="margin-top:14px"><summary class="card-link" style="cursor:pointer">{{ __('athar.more') }}</summary><div class="rich-text">{!! $trans->content !!}</div></details>@endif<a class="btn btn--green" style="margin-top:20px" href="{{ route('site.service_request.index',['service'=>$category->id]) }}">{{ __('athar.request') }}</a></div></article>
@empty <div class="empty-state">{{ __('athar.services.empty') }}</div> @endforelse
</div></div></section>
@endsection
