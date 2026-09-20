@extends('site.layouts.app')
@section('title', __('athar.products.title'))
@section('content')
@include('site.includes.page-hero',['title'=>__('athar.products.title'),'kicker'=>__('athar.services.kicker')])
<section class="section"><div class="container">@forelse($categories as $category)<div class="section-head"><span class="eyebrow">{{ optional($category->transNow)->title }}</span><h2>{{ optional($category->transNow)->title }}</h2></div><div class="grid grid--3" style="margin-bottom:56px">@foreach($category->products as $product) @php($trans=$product->transNow)<article class="card"><img src="{{ media_asset($product->pathInView()) }}" alt="{{ $trans->title ?? '' }}" style="height:240px;width:100%;object-fit:cover" onerror="this.src='{{ media_asset('site/images/athar-devices.png') }}'"><div class="card-body"><h3>{{ $trans->title ?? '' }}</h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($trans->description ?? ''),130) }}</p><a class="card-link" href="{{ route('site.products.show',$trans->slug ?? $product->id) }}">{{ __('athar.more') }}</a></div></article>@endforeach</div>@empty<div class="empty-state">{{ __('athar.services.empty') }}</div>@endforelse</div></section>
@endsection
