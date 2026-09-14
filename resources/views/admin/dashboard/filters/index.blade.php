@extends('admin.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>{{ __('admin.filters_management') }}</h2>
        <a href="{{ route('admin.filters.create') }}" class="btn btn-primary">
            {{ __('admin.add_filter') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-light">
          <tr>
            <th>{{ __('admin.name') }}</th>
            <th>{{ __('admin.filter_type') }}</th>
            <th>{{ __('admin.products_count') }}</th>
            <th>{{ __('admin.products') }}</th>
            <th style="width:160px">{{ __('admin.actions') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($parents as $parent)
            <tr class="table-primary">
                <td>{{ $parent->name }}</td>
                <td>{{ __('admin.parent') }}</td>
              <td></td>
              <td>
               
              </td>
              <td>
                <a href="{{ route('admin.filters.edit', $parent) }}" class="btn btn-sm btn-warning">
                  {{ __('admin.actions.edit') }}
                </a>
                <form action="{{ route('admin.filters.destroy', $parent) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('admin.are_you_sure') }}');">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">{{ __('admin.actions.delete') }}</button>
                </form>
              </td>
            </tr>
            @foreach($parent->children as $child)
            <tr>
                <td>&nbsp;&nbsp;— {{ $child->name }}</td>
                <td>{{ __('admin.child') }}</td>
              <td>{{ $child->products_count }}</td>
              <td>
                <a href="{{ route('admin.filters.products', $child) }}" class="btn btn-sm btn-secondary">
                  {{ __('admin.add_products') }}
                </a>
              </td>
              <td>
                <a href="{{ route('admin.filters.edit', $child) }}" class="btn btn-sm btn-warning">
                  {{ __('admin.actions.edit') }}
                </a>
                <form action="{{ route('admin.filters.destroy', $child) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('admin.are_you_sure') }}');">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">{{ __('admin.actions.delete') }}</button>
                </form>
              </td>
            </tr>
            @endforeach
          @endforeach
        </tbody>
      </table>
      
</div>
@endsection
