@extends('admin.app')

@section('title', __('admin.show_blog'))
@section('title_page', __('admin.show_blog'))

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h3>{{ optional($blog->translate(app()->getLocale()))->title }}</h3>

            @if($blog->image)
                <img src="{{ asset(@$blog->pathInView()) }}" style="max-width:300px" class="mb-3" alt="">
            @endif

            <h5>{{ __('blogs.description') }}</h5>
            <div>{!! optional($blog->translate(app()->getLocale()))->description !!}</div>

            

            <div class="mt-3">
                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-primary btn-sm">@lang('button.edit')</a>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-success btn-sm">@lang('admin.back')</a>
            </div>
        </div>
    </div>
</div>
@endsection
