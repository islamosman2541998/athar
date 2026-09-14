@extends('admin.app')

@section('title', trans('service_categories.show_service_categories'))
@section('title_page', trans('service_categories.show_service_categories'))


@section('content')

    <div class="container-fluid">

        {{--showProduct*--}}
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body  search-group">
                        <div class="row">
                            <div class="col-md-12 text-end mb-2">
                                <a href="{{ route('admin.events.create') }}"
                                   class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
                            </div>
                        </div>
                        {{-- Start Form search --}}
                        <form action="{{route('admin.events.index')}}" method="get">
                            <div class="row mb-3">
                                <div class="col-md-2 mb-2">
                                    <input type="test" value="{{ old('title', request()->input('title')) }}"
                                           name="title" placeholder="{{ trans('service_categories.title') }}"
                                           class="form-control">
                                </div>
                                <div class="col-md-2 mb-2">
                                    <input type="test" value="{{ old('description', request()->input('description')) }}"
                                           name="description"
                                           placeholder="{{ trans('service_categories.description') }}"
                                           class="form-control">
                                </div>


                                <div class="col-md-2 mb-2">
                                    <select class="form-select" name="status" aria-label=".form-select-sm example">
                                        <option selected value=""> @lang('admin.status') </option>
                                        <option
                                            value="1" {{ old('status', request()->input('status')) == 1? "selected":"" }}>@lang('admin.active') </option>
                                        <option
                                            value="0" {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null? "selected":"" }}> @lang('admin.dis_active') </option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <select class="form-select" name="feature" aria-label=".form-select-sm example">
                                        <option selected value=""> @lang('admin.feature') </option>
                                        <option
                                            value="1" {{ old('feature', request()->input('feature')) == 1? "selected":"" }}>@lang('admin.active') </option>
                                        <option
                                            value="0" {{ old('feature', request()->input('feature')) != 1 && old('feature', request()->input('feature')) != null? "selected":"" }}> @lang('admin.dis_active') </option>
                                    </select>
                                </div>


                                <div class="row">
                                {{--                                <div class="col-md-2 mb-2">--}}
                                {{--                                    <input type="number" step="any" min="0" value="{{  request()->input('from_price') }}" name="from_price" placeholder="{{ trans('service_categories.from_price') }}" class="form-control">--}}
                                {{--                                </div>--}}
                                {{--                                <div class="col-md-2 mb-2">--}}
                                {{--                                    <input type="number" step="any" min="0" value="{{   request()->input('to_price') }}" name="to_price" placeholder="{{ trans('service_categories.to_price') }}" class="form-control">--}}
                                {{--                                </div>--}}


                                <!------------------->

                                    <div class="col-md-2 mb-2 d-flex">
                                        <div class="col">
                                            <label
                                                class="form-label "><small>{{ __('service_categories.from_date') }} </small></label>
                                        </div>

                                        <div class="col">
                                            <input type="date" value="{{  request()->input('from_date') }}"
                                                   name="from_date"
                                                   placeholder="{{ trans('service_categories.from_date') }}"
                                                   class="form-control col">
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-2 d-flex">
                                        <div class="col">
                                            <label
                                                class="form-label  "><small>{{ __('service_categories.to_date') }} </small></label>
                                        </div>

                                        <div class="col">
                                            <input type="date" value="{{   request()->input('to_date') }}"
                                                   name="to_date"
                                                   placeholder="{{ trans('service_categories.to_date') }}"
                                                   class="form-control  ">
                                        </div>
                                    </div>


                                    <div class="search-input col-md-2">
                                        <button class="btn btn-primary btn-sm" type="submit">
                                            <i class="fas fa-search"> </i>
                                        </button>
                                        <a class="btn btn-success btn-sm"
                                           href="{{route('admin.events.index')}}"><i
                                                class="refresh ion ion-md-refresh"></i></a>
                                    </div>
                                </div>

                            </div>
                        </form>
                        {{-- End Form search --}}
                    </div>


                    <div class="card-body mt-0 pt-0">
{{--                        <form id="update-pages" action="{{route('admin.events.actions')}}" method="post">--}}
{{--                            --}}{{--                    <form id="update-pages" action="#" method="post">--}}

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
                                     <th>#</th>
{{--                                    <th>@lang('service_categories.code')</th>--}}
                                    <th>@lang('admin.image')</th>

                                    <th>@lang('admin.title')</th>
                                    <th> @lang('service_categories.occasions') </th>
{{--                                    <th>@lang('service_categories.price')</th>--}}
                                    <th>@lang('articles.sort')</th>
{{--                                    <th>@lang('articles.page')</th>--}}
                                    <th>@lang('admin.created_at')</th>
                                    <th>@lang('admin.updated_at')</th>
                                    <th>@lang('articles.actions')</th>

                                </tr>
                                </thead>
                                <tbody>


                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <img onclick="window.open(this.getAttribute('src') , '_blank')" width="50"
                                                  src="{{ $item->pathInView()}}"/>
                                        </td>

                                        <td>
                                            {{ isset($item->transNow )?  $item->transNow->title : ''}}

                                        </td>
                                        <td>
                                                                                    @forelse($item->occasions as $occasion)
                                                                                    <span class="badge bg-success"> {{ $occasion->transNow->title }} </span>
                                                                                    <br>
                                                                                    @empty

                                                                                    @endforelse

                                        </td>
                                        <td>{{ $item->sort }}</td>

                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                @if($item->status == 1)
                                                    <a href="{{ route('admin.events.update-status', $item->id )}}"
                                                       title="@lang('admin.active')"
                                                       class="btn btn-xs btn-success btn-sm m-1"><i
                                                            class="fa fa-check"></i></a>
                                                @else
                                                    <a href="{{ route('admin.events.update-status', $item->id )}}"
                                                       title="@lang('admin.dis_active')"
                                                       class="btn btn-xs btn-outline-secondary btn-sm m-1"><i
                                                            class="fa fa-ban"></i></a>
                                                @endif

                                                @if($item->feature == 1)
                                                    <a href="{{ route('admin.events.update-featured', $item->id )}}"
                                                       title="@lang('admin.feature')"
                                                       class="btn btn-xs btn-warning btn-sm m-1"><i
                                                            class="fa fa-star"></i></a>
                                                @else
                                                    <a href="{{ route('admin.events.update-featured', $item->id )}}"
                                                       title="@lang('admin.feature')"
                                                       class="btn btn-xs btn-outline-secondary btn-sm m-1"><i
                                                            class="fa fa-star"></i></a>
                                                @endif


                                                <a href="{{ route('admin.events.show', $item->id) }}"
                                                   title="@lang('admin.show')"
                                                   class="btn btn-xs btn-outline-info btn-sm m-1"><i
                                                        class="fas fa-eye"></i></a>


                                                <a href="{{ route('admin.events.edit',$item->id) }}"
                                                   title="@lang('admin.edit')"
                                                   class="btn btn-outline-primary btn-sm m-1"><i
                                                        class="fas fa-pencil-alt"></i></a>

{{--                                                <a class="btn btn-outline-danger btn-sm m-1"--}}
{{--                                                   title="@lang('admin.delete')" data-bs-toggle="modal"--}}
{{--                                                   data-bs-target="#exampleModal{{ $item->id }}">--}}
{{--                                                    <i class="fas fa-trash-alt"> </i>--}}
{{--                                                </a>--}}

                                            </div>
                                        </td>


                                    </tr>
                                    @include('admin.dashboard.service_category.delete')


                                </tbody>


                            </table>
                        </div>


                        <div class="col-md-12 text-center">
{{--                            {{ $items->links('pagination::bootstrap-5') }}--}}
                        </div>

                        </div>
                    </div>

                </div>

            </div>

        </div> <!-- container-fluid -->

@endsection


@section('script')
    {{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
@endsection
