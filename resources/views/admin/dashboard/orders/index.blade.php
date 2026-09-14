@extends('admin.app')

@section('title', trans('admin.show_orders'))
@section('title_page', trans('admin.show_orders'))


@section('content')
    <style>
        .badge {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            text-align: center;
        }

        .content_of_squares {
            justify-content: space-evenly;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .square_item {
            /*height: 83px;*/
            /*width: 177px;*/
            height: 87px;
            width: 177px;
            /*max-width: fit-content;*/
            word-break: break-all;
            border-radius: 15px;
            position: relative;
            opacity: 0.8;
            /*border: 1px solid black;*/
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            text-align: center;
            padding: 10px;
            z-index: 2;
        }

        .square_item:hover {
            opacity: 1;
        }

        .small_square {

            /*   position: absolute;*/
            /*   top: 0;*/
            /*   left: 0;*/
            /*width: 25%;*/
            /*    !*margin-top: -12px;*!*/
            /*    !*margin-right: -15px;*!*/
            /*   border-radius: 5px;*/
            /*   color: transparent;*/
            /*   height: 30px;*/
            /* position: absolute; */
            /* top: 0; */
            /* left: 0; */
            /* width: 25%; */
            /* border-radius: 5px; */
            /* color: transparent; */
            /* height: 30px; */
            position: absolute;
            top: -11px;
            left: -12px;
            width: 100%;
            /* margin-top: -12px; */
            /* margin-right: -15px; */
            border-radius: 10px;
            color: transparent;
            height: 87px;
        }

        .inside_p {
            font-size: 13px;
            position: relative;

        }


        .search-input .inner_div {
            margin-top: 31px;
        }
    </style>
    <div class="container-fluid">



        {{-- showProduct* --}}
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body  search-group">
                        <div class="row">
                            <div class="col-md-12 text-end mb-2">
                                {{--                            <a href="{{ route('admin.orders.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a> --}}
                            </div>
                        </div>
                        {{-- Start Form search --}}
                        <form action="{{ route('admin.orders.index') }}" method="get">
                            <div class="row mb-3">
                                <div class="col-md-2 mb-2">
                                    <input type="test" value="{{ old('identifier', request()->input('identifier')) }}"
                                        name="identifier" placeholder="{{ trans('admin.identifier') }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-2 mb-2">
                                    <input type="test"
                                        value="{{ old('customer_mobile', request()->input('customer_mobile')) }}"
                                        name="customer_mobile" placeholder="{{ trans('admin.customer_mobile') }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-2 mb-2">
                                    <input type="test"
                                        value="{{ old('customer_email', request()->input('customer_email')) }}"
                                        name="customer_email" placeholder="{{ trans('admin.customer_email') }}"
                                        class="form-control">
                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-outline-primary w-100 mb-2 collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#statusCollapse" aria-expanded="false"
                                        aria-controls="statusCollapse">
                                        {{ __('admin.choose_status') }}
                                    </button>

                                    <div class="collapse" id="statusCollapse">
                                        @foreach (\App\Enums\OrderStatusEnum::values() as $val)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="status[]"
                                                    value="{{ $val }}" id="status_{{ $val }}"
                                                    {{ in_array($val, (array) request()->input('status', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status_{{ $val }}">
                                                    {{ __('admin.' . $val) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>




                                <div class="col-md-2 mb-2">
                                    <button class="btn btn-outline-secondary w-100 mb-1 collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#shippedStatusCollapse"
                                        aria-expanded="false" aria-controls="shippedStatusCollapse">
                                        {{ __('admin.choose_shipping_status') }}
                                    </button>

                                    <div class="collapse" id="shippedStatusCollapse">
                                        @foreach (\App\Enums\ShippingEnum::values() as $val)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="shipped_status[]"
                                                    value="{{ $val }}" id="shipped_{{ $val }}"
                                                    {{ in_array($val, (array) request()->input('shipped_status', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="shipped_{{ $val }}">
                                                    {{ __('admin.' . $val) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>




                                <div class="row">


                                    <!------------------->

                                    <div class="col-md-2 mb-2 ">
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

                                    <div class="col-md-2 mb-2 ">
                                        <div class="col">
                                            <label class="form-label  "><small>{{ __('products.to_date') }}
                                                </small></label>
                                        </div>

                                        <div class="col">
                                            <input type="date" value="{{ request()->input('to_date') }}" name="to_date"
                                                placeholder="{{ trans('products.to_date') }}" class="form-control  ">
                                        </div>
                                    </div>




                                    <div class="col-md-2 mb-2 ">
                                        <div class="col">
                                            <label class="form-label "><small>{{ __('products.from_total') }}
                                                </small></label>
                                        </div>

                                        <div class="col">
                                            <input type="number" step="any"
                                                value="{{ request()->input('from_total') }}" name="from_total"
                                                placeholder="{{ trans('products.from_total') }}" class="form-control col">
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-2 ">
                                        <div class="col">
                                            <label class="form-label  "><small>{{ __('products.to_total') }}
                                                </small></label>
                                        </div>

                                        <div class="col">
                                            <input type="number" step="any" value="{{ request()->input('to_total') }}"
                                                name="to_total" placeholder="{{ trans('products.to_total') }}"
                                                class="form-control  ">
                                        </div>
                                    </div>





                                    <div class="search-input col-md-2">
                                        <div class="inner_div">
                                            <button class="btn btn-primary btn-sm" type="submit">
                                                <i class="fas fa-search"> </i>
                                            </button>
                                            <a class="btn btn-success btn-sm" href="{{ route('admin.orders.index') }}"><i
                                                    class="refresh ion ion-md-refresh"></i></a>

                                            <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}"
                                                class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-file-excel"></i> Excel
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                        {{-- End Form search --}}
                        {{--                        //        public const PENDING = 'pending'; --}}
                        {{--                        //        public const PROCESSING = 'processing'; --}}
                        {{--                        //        public const COMPLETED = 'completed'; --}}
                        {{--                        //        public const CANCELLED = 'cancelled'; --}}
                        {{--                        //        public const REFUNDED = 'refunded'; --}}



                        <div class="row content_of_squares">
                            <div class="bg-indigo square_item text-light col-sm-12 col-md-4 col-xl-2 mt-4 mb-4">
                                <div class="small_square border border-indigo border-5">..</div>
                                <h5>{{ __('admin.orders') }} :</h5>
                                <p class="inside_p"> @lang('admin.sum') : {{ $data['sum'] }} <br> @lang('admin.count') :
                                    {{ $data['count'] }}</p>
                            </div>

                            <div class="bg-info  square_item  col-sm-12 col-md-4 col-xl-2 mt-4 mb-4">
                                <div class="small_square border border-info border-5">..</div>
                                <h5>{{ __('admin.pending') }} :</h5>
                                <p class="inside_p"> @lang('admin.sum') : {{ $data['pending_sum'] }} <br> @lang('admin.count')
                                    : {{ $data['pending_count'] }}</p>
                            </div>
                            <div class="bg-danger  square_item  col-sm-12 col-md-4 col-xl-2 mt-4 mb-4">
                                <div class="small_square border border-danger border-5 ">..</div>
                                <h5>{{ __('admin.processing') }} :</h5>
                                <p class="inside_p"> @lang('admin.sum') : {{ $data['processing_sum'] }} <br>
                                    @lang('admin.count') : {{ $data['processing_count'] }}</p>
                            </div>
                            <div class="bg-warning square_item  col-sm-12 col-md-4 col-xl-2 mt-4 mb-4">
                                <div class="small_square border border-warning border-5 ">..</div>
                                <h5>{{ __('admin.completed') }} :</h5>
                                <p class="inside_p"> @lang('admin.sum') : {{ $data['completed_sum'] }} <br>
                                    @lang('admin.count') : {{ $data['completed_count'] }} </p>
                            </div>
                            <div class="bg-primary square_item  col-sm-12 col-md-4 col-xl-2 mt-4 mb-4">
                                <div class="small_square border border-primary border-5  ">..</div>
                                <h5>{{ __('admin.cancelled') }} :</h5>
                                <p class="inside_p"> @lang('admin.sum') : {{ $data['cancelled_sum'] }} <br>
                                    @lang('admin.count') : {{ $data['cancelled_count'] }}</p>
                            </div>
                            <div class="bg-success square_item  col-sm-12 col-md-4 col-xl-2 mt-4 mb-4">
                                <div class="small_square border border-success border-5  ">..</div>
                                <h5>{{ __('admin.refunded') }} :</h5>
                                <p class="inside_p"> @lang('admin.sum') : {{ $data['refunded_sum'] }} <br>
                                    @lang('admin.count') : {{ $data['refunded_count'] }} </p>
                            </div>


                        </div>
                    </div>




                    <div class="card-body mt-0 pt-0">


                        <form id="update-pages" action="{{ route('admin.orders.actions') }}" method="post">
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
                                            <div class="col-md-12 mt-0 mb-0 text-center">
                                                {{--                                            <button form="update-pages" class="btn btn-success btn-sm" type="submit" name="publish" value="1"><i class="fa fa-check"></i></button> --}}
                                                {{--                                            <button form="update-pages" class="btn btn-warning btn-sm" type="submit" name="unpublish" value="1"><i class="fa fa-ban"></i></button> --}}
                                                <button form="update-pages" class="btn btn-danger btn-sm" type="submit"
                                                    name="delete_all" value="1"><i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>

                                    </tr>
                                    <tr>
                                        <th title="width: 1px">
                                            <input form="update-pages" class="checkbox-check flat" type="checkbox"
                                                name="check-all" id="check-all">
                                        </th>
                                        <th>#</th>
                                        <th>@lang('admin.identifier')</th>
                                        <th>@lang('admin.customer_name')</th>
                                        <th>@lang('admin.customer_mobile')</th>

                                        <th>@lang('admin.customer_email')</th>

                                        <th>@lang('admin.status')</th>
                                        <th> @lang('admin.total') </th>
                                        <th>@lang('admin.shipped_status')</th>
                                        <th>@lang('admin.shipped_price')</th>
                                        <th>@lang('admin.created_at')</th>

                                        <th>@lang('admin.updated_by')</th>


                                        <th>@lang('admin.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($items as $key => $item)
                                        <tr>
                                            <td>
                                                <input form="update-pages" class="checkbox-check" type="checkbox"
                                                    name="record[{{ $item->id }}]" value={{ $item->id }}>
                                            </td>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                {{ $item->identifier ?? $item->id }}
                                            </td>
                                            <td>
                                                {{ $item->customer_name }}
                                            </td>

                                            <td>
                                                {{ $item->customer_mobile }}

                                            </td>
                                            <td>
                                                {{ $item->customer_email }}
                                            </td>
                                            <td>
                                                @if ($item->status)
                                                    <span
                                                        class="badge p-1 px-2 fw-bold   border border-1 border-dark text-dark"
                                                        style="  width:80px;   background-color: {{ \App\Enums\OrderStatusEnum::colors[$item->status] ?? '' }}">
                                                        {{ __('admin.' . $item->status) }} </span>
                                                @else
                                                    <span> </span>
                                                @endif

                                            </td>

                                            <td>{{ $item->total ?? 0 }} @lang('admin.egp')</td>

                                            <td>
                                                @if ($item->shipped_status)
                                                    <span
                                                        class="badge p-1 px-2 fw-bold   border border-1 border-dark text-dark  "
                                                        style="  width:80px;   background-color: {{ \App\Enums\ShippingEnum::colors[$item->shipped_status] ?? '' }}">
                                                        {{ __('admin.' . $item->shipped_status) }} </span>
                                                @else
                                                @endif
                                            </td>
                                            <td>
                                                {{ $item->shipped_price ?? 0 }} @lang('admin.egp')


                                            </td>
                                            <td>{{ $item->created_at }}</td>

                                            <td>{{ $item?->updatedBy?->name }}</td>

                                            <td>
                                                <div class="d-flex justify-content-center">


                                                    <a href="{{ route('admin.orders.show', $item->id) }}"
                                                        title="@lang('admin.show')"
                                                        class="btn btn-xs btn-outline-info btn-sm m-1"><i
                                                            class="fas fa-eye"></i></a>


                                                    <a href="{{ route('admin.orders.edit', $item->id) }}"
                                                        title="@lang('admin.edit')"
                                                        class="btn btn-outline-primary btn-sm m-1"><i
                                                            class="fas fa-pencil-alt"></i></a>

                                                    <a class="btn btn-outline-danger btn-sm m-1"
                                                        title="@lang('admin.delete')" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $item->id }}">
                                                        <i class="fas fa-trash-alt"> </i>
                                                    </a>

                                                </div>
                                            </td>


                                        </tr>
                                        @include('admin.dashboard.orders.delete')
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
