@extends('admin.app')

@section('title', trans('brand.brand'))
@section('title_page', trans('brand.brand'))

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
                                <a href="{{ route('admin.brands.create') }}"
                                    class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
                            </div>
                        </div>
                        <form action="{{ route('admin.brands.index') }}" method="get">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <input type="test" value="{{ request()->title != '' ? request()->title : '' }}"
                                        name="title" placeholder="{{ trans('pages.search_title') }}" class="form-control">
                                </div>
                                <div class="search-input col-md-2">
                                    <button class="btn btn-primary btn-sm" type="submit"
                                        title="{{ trans('button.search') }}"><i class="fas fa-search"> </i></button>
                                    <a class="btn btn-warning btn-sm" href="{{ route('admin.brands.index') }}"
                                        title="{{ trans('button.reset') }}"><i class="refresh ion ion-md-refresh"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>




                    <div class="card-body mt-0 pt-0">
                        <form id="update-pages" action="{{ route('admin.brands.actions') }}" method="post">
                            @csrf
                        </form>
                        <table id="main-datatable"
                            class="table table-bordered text-center dt-responsive nowrap table-striped table-table-success table-hover table-sm"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                            <thead>

                                <tr class="bluck-actions" style="display: none" scope="row">
                                    <td colspan="8">
                                        <div class="col-md-12 mt-0 mb-0 text-center">
                                            <button form="update-pages" class="btn btn-success btn-sm" type="submit"
                                                name ="publish" value="1"title="{{ trans('button.active') }}"> <i
                                                    class="fa fa-check"></i></button>
                                            <button form="update-pages" class="btn btn-warning btn-sm" type="submit"
                                                name ="unpublish" value="1"title="{{ trans('button.unactive') }}"> <i
                                                    class="fa fa-ban"></i></button>
                                            <button form="update-pages" class="btn btn-danger btn-sm" type="submit"
                                                name ="delete_all" value="1"title="{{ trans('button.delete_all') }}">
                                                <i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <th style="width: 1px">
                                        <input form="update-pages" class="checkbox-check flat" type="checkbox"
                                            name="check-all" id="check-all">
                                    </th>
                                    <th style="width: 2px">#</th>
                                    <th>@lang('admin.title')</th>
                                    <th>@lang('admin.image')</th>
                                    <th>@lang('admin.active')</th>
                                    <th>@lang('admin.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $key => $item)
                                    <tr>
                                        <td>
                                            <input form="update-pages" class="checkbox-check" type="checkbox"
                                                name="record[{{ $item->id }}]" value={{ $item->id }}>
                                        </td>

                                        <th scope="row">{{ $items->firstItem() + $key }}</th>
                                        <td>
                                            {{-- @foreach ($languages as $key => $local)
                                                @if ($key != 0)<br> @endif

                                            @endforeach --}}
                                            {{ $item->trans->where('locale', $current_lang)->first()->title }}

                                        </td>


                                        <td>
                                            <a href="{{ asset($item->image) }}" target="_blank"> <img
                                                    src="{{ asset($item->image) }}" alt="" style="width: 50px"></a>
                                        </td>
                                        <td>{{ $item->status ? trans('admin.active') : trans('admin.dis_active') }}</td>

                                        <td>

                                            <div class="d-flex justify-content-center">
                                                @if ($item->status == 1)
                                                    <a href="{{ route('admin.brands.update-status', $item->id) }}"
                                                        class="btn btn-xs btn-success btn-sm m-1"
                                                        title="{{ trans('button.active') }}"><i
                                                            class="fa fa-check"></i></a>
                                                @else
                                                    <a href="{{ route('admin.brands.update-status', $item->id) }}"
                                                        class="btn btn-xs btn-outline-secondary btn-sm m-1"
                                                        title="{{ trans('button.unactive') }}"><i
                                                            class="fa fa-ban"></i></a>
                                                @endif

                                                <a href="{{ route('admin.brands.show', $item->id) }}"
                                                    class="btn btn-xs btn-outline-info btn-sm m-1"
                                                    title="{{ trans('button.show') }}"><i class="fas fa-eye"></i></a>

                                                <a href="{{ route('admin.brands.edit', $item->id) }}"
                                                    class="btn btn-outline-primary btn-sm m-1"
                                                    title="{{ trans('button.edit') }}"><i
                                                        class="fas fa-pencil-alt"></i></a>

                                                <a class="btn btn-outline-danger btn-sm m-1" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $item->id }}"
                                                    title="{{ trans('button.delete') }}">
                                                    <i class="fas fa-trash-alt"> </i>
                                                </a>

                                            </div>




                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">
                                                                @lang('admin.delete_item')</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{-- <div class="swal2-icon-content text-warning h1">!</div> --}}
                                                            <h2 class="swal2-title" id="swal2-title"
                                                                style="display: flex;"> @lang('admin.are_you_sure')</h2>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('admin.brands.destroy', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-primary"
                                                                        data-dismiss="modal">@lang('admin.no')</button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger">@lang('admin.yes')</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                        </td>
                                    </tr>
                                @empty
                                @endforelse

                            </tbody>


                        </table>

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
