@extends('admin.app')

@section('title', __('admin.edit_blog'))
@section('title_page', __('admin.edit_blog'))

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.blogs.index') }}"
                                class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form class="row" method="post" action="{{ route('admin.blogs.update', $blog->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- title and description --}}
                                <div class="col-md-8">
                                    @foreach ($languages as $key => $locale)
                                        @php $trans = $blog->trans->where('locale', $locale)->first(); @endphp
                                        @if ($trans)
                                            <div class="accordion mt-4 mb-4" id="accordionExample">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                        <button class="accordion-button fw-medium" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne{{ $key }}"
                                                            aria-expanded="true"
                                                            aria-controls="collapseOne{{ $key }}">
                                                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne{{ $key }}"
                                                        class="accordion-collapse collapse show mt-3"
                                                        aria-labelledby="headingOne{{ $key }}"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            {{-- title ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text"
                                                                        name="{{ $locale }}[title]"
                                                                        value="{{ old($locale . '.title') ?? $trans->title }}"
                                                                        id="title{{ $key }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- slug ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3 slug-section">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="{{ $locale }}[slug]"
                                                                        value="{{ old($locale . '.slug') ?? $trans->slug }}"
                                                                        id="slug{{ $key }}"
                                                                        class="form-control slug" required>
                                                                </div>
                                                                @if ($errors->has($locale . '.slug'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                                @endif
                                                            </div>

                                                            @include('admin.layouts.scriptSlug')

                                                            {{-- description ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label"> @lang('admin.description_in')
                                                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ old($locale . '.description') ?? $trans->description }} </textarea>
                                                                    <script type="text/javascript">
                                                                        CKEDITOR.replace('description{{ $key }}', {
                                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                            filebrowserUploadMethod: 'form'
                                                                        });
                                                                    </script>
                                                                    @if ($errors->has($locale . '.description'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="accordion mt-4 mb-4" id="accordionExample">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                        <button class="accordion-button fw-medium" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne{{ $key }}"
                                                            aria-expanded="true"
                                                            aria-controls="collapseOne{{ $key }}">
                                                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne{{ $key }}"
                                                        class="accordion-collapse collapse show mt-3"
                                                        aria-labelledby="headingOne{{ $key }}"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            {{-- title ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text" required
                                                                        name="{{ $locale }}[title]"
                                                                        value="{{ old($locale . '.title') }}"
                                                                        id="title{{ $key }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- slug ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3 slug-section">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="{{ $locale }}[slug]"
                                                                        value="{{ old($locale . '.slug') }}"
                                                                        id="slug{{ $key }}"
                                                                        class="form-control slug" required>
                                                                </div>
                                                                @if ($errors->has($locale . '.slug'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                                @endif
                                                                <script>
                                                                    $(document).ready(function() {
                                                                        $("#title" + {
                                                                            {
                                                                                $key
                                                                            }
                                                                        }).on('keyup', function() {
                                                                            var Text = $(this).val();
                                                                            Text = Text.toLowerCase();
                                                                            Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g, '-');
                                                                            $("#slug" + {
                                                                                {
                                                                                    $key
                                                                                }
                                                                            }).val(Text);
                                                                        });
                                                                    });
                                                                </script>
                                                            </div>
                                                            @include('admin.layouts.scriptSlug')

                                                            {{-- description ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label"> @lang('admin.description_in')
                                                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ old($locale . '.description') }} </textarea>
                                                                    <script type="text/javascript">
                                                                        CKEDITOR.replace('description{{ $key }}', {
                                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                            filebrowserUploadMethod: 'form'
                                                                        });
                                                                    </script>
                                                                    @if ($errors->has($locale . '.description'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    {{-- meta info --}}
                                    <div class="accordion mt-4 mb-4 bg-success" id="accordionExample">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingTwo{{ $key }}">
                                                <button class="accordion-button fw-medium collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapseTwo{{ $key }}" aria-expanded="true"
                                                    aria-controls="collapseTwo{{ $key }}">
                                                    @lang('admin.meta')
                                                </button>
                                            </h2>
                                            <div id="collapseTwo{{ $key }}"
                                                class="accordion-collapse collapse mt-3"
                                                aria-labelledby="headingTwo{{ $key }}"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    @foreach ($languages as $key => $locale)
                                                        @php $trans = $blog->trans->where('locale', $locale)->first(); @endphp
                                                        @if ($trans)
                                                            {{-- meta info  ------------------------------------------------------------------------------------- --}}
                                                            {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text"
                                                                        name="{{ $locale }}[meta_title]"
                                                                        value="{{ old($locale . '.meta_title') ?? $trans->meta_title }}"
                                                                        id="title{{ $key }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.meta_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label"> @lang('admin.meta_description_in')
                                                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea id="meta_description{{ $key }}" name="{{ $locale }}[meta_desc]"
                                                                        class="form-control description">    {!! $trans->meta_desc !!} </textarea>
                                                                    <script type="text/javascript">
                                                                        CKEDITOR.replace('meta_description{{ $key }}', {
                                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                            filebrowserUploadMethod: 'form'
                                                                        });
                                                                    </script>
                                                                    @if ($errors->has($locale . '.meta_description'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label"> @lang('admin.meta_key_in')
                                                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {!! $trans->meta_key !!}</textarea>
                                                                    @if ($errors->has($locale . '.meta_key'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <!----------end meta info ----------------->
                                                        @else
                                                            {{-- meta info  ------------------------------------------------------------------------------------- --}}
                                                            {{-- slug ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3 slug-section">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text"
                                                                        name="{{ $locale }}[slug]"
                                                                        value="{{ old($locale . '.slug') }}"
                                                                        id="slug{{ $key }}"
                                                                        class="form-control slug" required>
                                                                </div>
                                                                @if ($errors->has($locale . '.slug'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                                @endif
                                                                <script>
                                                                    $(document).ready(function() {
                                                                        $("#title" + {
                                                                            {
                                                                                $key
                                                                            }
                                                                        }).on('keyup', function() {
                                                                            var Text = $(this).val();
                                                                            Text = Text.toLowerCase();
                                                                            Text = Text.replace(/[^a-zA-Z0-9ء-ي]+/g, '-');
                                                                            $("#slug" + {
                                                                                {
                                                                                    $key
                                                                                }
                                                                            }).val(Text);
                                                                        });
                                                                    });
                                                                </script>
                                                            </div>

                                                            {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text"
                                                                        name="{{ $locale }}[meta_title]"
                                                                        value="{{ old($locale . '.meta_title') }}"
                                                                        id="title{{ $key }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.meta_title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label"> @lang('admin.meta_description_in')
                                                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea id="meta_description{{ $key }}" name="{{ $locale }}[meta_desc]"
                                                                        class="form-control description"> {{ old($locale . '.meta_desc') }} </textarea>
                                                                    <script type="text/javascript">
                                                                        CKEDITOR.replace('meta_description{{ $key }}', {
                                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                            filebrowserUploadMethod: 'form'
                                                                        });
                                                                    </script>
                                                                    @if ($errors->has($locale . '.meta_description'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label"> @lang('admin.meta_key_in')
                                                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{ old($locale . '.meta_key') }} </textarea>
                                                                    @if ($errors->has($locale . '.meta_key'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <!----------end meta info ----------------->
                                                        @endif
                                                        <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                               

                                

                                </div>

                                {{-- other info --}}

                                <div class="col-md-4">
                                    <div class="accordion mt-4 mb-4 bg-danger" id="accordionExample_Settings">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingSettings">
                                                <button class="accordion-button fw-medium " type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseSettings"
                                                    aria-expanded="true" aria-controls="collapseSettings">
                                                    @lang('admin.settings')
                                                </button>
                                            </h2>
                                            <div id="collapseSettings" class="accordion-collapse collapse show mt-3"
                                                aria-labelledby="headingSettings"
                                                data-bs-parent="#accordionExample_Settings">
                                                <div class="accordion-body">


                                                    @if (@$blog->image != null)
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <div class="col-sm-12">
                                                                    <a href="{{ asset($blog->pathInView())}}"
                                                                        target="_blank">
                                                                        <img src="{{ asset($blog->pathInView())}}"
                                                                            alt="" style="width:100%">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label for="example-number-specialty"
                                                                class="col-sm-4 col-form-label">
                                                                @lang('products.image')</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="file"
                                                                    placeholder="@lang('products.image')" name="image">
                                                            </div>
                                                        </div>
                                                    </div>

                                           

                                                

                                                    {{-- sort ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label for="example-number-address"
                                                                class="col-sm-2 col-form-label">
                                                                @lang('admin.sort')</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="number"
                                                                    placeholder="@lang('admin.sort')" name="sort"
                                                                    value="{{ $blog->sort ?? old('sort') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                           
                                                    {{-- feature ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-2 col-form-label"
                                                            for="available">{{ trans('admin.feature') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch" name="feature"
                                                                type="checkbox" id="switch1" switch="success"
                                                                {{ $blog->feature == 1 || old('feature') == 1 ? 'checked' : '' }}
                                                                value="1">
                                                            <label class="form-label" for="switch1"
                                                                data-on-label=" @lang('admin.yes') "
                                                                data-off-label=" @lang('admin.no')"></label>
                                                        </div>
                                                    </div>
                                                    {{-- Status ------------------------------------------------------------------------------------- --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-2 col-form-label"
                                                            for="available">{{ trans('admin.status') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch" name="status"
                                                                type="checkbox" id="switch3" switch="success"
                                                                {{ $blog->status == 1 || old('status') == 1 ? 'checked' : '' }}
                                                                value="1">
                                                            <label class="form-label" for="switch3"
                                                                data-on-label=" @lang('admin.yes') "
                                                                data-off-label=" @lang('admin.no')"></label>
                                                        </div>
                                                    </div>



                                                    <hr>
                                               


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                             

                                <div class="row mb-3 text-end">
                                    <div>
                                        <button type="submit"
                                            class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.submit')</button>
                                        <a href="{{ route('admin.blogs.index') }}"
                                            class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div> <!-- end row-->
    </div>
@endsection

@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(function() {
            @foreach ($languages as $key => $locale)
                CKEDITOR.replace('description{{ $key }}', {
                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) ?? '#' }}",
                    filebrowserUploadMethod: 'form'
                });
            @endforeach
        });
    </script>
@endsection
