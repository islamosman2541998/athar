@foreach (!empty(@$searchItem ) && $first == true ? @$searchItem : $items->where('parent_id', $parent_id ?? 0)  as $item)
@php
    $totalChildren = $items->where('parent_id', $item->id)->count();
    $first = false;
@endphp
@if ($totalChildren)
    <li>
        <div class="toggler p-1 @if(@$item_parent_id == $item->id  || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) ) active @endif @if(@$item->id == @$menu->id || @$item_parent_id == $item->id) active  current @endif">
            <i class="far fa-folder"></i>
            {{ optional( $item->trans)->where('locale', $current_lang)->first()->title }} 
        </div>
    
        <ul class="toggler-target @if(@$item_parent_id == $item->id  || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) ) active @endif @if(@$item->id == @$menu->id || @$item_parent_id == $item->id) active  current @endif">
            @include('admin/dashboard/footer-menus/tree', ['parent_id' => $item->id])
        </ul>
    </li>    
@else
    <li class="todo  @if(@$item_parent_id == $item->id  || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) || in_array(@$item->id ?? [], @$menu_parent_ids ?? []) ) active @endif @if(@$item->id == @$menu->id || @$item_parent_id == $item->id) active  current @endif">
        <i class="far fa-file"></i>
        {{ optional( $item->trans)->where('locale', $current_lang)->first()->title }}
    </li>
@endif
@endforeach
