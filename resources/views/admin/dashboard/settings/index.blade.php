@extends('admin.app')

@section('title', trans('admin.settings'))
@section('title_page', trans('settings.settings'))

@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
@endsection

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                

                <div class="card-body mt-0 pt-0">
                    <div class="table-responsive">
                        <table id="main-datatable" class="table table-bordered  dt-responsive nowrap table-striped table-table-success table-hover" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                            <thead>
                              
                                <tr>
                                    <th>#</th>
                                    <th>@lang('admin.title')</th>
                                    <th>@lang('admin.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($items as $key => $item)
                                <tr>
                                    <td>{{  $key + 1 }}</td>
                                    <td>
                                      {{ trans('settings.' . $item->key) }}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('admin.settings.form',$item->key) }}" title="@lang('admin.edit')" class="btn btn-outline-primary btn-sm m-1"><i class="fas fa-pencil-alt"></i></a>
                                        </div>
                                    </td>
                            
                                    
                                </tr>
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
        {{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
@endsection