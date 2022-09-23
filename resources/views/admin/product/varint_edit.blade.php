<?php
    $categories_combo       = $data['category_combo'] ?? [];
    $vat_class_combo        = $data['vat_class_combo'] ?? [];
    $brand_combo            = $data['brand_combo'] ?? [];
    $subcategory_combo      = $data['subcategory_combo'] ?? array();
    $prod_model_combo       = $data['prod_model_combo'] ?? array();
    $prod_size_combo        = $data['prod_size_combo'] ?? array();
    $prod_color_combo       = $data['prod_color_combo'] ?? array();
    $hscode_combo           = $data['hscode_combo'] ?? array();
    $updated_data           = json_decode($data['variant']->NEED_APPROVAL,TRUE);
    $tab_index              = 1;
    $shipping_method_combo = [
        'AIR' => 'AIR',
        'SEA' => 'SEA'
    ];
    $roles      = userRolePermissionArray();
    $variant_info = $data['variant'];
    $variant_id  = $data['variant']->PK_NO;
    $product  = $data['variant']->master;
?>

@extends('admin.layout.master')
<!--push from page-->
@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/file_upload/image-uploader.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/editors/summernote.css')}}">
    <!--for file uploads-->
    <link rel="stylesheet" href="{{ asset('assets/file_upload/image-uploader.min.css')}}">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!--for tooltip-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
    <!--for image gallery-->
    <link rel="stylesheet" href="{{ asset('assets/lightgallery/dist/css/lightgallery.min.css') }}">
@endpush('custom_css')

@section('pending_varint','active')
@section('Product Management','open')

@section('title') Product Variant Edit @endsection

@section('page-name') Product Variant Edit @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('product.breadcrumb_title')  </a></li>
<li class="breadcrumb-item active">@lang('product.breadcrumb_sub_title')    </li>
@endsection

@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-sm card-success" >

                <div class="card-content">
                    <div class="card-body">
                        {!! Form::open([ 'route' => ['admin.product_variant.update',$variant_id], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                        {!! Form::hidden('variant_pk_no', $variant_id ) !!}
                        {!! Form::hidden('pk_no', $product->PK_NO ) !!}
                            <section>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card card-sm card-smart">
                                        <div class="card-header" >
                                            <h4 class="card-title">@lang('product.product_variant')</h4>
                                            <a class="heading-elements-toggle"><i class="la la-ellipsis font-medium-3"></i></a>
                                            <div class="heading-elements" style="top: 10px;">
                                                <ul class="list-inline mb-0">
                                                    <li><a data-action="collapse"><i class="ft-plus "></i></a></li>
                                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show" style="">
                                            <div class="card-body card-body-sm">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group {!! $errors->has('color') ? 'error' : '' !!}">
                                                            <div>
                                                                <label>{{trans('form.color')}}<span class="text-danger">*</span></label>
                                                                @if(hasAccessAbility('new_color', $roles))
                                                                <button type="button" class="btn btn-icon btn-info btn-xs pull-right" title="ADD COLOR FOR THE BRAND" data-toggle="modal" data-target="#colorAddModal" data-brand_name="{{$product->BRAND_NAME ?? ''}}" data-brand_id="{{$product->F_BRAND ?? ''}}" id="colorAdd">&nbsp;+ C&nbsp;</button>
                                                                @endif
                                                            </div>
                                                            <div class="controls">
                                                                {!! Form::select('color', $prod_color_combo, $variant_info->F_COLOR_NO ?? null, ['class'=>'form-control mb-1 select2 set_variant_name', 'id' => 'color', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select color', 'tabindex' => $tab_index++ ]) !!}

                                                                {!! $errors->first('color', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group {!! $errors->has('color') ? 'error' : '' !!}">
                                                            <div>
                                                                <label>{{trans('form.size')}}<span class="text-danger">*</span></label>
                                                                @if(hasAccessAbility('new_size', $roles))
                                                                <button type="button" class="btn btn-icon btn-info btn-xs pull-right" title="ADD SIZE FOR THE BRAND" data-toggle="modal" data-target="#sizeAddModal" data-brand_name="{{$product->BRAND_NAME ?? ''}}" data-brand_id="{{$product->F_BRAND ?? ''}}" id="sizeAdd">&nbsp;+ S&nbsp;</button>
                                                                @endif
                                                            </div>
                                                            <div class="controls">
                                                                {!! Form::select('size', $prod_size_combo, $variant_info->F_SIZE_NO ?? null, ['class'=>'form-control mb-1 select2 set_variant_name', 'id' => 'size', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select size', 'tabindex' => $tab_index++ ]) !!}
                                                                {!! $errors->first('size', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group {!! $errors->has('barcode') ? 'error' : '' !!}">
                                                            <label>{{trans('form.barcode')}}<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::text('barcode', $variant_info->BARCODE ?? null, [ 'class' => 'form-control mb-1', 'id' => 'barcode', 'placeholder' => 'Enter product barcode', 'tabindex' => $tab_index++,'data-validation-required-message' => 'This field is required' ]) !!}
                                                                {!! $errors->first('barcode', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                            @if($variant_info->IS_ACTIVE == 2 && isset($updated_data['BARCODE']) )
                                                            <p class="text-warning pl-1">Old Barcode : {{ $updated_data['BARCODE'] }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <br>
                                                            <div class="controls mt-1">
                                                                <label>
                                                                    <input id="barcode_by_mfg" type="checkbox" name="is_barcode_by_mfg" tabindex="13" {{ $variant_info->IS_BARCODE_BY_MFG == 1 ? 'checked' : '' }} >

                                                                    <small>{{ trans('form.is_barcode_by_manufacturer') }} </small></label>
                                                                {!! $errors->first('is_barcode_by_mfg', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                                            <label>{{trans('form.name')}}<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::text('name', $variant_info->VARIANT_NAME, [ 'class' => 'form-control mb-1', 'id' => 'variant_name',  'data-variant_name' => $variant_info->VARIANT_NAME,  'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter product name', 'tabindex' => $tab_index++ ]) !!}
                                                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                            @if($variant_info->IS_ACTIVE == 2 && isset($updated_data['NAME']) )
                                                                <p class="text-warning pl-1">Old Name : {{ $updated_data['NAME'] }}</p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group {!! $errors->has('vat_class') ? 'error' : '' !!}">
                                                            <label>{{trans('form.vat_class')}}<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::select('vat_class', $vat_class_combo, $variant_info->F_VAT_CLASS ?? 3, ['class'=>'form-control mb-1 ','data-validation-required-message' => 'This field is required', 'placeholder' => 'Select vat_class', 'tabindex' => $tab_index++ ]) !!}
                                                                {!! $errors->first('vat_class', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group {!! $errors->has('hs_code') ? 'error' : '' !!}">
                                                            <label>{{trans('form.hs_code')}}<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::text('hs_code', $variant_info->HS_CODE, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter product HS code', 'tabindex' => $tab_index++ ]) !!}
                                                                {!! $errors->first('hs_code', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                            @if($variant_info->IS_ACTIVE == 2 && isset($updated_data['HS_CODE']) )
                                                            <p class="text-warning pl-1">Old HS Code : {{ $updated_data['HS_CODE'] }}</p>
                                                            @endif
                                                        </div>
                                                    </div>



                                                    <div class="col-md-12">
                                                        <h5><strong>PRODUCT PRICE -------------------</strong></h5>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group {!! $errors->has('price') ? 'error' : '' !!}">
                                                            <label>{{trans('form.price')}}<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::number('price', $variant_info->REGULAR_PRICE, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter price for fixed', 'tabindex' => $tab_index++, 'step' => '0.01', 'data-validation-number-message' => 'Please enter max 2 decimal point' ]) !!}
                                                                {!! $errors->first('price', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                            @if($variant_info->IS_ACTIVE == 2 && isset($updated_data['REGULAR_PRICE']) )
                                                            <p class="text-warning pl-1">Old Price : {{ number_format($updated_data['REGULAR_PRICE'],2) }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group {!! $errors->has('price_ins') ? 'error' : '' !!}">
                                                            <label>{{trans('form.price_ins')}}<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::number('price_ins', $variant_info->INSTALLMENT_PRICE, ['class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter price for installment', 'tabindex' => $tab_index++, 'step' => '0.01', 'data-validation-number-message' => 'Please enter max 2 decimal point']) !!}
                                                                {!! $errors->first('price_ins', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                            @if($variant_info->IS_ACTIVE == 2 && isset($updated_data['INSTALLMENT_PRICE']) )
                                                            <p class="text-warning pl-1">Old Price : {{ number_format($updated_data['INSTALLMENT_PRICE'],2) }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group {!! $errors->has('max_order_qty') ? 'error' : '' !!}">
                                                            <label>{{trans('form.max_order_qty')}}<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::number('max_order_qty', $variant_info->MAX_ORDER, ['class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter max order quantity', 'tabindex' => $tab_index++, 'step' => '0.01', 'data-validation-number-message' => 'Please enter max 2 decimal point']) !!}
                                                                {!! $errors->first('max_order_qty', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                            @if($variant_info->IS_ACTIVE == 2 && isset($updated_data['MAXIMUM_ORDER']) )
                                                            <p class="text-warning pl-1">Old Max Order : {{ number_format($updated_data['MAXIMUM_ORDER'],2) }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group {!! $errors->has('air_freight') ? 'error' : '' !!}">
                                                            <label>{{trans('form.air_freight')}}<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::number('air_freight', $variant_info->AIR_FREIGHT_CHARGE, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter air freight cost', 'tabindex' => $tab_index++, 'step' => '0.01', 'data-validation-number-message' => 'Please enter max 2 decimal point']) !!}
                                                                {!! $errors->first('air_freight', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>

                                                            @if($variant_info->IS_ACTIVE == 2 && isset($updated_data['AIR_FREIGHT']) )
                                                            <p class="text-warning pl-1">Old Air Freight : {{ number_format($updated_data['AIR_FREIGHT'],2) }}</p>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group {!! $errors->has('sea_freight') ? 'error' : '' !!}">
                                                            <label>{{trans('form.sea_freight')}}<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::number('sea_freight', $variant_info->SEA_FREIGHT_CHARGE, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter sea freight cost', 'tabindex' => $tab_index++,'step' => '0.01', 'data-validation-number-message' => 'Please enter max 2 decimal point' ]) !!}
                                                                {!! $errors->first('sea_freight', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>

                                                            @if($variant_info->IS_ACTIVE == 2 && isset($updated_data['SEA_FREIGHT']) )
                                                            <p class="text-warning pl-1">Old Sea Freight : {{ number_format($updated_data['SEA_FREIGHT'],2) }}</p>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group {!! $errors->has('local_postage') ? 'error' : '' !!}">
                                                            <label>{{trans('form.local_postage')}}<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::number('local_postage', $variant_info->LOCAL_POSTAGE, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter postage cost for local', 'tabindex' => $tab_index++, 'step' => '0.01', 'data-validation-number-message' => 'Please enter max 2 decimal point']) !!}
                                                                {!! $errors->first('local_postage', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                            @if($variant_info->IS_ACTIVE == 2 && isset($updated_data['LOCAL_POSTAGE']) )
                                                            <p class="text-warning pl-1">Old Postage for SM : {{ number_format($updated_data['LOCAL_POSTAGE'],2) }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group {!! $errors->has('int_postage') ? 'error' : '' !!}">
                                                            <label>{{trans('form.interdistric_postage')}}<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::number('int_postage', $variant_info->INTER_DISTRICT_POSTAGE, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter postage cost for interdistrict', 'tabindex' => $tab_index++, 'step' => '0.01', 'data-validation-number-message' => 'Please enter max 2 decimal point' ]) !!}
                                                                {!! $errors->first('int_postage', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                            @if($variant_info->IS_ACTIVE == 2 && isset($updated_data['INTER_DISTRICT_POSTAGE']) )
                                                            <p class="text-warning pl-1">Old Postage for SS : {{ number_format($updated_data['INTER_DISTRICT_POSTAGE'],2) }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group {!! $errors->has('def_shipping_method') ? 'error' : '' !!}">
                                                            <label>{{trans('form.preffered_shipping_method')}}<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::select('def_shipping_method', $shipping_method_combo, $variant_info->PREFERRED_SHIPPING_METHOD, ['class'=>'form-control mb-1','data-validation-required-message' => 'This field is required', 'placeholder' => 'Select preffered shipping method', 'tabindex' => $tab_index++]) !!}
                                                                {!! $errors->first('def_shipping_method', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="input-field">
                                                                <label class="new_arrival">New Arrival</label>
                                                                {!! Form::select('new_arrival', ['1' =>'Yes','0' => 'NO'], $variant_info->NEW_ARRIVAL, ['class'=>'form-control mb-1','tabindex' => 24,'id'=>'new_arrival','placeholder'=>'Select']) !!}
                                                                {!! $errors->first('new_arrival', '<label class="help-block text-danger">:message</label>') !!}

                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="input-field">
                                                                <label class="active" for="is_feature">Is Feature</label>
                                                                {!! Form::select('is_feature', ['1' =>'Yes','0' => 'NO'], $variant_info->IS_FEATURE, ['class'=>'form-control mb-1','tabindex' => $tab_index++,'id'=>'is_feature','placeholder'=>'Select' ]) !!}
                                                                {!! $errors->first('is_feature', '<label class="help-block text-danger">:message</label>') !!}

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group {!! $errors->has('short_narration') ? 'error' : '' !!}">
                                                            <label>{{trans('form.short_description')}}</label>
                                                            <div class="controls">
                                                                {!! Form::textarea('short_narration', $variant_info->SHORT_NARRATION, [ 'class' => 'form-control mb-1', 'tabindex' => $tab_index++, 'rows' => 5 ]) !!}
                                                                {!! $errors->first('short_narration', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group {!! $errors->has('def_narration') ? 'error' : '' !!}">
                                                            <label>{{trans('form.description')}}</label>
                                                            <div class="controls">
                                                                {!! Form::textarea('narration', $variant_info->NARRATION, [ 'class' => 'form-control mb-1 summernote', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tab_index++, 'rows' => 3 ]) !!}
                                                                {!! $errors->first('def_narration', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if($variant_info->allVariantPhotos && $variant_info->allVariantPhotos->count() > 0)
                                                     <p style="margin-left: 15px;">All Variant Photos</p>
                                                    <div class="col-md-12">
                                                        <div class="row">

                                                            @foreach($variant_info->allVariantPhotos as $photo)
                                                            <div class="col-md-2" id="photo_div_{{$photo->PK_NO}}">
                                                                <div class="form-group">
                                                                    <div class="img-box" style="border: 2px solid #ccc; display: inline-block;">
                                                                        <img src="{{asset($photo->RELATIVE_PATH)}}" class="img-fluid">
                                                                        <div class="img-box-child">
                                                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                                            <button type="button" class="btn btn-success"><i class="la la-search"></i>
                                                                                Show</button>
                                                                            <button type="button" class="btn btn-danger photo-delete" data-id="{{$photo->PK_NO}}"><i class="la la-smile-o"></i>
                                                                                Delete</button>

                                                                        </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="input-field">
                                                                <label class="active">{{trans('form.product_variant_photos')}}</label>
                                                                <div class="product_variant_photos" style="padding-top: .5rem;" title="Click for photo upload"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-actions text-center">
                                                            <a href="{{route('admin.product.pending')}}" class="btn btn-warning mr-1"><i class="ft-x"></i> Cancel</a>
                                                            @if(hasAccessAbility('product_approval', $roles))
                                                                <button type="submit" class="btn bg-primary bg-darken-1 text-white" name="submit" value="approved"><i class="la la-check-square-o"></i> Approved </button>

                                                                <button name="submit" type="submit" class="btn btn-danger save-inv-details mr-1" value="discard"><i class="ft-alert-octagon"></i> Discard Changes</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>








@endsection
<!--push from page-->
@push('custom_js')
<script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<!--for image upload-->
<script type="text/javascript" src="{{ asset('assets/file_upload/image-uploader.min.js')}}"></script>
<script src="{{ asset('assets/vendors/js/editors/summernote/summernote.js') }}"></script>
<script src="{{ asset('assets/js/scripts/editors/editor-summernote.js') }}"></script>
<!--script only for product page-->
<script type="text/javascript" src="{{ asset('assets/pages/product.js')}}"></script>
<!--for tooltip-->
<script src="{{ asset('assets/js/scripts/tooltip/tooltip.js')}}"></script>
<!--for image gallery-->
<script src="{{ asset('assets/lightgallery/dist/js/lightgallery.min.js')}}"></script>
<script type="text/javascript">
    //for image gallery
    $(".lightgallery").lightGallery();
   //product photo delete
   $(document).on('click','.photo-delete', function(e){
    var id = $(this).attr('data-id');
    if (!confirm('Are you sure you want to delete the photo')) {
        return false;
    }
    if ('' != id) {
        var pageurl = `{{ URL::to('prod_img_delete')}}/`+id;
        $.ajax({
            type:'get',
            url:pageurl,
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                // console.log(data.status);
                if(data.status == true ){
                    $('#photo_div_'+id).hide();
                } else {
                    alert('something wrong please you should reload the page');
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    }
})
</script>
<script>
    $(function () {
        $('.prod_def_photo_upload').imageUploader({
            extensions:[".jpg",".jpeg",".png",".gif",".svg", ".pdf",".JPG",".JPEG",".PNG",".GIF",".SVG", ".PDF"],
            mimes:["image/jpeg","image/png","image/gif","image/svg+xml","application/pdf"]
        });
        $('.product_variant_photos').imageUploader({
            extensions:[".jpg",".jpeg",".png",".gif",".svg", ".pdf",".JPG",".JPEG",".PNG",".GIF",".SVG", ".PDF"],
            mimes:["image/jpeg","image/png","image/gif","image/svg+xml","application/pdf"]
        });
    });
 </script>
<script type="text/javascript" src="{{ asset('assets/js/select2-tabindex.js') }}"></script>
 @endpush('custom_js')
