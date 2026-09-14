@extends('admin.app')

@section('title', trans('products.show_product_category'))
@section('title_page', trans('products.show', ['name' => $product->transNow?->title]))

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.products.index') }}"
                                class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    @foreach ($languages as $key => $locale)
                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne{{ $key }}"
                                                        aria-expanded="true" aria-controls="collapseOne{{ $key }}">
                                                        {{ trans('lang.' . Locale::getDisplayName($locale)) }}
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
                                                                class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">
                                                                {{-- <input class="form-control" type="text" name="{{ $locale }}[title]" disabled value="{{ @$product->trans->where('locale',$locale)->first()->title}}" id="title{{ $key }}"> --}}
                                                                <input class="form-control" type="text"
                                                                    name="{{ $locale }}[title]" disabled
                                                                    value="{{ $product->trans()->where('locale', $locale)->first()->title }}"
                                                                    id="title{{ $key }}">
                                                            </div>
                                                            @if ($errors->has($locale . '.title'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                            @endif
                                                        </div>


                                                        {{-- slug ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3 slug-section">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>

                                                            <div class="col-sm-10">
                                                                <input type="text" name="{{ $locale }}[slug]"
                                                                    disabled
                                                                    value="{{ $product->trans()->where('locale', $locale)->first()->slug }}"
                                                                    id="slug{{ $key }}" class="form-control slug"
                                                                    required>
                                                            </div>
                                                            @if ($errors->has($locale . '.slug'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                            @endif

                                                            <script>
                                                                $(document).ready(function() {
                                                                    $("#title" + {
                                                                        {
                                                                            $key
                                                                        }
                                                                    }).
                                                                    on('keyup', function() {
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


                                                        {{-- description ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                                @lang('admin.description_in')
                                                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-10 mb-2">

                                                                {!! $product->trans()->where('locale', $locale)?->first()->description !!}


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
                                    @endforeach


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
                                                        {{-- meta info  ------------------------------------------------------------------------------------- --}}

                                                        {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text"
                                                                    name="{{ $locale }}[meta_title]" disabled
                                                                    value="{{ $product->trans()->where('locale', $locale)->first()->meta_title }}"
                                                                    id="title{{ $key }}">
                                                            </div>
                                                            @if ($errors->has($locale . '.meta_title'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                            @endif
                                                        </div>

                                                        {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                                @lang('admin.meta_description_in')
                                                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-10 mb-2">
                                                                {!! $product->trans()->where('locale', $locale)->first()->meta_desc !!}

                                                                @if ($errors->has($locale . '.meta_description'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                                @lang('admin.meta_key_in')
                                                                {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-10 mb-2">
                                                                <textarea name="{{ $locale }}[meta_key]" class="form-control description" disabled> {{ $product->trans()->where('locale', $locale)->first()->meta_key }} </textarea>
                                                                @if ($errors->has($locale . '.meta_key'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <!----------end meta info ----------------->



                                                        <hr>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- images Gellary  --}}
                                    <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingImage">
                                                <button class="accordion-button fw-medium" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseImage"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                    @lang('admin.gallerys')
                                                </button>
                                            </h2>
                                            <div id="collapseImage" class="accordion-collapse collapse show mt-3"
                                                aria-labelledby="headingImage" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row mb-3">
                                                        <div id="images_section"></div>

                                                        @if ($product->galleryGroup && $product->galleryGroup->images && $product->galleryGroup->images->count())

                                                            @forelse($product->galleryGroup->images as $image)
                                                                <div class="col-4 p-5 ">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <img style="width: 100%; height:100px"
                                                                                src="{{ $image->pathInView('products') }}">
                                                                        </div>

                                                                        <div class="card-body">
                                                                            {{-- <h4>{{$image->title}} </h4> --}}
                                                                            <h6> @lang('products.sort')
                                                                                : {{ $image->sort }} </h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                            @endforelse
                                                            {{-- </div> --}}


                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!---end -->

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

                                                        @if (@$product->image != null)
                                                            <div class="col-12">
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-12">
                                                                        <a href="{{ asset($product->pathInView()) }}"
                                                                            target="_blank">
                                                                            <img src="{{ asset($product->pathInView()) }}"
                                                                                alt="" style="width:100%">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        {{-- phone ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-specialty"
                                                                    class="col-sm-2  col-form-label">
                                                                    @lang('products.price')</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" disabled type="text"
                                                                        placeholder="@lang('products.price')" name="price"
                                                                        value="{{ $product->price }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- sale ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-phone"
                                                                    class="col-sm-2  col-form-label">
                                                                    @lang('products.sale')</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" disabled type="text"
                                                                        placeholder="@lang('products.sale')" name="sale"
                                                                        value="{{ $product->sale }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- after sale ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('products.after_sale') }}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" disabled type="number"
                                                                        step="any"
                                                                        value="{{ $product->price - $product->price * ($product->sale / 100) }}">
                                                                </div>
                                                                @error('after_sale')
                                                                    <span class="missiong-spam">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        {{-- code ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-email"
                                                                    class="col-sm-2  col-form-label">
                                                                    @lang('products.code')</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" disabled type="text"
                                                                        placeholder="@lang('products.code')" name="code"
                                                                        value="{{ $product->code }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- sort ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-address"
                                                                    class="col-sm-2  col-form-label">
                                                                    @lang('admin.sort')</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" disabled type="text"
                                                                        placeholder="@lang('admin.sort')" name="sort"
                                                                        value="{{ $product->sort }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- created_by ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-twitter"
                                                                    class="col-sm-2  col-form-label">
                                                                    @lang('products.created_by')</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" disabled type="text"
                                                                        placeholder="@lang('products.created_by')" name="created_by"
                                                                        value="{{ $product->createdBy?->name }}">
                                                                </div>
                                                            </div>
                                                        </div>


                                                        @if ($product->updatedBy && $product->updatedBy->id)
                                                            {{-- updated_by ------------------------------------------------------------------------------------- --}}
                                                            <div class="col-12">
                                                                <div class="row mb-3">
                                                                    <label for="example-number-input"
                                                                        class="col-sm-2 col-form-label"> @lang('products.updated_by')
                                                                        :</label>
                                                                    <div class="col-sm-10">
                                                                        <input class="form-control" disabled
                                                                            type="text"
                                                                            placeholder="@lang('products.updated_by'):"
                                                                            id="example-number-input"
                                                                            value="{{ $product->updatedBy->name }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        {{-- feature ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12 ">
                                                            <label class="col-md-3 col-form-label"
                                                                for="available">{{ trans('admin.feature') }}</label>
                                                            @if ($product->feature == 1)
                                                                <p class="badge  bg-success h3" style="font-size:20px">
                                                                    @lang('admin.yes')</p>
                                                            @else
                                                                <p class="badge  bg-danger h3" style="font-size:20px">
                                                                    @lang('admin.no')</p>
                                                            @endif
                                                        </div>

                                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <label class="col-sm-3 col-form-label"
                                                                for="available">{{ trans('admin.status') }}</label>
                                                            @if ($product->status == 1)
                                                                <p class="badge  bg-success h3" style="font-size:20px">
                                                                    @lang('admin.active')</p>
                                                            @else
                                                                <p class="badge  bg-danger h3" style="font-size:20px">
                                                                    @lang('admin.dis_active')</p>
                                                            @endif
                                                        </div>

                                                        {{-- form ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('admin.form_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">
                                                                {{-- <input class="form-control" type="text" name="{{ $locale }}[form]" disabled value="{{ @$product->trans->where('locale',$locale)->first()->form}}" id="form{{ $key }}"> --}}
                                                                <input class="form-control" type="text"
                                                                    name="{{ $locale }}[form]" disabled
                                                                    value="{{ $product->trans()->where('locale', $locale)->first()->form }}"
                                                                    id="form{{ $key }}">
                                                            </div>
                                                            @if ($errors->has($locale . '.form'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.form') }}</span>
                                                            @endif
                                                        </div>

                                                        {{-- category ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('admin.category_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text"
                                                                    name="{{ $locale }}[category]" disabled
                                                                    value="{{ $product->trans()->where('locale', $locale)->first()->category }}"
                                                                    id="category{{ $key }}">
                                                            </div>
                                                            @if ($errors->has($locale . '.category'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.category') }}</span>
                                                            @endif
                                                        </div>
                                                        {{-- servings ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('admin.servings_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text"
                                                                    name="{{ $locale }}[servings]" disabled
                                                                    value="{{ $product->trans()->where('locale', $locale)->first()->servings }}"
                                                                    id="servings{{ $key }}">
                                                            </div>
                                                            @if ($errors->has($locale . '.servings'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.servings') }}</span>
                                                            @endif
                                                        </div>
                                                        {{-- dispatch ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-12 col-form-label">{{ trans('admin.dispatch_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="text"
                                                                    name="{{ $locale }}[dispatch]" disabled
                                                                    value="{{ $product->trans()->where('locale', $locale)->first()->dispatch }}"
                                                                    id="dispatch{{ $key }}">
                                                            </div>
                                                            @if ($errors->has($locale . '.dispatch'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.dispatch') }}</span>
                                                            @endif
                                                        </div>



                                                        {{-- in_stock ------------------------------------------------------------------------------------- --}}
                                                        {{-- <div class="col-12">
                                                        <label class="col-sm-3 col-form-label"
                                                            for="available">{{ trans('admin.in_stock') }}</label>
                                                        @if ($product->in_stock == 1)
                                                            <p class="badge  bg-success h3" style="font-size:20px">
                                                                @lang('admin.active')</p>
                                                        @else
                                                            <p class="badge  bg-danger h3" style="font-size:20px">
                                                                @lang('admin.dis_active')</p>
                                                        @endif
                                                    </div> --}}
                                                        {{-- show_text ------------------------------------------------------------------------------------- --}}
                                                        {{-- <div class="col-12">
                                                        <label class="col-sm-3 col-form-label"
                                                            for="available">{{ trans('admin.show_text
                                                                                                                        ') }}</label>
                                                        @if ($product->show_text == 1)
                                                            <p class="badge  bg-success h3" style="font-size:20px">
                                                                @lang('admin.active')</p>
                                                        @else
                                                            <p class="badge  bg-danger h3" style="font-size:20px">
                                                                @lang('admin.dis_active')</p>
                                                        @endif
                                                    </div> --}}

                                                        <br>
                                                        {{-- //here --}}
                                                        {{-- <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-2 col-form-label">{{ trans('products.occasions') }}</label>
                                                        <div class="col-sm-10">

                                                            @forelse($product->occasions as $occa)
                                                                <span
                                                                    class="badge bg-primary">{{ $occa->trans->where('locale', $locale)->first()->title }}

                                                                </span>

                                                            @empty
                                                            @endforelse

                                                        </div>
                                                    </div> --}}


                                                        {{-- <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-2 col-form-label">{{ trans('products.category') }}</label>
                                                        <div class="col-sm-10">

                                                            @if ($product->productCat)
                                                                <span
                                                                    class="badge bg-orange">{{ $product->productCat->trans[0]->title }}

                                                                </span>
                                                            @endif

                                                        </div>
                                                    </div> --}}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>




                                    <div class="row mb-3 text-end">
                                        <div>
                                            <a href="{{ route('admin.products.index') }}"
                                                class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                        </div>
                                    </div>
                                </div>


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
