@extends('site.layouts.app')

@section('title', __('athar.tagline'))

@section('content')
    @include('site.pages.home.sections.hero')
    @include('site.pages.home.sections.services')
    @include('site.pages.home.sections.portfolio')
    @include('site.pages.home.sections.why-us')
    @include('site.pages.home.sections.process')
    @include('site.pages.home.sections.statistics')
    @include('site.pages.home.sections.blogs')
    @include('site.pages.home.sections.partners')
@endsection
