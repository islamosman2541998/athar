@extends('site.layouts.app')
@php($trans=$blog->transNow)
@section('title', $trans->meta_title ?? $trans->title ?? __('athar.blog.title'))
@section('meta_description', strip_tags($trans->meta_description ?? \Illuminate\Support\Str::limit($trans->description ?? '',150)))
@section('content')
@include('site.includes.page-hero',['title'=>$trans->title ?? __('athar.fallback.blog'),'kicker'=>__('athar.blog.kicker')])
<section class="section"><div class="container article-layout"><article class="article-main"><img class="article-cover" src="{{ $blog->pathInView() !== 'attachments/no_image/no_image.png' ? asset($blog->pathInView()) : asset('site/images/athar-devices.png') }}" alt="{{ $trans->title ?? '' }}"><div class="article-meta">{{ $blog->created_at?->translatedFormat('d F Y') }}</div><div class="rich-text">{!! $trans->description ?? '' !!}</div></article><aside class="sidebar-card"><h3>{{ __('athar.footer.links') }}</h3><ul class="sidebar-links"><li><a href="{{ route('site.site.blogs.index') }}">{{ __('athar.blog.title') }} <span>←</span></a></li><li><a href="{{ route('site.services.index') }}">{{ __('athar.services.title') }} <span>←</span></a></li><li><a href="{{ route('site.contact-us') }}">{{ __('athar.contact.title') }} <span>←</span></a></li></ul><a class="btn btn--green btn--block" style="margin-top:24px" href="{{ route('site.service_request.index') }}">{{ __('athar.request') }}</a></aside></div></section>
@endsection
