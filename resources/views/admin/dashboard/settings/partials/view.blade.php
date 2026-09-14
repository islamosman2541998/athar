@extends('admin.app')

@section('title', trans('settings.settings'))
@section('title_page', trans('settings.edit', ['name' => @$settingMain->key]))

@section('content')
    <div class="container-fluid">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('admin.settings.update-custom', $settingMain->key) }}" method="POST" enctype="multipart/form-data" role="form">
                                @csrf

                                <h3> Settings View Products </h3>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th> Product Name  </th>
                                            <th> Image </th>
                                            <th>  (Most Selling)</th>
                                            <th>  (Best Offer)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                            <tr>
                                                <td>{{ $product->transNow->title ?? '' }}</td>

                                                <td>
                                                    <img src="{{ $product->pathInView() }}" class="img-fluid" style="width: 50px; height: 50px;" alt="">

                                                </td>


                                                <td>

                                                    <input type="checkbox" name="most_selling[{{ $product->id }}]" {{ $product->most_selling ? 'checked' : '' }}>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="best_offer[{{ $product->id }}]" {{ $product->best_offer ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                              

                                <div class="card-footer text-end">
                                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-danger waves-effect waves-light ml-3">@lang('button.cancel')</a>
                                    <button type="submit" class="btn btn-success">@lang('button.save')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


@endsection