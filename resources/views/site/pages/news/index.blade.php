@extends('site.layouts.app')
@section('title', app()->getLocale()==='ar'?'الأخبار':'News')
@section('content')
@include('site.includes.page-hero',['title'=>app()->getLocale()==='ar'?'الأخبار':'News','kicker'=>__('athar.blog.kicker'),'intro'=>__('athar.blog.intro')])
<section class="section"><div class="container"><div class="grid grid--3">@forelse($news as $item) @php($trans=$item->transNow)<article class="card"><img src="{{ asset($item->pathInView()) }}" alt="{{ $trans->title ?? '' }}" style="height:240px;width:100%;object-fit:cover"><div class="card-body"><span class="tag">{{ $item->created_at?->format('Y.m.d') }}</span><h3>{{ $trans->title ?? '' }}</h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($trans->description ?? ''),140) }}</p><a class="card-link" href="{{ route('site.news.show',$item) }}">{{ __('athar.more') }}</a></div></article>@empty<div class="empty-state">{{ __('athar.blog.empty') }}</div>@endforelse</div></div></section>
@endsection
