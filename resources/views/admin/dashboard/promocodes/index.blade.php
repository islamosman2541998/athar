@extends('admin.app')

@section('title', trans('admin.show_promocodes'))
@section('title_page', trans('admin.show_promocodes'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-end">
                    <a href="{{ route('admin.promocodes.create') }}"
                       class="btn btn-outline-success btn-sm">
                        @lang('admin.create')
                    </a>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('promocodes.code')</th>
                                <th>@lang('promocodes.title')</th>
                                <th>@lang('promocodes.type')</th>
                                <th>@lang('promocodes.value')</th>
                                <th>@lang('promocodes.start_at')</th>
                                <th>@lang('promocodes.end_at')</th>
                                <th>@lang('promocodes.uses_left')</th> 
                                <th>@lang('admin.status')</th>
                                <th>@lang('admin.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ optional($item->transNow)->title ?? '-' }}</td>
                                    <td>
                                        @if($item->type == 'percent')
                                            <span class="badge bg-info">%</span>
                                        @else
                                            <span class="badge bg-primary">@lang('Fixed')</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->type == 'percent')
                                            {{ $item->value }}%
                                        @else
                                            {{ number_format($item->value, 2) }}
                                        @endif
                                    </td>
                                    <td>{{ $item->start_at }}</td>
                                    <td>{{ $item->end_at }}</td>
                                    <td>
                                        @if($item->uses_left > 0)
                                            {{ $item->uses_left }}
                                        @else
                                            <span class="text-danger">@lang('promocodes.expired')</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->status)
                                            <span class="badge bg-success">@lang('admin.active')</span>
                                        @else
                                            <span class="badge bg-secondary">@lang('admin.disabled')</span>
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('admin.promocodes.toggle-status', $item->id ) }}"
                                           class="btn btn-sm {{ $item->status ? 'btn-success' : 'btn-secondary' }} m-1"
                                           title="@lang('admin.toggle_status')">
                                            <i class="fa {{ $item->status ? 'fa-check' : 'fa-ban' }}"></i>
                                        </a>

                                        <a href="{{ route('admin.promocodes.edit', $item->id) }}"
                                           class="btn btn-outline-primary btn-sm m-1" title="@lang('admin.edit')">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        <form action="{{ route('admin.promocodes.destroy', $item->id) }}"
                                              method="POST" class="m-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('@lang("admin.are_you_sure")');">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
