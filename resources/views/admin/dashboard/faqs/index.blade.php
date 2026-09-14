@extends('admin.app')

@section('title', __('faq.page'))
@section('title_page', __('faq.page'))

@section('content')
    <div class="container-fluid">
        <div class="row mb-3 text-end">
            <div class="col-12">
                <a href="{{ route('admin.faqs.create') }}" class="btn btn-success btn-sm">@lang('button.create') </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('faq.question')</th>
                            <th>@lang('faq.category')</th>

                            <th>@lang('admin.status')</th>
                            <th>@lang('admin.sort')</th>
                            <th class="text-end">@lang('admin.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqs as $f)
                            <tr>
                                <td>{{ $f->id }}</td>
                                <td>{{ optional($f->translate(app()->getLocale()))->question ?? optional($f->translate(config('app.fallback_locale')))->question }}
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ optional(optional($f->category)->translate(app()->getLocale()))->title ??
                                            (optional(optional($f->category)->translate(config('app.fallback_locale')))->title ?? '-') }}
                                    </span>
                                </td>

                                <td>
                                    @if ($f->status)
                                        <span class="badge bg-success">@lang('admin.active')</span>
                                    @else
                                        <span class="badge bg-warning">@lang('admin.dis_active')</span>
                                    @endif
                                </td>
                                <td>{{ $f->sort }}</td>

                                <td class="text-end">

                                    <a href="{{ route('admin.faqs.show', $f->id) }}" title="@lang('admin.show')"
                                        class="btn btn-xs btn-outline-info btn-sm m-1"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.faqs.edit', $f->id) }}" title="@lang('admin.edit')"
                                        class="btn btn-outline-primary btn-sm m-1"><i class="fas fa-pencil-alt"></i></a>

                                    @if ($f->status == 1)
                                        <a href="{{ route('admin.faqs.toggle-status', $f->id) }}" title="@lang('admin.active')"
                                            class="btn btn-xs btn-success btn-sm m-1"><i class="fa fa-check"></i></a>
                                    @else
                                        <a href="{{ route('admin.faqs.toggle-status', $f->id) }}" title="@lang('admin.dis_active')"
                                            class="btn btn-xs btn-outline-secondary btn-sm m-1"><i
                                                class="fa fa-ban"></i></a>
                                    @endif

                                    <form action="{{ route('admin.faqs.destroy', $f->id) }}" method="POST"
                                        class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">@lang('faq.no_records')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">{{ $faqs->links() }}</div>
            </div>
        </div>
    </div>
@endsection
