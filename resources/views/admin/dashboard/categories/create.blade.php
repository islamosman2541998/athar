@extends('admin.app')

@section('title', trans('categories.create'))
@section('title_page', trans('categories.create'))

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.categories.index') }}"
                                class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('admin.categories.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-9">
                                        @foreach ($languages as $key => $locale)
                                            <div class="accordion mt-4 mb-4" id="accordionExample">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                        <button class="accordion-button fw-medium" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne{{ $key }}"
                                                            aria-expanded="true"
                                                            aria-controls="collapseOne{{ $key }}">
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
                                                                    <input class="form-control" type="text"
                                                                        name="{{ $locale }}[title]"
                                                                        value="{{ old($locale . '.title') }}"
                                                                        id="title{{ $key }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- slug ------------------------------------------------------------------------------------- --}}
                                                            {{-- Start Slug --}}
                                                            <div class="row mb-3 slug-section">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>

                                                                <div class="col-sm-10">
                                                                    <input type="text" id="slug{{ $key }}"
                                                                        name="{{ $locale }}[slug]"
                                                                        value="{{ old($locale . '.slug') }}"class="form-control slug"
                                                                        required>
                                                                    @if ($errors->has($locale . '.slug'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                                    @endif
                                                                </div>
                                                                @include('admin.layouts.scriptSlug')
                                                                {{-- End Slug --}}


                                                                {{-- description ------------------------------------------------------------------------------------- --}}
                                                                <div class="row mb-3">
                                                                    <label for="example-text-input"
                                                                        class="col-sm-2 col-form-label">
                                                                        {{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                    </label>
                                                                    <div class="col-sm-10 mt-2">
                                                                        <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ old($locale . '.description') }} </textarea>
                                                                        @if ($errors->has($locale . '.description'))
                                                                            <span
                                                                                class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                                        @endif
                                                                    </div>


                                                                    <script type="text/javascript">
                                                                        CKEDITOR.replace('description{{ $key }}', {
                                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                            filebrowserUploadMethod: 'form'
                                                                        });
                                                                    </script>
                                                                </div>



                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach


                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingTwo{{ $key }}">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseTwo{{ $key }}"
                                                        aria-expanded="true"
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
                                                            {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text"
                                                                        name="{{ $locale }}[meta_title]"
                                                                        value="{{ old($locale . '.meta_title') }}"
                                                                        id="title{{ $key }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.meta_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">
                                                                    {{ trans('admin.meta_description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea name="{{ $locale }}[meta_description]" class="form-control description"> {{ old($locale . '.meta_description') }} </textarea>
                                                                    @if ($errors->has($locale . '.meta_description'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">
                                                                    {{ trans('admin.meta_key_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{ old($locale . '.meta_key') }} </textarea>
                                                                    @if ($errors->has($locale . '.meta_key'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
                                                                    @endif
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
                        </div>


                        <div class="col-md-3">

                            <div class="accordion mt-4 mb-4" id="accordionExample">
                                <div class="accordion-item border rounded">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button fw-medium" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            {{ trans('admin.settings') }}
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            {{-- image ------------------------------------------------------------------------------------- --}}

                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label for="example-number-input"> @lang('admin.image'):</label>
                                                    <div class="col-sm-12">
                                                        <input class="form-control" type="file" name="image">
                                                    </div>
                                                </div>
                                                @if ($errors->has('image'))
                                                    <span class="missiong-spam">{{ $errors->first('image') }}</span>
                                                @endif
                                            </div>


                                            {{-- parent Category ------------------------------------------------------------------------------------- --}}
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label for="example-number-input"> @lang('categories.parent'):</label>
                                                    <div class="col-sm-12">
                                                        <select class="form-select form-select-sm select2"
                                                            name="parent_id">
                                                            <option value="" selected>
                                                                {{ trans('categories.select_parent') }}</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}"
                                                                    {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                                                    {{ str_repeat('ـــ ', $category->level - 1) }}
                                                                    {{ @$category->trans->where('locale', $current_lang)->first()->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @error('parent_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- sort ------------------------------------------------------------------------------------- --}}
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label for="example-number-input"> @lang('categories.sort'):</label>
                                                    <div class="col-12">
                                                        <input class="form-control" type="number" name="sort">
                                                    </div>
                                                    @error('sort')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>


                                            {{-- Status ------------------------------------------------------------------------------------- --}}
                                            <div class="row col-12">
                                                <label class="col-md-6"
                                                    for="example-number-input">{{ trans('admin.status') }}</label>
                                                <div class="col-sm-6">
                                                    <input class="form-check form-switch" name="status" type="checkbox"
                                                        id="switch3" switch="success"
                                                        {{ @old('status') == 1 ? 'checked' : '' }} value="1">
                                                    <label class="form-label" for="switch3"
                                                        data-on-label=" @lang('admin.yes') "
                                                        data-off-label=" @lang('admin.no')"></label>
                                                </div>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            {{-- feature ------------------------------------------------------------------------------------- --}}
                                            <div class="row col-12">
                                                <label class="col-md-6" for="example-number-input"
                                                    for="available">{{ trans('categories.feature') }}</label>
                                                <div class="col-sm-6">
                                                    <input class="form-check form-switch" name="feature" type="checkbox"
                                                        id="switch1" switch="success"
                                                        {{ old('feature') == 1 ? 'checked' : '' }} value="1">
                                                    <label class="form-label" for="switch1"
                                                        data-on-label=" @lang('admin.yes') "
                                                        data-off-label=" @lang('admin.no')"></label>
                                                    @error('feature')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Butoooons ------------------------------------------------------------------------- --}}
                        <div class="row mb-3 text-end">
                            <div>
                                <a href="{{ route('admin.categories.index') }}"
                                    class="btn btn-outline-primary waves-effect waves-light ml-3">@lang('button.cancel')</a>
                                <button type="submit"
                                    class="btn btn-outline-success waves-effect waves-light ml-3">@lang('button.save')</button>
                            </div>
                        </div>

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
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
@endsection
