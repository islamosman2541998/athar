@extends('admin.app')

@section('content')
<div class="container py-4">
    <h2>{{ __('admin.edit_filter') }}</h2>

    @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('admin.filters.update', $filter) }}" method="POST">
        @csrf @method('PUT')

        {{-- Parent --}}
        <div class="mb-3">
          <label class="form-label">{{ __('admin.parent_filter') }}</label>
          <select name="parent_id" class="form-select">
            <option value="">{{ __('admin.no_parent') }}</option>
            @foreach($parents as $p)
              <option value="{{ $p->id }}" {{ old('parent_id', $filter->parent_id) == $p->id ? 'selected' : '' }}>
                {{ $p->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Name (EN)</label>
          <input type="text" name="name[en]" class="form-control" value="{{ old('name.en', $translations['en']->name ?? $filter->name) }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">الاسم (AR)</label>
          <input type="text" name="name[ar]" class="form-control" value="{{ old('name.ar', $translations['ar']->name ?? '') }}" required>
        </div>

        <button class="btn btn-primary">{{ __('admin.update') }}</button>
        <a href="{{ route('admin.filters.index') }}" class="btn btn-secondary">
            {{ __('admin.cancel') }}
        </a>
    </form>
</div>
@endsection