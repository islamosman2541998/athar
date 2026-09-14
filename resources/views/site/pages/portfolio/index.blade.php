@extends('site.layouts.app')
@section('title', __('athar.portfolio.title'))
@section('content')
@include('site.includes.page-hero',['title'=>__('athar.portfolio.title'),'kicker'=>__('athar.portfolio.kicker'),'intro'=>__('athar.portfolio.intro'),'image'=>asset('site/images/athar-devices.png')])
<section class="section">
    <div class="container">
        @if($tags->count())
            <div class="filter-bar">
                <a class="filter-btn {{ $activeTag ? '' : 'active' }}" href="{{ route('site.portfolio.index') }}">{{ __('athar.all') }}</a>
                @foreach($tags as $tag)
                    <a class="filter-btn {{ $activeTag === $tag->id ? 'active' : '' }}" href="{{ route('site.portfolio.index', ['tag' => $tag->id]) }}">{{ optional($tag->transNow)->title ?? __('athar.nav.work') }}</a>
                @endforeach
            </div>
        @endif

        <div class="portfolio-home-grid portfolio-list-grid">
            @forelse($portfolios as $portfolio)
                @include('site.includes.portfolio-card', ['portfolio' => $portfolio])
            @empty
                <div class="empty-state">{{ __('athar.portfolio.empty') }}</div>
            @endforelse
        </div>

        {{ $portfolios->onEachSide(1)->links('site.includes.pagination') }}
    </div>
</section>
@if($portfolios->isNotEmpty()) @include('site.includes.media-viewer') @endif
@endsection
