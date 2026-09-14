@php($blogsSection = $homeSections->get('blogs')?->transNow)
@include('site.includes.swiper-assets')

<section class="section home-articles-section">
    <div class="container">
        <div class="section-heading-row" data-reveal>
            <div class="section-head">
                <span class="eyebrow">{{ $blogsSection->sub_title ?? __('athar.nav.blog') }}</span>
                <h2>{{ $blogsSection->title ?? __('athar.home.blogs_title') }}</h2>
                <p>{{ strip_tags($blogsSection->description ?? '') }}</p>
            </div>
            <a class="section-inline-link" href="{{ route('site.site.blogs.index') }}">{{ __('athar.home.all_articles') }}</a>
        </div>

        <div class="blogs-slider" data-blogs-swiper data-prev-label="{{ __('athar.previous') }}" data-next-label="{{ __('athar.next') }}">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @forelse($blogs as $blog)
                        @php($trans = $blog->transNow)
                        <div class="swiper-slide">
                            <article class="article-slide card">
                                <img src="{{ $blog->pathInView() !== 'attachments/no_image/no_image.png' ? asset($blog->pathInView()) : asset('site/images/athar-devices.png') }}" alt="{{ $trans->title ?? __('athar.fallback.blog') }}" loading="lazy" draggable="false">
                                <div class="card-body">
                                    <span class="tag">{{ $blog->created_at?->format('Y.m.d') }}</span>
                                    <h3>{{ $trans->title ?? __('athar.fallback.blog') }}</h3>
                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($trans->description ?? ''), 105) }}</p>
                                    <a class="card-link" href="{{ route('site.site.blogs.show', $blog) }}">{{ __('athar.more') }}</a>
                                </div>
                            </article>
                        </div>
                    @empty
                        @foreach(range(1, 3) as $i)
                            <div class="swiper-slide">
                                <article class="article-slide card">
                                    <img src="{{ asset('site/images/athar-devices.png') }}" alt="">
                                    <div class="card-body">
                                        <span class="tag">{{ __('athar.nav.blog') }}</span>
                                        <h3>{{ __('athar.fallback.blog') }}</h3>
                                        <p>{{ __('athar.blog.intro') }}</p>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    @endforelse
                </div>
            </div>

            <button class="slider-arrow slider-arrow--prev" type="button" data-swiper-prev aria-label="{{ __('athar.previous') }}">@include('site.includes.icon', ['name' => 'chevron-left'])</button>
            <button class="slider-arrow slider-arrow--next" type="button" data-swiper-next aria-label="{{ __('athar.next') }}">@include('site.includes.icon', ['name' => 'chevron-right'])</button>
            <div class="slider-pagination" data-swiper-pagination></div>
        </div>
    </div>
</section>
