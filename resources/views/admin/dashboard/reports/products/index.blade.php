{{-- //id,image,name,code,category,price,total_orde,total_qty,rate, occasions , created_at --}}


{{-- //filter///////name,code,category,occassion,frpm_price,to_price,status,rate --}}

@extends('admin.app')

@section('title', trans('admin.show_products_reports'))
@section('title_page', trans('admin.show_products_reports'))


@section('content')

    <div class="container-fluid">

        {{-- showProduct* --}}
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body  search-group">
                        <div class="row">
                            <div class="col-md-12 text-end mb-2">
                                {{-- <a href="{{ route('admin.products.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a> --}}
                            </div>
                        </div>
                        {{-- Start Form search --}}
                        <form action="{{ route('admin.products_reports.reports') }}" method="get">
                            <div class="row mb-3">
                                <div class="col-md-2 mb-2">
                                    <input type="text" value="{{ old('title', request()->input('title')) }}"
                                        name="title" placeholder="{{ trans('products.title') }}" class="form-control">
                                </div>
                                <div class="col-md-2 mb-2">
                                    <input type="text" value="{{ old('description', request()->input('code')) }}"
                                        name="code" placeholder="{{ trans('products.code') }}" class="form-control">
                                </div>
                                <div class="col-md-2 mb-2">
                                    <input type="number" step="any" value="{{ old('rate', request()->input('rate')) }}"
                                        name="rate" placeholder="{{ trans('admin.rates') }}" class="form-control">
                                </div>

                                <div class="col-md-2 mb-2">
                                    <select class="form-select" name="cat_id" aria-label=".form-select-sm example">
                                        <option selected value=""> @lang('admin.product_categories') </option>
                                        @forelse($cats as $key => $specialty)
                                            <option value="{{ $specialty->transNow->title }}"
                                                {{ request()->input('cat_id') == $specialty->transNow->title ? 'selected' : '' }}>
                                                {{ @$specialty->trans->where('locale', $current_lang)->first()->title }}
                                                {{ @$specialty->trans->where('locale', $current_lang)->first()->title }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-2 mb-2">
                                    <select class="form-select" name="occasions" aria-label=".form-select-sm example">
                                        <option selected value=""> @lang('products.occasions') </option>
                                        @forelse($occasions as $key => $specialty)
                                            @if ($specialty)
                                                <option value="{{ $specialty->transNow?->title }}"
                                                    {{ request()->input('occasions') == $specialty->transNow?->title ? 'selected' : '' }}>
                                                    {{ @$specialty->trans->where('locale', $current_lang)->first()->title }}
                                                    {{ @$specialty->trans->where('locale', $current_lang)->first()->title }}
                                                </option>
                                            @endif
                                        @empty
                                        @endforelse
                                    </select>
                                </div>






                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="col">
                                            <label class="form-label "><small>{{ __('admin.status') }} </small></label>
                                        </div>

                                        <select class="form-select" name="status" aria-label=".form-select-sm example">
                                            <option selected value=""> @lang('admin.status') </option>
                                            <option value="1"
                                                {{ old('status', request()->input('status')) == 1 ? 'selected' : '' }}>
                                                @lang('admin.active') </option>
                                            <option value="0"
                                                {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null ? 'selected' : '' }}>
                                                @lang('admin.dis_active') </option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="col">
                                            <label class="form-label "><small>{{ __('products.from_price') }}
                                                </small></label>
                                        </div>

                                        <input type="number" step="any" min="0"
                                            value="{{ request()->input('from_price') }}" name="from_price"
                                            placeholder="{{ trans('products.from_price') }}" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="col">
                                            <label class="form-label "><small>{{ __('products.to_price') }}
                                                </small></label>
                                        </div>

                                        <input type="number" step="any" min="0"
                                            value="{{ request()->input('to_price') }}" name="to_price"
                                            placeholder="{{ trans('products.to_price') }}" class="form-control">
                                    </div>


                                    <!------------------->

                                    <div class="col-md-2">
                                        <div class="col">
                                            <label class="form-label "><small>{{ __('products.from_date') }}
                                                </small></label>
                                        </div>

                                        <div class="col">
                                            <input type="date" value="{{ request()->input('from_date') }}"
                                                name="from_date" placeholder="{{ trans('products.from_date') }}"
                                                class="form-control col">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="col">
                                            <label class="form-label  "><small>{{ __('products.to_date') }}
                                                </small></label>
                                        </div>

                                        <div class="col">
                                            <input type="date" value="{{ request()->input('to_date') }}" name="to_date"
                                                placeholder="{{ trans('products.to_date') }}" class="form-control  ">
                                        </div>
                                    </div>






                                    <div class="search-input col-md-2 mt-4">
                                        <button class="btn btn-primary btn-sm" type="submit">
                                            <i class="fas fa-search"> </i>
                                        </button>
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('admin.products_reports.reports') }}"><i
                                                class="refresh ion ion-md-refresh"></i></a>
                                    </div>
                                </div>

                            </div>
                        </form>
                        {{-- End Form search --}}
                    </div>


                    <br><br>

                    <div class="container-fluid w-50 text-center">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-success rounded-3 text-white fs-2">
                                    <div class="card-body">
                                        <h5 class="card-title">@lang('admin.orders_count')</h5>
                                        <p class="card-text">{{ $totalOrders }}</p>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card bg-success rounded-3 text-white fs-2">
                                    <div class="card-body">
                                        <h5 class="card-title">@lang('admin.orders_total')</h5>
                                        <p class="card-text">{{ number_format($totalSum, 2) }} EGP</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="card-body mt-0 pt-0">
                        <form id="update-pages" action="{{ route('admin.products.actions') }}" method="post">
                            {{--                    <form id="update-pages" action="#" method="post"> --}}

                            @csrf
                        </form>
                        <div class="table-responsive">
                            <table id="main-datatable"
                                class="table table-bordered  dt-responsive nowrap table-striped table-table-success table-hover"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>
                                    <tr class="bluck-actions" style="display: none" scope="row">
                                        <td colspan="8">
                                            {{--                                        <div class="col-md-12 mt-0 mb-0 text-center"> --}}
                                            {{--                                            <button form="update-pages" class="btn btn-success btn-sm" type="submit" name="publish" value="1"><i class="fa fa-check"></i></button> --}}
                                            {{--                                            <button form="update-pages" class="btn btn-warning btn-sm" type="submit" name="unpublish" value="1"><i class="fa fa-ban"></i></button> --}}
                                            {{--                                            <button form="update-pages" class="btn btn-danger btn-sm" type="submit" name="delete_all" value="1"><i class="fas fa-trash-alt"></i> --}}
                                            {{--                                            </button> --}}
                                            {{--                                        </div> --}}
                                        </td>

                                    </tr>



                                    <tr>
                                        <th>#</th>
                                        <th>@lang('admin.id')</th>
                                        <th>@lang('products.image')</th>
                                        <th>@lang('admin.name')</th>
                                        <th>@lang('products.code')</th>
                                        <th>@lang('products.category')</th>
                                        {{-- <th>@lang('products.occasions')</th>  --}}

                                        <th>@lang('products.price')</th>
                                        <th>@lang('admin.total')</th>

                                        <th>@lang('admin.quantity')</th>
                                        <th> @lang('admin.rates') </th>
                                        {{--                                    <th>@lang('products.occasions')</th> --}}
                                        <th>@lang('admin.created_at')</th>

                                        <th>@lang('articles.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($items as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ $item->id }}
                                            </td>
                                            <td>
                                                <img onclick="window.open(this.getAttribute('src') , '_blank')"
                                                    width="50" height="50" src="{{ $item->pathInView() }}" />
                                            </td>

                                            <td>
                                                {{ isset($item->transNow) ? $item->transNow->title : '' }}

                                            </td>
                                            {{-- //id,image,name,code,category,price,total_orde,total_qty,rate, occasions , created_at --}}

                                            <td>{{ $item->code }}</td>
                                            <td>
                                                {{ $item->productCategoriesProducts->pluck('transNow.title')->filter()->implode(', ') ?: '—' }}
                                            </td>
                                            {{-- <td class="d-flex flex-wrap">
                                                
                                                {{ $item->occasions->pluck('transNow.title')->filter()->implode(', ') ?: '—' }}
                                            </td> --}}
                                            <td>
                                                {{ $item->price }} @lang('admin.egp')

                                            </td>
                                            <td>{{ $item->order_details_sum_total ?? 0 }} @lang('admin.egp')</td>
                                            <td>{{ $item->order_details_sum_quantity ?? 0 }}</td>

                                            <td>{{ round($item->rates_avg_rating_value, 1) ?? 0 }}</td>
                                            {{--                                    <td> --}}
                                            {{--                                        @forelse($item->occasions as $occasion) --}}
                                            {{--                                            <span class="badge bg-success"> {{ $occasion->transNow->title }} </span> --}}
                                            {{--                                            <br> --}}
                                            {{--                                        @empty --}}

                                            {{--                                        @endforelse --}}

                                            {{--                                    </td> --}}
                                            <td>{{ $item->created_at }}</td>

                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    @if ($item->status == 1)
                                                        <span title="@lang('admin.active')"
                                                            class="btn btn-xs btn-success btn-sm m-1"><i
                                                                class="fa fa-check"></i></span>
                                                    @else
                                                        <span title="@lang('admin.dis_active')"
                                                            class="btn btn-xs btn-outline-secondary btn-sm m-1"><i
                                                                class="fa fa-ban"></i></span>
                                                    @endif

                                                    @if ($item->feature == 1)
                                                        <span title="@lang('admin.feature')"
                                                            class="btn btn-xs btn-warning btn-sm m-1"><i
                                                                class="fa fa-star"></i></span>
                                                    @else
                                                        <span title="@lang('admin.feature')"
                                                            class="btn btn-xs btn-outline-secondary btn-sm m-1"><i
                                                                class="fa fa-star"></i></span>
                                                    @endif


                                                    <a href="{{ route('admin.products.show', $item->id) }}"
                                                        title="@lang('admin.show')"
                                                        class="btn btn-xs btn-outline-info btn-sm m-1"><i
                                                            class="fas fa-eye"></i></a>


                                                    {{--                                            <a href="{{ route('admin.products.edit',$item->id) }}" title="@lang('admin.edit')" class="btn btn-outline-primary btn-sm m-1"><i class="fas fa-pencil-alt"></i></a> --}}

                                                    {{--                                            <a class="btn btn-outline-danger btn-sm m-1" title="@lang('admin.delete')" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}"> --}}
                                                    {{--                                                <i class="fas fa-trash-alt"> </i> --}}
                                                    {{--                                            </a> --}}

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
