@extends('admin.app')

@section('title', trans('portfolio.edit_portfolio'))
@section('title_page', trans('portfolio.edit', ['name' => @$portfolio->trans->where('locale',
    $current_lang)->first()->title]))


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

                            <form action="{{ route('admin.portfolio.update', $portfolio->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="accordion mt-4 mb-4" id="accordionExample">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                        {{ trans('admin.title') }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse show mt-3"
                                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">

                                                        @foreach ($languages as $key => $locale)
                                                            {{-- title ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text"
                                                                        name="{{ $locale }}[title]"
                                                                        value="{{ @$portfolio->trans->where('locale', $locale)->first()->title }}"
                                                                        id="title{{ $key }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.title'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- description ------------------------------------------------------------------------------------- --}}
                                                            <div class="row mb-3">
                                                                <label for="example-text-input"
                                                                    class="col-sm-2 col-form-label">{{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea id="description{{ $key }}" name="{{ $locale }}[description]"> {{ @$portfolio->trans->where('locale', $locale)->first()->description }} </textarea>
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
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>





                                    <div class="col-md-4">

                                        <div class="accordion mt-4 mb-4" id="accordionExampleTwo">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingtwo">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                        aria-expanded="true" aria-controls="collapseTwo">
                                                        {{ trans('admin.settings') }}
                                                    </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse show"
                                                    aria-labelledby="headingTwo" data-bs-parent="#accordionExampleTwo">
                                                    <div class="accordion-body">
                                                        <div class="col-sm-3 col-md-6 mb-3">
                                                            @if ($portfolio->type == 'image')
                                                                <div class="col-sm-3 col-md-6 mb-3">
                                                                    @if ($portfolio->image != null)
                                                                        <img src="{{ asset($portfolio->image) }}"
                                                                            alt="" style="width:100%">
                                                                    @endif
                                                                </div>
                                                            @elseif ($portfolio->type == 'video')
                                                                <div class="col-sm-3 col-md-6 mb-3">
                                                                    @if ($portfolio->image != null)
                                                                        <video width="100%" height="100%" controls>
                                                                            <source src="{{ asset($portfolio->image) }}"
                                                                                type="video/mp4">
                                                                        </video>
                                                                    @endif
                                                                </div>
                                                            @elseif ($portfolio->type == 'pdf')
                                                                <a href="{{ asset($portfolio->image) }}" target="_blank">
                                                                    <div class="col-sm-3 col-md-6 mb-3">
                                                                        @if ($portfolio->image != null)
                                                                            <embed src="{{ asset($portfolio->image) }}"
                                                                                width="100%" height="100%"
                                                                                type="application/pdf">
                                                                        @endif
                                                                    </div>
                                                                </a>


                                                            @endif
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
                                                                    <small class="text-muted" id="portfolio-media-help">{{ $current_lang === 'ar' ? 'اتركه فارغًا للاحتفاظ بالملف الحالي.' : 'Leave empty to keep the current file.' }}</small>
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
                                                                    @if($portfolio->poster)
                                                                        <img src="{{ asset($portfolio->posterInView()) }}" alt="" class="img-thumbnail mb-2" style="max-height:180px">
                                                                    @endif
                                                                    <input class="form-control" type="file" id="portfolio-poster"
                                                                        name="poster" accept="image/jpeg,image/png,image/webp">
                                                                    <small class="text-muted">{{ $current_lang === 'ar' ? 'مطلوب للفيديو وPDF، ويظهر على الكارد وقبل فتح الملف.' : 'Required for video and PDF and shown on cards before opening the file.' }}</small>
                                                                    @error('poster')
                                                                        <span class="text-danger d-block">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- type category ------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input">
                                                                    @lang('tags.tags'):</label>
                                                                <div class="col-sm-12">
                                                                    <select class="form-select form-select-sm select2"
                                                                        name="tag_id">
                                                                        <option value="" disabled selected>
                                                                            {{ trans('tags.tags') }}</option>
                                                                        @foreach ($tags as $tag)
                                                                            <option value="{{ $tag->id }}"
                                                                                {{ $portfolio->tag_id == $tag->id ? 'selected' : '' }}>
                                                                                {{ @$tag->trans->where('locale', $current_lang)->first()->title }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            @error('category_id')
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
                                                                        <option value="" disabled
                                                                            {{ old('type', $portfolio->type) == '' ? 'selected' : '' }}>
                                                                            {{ trans('admin.type') }}
                                                                        </option>

                                                                        <option value="image"
                                                                            {{ old('type', $portfolio->type) == 'image' ? 'selected' : '' }}>
                                                                            {{ trans('admin.image') }}
                                                                        </option>

                                                                        <option value="video"
                                                                            {{ old('type', $portfolio->type) == 'video' ? 'selected' : '' }}>
                                                                            {{ trans('admin.video') }}
                                                                        </option>

                                                                        <option value="pdf"
                                                                            {{ old('type', $portfolio->type) == 'pdf' ? 'selected' : '' }}>
                                                                            {{ trans('admin.pdf') }}
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            @error('type')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        {{-- sort ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-number-input" col-form-label>
                                                                    @lang('portfolio.sort'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="number"
                                                                        id="example-number-input" name="sort"
                                                                        value="{{ @$portfolio->sort }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- link ------------------------------------------------------------------------------------- --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label for="example-url-input" col-form-label>
                                                                    @lang('portfolio.link'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" type="url"
                                                                        id="example-url-input" name="link"
                                                                        value="{{ @$portfolio->link }}">
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
                                                                    {{ @$portfolio->feature == 1 ? 'checked' : '' }}
                                                                    value="1">
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
                                                                    {{ @$portfolio->status == 1 ? 'checked' : '' }}
                                                                    value="1">
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

                                    @if ($portfolio->galleryGroup && $portfolio->galleryGroup->images && $portfolio->galleryGroup->images->count())
                                        <div class="accordion mt-4 mb-4 bg-danger" id="accordionPortfolioGalleryOld">
                                            <div class="accordion-item border rounded">
                                                <h2 class="accordion-header" id="headingPortfolioGalleryOld">
                                                    <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapsePortfolioGalleryOld" aria-expanded="true"
                                                        aria-controls="collapsePortfolioGalleryOld">
                                                        @lang('admin.current_gallerys')
                                                    </button>
                                                </h2>

                                                <div id="collapsePortfolioGalleryOld"
                                                    class="accordion-collapse collapse show mt-3"
                                                    aria-labelledby="headingPortfolioGalleryOld"
                                                    data-bs-parent="#accordionPortfolioGalleryOld">
                                                    <div class="accordion-body">
                                                        <div class="row">
                                                            @foreach ($portfolio->galleryGroup->images->sortBy('sort') as $image)
                                                                <div class="col-md-4 p-3">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            @php
                                                                                $mediaUrl = asset(
                                                                                    $image->pathInView('portfolios'),
                                                                                );

                                                                                $ext = strtolower(
                                                                                    pathinfo(
                                                                                        $image->image,
                                                                                        PATHINFO_EXTENSION,
                                                                                    ),
                                                                                );

                                                                                if (
                                                                                    in_array($ext, [
                                                                                        'jpg',
                                                                                        'jpeg',
                                                                                        'png',
                                                                                        'gif',
                                                                                        'webp',
                                                                                        'svg',
                                                                                    ])
                                                                                ) {
                                                                                    $mediaType = 'image';
                                                                                } elseif (
                                                                                    in_array($ext, [
                                                                                        'mp4',
                                                                                        'mov',
                                                                                        'avi',
                                                                                        'mkv',
                                                                                    ])
                                                                                ) {
                                                                                    $mediaType = 'video';
                                                                                } elseif ($ext === 'pdf') {
                                                                                    $mediaType = 'pdf';
                                                                                } else {
                                                                                    $mediaType =
                                                                                        $image->type ?? 'other';
                                                                                }
                                                                            @endphp

                                                                            @if ($mediaType == 'image')
                                                                                <img src="{{ $mediaUrl }}"
                                                                                    alt=""
                                                                                    style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px;">
                                                                            @elseif ($mediaType == 'video')
                                                                                <video controls
                                                                                    style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px;">
                                                                                    <source src="{{ $mediaUrl }}"
                                                                                        type="video/mp4">
                                                                                </video>
                                                                            @elseif ($mediaType == 'pdf')
                                                                                <a href="{{ $mediaUrl }}"
                                                                                    target="_blank"
                                                                                    class="d-flex flex-column align-items-center justify-content-center bg-light text-decoration-none"
                                                                                    style="width: 100%; height: 120px; border-radius: 8px;">
                                                                                    <i
                                                                                        class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                                                                    <span class="text-danger small">PDF
                                                                                        File</span>
                                                                                </a>
                                                                            @else
                                                                                <a href="{{ $mediaUrl }}"
                                                                                    target="_blank"
                                                                                    class="d-flex align-items-center justify-content-center bg-light text-decoration-none"
                                                                                    style="width: 100%; height: 120px; border-radius: 8px;">
                                                                                    Open File
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="mb-2">
                                                                                <label>@lang('admin.sort')</label>
                                                                                <input type="number"
                                                                                    name="old_gallery_sort[{{ $image->id }}]"
                                                                                    class="form-control"
                                                                                    value="{{ $image->sort ?? 0 }}"
                                                                                    min="0">
                                                                            </div>

                                                                            <a class="btn btn-danger btn-sm"
                                                                                href="{{ \LaravelLocalization::localizeURL(route('admin.portfolio.destroy_portfolio_gallery_image', $image->id)) }}">
                                                                                <i class="fa fa-trash"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="accordion mt-4 mb-4 bg-danger" id="accordionPortfolioGallery">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingPortfolioGallery">
                                                <button class="accordion-button fw-medium collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapsePortfolioGallery"
                                                    aria-expanded="false" aria-controls="collapsePortfolioGallery">
                                                    @lang('admin.update_gallerys')
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
                                                                value="{{ $portfolio->galleryGroup?->translate($lang)?->title }}"
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
                                                class="btn btn-outline-danger waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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
        const originalPortfolioType = @json($portfolio->type);
        const hasPortfolioPoster = @json((bool) $portfolio->poster);

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
                portfolioMedia.required = Boolean(type && type !== originalPortfolioType);
            }
            if (portfolioPoster) portfolioPoster.required = needsPoster && (!hasPortfolioPoster || type !== originalPortfolioType);
            if (portfolioMediaHelp) {
                portfolioMediaHelp.textContent = type !== originalPortfolioType
                    ? @json($current_lang === 'ar' ? 'لتغيير النوع يجب رفع ملف رئيسي مطابق.' : 'Upload a matching main file when changing the type.')
                    : @json($current_lang === 'ar' ? 'اتركه فارغًا للاحتفاظ بالملف الحالي.' : 'Leave empty to keep the current file.');
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
