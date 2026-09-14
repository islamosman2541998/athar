@extends('admin.app')

@section('title', trans('products_of_car_only.show_products'))
@section('title_page', trans('products_of_car_only.show_products'))


@section('content')

<div class="container-fluid">

    {{--showProduct*--}}
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body  search-group">
                    <div class="row">
                        <div class="col-md-12 text-end mb-2">

                            <a href="{{ url(app()->getLocale() .  '/admin/show-in-cart-products/create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
                        </div>
                    </div>
                    {{-- Start Form search --}}
                    <form action="{{ url(app()->getLocale() .  '/admin/show-in-cart-products/list')}}" method="get">
                        <div class="row mb-3">
                            <div class="col-md-2 mb-2">
                                <input type="test" value="{{ old('title', request()->input('title')) }}" name="title" placeholder="{{ trans('products.title') }}" class="form-control">
                            </div>
                            <div class="col-md-2 mb-2">
                                <input type="test" value="{{ old('description', request()->input('description')) }}" name="description" placeholder="{{ trans('products.description') }}" class="form-control">
                            </div>
{{--                            <div class="col-md-2 mb-2">--}}
{{--                                <select class="form-select" name="cat_id" aria-label=".form-select-sm example">--}}
{{--                                    <option selected value=""> @lang('specialties.specialties') </option>--}}
{{--                                    @forelse($cats as $key => $specialty)--}}
{{--                                    <option value="{{ $specialty->transNow->title }}" {{ request()->input('cat_id') == $specialty->transNow->title ? 'selected' : '' }}>--}}
{{--                                        {{ @$specialty->trans->where('locale', $current_lang)->first()->title }}--}}
{{--                                    </option>--}}
{{--                                    @empty--}}
{{--                                    @endforelse--}}
{{--                                </select>--}}
{{--                            </div>--}}

                            <div class="col-md-2 mb-2">
                                <select class="form-select" name="occasions" aria-label=".form-select-sm example">
                                    <option selected value=""> @lang('products.occasions') </option>
                                    @forelse($occasions as $key => $specialty)
                                        @if($specialty)
                                    <option value="{{ $specialty->transNow?->title }}" {{    request()->input('occasions') == $specialty->transNow?->title ? 'selected' : '' }}>
                                        {{ @$specialty->trans->where('locale', $current_lang)->first()->title }}
                                    </option>
                                        @endif
                                    @empty
                                    @endforelse
                                </select>
                            </div>




                            <div class="col-md-2 mb-2">
                                <select class="form-select" name="status" aria-label=".form-select-sm example">
                                    <option selected value=""> @lang('admin.status') </option>
                                    <option value="1" {{ old('status', request()->input('status')) == 1? "selected":"" }}>@lang('admin.active') </option>
                                    <option value="0" {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null? "selected":"" }}> @lang('admin.dis_active') </option>
                                </select>
                            </div>


                            <div class="row">
                                <div class="col-md-2 mb-2">
                                    <input type="number" step="any" min="0" value="{{  request()->input('from_price') }}" name="from_price" placeholder="{{ trans('products.from_price') }}" class="form-control">
                                </div>
                                <div class="col-md-2 mb-2">
                                    <input type="number" step="any" min="0" value="{{   request()->input('to_price') }}" name="to_price" placeholder="{{ trans('products.to_price') }}" class="form-control">
                                </div>


                                <!------------------->

                                <div class="col-md-2 mb-2 d-flex">
                                    <div class="col">
                                        <label class="form-label "><small>{{ __('products.from_date') }} </small></label>
                                    </div>

                                    <div class="col">
                                        <input type="date" value="{{  request()->input('from_date') }}" name="from_date" placeholder="{{ trans('products.from_date') }}" class="form-control col">
                                    </div>
                                </div>

                                <div class="col-md-2 mb-2 d-flex">
                                    <div class="col">
                                        <label class="form-label  "><small>{{ __('products.to_date') }} </small></label>
                                    </div>

                                    <div class="col">
                                        <input type="date" value="{{   request()->input('to_date') }}" name="to_date" placeholder="{{ trans('products.to_date') }}" class="form-control  ">
                                    </div>
                                </div>






                                <div class="search-input col-md-2">
                                    <button class="btn btn-primary btn-sm" type="submit">
                                        <i class="fas fa-search"> </i>
                                    </button>
                                    <a class="btn btn-success btn-sm" href="{{  url(app()->getLocale() .  '/admin/show-in-cart-products/list') }}"><i class="refresh ion ion-md-refresh"></i></a>
                                </div>
                            </div>

                        </div>
                    </form>
                    {{-- End Form search --}}
                </div>


                <div class="card-body mt-0 pt-0">
                     <form id="update-pages" action="{{route('admin.products.actions')}}" method="post">
{{--                    <form id="update-pages" action="#" method="post">--}}

                        @csrf
                    </form>
                    <div class="table-responsive">
                        <table id="main-datatable" class="table table-bordered  dt-responsive nowrap table-striped table-table-success table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                            <thead>
                                <tr class="bluck-actions" style="display: none" scope="row">
                                    <td colspan="8">
                                        <div class="col-md-12 mt-0 mb-0 text-center">
                                            <button form="update-pages" class="btn btn-success btn-sm" type="submit" name="publish" value="1"><i class="fa fa-check"></i></button>
                                            <button form="update-pages" class="btn btn-warning btn-sm" type="submit" name="unpublish" value="1"><i class="fa fa-ban"></i></button>
                                            <button form="update-pages" class="btn btn-danger btn-sm" type="submit" name="delete_all" value="1"><i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <th title="width: 1px">
                                        <input form="update-pages" class="checkbox-check flat" type="checkbox" name="check-all" id="check-all">
                                    </th>
                                    <th>#</th>
                                    <th>@lang('products.code')</th>
                                    <th>@lang('admin.image')</th>

                                    <th>@lang('admin.title')</th>
                                    <th> @lang('products.occasions') </th>
                                    <th>@lang('products.price')</th>
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
                                    <td>{{ $key + 1  }}</td>
                                    <td>
                                        {{ $item->code }}
                                    </td>
                                    <td>
                                        <img onclick="window.open(this.getAttribute('src') , '_blank')" width="50" height="50" src="{{ $item->pathInView()}}" />
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
                                    <td>
                                        {{ $item->price }}

                                    </td>
                                    <td>{{ $item->sort }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if($item->status == 1)
                                            <a href="{{ route('admin.products.update-status', $item->id )}}" title="@lang('admin.active')" class="btn btn-xs btn-success btn-sm m-1"><i class="fa fa-check"></i></a>
                                            @else
                                            <a href="{{ route('admin.products.update-status', $item->id )}}" title="@lang('admin.dis_active')" class="btn btn-xs btn-outline-secondary btn-sm m-1"><i class="fa fa-ban"></i></a>
                                            @endif

                                            @if($item->feature == 1)
                                            <a href="{{ route('admin.products.update-featured', $item->id )}}" title="@lang('admin.feature')" class="btn btn-xs btn-warning btn-sm m-1"><i class="fa fa-star"></i></a>
                                            @else
                                            <a href="{{ route('admin.products.update-featured', $item->id )}}" title="@lang('admin.feature')" class="btn btn-xs btn-outline-secondary btn-sm m-1"><i class="fa fa-star"></i></a>
                                            @endif


                                            <a href="{{ route('admin.show_in_cart_product_show', $item->id) }}" title="@lang('admin.show')" class="btn btn-xs btn-outline-info btn-sm m-1"><i class="fas fa-eye"></i></a>


                                            <a href="{{ route('admin.show_in_cart_product_edit',$item->id) }}" title="@lang('admin.edit')" class="btn btn-outline-primary btn-sm m-1"><i class="fas fa-pencil-alt"></i></a>

                                            <a class="btn btn-outline-danger btn-sm m-1" title="@lang('admin.delete')" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">
                                                <i class="fas fa-trash-alt"> </i>
                                            </a>

                                        </div>
                                    </td>


                                </tr>
                                @include('admin.dashboard.products.delete')

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
