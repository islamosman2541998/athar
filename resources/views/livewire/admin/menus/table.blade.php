<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{-- Start Form search --}}
                <div class="card-body  search-group">
                    @include('admin.layouts.message')


                    <div class="row">
                        <div class="col-md-12 mb-3 text-end">
                            <a href="{{ route('admin.menus.show_tree', ['position' => App\Enums\MenuPositionEnums::MAIN]) }}"  class="btn btn-outline-primary">@lang('menus.show_tree_menu')</a>
                            <a href="{{ route('admin.menus.show_tree',  ['position' => App\Enums\MenuPositionEnums::FOOTER]) }}"  class="btn btn-outline-primary">@lang('menus.show_tree_footer')</a>
                            <a href="{{ route('admin.menus.create') }}"  class="btn btn-outline-success">@lang('admin.create')</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <input type="test" value="{{ $search_title ?? '' }}"
                                wire:model="search_title" placeholder="{{ trans('admin.title') }}"
                                class="form-control">
                        </div>
                  
                        <div class="col-md-3 mb-3">
                            <select class="form-select" wire:model="search_status"  aria-label=".form-select-sm example">
                                <option selected value=""> @lang('admin.status')  </option>
                                <option value="1" {{  $search_status == 1? 'selected':'' }}>@lang('admin.active') </option>
                                <option value="0" {{  $search_status != 1 &&  $search_status != null ? 'selected':'' }}> @lang('admin.dis_active') </option>
                            </select>   
                        </div>
                        <div class="col-md-3 mb-3">
                            @foreach (App\Enums\MenuPositionEnums::values() as $pos)
                                <input type="radio" id="html"  wire:model="search_position" value="{{ $pos }}" required>
                                <label for="html">{{ $pos }}</label><br> 
                            @endforeach
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
                                    @can('admin.menus.actions')
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
                            <th>{{ trans('admin.title') }}</th>
                            <th>{{ trans('admin.url') }}</th>
                            <th>{{ trans('admin.sort') }}</th>
                            <th>{{ trans('menus.position') }}</th>
                            <th>{{ trans('admin.created_at') }}</th>
                            <th>{{ trans('admin.updated_at') }}</th>
                            <th>{{ trans('admin.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $key => $item)
                            @livewire('admin.menus.show-menu', [
                                'item' => $item,
                                'index' => $links->firstItem() + $key,
                                'selected' =>$mySelected,
                                'selectAll'=>$selectAll], key($item->id))
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
