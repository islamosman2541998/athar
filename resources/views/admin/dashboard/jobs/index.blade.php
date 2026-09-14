@extends('admin.app')

@section('title', __('admin.jobs'))
@section('title_page', __('admin.jobs'))

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 text-end">
                <a href="{{ route('admin.jobs.create') }}" class="btn btn-success btn-sm">@lang('button.create')</a>
            </div>
        </div>

        <div class="card">
            {{-- <div class="card-body  search-group">
                <form action="{{ route('admin.jobs.index') }}" method="get">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <input type="text" value="{{ request('title') }}" name="title"
                                placeholder="{{ trans('pages.search_title') }}" class="form-control">
                        </div>


                        <div class="search-input col-md-2">
                            <button class="btn btn-primary btn-sm" type="submit" title="{{ trans('button.search') }}"><i
                                    class="fas fa-search"> </i></button>
                            <a class="btn btn-warning btn-sm" href="{{ route('admin.jobs.index') }}"
                                title="{{ trans('button.reset') }}"><i class="refresh ion ion-md-refresh"></i></a>
                        </div>
                    </div>
                </form>
            </div> --}}
            <div class="card-body">
                @if ($jobs->count())
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('job.title')</th>
                                    <th>@lang('admin.career_category')</th>

                                    <th>@lang('admin.status')</th>
                                    <th>@lang('admin.sort')</th>
                                    <th class="text-end">@lang('admin.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jobs as $job)
                                    <tr>
                                        <td>{{ $job->id }}</td>
                                        <td>{{ optional($job->translate(app()->getLocale()))->title ?? '—' }}</td>
                                        <td>
                                            @if ($job->career_category)
                                                <span class="badge bg-success">
                                                    {{ optional($job->career_category->translate(app()->getLocale()))->title ?? (optional($job->career_category->translate(config('app.fallback_locale')))->title ?? '—') }}
                                                </span>
                                            @else
                                                —
                                            @endif
                                        </td>

                                        <td>
                                            @if ($job->status)
                                                <span class="badge bg-success">@lang('admin.active')</span>
                                            @else
                                                <span class="badge bg-warning">@lang('admin.dis_active')</span>
                                            @endif
                                        </td>
                                        <td>{{ $job->sort }}</td>
                                        <td class="text-end">

                                            <a href="{{ route('admin.jobs.show', $job->id) }}" title="@lang('admin.show')"
                                                class="btn btn-xs btn-outline-info btn-sm m-1"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.jobs.edit', $job->id) }}" title="@lang('admin.edit')"
                                                class="btn btn-outline-primary btn-sm m-1"><i
                                                    class="fas fa-pencil-alt"></i></a>

                                            @if ($job->status == 1)
                                                <a href="{{ route('admin.jobs.toggle-status', $job->id) }}"
                                                    title="@lang('admin.active')" class="btn btn-xs btn-success btn-sm m-1"><i
                                                        class="fa fa-check"></i></a>
                                            @else
                                                <a href="{{ route('admin.jobs.toggle-status', $job->id) }}"
                                                    title="@lang('admin.dis_active')"
                                                    class="btn btn-xs btn-outline-secondary btn-sm m-1"><i
                                                        class="fa fa-ban"></i></a>
                                            @endif
                                            @if ($job->feature == 1)
                                                <a href="{{ route('admin.jobs.toggle-feature', $job->id) }}"
                                                    title="@lang('admin.feature')" class="btn btn-xs btn-warning btn-sm m-1"><i
                                                        class="fa fa-star"></i></a>
                                            @else
                                                <a href="{{ route('admin.jobs.toggle-feature', $job->id) }}"
                                                    title="@lang('admin.feature')"
                                                    class="btn btn-xs btn-outline-secondary btn-sm m-1"><i
                                                        class="fa fa-star"></i></a>
                                            @endif

                                            <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST"
                                                class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $jobs->links() }}
                    </div>
                @else
                    <div class="alert alert-info">@lang('admin.no_data')</div>
                @endif
            </div>
        </div>
    </div>
@endsection
