@extends('admin.app')

@section('title', trans('tags.edit'))
@section('title_page', trans('tags.edit_tags', ['name' => @$portfolioTag->trans->where('locale',$current_lang)->first()->title]) )

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.portfolio-tags.index') }}"
                                class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('admin.portfolio-tags.update', $portfolioTag->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-8">
                                            <div class="accordion mt-4 mb-4" id="accordionExample">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOneTitle">
                                                        <button class="accordion-button fw-medium" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOnetitle"
                                                            aria-expanded="true"
                                                            aria-controls="collapseOnetitle">
                                                            {{  trans('admin.title')}}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOnetitle"
                                                        class="accordion-collapse collapse show mt-3"
                                                        aria-labelledby="headingOneTitle"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">


                                                            @foreach ($languages as $key => $locale)

                                                            {{-- title ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.title_in') .  trans('lang.' .Locale::getDisplayName($locale))}}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text"
                                                                        name="{{ $locale }}[title]"
                                                                        value="{{ $portfolioTag->trans->where('locale',$locale)->first()->title }}"
                                                                        id="title{{ $key }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>
                                                            @endforeach

                                                
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                
                                    </div>


                                    <div class="col-md-4">

                                        {{-- ------ Start Post Settings------ --}}
                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                        {{ trans('tags.Post_settings') }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse show"
                                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                               
                                                  
                                                        {{-- sort ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('articles.sort'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="number"
                                                                        id="example-number-input" name="sort"
                                                                        value="{{ $portfolioTag->sort }}">
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
                                                                    value="1"
                                                                    {{ @$portfolioTag->feature == 1 ? 'checked' : '' }}>
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
                                                                    value="1" {{ @$portfolioTag->status == 1 ? 'checked' : '' }}>
                                                                <label class="form-label" for="switch3"
                                                                    data-on-label=" @lang('admin.yes') "
                                                                    data-off-label=" @lang('admin.no')"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- ------ End Post Settings------ --}}
                                    </div>
                                                     {{-- Butoooons ------------------------------------------------------------------------- --}}
                                <div class="row mb-3 text-end">
                                    <div>
                                        <a href="{{ route('admin.portfolio-tags.index') }}"
                                            class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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
    <<script src="https://cdn.ckeditor.com/4.5.6/full/ckeditor.js"></script>
@endsection
