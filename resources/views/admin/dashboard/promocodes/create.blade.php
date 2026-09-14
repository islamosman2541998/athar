@extends('admin.app')

@section('title', trans('admin.create_promocode'))
@section('title_page', trans('admin.create_promocode'))

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-8 offset-2">
      <div class="card">
        <div class="card-body">

          <form id="promo-form" action="{{ route('admin.promocodes.store') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label for="code" class="form-label">@lang('promocodes.code')</label>
              <input type="text" name="code" id="code"
                     value="{{ old('code') }}"
                     class="form-control @error('code') is-invalid @enderror">
              @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label for="type" class="form-label">@lang('promocodes.type')</label>
              <select name="type" id="type"
                      class="form-select @error('type') is-invalid @enderror">
                <option value="percent" {{ old('type')=='percent' ? 'selected':'' }}>
                  @lang('promocodes.type_percent')
                </option>
                <option value="fixed" {{ old('type')=='fixed' ? 'selected':'' }}>
                  @lang('promocodes.type_fixed')
                </option>
              </select>
              @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label for="value" class="form-label">@lang('promocodes.value')</label>
              <input type="number" step="0.01" name="value" id="value"
                     value="{{ old('value') }}"
                     class="form-control @error('value') is-invalid @enderror">
              @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label for="start_at" class="form-label">@lang('promocodes.start_at')</label>
              <input type="datetime-local" name="start_at" id="start_at"
                     value="{{ old('start_at') }}"
                     class="form-control @error('start_at') is-invalid @enderror">
              @error('start_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label for="usage_limit" class="form-label">@lang('promocodes.usage_limit')</label>
              <input type="number" name="uses_left" id="usage_limit"
                     value="{{ old('uses_limit',1) }}"
                     class="form-control @error('uses_left') is-invalid @enderror" min="1">
              @error('uses_left')<div class="invalid-feedback">{{ $message }}</div>@enderror
              <small class="form-text text-muted">
                @lang('promocodes.usage_limit_help')
              </small>
            </div>

            <div class="mb-3">
              <label for="end_at" class="form-label">@lang('promocodes.end_at')</label>
              <input type="datetime-local" name="end_at" id="end_at"
                     value="{{ old('end_at') }}"
                     class="form-control @error('end_at') is-invalid @enderror">
              @error('end_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <hr>

            <div class="mb-3">
              <label for="title_ar" class="form-label">@lang('promocodes.title_ar')</label>
              <input type="text" name="title[ar]" id="title_ar"
                     value="{{ old('title.ar') }}"
                     class="form-control @error('title.ar') is-invalid @enderror">
              @error('title.ar')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
              <label for="title_en" class="form-label">@lang('promocodes.title_en')</label>
              <input type="text" name="title[en]" id="title_en"
                     value="{{ old('title.en') }}"
                     class="form-control @error('title.en') is-invalid @enderror">
              @error('title.en')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <hr>

            <div class="row mb-4">
              <div class="col-md-5">
                <label>@lang('promocodes.all_categories')</label>
                <select id="all-cats" multiple size="10" class="form-select">
                  @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2 d-flex flex-column justify-content-center">
                <button type="button" id="btn-add" class="btn btn-primary mb-2">&raquo;</button>
                <button type="button" id="btn-remove" class="btn btn-danger">&laquo;</button>
              </div>
              <div class="col-md-5">
                <label>@lang('promocodes.selected_categories')</label>
                <select name="categories[]" id="selected-cats" multiple size="10"
                        class="form-select @error('categories') is-invalid @enderror">
                </select>
                @error('categories')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="text-center mt-4">
              <button type="submit" class="btn btn-primary">@lang('admin.save')</button>
              <a href="{{ route('admin.promocodes.index') }}" class="btn btn-secondary">
                @lang('admin.cancel')
              </a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', ()=> {
  const all   = document.getElementById('all-cats'),
        sel   = document.getElementById('selected-cats'),
        add   = document.getElementById('btn-add'),
        rem   = document.getElementById('btn-remove'),
        form  = document.getElementById('promo-form');

  add.onclick = ()=> {
    Array.from(all.selectedOptions).forEach(o=>{
      sel.appendChild(o.cloneNode(true));
      all.removeChild(o);
    });
  };
  rem.onclick = ()=> {
    Array.from(sel.selectedOptions).forEach(o=>{
      all.appendChild(o.cloneNode(true));
      sel.removeChild(o);
    });
  };

  form.addEventListener('submit', ()=>{
    Array.from(sel.options).forEach(o=> o.selected = true);
  });
});
</script>
@endpush
