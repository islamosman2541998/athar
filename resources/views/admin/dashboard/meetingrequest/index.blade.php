@extends('admin.app')

@section('title', 'Meeting Requests')
@section('title_page', 'Meeting Requests')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body search-group">
                <form action="{{ route('admin.meeting_request.index') }}" method="get">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <input type="text"
                                   value="{{ request('name') }}"
                                   name="name"
                                   placeholder="{{ trans('pages.search_title') }}"
                                   class="form-control">
                        </div>

                        <div class="col-md-3 mb-2">
                            <input type="text"
                                   value="{{ request('email') }}"
                                   name="email"
                                   placeholder="Email"
                                   class="form-control">
                        </div>

                        <div class="col-md-3 mb-2">
                            <input type="text"
                                   value="{{ request('phone') }}"
                                   name="phone"
                                   placeholder="Phone"
                                   class="form-control">
                        </div>

                        <div class="col-md-3 mb-2">
                            <input type="text"
                                   value="{{ request('company') }}"
                                   name="company"
                                   placeholder="Company"
                                   class="form-control">
                        </div>

                        <div class="col-md-3 mb-2">
                            <select name="meeting_type" class="form-control">
                                <option value="">Meeting Type</option>
                                <option value="Online" {{ request('meeting_type') == 'Online' ? 'selected' : '' }}>
                                    Online
                                </option>
                                <option value="Phone call" {{ request('meeting_type') == 'Phone call' ? 'selected' : '' }}>
                                    Phone call
                                </option>
                                <option value="Office meeting" {{ request('meeting_type') == 'Office meeting' ? 'selected' : '' }}>
                                    Office meeting
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-2">
                            <input type="date"
                                   value="{{ request('preferred_date') }}"
                                   name="preferred_date"
                                   class="form-control">
                        </div>

                        <div class="search-input col-md-2">
                            <button class="btn btn-primary btn-sm" type="submit" title="{{ trans('button.search') }}">
                                <i class="fas fa-search"></i>
                            </button>

                            <a class="btn btn-warning btn-sm"
                               href="{{ route('admin.meeting_request.index') }}"
                               title="{{ trans('button.reset') }}">
                                <i class="refresh ion ion-md-refresh"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($meeting_requests->count())
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('admin.name')</th>
                                    <th>@lang('admin.email')</th>
                                    <th>@lang('admin.phone')</th>
                                    <th>@lang('admin.company')</th>
                                    <th>Meeting Type</th>
                                    <th>Preferred Date</th>
                                    <th>Preferred Time</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th class="text-center">@lang('admin.actions')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($meeting_requests as $meeting_request)
                                    <tr>
                                        <td>{{ $meeting_request->id }}</td>
                                        <td>{{ $meeting_request->name }}</td>
                                        <td>{{ $meeting_request->email }}</td>
                                        <td>{{ $meeting_request->phone ?? '—' }}</td>
                                        <td>{{ $meeting_request->company ?? '—' }}</td>
                                        <td>{{ $meeting_request->meeting_type ?? '—' }}</td>
                                        <td>{{ $meeting_request->preferred_date ?? '—' }}</td>
                                        <td>{{ $meeting_request->preferred_time ?? '—' }}</td>

                                        <td>
                                            @if ($meeting_request->message)
                                                {{ Str::limit($meeting_request->message, 50) }}
                                            @else
                                                —
                                            @endif
                                        </td>

                                        <td>
                                            <span class="badge bg-info">
                                                {{ $meeting_request->status ?? 'new' }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <form action="{{ route('admin.meeting_request.destroy', $meeting_request->id) }}"
                                                  method="POST"
                                                  style="display:inline"
                                                  onsubmit="return confirm('هل تريد الحذف؟');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
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

                    <div class="mt-3">
                        {{ $meeting_requests->links() }}
                    </div>
                @else
                    <div class="alert alert-info">@lang('admin.no_data')</div>
                @endif
            </div>
        </div>
    </div>
@endsection