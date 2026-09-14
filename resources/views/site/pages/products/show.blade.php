@extends('site.layouts.app')
@php($trans=$product->transNow)
@section('title', $trans->meta_title ?? $trans->title ?? '')
@section('content')
@include('site.includes.page-hero',['title'=>$trans->title ?? '','kicker'=>__('athar.services.kicker')])
<section class="section"><div class="container split"><div class="feature-image"><img src="{{ asset($product->pathInView()) }}" alt="{{ $trans->title ?? '' }}" onerror="this.src='{{ asset('site/images/athar-devices.png') }}'"></div><div class="feature-copy"><span class="eyebrow">{{ __('athar.tagline') }}</span><h2>{{ $trans->title ?? '' }}</h2><div class="rich-text">{!! $trans->description ?? '' !!}</div>@if($product->url)<a class="btn btn--green" href="{{ $product->url }}" target="_blank" rel="noopener">{{ __('athar.start') }}</a>@else<a class="btn btn--green" href="{{ route('site.service_request.index') }}">{{ __('athar.request') }}</a>@endif</div></div></section>
@endsection
