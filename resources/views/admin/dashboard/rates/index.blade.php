@extends('admin.app')

@section('title', trans('rates.show_rates'))
@section('title_page', trans('rates.show_rates'))

<style>
    /*'★★★★★'*/
    .rate_class_1 , .afterrate_class_1{
       position: relative;
    }
    .afterrate_class_1::after{
        content: '★';
        position: absolute;
        left: 0;
        top: 0;
        color:   blue;

    }
    .rate_class_1::after{
        content: '★★★★';
        position: absolute;
        left: 1.1rem;
        top: 0;


    }



    .rate_class_2  , .afterrate_class_2{
        position: relative;
    }
    .afterrate_class_2::after{
        content: '★★';
        position: absolute;
        color:   blue;

        left: 0rem;
        top: 0;
    }
    .rate_class_2::after{
        content: '★★★';
        position: absolute;


        left: 2.3rem;
        top: 0;
    }




    .rate_class_3 , .afterrate_class_3{
        position: relative;
    }
    .afterrate_class_3::after{
        content: '★★★';
        position: absolute;
        left:      0rem;
        top: 0;
        color:   blue;

    }
    .rate_class_3::after{
        content: '★★';
        position: absolute;
        left: 3.4rem;
        top: 0;


    }


    .rate_class_4 , .afterrate_class_4{
        position: relative;
    }
    .afterrate_class_4::after{
        content: '★★★★';
        position: absolute;
        left: 0;
        top: 0;
        color:   blue;

    }


    .rate_class_4::after{
        content: '★';
        position: absolute;
        left: 4.6rem;
        top: 0;


    }


    .rate_class_5 , .afterrate_class_5{
        position: relative;
    }
    .afterrate_class_5::after{
        content: '★★★★★';
        position: absolute;
        left: 0;
        top: 0;
        color:   blue;

    }


    .rate_class_5::after{
        content: '';
        position: absolute;
        left: 1.9rem;
        top: 0;


    }


</style>
@section('content')

    <div class="container-fluid">

        {{--showProduct*--}}
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body  search-group">
                        <div class="row">
                            <div class="col-md-12 text-end mb-2">
                                {{--                            <a href="{{ route('admin.rates.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>--}}
                            </div>
                        </div>
                        {{-- Start Form search --}}
                        <form action="{{route('admin.rates.index')}}" method="get">
                            <div class="row mb-3">


                                <div class="col-md-2 mb-2">
                                    <select class="form-select" name="product" aria-label=".form-select-sm example">
                                        <option selected value=""> @lang('admin.products') </option>
                                        @forelse($products as $key => $val)
                                            @if($products)
                                                <option
                                                    value="{{ $val->transNow?->title }}" {{    request()->input('product') == $val->transNow?->title ? 'selected' : '' }}>
                                                    {{ $val->transNow?->title }}
                                                </option>
                                            @endif
                                        @empty
                                        @endforelse
                                    </select>
                                </div>


                                <div class="col-md-2 mb-2">
                                    <select class="form-select" name="order_id" aria-label=".form-select-sm example">
                                        <option selected value=""> @lang('admin.orders') </option>
                                        @forelse($orders as $key => $val)
                                            @if($orders)
                                                <option
                                                    value="{{ $val->id }}" {{    request()->input('order_id') == $val->id ? 'selected' : '' }}>
                                                    {{ @$val->identifier  }}
                                                </option>
                                            @endif
                                        @empty
                                        @endforelse
                                    </select>
                                </div>


                                <!------------------->

                                <div class="col-md-2 mb-2 d-flex">
                                    <div class="col">
                                        <label class="form-label "><small>{{ __('rates.from_date') }} </small></label>
                                    </div>

                                    <div class="col">
                                        <input type="date" value="{{  request()->input('from_date') }}" name="from_date"
                                               placeholder="{{ trans('rates.from_date') }}" class="form-control col">
                                    </div>
                                </div>

                                <div class="col-md-2 mb-2 d-flex">
                                    <div class="col">
                                        <label class="form-label  "><small>{{ __('rates.to_date') }} </small></label>
                                    </div>

                                    <div class="col">
                                        <input type="date" value="{{   request()->input('to_date') }}" name="to_date"
                                               placeholder="{{ trans('rates.to_date') }}" class="form-control  ">
                                    </div>
                                </div>


                                <div class="row">


                                    <div class="search-input col-md-2">
                                        <button class="btn btn-primary btn-sm" type="submit">
                                            <i class="fas fa-search"> </i>
                                        </button>
                                        <a class="btn btn-success btn-sm" href="{{route('admin.rates.index')}}"><i
                                                class="refresh ion ion-md-refresh"></i></a>
                                    </div>
                                </div>

                            </div>
                        </form>
                        {{-- End Form search --}}
                    </div>


                    <div class="card-body mt-0 pt-0">
                        {{--                     <form id="update-pages" action="{{route('admin.rates.actions')}}" method="post">--}}
                        <form id="update-pages" action="#" method="post">

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
                                    <th>@lang('admin.rates')</th>
                                    <th>@lang('admin.product')</th>
                                    <th>@lang('admin.order')</th>

                                    <th>@lang('admin.created_at')</th>
                                    <th>@lang('admin.updated_at')</th>
                                    <th>@lang('articles.actions')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($items as $key => $item)

                                    <tr>
                                        <td>
                                            <input form="update-pages" class="checkbox-check" type="checkbox"
                                                   name="record[{{$item->id}}]" value={{ $item->id }}>
                                        </td>
                                        <td>{{ $key + 1  }}</td>
                                        <td  style="position: relative;  min-width: 5.5rem;    font-size: 22px;  ">
{{--                                            {{ $item->rating_value }}--}}
                                            <span  class="rate_class_{{ $item->rating_value??1 }}">

                                            </span>

                                            <span class="afterrate_class_{{ $item->rating_value??1 }}"> </span>
                                        </td>


                                        <td>
                                            {{ isset($item->product->transNow )?  $item->product->transNow->title : ''}}

                                        </td>
                                        <td>{{ $item->order?->identifier }}  </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">


                                                {{--                                            <a href="{{ route('admin.rates.show', $item->id) }}" title="@lang('admin.show')" class="btn btn-xs btn-outline-info btn-sm m-1"><i class="fas fa-eye"></i></a>--}}


                                                {{--                                            <a href="{{ route('admin.rates.edit',$item->id) }}" title="@lang('admin.edit')" class="btn btn-outline-primary btn-sm m-1"><i class="fas fa-pencil-alt"></i></a>--}}

                                                <a class="btn btn-outline-danger btn-sm m-1"
                                                   title="@lang('admin.delete')" data-bs-toggle="modal"
                                                   data-bs-target="#exampleModal{{ $item->id }}">
                                                    <i class="fas fa-trash-alt"> </i>
                                                </a>

                                            </div>
                                        </td>


                                    </tr>
                                    @include('admin.dashboard.rates.delete')

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
