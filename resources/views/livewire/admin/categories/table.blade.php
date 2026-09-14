<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{-- Start Form search --}}
                <div class="card-body  search-group">
                    @include('admin.layouts.message')


                    <div class="row">
                        <div class="col-md-12 text-end mb-3">
                        <a href="{{ route('admin.categories.show_tree') }}"  class="btn btn-outline-primary">@lang('categories.show_tree')</a>
                            <a href="{{ route('admin.categories.create') }}"  class="btn btn-outline-success">@lang('admin.create')</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <input type="test" value="{{ $search_title ?? '' }}"
                                wire:model="search_title" placeholder="{{ trans('admin.title') }}"
                                class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="test" value="{{ $search_description ?? '' }}"
                                wire:model="search_description" placeholder="{{ trans('admin.description') }}"
                                class="form-control">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select " wire:model="search_status"  aria-label=".form-select-sm example">
                                <option selected value=""> @lang('admin.status')  </option>
                                <option value="1" {{  $search_status == 1? 'selected':'' }}>@lang('admin.active') </option>
                                <option value="0" {{  $search_status != 1 &&  $search_status != null ? 'selected':'' }}> @lang('admin.dis_active') </option>
                            </select>   
                        </div>
                    </div>
                 </div>
                {{-- Start Form search --}}
            </div>

           <div class="container">
           <div class="table-responsive">
                <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr class="bluck-actions"  @if(empty($mySelected)) style="display: none"  @endif scope="row">
                            <td colspan="8">
                           
                                <div class="col-md-12 mt-0 mb-0 text-center" >
                                    @can('admin.categories.actions')
                                        <button  wire:click.prevent="publishSelected" @if(empty($mySelected)) disabled  @endif class="btn btn-success btn-sm" type="submit" > <i class="fa fa-check"></i></button>
                                        <button  wire:click.prevent="unpublishSelected" @if(empty($mySelected)) disabled  @endif class="btn btn-warning btn-sm" type="submit">  <i class="fa fa-ban"></i></button>
                                        <button  wire:click.prevent="deleteSelected" @if(empty($mySelected)) disabled  @endif class="btn btn-danger btn-sm" type="submit">  <i class="fas fa-trash-alt"></i></button>
                                    @endcan
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <th style="width: 1px">
                                <input type="checkbox" id="check-all" wire:model="selectAll">
                            </th>
                            <th>#</th>
                            <th>{{ trans('categories.title') }}</th>
                            <th>{{ trans('categories.description') }}</th>
                            <th>{{ trans('categories.sort') }}</th>
                            <th>{{ trans('categories.created_at') }}</th>
                            <th>{{ trans('categories.updated_at') }}</th>
                            <th>{{ trans('categories.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $key => $item)
                            @livewire('admin.categories.show-category', [
                                'item' => $item,
                                'index' => $links->firstItem() + $key,
                                'selected' =>$mySelected,
                                'selectAll'=>$selectAll], key($item->id))
                            {{-- <livewire:admin.categories.show-category :item="$item" :index="$items->firstItem()+$key" :wire:keys="$item->id" /> --}}
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
        <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
        <script>
            $(".page-item").on("click", function(event){
            Livewire.emit('resetMySelected');
            })
            

            // press check will check all checkbox
            $("#check-all").click(function(){
                $("input[type=checkbox]").prop("checked",$(this).is(':checked'));
            });


        </script>
    </div>
</div>
