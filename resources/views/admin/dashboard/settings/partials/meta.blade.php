@extends('admin.app')

@section('title', trans('settings.settings'))
@section('title_page', trans('settings.edit', ['name' => @$settingMain->key]) )


@section('style')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.5.6/full/ckeditor.js"></script>
@endsection

@section('content')

<div class="container-fluid">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <!-- form start -->
                        <form class="form-horizontal" action="{{route('admin.settings.update-custom', $settingMain->key)}}" method="POST" enctype="multipart/form-data" role="form">
                            @csrf

                            <div class="row">
                                <div class="col-md-12">

                                    <!--home page--->
                                    <div class="accordion mt-4 mb-4" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    @lang('settings.home')
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">

                                                    @foreach ($languages as $key => $locale)
                                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" name="home_meta_title_{{ $locale }}" value="{{ @$settings['home_meta_title_' . $locale] }}" id="title{{ $key }}">
                                                        </div>
                                                    </div>

                                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="home_meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['home_meta_description_' . $locale] }} </textarea>
                                                        </div>
                                                    </div>

                                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="home_meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['home_meta_key_' . $locale] }} </textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--AboutUS page--->
                                    <div class="accordion mt-4 mb-4" id="accordionAboutUS">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingAboutUS">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAboutUS" aria-expanded="true" aria-controls="collapseAboutUS">
                                                    @lang('settings.about_us')
                                                </button>
                                            </h2>
                                            <div id="collapseAboutUS" class="accordion-collapse collapse show mt-3" aria-labelledby="headingAboutUS" data-bs-parent="#accordionAboutUS">
                                                <div class="accordion-body">

                                                    @foreach ($languages as $key => $locale)
                                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" name="about_meta_title_{{ $locale }}" value="{{ @$settings['about_meta_title_' . $locale] }}" id="title{{ $key }}">
                                                        </div>
                                                    </div>

                                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="about_meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['about_meta_description_' . $locale] }} </textarea>
                                                        </div>
                                                    </div>

                                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="about_meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['about_meta_key_' . $locale] }} </textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--categories--->
                                    <div class="accordion mt-4 mb-4" id="accordionExamplerepair">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingTreerepair">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTreerepair" aria-expanded="true" aria-controls="collapseTreerepair">
                                                    @lang('admin.categories')
                                                </button>
                                            </h2>
                                            <div id="collapseTreerepair" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTree" data-bs-parent="#accordionExamplerepair">
                                                <div class="accordion-body">

                                                    @foreach ($languages as $key => $locale)
                                                    {{-- meta_title_ ---------------------------------------------------------------------------------------}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.categories_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" name="categories_meta_title_{{ $locale }}" value="{{ @$settings['categories_meta_title_' . $locale] }}" id="title{{ $key }}">
                                                        </div>
                                                    </div>

                                                    {{-- meta_description_ ---------------------------------------------------------------------------------------}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.categories_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="categories_meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['categories_meta_description_' . $locale] }} </textarea>

                                                        </div>
                                                    </div>

                                                    {{-- meta_key_ ---------------------------------------------------------------------------------------}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="categories_meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['categories_meta_key_' . $locale] }} </textarea>

                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!---product--------->
                                    <div class="accordion mt-4 mb-4" id="accordionExampleproduct">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingFourproduct">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourproduct" aria-expanded="true" aria-controls="collapseFourproduct">
                                                    @lang('admin.product')
                                                </button>
                                            </h2>
                                            <div id="collapseFourproduct" class="accordion-collapse collapse show mt-3" aria-labelledby="headingFourproduct" data-bs-parent="#accordionExampleproduct">
                                                <div class="accordion-body">

                                                    @foreach ($languages as $key => $locale)
                                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" name="product_meta_title_{{ $locale }}" value="{{ @$settings['product_meta_title_' . $locale] }}" id="title{{ $key }}">
                                                        </div>
                                                    </div>

                                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="product_meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['product_meta_description_' . $locale] }} </textarea>

                                                        </div>
                                                    </div>

                                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="product_meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['product_meta_key_' . $locale] }} </textarea>

                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Blogs--->
                                    <div class="accordion mt-4 mb-4" id="accordionExampleBlogs">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingFourBlogs">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourBlogs" aria-expanded="true" aria-controls="collapseFourBlogs">
                                                    @lang('admin.blogs')
                                                </button>
                                            </h2>
                                            <div id="collapseFourBlogs" class="accordion-collapse collapse show mt-3" aria-labelledby="headingFourBlogs" data-bs-parent="#accordionExampleBlogs">
                                                <div class="accordion-body">

                                                    @foreach ($languages as $key => $locale)
                                                    {{-- meta_title_--}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" name="blogs_meta_title_{{ $locale }}" value="{{ @$settings['blogs_meta_title_' . $locale] }}" id="title{{ $key }}">
                                                        </div>
                                                    </div>

                                                    {{-- meta_description_--}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="blogs_meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['blogs_meta_description_' . $locale] }} </textarea>
                                                        </div>
                                                    </div>

                                                    {{-- meta_key_--}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="blogs_meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['blogs_meta_key_' . $locale] }} </textarea>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--News--->
                                    <div class="accordion mt-4 mb-4" id="accordionExampleNews">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingFourNews">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourNews" aria-expanded="true" aria-controls="collapseFourNews">
                                                    @lang('admin.news')
                                                </button>
                                            </h2>
                                            <div id="collapseFourNews" class="accordion-collapse collapse show mt-3" aria-labelledby="headingFourNews" data-bs-parent="#accordionExampleNews">
                                                <div class="accordion-body">

                                                    @foreach ($languages as $key => $locale)
                                                    {{-- meta_title_ ---------------------------------------------------------------------------------------}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" name="news_meta_title_{{ $locale }}" value="{{ @$settings['news_meta_title_' . $locale] }}" id="title{{ $key }}">
                                                        </div>
                                                    </div>

                                                    {{-- meta_description_ ---------------------------------------------------------------------------------------}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="news_meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['news_meta_description_' . $locale] }} </textarea>

                                                        </div>
                                                    </div>

                                                    {{-- meta_key_ ---------------------------------------------------------------------------------------}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="news_meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['news_meta_key_' . $locale] }} </textarea>

                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--thank--->
                                    <div class="accordion mt-4 mb-4" id="accordionExampleNews">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingFourNews">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourNews" aria-expanded="true" aria-controls="collapseFourNews">
                                                    @lang('admin.thank_you')
                                                </button>
                                            </h2>
                                            <div id="collapseFourNews" class="accordion-collapse collapse show mt-3" aria-labelledby="headingFourNews" data-bs-parent="#accordionExampleNews">
                                                <div class="accordion-body">

                                                    @foreach ($languages as $key => $locale)
                                                    {{-- meta_title_ ---------------------------------------------------------------------------------------}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" name="thank_meta_title_{{ $locale }}" value="{{ @$settings['thank_meta_title_' . $locale] }}" id="title{{ $key }}">
                                                        </div>
                                                    </div>

                                                    {{-- meta_description_ ---------------------------------------------------------------------------------------}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="thank_meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['thank_meta_description_' . $locale] }} </textarea>

                                                        </div>
                                                    </div>

                                                    {{-- meta_key_ ---------------------------------------------------------------------------------------}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="thank_meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['thank_meta_key_' . $locale] }} </textarea>

                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--faq--->
                                    <div class="accordion mt-4 mb-4" id="accordionExampleFaq">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingFourFaq">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFourFaq" aria-expanded="true" aria-controls="collapseFourFaq">
                                                    @lang('admin.faq')
                                                </button>
                                            </h2>
                                            <div id="collapseFourFaq" class="accordion-collapse collapse show mt-3" aria-labelledby="headingFourFaq" data-bs-parent="#accordionExampleFaq">
                                                <div class="accordion-body">

                                                    @foreach ($languages as $key => $locale)
                                                    {{-- meta_title_ ---------------------------------------------------------------------------------------}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" name="faq_meta_title_{{ $locale }}" value="{{ @$settings['faq_meta_title_' . $locale] }}" id="title{{ $key }}">
                                                        </div>
                                                    </div>

                                                    {{-- meta_description_ ---------------------------------------------------------------------------------------}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="faq_meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['faq_meta_description_' . $locale] }} </textarea>

                                                        </div>
                                                    </div>

                                                    {{-- meta_key_ ---------------------------------------------------------------------------------------}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="faq_meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['faq_meta_key_' . $locale] }} </textarea>

                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--contact us--->
                                    <div class="accordion mt-4 mb-4" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingTree">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTree" aria-expanded="true" aria-controls="collapseTree">
                                                    @lang('settings.contact_us')
                                                </button>
                                            </h2>
                                            <div id="collapseTree" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">

                                                    @foreach ($languages as $key => $locale)
                                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text" name="contact_us_meta_title_{{ $locale }}" value="{{ @$settings['contact_us_meta_title_' . $locale] }}" id="title{{ $key }}">
                                                        </div>
                                                    </div>

                                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="contact_us_meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['contact_us_meta_description_' . $locale] }} </textarea>

                                                        </div>
                                                    </div>

                                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="contact_us_meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['contact_us_meta_key_' . $locale] }} </textarea>

                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <!-- /.card-body -->
                            <div class="card-footer text-end">
                                <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-danger waves-effect waves-light ml-3">@lang('button.cancel')</a>
                                <button type="submit" class="btn btn-success">@lang('button.save')</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>

</div> <!-- container-fluid -->

@endsection




@section('script')
{{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
@endsection
