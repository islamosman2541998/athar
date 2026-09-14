<tr
    style="background-color:{{ $item->position == App\Enums\MenuPositionEnums::MAIN ? '#72726957' : '' }}{{ $item->position == App\Enums\MenuPositionEnums::FOOTER ? '#98d9e1a1' : '' }}">
    <td>
        <input type="checkbox" class="checkbox-check" wire:click="updateSellected({{ $item->id }})"
            wire:model="mySelected" value="{{ $item->id }}"
            {{ in_array($mySelected, [$item->id]) ? 'selected' : '' }}>
    </td>
    <td>{{ $index }}</td>
    <td>
        @if ($item->level != null)
            {{ str_repeat('ـــ ', $item->level - 1) }}
        @endif

        {{ $item->trans->where('locale', $current_lang)->first()->title }} <br>

    </td>
    <td>
        @if ($item->type == App\Enums\MunesEnums::DYNAMIC)
            <a href="{{ @$item->dynamic_url }}" target="_blank" class="text-info">{{ $item->dynamic_url }} <i
                    class="fas fa-external-link-alt"></i> </a>
        @elseif ($item->type == App\Enums\MunesEnums::STATIC)
            <a href="{{ @$item->url }}" target="_blank" class="text-info">{{ @$item->url }} <i
                    class="fas fa-external-link-alt"></i> </a>
        @endif
    </td>
    <td style="width: 20%;">
        <div class="row">
            <div class="col-md-6 mt-1">
                <input type="number" name="sort" wire:model="sort" class="form-control">
            </div>

            <div class="col-md-2 mt-1">
                <span wire:click="update_sort({{ $item->id }})" class="btn btn-primary">@lang('admin.change')</span>
            </div>
        </div>
    </td>
    <td>{{ $item->position }}</td>


    <td>{{ $item->created_at }}</td>
    <td>{{ $item->updated_at }}</td>
    <td>
        <div class="d-flex justify-content-center">
            @can('admin.menus.update-status')
                @if ($item->status == 1)
                    <a title="@lang('admin.active')" class="btn btn-xs btn-success btn-sm m-1"
                        wire:click="update_status({{ $item->id }})"><i class="fa fa-check"></i></a>
                @else
                    <a title="@lang('admin.dis_active')" class="btn btn-xs btn-outline-secondary btn-sm m-1"
                        wire:click="update_status({{ $item->id }})"><i class="fa fa-ban"></i></a>
                @endif
            @endcan

            {{-- @if ($item->feature == 1)
                <a title="@lang('admin.feature')"  class="btn btn-xs btn-success btn-sm m-1" wire:click="update_featured({{ $item->id }})"><i class="fa fa-star"></i></a>
            @else
                <a title="@lang('admin.feature')"  class="btn btn-xs btn-outline-warning btn-sm m-1" wire:click="update_featured({{ $item->id }})"><i class="fa fa-star"></i></a>
            @endif --}}

            <a title="@lang('admin.show')" href="{{ route('admin.menus.show', $item->id) }}"
                class="btn btn-xs btn-outline-info btn-sm m-1"><i class="fas fa-eye"></i></a>


            <a title="@lang('admin.edit')" href="{{ route('admin.menus.edit', $item->id) }}"
                class="btn btn-outline-primary btn-sm m-1"><i class="fas fa-pencil-alt"></i></a>

            @can('admin.menus.destroy')
                <button type="button" wire:click="deleteId({{ $item->id }})"
                    class="btn btn-outline-danger btn-sm m-1"data-bs-toggle="modal" data-bs-target="#exampleModalLabel">
                    <i class="fa fa-trash"></i>
                </button>
            @endcan


        </div>

    </td>
</tr>
