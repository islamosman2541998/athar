@extends('admin.app')

@section('title', trans('main_page.edit_product_categories'))
@section('title_page', trans('main_page.edit_product_categories', ['name' => $main->trans ?  @$main->trans->where('locale', $current_lang)->first()->title : '']) )

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.main_page.index') }}"
                               class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form class="row" method="post" action="{{route('admin.main_page.update' , $main->id)}}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')



                                {{--                                title and description--}}
                                <div class="col-md-8">

                                    @foreach ($languages as $key => $locale)

                                    @if( isset($main) )
                                             <div class="accordion mt-4 mb-4" id="accordionExample">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                        <button class="accordion-button fw-medium" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapseOne{{ $key }}"
                                                                aria-expanded="true"
                                                                aria-controls="collapseOne{{ $key }}">
                                                            {{ trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne{{ $key }}"
                                                         class="accordion-collapse collapse show mt-3"
                                                         aria-labelledby="headingOne{{ $key }}"
                                                         data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">

{{--                                                            --}}{{-- title ------------------------------------------------------------------------------------- --}}
{{--                                                            <div class="row mb-3">--}}
{{--                                                                <label for="example-text-input"--}}
{{--                                                                       class="col-sm-2 col-form-label">{{ trans('admin.title_in') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>--}}
{{--                                                                <div class="col-sm-10">--}}
{{--                                                                    <input class="form-control" type="text"--}}
{{--                                                                           name="{{ $locale }}[title]"--}}
{{--                                                                           id="title{{$key}}"--}}
{{--                                                                           --}}{{--                   value="{{ $model->trans[0]->title ??  old($locale . '.title') }}"--}}
{{--                                                                           value="{{$main->transNow->title}}"--}}
{{--                                                                    >--}}
{{--                                                                </div>--}}
{{--                                                                @if ($errors->has($locale . '.title'))--}}
{{--                                                                    <span--}}
{{--                                                                        class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>--}}
{{--                                                                @endif--}}
{{--                                                            </div>--}}

                                                            {{-- company_name   ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.company_name') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                    <input class="form-control"
                                                                           id="company_name{{ $key }}" value="{{$main->transNow->company_name}}"
                                                                           name="{{ $locale }}[company_name]">






                                                                </div>
                                                                @if ($errors->has($locale . '.company_name'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.company_name') }}</span>
                                                                @endif
                                                            </div>





                                                            {{-- main title ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.main_title') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                    <input class="form-control"
                                                                           id="main_title{{ $key }}"
                                                                           name="{{ $locale }}[main_title]"

                                                                    value="{{$main->transNow->main_title}}">






                                                                </div>
                                                                @if ($errors->has($locale . '.main_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.main_title') }}</span>
                                                                @endif
                                                            </div>







                                                            {{-- main description ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.main_desc') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                <textarea class="form-control"
                                                                          id="main_desc{{ $key }}"
                                                                          name="{{ $locale }}[main_desc]">

                                                                    {{$main->transNow->main_desc}}
                                                                </textarea>




                                                                </div>
                                                                @if ($errors->has($locale . '.main_desc'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.main_desc') }}</span>
                                                                @endif
                                                            </div>






                                                            {{--   services_title   ---------------------------------------------------------------------------------------}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.services_title') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                    <input class="form-control"
                                                                           id="services_title{{ $key }}"
                                                                           value="{{$main->transNow->services_title}}"
                                                                           name="{{ $locale }}[services_title]">





                                                                </div>
                                                                @if ($errors->has($locale . '.services_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.services_title') }}</span>
                                                                @endif
                                                            </div>



                                                            {{--                                                                                                                 any   ------------------------------------------------------------------------------------- --}}











                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else

                                            <div class="accordion mt-4 mb-4" id="accordionExample">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                        <button class="accordion-button fw-medium" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapseOne{{ $key }}"
                                                                aria-expanded="true"
                                                                aria-controls="collapseOne{{ $key }}">
                                                            {{ trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne{{ $key }}"
                                                         class="accordion-collapse collapse show mt-3"
                                                         aria-labelledby="headingOne{{ $key }}"
                                                         data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">




                                                            {{-- company_name   ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.company_name') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                    <input class="form-control"
                                                                           id="company_name{{ $key }}" value="{{ old($locale . '.company_name') }}"
                                                                           name="{{ $locale }}[company_name]">






                                                                </div>
                                                                @if ($errors->has($locale . '.company_name'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.company_name') }}</span>
                                                                @endif
                                                            </div>



                                                            {{-- main title ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.main_title') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                    <input class="form-control"
                                                                           id="main_title{{ $key }}"
                                                                           name="{{ $locale }}[main_title]">
                                                                    {{ old($locale . '.main_title') }}





                                                                </div>
                                                                @if ($errors->has($locale . '.main_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.main_title') }}</span>
                                                                @endif
                                                            </div>





                                                            {{-- main description ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.main_desc') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                <textarea class="form-control"
                                                                          id="main_desc{{ $key }}"
                                                                          name="{{ $locale }}[main_desc]">
                                                                {{ old($locale . '.main_desc') }}
                                                                </textarea>




                                                                </div>
                                                                @if ($errors->has($locale . '.main_desc'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.main_desc') }}</span>
                                                                @endif
                                                            </div>






                                                            {{--                                                        services_title   ---------------------------------------------------------------------------------------}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.services_title') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                    <input class="form-control"
                                                                           id="services_title{{ $key }}"
                                                                           value="{{ old($locale . '.services_title') }}"
                                                                           name="{{ $locale }}[services_title]">





                                                                </div>
                                                                @if ($errors->has($locale . '.services_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.services_title') }}</span>
                                                                @endif
                                                            </div>










                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endif

                                    @endforeach







                                        @foreach ($languages as $key => $locale)
                                        <!-----second section ------>
                                            <div class="accordion mt-4 mb-4 bg-primary" id="accordionExampleSlugs{{$key}}">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOneSlugs{{$key}}">
                                                        <button class="accordion-button fw-medium " type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapseOneSlugs{{$key}}"
                                                                aria-expanded="true"
                                                                aria-controls="collapseOneSlugs{{$key}}">
                                                            {{ __('main_page' . '.second_section_' . $locale )  }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOneSlugs{{$key}}"
                                                         class="accordion-collapse collapse show mt-3"
                                                         aria-labelledby="headingOneSlugs{{$key}}"
                                                         data-bs-parent="#accordionExampleSlugs{{$key}}">
                                                        <div class="accordion-body">




                                                            {{-- our_mission_image   ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.our_mission_image') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                    <input class="form-control" type="file"
                                                                           id="our_mission_image{{ $key }}" value="{{ old($locale . '.our_mission_image') }}"
                                                                           name="{{ $locale }}[our_mission_image]">


                                                                </div>
                                                                @if ($errors->has($locale . '.our_mission_image'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.our_mission_image') }}</span>
                                                                @endif
                                                            </div>





                                                            {{-- our_mission_desc   ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.our_mission_desc') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                <textarea  class="form-control"
                                                                           id="our_mission_desc{{ $key }}"
                                                                           name="{{ $locale }}[our_mission_desc]">
                                                                    {{$main->transNow->our_mission_desc ??  old($locale . '.our_mission_desc') }}
                                                                </textarea>

                                                                </div>
                                                                @if ($errors->has($locale . '.our_mission_desc'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.our_mission_desc') }}</span>
                                                                @endif
                                                            </div>




                                                            {{-- happiness_title   ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.happiness_title') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                    <input class="form-control"
                                                                           id="happiness_title{{ $key }}" value="{{ $main->transNow->happiness_title ??old($locale . '.happiness_title') }}"
                                                                           name="{{ $locale }}[happiness_title]">


                                                                </div>
                                                                @if ($errors->has($locale . '.happiness_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.happiness_title') }}</span>
                                                                @endif
                                                            </div>




                                                            {{-- organic_title   ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.organic_title') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                    <input class="form-control"
                                                                           id="organic_title{{ $key }}" value="{{ $main->transNow->organic_title ?? old($locale . '.organic_title') }}"
                                                                           name="{{ $locale }}[organic_title]">


                                                                </div>
                                                                @if ($errors->has($locale . '.organic_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.organic_title') }}</span>
                                                                @endif
                                                            </div>





                                                            {{-- freshness_title   ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.freshness_title') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                    <input class="form-control"
                                                                           id="freshness_title{{ $key }}" value="{{$main->transNow->freshness_title ?? old($locale . '.freshness_title') }}"
                                                                           name="{{ $locale }}[freshness_title]">


                                                                </div>
                                                                @if ($errors->has($locale . '.freshness_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.freshness_title') }}</span>
                                                                @endif
                                                            </div>




                                                            {{-- delivery   ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.delivery') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                    <input class="form-control"
                                                                           id="delivery{{ $key }}" value="{{$main->transNow->delivery ?? old($locale . '.delivery') }}"
                                                                           name="{{ $locale }}[delivery]">


                                                                </div>
                                                                @if ($errors->has($locale . '.delivery'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.delivery') }}</span>
                                                                @endif
                                                            </div>




                                                            <hr>



                                                            {{-- main_last_title   ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.main_last_title') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                    <input class="form-control"
                                                                           id="main_last_title{{ $key }}" value="{{$main->transNow->main_last_title ??   old($locale . '.main_last_title') }}"
                                                                           name="{{ $locale }}[main_last_title]">


                                                                </div>
                                                                @if ($errors->has($locale . '.main_last_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.main_last_title') }}</span>
                                                                @endif
                                                            </div>



                                                            {{-- main_last_desc   ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.main_last_desc') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                    <input class="form-control"
                                                                           id="main_last_desc{{ $key }}" value="{{$main->transNow->main_last_desc ??   old($locale . '.main_last_desc') }}"
                                                                           name="{{ $locale }}[main_last_desc]">


                                                                </div>
                                                                @if ($errors->has($locale . '.main_last_desc'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.main_last_desc') }}</span>
                                                                @endif
                                                            </div>



                                                            <hr>


                                                            {{-- address   ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('main_page.address') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                            <textarea class="form-control"
                                                                      id="address{{ $key }}"
                                                                      name="{{ $locale }}[address]">  {{$main->transNow->address ?? old($locale . '.address') }}  </textarea>


                                                                </div>
                                                                @if ($errors->has($locale . '.address'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.address') }}</span>
                                                                @endif
                                                            </div>













                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!----------end second section ---------->
                                        @endforeach








                                    <!-----third section test ------>
                                        <div class="accordion mt-4 mb-4 bg-primary" id="accordionExampleSlugs321">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOneSlugs321">
                                                    <button class="accordion-button fw-medium " type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOneSlugs321"
                                                            aria-expanded="true"
                                                            aria-controls="collapseOneSlugs321">
                                                        {{ __('main_page.third_section'  )  }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOneSlugs321"
                                                     class="accordion-collapse collapse show mt-3"
                                                     aria-labelledby="headingOneSlugs321"
                                                     data-bs-parent="#accordionExampleSlugs321">
                                                    <div class="accordion-body">



                                                        {{--                                                        '',--}}
                                                        {{--                                                        '',--}}
                                                        {{--                                                        '',--}}
                                                        {{--                                                        'address',--}}





                                                        {{-- phone   ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                   class="col-sm-2 col-form-label">{{ trans('main_page.phone') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <input class="form-control"
                                                                       id="phone" value="{{$main->phone ??  old('phone') }}"
                                                                       name="phone">


                                                            </div>
                                                            @if ($errors->has(  'phone'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first('phone') }}</span>
                                                            @endif
                                                        </div>





                                                        {{-- email   ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                   class="col-sm-2 col-form-label">{{ trans('main_page.email') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <input type="email"  class="form-control"
                                                                       id="email"
                                                                       value="{{$main->email ??   old('email') }}"
                                                                       name="email">



                                                            </div>
                                                            @if ($errors->has('email'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first('email') }}</span>
                                                            @endif
                                                        </div>




                                                        {{-- location   ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                   class="col-sm-2 col-form-label">{{ trans('main_page.location') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <input   class="form-control"
                                                                         id="location"
                                                                         value="{{$main->location }}"
                                                                         name="location">



                                                            </div>
                                                            @if ($errors->has('location'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first('location')}}</span>
                                                            @endif
                                                        </div>








                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!----------end third section ---------->








{{--                                        --}}{{-- images Gellary  --}}
{{--                                    <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample_image">--}}
{{--                                        <div class="accordion-item border rounded">--}}
{{--                                            <h2 class="accordion-header" id="headingImage">--}}
{{--                                                <button class="accordion-button fw-medium" type="button"--}}
{{--                                                        data-bs-toggle="collapse"--}}
{{--                                                        data-bs-target="#collapseImage"--}}
{{--                                                        aria-expanded="true"--}}
{{--                                                        aria-controls="collapseOne">--}}
{{--                                                    @lang('admin.update_gallerys')--}}
{{--                                                </button>--}}
{{--                                            </h2>--}}
{{--                                            <div id="collapseImage"--}}
{{--                                                 class="accordion-collapse collapse show mt-3"--}}
{{--                                                 aria-labelledby="headingImage"--}}
{{--                                                 data-bs-parent="#accordionExample_image">--}}
{{--                                                <div class="accordion-body">--}}
{{--                                                    <div class="row mb-3">--}}
{{--                                                        <div id="images_section"></div>--}}
{{--                                                        <button type="button" class="btn btn-success form-control mt-3"--}}
{{--                                                                id="add_images_section">--}}
{{--                                                            <i class="fa fa-plus"></i>--}}
{{--                                                        </button>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}


                                </div>

                                {{--                                other info--}}
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

                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                @if( @$main->logo)

                                                                <div class="col-sm-3">
                                                                    <a href="{{ asset( $main->pathInView('logo/' , 'logo')) }}"
                                                                       target="_blank">
                                                                        <img src="{{asset( $main->pathInView('logo/' , 'logo'))}}"
                                                                             alt="" style="width:100%">
                                                                    </a>
                                                                </div>
                                                                @endif

                                                                    @if( @$main->first_image)

                                                                <div class="col-sm-3">
                                                                    <a href="{{ asset($main->pathInView('first_image/' , 'first_image')) }}"
                                                                       target="_blank">
                                                                        <img src="{{asset( $main->pathInView('first_image/' , 'first_image') )}}"
                                                                             alt="" style="width:100%">
                                                                    </a>
                                                                </div>
                                                                    @endif

                                                                    @if( @$main->second_image )

                                                                <div class="col-sm-3">
                                                                    <a href="{{asset( $main->pathInView('second_image/' , 'second_image') )}}"
                                                                       target="_blank">
                                                                        <img src="{{asset( $main->pathInView('second_image/' , 'second_image') )}}"
                                                                             alt="" style="width:100%">
                                                                    </a>
                                                                </div>
                                                                    @endif


                                                                    @if( @$main->our_mission_image)

                                                                <div class="col-sm-3">
                                                                    <a href="{{asset( $main->pathInView('our_mission_image/' , 'our_mission_image') )}}"
                                                                       target="_blank">
                                                                        <img src="{{asset( $main->pathInView('our_mission_image/' , 'our_mission_image') )}}"
                                                                             alt="" style="width:100%">
                                                                    </a>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </div>



{{--                                                    <div class="col-12">--}}
{{--                                                        <div class="row mb-3">--}}
{{--                                                            <label for="example-number-specialty" col-form-label>--}}
{{--                                                                @lang('products.image')</label>--}}
{{--                                                            <div class="col-sm-12">--}}
{{--                                                                <input class="form-control" type="file"--}}
{{--                                                                       placeholder="@lang('products.image')"--}}
{{--                                                                       name="image">--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

                                                        {{-- logo ------------------------------------------------------------------------------------- --}}

                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" class='col-form-label'>
                                                                    @lang('products.logo'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="file"
                                                                           placeholder="@lang('products.logo'):"
                                                                           id="example-number-input"
                                                                           name="logo" value="{{ old('logo') }}">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <hr>


                                                        {{-- first_image ------------------------------------------------------------------------------------- --}}

                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" class='col-form-label'>
                                                                    @lang('products.first_image'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="file"
                                                                           placeholder="@lang('products.first_image'):"
                                                                           id="example-number-input"
                                                                           name="first_image" value="{{ old('first_image') }}">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        {{-- second_image ------------------------------------------------------------------------------------- --}}

                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" class='col-form-label'>
                                                                    @lang('products.second_image'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="file"
                                                                           placeholder="@lang('products.second_image'):"
                                                                           id="example-number-input"
                                                                           name="second_image" value="{{ old('second_image') }}">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        {{-- ut mission image ------------------------------------------------------------------------------------- --}}

                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" class='col-form-label'>
                                                                    @lang('products.our_mission_image'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="file"
                                                                           placeholder="@lang('products.our_mission_image'):"
                                                                           id="example-number-input"
                                                                           name="our_mission_image" value="{{ old('our_mission_image') }}">
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <hr>









                                                @if($main->updatedBy && $main->updatedBy->id)
{{--   updated_by ---------------------------------------------------------------------------------------}}
                                                                                                            <div class="col-12">
                                                                                                                <div class="row mb-3">
                                                                                                                    <label for="example-number-input"
                                                                                                                           col-form-label> @lang('admin.updated_by')
                                                                                                                        :</label>
                                                                                                                    <div class="col-sm-12">
                                                                                                                        <input class="form-control" type="number"
                                                                                                                               placeholder="@lang('admin.updated_by'):"
                                                                                                                               id="example-number-input"
                                                                                                                               value="{{ $main->updatedBy->name }}">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        @endif









                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mb-3 text-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.submit')</button>

                                        <a href="{{ route('admin.main_page.index') }}"
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

    <script>
        $(document).ready(function () {
            $('#add_images_section').on('click', function () {

                $('#images_section').append(
                    `
                    <div class="images ">
                        <div class="row">
                            <div class="col-12">
                                    <label for="example-number-input"  > @lang("admin.image"):</label>
                                <input type="file" name="gallery_image[]"   class="form-control" required>
                            </div>
                            <div class="col-3">
                                <label for="example-number-input"  > @lang("admin.sort"):</label>
                                <input type="number" name="gallery_sort[]"  class="form-control"  >
                            </div>
                                                        <div class="col-3">
                                <label for="example-number-input"  > @lang("admin.image_title"):</label>
                                <input type="text" name="gallery_title[]"  class="form-control"  >
                            </div>

                              <div class="col-3">
                                <label for="example-number-input"  > @lang("admin.feature"):</label>
                                <input    style="margin-top: 28px;" type="checkbox" name="gallery_feature[]"    value="1"    >
                            </div>

                            <div class="col-12 mt-3">
                                <button class="btn btn-danger delete_img form-control"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        <hr>
                    </div>
                    `
                )

            });


            $('#images_section').on('click', '.delete_img', function (e) {
                $(this).parent().parent().parent().remove();
            })
        });
    </script>

    {{--    <script>--}}
{{--        --}}{{--$(document).ready(function () {--}}
{{--        --}}{{--    $('#add_images_section').on('click', function () {--}}
{{--        --}}
{{--        --}}{{--        $('#images_section').append(--}}
{{--        --}}{{--            `--}}
{{--        --}}{{--            <div class="images ">--}}
{{--        --}}{{--                <div class="row">--}}
{{--        --}}{{--                    <div class="col-12">--}}
{{--        --}}{{--                            <label for="example-number-input"  > @lang("admin.image"):</label>--}}
{{--        --}}{{--                        <input type="file" name="gallery_image[]"   class="form-control" required>--}}
{{--        --}}{{--                    </div>--}}
{{--        --}}{{--                    <div class="col-3">--}}
{{--        --}}{{--                        <label for="example-number-input"  > @lang("admin.sort"):</label>--}}
{{--        --}}{{--                        <input type="number" name="gallery_sort[]"  class="form-control"  >--}}
{{--        --}}{{--                    </div>--}}
{{--        --}}{{--                                                <div class="col-3">--}}
{{--        --}}{{--                        <label for="example-number-input"  > @lang("admin.image_title"):</label>--}}
{{--        --}}{{--                        <input type="number" name="gallery_title[]"  class="form-control"  >--}}
{{--        --}}{{--                    </div>--}}
{{--        --}}
{{--        --}}{{--                      <div class="col-3">--}}
{{--        --}}{{--                        <label for="example-number-input"  > @lang("admin.feature"):</label>--}}
{{--        --}}{{--                        <input type="number" name="gallery_feature[]"  class="form-control"  >--}}
{{--        --}}{{--                    </div>--}}
{{--        --}}
{{--        --}}{{--                    <div class="col-12 mt-3">--}}
{{--        --}}{{--                        <button class="btn btn-danger delete_img form-control"><i class="fa fa-trash"></i></button>--}}
{{--        --}}{{--                    </div>--}}
{{--        --}}{{--                </div>--}}
{{--        --}}{{--                <hr>--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--            `--}}
{{--        --}}{{--        )--}}
{{--        --}}
{{--        --}}{{--    });--}}
{{--        --}}
{{--        --}}
{{--        --}}{{--    $('#images_section').on('click', '.delete_img', function (e) {--}}
{{--        --}}{{--        $(this).parent().parent().parent().remove();--}}
{{--        --}}{{--    })--}}
{{--        --}}{{--});--}}
{{--    </script>--}}


@endsection
