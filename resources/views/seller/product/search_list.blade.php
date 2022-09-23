@extends('admin.layout.master')

@section('product_search_list','active')
@section('Product Management','open')

@section('title') @lang('product.list_page_title') @endsection
@section('page-name') @lang('product.list_page_sub_title') @endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('product.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">Product List</li>
@endsection

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lightgallery/dist/css/lightgallery.min.css') }}">

@endpush

@php
    $roles = userRolePermissionArray()
@endphp

@section('content')
<div class="card">
    <div class="card-content card-success">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @include('admin.components._product_search_inner')
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.components._update_variant_master')
@endsection

@push('custom_js')
<script src="{{ asset('assets/lightgallery/dist/js/lightgallery.min.js')}}"></script>
<script>
$(".lightgallery").lightGallery();
</script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
@endpush

