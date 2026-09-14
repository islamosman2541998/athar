@extends('admin.app')

@section('title', trans('statistic.edit_statistic'))
@section('title_page', trans('statistic.edit', ['name' => @$statistic->trans->where('locale',
    $current_lang)->first()->title]))


@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.statistic.index') }}"
                                class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('admin.statistic.update', $statistic->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                        {{ trans('admin.title') }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse show mt-3"
                                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">

                                                        @foreach ($languages as $key => $locale)
                                                            {{-- title ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text"
                                                                        name="{{ $locale }}[title]"
                                                                        value="{{ @$statistic->trans->where('locale', $locale)->first()->title }}"
                                                                        id="title{{ $key }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- description ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ @$statistic->trans->where('locale', $locale)->first()->description }} </textarea>
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
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>





                                    <div class="col-md-4">

                                        <div class="accordion mt-4 mb-4" id="accordionExampleTwo">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingtwo">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                        aria-expanded="true" aria-controls="collapseTwo">
                                                        {{ trans('admin.settings') }}
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse show"
                                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExampleTwo">
                                                    <div class="accordion-body">
                                                        <div class="col-sm-3 col-md-6 mb-3">
                                                            @if ($statistic->image != null)
                                                                <img src="{{ asset($statistic->image) }}" alt=""
                                                                    style="width:100%">
                                                            @endif
                                                        </div>
                                                        {{-- image ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('admin.image'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="file"
                                                                        placeholder="@lang('admin.image'):"
                                                                        id="example-number-input" name="image"
                                                                        value="{{ old('image') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                 

                                                        {{-- count ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('portfolio.count'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="number"
                                                                        id="example-number-input" name="count"
                                                                        value="{{ @$statistic->count }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- sort ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('portfolio.sort'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="number"
                                                                        id="example-number-input" name="sort"
                                                                        value="{{ @$statistic->sort }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- feature ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <label class="col-sm-12 col-form-label"
                                                                for="available">{{ trans('admin.feature') }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-check form-switch" name="feature"
                                                                    type="checkbox" id="switch1" switch="success"
                                                                    {{ @$statistic->feature == 1 ? 'checked' : '' }}
                                                                    value="1">
                                                                <label class="form-label" for="switch1"
                                                                    data-on-label=" @lang('admin.yes') "
                                                                    data-off-label=" @lang('admin.no')"></label>
                                                            </div>
                                                        </div>
                                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <label class="col-sm-12 col-form-label"
                                                                for="available">{{ trans('admin.status') }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-check form-switch" name="status"
                                                                    type="checkbox" id="switch3" switch="success"
                                                                    {{ @$statistic->status == 1 ? 'checked' : '' }}
                                                                    value="1">
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
                                            <a href="{{ route('admin.statistic.index') }}"
                                                class="btn btn-outline-danger waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                            <button type="submit"
                                                class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
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
     <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
@endsection
