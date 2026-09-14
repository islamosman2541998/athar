@extends('admin.app')

@section('title', trans('admin.ads'))
@section('title_page', trans('admin.ads'))

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row mb-3">
                        <div id="ads_section">
                            @foreach($items as $key => $ad)
                                <div class="ads mt-3">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 mb-3">
                                            <label for="example-number-input"  > @lang("categories.link"):</label>
                                                <a href="{{ $ad->link }}" target="_blank">{{ $ad->link }}</a>
                                        </div>
                                
                                        @if( @$ad->image!= null)
                                        <div class="col-md-2 col-sm-12 mb-3">
                                            <a href="{{ asset( @$ad->image) }}" target="_blank">
                                                    <img src="{{asset(@$ad->image)}}" alt="" width="50%">
                                                </a>
                                            </div>
                                        @endif
                                
                                    </div>
                                    
                                
                                
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div>

</div> 

@endsection
