@extends('site.layouts.app')
@php($trans=$category->transNow)
@section('title', $trans->title ?? '')
@section('content')
@include('site.includes.page-hero',['title'=>$trans->title ?? '','kicker'=>__('athar.services.kicker'),'intro'=>strip_tags($trans->description ?? '')])
<section class="section"><div class="container"><div class="grid grid--3">@forelse($category->products as $product) @php($pt=$product->transNow)<article class="card"><img src="{{ media_asset($product->pathInView()) }}" alt="{{ $pt->title ?? '' }}" style="height:240px;width:100%;object-fit:cover" onerror="this.src='{{ media_asset('site/images/athar-devices.png') }}'"><div class="card-body"><h3>{{ $pt->title ?? '' }}</h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($pt->description ?? ''),130) }}</p><a class="card-link" href="{{ route('site.products.show',$pt->slug ?? $product->id) }}">{{ __('athar.more') }}</a></div></article>@empty<div class="empty-state">{{ __('athar.services.empty') }}</div>@endforelse</div></div></section>
@endsection
