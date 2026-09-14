@extends('admin.app')

@section('title', __('admin.blogs'))
@section('title_page', __('admin.blogs'))

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 text-end">
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-success btn-sm">@lang('button.create')</a>
            </div>
        </div>

        <div class="card">

            {{-- <div class="card-body  search-group">
                <form action="{{ route('admin.blogs.index') }}" method="get">
                    <div class="row mb-3">
                        <div class="col-md-2 mb-2">
                            <input type="text" value="{{ old('title', request()->input('title')) }}" name="title"
                                placeholder="{{ trans('products.title') }}" class="form-control">
                        </div>

                        <div class="search-input col-md-2">
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="fas fa-search"> </i>
                            </button>
                            <a class="btn btn-success btn-sm" href="{{ route('admin.blogs.index') }}"><i
                                    class="refresh ion ion-md-refresh"></i></a>
                        </div>
                    </div>
            </form>
        </div> --}}
            <div class="card-body">
                @if ($blogs->count())
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.id') }}</th>
                                    <th>{{ __('admin.title_en') }}</th>
                                    <th>{{ __('admin.title_ar') }}</th>
                                    <th>{{ __('admin.image') }}</th>
                                    <th class="text-end">{{ __('admin.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $blog)
                                    <tr>
                                        <td>{{ $blog->id }}</td>
                                        <td>{{ @$blog->translate('en')->title }}</td>
                                        <td>{{ @$blog->translate('ar')->title }}</td>
                                        <td>
                                            @if ($blog->image)
                                                <img src="{{ asset($blog->pathInView()) }}" width="80" alt="">
                                            @endif
                                        </td>


                                        <td class="text-end">

                                            @if ($blog->status == 1)
                                                <a href="{{ route('admin.blogs.update-status', $blog->id) }}"
                                                    title="@lang('admin.active')" class="btn btn-xs btn-success btn-sm m-1"><i
                                                        class="fa fa-check"></i></a>
                                            @else
                                                <a href="{{ route('admin.blogs.update-status', $blog->id) }}"
                                                    title="@lang('admin.dis_active')"
                                                    class="btn btn-xs btn-outline-secondary btn-sm m-1"><i
                                                        class="fa fa-ban"></i></a>
                                            @endif

                                            @if ($blog->feature == 1)
                                                <a href="{{ route('admin.blogs.update-featured', $blog->id) }}"
                                                    title="@lang('admin.feature')" class="btn btn-xs btn-warning btn-sm m-1"><i
                                                        class="fa fa-star"></i></a>
                                            @else
                                                <a href="{{ route('admin.blogs.update-featured', $blog->id) }}"
                                                    title="@lang('admin.feature')"
                                                    class="btn btn-xs btn-outline-secondary btn-sm m-1"><i
                                                        class="fa fa-star"></i></a>
                                            @endif

                                            <a href="{{ route('admin.blogs.show', $blog->id) }}" title="@lang('admin.show')"
                                                class="btn btn-xs btn-outline-info btn-sm m-1"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" title="@lang('admin.edit')"
                                                class="btn btn-outline-primary btn-sm m-1"><i
                                                    class="fas fa-pencil-alt"></i></a>



                                            <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST"
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
                        {{ $blogs->links() }}
                    </div>
                @else
                    <div class="alert alert-info">@lang('admin.no_data')</div>
                @endif
            </div>
        </div>
    </div>
@endsection
