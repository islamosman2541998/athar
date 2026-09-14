@extends('admin.app')

@section('title', trans('contact_us.contact_show'))
@section('title_page', trans('contact_us.contact_show'))

@section('style')
    {{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
    @livewireStyles
@endsection

@section('content')
    <div class="container-fluid">
        @livewire('admin.contact-us.index')
    </div>
@endsection

@section('script')    
    @livewireScripts
@endsection



