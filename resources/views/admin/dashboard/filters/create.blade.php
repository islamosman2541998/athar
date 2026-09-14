@extends('admin.app')

@section('content')
<div class="container py-4">
    <h2>{{ __('admin.create_filter') }}</h2>

    @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('admin.filters.store') }}" method="POST">
        @csrf
      
        {{-- Parent --}}
        <div class="mb-3">
          <label class="form-label">{{ __('admin.parent_filter') }}</label>
          <select name="parent_id" class="form-select">
            <option value="">{{ __('admin.no_parent') }}</option>
            @foreach($parents as $p)
              <option value="{{ $p->id }}">{{ $p->name }}</option>
            @endforeach
          </select>
        </div>
      
        {{-- Name EN --}}
        <div class="mb-3">
          <label class="form-label">Name (EN)</label>
          <input type="text" name="name[en]" class="form-control" value="{{ old('name.en') }}" required>
        </div>
      
        {{-- Name AR --}}
        <div class="mb-3">
          <label class="form-label">الاسم (AR)</label>
          <input type="text" name="name[ar]" class="form-control" value="{{ old('name.ar') }}" required>
        </div>
      
        <button class="btn btn-success">{{ __('admin.save') }}</button>
      </form>
</div>
@endsection
