@extends('admin.app')
@section('title', __('partners.edit'))
@section('title_page', __('partners.edit'))
@section('content')
    <div class="container-fluid">
        <form
            action="{{ isset($partner) ? route('admin.partners.update', $partner->id) : route('admin.partners.store') }}"
            method="post" enctype="multipart/form-data">
            @csrf
            @if (isset($partner))
                @method('PUT')
            @endif

            <div class="row">
                {{-- <div class="col-md-9">
                    @foreach ($languages as $key => $locale)
                        <div class="accordion mb-3" id="acc{{ $key }}">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $key }}">
                                        @lang('lang.' . \Locale::getDisplayName($locale))
                                    </button>
                                </h2>
                                <div id="collapse{{ $key }}" class="accordion-collapse collapse show"
                                    data-bs-parent="#acc{{ $key }}">
                                    <div class="accordion-body">
                                        <div class="mb-3">
                                            <label>@lang('partners.title') ({{ $locale }})</label>
                                            <input type="text" name="{{ $locale }}[title]" class="form-control"
                                                value="{{ old($locale . '.title', isset($partner) ? $partner->translate($locale)->title ?? '' : '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div> --}}

                <div class="col-md-12">
                    <div class="card p-3">
                        <div class="mb-3">
                            <label>@lang('partners.image')</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if (isset($partner) && $partner->image)
                                <img src="{{ asset('storage/attachments/partners/' . $partner->image) }}"
                                    style="width:20%;margin-top:10px">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label>@lang('partners.url')</label>
                            <input type="text" name="url" class="form-control"
                                value="{{ old('url', $partner->url ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label>@lang('partners.sort')</label>
                            <input type="number" name="sort" class="form-control"
                                value="{{ old('sort', $partner->sort ?? 0) }}">
                        </div>
                        <div class="mb-3">
                            <label>@lang('partners.status')</label><br>
                            <input type="checkbox" name="status" value="1"
                                {{ old('status', $partner->status ?? 1) ? 'checked' : '' }}>
                        </div>

                    </div>
                </div>
                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.partners.index') }}"
                            class="btn btn-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        <button type="submit"
                            class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
