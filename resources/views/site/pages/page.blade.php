@extends('site.layouts.app')
@php($trans=$page->transNow)
@section('title', $trans->meta_title ?? $trans->title ?? __('athar.brand'))
@section('meta_description', strip_tags($trans->meta_description ?? ''))
@section('content')
@include('site.includes.page-hero',['title'=>$trans->title ?? __('athar.brand'),'kicker'=>__('athar.tagline')])
<section class="section"><div class="container article-main"><div class="rich-text">{!! $trans->content ?? '' !!}</div></div></section>
@endsection
