@extends('admin.app')

@section('title', trans('slider.sliders'))
@section('title_page', trans('slider.slider_show'))

@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
@endsection

@section('content')

<div class="container-fluid">


    <div class="row">
        <div class="col-12">
        <div class="col-12">
            <div class="card">

            <div class="card-body  search-group">
                <div class="row">
                    <div class="col-md-12 text-end mb-2">
                        <a href="{{ route('admin.slider.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
                    </div>
                </div>
                <form action="{{route('admin.slider.index')}}" method="get">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <input type="text" value="" name="title" placeholder="{{ trans('pages.search_title') }}" class="form-control">
                        </div>
                        {{-- <div class="col-md-3">
                            <input type="text" value="{{ request()->url != '' ? request()->url : ''}}" name="url" placeholder="{{ trans('pages.search_by_url') }}" class="form-control">
                        </div> --}}
                        <div class="search-input col-md-2">
                            <button class="btn btn-primary btn-sm" type="submit" title="{{ trans('button.search') }}"><i class="fas fa-search"> </i></button>
                            <a class="btn btn-warning btn-sm" href="{{route('admin.slider.index')}}" title="{{ trans('button.reset') }}"><i class="refresh ion ion-md-refresh"></i></a>
                        </div>
                    </div>
                </form>
            </div>




                <div class="card-body mt-0 pt-0">
                    <form id="update-pages" action="{{route('admin.slider.actions')}}" method="post">
                        @csrf
                    </form>
                        <table id="main-datatable" class="table table-bordered  dt-responsive nowrap table-striped table-table-success table-hover table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                            <thead>

                                <tr class="bluck-actions" style="display: none" scope="row">
                                    <td colspan="8">
                                        <div class="col-md-12 mt-0 mb-0 text-center" >
                                            <button form="update-pages" class="btn btn-success btn-sm" type="submit" name ="publish" value="1" title="{{ trans('button.active') }}"> <i class="fa fa-check"></i></button>
                                            <button form="update-pages" class="btn btn-warning btn-sm" type="submit" name ="unpublish" value="1" title="{{ trans('button.unactive') }}">  <i class="fa fa-ban"></i></button>
                                            <button form="update-pages" class="btn btn-danger btn-sm" type="submit" name ="delete_all" value="1" title="{{ trans('button.delete_all') }}">  <i class="fas fa-trash-alt"></i></button>
                                        </div>
                                    </td>

                                </tr>
                            <tr class="text-center table-active">
                                <th style="width: 1px">
                                    <input form="update-pages"  class="checkbox-check flat" type="checkbox" name="check-all"  id="check-all">
                                </th>
                                <th style="width: 2px">#</th>
                                <th>@lang('slider.image')</th>
                                <th>@lang('slider.title')</th>
                                <th>@lang('slider.url')</th>
                                <th>@lang('slider.created_at')</th>
                                <th>@lang('slider.updated_at')</th>

                                <th>@lang('slider.actions')</th>
                            </tr>
                            </thead>


                                <tbody class="text-center">
                                    @foreach ($sliders as $slider)
                                    <tr>
                                        <td>
                                            <input form="update-pages" class="checkbox-check" type="checkbox" name="record[{{$slider->id}}]" value={{ $slider->id }}>
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{asset($slider->pathInView())}}" target="_blank">  <img src="{{asset($slider->pathInView())}}" alt="" style="width: 50px"></a>
                                        </td>
                                        <td>
                                            {{-- @foreach($languages as $local)
                                            {!!  @$slider->trans->where('locale',$local)->first()->title   !!} <br>
                                        @endforeach  --}}
                                        {{ $slider->trans->where('locale',$current_lang)->first()->title}}
                                        </td>
                                        <td>{{ $slider->url == 'javascript:void(0)'?'': $slider->url  }}</td>
                                        <td>{{ $slider->created_at }}</td>
                                        <td>{{ $slider->updated_at  }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                @if($slider->status == 1)
                                                    <a href="{{ route('admin.slider.update-status', $slider->id )}}" class="btn btn-xs btn-success btn-sm m-1" title="{{ trans('button.active') }}"><i class="fa fa-check"></i></a>
                                                @else
                                                    <a href="{{ route('admin.slider.update-status', $slider->id )}}" class="btn btn-xs btn-outline-secondary btn-sm m-1" title="{{ trans('button.unactive') }}"><i class="fa fa-ban"></i></a>
                                                @endif
                                                <a href="{{ route('admin.slider.edit',$slider->id) }}" class="btn btn-outline-primary btn-sm m-1" title="{{ trans('button.edit') }}"><i class="fas fa-pencil-alt"></i></a>
                                                <a href="{{ route('admin.slider.show', $slider->id) }}" class="btn btn-xs btn-outline-info btn-sm m-1" title="{{ trans('button.show') }}"><i class="fas fa-eye"></i></a>
                                                <a class="btn btn-outline-danger btn-sm m-1" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $slider->id }}" title="{{ trans('button.delete') }}">
                                                    <i class="fas fa-trash-alt"> </i>
                                                </a>

                                            </div>
                                        </td>


                                    </tr>



                                     @include('admin.dashboard.Slider.delete')
                                    @endforeach

                                </tbody>




                        </table>

                    <div class="col-md-12 text-center">
                        {{-- {{ $slider->links('pagination::bootstrap-5') }} --}}
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
