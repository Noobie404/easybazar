@extends('admin.layout.master')
@section('product attr master','active')

@section('title') Product attribute | Edit @endsection
@section('page-name') Edit Product attribute @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a> </li>
<li class="breadcrumb-item"><a href="{{ route('admin.product-attr.index') }}"> Product attribute </a></li>
<li class="breadcrumb-item active">Edit Product attribute </li>
@endsection

@push('custom_css')
@endpush
@php
   $productAttrType = Config::get('static_array.product_attr_type');
@endphp

@section('content')
<div class="card card-success min-height">
    <div class="card-header">
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
            <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                <li><a data-action="close"><i class="ft-x"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            {!! Form::open([ 'route' => ['admin.product-attr.update',$data->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
            @csrf
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                            <label>@lang('form.name')<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::text('name', $data->NAME ?? null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter product attribute name', 'data-validation-required-message' => 'This field is required', 'tabindex' => 2 ]) !!}
                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('title') ? 'error' : '' !!}">
                            <label>Title</label>
                            <div class="controls">
                                {!! Form::text('title', $data->TITLE ?? null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter product attribute title', 'tabindex' => 3 ]) !!}
                                {!! $errors->first('title', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('type') ? 'error' : '' !!}">
                            <label>Type<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('type',$productAttrType,$data->ATTRIBUTE_TYPE ?? null, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => 4 ]) !!}
                                {!! $errors->first('type', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('is_required') ? 'error' : '' !!}">
                            <label>Is Required<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('is_required',array(1=>'Yes',0=>'No'), $data->IS_REQUIRED ?? null, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => 5 ]) !!}
                                {!! $errors->first('is_required', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                            <label>Is Active<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('is_active',array(1=>'Yes',0=>'No'), $data->IS_ACTIVE ?? null, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => 5 ]) !!}
                                {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions text-center mt-3">
                    <a href="{{route('admin.product-attr.index')}}">
                        <button type="button" class="btn btn-warning mr-1">
                            <i class="ft-x"></i>@lang('form.btn_cancle')
                        </button>
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="la la-check-square-o"></i>@lang('form.btn_update')
                    </button>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom_js')

@endpush
