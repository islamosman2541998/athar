@extends('site.layouts.app')
@section('title', __('athar.faq.title'))
@section('content')
@include('site.includes.page-hero',['title'=>__('athar.faq.title'),'kicker'=>__('athar.contact.kicker'),'intro'=>__('athar.faq.intro')])
<section class="section"><div class="container" style="max-width:900px">@forelse($categories as $category)<div class="section-head" style="text-align:start;margin-inline:0"><span class="eyebrow">{{ optional($category->transNow)->title ?? __('athar.faq.title') }}</span></div>@forelse($category->faqs as $faq)<details class="card" style="margin-bottom:14px"><summary style="cursor:pointer;padding:20px 24px;font-weight:800">{{ optional($faq->transNow)->question }}</summary><div class="card-body rich-text" style="padding-top:0">{!! optional($faq->transNow)->answer !!}</div></details>@empty @endforelse @empty <div class="empty-state">{{ __('athar.faq.intro') }}</div>@endforelse</div></section>
@endsection
