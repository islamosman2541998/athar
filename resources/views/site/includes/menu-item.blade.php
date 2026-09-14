@php
    $children = $menu->childrenRecursive ?? collect();
    $hasChildren = $children->isNotEmpty();
@endphp
<li class="nav-item {{ $hasChildren ? 'has-submenu' : '' }}">
    <a href="{{ $menu->resolved_url }}">
        {{ $menu->current_title }}
    </a>
    @if($hasChildren)
        <button class="submenu-toggle" type="button" aria-expanded="false" aria-label="{{ $menu->current_title }}">@include('site.includes.icon', ['name' => 'chevron-down', 'stroke' => 2.4])</button>
        <ul class="submenu">
            @foreach($children as $menu)
                @include('site.includes.menu-item', ['menu' => $menu])
            @endforeach
        </ul>
    @endif
</li>
