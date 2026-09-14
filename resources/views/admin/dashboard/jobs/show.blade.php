@extends('admin.app')

@section('title', __('job.show'))
@section('title_page', __('job.show'))

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h3>{{ optional($job->translate(app()->getLocale()))->title }}</h3>
            <p class="text-muted">{{ optional($job->translate(app()->getLocale()))->short_description }}</p>

            @if($job->image)
                <img src="{{ asset('storage/' . $job->image) }}" style="max-width:300px" class="mb-3" alt="">
            @endif

            <h5>{{ __('job.description') }}</h5>
            <div>{!! optional($job->translate(app()->getLocale()))->description !!}</div>

            <h5>{{ __('job.job_desc') }}</h5>
            <div>{!! optional($job->translate(app()->getLocale()))->job_desc !!}</div>

            <h5 class="mt-3">{{ __('job.requirements') }}</h5>
            <div>{!! optional($job->translate(app()->getLocale()))->requirements !!}</div>

            <div class="mt-3">
                <a href="{{ route('admin.jobs.edit', $job->id) }}" class="btn btn-primary btn-sm">@lang('button.edit')</a>
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-success btn-sm">@lang('admin.back')</a>
            </div>
        </div>
    </div>
</div>
@endsection
