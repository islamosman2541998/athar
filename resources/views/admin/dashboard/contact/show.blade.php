@extends('admin.app')

@section('title', trans('contact_us.show'))
@section('title_page', trans('contact_us.show', ['name' => @$item->name]))

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.contact-us.index') }}"
                                class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">

                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6">

                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button fw-medium" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseOne1"
                                                aria-expanded="true" aria-controls="collapseOne1">
                                                <span class=" text-success "> {{ $item->name }}</span>
                                            </button>
                                        </h2>
                                        <div id="collapseOne1" class="accordion-collapse collapse show mt-3"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">

                                                <div class="row mb-3">
                                                    <label for="example-text-input"
                                                        class="col-sm-2 col-form-label">{{ trans('contact_us.name') }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" disabled type="text"
                                                            value="{{ $item->name }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="example-email-input"
                                                        class="col-sm-2 col-form-label">{{ trans('contact_us.email') }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" disabled value="{{ $item->email }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="example-email-input"
                                                        class="col-sm-2 col-form-label">{{ trans('contact_us.phone') }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" disabled value="{{ $item->phone }}">
                                                    </div>
                                                </div>



                                                <div class="row mb-3">
                                                    <label for="example-tel-input"
                                                        class="col-sm-2 col-form-label">{{ trans('contact_us.message') }}</label>
                                                    <div class="col-sm-10">
                                                        <input class="form-control" readonly disabled type="text"
                                                            value="{{ $item->message }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3 text-end">
                                <div>
                                    <a href="{{ route('admin.contact-us.index') }}"
                                        class="btn btn-outline-primary waves-effect waves-light  btn-sm">@lang('button.cancel')</a>
                                </div>
                            </div>
                        </div>




                        </form>
                    </div>
                </div> <!-- end col -->
            </div>
        </div> <!-- end row-->




    </div> <!-- container-fluid -->

@endsection
