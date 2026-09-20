@extends('site.layouts.app')
@section('title', __('athar.jobs.title'))
@section('content')
@include('site.includes.page-hero',['title'=>__('athar.jobs.title'),'kicker'=>__('athar.about.kicker'),'intro'=>__('athar.jobs.intro'),'image'=>media_asset('site/images/athar-team.png')])
<section class="section"><div class="container"><div class="grid grid--3">@forelse($jobs as $job) @php($trans=$job->transNow)<article class="card"><div class="card-body"><span class="tag">{{ $job->employment_type }}</span><h3>{{ $trans->title ?? '' }}</h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($trans->short_description ?? $trans->description ?? ''),150) }}</p><a class="card-link" href="{{ route('site.jobs.show',$trans->slug) }}">{{ __('athar.jobs.apply') }}</a></div></article>@empty <div class="empty-state">{{ __('athar.jobs.empty') }}</div>@endforelse</div>{{ $jobs->onEachSide(1)->links('site.includes.pagination') }}</div></section>
@endsection
