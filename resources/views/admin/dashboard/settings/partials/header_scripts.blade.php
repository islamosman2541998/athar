@extends('admin.app')

@section('title', trans('settings.settings'))
@section('title_page', trans('settings.edit', ['name' => @$settingMain->key]) )


@section('content')

<div class="container-fluid">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <!-- form start -->
                        <form class="form-horizontal" action="{{route('admin.settings.update-custom', $settingMain->key)}}" method="POST" enctype="multipart/form-data" role="form">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    {{-- Header Script ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-form-label"> Header Script </label>
                                        <textarea name="header_script" class="form-control" rows="15">{{ @$settings['header_script' ] }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    {{-- Body Script ------------------------------------------------------------------------------------- --}}
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-form-label"> Body Script </label>
                                        <textarea name="body_script" class="form-control" rows="15">{{ @$settings['body_script' ] }}</textarea>
                                    </div>
                                </div>

                                {{-- Header Script ------------------------------------------------------------------------------------- --}}
                                <div class="row my-5">
                                    <label for="example-text-input" class="col-form-label"> Footer Script </label>
                                    <textarea name="footer_script" class="form-control" rows="15"> {{ @$settings['footer_script' ] }} </textarea>
                                </div>
                            </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer text-end">
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-danger waves-effect waves-light ml-3">@lang('button.cancel')</a>
                    <button type="submit" class="btn btn-success">@lang('button.save')</button>
                </div>
                <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.card -->
        </div>

    </section>

</div> <!-- container-fluid -->

@endsection
