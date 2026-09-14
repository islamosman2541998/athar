@extends('admin.app')

@section('title', trans('main_page.product_categories'))
@section('title_page', trans('main_page.product_categories'))


@section('content')

    <div class="container-fluid">


        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body  search-group">
                        <div class="row">
                            <div class="col-md-12 text-end mb-2">
{{--                                <a href="{{ route('admin.main_page.create') }}"--}}
{{--                                   class="btn btn-outline-success btn-sm">@lang('admin.create')</a>--}}
                            </div>
                        </div>

                    </div>


                    <div class="card-body mt-0 pt-0">
{{--                        <form id="update-pages" action="{{route('admin.main_page.actions')}}" method="post">--}}
{{--                            --}}{{--                        <form id="update-pages" action="#" method="post">--}}

{{--                            @csrf--}}
{{--                        </form>--}}
                        <div class="table-responsive">
                            <table id="main-datatable"
                                   class="table table-bordered  dt-responsive nowrap table-striped table-table-success table-hover"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>
                                <tr class="bluck-actions" style="display: none" scope="row">
                                    <td colspan="8">
                                        <div class="col-md-12 mt-0 mb-0 text-center">
                                            <button form="update-pages" class="btn btn-success btn-sm" type="submit"
                                                    name="publish" value="1"><i class="fa fa-check"></i></button>
                                            <button form="update-pages" class="btn btn-warning btn-sm" type="submit"
                                                    name="unpublish" value="1"><i class="fa fa-ban"></i></button>
                                            <button form="update-pages" class="btn btn-danger btn-sm" type="submit"
                                                    name="delete_all" value="1"><i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
{{--                                    <th title="width: 1px">--}}
{{--                                        <input form="update-pages" class="checkbox-check flat" type="checkbox"--}}
{{--                                               name="check-all" id="check-all">--}}
{{--                                    </th>--}}
                                     <th>@lang('admin.image')</th>

                                    <th>@lang('admin.title')</th>
                                    <th>@lang('articles.sort')</th>
                                    <th>@lang('admin.created_at')</th>
                                    <th>@lang('admin.updated_at')</th>
                                    <th>@lang('articles.actions')</th>
                                </tr>
                                </thead>
                                <tbody>


                                <tr>
{{--                                    <td>--}}
{{--                                        <input form="update-pages" class="checkbox-check" type="checkbox"--}}
{{--                                               name="record[{{$item->id}}]" value={{ $item->id }}>--}}
{{--                                    </td>--}}
                                     <td>
                                        <img onclick="window.open(this.getAttribute('src') , '_blank')" width="50"
                                                                                              height="50" src="{{ asset($item->pathInView())}}"/>


                                    </td>

                                    <td>
                                       {{ $item->transNow->company_name}}

                                    </td>
                                    <td>{{ $item->transNow->main_title }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
{{--                                            @if($item->status == 1)--}}
{{--                                                <a href="{{ route('admin.main_page.update-status', $item->id )}}"--}}
{{--                                                   title="@lang('admin.active')"--}}
{{--                                                   class="btn btn-xs btn-success btn-sm m-1"><i--}}
{{--                                                        class="fa fa-check"></i></a>--}}
{{--                                            @else--}}
{{--                                                <a href="{{ route('admin.main_page.update-status', $item->id )}}"--}}
{{--                                                   title="@lang('admin.dis_active')"--}}
{{--                                                   class="btn btn-xs btn-outline-secondary btn-sm m-1"><i--}}
{{--                                                        class="fa fa-ban"></i></a>--}}
{{--                                            @endif--}}

{{--                                            @if($item->feature == 1)--}}
{{--                                                <a href="{{ route('admin.main_page.update-featured', $item->id )}}"--}}
{{--                                                   title="@lang('admin.feature')"--}}
{{--                                                   class="btn btn-xs btn-warning btn-sm m-1"><i--}}
{{--                                                        class="fa fa-star"></i></a>--}}
{{--                                            @else--}}
{{--                                                <a href="{{ route('admin.main_page.update-featured', $item->id )}}"--}}
{{--                                                   title="@lang('admin.feature')"--}}
{{--                                                   class="btn btn-xs btn-outline-secondary btn-sm m-1"><i--}}
{{--                                                        class="fa fa-star"></i></a>--}}
{{--                                            @endif--}}


                                            <a href="{{ route('admin.main_page.show', $item->id) }}"
                                               title="@lang('admin.show')"
                                               class="btn btn-xs btn-outline-info btn-sm m-1"><i
                                                    class="fas fa-eye"></i></a>


                                            <a href="{{ route('admin.main_page.edit',$item->id) }}"
                                               title="@lang('admin.edit')"
                                               class="btn btn-outline-primary btn-sm m-1"><i
                                                    class="fas fa-pencil-alt"></i></a>

{{--                                            <a class="btn btn-outline-danger btn-sm m-1"--}}
{{--                                               title="@lang('admin.delete')" data-bs-toggle="modal"--}}
{{--                                               data-bs-target="#exampleModal{{ $item->id }}">--}}
{{--                                                <i class="fas fa-trash-alt"> </i>--}}
{{--                                            </a>--}}

                                        </div>
                                    </td>


                                </tr>
                                @include('admin.dashboard.product_categories.delete')

                                </tbody>


                            </table>
                        </div>


                        <div class="col-md-12 text-center">

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
