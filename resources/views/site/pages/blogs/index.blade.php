@extends('site.layouts.app')
@section('title', __('athar.blog.title'))
@section('content')
@include('site.includes.page-hero',['title'=>__('athar.blog.title'),'kicker'=>__('athar.blog.kicker'),'intro'=>__('athar.blog.intro')])
<section class="section"><div class="container"><div class="grid grid--3">
@forelse($blogs as $blog) @php($trans=$blog->transNow) @php($img=$blog->pathInView())
<article class="card" data-reveal><img src="{{ $img !== 'attachments/no_image/no_image.png' ? asset($img) : media_asset('site/images/athar-devices.png') }}" alt="{{ $trans->title ?? __('athar.fallback.blog') }}" style="height:250px;width:100%;object-fit:cover" loading="lazy"><div class="card-body"><span class="tag">{{ $blog->created_at?->format('Y.m.d') }}</span><h3>{{ $trans->title ?? __('athar.fallback.blog') }}</h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($trans->description ?? ''),145) }}</p><a class="card-link" href="{{ route('site.site.blogs.show',$blog) }}">{{ __('athar.more') }}</a></div></article>
@empty <div class="empty-state">{{ __('athar.blog.empty') }}</div> @endforelse
</div></div></section>
@endsection
