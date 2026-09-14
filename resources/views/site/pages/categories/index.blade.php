@extends('site.layouts.app')
@section('title', app()->getLocale()==='ar'?'التصنيفات':'Categories')
@section('content')
@include('site.includes.page-hero',['title'=>app()->getLocale()==='ar'?'التصنيفات':'Categories','kicker'=>__('athar.services.kicker')])
<section class="section"><div class="container"><div class="grid grid--3">@forelse($categories as $category) @php($trans=$category->transNow)<article class="card"><div class="card-body"><span class="icon-box">◈</span><h3>{{ $trans->title ?? '' }}</h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($trans->description ?? ''),140) }}</p><a class="card-link" href="{{ route('site.categories.show',$trans->slug ?? $category->id) }}">{{ __('athar.more') }}</a></div></article>@empty<div class="empty-state">{{ __('athar.services.empty') }}</div>@endforelse</div></div></section>
@endsection
