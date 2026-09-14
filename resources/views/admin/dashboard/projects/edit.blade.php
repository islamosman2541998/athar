@extends('admin.app')

@section('title', trans('project.edit_project'))
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

                            <form action="{{ route('admin.projects.update',$project->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')

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
                                                        {{   trans('admin.title') }}
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
                                                                    name="{{ $locale }}[title]"
                                                                    value="{{ @$project->trans->where('locale', $locale)->first()->title }}"
                                                                    id="title{{ $key }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.title'))
                                                                <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>
                                                        @endforeach


                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- images Gellary  --}}
                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingImage">
                                                    <button class="accordion-button fw-medium" type="button"data-bs-toggle="collapse"  data-bs-target="#collapseImage" aria-expanded="true"   aria-controls="collapseOne">
                                                        @lang('admin.gallerys')
                                                    </button>
                                                </h2>
                                                <div id="collapseImage"  class="accordion-collapse collapse show mt-3" aria-labelledby="headingImage" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">


                                                        <div class="row mb-3">
                       
                       
                                                            <div id="images_section">
                                                                @forelse($project->images as $key => $img)
                                                                    <div class="ads mt-3">
                                                                        <div class="row">
                                                                            <input type="hidden" name="gallery[image][]" value="{{ $img->url }}" id="">
                                                                            <input type="hidden" name="gallery[id][]" value="{{ $img->id }}" id="">
                                                                            <div class="col-md-6 col-sm-12 mb-3">
                                                                                <label for="example-number-input"  > @lang("admin.sort"):</label>
                                                                                <div class="col-sm-12">
                                                                                    <input type="number" name="gallery[sort][]" value="{{ $img->sort }}" class="form-control" >
                                                                                    <input type="file" name="gallery[image][]" value="{{ $img->sort }}" class="form-control mt-3" >

                                                                                </div>
                                                                            </div>
                                                                      
                                                                            @if( @$img->url!= null)
                                                                            <div class="col-md-6 col-sm-12 mb-3">
                                                                                <a href="{{ asset( @$img->url) }}" target="_blank">
                                                                                        <img src="{{asset(@$img->url)}}" alt="" width="50%">
                                                                                    </a>
                                                                                </div>
                                                                            @endif
                                                                          
                                                                        </div>
                                                                        
                                                                        <div class="col-12 text-center">
                                                                            <button  type="button"  class="btn btn-danger delete_img form-control"><i class="fa fa-trash"></i></button>
                                                                        </div>
                                                                    </div>
                                                                    <hr>

                                                                @empty
                                                                @endforelse
                                                            </div>
                            
                            
                                                            <a  type="button" class="btn btn-success form-control" id="add_images_section">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                            
                                                        </div>
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
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true"
                                                        aria-controls="collapseTwo">
                                                        {{ trans('admin.settings') }}
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse show"
                                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExampleTwo">
                                                    <div class="accordion-body">
                                                        <div class="col-sm-3 col-md-6 mb-3">
                                                            @if ($project->image != null)
                                                                <img src="{{ asset($project->image) }}" alt=""
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
                                                                        placeholder="@lang('admin.image'):" id="example-number-input"
                                                                        name="image" value="{{ old('image') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                           {{-- portfolios  ------------------------------------------------------------------------------- --}}
                                                           <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input"> @lang('project.portfolio'):</label>
                                                                <div class="col-sm-12">
                                                                    <select class="form-select form-select-sm " name="portfolio_id" >
                                                                        <option value="" disabled selected> {{ trans('admin.select') }}</option>
                                                                        @foreach ($portfolios as $portfolio)
                                                                            <option value="{{ $portfolio->id }}" {{ $project->portfolio_id == $portfolio->id ? 'selected' : '' }}>  {{ @$portfolio->trans->where('locale', $current_lang)->first()->title }} </option>
                                                                        @endforeach
                                                                    </select>      
                                                                </div>
                                                            </div>
                                                            @error('category_id')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- sort ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('project.sort'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="number" id="example-number-input"  name="sort" value="{{ @$project->sort }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                      
                                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <label class="col-sm-12 col-form-label"
                                                                for="available">{{ trans('admin.status') }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-check form-switch" name="status" type="checkbox"
                                                                    id="switch3" switch="success"
                                                                    {{ @$project->status == 1 ? 'checked' : '' }} value="1">
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
                                            <a href="{{ route('admin.projects.index') }}"
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
    <script>
        $( document ).ready(function() {
            $('#add_images_section').on('click',function (){
                $('#images_section').append(
                    `
                    <div class="images ">
                        <div class="row">
                            <div class="col-6">
                                <label for="example-number-input"  > @lang("admin.image"):</label>
                                <input type="file" name="newgallery[][image]"   class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label for="example-number-input"  > @lang("admin.sort"):</label>
                                <input type="number" name="newgallery[][sort]"  class="form-control"  >
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

        
            $('#images_section').on('click','.delete_img',function (e){
                $(this).parent().parent().remove();
            })
        });
    </script>
@endsection
