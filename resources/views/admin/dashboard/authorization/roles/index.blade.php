@extends('admin.app')

@section('title', trans('admin.roles'))
@section('title_page', trans('admin.roles_show'))


@section('content')

<div class="container-fluid">


    <div class="row">
        <div class="col-12">
            <div class="card">
                
            <div class="card-body">
                <div class="col-md-12 text-end">
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
                    {{-- <a href="{{ route('admin.permissions.restore') }}" class="btn btn-success btn-sm" title="@lang('admin.restore_permissions')">@lang('admin.restore') @lang('admin.permissions')</a> --}}
                </div>
            </div>


                <div class="card-body">

                    <table id="main-datatable" class="table table-bordered  dt-responsive nowrap table-striped table-table-success table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('admin.name')</th>
                            {{-- <th>@lang('admin.permissions')</th> --}}
                            <th>@lang('admin.actions')</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $key => $item)
                                <tr>
                                    <th>{{$items->firstItem() +$key}}</th>
                                    <td>
                                      {{$item->name}}
                                    </td>
                                    {{-- <td>
                                        @foreach($item->permissions as $key => $permission)
                                        @if($key > 10) ... <?php  break; ?>  @endif
                                            <span class="badge bg-success">{{ transPermission($permission->name) }}</span>
                                        @endforeach
                                    </td> --}}
                                  

                                    <td class="text-center">
                                        <a href="{{ route('admin.roles.edit',$item->id) }}" title="@lang('admin.edit')" class="btn btn-outline-primary btn-sm m-1"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="{{ route('admin.roles.show', $item->id) }}" title="@lang('admin.show')" class="btn btn-xs btn-outline-info btn-sm m-1"><i class="fas fa-eye"></i></a>
                                        @if ($item->id != 1)
                                        <!-- Button trigger modal -->
                                        <a class="color-red m-1" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}" title="{{ trans('button.delete') }}">
                                            <i class="text-danger fas fa-trash-alt"> </i>
                                        </a>
                                        
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">@lang('admin.delete_item')</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {{-- <div class="swal2-icon-content text-warning h1">!</div> --}}
                                                    <h2 class="swal2-title" id="swal2-title" style="display: flex;">  @lang('admin.are_you_sure')</h2>
                                                <div class="modal-footer">
                                                    <form  action="{{ route('admin.roles.destroy' , $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('admin.no')</button>
                                                        <button type="submit" class="btn btn-danger">@lang('admin.yes')</button>
                                                    </form>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    @endif
                                    </td>

                            
                                </tr>
                            @empty

                            @endforelse
                     
                        </tbody>

                      
                    </table>
                    
                </div>
                <div class="col-md-12 text-center">
                    {{ $items->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
      
    </div>

</div> <!-- container-fluid -->

@endsection


