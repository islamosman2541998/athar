@extends('admin.app')

@section('title', __('job.create'))
@section('title_page', __('job.create'))

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 m-3">
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.jobs.index') }}"
                            class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.jobs.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-md-8">

                                    @foreach ($languages as $key => $locale)
                                        <div class="accordion mt-4 mb-4 bg-primary"
                                            id="accordionExample{{ $locale }}">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOne{{ $locale }}">
                                                    <button class="accordion-button fw-medium " type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne{{ $locale }}"
                                                        aria-expanded="true" aria-controls="collapseOne{{ $locale }}">
                                                        {{ __('products.' . $locale) }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne{{ $locale }}"
                                                    class="accordion-collapse collapse show mt-3"
                                                    aria-labelledby="headingOne{{ $locale }}"
                                                    data-bs-parent="#accordionExample{{ $locale }}">
                                                    <div class="accordion-body">


                                                        {{-- title ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text" required
                                                                    name="{{ $locale }}[title]"
                                                                    value="{{ old($locale . '.title') }}"
                                                                    id="title{{ $key }}">
                                                                @if ($errors->has($locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        {{-- slug ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3 slug-section">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-10">
                                                                <input type="text" id="slug{{ $key }}"
                                                                    name="{{ $locale }}[slug]"
                                                                    value="{{ old($locale . '.slug') }}"
                                                                    class="form-control slug">
                                                                @if ($errors->has($locale . '.slug'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                                @endif
                                                            </div>
                                                            @include('admin.layouts.scriptSlug')
                                                        </div>

                                                        {{-- description ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('products.description') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <textarea class="form-control" id="description{{ $key }}" name="{{ $locale }}[description]">
                                                        {{ old($locale . '.description') }}
                                                        </textarea>


                                                                <script type="text/javascript">
                                                                    CKEDITOR.replace('description{{ $key }}', {
                                                                        filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                        filebrowserUploadMethod: 'form'
                                                                    });
                                                                </script>


                                                            </div>
                                                            @if ($errors->has($locale . '.description'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                            @endif
                                                        </div>
                                                           {{-- job_desc ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('products.job_desc') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <textarea class="form-control" id="job_desc{{ $key }}" name="{{ $locale }}[job_desc]">
                                                        {{ old($locale . '.job_desc') }}
                                                        </textarea>


                                                                <script type="text/javascript">
                                                                    CKEDITOR.replace('job_desc{{ $key }}', {
                                                                        filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                        filebrowserUploadMethod: 'form'
                                                                    });
                                                                </script>


                                                            </div>
                                                            @if ($errors->has($locale . '.job_desc'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.job_desc') }}</span>
                                                            @endif
                                                        </div>
                                                        {{-- short_description ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('products.short_description') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <textarea class="form-control" id="short_description{{ $key }}"
                                                                    name="{{ $locale }}[short_description]">
                                                        {{ old($locale . '.short_description') }}
                                                        </textarea>


                                                                <script type="text/javascript">
                                                                    CKEDITOR.replace('short_description{{ $key }}', {
                                                                        filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                        filebrowserUploadMethod: 'form'
                                                                    });
                                                                </script>


                                                            </div>
                                                            @if ($errors->has($locale . '.short_description'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.short_description') }}</span>
                                                            @endif
                                                        </div>
                                                        {{-- requirements ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('products.requirements') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <textarea class="form-control" id="requirements{{ $key }}" name="{{ $locale }}[requirements]">
                                                        {{ old($locale . '.requirements') }}
                                                        </textarea>


                                                                <script type="text/javascript">
                                                                    CKEDITOR.replace('requirements{{ $key }}', {
                                                                        filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                        filebrowserUploadMethod: 'form'
                                                                    });
                                                                </script>


                                                            </div>
                                                            @if ($errors->has($locale . '.requirements'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.requirements') }}</span>
                                                            @endif
                                                        </div>




                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach

                                    <!-----start meta ------>
                                    <div class="accordion mt-4 mb-4 bg-primary" id="accordionExampleSlugs">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingOneSlugs">
                                                <button class="accordion-button fw-medium collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOneSlugs"
                                                    aria-expanded="false" aria-controls="collapseOneSlugs">
                                                    {{ __('products.meta_info') }}
                                                </button>
                                            </h2>
                                            <div id="collapseOneSlugs" class="accordion-collapse collapse  mt-3"
                                                aria-labelledby="headingOneSlugs" data-bs-parent="#accordionExampleSlugs">
                                                <div class="accordion-body">

                                                    @foreach ($languages as $key => $locale)
                                                        {{-- meta_title ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('products.meta_title') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <input class="form-control"
                                                                    name="{{ $locale }}[meta_title]"
                                                                    value="{{ old($locale . '.meta_title') }} ">


                                                            </div>
                                                            @if ($errors->has($locale . '.meta_title'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                            @endif
                                                        </div>


                                                        {{-- meta_desc ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('products.meta_desc') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <textarea class="form-control" id="meta_description{{ $key }}" name="{{ $locale }}[meta_desc]">
                                                        {{ old($locale . '.meta_desc') }}
                                                        </textarea>


                                                            </div>
                                                            @if ($errors->has($locale . '.meta_desc'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_desc') }}</span>
                                                            @endif
                                                        </div>


                                                        {{-- meta_key ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-2 col-form-label">{{ trans('products.meta_key') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                            <div class="col-sm-10">

                                                                <textarea class="form-control" name="{{ $locale }}[meta_key]">
                                                        {{ old($locale . '.meta_key') }}
                                                        </textarea>

                                                            </div>
                                                            @if ($errors->has($locale . '.meta_key'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
                                                            @endif
                                                        </div>

                                                        <br>
                                                        <hr>
                                                        <br>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!----------end meta ---------->




                                </div>


                                <div class="col-md-4">

                                    {{-- Main Settings --}}
                                    <div class="accordion mt-4 mb-4" id="accordionExample1">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingtwo">
                                                <button class="accordion-button fw-medium" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                    aria-expanded="true" aria-controls="collapseTwo">
                                                    {{ trans('admin.settings') }}
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse show"
                                                aria-labelledby="headingtwo" data-bs-parent="#accordionExample1">
                                                <div class="accordion-body">
                                                    {{-- type category ------------------------------------------------------------------------------- --}}
                                                 <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input">
                                                                    @lang('admin.career_category'):</label>
                                                                <div class="col-sm-12">
                                                                    <select class="form-select form-select-sm select2"
                                                                        name="career_category_id">
                                                                        <option value="" selected disabled>
                                                                            {{ trans('admin.career_category') }}</option>
                                                                        @foreach ($careerCategories as $careerCategory)
                                                                            <option value="{{ $careerCategory->id }}"
                                                                                {{ old('career_category_id') == $careerCategory->id ? 'selected' : '' }}>
                                                                                {{ @$careerCategory->trans->where('locale', $current_lang)->first()->title }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            @error('career_category_id')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>


                                                    {{-- employment_type ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">{{ trans('products.employment_type') }}</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="text"
                                                                name="employment_type"
                                                                value="{{ old('employment_type') }}">
                                                        </div>
                                                        @if ($errors->has('employment_type'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first('employment_type') }}</span>
                                                        @endif
                                                    </div>
                                                    {{-- location ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">{{ trans('products.location') }}</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="text" name="location"
                                                                value="{{ old('location') }}">
                                                        </div>
                                                        @if ($errors->has('location'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first('location') }}</span>
                                                        @endif
                                                    </div>





                                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-4 col-form-label">{{ trans('products.sort') }}</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="number" name="sort"
                                                                value="{{ old('sort') }}">
                                                        </div>
                                                        @if ($errors->has('sort'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first('sort') }}</span>
                                                        @endif
                                                    </div>





                                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12 col-sm-12">
                                                        <label class="col-sm-12 col-form-label"
                                                            for="available">{{ trans('admin.feature') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch" name="feature"
                                                                type="checkbox" id="switch1" switch="success"
                                                                {{ old('feature') == 'on' ? 'checked' : '' }}>
                                                            <label class="form-label" for="switch1"
                                                                data-on-label=" @lang('admin.yes') "
                                                                data-off-label=" @lang('admin.no')"></label>
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('feature'))
                                                        <span class="missiong-spam">{{ $errors->first('feature') }}</span>
                                                    @endif
                                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label"
                                                            for="available">{{ trans('admin.status') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch" name="status"
                                                                type="checkbox" id="switch3" switch="success"
                                                                {{ old('status') == 'on' ? 'checked' : '' }}>
                                                            <label class="form-label" for="switch3"
                                                                data-on-label=" @lang('admin.yes') "
                                                                data-off-label=" @lang('admin.no')"></label>
                                                        </div>
                                                        @if ($errors->has('status'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first('status') }}</span>
                                                        @endif
                                                    </div>

                                                    <hr>



                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>




                                {{-- Butoooons ------------------------------------------------------------------------- --}}
                                <div class="row mb-3 text-end">
                                    <div>
                                        <a href="{{ route('admin.products.index') }}"
                                            class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                        <button type="submit"
                                            class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                                    </div>
                                </div>
                            </div>
                    </div>

                    </form>

                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection

@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(function() {
            @foreach ($languages as $key => $locale)
                CKEDITOR.replace('description{{ $key }}', {
                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) ?? '#' }}",
                    filebrowserUploadMethod: 'form'
                });
            @endforeach
        });
    </script>
@endsection
