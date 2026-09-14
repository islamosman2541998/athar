@extends('admin.app')

@section('title', trans('settings.settings'))
@section('title_page', trans('settings.edit', ['name' => @$settingMain->key]))


@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <<script src="https://cdn.ckeditor.com/4.5.6/full/ckeditor.js"></script>
@endsection

@section('content')

    <div class="container-fluid">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-gray-dark">

                            <!-- form start -->
                            <form class="form-horizontal" action="{{ route('admin.settings.update', $settingMain->id) }}"
                                method="POST" enctype="multipart/form-data" role="form">
                                @csrf
                                <div class="card-body">
                                    @foreach ($settings as $setting)
                                        @if ($setting->type == 0)
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">
                                                    {{ trans('admin.' . $setting->key) }} </label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="{{ $setting->key }}"
                                                        value="{{ $setting->value }}">
                                                </div>
                                            </div>
                                        @elseif($setting->type == 1)
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label for="example-number-input" col-form-label>
                                                        {{ trans('admin.' . $setting->key) }} :</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input class="form-control" type="file"
                                                        placeholder="@lang('admin.image'):" id="example-number-input"
                                                        name="{{ $setting->key }}">
                                                </div>
                                                @if ($setting->value)
                                                    @if(substr($setting->value, -3) == "mp4")
                                                        <div class="col-sm-4" >
                                                            <video width="200" height="150" controls muted>
                                                                <source src="{{ asset($setting->value) }}" type="video/mp4">
                                                            </video>
                                                        </div>
                                                    @else
                                                        <div class="col-sm-4 " background-color: #e7e7e7;">
                                                            <img src="{{asset($setting->value)}}" alt="" style="width: 50px">
                                                        </div>
                                                    @endif 
                                                @else
                                                    <div class="col-sm-4" style="width: 200px; height: 150px;">
                                                        <img src="{{ admin_path('images/not_found.PNG') }}" width="150"
                                                            height="150" alt="" />
                                                    </div>
                                                @endif


                                            </div>
                                        @elseif($setting->type == 6)
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label for="example-number-input" col-form-label>
                                                        {{ trans('admin.' . $setting->key) }} :</label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input class="form-control" type="file"
                                                        placeholder="@lang('admin.pdf'):" id="example-number-input"
                                                        name="{{ $setting->key }}">
                                                </div>
                                                @if ($setting->value)
                                                    <div class="col-sm-4">
                                                        <a href="{{ asset($setting->value) }}" target="_blank">
                                                            <img style="width: 100px;height:100px"
                                                                src="{{ admin_path('images/pdf.png') }}" alt="" />
                                                        </a>
                                                    </div>
                                                @endif


                                            </div>
                                        @elseif($setting->type == 2)
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">
                                                    {{ trans('admin.' . $setting->key) }} </label>
                                                <div class="col-sm-10">
                                                    <textarea id="content{{ $setting->key }}" name="{{ $setting->key }}" class="form-control"> {{ $setting->value }} </textarea>
                                                </div>
                                            </div>
                                        @elseif($setting->type == 3)
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="global_meta_title">
                                                    {{ trans('settings.' . $setting->key) }}
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="global_meta_title"
                                                        placeholder="{{ trans('admin.' . $setting->key) }}"
                                                        name="{{ $setting->key }}" class="form-control"
                                                        value="{{ $setting->value }}" />
                                                    <iframe style="margin-top: 10px" src="{{ $setting->value }}"
                                                        frameborder="0"></iframe>
                                                </div>
                                            </div>
                                        @elseif($setting->type == 4)
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">
                                                    {{ trans('admin.' . $setting->key) }} </label>
                                                <div class="col-sm-10">
                                                    <textarea id="content{{ $setting->key }}" name="{{ $setting->key }}" class="form-control"> {{ $setting->value }} </textarea>
                                                </div>
                                            </div>
                                            <hr>
                                        @elseif($setting->type == 5)
                                            <div class="row mb-3">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">
                                                    {{ trans('admin.' . $setting->key) }} </label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="number" name="{{ $setting->key }}"
                                                        value="{{ $setting->value }}">
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer text-end">
                                    <a href="{{ route('admin.settings.index') }}"
                                        class="btn btn-outline-danger waves-effect waves-light ml-3">@lang('button.cancel')</a>
                                    <button type="submit" class="btn btn-success">@lang('button.save')</button>

                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>

    </div> <!-- container-fluid -->

@endsection




@section('script')
    {{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
@endsection
