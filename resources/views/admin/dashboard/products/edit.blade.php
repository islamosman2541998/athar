@extends('admin.app')

@section('title', trans('products.edit_product'))
@section('title_page', trans('products.edit_product', ['name' => $product->transNow?->title]))

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="row">
            <div class="col-12 m-3">
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form class="row" method="post" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- title and description --}}
                            <div class="col-md-8">
                                @foreach ($languages as $key => $locale)
                                @php $trans = $product->trans->where('locale', $locale)->first(); @endphp
                                @if ($trans)
                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingOne{{ $key }}">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne{{ $key }}" aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                            </button>
                                        </h2>
                                        <div id="collapseOne{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne{{ $key }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                {{-- title ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ old($locale . '.title') ?? $trans->title }}" id="title{{ $key }}">
                                                    </div>
                                                    @if ($errors->has($locale . '.title'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                    @endif
                                                </div>

                                                {{-- slug ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3 slug-section">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="{{ $locale }}[slug]" value="{{ old($locale . '.slug') ?? $trans->slug }}" id="slug{{ $key }}" class="form-control slug" required>
                                                    </div>
                                                    @if ($errors->has($locale . '.slug'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                    @endif
                                                </div>

                                                @include('admin.layouts.scriptSlug')

                                                {{-- description ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.description_in')
                                                        {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ old($locale . '.description') ?? $trans->description }} </textarea>
                                                        <script type="text/javascript">
                                                            CKEDITOR.replace('description{{ $key }}', {
                                                                filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                , filebrowserUploadMethod: 'form'
                                                            });

                                                        </script>
                                                        @if ($errors->has($locale . '.description'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
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
                                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                            </button>
                                        </h2>
                                        <div id="collapseOne{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne{{ $key }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                {{-- title ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" required name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}" id="title{{ $key }}">
                                                    </div>
                                                    @if ($errors->has($locale . '.title'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                    @endif
                                                </div>

                                                {{-- slug ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3 slug-section">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="{{ $locale }}[slug]" value="{{ old($locale . '.slug') }}" id="slug{{ $key }}" class="form-control slug" required>
                                                    </div>
                                                    @if ($errors->has($locale . '.slug'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                    @endif
                                                    <script>
                                                        $(document).ready(function() {
                                                            $("#title" + {
                                                                {
                                                                    $key
                                                                }
                                                            }).on('keyup', function() {
                                                                var Text = $(this).val();
                                                                Text = Text.toLowerCase();
                                                                Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g, '-');
                                                                $("#slug" + {
                                                                    {
                                                                        $key
                                                                    }
                                                                }).val(Text);
                                                            });
                                                        });

                                                    </script>
                                                </div>
                                                @include('admin.layouts.scriptSlug')

                                                {{-- description ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.description_in')
                                                        {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ old($locale . '.description') }} </textarea>
                                                        <script type="text/javascript">
                                                            CKEDITOR.replace('description{{ $key }}', {
                                                                filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                , filebrowserUploadMethod: 'form'
                                                            });

                                                        </script>
                                                        @if ($errors->has($locale . '.description'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach

                                {{-- meta info --}}
                                <div class="accordion mt-4 mb-4 bg-success" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingTwo{{ $key }}">
                                            <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo{{ $key }}" aria-expanded="true" aria-controls="collapseTwo{{ $key }}">
                                                @lang('admin.meta')
                                            </button>
                                        </h2>
                                        <div id="collapseTwo{{ $key }}" class="accordion-collapse collapse mt-3" aria-labelledby="headingTwo{{ $key }}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                @foreach ($languages as $key => $locale)
                                                @php $trans = $product->trans->where('locale', $locale)->first(); @endphp
                                                @if ($trans)
                                                {{-- meta info  ------------------------------------------------------------------------------------- --}}
                                                {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="{{ old($locale . '.meta_title') ?? $trans->meta_title }}" id="title{{ $key }}">
                                                    </div>
                                                    @if ($errors->has($locale . '.meta_title'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                    @endif
                                                </div>

                                                {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_description_in')
                                                        {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea id="meta_description{{ $key }}" name="{{ $locale }}[meta_desc]" class="form-control description">    {!! $trans->meta_desc !!} </textarea>
                                              
                                                        @if ($errors->has($locale . '.meta_description'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_key_in')
                                                        {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {!! $trans->meta_key !!}</textarea>
                                                        @if ($errors->has($locale . '.meta_key'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!----------end meta info ----------------->
                                                @else
                                                {{-- meta info  ------------------------------------------------------------------------------------- --}}
                                                {{-- slug ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3 slug-section">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="{{ $locale }}[slug]" value="{{ old($locale . '.slug') }}" id="slug{{ $key }}" class="form-control slug" required>
                                                    </div>
                                                    @if ($errors->has($locale . '.slug'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                    @endif
                                                    <script>
                                                        $(document).ready(function() {
                                                            $("#title" + {
                                                                {
                                                                    $key
                                                                }
                                                            }).on('keyup', function() {
                                                                var Text = $(this).val();
                                                                Text = Text.toLowerCase();
                                                                Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g, '-');
                                                                $("#slug" + {
                                                                    {
                                                                        $key
                                                                    }
                                                                }).val(Text);
                                                            });
                                                        });

                                                    </script>
                                                </div>

                                                {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" type="text" name="{{ $locale }}[meta_title]" value="{{ old($locale . '.meta_title') }}" id="title{{ $key }}">
                                                    </div>
                                                    @if ($errors->has($locale . '.meta_title'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                    @endif
                                                </div>

                                                {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_description_in')
                                                        {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea id="meta_description{{ $key }}" name="{{ $locale }}[meta_desc]" class="form-control description"> {{ old($locale . '.meta_desc') }} </textarea>
                                                        <script type="text/javascript">
                                                            CKEDITOR.replace('meta_description{{ $key }}', {
                                                                filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                , filebrowserUploadMethod: 'form'
                                                            });

                                                        </script>
                                                        @if ($errors->has($locale . '.meta_description'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.meta_key_in')
                                                        {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                    </label>
                                                    <div class="col-sm-10 mb-2">
                                                        <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{ old($locale . '.meta_key') }} </textarea>
                                                        @if ($errors->has($locale . '.meta_key'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
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


                                @if ($product->galleryGroup && $product->galleryGroup->images && $product->galleryGroup->images->count())
                                {{-- images Gellary  --}}
                                <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample_image_old">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingImage2">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseImage2" aria-expanded="true" aria-controls="collapseOne">
                                                @lang('admin.current_gallerys')
                                            </button>
                                        </h2>
                                        <div id="collapseImage2" class="accordion-collapse collapse show mt-3" aria-labelledby="headingImage2" data-bs-parent="#accordionExample_image_old">
                                            <div class="accordion-body">
                                                <div class="row mb-3">
                                                    <div class="row">
                                                        @forelse($product->galleryGroup->images as $image)
                                                        <div class="col-4 p-5">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <img style="width: 100%; height:100px" src="{{ asset($image->pathInView('products')) }}">
                                                                </div>
                                                                <div class="card-body">
                                                                    <h4>{{ $image->title }} </h4>
                                                                    <h6> @lang('products.sort')
                                                                        : {{ $image->sort }} </h6>
                                                                    <br>
                                                                    <a class="btn btn-danger btn-sm" href="{{ \LaravelLocalization::localizeURL(route('admin.products.destroy_product_gallery_image', $image->id)) }}">
                                                                        <i class="fa fa-trash"></i> </a>
                                                                    <br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @empty
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                {{-- images Gellary  --}}
                                <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample_image">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingImage">
                                            <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseImage" aria-expanded="true" aria-controls="collapseOne">
                                                @lang('admin.update_gallerys')
                                            </button>
                                        </h2>
                                        <div id="collapseImage" class="accordion-collapse collapse mt-3" aria-labelledby="headingImage" data-bs-parent="#accordionExample_image">
                                            <div class="accordion-body">
                                                <div class="row mb-3">
                                                    <input type="hidden" class="form-control" value="0" name="gallery[type]">
                                                    @foreach (config('translatable.locales') as $lang)
                                                    @if ($product->galleryGroup?->translate($lang) && $product->galleryGroup?->translate($lang)->id)
                                                    <input class="d-none" type="text" value="{{ $product->galleryGroup->translate($lang)->id }}" name="gallery[id]">
                                                    @endif
                                                    <div class=" mb-3 col-sm-2 col-form-label">
                                                        <label>@lang('admin.group_title_' . $lang)</label>
                                                    </div>
                                                    <div class=" mb-3 col-sm-10 ">
                                                        <input type="text" class="form-control" value="{{ $product->galleryGroup?->translate($lang)?->title }}" name="gallery[{{ $lang }}][title]">
                                                    </div>
                                                    @endforeach
                                                    <div id="images_section"></div>
                                                    <button type="button" class="btn btn-success form-control mt-3" id="add_images_section">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- other info --}}
                          
                            <div class="col-md-4">
                                <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample_Settings">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingSettings">
                                            <button class="accordion-button fw-medium " type="button" data-bs-toggle="collapse" data-bs-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings">
                                                @lang('admin.settings')
                                            </button>
                                        </h2>
                                        <div id="collapseSettings" class="accordion-collapse collapse show mt-3" aria-labelledby="headingSettings" data-bs-parent="#accordionExample_Settings">
                                            <div class="accordion-body">
    

                                                @if (@$product->image != null)
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <div class="col-sm-12">
                                                            <a href="{{ asset($product->pathInView('products')) }}" target="_blank">
                                                                <img src="{{ asset($product->pathInView('products')) }}" alt="" style="width:100%">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-specialty" class="col-sm-4 col-form-label">
                                                            @lang('products.image')</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="file" placeholder="@lang('products.image')" name="image">
                                                            <span class="text-danger"> Size: 358 x 360</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="example-text-input" class="col-sm-12 col-form-label">{{ trans('products.categories') }}</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-select form-select-sm select2" multiple name="categories[]">
                                                            @forelse($cats as $key2 => $val2)
                                                            <option value="{{ $val2->id }}" {{ in_array($val2->id, $product->productCategoriesProducts->pluck('id')->toArray()) || old('categories.' . $key2) == $val2->id ? 'selected' : '' }}>
                                                                {{ isset($val2->transNow) ? $val2->transNow->title : '' }}
                                                            </option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                    @if ($errors->has('categories'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.status') }}</span>
                                                    @endif
                                                </div>

                                                @livewireStyles
                                                @livewire('admin.calculate-after-sale', ['model' => @$product])
                                                

                                                {{-- code ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-email" class="col-sm-2 col-form-label">
                                                            @lang('products.code')</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" placeholder="@lang('products.code')" name="code" value="{{ $product->code ?? old('code') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- sort ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-address" class="col-sm-2 col-form-label">
                                                            @lang('admin.sort')</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="number" placeholder="@lang('admin.sort')" name="sort" value="{{ $product->sort ?? old('sort') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- URL ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-input" col-form-label>
                                                            @lang('slider.url'):</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="text" id="example-number-input" name="url" value="{{ @$product->url == 'javascript:void(0)' ? '' : @$product->url }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- feature ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <label class="col-sm-2 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-check form-switch" name="feature" type="checkbox" id="switch1" switch="success" {{ $product->feature == 1 || old('feature') == 1 ? 'checked' : '' }} value="1">
                                                        <label class="form-label" for="switch1" data-on-label=" @lang('admin.yes') " data-off-label=" @lang('admin.no')"></label>
                                                    </div>
                                                </div>
                                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <label class="col-sm-2 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-check form-switch" name="status" type="checkbox" id="switch3" switch="success" {{ $product->status == 1 || old('status') == 1 ? 'checked' : '' }} value="1">
                                                        <label class="form-label" for="switch3" data-on-label=" @lang('admin.yes') " data-off-label=" @lang('admin.no')"></label>
                                                    </div>
                                                </div>



                                                <hr>
                                                {{-- Pockets Section --}}
                                                <div class="row mb-3">
                                                    <label class="col-sm-12 col-form-label" for="available">{{ trans('products.medicine_feature') }}</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-check form-switch" name="has_pockets" type="checkbox" id="has_pockets" switch="success" {{ @$product->has_pockets  ? 'checked' : '' }} value="1">
                                                        <label class="form-label" for="has_pockets" data-on-label=" @lang('admin.yes')" data-off-label=" @lang('admin.no')"></label>
                                                    </div>


                                                    <div id="pockets_section" style="{{ $product->has_pockets ? '' : 'display:none;' }}">
                                                        @if ($product->has_pockets && $product->pockets->count())
                                                        @foreach ($product->pockets as $index => $pocket)
                                                        <div class="pocket mb-4 p-3 border rounded" data-index="{{ $index }}">
                                                            <div class="row">
                                                                <div class="col-md-12 mb-2">
                                                                    <label>@lang('products.feature_name_en')</label>
                                                                    <input type="text" name="pockets[en][{{ $index }}]" value="{{ @$pocket->translate('en')->pocket_name }}" class="form-control" required>
                                                                </div>

                                                                <div class="col-md-12 mb-2">
                                                                    <label>@lang('products.feature_name_ar')</label>
                                                                    <input type="text" name="pockets[ar][{{ $index }}]" value="{{ @$pocket->translate('ar')->pocket_name }}" class="form-control" required>
                                                                </div>

                                                                <div class="col-md-12 mb-2">
                                                                    <input hidden type="number" name="pockets[price][{{ $index }}]" value="{{ @$pocket->price }}" class="form-control" step="0.01">
                                                                </div>


                                                                <input type="hidden" name="pockets[id][{{ $index }}]" value="{{ $pocket->id }}">


                                                                <div class="col-md-4 text-end align-self-end mb-2">
                                                                    <button type="button" class="btn btn-danger delete_pocket">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        @endforeach
                                                        @endif
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="button" id="add_pocket" class="btn btn-success" style="{{ $product->has_pockets ? '' : 'display:none;' }}">
                                                            <i class="fa fa-plus"></i>
                                                            @lang('products.add_pocket')
                                                        </button>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="accordion mt-4 mb-4" id="accordionPockets">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingPockets">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePockets" aria-expanded="true" aria-controls="collapsePockets">
                                                    {{ trans('admin.payment_lines') }}
                                                </button>
                                            </h2>
                                            <div id="collapsePockets" class="accordion-collapse collapse show mt-3" aria-labelledby="headingPockets" data-bs-parent="#accordionPockets">
                                                <div class="accordion-body">
                                                    <div class="row mb-3">
                                                        @if ($product->paymentLine)
                                                        @forelse($product->paymentLine as $keyLine => $line)
                                                        <div class="payment_lines-row mb-4 p-4 border border-gray-200 rounded-xl shadow-sm bg-white transition duration-150 ease-in-out">
                                                            <div class="row g-3">
                                                                <input type="hidden" name="lines[{{ $keyLine }}][id]" value="{{ $line->id }}">

                                                                <!-- Multilingual Titles (Full Width) -->
                                                                <div class="col-md-12">
                                                                    <label class="form-label text-sm font-semibold mb-1">Titles</label>
                                                                    <div class="input-group mb-2">
                                                                        <span class="input-group-text bg-indigo-50 border-r-0">EN</span>
                                                                        <input type="text" name="lines[{{ $keyLine }}][title][en]" value="{{ @$line->trans?->where('locale', 'en')?->first()?->title }}" class="form-control" placeholder="{{ trans('products.feature_name_en') }}" required>
                                                                    </div>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text bg-indigo-50 border-r-0">AR</span>
                                                                        <input type="text" name="lines[{{ $keyLine }}][title][ar]" value="{{ @$line->trans?->where('locale', 'ar')?->first()?->title }}" class="form-control" placeholder="{{ trans('products.feature_name_ar') }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label class="form-label text-sm mb-1">links</label>
                                                                    <input type="text" name="lines[{{ $keyLine }}][links]" value="{{ @$line->links}}" class="form-control" required>
                                                                </div>

                                                                <!-- Static Fields (Split Layout) -->
                                                                <div class="col-md-4">
                                                                    <label class="form-label text-sm mb-1">Sort Order</label>
                                                                    <input type="number" name="lines[{{ $keyLine }}][sort]" value="{{ @$line->sort}}" class="form-control" placeholder="e.g., 10" min="1" required>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label class="form-label text-sm mb-1">Color</label>
                                                                    <input type="color" name="lines[{{ $keyLine }}][color]" value="{{ @$line->color}}" class="form-control form-control-color w-full h-10 cursor-pointer" required value="#374151" title="Choose tip color">
                                                                </div>

                                                                <div class="col-md-3 text-end align-self-end">
                                                                    <label class="form-label text-sm mb-1 opacity-0">Action</label>
                                                                    <button type="button" class="btn btn-danger remove_paymentLine w-full">
                                                                        <i class="fa fa-trash me-1"></i> Remove
                                                                    </button>
                                                                </div>

                                                                <div class="col-md-3 pt-2 border-t border-gray-100 mt-2">
                                                                    <label class="form-label text-sm font-semibold me-4">Status:</label>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="lines[{{ $keyLine }}][status]"  value="1" @if(@$line->status == 1) checked @endif>
                                                                        <label class="form-check-label"> Active </label>
                                                                    </div>

                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="lines[{{ $keyLine }}][status]" value="0" @if(@$line->status == '0') checked @endif>
                                                                        <label class="form-check-label"> Inactive </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @empty
                                                        @endforelse
                                                        @endif

                                                        <div id="payment_lines_section_inputs"></div>
                                                        <button type="button" class="btn btn-success mt-3" id="add_payment_lines_section">
                                                            <i class="fa fa-plus"></i> {{ trans('products.payment_lines') }}
                                                        </button>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="accordion mt-4 mb-4" id="accordionSetting3">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingSetting3">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting3" aria-expanded="true" aria-controls="collapseSetting3">
                                                    {{ trans('admin.product_tips') }}
                                                </button>
                                            </h2>
                                            <div id="collapseSetting3" class="accordion-collapse collapse show" aria-labelledby="headingSetting3" data-bs-parent="#accordionSetting3">
                                                <div class="accordion-body">

                                                    @if ($product->tips)
                                                    @forelse($product->tips as $keytip => $tip)
                                                    <input type="hidden" name="tips[{{ $keytip }}][id]" value="{{ $tip->id }}">

                                                    <div class="payment_tips-row mb-4 p-4 border border-gray-200 rounded-xl shadow-sm bg-white transition duration-150 ease-in-out">
                                                        <div class="row g-3">
                                                            <!-- Multilingual Titles (Full Width) -->
                                                            <div class="col-md-12">
                                                                <label class="form-label text-sm font-semibold mb-1">Titles</label>
                                                                <div class="input-group mb-2">
                                                                    <span class="input-group-text bg-indigo-50 border-r-0">EN</span>
                                                                    <input type="text" name="tips[{{ $keytip }}][title][en]" value="{{ @$tip->trans?->where('locale', 'en')?->first()?->title }}" class="form-control" placeholder="{{ trans('products.feature_name_en') }}" required >
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text bg-indigo-50 border-r-0">AR</span>
                                                                    <input type="text" name="tips[{{ $keytip }}][title][ar]" value="{{ @$tip->trans?->where('locale', 'ar')?->first()?->title }}" class="form-control" placeholder="{{ trans('products.feature_name_ar') }}" required >
                                                                </div>
                                                            </div>
                                    
                                                            <div class="col-md-12 pt-3">
                                                                <label class="form-label text-sm font-semibold mb-1">Descriptions</label>
                                                                <div class="input-group mb-2">
                                                                    <span class="input-group-text bg-indigo-50 border-r-0">EN Desc</span>
                                                                    <textarea name="tips[{{ $keytip }}][description][en]" class="form-control" rows="2" placeholder="English description/details" required>{{ @$tip->trans?->where('locale', 'en')?->first()?->description }}</textarea>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text bg-indigo-50 border-r-0">AR Desc</span>
                                                                    <textarea name="tips[{{ $keytip }}][description][ar]" class="form-control" rows="2" placeholder="Arabic description/details" required>{{ @$tip->trans?->where('locale', 'ar')?->first()?->description }}</textarea>
                                                                </div>
                                                            </div>
                                    
                                                            <!-- Static Fields (Split Layout) -->
                                                            <div class="col-md-4">
                                                                <label class="form-label text-sm mb-1">Sort Order</label>
                                                                <input type="number" name="tips[{{ $keytip }}][sort]" class="form-control" placeholder="e.g., 10" value="{{ @$tip->sort }}" min="1" required>
                                                            </div>
                                    
                                                            <div class="col-md-3 text-end align-self-end">
                                                                <label class="form-label text-sm mb-1 opacity-0">Action</label>
                                                                <button type="button" class="btn btn-danger remove_product_tips w-full">
                                                                    <i class="fa fa-trash me-1"></i> Remove
                                                                </button>
                                                            </div>
                                    
                                                            <div class="col-md-3 pt-2 border-t border-gray-100 mt-2">
                                                                <label class="form-label text-sm font-semibold me-4">Status:</label>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="tips[{{ $keytip }}][status]" value="1" @if(@$tip->status == 1) checked @endif>
                                                                    <label class="form-check-label"> Active </label>
                                                                </div>
                                    
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="tips[{{ $keytip }}][status]" value="0" @if(@$tip->status == '0') checked @endif>
                                                                    <label class="form-check-label"> Inactive </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @empty
                                                    @endforelse
                                                    @endif

                                                    {{-- has_product_tips --}}
                                                    <div id="product_tips_section">
                                                        <h4>{{ trans('products.product_tips') }}</h4>
                                                        <div id="product_tips_section_inputs"></div>
                                                        <button type="button" class="btn btn-success mt-3" id="add_product_tips_section">
                                                            <i class="fa fa-plus"></i> {{ trans('products.product_tips') }}
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="accordion mt-4 mb-4" id="accordionSetting4">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingSetting4">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting4" aria-expanded="true" aria-controls="collapseSetting4">
                                                    {{ trans('admin.product_info') }}
                                                </button>
                                            </h2>
                                            <div id="collapseSetting4" class="accordion-collapse collapse show" aria-labelledby="headingSetting4" data-bs-parent="#accordionSetting4">
                                                <div class="accordion-body">
                                                    @if ($product->info)
                                                    @forelse($product->info as $keyInfo => $info)
                                                    <div class="payment_info-row mb-4 p-4 border border-gray-200 rounded-xl shadow-sm bg-white transition duration-150 ease-in-out">
                                                        <div class="row g-3">
                                                            <input type="hidden" name="info[{{ $keyInfo }}][id]" value="{{ $info->id }}">
                                                            <!-- Multilingual Titles (Full Width) -->
                                                            <div class="col-md-12">
                                                                <label class="form-label text-sm font-semibold mb-1">Titles</label>
                                                                <div class="input-group mb-2">
                                                                    <span class="input-group-text bg-indigo-50 border-r-0">EN</span>
                                                                    <input type="text" name="info[{{ $keyInfo }}][title][en]" value="{{ @$info->trans?->where('locale', 'en')?->first()?->title }}" class="form-control" placeholder="{{ trans('products.feature_name_en') }}" required >
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text bg-indigo-50 border-r-0">AR</span>
                                                                    <input type="text" name="info[{{ $keyInfo }}][title][ar]" value="{{ @$info->trans?->where('locale', 'ar')?->first()?->title }}"  class="form-control" placeholder="{{ trans('products.feature_name_ar') }}" required >
                                                                </div>
                                                            </div>
                                    
                                                            <div class="col-md-12 pt-3">
                                                                <label class="form-label text-sm font-semibold mb-1">Descriptions</label>
                                                                <div class="input-group mb-2">
                                                                    <span class="input-group-text bg-indigo-50 border-r-0">EN Desc</span>
                                                                    <textarea id="descriptionInfo_en{{ $keyInfo }}" name="info[{{ $keyInfo }}][description][en]" class="form-control" rows="2" placeholder="English description/details" required>{{ @$info->trans?->where('locale', 'en')?->first()?->description }}</textarea>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text bg-indigo-50 border-r-0">AR Desc</span>
                                                                    <textarea id="descriptionInfo_ar{{ $keyInfo }}" name="info[{{ $keyInfo }}][description][ar]" class="form-control" rows="2" placeholder="Arabic description/details" required>{{ @$info->trans?->where('locale', 'ar')?->first()?->description }}</textarea>
                                                                </div>
                                                            </div>

                                                            <script type="text/javascript">
                                                                CKEDITOR.replace('descriptionInfo_ar{{ $keyInfo }}', {
                                                                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                    , filebrowserUploadMethod: 'form'
                                                                });
                                                            </script>
                                                            <script type="text/javascript">
                                                                CKEDITOR.replace('descriptionInfo_en{{ $keyInfo }}', {
                                                                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                    , filebrowserUploadMethod: 'form'
                                                                });
                                                            </script>
                                    
                                                            <!-- Static Fields (Split Layout) -->
                                                            <div class="col-md-4">
                                                                <label class="form-label text-sm mb-1">Sort </label>
                                                                <input type="number" name="info[{{ $keyInfo }}][sort]" class="form-control" placeholder="e.g., 10" value="{{ @$info->sort }}" min="1" required>
                                                            </div>
                                    
                                                            <div class="col-md-3 text-end align-self-end">
                                                                <label class="form-label text-sm mb-1 opacity-0">Action</label>
                                                                <button type="button" class="btn btn-danger remove_product_info w-full">
                                                                    <i class="fa fa-trash me-1"></i> Remove
                                                                </button>
                                                            </div>
                                    
                                                            <div class="col-md-3 pt-2 border-t border-gray-100 mt-2">
                                                                <label class="form-label text-sm font-semibold me-4">Status:</label>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="info[{{ $keyInfo }}][status]" id="status_active_" value="1" @if(@$info->status == '1') checked @endif>
                                                                    <label class="form-check-label"> Active </label>
                                                                </div>
                                    
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="info[{{ $keyInfo }}][status]" id="status_inactive_" value="0" @if(@$info->status == '0') checked @endif>
                                                                    <label class="form-check-label"> Inactive </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @empty
                                                    @endforelse
                                                    @endif

                                                    {{-- has_product_tips --}}
                                                    <div id="product_info_section">
                                                        <h4>{{ trans('products.product_info') }}</h4>
                                                        <div id="product_info_section_inputs"></div>
                                                        <button type="button" class="btn btn-success mt-3" id="add_product_info_section">
                                                            <i class="fa fa-plus"></i> {{ trans('products.product_info') }}
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <div class="row mb-3 text-end">
                                    <div>
                                        <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.submit')</button>
                                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div> <!-- end row-->
</div>
 <!-- container-fluid -->

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
                                    <label for="example-number-input"  > @lang('admin.image'):</label>
                                <input type="file" name="gallery_image[]"   class="form-control" >
                            </div>
                            <div class="col-3">
                                <label for="example-number-input"  > @lang('admin.sort'):</label>
                                <input type="number" name="gallery_sort[]" required  class="form-control"  >
                            </div>
                            <div class="col-3">
                                <label for="example-number-input"  > @lang('admin.feature'):</label>
                                <input    style="margin-top: 28px;" type="checkbox" name="gallery_feature[]" value="1"     >
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
        });



        //  START Payment Lines -----------------------------------------------------------------------------------------------------------------------------
        let paymentLineIndex = {{ @$keyLine + 1 }};
        $('#add_payment_lines_section').on('click', function() {
            
            // Ensure paymentLineIndex is defined and available in the scope (e.g., let paymentLineIndex = 0;)
            const currentaymentLineIndex = paymentLineIndex++;

            // Use a multi-column grid for better layout
            $('#payment_lines_section_inputs').append(`
                <div class="payment_lines-row mb-4 p-4 border border-gray-200 rounded-xl shadow-sm bg-white transition duration-150 ease-in-out">
                    <div class="row g-3">
                        
                        <!-- Multilingual Titles (Full Width) -->
                        <div class="col-md-12">
                            <label class="form-label text-sm font-semibold mb-1">Titles</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-indigo-50 border-r-0">EN</span>
                                <input type="text" name="lines[${currentaymentLineIndex}][title][en]" class="form-control" placeholder="{{ trans('products.feature_name_en') }}" required >
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-50 border-r-0">AR</span>
                                <input type="text" name="lines[${currentaymentLineIndex}][title][ar]" class="form-control" placeholder="{{ trans('products.feature_name_ar') }}" required >
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label text-sm mb-1">links</label>
                            <input type="text" name="lines[${currentaymentLineIndex}][links]" class="form-control" required>
                        </div>

                        <!-- Static Fields (Split Layout) -->
                        <div class="col-md-4">
                            <label class="form-label text-sm mb-1">Sort Order</label>
                            <input type="number" name="lines[${currentaymentLineIndex}][sort]" class="form-control" placeholder="e.g., 10" value="${currentaymentLineIndex + 1}" min="1" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label text-sm mb-1">Color</label>
                            <input type="color" name="lines[${currentaymentLineIndex}][color]" class="form-control form-control-color w-full h-10 cursor-pointer" required value="#374151" title="Choose tip color">
                        </div>

                        <div class="col-md-3 text-end align-self-end">
                            <label class="form-label text-sm mb-1 opacity-0">Action</label>
                            <button type="button" class="btn btn-danger remove_paymentLine w-full">
                                <i class="fa fa-trash me-1"></i> Remove
                            </button>
                        </div>

                        <div class="col-md-3 pt-2 border-t border-gray-100 mt-2">
                            <label class="form-label text-sm font-semibold me-4">Status:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="lines[${currentaymentLineIndex}][status]" id="status_active_${currentaymentLineIndex}" value="1" checked>
                                <label class="form-check-label" for="status_active_${currentaymentLineIndex}"> Active </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="lines[${currentaymentLineIndex}][status]" id="status_inactive_${currentaymentLineIndex}" value="0">
                                <label class="form-check-label" for="status_inactive_${currentaymentLineIndex}"> Inactive </label>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            // Auto-scroll to the new element
            $('#payment_lines_section_inputs').find('.payment_lines-row').last()[0].scrollIntoView({
                behavior: 'smooth'
            });
        });
        // Required listener for the remove button
        $(document).on('click', '.remove_paymentLine', function() {
            $(this).closest('.payment_lines-row').remove();
        });
        //  END payment Lines -----------------------------------------------------------------------------------------------------------------------------


        
        //  START Payment Tips -----------------------------------------------------------------------------------------------------------------------------
        let productTipsIndex = {{ @$keytip + 1 }};
        console.log("productTipsIndex", productTipsIndex , "key");
        $('#add_product_tips_section').on('click', function() {

            // Ensure productTipsIndex is defined and available in the scope (e.g., let productTipsIndex = 0;)
            const currentProductTipsIndex = productTipsIndex++;

            // Use a multi-column grid for better layout
            $('#product_tips_section_inputs').append(`
                <div class="payment_tips-row mb-4 p-4 border border-gray-200 rounded-xl shadow-sm bg-white transition duration-150 ease-in-out">
                    <div class="row g-3">
                        
                        <!-- Multilingual Titles (Full Width) -->
                        <div class="col-md-12">
                            <label class="form-label text-sm font-semibold mb-1">Titles</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-indigo-50 border-r-0">EN</span>
                                <input type="text" name="tips[${currentProductTipsIndex}][title][en]" class="form-control" placeholder="{{ trans('products.feature_name_en') }}" required >
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-50 border-r-0">AR</span>
                                <input type="text" name="tips[${currentProductTipsIndex}][title][ar]" class="form-control" placeholder="{{ trans('products.feature_name_ar') }}" required >
                            </div>
                        </div>

                        <div class="col-md-12 pt-3">
                            <label class="form-label text-sm font-semibold mb-1">Descriptions</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-indigo-50 border-r-0">EN Desc</span>
                                <textarea name="tips[${currentProductTipsIndex}][description][en]" class="form-control" rows="2" placeholder="English description/details" required></textarea>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-50 border-r-0">AR Desc</span>
                                <textarea name="tips[${currentProductTipsIndex}][description][ar]" class="form-control" rows="2" placeholder="Arabic description/details" required></textarea>
                            </div>
                        </div>

                        <!-- Static Fields (Split Layout) -->
                        <div class="col-md-4">
                            <label class="form-label text-sm mb-1">Sort Order</label>
                            <input type="number" name="tips[${currentProductTipsIndex}][sort]" class="form-control" placeholder="e.g., 10" value="${currentProductTipsIndex + 1}" min="1" required>
                        </div>

                        <div class="col-md-3 text-end align-self-end">
                            <label class="form-label text-sm mb-1 opacity-0">Action</label>
                            <button type="button" class="btn btn-danger remove_product_tips w-full">
                                <i class="fa fa-trash me-1"></i> Remove
                            </button>
                        </div>

                        <div class="col-md-3 pt-2 border-t border-gray-100 mt-2">
                            <label class="form-label text-sm font-semibold me-4">Status:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tips[${currentProductTipsIndex}][status]" id="status_active_${currentProductTipsIndex}" value="1" checked>
                                <label class="form-check-label" for="status_active_${currentProductTipsIndex}"> Active </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tips[${currentProductTipsIndex}][status]" id="status_inactive_${currentProductTipsIndex}" value="0">
                                <label class="form-check-label" for="status_inactive_${currentProductTipsIndex}"> Inactive </label>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            // Auto-scroll to the new element
            $('#product_tips_section_inputs').find('.payment_tips-row').last()[0].scrollIntoView({
                behavior: 'smooth'
            });

        });
        // Required listener for the remove button
        $(document).on('click', '.remove_product_tips', function() {
            $(this).closest('.payment_tips-row').remove();
        });
        //  END Payment Tips -----------------------------------------------------------------------------------------------------------------------------

        
        //  START Payment info -----------------------------------------------------------------------------------------------------------------------------
        let productInfoIndex = {{  @$keyInfo + 1}};
        $('#add_product_info_section').on('click', function() {
            const currentProductInfoIndex = productInfoIndex++;
            
            $('#product_info_section_inputs').append(`
                <div class="payment_info-row mb-4 p-4 border border-gray-200 rounded-xl shadow-sm bg-white transition duration-150 ease-in-out">
                    <div class="row g-3">
                        
                        <!-- Multilingual Titles (Full Width) -->
                        <div class="col-md-12">
                            <label class="form-label text-sm font-semibold mb-1">Titles</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-indigo-50 border-r-0">EN</span>
                                <input type="text" name="info[${currentProductInfoIndex}][title][en]" class="form-control" placeholder="{{ trans('products.feature_name_en') }}" required >
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-50 border-r-0">AR</span>
                                <input type="text" name="info[${currentProductInfoIndex}][title][ar]" class="form-control" placeholder="{{ trans('products.feature_name_ar') }}" required >
                            </div>
                        </div>

                        <div class="col-md-12 pt-3">
                            <label class="form-label text-sm font-semibold mb-1">Descriptions</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-indigo-50 border-r-0">EN Desc</span>
                                <textarea id="descriptionInfo_en${currentProductInfoIndex}" name="info[${currentProductInfoIndex}][description][en]" class="form-control" rows="2" placeholder="English description/details" required></textarea>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-indigo-50 border-r-0">AR Desc</span>
                                <textarea id="descriptionInfo_ar${currentProductInfoIndex}" name="info[${currentProductInfoIndex}][description][ar]" class="form-control" rows="2" placeholder="Arabic description/details" required></textarea>
                            </div>
                        </div>

                        <!-- Static Fields (Split Layout) -->
                        <div class="col-md-4">
                            <label class="form-label text-sm mb-1">Sort </label>
                            <input type="number" name="info[${currentProductInfoIndex}][sort]" class="form-control" placeholder="e.g., 10" value="${currentProductInfoIndex + 1}" min="1" required>
                        </div>

                        <div class="col-md-3 text-end align-self-end">
                            <label class="form-label text-sm mb-1 opacity-0">Action</label>
                            <button type="button" class="btn btn-danger remove_product_info w-full">
                                <i class="fa fa-trash me-1"></i> Remove
                            </button>
                        </div>

                        <div class="col-md-3 pt-2 border-t border-gray-100 mt-2">
                            <label class="form-label text-sm font-semibold me-4">Status:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="info[${currentProductInfoIndex}][status]" id="status_active_${currentProductInfoIndex}" value="1" checked>
                                <label class="form-check-label" for="status_active_${currentProductInfoIndex}"> Active </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="info[${currentProductInfoIndex}][status]" id="status_inactive_${currentProductInfoIndex}" value="0">
                                <label class="form-check-label" for="status_inactive_${currentProductInfoIndex}"> Inactive </label>
                            </div>
                        </div>
                    </div>
                </div>
            `);

            initializeCkeditor(currentProductInfoIndex);

            // Auto-scroll to the new element
            $('#product_info_section_inputs').find('.payment_info-row').last()[0].scrollIntoView({
                behavior: 'smooth'
            });

        });
        // Required listener for the remove button
        $(document).on('click', '.remove_product_info', function() {
            $(this).closest('.payment_info-row').remove();
        });
        //  END Payment INFO -----------------------------------------------------------------------------------------------------------------------------



        //  Start Pockets  -----------------------------------------------------------------------------------------------------------------------------
        // Toggle pockets section based on checkbox
        let pocketIndex = {{ $product->pockets->count() }};

        function togglePocketsSection() {
            if ($('#has_pockets').is(':checked')) {
                $('#pockets_section').show();
                $('#add_pocket').show();
            } else {
                $('#pockets_section').hide();
                $('#add_pocket').hide();
            }
        }
        togglePocketsSection();
        
        $('#has_pockets').on('change', function() {
            togglePocketsSection();
        });

        $('#switch_has_pockets').on('change', function() {
            $('#pockets_section').toggle(this.checked);
        })

        // Add new pocket section
        $('#add_pocket').on('click', function() {
                const currentIndex = pocketIndex++;
                $('#pockets_section').append(`
                <div class="pocket mb-4 p-3 border rounded" data-index="${currentIndex}">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label>@lang('products.pocket_name_en')</label>
                            <input type="text" name="pockets[en][${currentIndex}]" class="form-control" >
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>@lang('products.pocket_name_ar')</label>
                            <input type="text" name="pockets[ar][${currentIndex}]" class="form-control" >
                        </div>
                        <input type="hidden" name="pockets[id][${currentIndex}]" value="new">
                        <div class="col-md-12 text-end align-self-end mb-2">
                            <button type="button" class="btn btn-danger delete_pocket">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `);
        });

        // Remove pocket section
        $('#pockets_section').on('click', '.delete_pocket', function() {
            $(this).closest('.pocket').remove();
        });

        //  End Pockets -----------------------------------------------------------------------------------------------------------------------------

    });

</script>
@endsection
