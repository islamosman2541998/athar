@extends('admin.app')

@section('title', trans('booking.show_booking'))
@section('title_page', trans('booking.show_booking'))

@section('style')
    @livewireStyles
@endsection

@section('content')
    <div class="container-fluid">
        @livewire('admin.booking.index')
    </div>
@endsection

@section('script')    
    @livewireScripts
@endsection



