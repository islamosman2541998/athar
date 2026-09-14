@extends('admin.app')

@section('title', trans('admin.ads'))
@section('title_page', trans('admin.ads'))

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.ads.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="id" value="{{ $data['id'] }}">
                            <input type="hidden" name="model" value="{{ $data['model'] }}">

                            <div class="row mb-3">
                       
                       
                                <div id="ads_section">
                                    @foreach($items as $key => $ad)
                                        <div class="ads mt-3">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12 mb-3">
                                                    <label for="example-number-input"  > @lang("categories.link"):</label>
                                                    <div class="col-sm-12">
                                                        <input type="text"  name="ads[link][]" value="{{ $ad->link }}" class="form-control" >
                                                    </div>
                                                </div>
                                          
                                                @if( @$ad->image!= null)
                                                <div class="col-md-2 col-sm-12 mb-3">
                                                    <a href="{{ asset( @$ad->image) }}" target="_blank">
                                                            <img src="{{asset(@$ad->image)}}" alt="" width="50%">
                                                        </a>
                                                    </div>
                                                @endif
                                                <div class="col-md-3 col-sm-12 mb-3">
                                                    <label for="example-number-input"  > @lang("categories.background_image"):</label>
                                                    <div class="col-sm-12">
                                                        <input type="hidden" name="ads[image][]" value="{{ @$ad->image }}">
                                                        <input type="file" name="ads[image][]"   class="form-control" value="{{ @$ad->image }}">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        
                                            <div class="col-12 text-center">
                                                <button  type="button"  class="btn btn-danger delete_ads form-control"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                </div>


                                <a  type="button" class="btn btn-success form-control" id="add_ads_section">
                                    <i class="fa fa-plus"></i>
                                </a>

                            </div>
                                
            


                        <div class="row mb-3 text-end">                                
                            <div>
                                <a href="{{ route('admin.ads.index') }}" class="btn btn-outline-danger waves-effect waves-light ml-3">@lang('button.cancel')</a>
                                <button type="reset" class="btn btn-outline-warning waves-effect waves-light ml-3">@lang('button.reset')</button>
                                <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3">@lang('button.save')</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>

</div> <!-- container-fluid -->

@endsection



@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $( document ).ready(function() {
            $('#add_ads_section').on('click',function (){
                $('#ads_section').append(
                    `
                    <div>
                        <div class="ads">
                            <div class="col-12">
                                <div class="row mb-3">
                                    <label for="example-number-input"  > @lang("categories.link"):</label>
                                    <div class="col-sm-12">
                                        <input type="url" name="ads[link][]"  class="form-control"  required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row mb-3">
                                    <label for="example-number-input"  > @lang("categories.background_image"):</label>
                                    <div class="col-sm-12">
                                        <input type="file" name="ads[image][]"   class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-danger delete_ads form-control"><i class="fa fa-trash"></i></button>
                            </div>
                        <hr>

                        </div>
                    
                    `
                )

            });

        
            $('#ads_section').on('click','.delete_ads',function (e){
                console.log("ddddd");
                console.log($(this).parent());
                $(this).parent().parent().remove();
            })
        });
    </script>
@endsection