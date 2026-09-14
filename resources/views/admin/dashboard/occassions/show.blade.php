@extends('admin.app')

@section('title', trans('occasions.show'))
@section('title_page', trans('occasions.show', ['name' => $occasion->trans ?  @$occasion->trans->where('locale', $current_lang)->first()->title : '']) )

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a
                                @if(request()->occ_type == "products" )
                                href="{{ route('admin.occasions_products_index.index') }}"
                                @elseif(request()->occ_type == "services")
                                href="{{ route('admin.occasions_services_index.index') }}"
                                @else
                                href="{{ route('admin.occasions.index') }}"
                                @endif
                               class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form class="row" method="post" action="{{route('admin.occasions.update' , $occasion->id)}}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')




                                {{--                                title and description--}}
                                <div class="col-md-8">
                                    @foreach ($languages as $key => $locale)
                                        @php   $trans = $occasion->trans()->where('locale' , $locale)->first()  @endphp
                                        @if( $trans )

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


                                                            {{-- title ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('admin.title_in') .   trans('lang.' .Locale::getDisplayName($locale))}}</label>
                                                                <div class="col-sm-10">
                                                                    {{--                                                        <input disabled  class="form-control" type="text" name="{{ $locale }}[title]"   value="{{ @$occasion->trans->where('locale',$locale)->first()->title}}" id="title{{ $key }}">--}}
                                                                    <input disabled  class="form-control" type="text"
                                                                           name="{{ $locale }}[title]"
                                                                           value="{{ $trans->title}}"
                                                                           id="title{{ $key }}">
                                                                </div>
                                                                @if($errors->has( $locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first( $locale . '.title') }}</span>
                                                                @endif
                                                            </div>



                                                            {{-- description ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">

                                                                  <p> {!!  $trans->title !!}</p>
                                                                    @if ($errors->has($locale . '.description'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                                    @endif
                                                                </div>


                                                            </div>




                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else


                                        @endif
                                    @endforeach








                                    @if(request()->occ_type === "services")
                                        {{-- occasions Gellaries  --}}
                                        <div class="accordion mt-4 mb-4 bg-success" id="accordionExample_occ">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingTwo_occ">
                                                    <button class="accordion-button fw-medium" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseTwo_occ" aria-expanded="true"
                                                            aria-controls="collapseTwo_occ">
                                                        @lang('admin.occasions')

                                                    </button>
                                                </h2>
                                                <div id="collapseTwo_occ"
                                                     class="accordion-collapse collapse show mt-3"
                                                     aria-labelledby="headingTwo_occ"
                                                     data-bs-parent="#accordionExample_occ">
                                                    <div class="accordion-body">
                                                        <strong style="color: grey">press on each occasion to show its galleries</strong>
                                                        <br>
                                                        <br>


                                                             <!----------start -------------------->
                                                                 <button type="button" class="btn badge bg-warning  d-inline-block" data-bs-toggle="modal" data-bs-target="#myModal{{$occasion->id}}">
                                                                    {{$occasion->transNow->title}}
                                                                </button>

                                                                <!-- The Modal -->
                                                                <div class="modal fade" id="myModal{{$occasion->id}}">
                                                                    <div class="modal-dialog  modal-lg">
                                                                        <div class="modal-content">

                                                                            <!-- Modal Header -->
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">{{$occasion->transNow->title }} </h4>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                            </div>

                                                                            <!-- Modal body -->
                                                                            <div class="modal-body">
                                                                                @foreach($occasion->galleryGroup as $group)
                                                                                    <div class="col-12">
                                                                                    <h4> {{$group?->transNow?->title}}</h4>
                                                                                    @foreach($group->images as $img)
                                                                                        <div class="col-2 d-inline-block">
                                                                                        <img width="100" height="100" src="{{asset($img->pathInView('occasions'))}}">
                                                                                    <br>
                                                                                        <small> @lang('products.sort') : {{$img->sort}} </small>
                                                                                        </div>
                                                                                    @endforeach
                                                                                    </div>

                                                                                    <br>
                                                                                    <br>
                                                                                    <br>
                                                                                    <br>

                                                                                @endforeach
                                                                            </div>

                                                                            <!-- Modal footer -->
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                 <!------------end --------------->




                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif



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




                                                    {{-- @if(request()->occ_type == "services") --}}

                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <div class="col-sm-12">
                                                                <a href="{{ $occasion->pathInView() }}" target="_blank">
                                                                    <img src="{{ $occasion->pathInView() }}" alt="" style="width:100%">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- @endif --}}



                                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label for="example-number-address" class="col-sm-2 col-form-label">
                                                                @lang('admin.sort')</label>
                                                            <div class="col-sm-10">
                                                                <input disabled  class="form-control" type="number"
                                                                       placeholder="@lang('admin.sort')"
                                                                       name="sort" value="{{ $occasion->sort }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- created_by ------------------------------------------------------------------------------------- --}}






{{--                                                    --}}{{-- feature ------------------------------------------------------------------------------------- --}}
{{--                                                    <div class="col-12">--}}
{{--                                                        <label class="col-sm-12 col-form-label"--}}
{{--                                                               for="available">{{ trans('admin.feature') }}</label>--}}
{{--                                                        <div class="col-sm-10">--}}
{{--                                                            <input disabled  class="form-check form-switch" name="feature"--}}
{{--                                                                   type="checkbox" id="switch1" switch="success"--}}
{{--                                                                   {{ $occasion->feature == 1 ? 'checked' : '' }} value="1">--}}
{{--                                                            <label class="form-label" for="switch1"--}}
{{--                                                                   data-on-label=" @lang('admin.yes') "--}}
{{--                                                                   data-off-label=" @lang('admin.no')"></label>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    --}}{{-- Status ------------------------------------------------------------------------------------- --}}
{{--                                                    <div class="col-12">--}}
{{--                                                        <label class="col-sm-12 col-form-label"--}}
{{--                                                               for="available">{{ trans('admin.status') }}</label>--}}
{{--                                                        <div class="col-sm-10">--}}
{{--                                                            <input disabled  class="form-check form-switch" name="status"--}}
{{--                                                                   type="checkbox" id="switch3" switch="success"--}}
{{--                                                                   {{ $occasion->status == 1 ? 'checked' : '' }} value="1">--}}
{{--                                                            <label class="form-label" for="switch3"--}}
{{--                                                                   data-on-label=" @lang('admin.yes') "--}}
{{--                                                                   data-off-label=" @lang('admin.no')"></label>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}

                                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12 ">
                                                        <label class="col-md-3 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                                        @if($occasion->featured == 1 )
                                                            <p class="badge  bg-success h3" style="font-size:20px">@lang("admin.yes")</p>
                                                        @else
                                                            <p class="badge  bg-danger h3" style="font-size:20px">@lang("admin.no")</p>
                                                        @endif
                                                    </div>

                                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-3 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                                        @if($occasion->status == 1 )
                                                            <p class="badge  bg-success h3" style="font-size:20px">@lang("admin.active")</p>
                                                        @else
                                                            <p class="badge  bg-danger h3" style="font-size:20px">@lang("admin.dis_active")</p>
                                                        @endif
                                                    </div>


                                                    <br>

                                                    {{-- type ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3 d-none">
                                                        <label for="example-text-input"
                                                               class="col-sm-2 col-form-label">{{ trans('admin.type')  }}</label>
                                                        <div class="col-sm-10">
                                                            <div class="col-sm-10">
                                                                <select disabled class="form-control "
                                                                >
                                                                    <option value=""> @lang('admin.product')</option>
                                                                    <option
                                                                        {{ $occasion->type == 1 ? 'selected' : '' }}    value="1">  @lang('admin.service_category') </option>


                                                                </select>
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


                                        <a
                                            @if(request()->occ_type == "products" )
                                            href="{{ route('admin.occasions_products_index.index') }}"
                                            @elseif(request()->occ_type == "services")
                                            href="{{ route('admin.occasions_services_index.index') }}"
                                            @else
                                            href="{{ route('admin.occasions.index') }}"
                                            @endif
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
                                <input disabled  type="file" name="gallery_image[]"   class="form-control" required>
                            </div>
                            <div class="col-3">
                                <label for="example-number-input"  > @lang("admin.sort"):</label>
                                <input disabled  type="number" name="gallery_sort[]"  class="form-control"  >
                            </div>
                                                        <div class="col-3">
                                <label for="example-number-input"  > @lang("admin.image_title"):</label>
                                <input disabled  type="number" name="gallery_title[]"  class="form-control"  >
                            </div>

                              <div class="col-3">
                                <label for="example-number-input"  > @lang("admin.feature"):</label>
                                <input disabled  type="number" name="gallery_feature[]"  class="form-control"  >
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


@endsection
