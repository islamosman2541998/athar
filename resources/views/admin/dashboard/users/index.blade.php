@extends('admin.app')

@section('title', trans('users.show_user'))
@section('title_page', trans('users.show_user'))

@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
@endsection

@section('content')

    <div class="container-fluid">


        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body  search-group">

                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a href="{{ route('admin.users.create') }}"
                                    class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
                            </div>
                        </div>
                        {{-- Start Form Search User Search By name,email,role,status --}}
                        <form action="{{ route('admin.users.index') }}" method="get">

                            <div class="row mt-3">
                                <div class="col-md-2 mt-1">
                                    <input type="text" value="{{ request()->name != '' ? request()->name : '' }}"
                                        name="name" placeholder="{{ trans('pages.search_name') }}" class="form-control">
                                </div>
                                <div class="col-md-2 mt-1">
                                    <input type="text" value="{{ request()->email != '' ? request()->email : '' }}"
                                        name="email" placeholder="{{ trans('pages.search_email') }}" class="form-control">
                                </div>
                                <div class="col-md-2 mt-1">
                                    <input type="text" value="{{ request()->mobile != '' ? request()->mobile : '' }}"
                                        name="mobile" placeholder="{{ trans('pages.search_mobile') }}"
                                        class="form-control">
                                </div>
                                <div class="col-md-2 mt-1">
                                    <select class="select form-control select2 "  name="role">
                                        <option selected value="">{{ trans('pages.search_role') }}</option>
                                        @foreach ($roles as $role)
                                            <option {{ $role->id ==   request()->role  ? 'selected' : '' }}
                                                value="{{ $role->id }}"> {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 mt-1">
                                    <select class="select form-control" name="status">
                                        <option selected value=""> @lang('admin.status') </option>
                                        <option
                                            value="1"{{ old('status', request()->input('status')) == 1 ? 'selected' : '' }}>
                                            @lang('admin.active') </option>
                                        <option value="0"
                                            {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null ? 'selected' : '' }}>
                                            @lang('admin.dis_active') </option>

                                    </select>
                                </div>
                                <div class="col-md-2 mt-1">
                                    <button class="btn btn-primary btn-sm" type="submit" title="{{ trans('pages.search') }}"><i
                                        class="fas fa-search"> </i></button>
                                    <a class="btn btn-warning btn-sm" href="{{ route('admin.users.index') }}" title="{{ trans('button.reset') }}"><i
                                            class="refresh ion ion-md-refresh"></i></a>
                                  
                                </div>
                            </div>
                        </form>
                        {{-- End Form Search User Search By name,email,role,status --}}

                    </div>



                    <div class="card-body table-responsive">
                        <form id="update-pages" action="{{ route('admin.users.actions') }}" method="post">
                            @csrf
                        </form>
                        <table  id="main-datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                <tr class="bluck-actions" style="display: none" scope="row">
                                    <td colspan="8">
                                        <div class="col-md-12 mt-0 mb-0 text-center">
                                            <button form="update-pages" class="btn btn-success btn-sm" type="submit"
                                                name="publish" value="1"> <i class="fa fa-check"></i></button>
                                            <button form="update-pages" class="btn btn-warning btn-sm" type="submit"
                                                name="unpublish" value="1"> <i class="fa fa-ban"></i></button>
                                            <button form="update-pages" class="btn btn-danger btn-sm" type="submit"
                                                name="delete_all" value="1"> <i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>

                                </tr>
                                <th style="width: 1px">
                                    <input form="update-pages" class="checkbox-check flat" type="checkbox" name="check-all"
                                        id="check-all">
                                </th>


                                <th>#</th>
                                <th>@lang('users.name')</th>
                                <th>@lang('users.email')</th>
                                <th>@lang('users.mobile')</th>
                                <th>@lang('users.image')</th>
                                <th>@lang('users.role')</th>
                                <th>@lang('users.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>
                                            @if ($key != 0)
                                                <input form="update-pages" class="checkbox-check" type="checkbox"
                                                    name="record[{{ $user->id }}]" value={{ $user->id }}>
                                            @endif
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->mobile }}</td>
                                        <td> <a href="{{ asset($user->image) }}" target="_blank"> <img
                                                    src="{{ asset($user->image) }}" alt="" style="width: 50px"></a>
                                        </td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                                <span class="badge bg-success">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                    class="btn btn-outline-warning btn-sm m-1"
                                                    title="{{ trans('button.edit') }}"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                @if ($key != 0)
                                                    @if ($user->status == 1)
                                                        <a href="{{ route('admin.users.update-status', $user->id) }}"
                                                            class="btn btn-xs btn-outline-success btn-sm m-1"><i
                                                                class="fa fa-check"></i></a>
                                                    @else
                                                        <a href="{{ route('admin.users.update-status', $user->id) }}"
                                                            class="btn btn-xs btn-outline-warning btn-sm m-1"><i
                                                                class="fa fa-ban"></i></a>
                                                    @endif
                                                    <a type="button" class="btn btn-outline-danger btn-sm m-1"
                                                        class="color-red" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $user->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            </div>
                                    </tr>
                                    </tr>




                                    @include('admin.dashboard.users.delete')
                                @endforeach



                            </tbody>


                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div> <!-- container-fluid -->

@endsection


@section('script')


@endsection
