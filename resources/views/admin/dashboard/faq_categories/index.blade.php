@extends('admin.app')

@section('title', __('faq_category.faq_category'))
@section('title_page', __('faq_category.faq_category'))

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12 text-end">
            <a href="{{ route('admin.faq-categories.create') }}" class="btn btn-success btn-sm">@lang('button.create')</a>
        </div>
    </div>

  

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.faq-categories.index') }}" class="row g-2 mb-3">
                <div class="col-md-4">
                    <input name="search" value="{{ request('search') }}" class="form-control" placeholder="@lang('admin.title')">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">@lang('admin.status')</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>@lang('admin.active')</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>@lang('admin.dis_active')</option>
                    </select>
                </div>
                
                <div class="search-input col-md-2">
                    <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-search"> </i></button>
                    <a class="btn btn-success btn-sm" href=""{{ route('admin.faq-categories.index') }}""><i
                            class="refresh ion ion-md-refresh"></i></a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('admin.title')</th>
                            <th>@lang('admin.sort')</th>
                            <th>@lang('admin.status')</th>
                            <th  class="text-end">@lang('admin.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                            <tr>
                                <td>{{ $cat->id }}</td>
                                <td>{{ $cat->translate(app()->getLocale())->title ?? $cat->translate(config('app.fallback_locale'))->title ?? '-' }}</td>
                                <td>{{ $cat->sort }}</td>
                                <td>
                                    @if($cat->status)
                                        <span class="badge bg-success">@lang('admin.active')</span>
                                    @else
                                        <span class="badge bg-warning">@lang('admin.dis_active')</span>
                                    @endif
                                </td>
                            
                                 <td class="text-end">

                                    <a href="{{ route('admin.faq-categories.show', $cat->id) }}" title="@lang('admin.show')"
                                        class="btn btn-xs btn-outline-info btn-sm m-1"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.faq-categories.edit', $cat->id) }}" title="@lang('admin.edit')"
                                        class="btn btn-outline-primary btn-sm m-1"><i class="fas fa-pencil-alt"></i></a>

                                    @if ($cat->status == 1)
                                        <a href="{{ route('admin.faq-categories.toggle-status', $cat->id) }}"
                                            title="@lang('admin.active')" class="btn btn-xs btn-success btn-sm m-1"><i
                                                class="fa fa-check"></i></a>
                                    @else
                                        <a href="{{ route('admin.faq-categories.toggle-status', $cat->id) }}"
                                            title="@lang('admin.dis_active')"
                                            class="btn btn-xs btn-outline-secondary btn-sm m-1"><i
                                                class="fa fa-ban"></i></a>
                                    @endif

                                    <form action="{{ route('admin.faq-categories.destroy', $cat->id) }}" method="POST"
                                        class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center">@lang('No records found')</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
