@extends('admin.app')

@section('title', trans('settings.settings'))
@section('title_page', trans('settings.edit', ['name' => @$settingMain->key]))

@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.5.6/full/ckeditor.js"></script>
@endsection
@section('content')
<div class="container-fluid">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <!-- form start -->
                        <form class="form-horizontal"
                              action="{{ route('admin.settings.update-custom', $settingMain->key) }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="accordion mt-4 mb-4" id="upperNotifyAccordion">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingUpperNotify">
                                                <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseUpperNotify"
                                                        aria-expanded="true"
                                                        aria-controls="collapseUpperNotify">
                                                    {{ __('settings.upper_notify_settings') }}
                                                </button>
                                            </h2>
                                            <div id="collapseUpperNotify"
                                                 class="accordion-collapse collapse show mt-3"
                                                 aria-labelledby="headingUpperNotify"
                                                 data-bs-parent="#upperNotifyAccordion">
                                                <div class="accordion-body">
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label">
                                                            {{ __('settings.upper_show') }}
                                                        </label>
                                                        <div class="col-sm-10 d-flex align-items-center">
                                                            @php
                                                                $showUpper = (int) ($settings['upper_show'] ?? 0);
                                                            @endphp
                                                            <input type="hidden" name="upper_show" value="0">
                                                            <input type="checkbox"
                                                                   name="upper_show"
                                                                   value="1"
                                                                   id="upper_show"
                                                                   {{ $showUpper ? 'checked' : '' }}>
                                                            <label for="upper_show" class="ms-2">
                                                                {{ __('settings.enable_upper_notify') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-end">
                                <a href="{{ route('admin.settings.index') }}"
                                   class="btn btn-outline-danger waves-effect waves-light ml-3">
                                    @lang('button.cancel')
                                </a>
                                <button type="submit" class="btn btn-success">@lang('button.save')</button>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
</div> <!-- container-fluid -->
@endsection

@section('script')
    
@endsection
