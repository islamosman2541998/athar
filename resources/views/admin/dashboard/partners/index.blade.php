@extends('admin.app')
@section('title', __('partners.page'))
@section('title_page', __('partners.page'))
@section('content')
    <div class="container-fluid">
        <div class="mb-3">
            <a href="{{ route('admin.partners.create') }}" class="btn btn-success">@lang('partners.create_new')</a>
        </div>
        {{-- Start Form search --}}
        <form action="{{ route('admin.partners.index') }}" method="get">
            @csrf
            <div class="row mb-3">
                <div class="col-md-3 mb-2">
                    <input type="test" value="{{ old('title', request()->input('title')) }}" name="title"
                        placeholder="{{ trans('admin.title') }}" class="form-control">
                </div>

                <div class="col-md-3 mb-2">
                    <select class="form-select" name="status" aria-label=".form-select-sm example">
                        <option selected value=""> @lang('admin.status') </option>
                        <option value="1"{{ old('status', request()->input('status')) == 1 ? 'selected' : '' }}>
                            @lang('admin.active') </option>
                        <option value="0"
                            {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null ? 'selected' : '' }}>
                            @lang('admin.dis_active') </option>
                    </select>
                </div>

                <div class="search-input col-md-2">
                    <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-search"> </i></button>
                    <a class="btn btn-success btn-sm" href="{{ route('admin.partners.index') }}"><i
                            class="refresh ion ion-md-refresh"></i></a>
                </div>
            </div>
        </form>
        {{-- End Form search --}}
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('partners.image')</th>
                            {{-- <th>@lang('partners.title')</th> --}}
                            <th>@lang('partners.status')</th>
                            <th class="text-end">@lang('admin.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($partners as $p)
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>
                                    <img src="{{ asset('storage/attachments/partners/' . $p->image) }} " style="height:60px"
                                        alt="" />
                                </td>
                                {{-- <td>{{ $p->translate(app()->getLocale())->title ?? $p->translate(config('app.fallback_locale'))->title }}
                                </td> --}}
                                <td>
                                    @if ($p->status)
                                        <span class="badge bg-success">@lang('admin.active')</span>
                                    @else
                                        <span class="badge bg-warning">@lang('admin.dis_active')</span>
                                    @endif
                                </td>
                         

                                <td class="text-end">

                                    <a href="{{ route('admin.partners.show', $p->id) }}" title="@lang('admin.show')"
                                        class="btn btn-xs btn-outline-info btn-sm m-1"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.partners.edit', $p->id) }}" title="@lang('admin.edit')"
                                        class="btn btn-outline-primary btn-sm m-1"><i class="fas fa-pencil-alt"></i></a>

                                    @if ($p->status == 1)
                                        <a href="{{ route('admin.partners.toggle-status', $p->id) }}"
                                            title="@lang('admin.active')" class="btn btn-xs btn-success btn-sm m-1"><i
                                                class="fa fa-check"></i></a>
                                    @else
                                        <a href="{{ route('admin.partners.toggle-status', $p->id) }}"
                                            title="@lang('admin.dis_active')"
                                            class="btn btn-xs btn-outline-secondary btn-sm m-1"><i
                                                class="fa fa-ban"></i></a>
                                    @endif

                                    <form action="{{ route('admin.partners.destroy', $p->id) }}" method="POST"
                                        class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $partners->links() }}
            </div>
        </div>
    </div>
@endsection
