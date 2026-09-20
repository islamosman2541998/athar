@extends('site.layouts.app')
@php($trans=$news->transNow)
@section('title', $trans->meta_title ?? $trans->title ?? '')
@section('content')
@include('site.includes.page-hero',['title'=>$trans->title ?? '','kicker'=>app()->getLocale()==='ar'?'الأخبار':'News'])
<section class="section"><div class="container article-main"><img class="article-cover" src="{{ media_asset($news->pathInView()) }}" alt="{{ $trans->title ?? '' }}"><div class="article-meta">{{ $news->created_at?->translatedFormat('d F Y') }}</div><div class="rich-text">{!! $trans->content ?? $trans->description ?? '' !!}</div></div></section>
@endsection
