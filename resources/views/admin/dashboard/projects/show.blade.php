@extends('admin.app')

@section('title', trans('project.show_project'))
@section('title_page', trans('project.edit', ['name' => @$project->trans->where('locale',$current_lang)->first()->title]) )

 
@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.projects.index') }}"
                                class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                    
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne"
                                                        aria-expanded="true"
                                                        aria-controls="collapseOne">
                                                        {{   trans('admin.title')  }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne"
                                                    class="accordion-collapse collapse show mt-3"
                                                    aria-labelledby="headingOne"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">

                                                        @foreach ($languages as $key => $locale)
                                                            {{-- title ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.title_in') .   trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text"
                                                                    name="{{ $locale }}[title]" disabled
                                                                    value="{{ @$project->trans->where('locale', $locale)->first()->title }}"
                                                                    id="title{{ $key }}">
                                                                </div>
                                                          
                                                            </div>
                                                        @endforeach


                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>





                                    <div class="col-md-4">

                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true"
                                                        aria-controls="collapseTwo">
                                                        {{ trans('admin.settings') }}
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse show"
                                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="col-sm-3 col-md-6 mb-3">
                                                            @if ($project->image != null)
                                                                <img src="{{ asset($project->image) }}" alt=""
                                                                    style="width:100%">
                                                            @endif
                                                        </div>

                                                            {{-- portfolio  ------------------------------------------------------------------------------- --}}
                                                            <div class="col-12">
                                                                <div class="row mb-3">
                                                                    <label for="example-number-input"> @lang('project.portfolio'):</label>
                                                                    <div class="col-sm-12">
                                                                        <p class="h2 text-primary ">{{ @$project->portfolio ?@$project->portfolio->trans->where('locale',$current_lang)->first()->title: "__"  }}</p>
                                                                    </div>
                                                                </div>
                                                          
                                                            </div>
                                                     
                                                
                                                        {{-- sort ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('project.sort'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="number" id="example-number-input" disabled  name="sort" value="{{ @$project->sort }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 ">
                                                            <label class="col-md-3 col-form-label" for="available">{{ trans('admin.feature') }}</label>
                                                                @if($project->feature == 1 )
                                                                    <p class="badge  bg-success h3" style="font-size:20px">@lang("admin.yes")</p>   
                                                                @else
                                                                    <p class="badge  bg-danger h3" style="font-size:20px">@lang("admin.no")</p>
                                                                @endif   
                                                        </div>
                                                 
                                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <label class="col-sm-3 col-form-label" for="available">{{ trans('admin.status') }}</label>
                                                                @if($project->status == 1 )
                                                                    <p class="badge  bg-success h3" style="font-size:20px">@lang("admin.active")</p>   
                                                                @else
                                                                    <p class="badge  bg-danger h3" style="font-size:20px">@lang("admin.dis_active")</p>
                                                                @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                        
                                    {{-- Butoooons ------------------------------------------------------------------------- --}}
                                    <div class="row mb-3 text-end">
                                        <div>
                                            <a href="{{ route('admin.projects.index') }}"
                                                class="btn btn-outline-danger waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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



