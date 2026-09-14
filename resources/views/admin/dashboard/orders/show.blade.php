@extends('admin.app')

@section('title', trans('admin.order'))
@section('title_page', trans('admin.order_', ['name' => @$orders->identifier]))

@section('content')
    <style>
        .hh-grayBox {
            background-color: #F8F8F8;
            margin-bottom: 20px;
            padding: 35px;
            margin-top: 20px;
        }

        .pt45 {
            padding-top: 45px;
        }

        .order-tracking {
            text-align: center;
            width: 33.33%;
            position: relative;
            display: block;
        }

        .order-tracking .is-complete {
            display: block;
            position: relative;
            border-radius: 50%;
            height: 30px;
            width: 30px;
            border: 0px solid #AFAFAF;
            background-color: #f7be16;
            margin: 0 auto;
            transition: background 0.25s linear;
            -webkit-transition: background 0.25s linear;
            z-index: 2;
        }

        .order-tracking .is-complete:after {
            display: block;
            position: absolute;
            content: '';
            height: 14px;
            width: 7px;
            top: -2px;
            bottom: 0;
            left: 5px;
            margin: auto 0;
            border: 0px solid #AFAFAF;
            border-width: 0px 2px 2px 0;
            transform: rotate(45deg);
            opacity: 0;
        }

        .order-tracking.completed .is-complete {
            border-color: #27aa80;
            border-width: 0px;
            background-color: #27aa80;
        }

        .order-tracking.completed .is-complete:after {
            border-color: #fff;
            border-width: 0px 3px 3px 0;
            width: 7px;
            left: 11px;
            opacity: 1;
        }

        .order-tracking p {
            color: #A4A4A4;
            font-size: 16px;
            margin-top: 8px;
            margin-bottom: 0;
            line-height: 20px;
        }

        .order-tracking p span {
            font-size: 14px;
        }

        .order-tracking.completed p {
            color: #000;
        }

        .order-tracking::before {
            content: '';
            display: block;
            height: 3px;
            width: calc(100% - 40px);
            background-color: #f7be16;
            top: 13px;
            position: absolute;
            left: calc(-50% + 20px);
            z-index: 0;
        }

        .order-tracking:first-child:before {
            display: none;
        }

        .order-tracking.completed:before {
            background-color: #27aa80;
        }


        .order-tracking {
            text-align: center;
            width: 15.33%;
            position: relative;
            display: block;
        }
    </style>

    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.orders.index') }}"
                                class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form class="row" method="post" action="{{ route('admin.orders.update', $orders->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="col-md-8">

                                    <div class="accordion mt-4 mb-4" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button fw-medium" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                    @lang('admin.order')
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show mt-3"
                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">


                                                    {{--                                                    --}}{{-- title ------------------------------------------------------------------------------------- --}}
                                                    {{--                                                    <div class="row mb-3"> --}}
                                                    {{--                                                        <label for="example-text-input" --}}
                                                    {{--                                                               class="col-sm-2 col-form-label">{{ trans('admin.title') }}</label> --}}
                                                    {{--                                                        <div class="col-sm-10"> --}}
                                                    {{--                                                            --}}{{-- <input disabled class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$orders->trans->where('locale',$locale)->first()->title}}" id="title"> --}}
                                                    {{--                                                            <input disabled class="form-control" type="text" disabled --}}
                                                    {{--                                                                   value="{{$orders->title}}" id="title"> --}}
                                                    {{--                                                        </div> --}}
                                                    {{--                                                    </div> --}}


                                                    {{-- customer_name ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-2 col-form-label">{{ trans('admin.customer_name') }}</label>
                                                        <div class="col-sm-10">
                                                            <input disabled class="form-control" type="text"
                                                                value="{{ $orders->customer_name }}" id="customer_name">
                                                        </div>
                                                    </div>

                                                    {{-- customer_mobile ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-2 col-form-label">{{ trans('admin.customer_mobile') }}</label>
                                                        <div class="col-sm-10">
                                                            <input disabled class="form-control" type="text"
                                                                value="{{ $orders->customer_mobile }}" id="customer_mobile">
                                                        </div>
                                                    </div>


                                                    {{-- customer_email ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-2 col-form-label">{{ trans('admin.customer_email') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" disabled
                                                                value="{{ $orders->customer_email }}" id="customer_email">
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--                                    <div class="accordion mt-4 mb-4" id="accordionExample22"> --}}
                                    {{--                                        <div class="accordion-item border rounded"> --}}
                                    {{--                                            <h2 class="accordion-header" id="headingOne"> --}}
                                    {{--                                                <button class="accordion-button fw-medium" type="button" --}}
                                    {{--                                                        data-bs-toggle="collapse" data-bs-target="#collapseOne22" --}}
                                    {{--                                                        aria-expanded="true" aria-controls="collapseOne22"> --}}
                                    {{--                                                    @lang('admin.order_details') --}}
                                    {{--                                                </button> --}}
                                    {{--                                            </h2> --}}
                                    {{--                                            <div id="collapseOne22" class="accordion-collapse collapse show mt-3" --}}
                                    {{--                                                 aria-labelledby="headingOne22" data-bs-parent="#accordionExample22"> --}}
                                    {{--                                                <div class="accordion-body"> --}}


                                    {{--                                                    @if ($orders->orderDetails && $orders->orderDetails->count()) --}}
                                    {{--                                                        @foreach ($orders->orderDetails as $detail) --}}
                                    {{--                                                            --}}{{-- product_name ------------------------------------------------------------------------------------- --}}
                                    {{--                                                            <div class="row mb-3"> --}}
                                    {{--                                                                <label for="example-text-input" --}}
                                    {{--                                                                       class="col-sm-2 col-form-label">{{ trans('admin.product_name') }}</label> --}}
                                    {{--                                                                <div class="col-sm-10"> --}}
                                    {{--                                                                    --}}{{-- <input disabled class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$orders->trans->where('locale',$locale)->first()->title}}" id="title"> --}}
                                    {{--                                                                    <input disabled class="form-control" type="text" disabled --}}
                                    {{--                                                                           value="{{$detail->product_name}}" id="title"> --}}
                                    {{--                                                                </div> --}}
                                    {{--                                                            </div> --}}





                                    {{--                                                            --}}{{-- price ------------------------------------------------------------------------------------- --}}
                                    {{--                                                            <div class="row mb-3"> --}}
                                    {{--                                                                <label for="example-text-input" --}}
                                    {{--                                                                       class="col-sm-2 col-form-label">{{ trans('admin.price') }}</label> --}}
                                    {{--                                                                <div class="col-sm-10"> --}}
                                    {{--                                                                    <input disabled class="form-control" type="text" disabled --}}
                                    {{--                                                                           value="{{$detail->price}}" id="price"> --}}
                                    {{--                                                                </div> --}}
                                    {{--                                                            </div> --}}





                                    {{--                                                            --}}{{-- sale ------------------------------------------------------------------------------------- --}}
                                    {{--                                                            <div class="row mb-3"> --}}
                                    {{--                                                                <label for="example-text-input" --}}
                                    {{--                                                                       class="col-sm-2 col-form-label">{{ trans('admin.sale') }}</label> --}}
                                    {{--                                                                <div class="col-sm-10"> --}}
                                    {{--                                                                    <input disabled class="form-control" type="text" disabled --}}
                                    {{--                                                                           value="{{$detail->sale}}" id="sale"> --}}
                                    {{--                                                                </div> --}}
                                    {{--                                                            </div> --}}





                                    {{--                                                            --}}{{-- price_after_sale ------------------------------------------------------------------------------------- --}}
                                    {{--                                                            <div class="row mb-3"> --}}
                                    {{--                                                                <label for="example-text-input" --}}
                                    {{--                                                                       class="col-sm-2 col-form-label">{{ trans('admin.price_after_sale') }}</label> --}}
                                    {{--                                                                <div class="col-sm-10"> --}}
                                    {{--                                                                    <input disabled class="form-control" type="text" disabled --}}
                                    {{--                                                                           value="{{$detail->price_after_sale}}" --}}
                                    {{--                                                                           id="price_after_sale"> --}}
                                    {{--                                                                </div> --}}
                                    {{--                                                            </div> --}}






                                    {{--                                                            --}}{{-- quantity ------------------------------------------------------------------------------------- --}}
                                    {{--                                                            <div class="row mb-3"> --}}
                                    {{--                                                                <label for="example-text-input" --}}
                                    {{--                                                                       class="col-sm-2 col-form-label">{{ trans('admin.quantity') }}</label> --}}
                                    {{--                                                                <div class="col-sm-10"> --}}
                                    {{--                                                                    <input disabled class="form-control" type="text" disabled --}}
                                    {{--                                                                           value="{{$detail->quantity}}" id="quantity"> --}}
                                    {{--                                                                </div> --}}
                                    {{--                                                            </div> --}}







                                    {{--                                                            --}}{{-- total ------------------------------------------------------------------------------------- --}}
                                    {{--                                                            <div class="row mb-3"> --}}
                                    {{--                                                                <label for="example-text-input" --}}
                                    {{--                                                                       class="col-sm-2 col-form-label">{{ trans('admin.total') }}</label> --}}
                                    {{--                                                                <div class="col-sm-10"> --}}
                                    {{--                                                                    --}}{{-- <input disabled class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$orders->trans->where('locale',$locale)->first()->title}}" id="title"> --}}
                                    {{--                                                                    <input disabled class="form-control" type="text" disabled --}}
                                    {{--                                                                           value="{{$detail->total}}" id="total"> --}}
                                    {{--                                                                </div> --}}
                                    {{--                                                            </div> --}}




                                    {{--                                                            --}}{{-- refund_status ------------------------------------------------------------------------------------- --}}
                                    {{--                                                            <div class="row mb-3"> --}}
                                    {{--                                                                <label for="example-text-input" --}}
                                    {{--                                                                       class="col-sm-2 col-form-label">{{ trans('admin.refund_status') }}</label> --}}
                                    {{--                                                                <div class="col-sm-10"> --}}
                                    {{--                                                                    --}}{{-- <input disabled class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$orders->trans->where('locale',$locale)->first()->title}}" id="title"> --}}
                                    {{--                                                                    <input disabled type="hidden" value="{{$detail->id}}" --}}
                                    {{--                                                                           name="detail_id[]"> --}}

                                    {{--                                                                    --}}{{--                                                                    <input disabled class="form-control" type="number" --}}
                                    {{--                                                                    --}}{{--                                                                           name="refund_status[]" --}}
                                    {{--                                                                    --}}{{--                                                                           value="{{$detail->refund_status}}" --}}
                                    {{--                                                                    --}}{{--                                                                           id="refund_status"> --}}

                                    {{--                                                                    <select disabled class="form-control" --}}
                                    {{--                                                                            name="refund_status[]" --}}

                                    {{--                                                                            id="refund_status"> --}}
                                    {{--                                                                        <option value="0" {{$detail->refund_status == 0 ? 'selected' : ''}}>@lang('admin.not_refunded')</option> --}}
                                    {{--                                                                        <option value="1" {{$detail->refund_status == 1 ? 'selected' : ''}}>@lang('admin.refunded')</option> --}}

                                    {{--                                                                    </select> --}}

                                    {{--                                                                </div> --}}
                                    {{--                                                            </div> --}}


                                    {{--                                                            <hr> --}}


                                    {{--                                                        @endforeach --}}

                                    {{--                                                    @endif --}}

                                    {{--                                                </div> --}}
                                    {{--                                            </div> --}}
                                    {{--                                        </div> --}}
                                    {{--                                    </div> --}}

                                </div>


                                {{-- other info --}}
                                <div class="col-md-4">
                                    <div class="accordion mt-4 mb-4" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button fw-medium" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                    {{ trans('admin.settings') }}
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show"
                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">


                                                    {{-- code ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label for="example-number-email"
                                                                class="col-sm-4 col-form-label">
                                                                @lang('admin.identifier')</label>
                                                            <div class="col-sm-8">
                                                                <input disabled class="form-control" type="text"
                                                                    placeholder="@lang('admin.identifier')" name="code"
                                                                    value="{{ $orders->identifier ?? $orders->id }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">{{ trans('admin.status') }}</label>
                                                        <div class="col-sm-8">

                                                            <select class="form-select form-select-sm select2" disabled
                                                                name="status">
                                                                {{--                                                                <option --}}
                                                                {{--                                                                    {{$orders->status == 0 ? 'selected' : ''}}  value="0"> @lang('admin.no_action')  </option> --}}
                                                                {{--                                                                <option --}}
                                                                {{--                                                                    {{$orders->status == 1 ? 'selected' : ''}}   value="1"> @lang ('admin.processing')      </option> --}}
                                                                {{--                                                                <option --}}
                                                                {{--                                                                    {{$orders->status == 2 ? 'selected' : ''}}   value="2"> @lang ('admin.done')    </option> --}}
                                                                {{--                                                                <option --}}
                                                                {{--                                                                    {{$orders->status == 3 ? 'selected' : ''}}   value="3"> @lang ('admin.returned')    </option> --}}

                                                                @foreach (\App\Enums\OrderStatusEnum::values() as $val)
                                                                    <option {{ $orders->status == $val ? 'selected' : '' }}
                                                                        value="{{ $val }}"> @lang('admin.' . $val)
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                        @if ($errors->has('status'))
                                                            <span class="missiong-spam">{{ $errors->status }}</span>
                                                        @endif
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">{{ trans('admin.shipped_status') }}</label>
                                                        <div class="col-sm-8">

                                                            <select class="form-control" type="text" disabled
                                                                name="shipped_status">
                                                                @foreach (\App\Enums\ShippingEnum::values() as $val)
                                                                    <option
                                                                        {{ $orders->shipped_status == $val ? 'selected' : '' }}
                                                                        value="{{ $val }}"> @lang('admin.' . $val)
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                        @if ($errors->has('shipped_status'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->shipped_status }}</span>
                                                        @endif
                                                    </div>

                                                    {{--                                                    <div class="row mb-3"> --}}
                                                    {{--                                                        <label for="example-text-input" --}}
                                                    {{--                                                               class="col-sm-4 col-form-label">{{ trans('admin.status')   }}</label> --}}
                                                    {{--                                                        <div class="col-sm-8"> --}}

                                                    {{--                                                            <select disabled class="form-select form-select-sm select2" --}}
                                                    {{--                                                                    name="status"> --}}

                                                    {{--                                                                <option --}}
                                                    {{--                                                                    {{$orders->status == 0 ? 'selected' : ''}}  value="0"> @lang('admin.no_action')  </option> --}}
                                                    {{--                                                                <option --}}
                                                    {{--                                                                    {{$orders->status == 1 ? 'selected' : ''}}   value="1"> @lang ('admin.processing')      </option> --}}
                                                    {{--                                                                <option --}}
                                                    {{--                                                                    {{$orders->status == 2 ? 'selected' : ''}}   value="2"> @lang ('admin.done')    </option> --}}
                                                    {{--                                                                <option --}}
                                                    {{--                                                                    {{$orders->status == 3 ? 'selected' : ''}}   value="3"> @lang ('admin.returned')    </option> --}}

                                                    {{--                                                            </select> --}}
                                                    {{--                                                        </div> --}}
                                                    {{--                                                        @if ($errors->has('status')) --}}
                                                    {{--                                                            <span class="missiong-spam">{{ $errors->status }}</span> --}}
                                                    {{--                                                        @endif --}}
                                                    {{--                                                    </div> --}}
                                                    {{-- payment_method ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">{{ trans('admin.payment_method') }}</label>
                                                        <div class="col-sm-8">
                                                            <input disabled class="form-control" type="text"
                                                                value="{{ $orders->payment_method_id }}"
                                                                id="payment_method">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">{{ trans('admin.subtotal') }}</label>
                                                        <div class="col-sm-8">

                                                            <input disabled class="form-control" type="text"
                                                                name="subtotal"
                                                                value="{{ number_format($orders->orderDetails->sum('total'), 2) }} EGP">

                                                        </div>
                                                        @if ($errors->has('subtotal'))
                                                            <span class="missiong-spam">{{ $errors->subtotal }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">{{ trans('admin.discount') }}</label>
                                                        <div class="col-sm-8">

                                                            <input disabled class="form-control" type="text"
                                                                name="discount" value="{{ $orders->discount ?? 0 }} EGP">

                                                        </div>
                                                        @if ($errors->has('discount'))
                                                            <span class="missiong-spam">{{ $errors->discount }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">{{ trans('admin.shipped_price') }}</label>
                                                        <div class="col-sm-8">

                                                            <input disabled class="form-control" type="text"
                                                                name="shipped_price"
                                                                value="{{ $orders->shipped_price ?? 0 }} EGP">

                                                        </div>
                                                        @if ($errors->has('shipped_price'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->shipped_price }}</span>
                                                        @endif
                                                    </div>







                                                    {{-- total ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">{{ trans('admin.total') }}</label>
                                                        <div class="col-sm-8">
                                                            {{-- <input disabled class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$orders->trans->where('locale',$locale)->first()->title}}" id="title"> --}}
                                                            <input disabled class="form-control" type="text"
                                                                value="{{ $orders->total ?? 0 }} EGP" id="total">
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>




                                <div class="col-md-12">
                                    <div class="accordion mt-4 mb-4" id="accordionExample22all">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOneall">
                                                <button class="accordion-button fw-medium" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne22all"
                                                    aria-expanded="true" aria-controls="collapseOne22all">
                                                    @lang('admin.extra_data')
                                                </button>
                                            </h2>
                                            <div id="collapseOne22all" class="accordion-collapse collapse show mt-3"
                                                aria-labelledby="headingOne22all" data-bs-parent="#accordionExample22all">
                                                <div class="accordion-body">





                                                    <div class="container">
                                                        @php
                                                            $arr = [
                                                                null => '',
                                                                0 => __('admin.no'),
                                                                1 => __('admin.yes'),
                                                            ];
                                                            $arrPlace = [
                                                                null => '',
                                                                0 => __('admin.home'),
                                                                1 => __('admin.office'),
                                                            ];
                                                        @endphp

                                                        <div class="row">
                                                            <div class="col-md-12 col-md-6  col-lg-4 card cardInfo">

                                                                <div class="card-body">
                                                                    <h5>@lang('admin.extraOrderDetails')</h5>
                                                                    <li>


                                                                        <span class="spanText">@lang('admin.ship_to_me')</span> :
                                                                        {{ $arr[$orders->extraOrderDetails?->ship_to_me] }}
                                                                    </li>
                                                                    <li>


                                                                        <span class="spanText">@lang('admin.know_receipents_address')</span> :
                                                                        {{ $arr[$orders->extraOrderDetails?->know_receipent_address] }}
                                                                    </li>
                                                                    <li>

                                                                        <span class="spanText">@lang('admin.same_day')</span> :
                                                                        {{ $arr[$orders->extraOrderDetails?->same_day] }}
                                                                    </li>
                                                                    <li>


                                                                        <span class="spanText">@lang('admin.delivery_date')</span> :
                                                                        {{ $orders->extraOrderDetails?->delivery_date }}
                                                                    </li>
                                                                    <li>


                                                                        <span class="spanText">@lang('admin.specific_time_slot_status')</span> :
                                                                        {{ $arr[$orders->extraOrderDetails?->specific_time_slot_status] }}

                                                                    </li>
                                                                    <li>
                                                                        <span class="spanText"> @lang('admin.specifc_time') </span>
                                                                        :
                                                                        {{ $orders->extraOrderDetails?->specific_time ?? '--------' }}
                                                                    </li>






                                                                    <li>


                                                                        <span class="spanText">@lang('admin.greeting_card')</span> :
                                                                        {{ $orders->extraOrderDetails?->greeting_card }}
                                                                    </li>
                                                                    <li>


                                                                        <span class="spanText">@lang('admin.extra_instructions')</span> :
                                                                        {{ $orders->extraOrderDetails?->extra_instructions }}
                                                                    </li>
                                                                </div>

                                                            </div>



                                                            <div class="col-md-12 col-md-6  col-lg-4 card cardInfo">
                                                                <div class="card-body">
                                                                    <h5>@lang('admin.customer_info')</h5>

                                                                    <li>


                                                                        <span class="spanText">@lang('admin.customer_first_name')</span> :
                                                                        {{ $orders->customer_name }}
                                                                    </li>


                                                                    <li>


                                                                        <span class="spanText">@lang('admin.customer_mobile')</span> :
                                                                        {{ $orders->customer_mobile }}
                                                                    </li>
                                                                    <li>


                                                                        <span class="spanText">@lang('admin.customer_email')</span> :
                                                                        {{ $orders->customer_email }}
                                                                    </li>
                                                                    <li>


                                                                        <span class="spanText">@lang('admin.hide_my_name_status')</span> :
                                                                        {{ $arr[$orders->extraOrderDetails?->hide_my_name_status] }}
                                                                    </li>

                                                                </div>
                                                            </div>




                                                            <div class="col-md-12 col-md-6  col-lg-4  card cardInfo">
                                                                <div class="card-body">
                                                                    <h5>@lang('admin.receipent_info')</h5>


                                                                    <li>

                                                                        <span class="spanText">@lang('admin.receioent_name')</span> :
                                                                        {{ $orders->receipentsDetails?->name }}

                                                                    </li>

                                                                    <li>


                                                                        <span class="spanText">@lang('admin.receioent_mobile')</span> :
                                                                        {{ $orders->receipentsDetails?->mobile }}
                                                                    </li>

                                                                </div>
                                                            </div>





                                                            <div class="col-md-12 col-md-6  col-lg-4  card cardInfo">
                                                                <div class="card-body">
                                                                    <h5>@lang('admin.delivery_info')</h5>


                                                                    <li>


                                                                        <span class="spanText">@lang('admin.delivery_status')</span> :
                                                                        {{ $arr[$orders->deliveryDetails?->status] }}
                                                                    </li>
                                                                    <li>

                                                                        <span class="spanText">@lang('admin.area')</span> :
                                                                        {{ $orders->deliveryDetails?->area }}
                                                                    </li>
                                                                    <li>

                                                                        <span class="spanText">@lang('admin.st_name')</span> :
                                                                        {{ $orders->deliveryDetails?->st_name }}
                                                                    </li>
                                                                    <li>


                                                                        <span class="spanText">@lang('admin.apartment')</span> :
                                                                        {{ $orders->deliveryDetails?->apartment }}
                                                                    </li>
                                                                    <li>

                                                                        <span class="spanText">@lang('admin.floor')</span> :
                                                                        {{ $orders->deliveryDetails?->floor }}
                                                                    </li>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-12 col-md-6  col-lg-4  card cardInfo">
                                                                <div class="card-body">
                                                                    <h5>@lang('admin.payment_method_info')</h5>

                                                                    <li>


                                                                        <span class="spanText">@lang('admin.payment_method_id')</span> :
                                                                        {{ $orders->paymentMethod?->transNow->title }}
                                                                    </li>
                                                                    <li>



                                                                        <span class="spanText">@lang('admin.promo_code')</span> :
                                                                        {{ $orders?->promoCode?->transNow?->title }}
                                                                    </li>
                                                                    <li>

                                                                        <span class="spanText">@lang('admin.image')</span> :
                                                                        <img src="{{ asset($orders->image) }}"
                                                                            width="100" height="100">
                                                                    </li>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--------end new added------->
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="col-md-12">
                                    <div class="accordion mt-4 mb-4" id="accordionExample22">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button fw-medium" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne22"
                                                    aria-expanded="true" aria-controls="collapseOne22">
                                                    @lang('admin.order_details')
                                                </button>
                                            </h2>
                                            <div id="collapseOne22" class="accordion-collapse collapse show mt-3"
                                                aria-labelledby="headingOne22" data-bs-parent="#accordionExample22">
                                                <div class="accordion-body">
                                                    <table class="table table-success table-striped">

                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>

                                                                <th scope="col">{{ trans('admin.product_name') }}</th>
                                                                <th scope="col">{{ trans('admin.code') }}</th>
                                                                <th scope="col">{{ trans('admin.image') }}</th>

                                                                <th scope="col">{{ trans('admin.price') }}</th>
                                                                <th scope="col">{{ trans('admin.sale') }}</th>
                                                                <th scope="col">{{ trans('admin.price_after_sale') }}
                                                                </th>
                                                                <th scope="col">{{ trans('admin.quantity') }}</th>
                                                                <th scope="col">{{ trans('admin.user_input') }}</th>
                                                                <th scope="col">{{ trans('admin.total') }}</th>
                                                                <th scope="col">{{ trans('admin.refund_status') }}</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @if ($orders->orderDetails && $orders->orderDetails->count())
                                                                <?php $i = 1; ?>
                                                                @foreach ($orders->orderDetails as $detail)
                                                                    <tr>


                                                                        <th scope="row">{{ $i++ }}</th>
                                                                        <td>
                                                                            {{ $detail->product_name }}
                                                                        </td>
                                                                        <td>{{ $detail->product->code }}</td>
                                                                        <td>
                                                                            <img src="{{ asset($detail->product->pathInView()) }}"
                                                                                width="80" class="img-thumbnail"
                                                                                alt="Product Image">
                                                                        </td>





                                                                        <td>
                                                                            {{ $detail->price }}
                                                                        </td>





                                                                        <td>

                                                                            {{ $detail->sale }} %
                                                                        </td>





                                                                        <td>
                                                                            {{ $detail->price_after_sale }}
                                                                        </td>






                                                                        <td>

                                                                            {{ $detail->quantity }}
                                                                        </td>
                                                                        <td>

                                                                            {{ $detail->user_input }}
                                                                        </td>
                                                                        <td>

                                                                            {{ $detail->total }}
                                                                        </td>

                                                                        <td>

                                                                            <input type="hidden"
                                                                                value="{{ $detail->id }}"
                                                                                name="detail_id[]">



                                                                            <select class="form-control" disabled
                                                                                name="refund_status[]" id="refund_status">
                                                                                <option value="0"
                                                                                    {{ $detail->refund_status == 0 ? 'selected' : '' }}>
                                                                                    @lang('admin.not_refunded')</option>
                                                                                <option value="1"
                                                                                    {{ $detail->refund_status == 1 ? 'selected' : '' }}>
                                                                                    @lang('admin.refunded')</option>

                                                                            </select>
                                                                        </td>




                                                                    </tr>
                                                                @endforeach

                                                            @endif




                                                        </tbody>
                                                    </table>

                                                    {{--                                                    @if ($orders->orderDetails && $orders->orderDetails->count()) --}}
                                                    {{--                                                        @foreach ($orders->orderDetails as $detail) --}}
                                                    {{--                                                             product_name ------------------------------------------------------------------------------------- --}}
                                                    {{--                                                            <div class="row mb-3"> --}}
                                                    {{--                                                                <label for="example-text-input" --}}
                                                    {{--                                                                       class="col-sm-2 col-form-label">{{ trans('admin.product_name') }}</label> --}}
                                                    {{--                                                                <div class="col-sm-10"> --}}
                                                    {{--                                                                     <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$orders->trans->where('locale',$locale)->first()->title}}" id="title"> --}}
                                                    {{--                                                                    <input class="form-control" type="text" disabled --}}
                                                    {{--                                                                           value="{{$detail->product_name}}" id="title"> --}}
                                                    {{--                                                                </div> --}}
                                                    {{--                                                            </div> --}}





                                                    {{--                                                             price ------------------------------------------------------------------------------------- --}}
                                                    {{--                                                            <div class="row mb-3"> --}}
                                                    {{--                                                                <label for="example-text-input" --}}
                                                    {{--                                                                       class="col-sm-2 col-form-label">{{ trans('admin.price') }}</label> --}}
                                                    {{--                                                                <div class="col-sm-10"> --}}
                                                    {{--                                                                    <input class="form-control" type="text" disabled --}}
                                                    {{--                                                                           value="{{$detail->price}}" id="price"> --}}
                                                    {{--                                                                </div> --}}
                                                    {{--                                                            </div> --}}





                                                    {{--                                                             sale ------------------------------------------------------------------------------------- --}}
                                                    {{--                                                            <div class="row mb-3"> --}}
                                                    {{--                                                                <label for="example-text-input" --}}
                                                    {{--                                                                       class="col-sm-2 col-form-label">{{ trans('admin.sale') }}</label> --}}
                                                    {{--                                                                <div class="col-sm-10"> --}}
                                                    {{--                                                                    <input class="form-control" type="text" disabled --}}
                                                    {{--                                                                           value="{{$detail->sale}}" id="sale"> --}}
                                                    {{--                                                                </div> --}}
                                                    {{--                                                            </div> --}}





                                                    {{--                                                             price_after_sale ------------------------------------------------------------------------------------- --}}
                                                    {{--                                                            <div class="row mb-3"> --}}
                                                    {{--                                                                <label for="example-text-input" --}}
                                                    {{--                                                                       class="col-sm-2 col-form-label">{{ trans('admin.price_after_sale') }}</label> --}}
                                                    {{--                                                                <div class="col-sm-10"> --}}
                                                    {{--                                                                    <input class="form-control" type="text" disabled --}}
                                                    {{--                                                                           value="{{$detail->price_after_sale}}" --}}
                                                    {{--                                                                           id="price_after_sale"> --}}
                                                    {{--                                                                </div> --}}
                                                    {{--                                                            </div> --}}






                                                    {{--                                                             quantity ------------------------------------------------------------------------------------- --}}
                                                    {{--                                                            <div class="row mb-3"> --}}
                                                    {{--                                                                <label for="example-text-input" --}}
                                                    {{--                                                                       class="col-sm-2 col-form-label">{{ trans('admin.quantity') }}</label> --}}
                                                    {{--                                                                <div class="col-sm-10"> --}}
                                                    {{--                                                                    <input class="form-control" type="text" disabled --}}
                                                    {{--                                                                           value="{{$detail->quantity}}" id="quantity"> --}}
                                                    {{--                                                                </div> --}}
                                                    {{--                                                            </div> --}}







                                                    {{--                                                             total ------------------------------------------------------------------------------------- --}}
                                                    {{--                                                            <div class="row mb-3"> --}}
                                                    {{--                                                                <label for="example-text-input" --}}
                                                    {{--                                                                       class="col-sm-2 col-form-label">{{ trans('admin.total') }}</label> --}}
                                                    {{--                                                                <div class="col-sm-10"> --}}
                                                    {{--                                                                     <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$orders->trans->where('locale',$locale)->first()->title}}" id="title"> --}}
                                                    {{--                                                                    <input class="form-control" type="text" disabled --}}
                                                    {{--                                                                           value="{{$detail->total}}" id="total"> --}}
                                                    {{--                                                                </div> --}}
                                                    {{--                                                            </div> --}}




                                                    {{--                                                             refund_status ------------------------------------------------------------------------------------- --}}
                                                    {{--                                                            <div class="row mb-3"> --}}
                                                    {{--                                                                <label for="example-text-input" --}}
                                                    {{--                                                                       class="col-sm-2 col-form-label">{{ trans('admin.refund_status') }}</label> --}}
                                                    {{--                                                                <div class="col-sm-10"> --}}
                                                    {{--                                                                     <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$orders->trans->where('locale',$locale)->first()->title}}" id="title"> --}}
                                                    {{--                                                                    <input type="hidden" value="{{$detail->id}}" --}}
                                                    {{--                                                                           name="detail_id[]"> --}}

                                                    {{--                                                                                                                                        <input class="form-control" type="number" --}}
                                                    {{--                                                                                                                                               name="refund_status[]" --}}
                                                    {{--                                                                                                                                               value="{{$detail->refund_status}}" --}}
                                                    {{--                                                                                                                                               id="refund_status"> --}}

                                                    {{--                                                                    <select class="form-control" --}}
                                                    {{--                                                                            name="refund_status[]" --}}

                                                    {{--                                                                            id="refund_status"> --}}
                                                    {{--                                                                        <option value="0" {{$detail->refund_status == 0 ? 'selected' : ''}}>@lang('admin.not_refunded')</option> --}}
                                                    {{--                                                                        <option value="1" {{$detail->refund_status == 1 ? 'selected' : ''}}>@lang('admin.refunded')</option> --}}

                                                    {{--                                                                    </select> --}}

                                                    {{--                                                                </div> --}}
                                                    {{--                                                            </div> --}}


                                                    {{--                                                            <hr> --}}


                                                    {{--                                                        @endforeach --}}

                                                    {{--                                                    @endif --}}

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>



                                <div class="col-md-12">
                                    <div class="accordion mt-4 mb-4" id="accordionExamplestatus">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOnestatus">
                                                <button class="accordion-button fw-medium" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOnestatus"
                                                    aria-expanded="true" aria-controls="collapseOnestatus">
                                                    @lang('admin.order_status_details')
                                                </button>
                                            </h2>
                                            <div id="collapseOnestatus" class="accordion-collapse collapse show mt-3"
                                                aria-labelledby="headingOnestatus"
                                                data-bs-parent="#accordionExamplestatus">
                                                <div class="accordion-body">
                                                    <table class="table m-auto   w-50 p-5"
                                                        style="background-color: rgba(0,0,0,0.7)">

                                                        <thead>
                                                            <tr class=" text-white ">

                                                                <th>@lang('admin.status')</th>
                                                                <th>@lang('admin.created_at')</th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($orders->orderStatus as $item)
                                                                <tr
                                                                    style="background-color: {{ \App\Enums\OrderStatusEnum::colors[$item->status] ?? '' }}">
                                                                    <td class="p-2">{{ __('admin.' . $item->status) }}
                                                                    </td>
                                                                    <td class="p-2">{{ $item->created_at }}</td>


                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                    {{--                                                    @endif --}}












                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-12">
                                    <div class="accordion mt-4 mb-4" id="accordionExamplestatusShipping">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOnestatusShipping">
                                                <button class="accordion-button fw-medium" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOnestatusShipping"
                                                    aria-expanded="true" aria-controls="collapseOnestatusShipping">
                                                    @lang('admin.shipping_order_status_details')
                                                </button>
                                            </h2>
                                            <div id="collapseOnestatusShipping"
                                                class="accordion-collapse collapse show mt-3"
                                                aria-labelledby="headingOnestatusShipping"
                                                data-bs-parent="#accordionExamplestatusShipping">
                                                <div class="accordion-body">





                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-12 col-md-10 hh-grayBox pt45 pb20">
                                                                {{--                                                                <div class="row justify-content-between"> --}}
                                                                <div class="row">

                                                                    @foreach ($orders->shippingOrderStatus as $item)
                                                                        @if ($item->shipped_status)
                                                                            <div style="color: {{ \App\Enums\ShippingEnum::colors[$item->shipped_status] ?? '' }}"
                                                                                class="order-tracking completed">
                                                                                <span class="is-complete"
                                                                                    style="border-color: #27aa80; border-width: 0; background-color: {{ \App\Enums\ShippingEnum::colors[$item->shipped_status] ?? '' }};"></span>

                                                                                <p
                                                                                    style="color: {{ \App\Enums\ShippingEnum::colors[$item->shipped_status] ?? '' }}">
                                                                                    {{ __('admin.' . App\Enums\ShippingEnum::values()[$item->shipped_status]) }}<br><span>{{ $item->created_at }}</span>
                                                                                </p>


                                                                            </div>
                                                                        @endif
                                                                    @endforeach

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>





                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>



                                <div class="row mb-3 text-end">
                                    <div>
                                        {{--                                        <button type="submit" --}}
                                        {{--                                                class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.submit')</button> --}}

                                        <a href="{{ route('admin.orders.index') }}"
                                            class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div> <!-- end row-->

    </div> <!-- container-fluid -->

@endsection


@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
@endsection
