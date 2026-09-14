{{-- //id,image,name,code,category,price,total_orde,total_qty,rate, occasions , created_at --}}


{{-- //filter///////name,code,category,occassion,frpm_price,to_price,status,rate --}}

@extends('admin.app')

@section('title', trans('admin.show_clients_reports'))
@section('title_page', trans('admin.show_clients_reports'))


@section('content')

    <div class="container-fluid">

        {{-- showProduct* --}}
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body  search-group">




                        {{--                        customer_name --}}
                        {{--                        customer_mobile --}}
                        {{--                        customer_email --}}
                        {{--                        from_price --}}
                        {{--                        to_price --}}
                        {{--                        from_date --}}
                        {{--                        to_date --}}
                        {{-- Start Form search --}}
                        <form action="{{ route('admin.clients_reports.reports') }}" method="get">
                            <div class="row mb-3">
                                <div class="col-md-2 mb-2">
                                    <input type="text"
                                        value="{{ old('customer_name', request()->input('customer_name')) }}"
                                        name="customer_name" placeholder="{{ trans('admin.customer_name') }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-2 mb-2">
                                    <input type="text"
                                        value="{{ old('customer_mobile', request()->input('customer_mobile')) }}"
                                        name="customer_mobile" placeholder="{{ trans('admin.customer_mobile') }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-2 mb-2">
                                    <input type="text"
                                        value="{{ old('customer_email', request()->input('customer_email')) }}"
                                        name="customer_email" placeholder="{{ trans('admin.customer_email') }}"
                                        class="form-control">
                                </div>


                                {{--                                <div class="col-md-2 mb-2"> --}}
                                {{--                                    <select class="form-select" name="status" aria-label=".form-select-sm example"> --}}
                                {{--                                        <option selected value=""> @lang('admin.status') </option> --}}
                                {{--                                        <option value="1" {{ old('status', request()->input('status')) == 1? "selected":"" }}>@lang('admin.active') </option> --}}
                                {{--                                        <option value="0" {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null? "selected":"" }}> @lang('admin.dis_active') </option> --}}
                                {{--                                    </select> --}}
                                {{--                                </div> --}}


                                <div class="row">
                                    {{--                                    <div class="col-md-2 mb-2"> --}}
                                    {{--                                        <input type="number" step="any" min="0" value="{{  request()->input('from_price') }}" name="from_price" placeholder="{{ trans('products.from_price') }}" class="form-control"> --}}
                                    {{--                                    </div> --}}
                                    {{--                                    <div class="col-md-2 mb-2"> --}}
                                    {{--                                        <input type="number" step="any" min="0" value="{{   request()->input('to_price') }}" name="to_price" placeholder="{{ trans('products.to_price') }}" class="form-control"> --}}
                                    {{--                                    </div> --}}


                                    <!------------------->

                                    <div class="col-md-2 mb-2">
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

                                    <div class="col-md-2 mb-2">
                                        <div class="col">
                                            <label class="form-label  "><small>{{ __('products.to_date') }}
                                                </small></label>
                                        </div>

                                        <div class="col">
                                            <input type="date" value="{{ request()->input('to_date') }}" name="to_date"
                                                placeholder="{{ trans('products.to_date') }}" class="form-control  ">
                                        </div>
                                    </div>






                                    <div class="search-input col-md-2">
                                        <br>
                                        <button class="btn btn-primary btn-sm" type="submit">
                                            <i class="fas fa-search"> </i>
                                        </button>

                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('admin.clients_reports.reports') }}"><i
                                                class="refresh ion ion-md-refresh"></i></a>

                                    </div>
                                </div>

                            </div>
                        </form>
                        {{-- End Form search --}}


                        {{--                        <div> --}}

                        {{--                            <div class="row"> --}}
                        {{--                                <div class="search-input col-md-2 mt-4"> --}}
                        {{--                                </div> --}}
                        {{--                            </div> --}}

                        {{--                        </div> --}}
                        {{-- End Form search --}}
                    </div>
                    <div class="container-fluid w-50 text-center">

                           <div class="row ">
                        <div class="col-md-6">
                            <div class="card bg-success rounded-3 text-white fs-2">
                                <div class="card-body">
                                    <h5 class="card-title">@lang('admin.new_customers')</h5>
                                    <p class="card-text">{{ $newCustomers }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-success rounded-3 text-white fs-2">
                                <div class="card-body">
                                    <h5 class="card-title">@lang('admin.orders_count')</h5>
                                    <p class="card-text">{{ $totalOrders }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>

                 


                    <div class="card-body mt-0 pt-0">
                        <div>
                        </div>
                        <div class="table-responsive">
                            <table id="main-datatable"
                                class="table table-bordered  dt-responsive nowrap table-striped table-table-success table-hover"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>
                                    <tr class="bluck-actions" style="display: none" scope="row">
                                        <td colspan="8">
                                        </td>

                                    </tr>


                                    <tr>
                                        <th>#</th>


                                        <th>@lang('admin.customer_name')</th>
                                        <th>@lang('admin.customer_email')</th>
                                        <th>@lang('admin.customer_mobile')</th>

                                        <th>@lang('admin.total_orders')</th>
                                        <th>@lang('admin.all_total')</th>


                                        <th>@lang('admin.created_at')</th>

                                        <th>@lang('articles.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($items as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>


                                            <td>
                                                {{ $item->customer_name }}

                                            </td>

                                            <td> {{ $item->customer_email }}</td>
                                            <td>
                                                {{ $item->customer_mobile }}

                                            </td>
                                            <td>
                                                {{ $item->total_orders }}

                                            </td>
                                            <td> {{ $item->all_total }} @lang('admin.egp')</td>
                                            <td>{{ $item->created_at }}</td>


                                            <td>
                                                <a class="btn btn-success" target="_blank"
                                                    href="{{ route('admin.orders.index') . '?customer_mobile=' . $item->customer_mobile }}">@lang('admin.details')</a>
                                            </td>


                                        </tr>
                                    @endforeach

                                </tbody>


                            </table>
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
