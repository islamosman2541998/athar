@extends('admin.app')

@section('title', trans('products.show_product_category'))
@section('title_page', trans('products.show', ['name' => $service_category->trans ?  @$service_category->trans->where('locale', $current_lang)->first()->title : '']) )

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.events.index') }}"
                               class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form class="row" method="post"
                                  action="{{route('admin.service.update' , $service_category->id)}}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')



                                {{-- title and description--}}
                                <div class="col-md-8">
                                    @foreach ($languages as $key => $locale)

                                        @php $trans = $service_category->trans()->where('locale' , $locale)->first() @endphp
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
                                                                    {{-- <input disabled  class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$service_category->trans->where('locale',$locale)->first()->title}}" id="title{{ $key }}">--}}
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


                                                            {{-- slug ---------------------------------------------------------------------------------------}}
                                                            <div class="row mb-3 slug-section">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('admin.slug_in') .   trans('lang.' .Locale::getDisplayName($locale))}}</label>

                                                                <div class="col-sm-10">
                                                                    <input disabled  type="text" name="{{ $locale }}[slug]"
                                                                           value="{{ $trans->slug}}"
                                                                           id="slug{{ $key }}" class="form-control slug"
                                                                           required>
                                                                </div>
                                                                @if($errors->has( $locale . '.slug'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first( $locale . '.slug') }}</span>
                                                                @endif

                                                                <script>
                                                                    $(document).ready(function () {
                                                                        $("#title" + {
                                                                        {
                                                                            $key
                                                                        }
                                                                    }).
                                                                        on('keyup', function () {
                                                                            var Text = $(this).val();
                                                                            Text = Text.toLowerCase();
                                                                            Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g, '-');
                                                                            $("#slug" + {
                                                                            {
                                                                                $key
                                                                            }
                                                                        }).
                                                                            val(Text);
                                                                        });
                                                                    });

                                                                </script>
                                                            </div>

                                                            @include('admin.layouts.scriptSlug')



                                                            {{-- description ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label"> @lang('admin.description_in') {{trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                                                <div class="col-sm-10 mb-2">


                                                                   <textarea disabled  id="description{{ $key }}"
                                                                              name="{{ $locale }}[description]"> {{ $trans->description }} </textarea>


                                                                    <script type="text/javascript">
                                                                        CKEDITOR.replace('description{{ $key }}', {
                                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                            , filebrowserUploadMethod: 'form'
                                                                        });

                                                                    </script>


                                                                    {{-- {!!  $service_category->transNow->description  !!}--}}


                                                                    @if($errors->has( $locale . '.description'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first( $locale . '.description') }}</span>
                                                                    @endif
                                                                </div>

                                                            </div>



                                                            <br>
                                                            <br>
                                                            <br>
                                                            <!--------------------------start middle page ------------------------>
                                                            {{-- middle_title ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('service_categories.middle_title') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                    <input disabled  class="form-control" value="{{$trans->middle_title ?? old($locale . '.middle_title') }}" name="{{ $locale }}[middle_title]" >
                                                                </div>
                                                                @if ($errors->has($locale . '.middle_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.middle_title') }}</span>
                                                                @endif
                                                            </div>


                                                            {{-- middle_content ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('service_categories.middle_content') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                               <textarea disabled  class="form-control"
                                                                          id="middle_content{{ $key }}"
                                                                          name="{{ $locale }}[middle_content]">
                                                                {{$trans->middle_content ??  old($locale . '.middle_content') }}
                                                                </textarea>


                                                                    <script type="text/javascript">
                                                                        CKEDITOR.replace('middle_content{{ $key }}', {
                                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                            , filebrowserUploadMethod: 'form'
                                                                        });

                                                                    </script>


                                                                </div>
                                                                @if ($errors->has($locale . '.middle_content'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.middle_content') }}</span>
                                                                @endif
                                                            </div>
                                                            <!----------end middle page ------------------------------------------>



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


                                                            {{-- title ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('admin.title_in') .   trans('lang.' .Locale::getDisplayName($locale))}}</label>
                                                                <div class="col-sm-10">
                                                                    {{-- <input disabled  class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$service_category->trans->where('locale',$locale)->first()->title}}" id="title{{ $key }}">--}}
                                                                    <input disabled  class="form-control" type="text"
                                                                           name="{{ $locale }}[title]" value=" "
                                                                           id="title{{ $key }}">
                                                                </div>
                                                                @if($errors->has( $locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first( $locale . '.title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- slug ---------------------------------------------------------------------------------------}}
                                                            <div class="row mb-3 slug-section">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('admin.slug_in') .   trans('lang.' .Locale::getDisplayName($locale))}}</label>

                                                                <div class="col-sm-10">
                                                                    <input disabled  type="text" name="{{ $locale }}[slug]"
                                                                           value="{{old('slug')}}" id="slug{{ $key }}"
                                                                           class="form-control slug" required>
                                                                </div>
                                                                @if($errors->has( $locale . '.slug'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first( $locale . '.slug') }}</span>
                                                                @endif

                                                                <script>
                                                                    $(document).ready(function () {
                                                                        $("#title" + {
                                                                        {
                                                                            $key
                                                                        }
                                                                    }).
                                                                        on('keyup', function () {
                                                                            var Text = $(this).val();
                                                                            Text = Text.toLowerCase();
                                                                            Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g, '-');
                                                                            $("#slug" + {
                                                                            {
                                                                                $key
                                                                            }
                                                                        }).
                                                                            val(Text);
                                                                        });
                                                                    });

                                                                </script>
                                                            </div>
                                                            @include('admin.layouts.scriptSlug')


                                                            {{-- description ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label"> @lang('admin.description_in') {{trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                                                <div class="col-sm-10 mb-2">
                                                                   <textarea disabled  id="description{{ $key }}"
                                                                              name="{{ $locale }}[description]">   </textarea>


                                                                    <script type="text/javascript">
                                                                        CKEDITOR.replace('description{{ $key }}', {
                                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                            , filebrowserUploadMethod: 'form'
                                                                        });

                                                                    </script>


                                                                    {{-- {!!  $service_category->transNow->description  !!}--}}


                                                                    @if($errors->has( $locale . '.description'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first( $locale . '.description') }}</span>
                                                                    @endif
                                                                </div>

                                                            </div>






                                                            <br>
                                                            <br>
                                                            <br>
                                                            <!--------------------------start middle page ------------------------>
                                                            {{-- middle_title ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('service_categories.middle_title') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                                    <input disabled  class="form-control" value="{{  old($locale . '.middle_title') }}" name="{{ $locale }}[middle_title]" >
                                                                </div>
                                                                @if ($errors->has($locale . '.middle_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.middle_title') }}</span>
                                                                @endif
                                                            </div>


                                                            {{-- middle_content ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('service_categories.middle_content') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">

                                                               <textarea disabled  class="form-control"
                                                                          id="middle_content{{ $key }}"
                                                                          name="{{ $locale }}[middle_content]">
                                                                {{ old($locale . '.middle_content') }}
                                                                </textarea>


                                                                    <script type="text/javascript">
                                                                        CKEDITOR.replace('middle_content{{ $key }}', {
                                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                            , filebrowserUploadMethod: 'form'
                                                                        });

                                                                    </script>


                                                                </div>
                                                                @if ($errors->has($locale . '.middle_content'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.middle_content') }}</span>
                                                                @endif
                                                            </div>
                                                            <!----------end middle page ------------------------------------------>



                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endif
                                    @endforeach




                                    {{-- meta info--}}
                                    <div class="accordion mt-4 mb-4 bg-success" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingTwo{{ $key }}">
                                                <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseTwo{{ $key }}" aria-expanded="true"
                                                        aria-controls="collapseTwo{{ $key }}">
                                                    @lang('admin.meta')

                                                </button>
                                            </h2>
                                            <div id="collapseTwo{{ $key }}"
                                                 class="accordion-collapse collapse show mt-3"
                                                 aria-labelledby="headingTwo{{ $key }}"
                                                 data-bs-parent="#accordionExample">
                                                <div class="accordion-body">

                                                    @foreach ($languages as $key => $locale)
                                                        @php $trans_title = $service_category->trans()->where('locale' , $locale)->first() @endphp
                                                        @if( $trans_title )



                                                            {{--meta info  ------------------------------------------------------------------------------------- --}}


                                                            {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input disabled  class="form-control" type="text"
                                                                           name="{{ $locale }}[meta_title]"
                                                                           value="{{$trans_title->meta_title}}"
                                                                           id="title{{ $key }}">
                                                                </div>
                                                                @if($errors->has( $locale . '.meta_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first( $locale . '.meta_title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label"> @lang('admin.meta_description_in') {{ trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                                                <div class="col-sm-10 mb-2">
                                                                   <textarea disabled  id="meta_description{{$key}}"
                                                                              name="{{ $locale }}[meta_desc]"
                                                                              class="form-control description"> {{ $trans_title->meta_desc }} </textarea>
                                                                    {{-- {!! $service_category->transNow->meta_desc !!}--}}

                                                                    <script type="text/javascript">
                                                                        CKEDITOR.replace('meta_description{{ $key }}', {
                                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                            , filebrowserUploadMethod: 'form'
                                                                        });

                                                                    </script>


                                                                    @if($errors->has( $locale . '.meta_description'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first( $locale . '.meta_description') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label"> @lang('admin.meta_key_in') {{ trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                                                <div class="col-sm-10 mb-2">
                                                                   <textarea disabled  name="{{ $locale }}[meta_key]"
                                                                              class="form-control description"> {{$trans_title->meta_key }} </textarea>
                                                                    @if($errors->has( $locale . '.meta_key'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first( $locale . '.meta_key') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <!----------end meta info ----------------->


                                                        @else




                                                            {{--meta info  ------------------------------------------------------------------------------------- --}}

                                                            {{-- slug ---------------------------------------------------------------------------------------}}
                                                            <div class="row mb-3 slug-section">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('admin.slug_in') .   trans('lang.' .Locale::getDisplayName($locale))}}</label>

                                                                <div class="col-sm-10">
                                                                    <input disabled  type="text" name="{{ $locale }}[slug]"
                                                                           value="" id="slug{{ $key }}"
                                                                           class="form-control slug" required>
                                                                </div>
                                                                @if($errors->has( $locale . '.slug'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first( $locale . '.slug') }}</span>
                                                                @endif

                                                                <script>
                                                                    $(document).ready(function () {
                                                                        $("#title" + {
                                                                        {
                                                                            $key
                                                                        }
                                                                    }).
                                                                        on('keyup', function () {
                                                                            var Text = $(this).val();
                                                                            Text = Text.toLowerCase();
                                                                            Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g, '-');
                                                                            $("#slug" + {
                                                                            {
                                                                                $key
                                                                            }
                                                                        }).
                                                                            val(Text);
                                                                        });
                                                                    });

                                                                </script>
                                                            </div>

                                                            {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input disabled  class="form-control" type="text"
                                                                           name="{{ $locale }}[meta_title]" value=""
                                                                           id="title{{ $key }}">
                                                                </div>
                                                                @if($errors->has( $locale . '.meta_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first( $locale . '.meta_title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label"> @lang('admin.meta_description_in') {{ trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                                                <div class="col-sm-10 mb-2">
                                                                   <textarea disabled  id="meta_description{{$key}}"
                                                                              name="{{ $locale }}[meta_desc]"
                                                                              class="form-control description">   </textarea>


                                                                    <script type="text/javascript">
                                                                        CKEDITOR.replace('meta_description{{ $key }}', {
                                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                            , filebrowserUploadMethod: 'form'
                                                                        });

                                                                    </script>


                                                                    {{-- {!! $service_category->transNow->meta_desc !!}--}}

                                                                    @if($errors->has( $locale . '.meta_description'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first( $locale . '.meta_description') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                       class="col-sm-2 col-form-label"> @lang('admin.meta_key_in') {{ trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                                                <div class="col-sm-10 mb-2">
                                                                   <textarea disabled  name="{{ $locale }}[meta_key]"
                                                                              class="form-control description">   </textarea>
                                                                    @if($errors->has( $locale . '.meta_key'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first( $locale . '.meta_key') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <!----------end meta info ----------------->

                                                        @endif
                                                        <hr>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>


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

                                                    @if($service_category->occasions &&   $service_category->occasions->count() )

                                                        @foreach($service_category->occasions as $occ)




                                                            <!----------start -------------------->





                                                                <button type="button" class="btn badge bg-warning  d-inline-block" data-bs-toggle="modal" data-bs-target="#myModal{{$occ->id}}">
                                                                    {{$occ->transNow->title}}
                                                                </button>

                                                                <!-- The Modal -->
                                                                <div class="modal fade" id="myModal{{$occ->id}}">
                                                                    <div class="modal-dialog  modal-lg">
                                                                        <div class="modal-content">

                                                                            <!-- Modal Header -->
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">{{$occ->transNow->title }} </h4>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                            </div>

                                                                            <!-- Modal body -->
                                                                            <div class="modal-body">
                                                                                @foreach($occ->galleryGroup as $group)
                                                                                    <h4> {{$group->transNow->title}}</h4>

                                                                                    @foreach($group->images as $img)
                                                                                        <img width="100" height="100" src="{{asset($img->pathInView('occasions'))}}">
                                                                                    @endforeach

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





                                                            @endforeach
                                                            {{-- images Gellary  --}}
                                                            {{--                                        <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample_image_old">--}}
                                                            {{--                                            <div class="accordion-item border rounded">--}}
                                                            {{--                                                <h2 class="accordion-header" id="headingImage2">--}}
                                                            {{--                                                    <button class="accordion-button fw-medium" type="button"--}}
                                                            {{--                                                            data-bs-toggle="collapse" data-bs-target="#collapseImage2"--}}
                                                            {{--                                                            aria-expanded="true" aria-controls="collapseOne">--}}
                                                            {{--                                                        @lang('admin.current_gallerys')--}}
                                                            {{--                                                    </button>--}}
                                                            {{--                                                </h2>--}}
                                                            {{--                                                <div id="collapseImage2" class="accordion-collapse collapse show mt-3"--}}
                                                            {{--                                                     aria-labelledby="headingImage2"--}}
                                                            {{--                                                     data-bs-parent="#accordionExample_image_old">--}}
                                                            {{--                                                    <div class="accordion-body">--}}
                                                            {{--                                                        <div class="row mb-3">--}}

                                                            {{--                                                            <div class="d-flex">--}}
                                                            {{--                                                                @forelse($service_category->galleryGroup->images as $image)--}}
                                                            {{--                                                                    <div class="col">--}}
                                                            {{--                                                                        <img style="width: 100px; height:100px"--}}
                                                            {{--                                                                             src="{{$image->pathInView('service_category') }}">--}}
                                                            {{--                                                                        <h4>{{$image->title}} </h4>--}}


                                                            {{--                                                                        <h6> @lang('service_categories.sort')--}}
                                                            {{--                                                                            : {{$image->sort}} </h6>--}}
                                                            {{--                                                                        <h6> @lang('service_categories.feature') : <span--}}
                                                            {{--                                                                                class="badge bg-warning">{{$image->feature == 1 ? __('admin.yes') : __('admin.no')}}</span>--}}
                                                            {{--                                                                        </h6>--}}
                                                            {{--                                                                        <h6> @lang('service_categories.status') : <span--}}
                                                            {{--                                                                                class="badge bg-primary"> {{$image->status == 1 ? __('admin.yes') : __('admin.no')}} </span>--}}
                                                            {{--                                                                        </h6>--}}


                                                            {{--                                                                        --}}{{--                                                            <a class="btn btn-danger btn-sm" href="{{\LaravelLocalization::localizeURL(route('admin.service_categories.destroy_product_gallery_image' , $image->id))}}">{{__("admin.delete")}}</a> <br>--}}
                                                            {{--                                                                        <a class="btn btn-danger btn-sm"--}}
                                                            {{--                                                                           href="{{\LaravelLocalization::localizeURL(route('admin.service.gallery.delete' , $image->id))}}">{{__("admin.delete")}}</a>--}}
                                                            {{--                                                                        <br>--}}


                                                            {{--                                                                    </div>--}}
                                                            {{--                                                                @empty--}}
                                                            {{--                                                                @endforelse--}}
                                                            {{--                                                            </div>--}}

                                                            {{--                                                        </div>--}}
                                                            {{--                                                    </div>--}}
                                                            {{--                                                </div>--}}
                                                            {{--                                            </div>--}}

                                                            {{--                                        </div>--}}

                                                        @endif


                                                    </div>
                                                </div>
                                            </div>
                                        </div>





                                </div>


                                {{-- other info--}}
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

                                                    @if( @$service_category->image != null)
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <div class="col-sm-12">
                                                                    <a href="{{ asset( $service_category->pathInView()) }}"
                                                                       target="_blank">
                                                                        <img
                                                                            src="{{asset( $service_category->pathInView())}}"
                                                                            alt="" style="width:100%">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label for="example-number-specialty"
                                                                   class="col-sm-2 col-form-label">
                                                                @lang('service_categories.image')</label>
                                                            <div class="col-sm-10">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label for="example-number-address"
                                                                   class="col-sm-2 col-form-label">
                                                                @lang('admin.sort')</label>
                                                            <div class="col-sm-10">
                                                                <input disabled  class="form-control" type="number"
                                                                       placeholder="@lang('admin.sort')" name="sort"
                                                                       value="{{ $service_category->sort }}">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-2 col-form-label"
                                                               for="available">{{ trans('admin.feature') }}</label>
                                                        <div class="col-sm-10">
                                                            <input disabled  class="form-check form-switch" name="feature"
                                                                   type="checkbox" id="switch1" switch="success"
                                                                   {{ $service_category->feature == 1 ? 'checked' : '' }} value="1">
                                                            <label class="form-label" for="switch1"
                                                                   data-on-label=" @lang('admin.yes') "
                                                                   data-off-label=" @lang('admin.no')"></label>
                                                        </div>
                                                    </div>
                                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-2 col-form-label"
                                                               for="available">{{ trans('admin.status') }}</label>
                                                        <div class="col-sm-10">
                                                            <input disabled  class="form-check form-switch" name="status"
                                                                   type="checkbox" id="switch3" switch="success"
                                                                   {{ $service_category->status == 1 ? 'checked' : '' }} value="1">
                                                            <label class="form-label" for="switch3"
                                                                   data-on-label=" @lang('admin.yes') "
                                                                   data-off-label=" @lang('admin.no')"></label>
                                                        </div>
                                                    </div>


                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                               class="col-sm-2 col-form-label">{{ trans('service_categories.occasions')   }}</label>
                                                        <div class="col-sm-10">
                                                            {{--                                                            <input disabled  class="form-control" type="number"--}}
                                                            {{--                                                                   name="status"--}}
                                                            {{--                                                                   value="{{old('status')}}">--}}


                                                            <select disabled multiple class="form-select form-select-sm select2"
                                                                    name="occasions[]">
                                                                {{--                                                                <option value="" selected--}}
                                                                {{--                                                                        disabled> {{ trans('service_categories.occasions') }}</option>--}}
                                                                @forelse($occasions as $key1 => $val1)


                                                                    @forelse($service_category->occasions as $key2 => $val2)
                                                                        @if($val1->id === $val2->id)
                                                                            <option
                                                                                value="{{$val1->id}}" selected>
                                                                                {{   isset($val1->transNow->title)  ?  $val1->transNow->title : ''}}
                                                                            </option>
                                                                        @else
                                                                            <option
                                                                                value="{{$val1->id}}" {{ old('occasions.' . $key1) == $val1->id   ? 'selected' : '' }}>
                                                                                {{   isset($val1->transNow->title)  ?  $val1->transNow->title : ''}}
                                                                            </option>

                                                                        @endif
                                                                        <option
                                                                            value="{{$val1->id}}" {{ old('occasions.' . $key1) == $val1->id   ? 'selected' : '' }}>
                                                                            {{   isset($val1->transNow->title)  ?  $val1->transNow->title : ''}}
                                                                        </option>

                                                                    @empty
                                                                        <option
                                                                            value="{{$val1->id}}" {{ old('occasions.' . $key1) == $val1->id   ? 'selected' : '' }}>
                                                                            {{   isset($val1->transNow->title)  ?  $val1->transNow->title : ''}}
                                                                        </option>

                                                                    @endforelse
                                                                @empty
                                                                    <option
                                                                        value="{{$val1->id}}" {{ old('occasions.' . $key1) == $val1->id   ? 'selected' : '' }}>
                                                                        {{   isset($val1->transNow->title)  ?  $val1->transNow->title : ''}}
                                                                    </option>

                                                                @endforelse

                                                            </select>

                                                        </div>
                                                        @if ($errors->has($locale . '.status'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first($locale . '.status') }}</span>
                                                        @endif
                                                    </div>

                                                    {{--                                                    <a href="{{url('/admin/pages/' .  $service_category->page->id . '/' .'edit?service=123')}}">page</a>--}}

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mb-3 text-end">
                                    <div>

                                        <a href="{{ route('admin.events.index') }}"
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
