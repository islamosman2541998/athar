@extends('admin.app')

@section('title', trans('categories.categories'))
@section('title_page', trans('categories.categories'))

@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
    @livewireStyles
@endsection

@section('content')
    <div class="container-fluid">
        @livewire('admin.categories.index')
    </div>
@endsection

@section('script')    
    @livewireScripts
@endsection



