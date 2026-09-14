@extends('admin.app')

@section('content')
<div class="container py-4">
    <h2>{{ __('admin.attach_products_to_filter', ['name' => $filter->name]) }}</h2>

    <form method="POST" action="{{ route('admin.filters.products.update', $filter) }}">
        @csrf

        <div class="mb-3">
            <button type="submit" class="btn btn-success">
                {{ __('admin.save_links') }}
            </button>
            <a href="{{ route('admin.filters.index') }}" class="btn btn-secondary">
                {{ __('admin.back') }}
            </a>
        </div>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>{{ __('admin.product_id') }}</th>
                    <th>{{ __('admin.title') }}</th>
                    <th>{{ __('admin.image') }}</th>
                    <th>{{ __('admin.select') }}</th>                  
                </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->transNow?->title ?? $product->name }}</td>
                    <td>
                        @if($product->image)
                        <img src="{{ $product->pathInView() }}" class="img-fluid" style="width: 50px; height: 50px;" alt="">
                        @else
                            {{ __('admin.no_image') }}
                        @endif
                    </td>

                    <td class="text-center">
                        <input
                            type="checkbox"
                            name="products[]"
                            value="{{ $product->id }}"
                            {{ in_array($product->id, $attached) ? 'checked' : '' }}>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">
                {{ __('admin.save_links') }}
            </button>
            <a href="{{ route('admin.filters.index') }}" class="btn btn-secondary">
                {{ __('admin.cancel') }}
            </a>
        </div>
    </form>
</div>
@endsection
