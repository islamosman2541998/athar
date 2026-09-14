@extends('admin.app')

@section('title', trans('portfolio.create'))
@section('title_page', trans('portfolio.create'))

@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.portfolio.index') }}"
                                class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('admin.portfolio.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        @foreach ($languages as $key => $locale)
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
                                                                        value="{{ old($locale . '.title') }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- description ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3 mt-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label"> @lang('admin.description_in')
                                                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ old($locale . '.description') }} </textarea>
                                                                    @if ($errors->has($locale . '.description'))
                                                                        <span
                                                                            class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                                    @endif
                                                                </div>


                                                                <script type="text/javascript">
                                                                    CKEDITOR.replace('description{{ $key }}', {
                                                                        filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                        filebrowserUploadMethod: 'form'
                                                                    });
                                                                </script>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach


                                    </div>


                                    <div class="col-md-4">

                                        <div class="accordion mt-4 mb-4" id="accordionExample1">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingtwo">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                        aria-expanded="true" aria-controls="collapseTwo">
                                                        {{ trans('admin.settings') }}
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse show"
                                                    aria-labelledby="headingtwo" data-bs-parent="#accordionExample1">
                                                    <div class="accordion-body">
                                                        {{-- tags  ------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input">
                                                                    @lang('tags.tags'):</label>
                                                                <div class="col-sm-12">
                                                                    <select class="form-select form-select-sm select2"
                                                                        name="tag_id">
                                                                        <option value="" selected disabled>
                                                                            {{ trans('tags.tags') }}</option>
                                                                        @foreach ($tags as $tag)
                                                                            <option value="{{ $tag->id }}"
                                                                                {{ old('tag_id') == $tag->id ? 'selected' : '' }}>
                                                                                {{ @$tag->trans->where('locale', $current_lang)->first()->title }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            @error('tag_id')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- type  ------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input">
                                                                    @lang('admin.type'):</label>
                                                                <div class="col-sm-12">
                                                                    <select class="form-select form-select-sm select2"
                                                                        name="type" id="portfolio-media-type">
                                                                        <option value="" {{ old('type') ? '' : 'selected' }} disabled>
                                                                            {{ trans('admin.type') }}</option>
                                                                        <option value="image" {{ old('type') === 'image' ? 'selected' : '' }}>
                                                                            {{ trans('admin.image') }}
                                                                        </option>
                                                                        <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>
                                                                            {{ trans('admin.video') }}
                                                                        </option>
                                                                        <option value="pdf" {{ old('type') === 'pdf' ? 'selected' : '' }}>
                                                                            {{ trans('admin.pdf') }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            @error('type')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- link ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('admin.link'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="text"
                                                                        placeholder="@lang('admin.link'):"
                                                                        id="example-number-input" name="link"
                                                                        value="{{ old('link') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- image ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('admin.media'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="file"
                                                                        placeholder="@lang('admin.media'):"
                                                                        id="portfolio-main-media" name="image"
                                                                        accept="image/*,video/*,application/pdf">
                                                                    <small class="text-muted" id="portfolio-media-help">{{ $current_lang === 'ar' ? 'اختر نوع الغلاف أولاً، ثم ارفع الملف المطابق.' : 'Choose the cover type first, then upload the matching file.' }}</small>

                                                                    @error('image')
                                                                        <span class="text-danger d-block">{{ $message }}</span>
                                                                    @enderror

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12" id="portfolio-poster-field">
                                                            <div class="row mb-3">
                                                                <label for="portfolio-poster" col-form-label>
                                                                    {{ $current_lang === 'ar' ? 'بوستر الغلاف' : 'Cover poster' }}:</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="file" id="portfolio-poster"
                                                                        name="poster" accept="image/jpeg,image/png,image/webp">
                                                                    <small class="text-muted">{{ $current_lang === 'ar' ? 'مطلوب للفيديو وPDF، ويظهر قبل فتح الملف. JPG أو PNG أو WebP.' : 'Required for video and PDF and shown before opening the file. JPG, PNG or WebP.' }}</small>
                                                                    @error('poster')
                                                                        <span class="text-danger d-block">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- sort ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('admin.sort'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="number"
                                                                        id="example-number-input" name="sort"
                                                                        value="{{ old('sort') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- feature ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <label class="col-sm-12 col-form-label"
                                                                for="available">{{ trans('admin.feature') }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-check form-switch" name="feature"
                                                                    type="checkbox" id="switch1" switch="success"
                                                                    checked value="1">
                                                                <label class="form-label" for="switch1"
                                                                    data-on-label=" @lang('admin.yes') "
                                                                    data-off-label=" @lang('admin.no')"></label>
                                                            </div>
                                                        </div>

                                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <label class="col-sm-12 col-form-label"
                                                                for="available">{{ trans('admin.status') }}</label>
                                                            <div class="col-sm-10">
                                                                <input class="form-check form-switch" name="status"
                                                                    type="checkbox" id="switch3" switch="success"
                                                                    checked value="1">
                                                                <label class="form-label" for="switch3"
                                                                    data-on-label=" @lang('admin.yes') "
                                                                    data-off-label=" @lang('admin.no')"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="accordion mt-4 mb-4 bg-danger" id="accordionPortfolioGallery">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingPortfolioGallery">
                                                <button class="accordion-button fw-medium collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsePortfolioGallery"
                                                    aria-expanded="false" aria-controls="collapsePortfolioGallery">
                                                    @lang('admin.gallerys')
                                                </button>
                                            </h2>

                                            <div id="collapsePortfolioGallery" class="accordion-collapse collapse mt-3"
                                                aria-labelledby="headingPortfolioGallery"
                                                data-bs-parent="#accordionPortfolioGallery">
                                                <div class="accordion-body">
                                                    <input type="hidden" class="form-control" value="2"
                                                        name="gallery[type]">

                                                    @foreach (config('translatable.locales') as $lang)
                                                        <div class="mb-3">
                                                            <label>@lang('admin.group_title_' . $lang)</label>
                                                            <input type="text" class="form-control"
                                                                name="gallery[{{ $lang }}][title]">
                                                        </div>
                                                    @endforeach

                                                    <div id="images_section"></div>

                                                    <button type="button" class="btn btn-success form-control mt-3"
                                                        id="add_images_section">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Butoooons ------------------------------------------------------------------------- --}}
                                    <div class="row mb-3 text-end">
                                        <div>
                                            <a href="{{ route('admin.portfolio.index') }}"
                                                class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                            <button type="submit"
                                                class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                                        </div>
                                    </div>
                                </div>

                            </form>

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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const portfolioType = document.getElementById('portfolio-media-type');
        const portfolioMedia = document.getElementById('portfolio-main-media');
        const portfolioPoster = document.getElementById('portfolio-poster');
        const portfolioMediaHelp = document.getElementById('portfolio-media-help');

        function syncPortfolioMediaFields() {
            const type = portfolioType?.value;
            const needsPoster = type === 'video' || type === 'pdf';
            const accepts = {
                image: 'image/jpeg,image/png,image/gif,image/webp,image/svg+xml',
                video: 'video/mp4,video/quicktime,video/webm,.avi,.mkv',
                pdf: 'application/pdf'
            };

            if (portfolioMedia) {
                portfolioMedia.accept = accepts[type] || 'image/*,video/*,application/pdf';
            }
            if (portfolioPoster) portfolioPoster.required = needsPoster;
            if (portfolioMediaHelp) {
                portfolioMediaHelp.textContent = type === 'image'
                    ? @json($current_lang === 'ar' ? 'ارفع صورة الغلاف الرئيسية.' : 'Upload the main cover image.')
                    : type === 'video'
                        ? @json($current_lang === 'ar' ? 'ارفع ملف الفيديو الرئيسي.' : 'Upload the main video file.')
                        : type === 'pdf'
                            ? @json($current_lang === 'ar' ? 'ارفع ملف PDF الرئيسي.' : 'Upload the main PDF file.')
                            : @json($current_lang === 'ar' ? 'اختر نوع الغلاف أولاً.' : 'Choose the cover type first.');
            }
        }

        portfolioType?.addEventListener('change', syncPortfolioMediaFields);
        syncPortfolioMediaFields();
        });

        let imageIndex = 0;

        $(document).on('click', '#add_images_section', function() {
            imageIndex++;

            $('#images_section').append(`
            <div class="card mt-3 gallery-row">
                <div class="card-body">
                    <div class="mb-3">
                       <label>@lang('admin.media')</label>
<input type="file" name="gallery_image[]" class="form-control" accept="image/*,video/*,application/pdf">
<small class="text-muted">Allowed: jpg, png, gif, webp, svg, mp4, mov, avi, mkv, pdf</small>
                    </div>

                    <div class="mb-3">
                        <label>@lang('admin.sort')</label>
                        <input type="number" name="gallery_sort[]" class="form-control" value="0">
                    </div>

                    <div class="mb-3">
                        <label>@lang('admin.feature')</label>
                        <input type="checkbox" name="gallery_feature[${imageIndex}]" value="1">
                    </div>

                    <button type="button" class="btn btn-danger btn-sm remove-gallery-row">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        `);
        });

        $(document).on('click', '.remove-gallery-row', function() {
            $(this).closest('.gallery-row').remove();
        });
    </script>
@endsection
