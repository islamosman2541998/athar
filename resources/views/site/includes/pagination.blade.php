@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="{{ __('athar.pagination.label') }}">
        <ul class="pagination__list">
            {{-- Previous --}}
            <li>
                @if ($paginator->onFirstPage())
                    <span class="pagination__link pagination__link--arrow is-disabled" aria-disabled="true" aria-label="{{ __('athar.previous') }}">@include('site.includes.icon', ['name' => 'chevron-left'])</span>
                @else
                    <a class="pagination__link pagination__link--arrow" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('athar.previous') }}">@include('site.includes.icon', ['name' => 'chevron-left'])</a>
                @endif
            </li>

            {{-- Pages --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="pagination__link pagination__link--dots" aria-hidden="true">…</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            @if ($page == $paginator->currentPage())
                                <span class="pagination__link is-active" aria-current="page">{{ $page }}</span>
                            @else
                                <a class="pagination__link" href="{{ $url }}" aria-label="{{ __('athar.pagination.page', ['page' => $page]) }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            <li>
                @if ($paginator->hasMorePages())
                    <a class="pagination__link pagination__link--arrow" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('athar.next') }}">@include('site.includes.icon', ['name' => 'chevron-right'])</a>
                @else
                    <span class="pagination__link pagination__link--arrow is-disabled" aria-disabled="true" aria-label="{{ __('athar.next') }}">@include('site.includes.icon', ['name' => 'chevron-right'])</span>
                @endif
            </li>
        </ul>

        {{-- Compact list for small screens: first, current ±1, last --}}
        @php
            $current = $paginator->currentPage();
            $last = $paginator->lastPage();
            $compactPages = collect([1, $current - 1, $current, $current + 1, $last])
                ->filter(fn ($page) => $page >= 1 && $page <= $last)
                ->unique()
                ->sort()
                ->values();
        @endphp
        <ul class="pagination__list pagination__list--compact">
            <li>
                @if ($paginator->onFirstPage())
                    <span class="pagination__link pagination__link--arrow is-disabled" aria-disabled="true" aria-label="{{ __('athar.previous') }}">@include('site.includes.icon', ['name' => 'chevron-left'])</span>
                @else
                    <a class="pagination__link pagination__link--arrow" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('athar.previous') }}">@include('site.includes.icon', ['name' => 'chevron-left'])</a>
                @endif
            </li>
            @foreach ($compactPages as $index => $page)
                @if ($index > 0 && $page - $compactPages[$index - 1] > 1)
                    <li><span class="pagination__link pagination__link--dots" aria-hidden="true">…</span></li>
                @endif
                <li>
                    @if ($page == $current)
                        <span class="pagination__link is-active" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="pagination__link" href="{{ $paginator->url($page) }}" aria-label="{{ __('athar.pagination.page', ['page' => $page]) }}">{{ $page }}</a>
                    @endif
                </li>
            @endforeach
            <li>
                @if ($paginator->hasMorePages())
                    <a class="pagination__link pagination__link--arrow" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('athar.next') }}">@include('site.includes.icon', ['name' => 'chevron-right'])</a>
                @else
                    <span class="pagination__link pagination__link--arrow is-disabled" aria-disabled="true" aria-label="{{ __('athar.next') }}">@include('site.includes.icon', ['name' => 'chevron-right'])</span>
                @endif
            </li>
        </ul>

        <p class="pagination__summary">
            {{ __('athar.pagination.summary', ['from' => $paginator->firstItem(), 'to' => $paginator->lastItem(), 'total' => $paginator->total()]) }}
        </p>
    </nav>
@endif
