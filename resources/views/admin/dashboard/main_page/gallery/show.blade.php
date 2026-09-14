@extends('admin.app')

@section('title', trans('main_page_gallery.show_product_category'))
@section('title_page', trans('main_page_gallery.show', ['name' => $product->trans ?  @$product->trans->where('locale', $current_lang)->first()->title : '']) )

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.main_page_gallery.index') }}"
                               class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">


                                    {{-- images Gellary  --}}
                                    <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingImage">
                                                <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseImage"
                                                        aria-expanded="true"
                                                        aria-controls="collapseOne">
                                                    @lang('admin.gallerys')
                                                </button>
                                            </h2>
                                            <div id="collapseImage"
                                                 class="accordion-collapse collapse show mt-3"
                                                 aria-labelledby="headingImage"
                                                 data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row mb-3">
                                                        <div id="images_section"></div>

                                                        <div class="d-flex">
                                                            @if($product->galleryGroup && $product->galleryGroup->images && $product->galleryGroup->images->count())
                                                                @forelse($product->galleryGroup->images as $image)
                                                                    <div class="col">
                                                                        <img style="width: 100px; height:100px"
                                                                             src="{{$image->pathInView('main_page_gallery') }}">
                                                                        <h4>{{$image->title}} </h4>


                                                                        <h6>  @lang('main_page_gallery.sort')  : {{$image->sort}} </h6>
                                                                        <h6> @lang('main_page_gallery.feature')  : <span class="badge bg-warning">{{$image->feature == 1 ? __('admin.yes') : __('admin.no')}}</span>  </h6>
                                                                        <h6> @lang('main_page_gallery.status')  : <span class="badge bg-primary"> {{$image->status == 1 ? __('admin.yes') : __('admin.no')}}  </span> </h6>

                                                                        <br>
                                                                    </div>
                                                                @empty
                                                                @endforelse
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>  <!---end -->



                                <div class="row mb-3 text-end">
                                    <div>
                                        <a href="{{ route('admin.main_page_gallery.index') }}"
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
