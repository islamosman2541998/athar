@extends('admin.app')

@section('title', trans('admin.show_main_page_gallery'))
@section('title_page', trans('admin.show_main_page_gallery'))


@section('content')

    <div class="container-fluid">

        {{--showProduct*--}}
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body  search-group">
                        <div class="row">
                            @if($items && $items->count())
{{--                                <div class="col-md-1 text-end mb-2">--}}
{{--                                    <a href=" {{ route('admin.main_page_gallery.show', $items[0]->gallery_group_id) }}"--}}
{{--                                       class="btn btn-outline-success btn-sm">@lang('admin.show')</a>--}}
{{--                                </div>--}}

                                <div class="col-md-1 text-end mb-2">
                                    <a href="{{ route('admin.main_page_gallery.edit',$items[0]->gallery_group_id) }}"
                                       class="btn btn-outline-success btn-sm">@lang('admin.edit')</a>
                                </div>
                            @else
                                <div class="col-md-12 text-end mb-2">
                                    <a href="{{ route('admin.main_page_gallery.create') }}"
                                       class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
                                </div>
                            @endif


                        </div>
                    </div>


                    <div class="card-body mt-0 pt-0">
                        {{--                     <form id="update-pages" action="{{route('admin.main_page_gallery.actions')}}" method="post">--}}
                        <form id="update-pages" action="" method="post">

                            @csrf
                        </form>
                        <div class="table-responsive">
                            <table id="main-datatable"
                                   class="table table-bordered  dt-responsive nowrap table-striped table-table-success table-hover"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>
                                <tr class="bluck-actions" style="display: none" scope="row">
                                    <td colspan="8">
                                        <div class="col-md-12 mt-0 mb-0 text-center">
                                            <button form="update-pages" class="btn btn-success btn-sm" type="submit"
                                                    name="publish" value="1"><i class="fa fa-check"></i></button>
                                            <button form="update-pages" class="btn btn-warning btn-sm" type="submit"
                                                    name="unpublish" value="1"><i class="fa fa-ban"></i></button>
                                            <button form="update-pages" class="btn btn-danger btn-sm" type="submit"
                                                    name="delete_all" value="1"><i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                                <tr>
                                    <th title="width: 1px" class="d-none">
                                        <input form="update-pages" class="checkbox-check flat" type="checkbox"
                                               name="check-all" id="check-all">
                                    </th>
                                    <th>#</th>
{{--                                    <th>@lang('main_page_gallery.code')</th>--}}
                                    <th>@lang('admin.image')</th>

{{--                                    <th>@lang('admin.title')</th>--}}
{{--                                    <th> @lang('main_page_gallery.occasions') </th>--}}
{{--                                    <th>@lang('main_page_gallery.price')</th>--}}
                                    <th>{{__('admin.sort')}}</th>
                                     <th>@lang('articles.actions')</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($items as $key => $item)

                                    <tr>
                                        <td class="d-none">
                                            <input form="update-pages" class="checkbox-check" type="checkbox"
                                                   name="record[{{$item->gallery_group_id}}]"
                                                   value={{ $item->gallery_group_id }}>
                                        </td>
                                        <td>{{ $key + 1  }}</td>
                                         <td>
                                            <img onclick="window.open(this.getAttribute('src') , '_blank')" width="50"
                                                 height="50" src="{{ $item->pathInView('main_page')}}"/>
                                        </td>
                                        <td>
                                             {{ $item->sort }}
                                        </td>

{{--                                        <td>--}}
{{--                                            --}}{{--                                        {{ isset($item->transNow )?  $item->transNow->title : ''}}                                        @forelse($item->occasions as $occasion)--}}


{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            --}}{{--                                        @forelse($item->occasions as $occasion)--}}
{{--                                            --}}{{--                                        <span class="badge bg-success"> {{ $occasion->transNow->title }} </span>--}}
{{--                                            --}}{{--                                        <br>--}}
{{--                                            --}}{{--                                        @empty--}}

{{--                                            --}}{{--                                        @endforelse--}}

{{--                                        </td>--}}
{{--                                        <td>--}}
{{--                                            {{ $item->price }}--}}

{{--                                        </td>--}}
                                         <td>
{{--                                            <div class="d-flex justify-content-center">--}}
{{--                                                @if($item->status == 1)--}}
{{--                                                                                                <a href="{{ route('admin.main_page_gallery.update-status', $item->gallery_group_id )}}" title="@lang('admin.active')" class="btn btn-xs btn-success btn-sm m-1"><i class="fa fa-check"></i></a>--}}
{{--                                                    <a href="" title="@lang('admin.active')"--}}
{{--                                                       class="btn btn-xs btn-success btn-sm m-1"><i--}}
{{--                                                            class="fa fa-check"></i></a>--}}

{{--                                                @else--}}
{{--                                                                                                <a href="{{ route('admin.main_page_gallery.update-status', $item->gallery_group_id )}}" title="@lang('admin.dis_active')" class="btn btn-xs btn-outline-secondary btn-sm m-1"><i class="fa fa-ban"></i></a>--}}
{{--                                                    <a href="" title="@lang('admin.dis_active')"--}}
{{--                                                       class="btn btn-xs btn-outline-secondary btn-sm m-1"><i--}}
{{--                                                            class="fa fa-ban"></i></a>--}}

{{--                                                @endif--}}

{{--                                                @if($item->feature == 1)--}}
{{--                                                                                                <a href="{{ route('admin.main_page_gallery.update-featured', $item->gallery_group_id )}}" title="@lang('admin.feature')" class="btn btn-xs btn-warning btn-sm m-1"><i class="fa fa-star"></i></a>--}}
{{--                                                    <a href="" title="@lang('admin.feature')"--}}
{{--                                                       class="btn btn-xs btn-warning btn-sm m-1"><i--}}
{{--                                                            class="fa fa-star"></i></a>--}}

{{--                                                @else--}}
{{--                                                                                                <a href="{{ route('admin.main_page_gallery.update-featured', $item->gallery_group_id )}}" title="@lang('admin.feature')" class="btn btn-xs btn-outline-secondary btn-sm m-1"><i class="fa fa-star"></i></a>--}}
{{--                                                    <a href="" title="@lang('admin.feature')"--}}
{{--                                                       class="btn btn-xs btn-outline-secondary btn-sm m-1"><i--}}
{{--                                                            class="fa fa-star"></i></a>--}}

{{--                                                @endif--}}
{{--                                                                                            <a href="{{ route('admin.main_page_gallery.show', $item->gallery_group_id) }}" title="@lang('admin.show')" class="btn btn-xs btn-outline-info btn-sm m-1"><i class="fas fa-eye"></i></a>--}}


{{--                                                                                            <a href="{{ route('admin.main_page_gallery.edit',$item->gallery_group_id) }}" title="@lang('admin.edit')" class="btn btn-outline-primary btn-sm m-1"><i class="fas fa-pencil-alt"></i></a>--}}

                                                                                            <a class="btn btn-outline-danger btn-sm m-1" title="@lang('admin.delete')" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">
                                                                                                <i class="fas fa-trash-alt"> </i>
                                                                                            </a>

                                            </div>
                                        </td>


                                    </tr>
                                    @include('admin.dashboard.main_page.gallery.delete')

                                @endforeach

                                </tbody>


                            </table>
                        </div>


                        <div class="col-md-12 text-center">
                            {{--                        {{ $items->links('pagination::bootstrap-5') }}--}}
                        </div>

                        </form>
                    </div>

                </div>

            </div>

        </div> <!-- container-fluid -->

@endsection


@section('script')
    {{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
@endsection
