@extends('admin.app')

@section('title', trans('admin.pages'))
@section('title_page', trans('pages.show', ['name' => @$page->translate($locale)->title]) )

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a
                                @if(request()->service === "123")
                                href="{{ route('admin.service.index') }}"
                                @else
                                href="{{ route('admin.pages.index') }}"
                                @endif
                                class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('admin.pages.update', $page->id)  }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-8">
                                        @foreach ($languages as $key => $locale)
                                            <div class="accordion mt-4 mb-4" id="accordionExample">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                        <button class="accordion-button fw-medium" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne{{ $key }}"
                                                            aria-expanded="true"
                                                            aria-controls="collapseOne{{ $key }}">
                                                            {{ trans('lang.' .Locale::getDisplayName($locale))   }}
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
                                                                class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text"
                                                                        name="{{ $locale }}[title]"
                                                                        value="{{ @$page->trans->where('locale', $locale)->first()->title }}"
                                                                        id="title{{ $key }}" disabled>
                                                                </div>
                                                                @if ($errors->has($locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- slug ------------------------------------------------------------------------------------- --}}
                                                            {{-- Start Slug --}}
                                                            <div class="row mb-3 slug-section">
                                                                <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>

                                                                <div class="col-sm-10">
                                                                    <input type="text" id="slug{{ $key }}"
                                                                        name="{{ $locale }}[slug]"
                                                                        value="{{ @$page->trans->where('locale', $locale)->first()->slug }}"
                                                                        class="form-control slug mb-3" required disabled>
                                                                    @if ($errors->has($locale . '.slug'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                                    @endif
                                                                </div>
                                                                @include('admin.layouts.scriptSlug')
                                                                {{-- End Slug --}}




                                                                {{-- content ------------------------------------------------------------------------------------- --}}
                                                                <div class="row mb-3">
                                                                    <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">
                                                                    {{ trans('admin.content_in') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                                                    <div class="col-sm-10 mb-2">
                                                                        <textarea id="content{{ $key }}" name="{{ $locale }}[content]" disabled> {{ @$page->trans->where('locale', $locale)->first()->content }} </textarea>
                                                                        @if ($errors->has($locale . '.content'))
                                                                            <span
                                                                                class="missiong-spam">{{ $errors->first($locale . '.content') }}</span>
                                                                        @endif
                                                                    </div>

                                                                    <script type="text/javascript">
                                                                        $(function() {
                                                                            CKEDITOR.replace('content{{ $key }}');
                                                                            $('.textarea').wysihtml5()
                                                                        })
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
                                                                class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text"
                                                                        name="{{ $locale }}[meta_title]"
                                                                        value="{{ @$page->trans->where('locale', $locale)->first()->meta_title }}"
                                                                        id="title{{ $key }}" disabled>
                                                                </div>
                                                                @if ($errors->has($locale . '.meta_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea name="{{ $locale }}[meta_description]" class="form-control description" disabled> {{ @$page->trans->where('locale', $locale)->first()->meta_description }} </textarea>
                                                                    @if ($errors->has($locale . '.meta_description'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea name="{{ $locale }}[meta_key]" class="form-control description" disabled> {{ @$page->trans->where('locale', $locale)->first()->meta_key }} </textarea>
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


                        <div class="col-md-4">

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
                                            <div class="col-sm-3 mb-3">
                                                @if ($page->image != null)
                                                    <img src="{{ asset($page->image) }}" alt=""
                                                        style="width:100%">
                                                @endif
                                            </div>



                                            {{-- Status ------------------------------------------------------------------------------------- --}}
                                            <div class="col-12">
                                                <label class="col-sm-12 col-form-label"
                                                    for="available">{{ trans('admin.status') }}</label>
                                                <div class="col-sm-10">
                                                    <input class="form-check form-switch" name="status" type="checkbox"
                                                        id="switch3" switch="success"
                                                        {{ @$page->status == 1 ? 'checked' : '' }} value="1" disabled>
                                                    <label class="form-label" for="switch3"
                                                        data-on-label=" @lang('admin.yes') "
                                                        data-off-label=" @lang('admin.no')"></label>
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
                            <a
                                @if(request()->service === "123")
                                href="{{ route('admin.service.index') }}"
                                @else
                                href="{{ route('admin.pages.index') }}"
                                @endif
{{--                                href="{{ route('admin.pages.index') }}"--}}
                            class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>

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

{{--    <script>--}}
{{--        function goBackAndRefresh() {--}}
{{--            // Replace current state to avoid creating an extra history entry--}}
{{--            // window.history.replaceState(null, '', window.location.href);--}}

{{--            // Navigate back--}}
{{--        return     window.history.back();--}}

{{--            // Set a timeout to refresh the page after a short delay--}}
{{--            // setTimeout(function() {--}}
{{--            //     // Refresh the page--}}
{{--            //     window.location.reload();--}}
{{--            // }, 100); // Adjust the delay as needed (100ms is usually sufficient)--}}
{{--        }--}}
{{--    </script>--}}
@endsection


@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
@endsection
