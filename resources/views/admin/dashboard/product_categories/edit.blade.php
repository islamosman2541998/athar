@extends('admin.app')

@section('title', trans('product_category.edit_product_categories'))
@section('title_page', trans('product_category.edit_product_categories', ['name' => $category->trans ? @$category->trans->where('locale', $current_lang)->first()->title : '']) )

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="row">
            <div class="col-12 m-3">
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.product_category.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form class="row" method="post" action="{{route('admin.product_category.update' , $category->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            {{-- title and description--}}
                            <div class="col-md-8">
                                @foreach ($languages as $key => $locale)
                                @php $trans = $category->trans()->where('locale' , $locale)->first() @endphp
                                @if( isset($trans) )
                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingOne{{ $key }}">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                {{ trans('lang.' .Locale::getDisplayName($locale)) }}
                                            </button>
                                        </h2>
                                        <div id="collapseOne{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne{{ $key }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">


                                                {{-- title ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" name="{{ $locale }}[title]" required id="title{{$key}}" {{--                   value="{{ $model->trans[0]->title ??  old($locale . '.title') }}"--}} value="{{$trans->title}}">
                                                    </div>
                                                    @if ($errors->has($locale . '.title'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                    @endif
                                                </div>


                                                {{-- slug ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('products.slug') .  trans('lang.' .Locale::getDisplayName(@$locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" name="{{ @$locale }}[slug]" id="slug{{$key}}" type="text" value="{{  $trans->slug ??  old($locale . '.slug')}}">
                                                    </div>
                                                    @if ($errors->has($locale . '.slug'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                    @endif
                                                </div>

                                                @include('admin.layouts.scriptSlug')

                                                {{-- description ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.description_in') {{trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ $trans->description ??   old($locale . '.description') }} </textarea>

                                                        <script type="text/javascript">
                                                            CKEDITOR.replace('description{{ $key }}', {
                                                                filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                , filebrowserUploadMethod: 'form'
                                                            });

                                                        </script>
                                                        @if($errors->has( $locale . '.description'))
                                                        <span class="missiong-spam">{{ $errors->first( $locale . '.description') }}</span>
                                                        @endif
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else

                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingOne{{ $key }}">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                {{ trans('lang.' .Locale::getDisplayName($locale)) }}
                                            </button>
                                        </h2>
                                        <div id="collapseOne{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne{{ $key }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">


                                                {{-- title ------------------------------------------------------------------------------------- --}}
                                                {{-- <div class="row mb-3">--}}
                                                {{-- <label for="example-text-input"--}}
                                                {{-- class="col-sm-2 col-form-label">{{ trans('admin.title_in') .   trans('lang.' .Locale::getDisplayName($locale))}}</label>--}}
                                                {{-- <div class="col-sm-10">--}}
                                                {{-- --}}{{-- <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ @$category->trans->where('locale',$locale)->first()->title}}" id="title{{ $key }}">--}}
                                                {{-- <input class="form-control" type="text"--}}
                                                {{-- name="{{ $locale }}[title]"--}}
                                                {{-- value=" "--}}
                                                {{-- id="title{{ $key }}">--}}
                                                {{-- </div>--}}
                                                {{-- @if($errors->has( $locale . '.title'))--}}
                                                {{-- <span--}}
                                                {{-- class="missiong-spam">{{ $errors->first( $locale . '.title') }}</span>--}}
                                                {{-- @endif--}}
                                                {{-- </div>--}}

                                                {{-- title ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') .  trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" required name="{{ $locale }}[title]" id="title{{$key}}" {{--                   value="{{ $model->trans[0]->title ??  old($locale . '.title') }}"--}}>
                                                    </div>
                                                    @if ($errors->has($locale . '.title'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                    @endif
                                                </div>

                                                {{-- slug ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('products.slug') .  trans('lang.' .Locale::getDisplayName(@$locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" name="{{ @$locale }}[slug]" id="slug{{$key}}" type="text" value="{{old($locale . '.slug')}}">
                                                    </div>
                                                    @if ($errors->has($locale . '.slug'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                    @endif
                                                </div>

                                                @include('admin.layouts.scriptSlug')



                                                {{-- slug ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('products.slug') .  trans('lang.' .Locale::getDisplayName(@$locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" name="{{ @$locale }}[slug]" id="slug{{$key}}" type="text" {{--                   value="{{  $model->trans[0]->slug ??  old($locale . '.slug')}}"--}}>
                                                    </div>
                                                    @if ($errors->has($locale . '.slug'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                    @endif
                                                </div>

                                                @include('admin.layouts.scriptSlug')



                                                {{-- title slug livewire ------------------------------------------------------------------------------------- --}}

                                                {{-- description ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.description_in') {{trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ old($locale . '.description')}} </textarea>


                                                        <script type="text/javascript">
                                                            CKEDITOR.replace('description{{ $key }}', {
                                                                filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                , filebrowserUploadMethod: 'form'
                                                            });

                                                        </script>


                                                        {{-- {!!  $trans->description  !!}--}}


                                                        @if($errors->has( $locale . '.description'))
                                                        <span class="missiong-spam">{{ $errors->first( $locale . '.description') }}</span>
                                                        @endif
                                                    </div>

                                                </div>

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
                                            <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo{{ $key }}" aria-expanded="false" aria-controls="collapseTwo{{ $key }}">
                                                @lang('admin.meta')

                                            </button>
                                        </h2>
                                        <div id="collapseTwo{{ $key }}" class="accordion-collapse collapse  mt-3" aria-labelledby="headingTwo{{ $key }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">

                                                @foreach ($languages as $key => $locale)
                                                @php $trans = $category->trans()->where('locale' , $locale)->first() @endphp
                                                @if( $trans )






                                                {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="{{$trans->meta_title}}" id="title{{ $key }}">
                                                    </div>
                                                    @if($errors->has( $locale . '.meta_title'))
                                                    <span class="missiong-spam">{{ $errors->first( $locale . '.meta_title') }}</span>
                                                    @endif
                                                </div>

                                                {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_description_in') {{ trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea id="meta_description{{$key}}" name="{{ $locale }}[meta_desc]" class="form-control description"> {{ $trans->meta_desc ??  old($locale . '.meta_desc') }} </textarea>
                                                        {{-- {!! $trans->meta_desc !!}--}}

                                                        @if($errors->has( $locale . '.meta_description'))
                                                        <span class="missiong-spam">{{ $errors->first( $locale . '.meta_description') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_key_in') {{ trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{$trans->meta_key ??  old($locale . '.meta_key')  }} </textarea>
                                                        @if($errors->has( $locale . '.meta_key'))
                                                        <span class="missiong-spam">{{ $errors->first( $locale . '.meta_key') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!----------end meta info ----------------->


                                                @else




                                                {{--meta info  ------------------------------------------------------------------------------------- --}}


                                                {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="" id="title{{ $key }}">
                                                    </div>
                                                    @if($errors->has( $locale . '.meta_title'))
                                                    <span class="missiong-spam">{{ $errors->first( $locale . '.meta_title') }}</span>
                                                    @endif
                                                </div>

                                                {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_description_in') {{ trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea id="meta_description{{$key}}" name="{{ $locale }}[meta_desc]" class="form-control description"> {{ old($locale . '.meta_desc')}} </textarea>


                                                        <script type="text/javascript">
                                                            CKEDITOR.replace('meta_description{{ $key }}', {
                                                                filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                , filebrowserUploadMethod: 'form'
                                                            });

                                                        </script>


                                                        {{-- {!! $trans->meta_desc !!}--}}

                                                        @if($errors->has( $locale . '.meta_description'))
                                                        <span class="missiong-spam">{{ $errors->first( $locale . '.meta_description') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_key_in') {{ trans('lang.' .Locale::getDisplayName($locale))}} </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{ old($locale . '.meta_key')}} </textarea>
                                                        @if($errors->has( $locale . '.meta_key'))
                                                        <span class="missiong-spam">{{ $errors->first( $locale . '.meta_key') }}</span>
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

                                {{--{{dd($category->galleryGroup )}}--}}
                                {{-- @if($category->galleryGroup && $category->galleryGroup->images     && $category->galleryGroup->images->count()  )--}}
                                {{-- --}}{{-- images Gellary  --}}
                                {{-- <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample_image_old">--}}
                                {{-- <div class="accordion-item border rounded">--}}
                                {{-- <h2 class="accordion-header" id="headingImage2">--}}
                                {{-- <button class="accordion-button fw-medium collapsed" type="button"--}}
                                {{-- data-bs-toggle="collapse"--}}
                                {{-- data-bs-target="#collapseImage2"--}}
                                {{-- aria-expanded="false"--}}
                                {{-- aria-controls="collapseOne">--}}
                                {{-- @lang('admin.current_gallerys')--}}
                                {{-- </button>--}}
                                {{-- </h2>--}}
                                {{-- <div id="collapseImage2"--}}
                                {{-- class="accordion-collapse collapse   mt-3"--}}
                                {{-- aria-labelledby="headingImage2"--}}
                                {{-- data-bs-parent="#accordionExample_image_old">--}}
                                {{-- <div class="accordion-body">--}}

                                {{-- <div class="row mb-3">--}}
                                {{-- @foreach(config('translatable.locales')   as $lang)--}}

                                {{-- <div class=" mb-3 col-sm-2 col-form-label">--}}
                                {{-- <label>@lang('admin.group_title_' . $lang)</label>--}}
                                {{-- </div>--}}
                                {{-- <div class=" mb-3 col-sm-10  ">--}}
                                {{-- <input type="text"--}}
                                {{-- disabled--}}
                                {{-- class="form-control"--}}
                                {{-- value="{{$category->galleryGroup->translate($lang) ?->title}}"--}}
                                {{-- >--}}
                                {{-- </div>--}}
                                {{-- <br>--}}

                                {{-- @endforeach--}}
                                {{-- </div>--}}

                                {{-- <div class="row mb-3">--}}

                                {{-- <div class="row">--}}
                                {{-- @forelse($category->galleryGroup->images as $image)--}}
                                {{-- <div class="col-4 p-5">--}}
                                {{-- <div class="card">--}}
                                {{-- <div class="card-header">--}}
                                {{-- <img style="width: 100%; height:100px"--}}
                                {{-- src="{{$image->pathInView('product_category') }}">--}}
                                {{-- </div>--}}

                                {{-- <div class="card-body">--}}
                                {{-- <h4>{{$image->title}} </h4>--}}
                                {{-- <h6>  @lang('products.sort')--}}
                                {{-- : {{$image->sort}} </h6>--}}
                                {{-- --}}{{-- <h6> @lang('products.feature') : <span--}}
                                {{-- --}}{{-- class="badge bg-warning">{{$image->feature == 1 ? __('admin.yes') : __('admin.no')}}</span>--}}
                                {{-- --}}{{-- </h6>--}}
                                {{-- --}}{{-- <h6> @lang('products.status') : <span--}}
                                {{-- --}}{{-- class="badge bg-primary"> {{$image->status == 1 ? __('admin.yes') : __('admin.no')}} </span>--}}
                                {{-- --}}{{-- </h6>--}}

                                {{-- <br>--}}
                                {{-- <a class="btn btn-danger btn-sm"--}}
                                {{-- href="{{\LaravelLocalization::localizeURL(route('admin.product_category.destroy_product_gallery_image' , $image->id))}}">--}}
                                {{-- <i class="fa fa-trash"></i> </a>--}}

                                {{-- <br>--}}

                                {{-- </div>--}}
                                {{-- </div>--}}
                                {{-- </div>--}}
                                {{-- @empty--}}
                                {{-- @endforelse--}}
                                {{-- </div>--}}

                                {{-- </div>--}}
                                {{-- </div>--}}
                                {{-- </div>--}}
                                {{-- </div>--}}

                                {{-- </div>--}}

                                {{-- @endif--}}

                                {{-- --}}{{-- images Gellary  --}}
                                {{-- <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample_image">--}}
                                {{-- <div class="accordion-item border rounded">--}}
                                {{-- <h2 class="accordion-header" id="headingImage">--}}
                                {{-- <button class="accordion-button fw-medium collapsed" type="button"--}}
                                {{-- data-bs-toggle="collapse"--}}
                                {{-- data-bs-target="#collapseImage"--}}
                                {{-- aria-expanded="false"--}}
                                {{-- aria-controls="collapseOne">--}}
                                {{-- @lang('admin.update_gallerys')--}}
                                {{-- </button>--}}
                                {{-- </h2>--}}
                                {{-- <div id="collapseImage"--}}
                                {{-- class="accordion-collapse collapse   mt-3"--}}
                                {{-- aria-labelledby="headingImage"--}}
                                {{-- data-bs-parent="#accordionExample_image">--}}
                                {{-- <div class="accordion-body">--}}
                                {{-- <div class="row mb-3">--}}
                                {{-- <input type="hidden"--}}
                                {{-- class="form-control"--}}
                                {{-- value="1"--}}
                                {{-- name="gallery[type]">--}}

                                {{-- @foreach(config('translatable.locales')   as $lang)--}}

                                {{-- @if($category->galleryGroup && $category->galleryGroup->translate($lang)   && $category->galleryGroup->translate($lang) ->id)--}}
                                {{-- <input type="hidden"--}}
                                {{-- value="{{$category->galleryGroup->translate($lang) ?->id  }}"--}}
                                {{-- name="gallery[id]">--}}

                                {{-- <div class=" mb-3 col-sm-2 col-form-label">--}}

                                {{-- <label>@lang('admin.group_title_' . $lang)</label>--}}
                                {{-- </div>--}}

                                {{-- <div class=" mb-3 col-sm-10 ">--}}
                                {{-- <input type="text"--}}
                                {{-- class="form-control"--}}
                                {{-- value="{{$category->galleryGroup->translate($lang) ?->title}}"--}}
                                {{-- name="gallery[{{ $lang }}][title]">--}}
                                {{-- </div>--}}


                                {{-- @else--}}



                                {{-- --}}{{-- <input type="hidden"--}}
                                {{-- --}}{{-- value="{{$category->galleryGroup->translate($lang) ?->id  }}"--}}
                                {{-- --}}{{-- name="gallery[id]">--}}

                                {{-- <div class=" mb-3 col-sm-2 col-form-label">--}}

                                {{-- <label>@lang('admin.group_title_' . $lang)</label>--}}
                                {{-- </div>--}}

                                {{-- <div class=" mb-3 col-sm-10 ">--}}
                                {{-- <input type="text"--}}
                                {{-- class="form-control"--}}
                                {{-- value=""--}}
                                {{-- name="gallery[{{ $lang }}][title]">--}}
                                {{-- </div>--}}

                                {{-- @endif--}}

                                {{-- @endforeach--}}


                                {{-- <div id="images_section"></div>--}}
                                {{-- <button type="button" class="btn btn-success form-control mt-3"--}}
                                {{-- id="add_images_section">--}}
                                {{-- <i class="fa fa-plus"></i>--}}
                                {{-- </button>--}}
                                {{-- </div>--}}
                                {{-- </div>--}}
                                {{-- </div>--}}
                                {{-- </div>--}}

                                {{-- </div>--}}


                            </div>


                            {{-- other info--}}
                            <div class="col-md-4">
                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                {{ trans('admin.settings') }}
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">

                                                @if( @$category->image != null)
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <div class="col-sm-12">
                                                            <a href="{{ asset( $category->pathInView()) }}" target="_blank">
                                                                <img src="{{ asset( $category->pathInView()) }}" alt="" style="width:100%">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-specialty" class="col-form-label">
                                                            @lang('products.image')
                                                        </label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="file" placeholder="@lang('products.image')" name="image">
                                                        </div>
                                                    </div>
                                                </div>


                                                {{-- --}}{{-- phone ------------------------------------------------------------------------------------- --}}
                                                {{-- <div class="col-12">--}}
                                                {{-- <div class="row mb-3">--}}
                                                {{-- <label for="example-number-specialty" col-form-label>--}}
                                                {{-- @lang('products.price')</label>--}}
                                                {{-- <div class="col-sm-12">--}}
                                                {{-- <input class="form-control" type="number" step="any"--}}
                                                {{-- placeholder="@lang('products.price')"--}}
                                                {{-- name="price" value="{{ $category->price }}">--}}
                                                {{-- </div>--}}
                                                {{-- </div>--}}
                                                {{-- </div>--}}
                                                {{-- --}}{{-- sale ------------------------------------------------------------------------------------- --}}
                                                {{-- <div class="col-12">--}}
                                                {{-- <div class="row mb-3">--}}
                                                {{-- <label for="example-number-phone" col-form-label>--}}
                                                {{-- @lang('products.sale')</label>--}}
                                                {{-- <div class="col-sm-12">--}}
                                                {{-- <input class="form-control" type="number" step="any"--}}
                                                {{-- placeholder="@lang('products.sale')" name="sale"--}}
                                                {{-- value="{{ $category->sale }}">--}}
                                                {{-- </div>--}}
                                                {{-- </div>--}}
                                                {{-- </div>--}}
                                                {{-- --}}{{-- code ------------------------------------------------------------------------------------- --}}
                                                {{-- <div class="col-12">--}}
                                                {{-- <div class="row mb-3">--}}
                                                {{-- <label for="example-number-email" col-form-label>--}}
                                                {{-- @lang('products.code')</label>--}}
                                                {{-- <div class="col-sm-12">--}}
                                                {{-- <input class="form-control" type="text"--}}
                                                {{-- placeholder="@lang('products.code')" name="code"--}}
                                                {{-- value="{{ $category->code }}">--}}
                                                {{-- </div>--}}
                                                {{-- </div>--}}
                                                {{-- </div>--}}
                                                {{-- sort ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-address" col-form-label>
                                                            @lang('admin.sort')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="number" placeholder="@lang('admin.sort')" name="sort" value="{{ $category->sort }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- created_by ------------------------------------------------------------------------------------- --}}
                                                {{-- <div class="col-12">--}}
                                                {{-- <div class="row mb-3">--}}
                                                {{-- <label for="example-number-twitter" col-form-label>--}}
                                                {{-- @lang('admin.created_by')</label>--}}
                                                {{-- <div class="col-sm-12">--}}
                                                {{-- <input class="form-control" type="text"--}}
                                                {{-- placeholder="@lang('admin.created_by')"--}}
                                                {{-- name="created_by"--}}
                                                {{-- value="{{ $category->createdBy->name }}">--}}
                                                {{-- </div>--}}
                                                {{-- </div>--}}
                                                {{-- </div>--}}


                                                {{-- @if($category->updatedBy && $category->updatedBy->id)--}}
                                                {{-- --}}{{-- updated_by ------------------------------------------------------------------------------------- --}}
                                                {{-- <div class="col-12">--}}
                                                {{-- <div class="row mb-3">--}}
                                                {{-- <label for="example-number-input"--}}
                                                {{-- col-form-label> @lang('admin.updated_by')--}}
                                                {{-- :</label>--}}
                                                {{-- <div class="col-sm-12">--}}
                                                {{-- <input class="form-control" type="number"--}}
                                                {{-- placeholder="@lang('admin.updated_by'):"--}}
                                                {{-- id="example-number-input"--}}
                                                {{-- value="{{ $category->updatedBy->name }}">--}}
                                                {{-- </div>--}}
                                                {{-- </div>--}}
                                                {{-- </div>--}}
                                                {{-- @endif--}}








                                                {{-- feature ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <label class="col-sm-12 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-check form-switch" name="feature" type="checkbox" id="switch1" switch="success" {{ $category->feature == 1 ? 'checked' : '' }} value="1">
                                                        <label class="form-label" for="switch1" data-on-label=" @lang('admin.yes') " data-off-label=" @lang('admin.no')"></label>
                                                    </div>
                                                </div>
                                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <label class="col-sm-12 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-check form-switch" name="status" type="checkbox" id="switch3" switch="success" {{ $category->status == 1 ? 'checked' : '' }} value="1">
                                                        <label class="form-label" for="switch3" data-on-label=" @lang('admin.yes') " data-off-label=" @lang('admin.no')"></label>
                                                    </div>
                                                </div>

                                                {{-- annual-occasion--}}
                                                {{--
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label"
                                                               for="available">{{ trans('admin.annual_occasion') }}</label>
                                                <div class="col-sm-10">

                                                    <input class="form-check form-switch" name="annual_occasion" type="checkbox" id="switch5" switch="success" value="1" {{ old('annual_occasion', $category->annual_occasion ?? 0) == 1 ? 'checked' : '' }}>
                                                    <label class="form-label" for="switch5" data-on-label=" @lang('admin.yes') " data-off-label=" @lang('admin.no')"></label>
                                                </div>
                                            </div> --}}

                                            {{-- show_in_bottom--}}

                                            {{-- <div class="col-12">
                                                        <label class="col-sm-12 col-form-label"
                                                               for="available">{{ trans('admin.show_in_bottom') }}</label>
                                            <div class="col-sm-10">

                                                <input class="form-check form-switch" name="show_in_bottom" type="checkbox" id="switch6" switch="success" value="1" {{ old('show_in_bottom', $category->show_in_bottom ?? 0) == 1 ? 'checked' : '' }}>
                                                <label class="form-label" for="switch6" data-on-label=" @lang('admin.yes') " data-off-label=" @lang('admin.no')"></label>
                                            </div>
                                        </div> --}}


                                        {{-- --}}


                                        {{-- <div class="row mb-3">--}}
                                        {{-- <label for="example-text-input"--}}
                                        {{-- class="col-sm-2 col-form-label">{{ trans('products.occasions')   }}</label>--}}
                                        {{-- <div class="col-sm-10">--}}

                                        {{-- @forelse($category->occasions as $occa)--}}
                                        {{-- <span class="badge bg-primary">{{$occa->trans[0]->title}}--}}

                                        {{-- </span>--}}

                                        {{-- @empty--}}
                                        {{-- @endforelse--}}

                                        {{-- </div>--}}
                                        {{-- </div>--}}


                                        {{-- <div class="row mb-3">--}}
                                        {{-- <label for="example-text-input"--}}
                                        {{-- class="col-sm-2 col-form-label">{{ trans('products.edit_to_occasions')   }}</label>--}}
                                        {{-- <div class="col-sm-10">--}}

                                        {{-- <select multiple class="form-select form-select-sm select2"--}}
                                        {{-- name="occasions[]">--}}
                                        {{-- @forelse($occasions as $key1 => $val1)--}}
                                        {{-- <option--}}
                                        {{-- value="{{$val1->id}}" {{ old('occasions.' . $key1) == $val1->id   ? 'selected' : '' }}>--}}
                                        {{-- {{   isset($val1->trans[0])  ?  $val1->trans[0]->title : ''}}--}}
                                        {{-- </option>--}}
                                        {{-- @empty--}}
                                        {{-- @endforelse--}}
                                        {{-- </select>--}}
                                        {{-- </div>--}}
                                        {{-- @if ($errors->has($locale . '.status'))--}}
                                        {{-- <span--}}
                                        {{-- class="missiong-spam">{{ $errors->first($locale . '.status') }}</span>--}}
                                        {{-- @endif--}}
                                        {{-- </div>--}}


                                        {{-- --}}{{-- feature ------------------------------------------------------------------------------------- --}}
                                        {{-- <div class="row mb-3">--}}
                                        {{-- <label for="example-text-input"--}}
                                        {{-- class="col-sm-2 col-form-label">{{ trans('products.feature')  }}</label>--}}
                                        {{-- <div class="col-sm-10">--}}
                                        {{-- <div class="col-sm-12">--}}
                                        {{-- <select class="form-select form-select-sm select2"--}}
                                        {{-- name="feature">--}}
                                        {{-- <option value="" selected--}}
                                        {{-- disabled> {{ trans('products.feature') }}</option>--}}
                                        {{-- <option--}}
                                        {{-- value="1" {{ $category->feature == 1 ? 'selected' : '' }}> {{ trans('products.active') }} </option>--}}

                                        {{-- <option--}}
                                        {{-- value="0" {{  $category->feature == 0 ? 'selected' : '' }}> {{ trans('products.deactive') }} </option>--}}

                                        {{-- </select>--}}
                                        {{-- </div>--}}

                                        {{-- </div>--}}
                                        {{-- @if ($errors->has($locale . '.feature'))--}}
                                        {{-- <span--}}
                                        {{-- class="missiong-spam">{{ $errors->first($locale . '.feature') }}</span>--}}
                                        {{-- @endif--}}
                                        {{-- </div>--}}

                                        {{-- --}}{{-- status ------------------------------------------------------------------------------------- --}}
                                        {{-- <div class="row mb-3">--}}
                                        {{-- <label for="example-text-input"--}}
                                        {{-- class="col-sm-2 col-form-label">{{ trans('products.status')   }}</label>--}}
                                        {{-- <div class="col-sm-10">--}}

                                        {{-- <select class="form-select form-select-sm select2"--}}
                                        {{-- name="status">--}}
                                        {{-- <option value="" selected--}}
                                        {{-- disabled> {{ trans('products.status') }}</option>--}}
                                        {{-- <option--}}
                                        {{-- value="1" {{  $category->status == 1 ? 'selected' : '' }}> {{ trans('products.active') }} </option>--}}

                                        {{-- <option--}}
                                        {{-- value="0" {{  $category->status == 0 ? 'selected' : '' }}> {{ trans('products.deactive') }} </option>--}}

                                        {{-- </select>--}}

                                        {{-- </div>--}}
                                        {{-- @if ($errors->has($locale . '.status'))--}}
                                        {{-- <span--}}
                                        {{-- class="missiong-spam">{{ $errors->first($locale . '.status') }}</span>--}}
                                        {{-- @endif--}}
                                        {{-- </div>--}}

                                    </div>
                                </div>
                            </div>
                    </div>

                </div>

                <div class="row mb-3 text-end">
                    <div>
                        <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.submit')</button>

                        <a href="{{ route('admin.product_category.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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
    $(document).ready(function() {
        $('#add_images_section').on('click', function() {

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
                                <input type="number" name="gallery_sort[]" required  class="form-control"  >
                            </div>


                            {{--                            <div class="col-3">--}}
                            {{--    <label for="example-number-input"  > @lang("admin.image_title_ar"):</label>--}}
                            {{--    <input type="text" name="gallery_title[]"  class="form-control"  >--}}
                            {{--</div>--}}




                              {{--<div class="col-3">--}}
                              {{--  <label for="example-number-input"  > @lang("admin.image_title_en"):</label>--}}
                              {{--  <input type="text" name="gallery_title_en[]"  class="form-control"  >--}}
                              {{--  </div>--}}



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


        $('#images_section').on('click', '.delete_img', function(e) {
            $(this).parent().parent().parent().remove();
        })
    });

</script>

{{-- <script>--}}
{{-- --}}{{--$(document).ready(function () {--}}
{{-- --}}{{-- $('#add_images_section').on('click', function () {--}}
{{-- --}}
{{-- --}}{{-- $('#images_section').append(--}}
{{-- --}}{{-- `--}}
{{-- --}}{{-- <div class="images ">--}}
{{-- --}}{{-- <div class="row">--}}
{{-- --}}{{-- <div class="col-12">--}}
{{-- --}}{{-- <label for="example-number-input"  > @lang("admin.image"):</label>--}}
{{-- --}}{{-- <input type="file" name="gallery_image[]"   class="form-control" required>--}}
{{-- --}}{{-- </div>--}}
{{-- --}}{{-- <div class="col-3">--}}
{{-- --}}{{-- <label for="example-number-input"  > @lang("admin.sort"):</label>--}}
{{-- --}}{{-- <input type="number" name="gallery_sort[]"  class="form-control"  >--}}
{{-- --}}{{-- </div>--}}
{{-- --}}{{-- <div class="col-3">--}}
{{-- --}}{{-- <label for="example-number-input"  > @lang("admin.image_title"):</label>--}}
{{-- --}}{{-- <input type="number" name="gallery_title[]"  class="form-control"  >--}}
{{-- --}}{{-- </div>--}}
{{-- --}}
{{-- --}}{{-- <div class="col-3">--}}
{{-- --}}{{-- <label for="example-number-input"  > @lang("admin.feature"):</label>--}}
{{-- --}}{{-- <input type="number" name="gallery_feature[]"  class="form-control"  >--}}
{{-- --}}{{-- </div>--}}
{{-- --}}
{{-- --}}{{-- <div class="col-12 mt-3">--}}
{{-- --}}{{-- <button class="btn btn-danger delete_img form-control"><i class="fa fa-trash"></i></button>--}}
{{-- --}}{{-- </div>--}}
{{-- --}}{{-- </div>--}}
{{-- --}}{{-- <hr>--}}
{{-- --}}{{-- </div>--}}
{{-- --}}{{-- `--}}
{{-- --}}{{-- )--}}
{{-- --}}
{{-- --}}{{-- });--}}
{{-- --}}
{{-- --}}
{{-- --}}{{-- $('#images_section').on('click', '.delete_img', function (e) {--}}
{{-- --}}{{-- $(this).parent().parent().parent().remove();--}}
{{-- --}}{{-- })--}}
{{-- --}}{{--});--}}
{{-- </script>--}}


@endsection
