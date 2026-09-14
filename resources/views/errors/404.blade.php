@extends('site.layouts.app')


@section('content')

    <main id="main">
        <div class=" main-content ">
            <div class="page-content mt-3">
                <div class="container-fluid">

                    <div class="row m-4">
                        <div class="col-md-6 offset-md-3 mx-auto">
                            <div class="">
                                <div class="card-body mt-5">
                                    <div class="ex-page-content text-center">
                                        <h1 class="">404!</h1>
                                        <h3 class="">@lang('site.notFound')</h3><br>
                                        <a class="btn btn-primary mb-5 waves-effect waves-light" href="{{ route('site.home') }}">@lang('site.back')</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    

                </div> <!-- container-fluid -->
            </div>
      </div>
    </main>
@endsection
