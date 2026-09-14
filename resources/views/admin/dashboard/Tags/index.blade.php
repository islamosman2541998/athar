@extends('admin.app')

@section('title', trans('tags.tags'))
@section('title_page', trans('tags.show_tags'))

@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
@endsection
@section('content')

<div class="container-fluid">


    <div class="row">
        <div class="col-12">
            <div class="card">
                
            <div class="card-body  search-group">
                <div class="row">
                    <div class="col-md-12 text-end mb-2">
                        <a href="{{ route('admin.tag.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
                    </div>
                </div>
                {{-- Start Form search --}}
                <form action="{{route('admin.tag.index')}}" method="get">
                    <div class="row mb-3">
                        <div class="col-md-3 mb-2">
                            <input type="test"  value="{{ old('title', request()->input('title')) }}" name="title" placeholder="{{ trans('admin.title') }}" class="form-control">
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="test"  value="{{ old('description', request()->input('description')) }}" name="description" placeholder="{{ trans('admin.description') }}" class="form-control">
                        </div>
                        <div class="col-md-3 mb-2">
                            <select class="form-select" name="status"  aria-label=".form-select-sm example">
                                <option selected value=""> @lang('admin.status')  </option>
                                <option value="1"{{ old('status', request()->input('status')) == 1? "selected":"" }}>@lang('admin.active') </option>
                                <option value="0" {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null? "selected":"" }}> @lang('admin.dis_active') </option>

                            </select>   
                        </div>

                        <div class="search-input col-md-2">
                            <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-search" title="{{ trans('button.search') }}"> </i></button>
                            <a class="btn btn-success btn-sm" href="{{route('admin.tag.index')}}" title="{{ trans('button.reset') }}"><i class="refresh ion ion-md-refresh"></i></a>
                        </div>
                    </div>
                </form>
                {{-- End Form search --}}
            </div>

               


                <div class="card-body mt-0 pt-0">
                    <form id="update-pages" action="{{route('admin.tag.actions')}}" method="post">
                        @csrf
                    </form>
                    <div class="table-responsive">
                        <table id="main-datatable" class="table table-bordered  dt-responsive nowrap table-striped table-table-success table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                            <thead>
                                <tr class="bluck-actions" style="display: none" scope="row">
                                    <td colspan="8">
                                        <div class="col-md-12 mt-0 mb-0 text-center" >
                                            <button form="update-pages" class="btn btn-success btn-sm" type="submit" name ="publish" value="1"> <i class="fa fa-check"></i></button>
                                            <button form="update-pages" class="btn btn-warning btn-sm" type="submit" name ="unpublish" value="1">  <i class="fa fa-ban"></i></button>
                                            <button form="update-pages" class="btn btn-danger btn-sm" type="submit" name ="delete_all" value="1">  <i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>

                                </tr>
                            <tr>
                                <th tyle="width: 1px"> 
                                    <input form="update-pages"  class="checkbox-check flat" type="checkbox" name="check-all"  id="check-all">
                                </th>
                                <th>#</th>
                                <th>@lang('admin.title')</th>
                                <th>@lang('admin.description')</th>
                                <th>@lang('articles.sort')</th>
                                <th>@lang('admin.created_at')</th>
                                <th>@lang('admin.updated_at')</th>
                                <th>@lang('articles.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($items as $key => $item)
                                <tr>
                                    <td>
                                        <input form="update-pages" class="checkbox-check" type="checkbox" name="record[{{$item->id}}]" value={{ $item->id }}>
                                    </td>
                                    <td>{{ $items->firstItem() + $key  }}</td>
                                    <td>
                                          {{-- @foreach($languages as $local)
                                            {!!   @$item->trans->where('locale',$local)->first()->title   !!} <br>
                                            @endforeach  --}}
                                        {{   @$item->trans->where('locale',$current_lang)->first()->title }}
                                    </td>
                                    <td>
                                        {{  substr(removeHTML(  @$item->trans->where('locale',$current_lang)->first()->description),0,30) }}
                                    </td>
                                    <td>{{ $item->sort }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if($item->status == 1)
                                                <a href="{{ route('admin.tag.update-status',$item->id) }}" title="@lang('admin.active')" class="btn btn-xs btn-success btn-sm m-1"><i class="fa fa-check"></i></a>
                                            @else 
                                                <a href="{{ route('admin.tag.update-status',$item->id) }}" title="@lang('admin.dis_active')"  class="btn btn-xs btn-outline-secondary btn-sm m-1"><i class="fa fa-ban"></i></a>
                                            @endif

                                            @if($item->feature == 1)
                                                <a href="{{ route('admin.tag.update-featured',$item->id) }}}" title="@lang('admin.feature')"  class="btn btn-xs btn-warning btn-sm m-1"><i class="fa fa-star"></i></a>
                                            @else 
                                                <a href="{{ route('admin.tag.update-featured',$item->id) }}" title="@lang('admin.feature')"  class="btn btn-xs btn-outline-secondary btn-sm m-1"><i class="fa fa-star"></i></a>
                                            @endif
                                            <a href="{{ route('admin.tag.show',$item->id) }}" title="@lang('admin.show')" class="btn btn-xs btn-outline-info btn-sm m-1"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.tag.edit',$item->id) }}" title="@lang('admin.edit')" class="btn btn-outline-primary btn-sm m-1"><i class="fas fa-pencil-alt"></i></a>
                                            <a class="btn btn-outline-danger btn-sm m-1" title="@lang('admin.delete')" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">
                                                <i class="fas fa-trash-alt"> </i>
                                            </a>
                                        
                                        </div>
                                    </td>
                            
                                    
                                </tr>
                                @include('admin.dashboard.Tags.delete')

                                @endforeach
                        
                            </tbody>

                        
                        </table>
                    </div>

                        
                    <div class="col-md-12 text-center">
                        {{ $items->links('pagination::bootstrap-5') }}
                    </div>
                   
                </form>
                </div>
                
        </div>
      
    </div>

</div> <!-- container-fluid -->

@endsection


@section('script')
      
        {{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
@endsection