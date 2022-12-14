@extends('admin.layout.master')
@section('model','active')
@section('title')
@lang('user_group.product_edit_form_product_model_edit_head_title')
@endsection
@section('page-name')
@lang('form.product_edit_form_product_model_edit')
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> @lang('form.product_edit_form_dashboard')</a>
</li>
<li class="breadcrumb-item"><a href="{{ route('admin.product-model') }}"> @lang('form.product_edit_form_model_user') </a>
</li>
<li class="breadcrumb-item active">@lang('form.product_edit_form_model_edit_user')
</li>

@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
@endpush

@endsection
@section('content')
<div class="card card-success min-height">
    <div class="card-header">
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
            {!! Form::open([ 'route' => ['admin.product-model.update', $model->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
            @csrf
            <div class="form-body">

                <div class="row">
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('brand') ? 'error' : '' !!}">
                            <label>{{trans('form.brand')}}<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('brand', $brand ?? array(), $model->F_PRD_BRAND_NO, ['class'=>'form-control mb-1 select2', 'id' => 'brand','data-validation-required-message' => 'This field is required', 'placeholder' => 'Select brand', 'tabindex' => 1, 'data-url' => URL::to('prod_model') ]) !!}
                                {!! $errors->first('brand', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                            <label>@lang('form.name')<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::text('name', $model->NAME, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter product model name', 'data-validation-required-message' => 'This field is required', 'tabindex' => 2 ]) !!}
                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('code') ? 'error' : '' !!}">
                            <label>@lang('form.code')<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::text('code', $model->CODE, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter product model name', 'data-validation-required-message' => 'This field is required', 'tabindex' => 3 ]) !!}
                                {!! $errors->first('code', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions text-center mt-3">
                    <a href="{{route('admin.product-model')}}">
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
    <script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>\
    <script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
@endpush
