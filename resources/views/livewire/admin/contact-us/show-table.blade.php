<tr>
    <td>
        <input type="checkbox" class="checkbox-check" wire:click="updateSellected({{ $item->id }})"
            wire:model="mySelected" value="{{ $item->id }}"
            {{ in_array($mySelected, [$item->id]) ? 'selected' : '' }}>
    </td>
    <td>{{ $index }}</td>
    <td> {!! @$item->name !!} </td>

    <td> {!! @$item->email !!} </td>
    <td> {{ @$item->phone }}</td>

    <td>
        {{ substr(removeHTML(@$item->message), 0, 30) }}
    </td>
    <td>
        <div class="d-flex justify-content-center">
            @can('admin.contact-us.read')
                @if ($item->status == 1)
                    <a title="@lang('admin.active')" class="btn btn-xs btn-success btn-sm m-1"
                        wire:click="update_status({{ $item->id }})"><i class="fa  fas fa-check-double"></i></a>
                @else
                    <a title="@lang('admin.dis_active')" class="btn btn-xs btn-outline-secondary btn-sm m-1"
                        wire:click="update_status({{ $item->id }})"><i class="fa  fas fa-check-double"></i></a>
                @endif
            @endcan

            <button type="button" class="btn btn-outline-primary btn-sm m-1" data-bs-toggle="modal"
                data-bs-target="#show{{ $item->id }}">
                <i class="fa fa-eye"></i></button>

            @can('admin.contact-us.destroy')
                <button type="button" wire:click="deleteId({{ $item->id }})"
                    class="btn btn-outline-danger btn-sm m-1"data-bs-toggle="modal" data-bs-target="#exampleModalLabel">
                    <i class="fa fa-trash"></i>
                </button>
            @endcan

        </div>

    </td>
</tr>
