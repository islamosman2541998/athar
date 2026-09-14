<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="container">
                <div class="card-body">
                    {{-- Start Form search --}}
                    <div class="card-body  search-group">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <input type="test" value="{{ $search_name ?? '' }}" wire:model="search_name"
                                    placeholder="{{ trans('contact_us.search_name') }}" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="test" value="{{ $search_email ?? '' }}" wire:model="search_email"
                                    placeholder="{{ trans('contact_us.search_email') }}" class="form-control">
                            </div>
                            <div class="col-md-3 ">
                                <input type="test" value="{{ $search_phone ?? '' }}" wire:model="search_phone"
                                    placeholder="{{ trans('contact_us.search_phone') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    {{-- Start Form search --}}
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr class="bluck-actions" @if (empty($mySelected)) style="display: none" @endif
                                scope="row">
                                <td colspan="8">

                                    <div class="col-md-12 mt-0 mb-0 text-center">
                                        @can('admin.contact-us.destroy')
                                            <button wire:click.prevent="deleteSelected"
                                                @if (empty($mySelected)) disabled @endif
                                                class="btn btn-danger btn-sm" type="submit"> <i
                                                    class="fas fa-trash-alt"></i></button>
                                        @endcan
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <th style="width: 1px">
                                    <input type="checkbox" id="check-all" wire:model="selectAll">
                                </th>
                                <th>#</th>
                                <th>{{ trans('contact_us.name') }}</th>

                                <th>{{ trans('contact_us.email') }}</th>
                                <th>{{ trans('contact_us.phone') }}</th>

                                <th>{{ trans('contact_us.message') }}</th>
                                <th>{{ trans('contact_us.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($items as $key => $item)
                                @livewire(
                                    'admin.contact-us.show-table',
                                    [
                                        'item' => $item,
                                        'index' => $links->firstItem() + $key,
                                        'selected' => $mySelected,
                                        'selectAll' => $selectAll,
                                    ],
                                    key($item->id)
                                )
                                {{-- <livewire:admin.categories.show-category :item="$item" :index="$items->firstItem()+$key" :wire:keys="$item->id" /> --}}
                                @include('livewire.admin.layouts.show_message_modal')

                            @empty
                                <tr>
                                    <th colspan="12">
                                        <div class="alert alert-danger d-flex align-items-center " role="alert">
                                            <div class="text-center">
                                                {{ trans('message.admin.no_date') }}
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $links->links() }}
                </div>
            </div>

            {{-- Start Modal Delete --}}
            @include('livewire.admin.layouts.delete')

            {{-- End Modal Delete --}}


        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.slim.js"
            integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
        <script>
            $(".page-item").on("click", function(event) {
                Livewire.emit('resetMySelected');
            })


            // press check will check all checkbox
            $("#check-all").click(function() {
                $("input[type=checkbox]").prop("checked", $(this).is(':checked'));
            });
        </script>
    </div>
</div>
