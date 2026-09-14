@extends('admin.app')

@section('title', __('admin.servicerequest'))
@section('title_page', __('admin.serviceRequest'))

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 text-end">

            </div>
        </div>

        <div class="card">
            <div class="card-body  search-group">
                <form action="{{ route('admin.service_request.index') }}" method="get">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <input type="text" value="{{ request('name') }}" name="name"
                                placeholder="{{ trans('pages.search_title') }}" class="form-control">
                        </div>

                        <div class="col-md-3 mb-2">
                            <input type="text" value="{{ request('email') }}" name="email" placeholder="Email"
                                class="form-control">
                        </div>

                        <div class="col-md-3 mb-2">
                            <input type="text" value="{{ request('phone') }}" name="phone" placeholder="Phone"
                                class="form-control">
                        </div>
                        <div class="col-md-3 mb-2">
                            <input type="text" value="{{ request('company') }}" name="company" placeholder="company"
                                class="form-control">
                        </div>

                        <div class="search-input col-md-2">
                            <button class="btn btn-primary btn-sm" type="submit" title="{{ trans('button.search') }}"><i
                                    class="fas fa-search"> </i></button>
                            <a class="btn btn-warning btn-sm" href="{{ route('admin.service_request.index') }}"
                                title="{{ trans('button.reset') }}"><i class="refresh ion ion-md-refresh"></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
                @if ($service_requests->count())
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('admin.name')</th>
                                    <th>@lang('admin.service')</th>
                                    <th>@lang('admin.email')</th>
                                    <th>@lang('admin.phone')</th>
                                    <th>@lang('admin.company')</th>
                                    <th>@lang('admin.timeline')</th>
                                    <th class="">@lang('admin.attachment')</th>
                                    <th class="text-center">@lang('admin.actions')</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($service_requests as $service_request)
                                    <tr>
                                        <td>{{ $service_request->id }}</td>
                                        <td>{{ $service_request->name }}</td>

                                        <td>
                                            {{ $service_request->service_category->transNow->title ?? '—' }}
                                        </td>

                                        <td>{{ $service_request->email }}</td>
                                        <td>{{ $service_request->phone ?? '—' }}</td>
                                        <td>{{ $service_request->company ?? '—' }}</td>
                                        <td>{{ $service_request->timeline ?? '—' }}</td>

                                        <td class="">
                                                @if ($service_request->attachment)
                                            <a href="{{ asset('storage/service_requests/' . $service_request->attachment) }}"
                                                class="btn btn-info btn-sm" target="_blank"><i
                                                    class="fas fa-download"></i></a>
                                                @endif
                                        </td>
                                        <td class="text-center">
                                            <form
                                                action="{{ route('admin.service_request.destroy', $service_request->id) }}"
                                                method="POST" style="display:inline"
                                                onsubmit="return confirm('هل تريد الحذف  ');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ trans('admin.delete') }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">@lang('admin.no_data')</div>
                @endif
            </div>
        </div>
    </div>
@endsection
