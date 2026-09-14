@extends('admin.app')

@section('title', trans('menus.show_menus'))
@section('title_page', trans('menus.show_menus'))

@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
    @livewireStyles
@endsection

@section('content')
    <div class="container-fluid">
        @livewire('admin.menus.index')
    </div>
@endsection

@section('script')    
    @livewireScripts
@endsection



