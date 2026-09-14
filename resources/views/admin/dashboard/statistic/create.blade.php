@extends('admin.app')

@section('title', trans('statistic.create'))
@section('title_page', trans('statistic.create'))

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="row">
            <div class="col-12 m-3">
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.statistic.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('admin.statistic.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    @foreach ($languages as $key => $locale)
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
                                                            <input class="form-control" type="text" name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}">
                                                        </div>
                                                        @if ($errors->has($locale . '.title'))
                                                        <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                        @endif
                                                    </div>

                                                    {{-- description ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3 mt-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('admin.description_in')
                                                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ old($locale . '.description') }} </textarea>
                                                            @if ($errors->has($locale . '.description'))
                                                            <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                            @endif
                                                        </div>


                                                        <script type="text/javascript">
                                                            CKEDITOR.replace('description{{ $key }}', {
                                                                filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}"
                                                                , filebrowserUploadMethod: 'form'
                                                            });

                                                        </script>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    @endforeach


                                </div>


                                <div class="col-md-4">

                                    <div class="accordion mt-4 mb-4" id="accordionExample1">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingtwo">
                                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                    {{ trans('admin.settings') }}
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingtwo" data-bs-parent="#accordionExample1">
                                                <div class="accordion-body">
                                              
                                    
                                                 
                                                    {{-- image ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label for="example-number-input" col-form-label>
                                                                @lang('admin.image'):</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="file" placeholder="@lang('admin.image'):" id="example-number-input" name="image" value="{{ old('image') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- count ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label for="example-number-input" col-form-label>
                                                                @lang('admin.count'):</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="number" id="example-number-input" name="count" value="{{ old('sort') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label for="example-number-input" col-form-label>
                                                                @lang('admin.sort'):</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="number" id="example-number-input" name="sort" value="{{ old('sort') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch" name="feature" type="checkbox" id="switch1" switch="success" checked value="1">
                                                            <label class="form-label" for="switch1" data-on-label=" @lang('admin.yes') " data-off-label=" @lang('admin.no')"></label>
                                                        </div>
                                                    </div>

                                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch" name="status" type="checkbox" id="switch3" switch="success" checked value="1">
                                                            <label class="form-label" for="switch3" data-on-label=" @lang('admin.yes') " data-off-label=" @lang('admin.no')"></label>
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
                                        <a href="{{ route('admin.statistic.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                        <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
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
