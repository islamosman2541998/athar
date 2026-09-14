@extends('admin.app')
@section('title', __('partners.view'))
@section('title_page', __('partners.view'))
@section('content')
<div class="container-fluid">
    <div class="card p-4">
        <img src="{{ asset('storage/attachments/partners/' . $partner->image) }}" style="max-width:300px">
        <p>@lang(key: 'partners.url'): {{ $partner->url }}</p>
        <p>@lang(key: 'partners.status'): {{ $partner->status ? 'Active' : 'Inactive' }}</p>
    </div>
</div>
@endsection
