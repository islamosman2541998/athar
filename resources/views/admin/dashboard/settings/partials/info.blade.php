@extends('admin.app')

@section('title', trans('settings.settings'))
@section('title_page', trans('settings.edit', ['name' => @$settingMain->key]))


@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    < <script src="https://cdn.ckeditor.com/4.5.6/full/ckeditor.js"></script>
@endsection

@section('content')

    <div class="container-fluid">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="card">
                        <div class="card-body">

                            <!-- form start -->
                            <form class="form-horizontal" action="{{ route('admin.settings.update', $settingMain->id) }}"
                                method="POST" enctype="multipart/form-data" role="form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">

                                        <!--home page--->
                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            @foreach (range(1, 4) as $index)
                                                <div class="accordion-item border rounded mt-4">
                                                    <h2 class="accordion-header" id="heading{{ $index }}">
                                                        <button class="accordion-button fw-medium" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapse{{ $index }}"
                                                            aria-expanded="{{ $index == 1 ? 'true' : 'false' }}"
                                                            aria-controls="collapse{{ $index }}">
                                                            @lang('settings.section_{{ $index }}')
                                                        </button>
                                                    </h2>
                                                    <div id="collapse{{ $index }}"
                                                        class="accordion-collapse collapse {{ $index == 1 ? 'show' : '' }}"
                                                        aria-labelledby="heading{{ $index }}"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">

                                                            <div class="row mb-3">
                                                                @foreach ($languages as $key => $locale)
                                                                    <div class="col-6">
                                                                        <label for="example-text-input" class="col-form-label">
                                                                            {{ trans('admin.meta_title_in') . trans(Locale::getDisplayName($locale)) }}
                                                                        </label>
                                                                        <input class="form-control" type="text"
                                                                               name="section{{ $index }}_title{{ $locale }}"
                                                                               value="{{ $settings->where('key', 'section' . $index . '_title' . $locale)->first()->value ?? '' }}"
                                                                               id="title{{ $index . $key }}">
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <div class="row mb-3">
                                                                @foreach ($languages as $key => $locale)
                                                                    <div class="col-6">
                                                                        <label class="col-form-label">
                                                                            {{ trans('admin.meta_description_in') }} {{ trans(Locale::getDisplayName($locale)) }}
                                                                        </label>
                                                                        <textarea
                                                                            class="form-control"
                                                                            name="section{{ $index }}_description{{ $locale }}"
                                                                            id="section{{ $index }}_description{{ $locale }}"
                                                                            rows="3"
                                                                        >{{ $settings->where('key', 'section' . $index . '_description' . $locale)->first()->value ?? '' }}</textarea>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            
                                                            
                                                            <div class="row ">
                                                                <label>@lang('admin.image')</label>
                                                                <div class="col-12 col-lg-6">
                                                                    <input type="file" name="section{{ $index }}_image" class="form-control">
                                                                </div>
                                                                <div class="col-12 col-lg-3">
                                                                    <img class="img-fluid" src="{{ asset($settings->where('key', 'section' . $index . '_image')->first()->value ?? '') }}" alt="">
                                                                </div>
                                                               
{{--                                                                 
                                                                <script>
                                                                    let isEnabled = true; 
                                                                
                                                                    function toggleStatus() {
                                                                        const button = document.getElementById('toggleButton');
                                                                        if (isEnabled) {
                                                                            button.textContent = 'Disable';
                                                                            button.classList.remove('btn-primary');
                                                                            button.classList.add('btn-danger');
                                                                            isEnabled = false;
                                                                        } else {
                                                                            button.textContent = 'Enable';
                                                                            button.classList.remove('btn-danger');
                                                                            button.classList.add('btn-primary');
                                                                            isEnabled = true;
                                                                        }
                                                                    }
                                                                </script> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>


                                    </div>
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
