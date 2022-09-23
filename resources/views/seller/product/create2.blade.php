@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/file_upload/image-uploader.min.css')}}">
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/editors/summernote.css')}}"> --}}
{{-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons"> --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@endpush('custom_css')
@section('Product Management','open')
@section('product_list','active')
@section('title') @lang('product.add_new_product') @endsection
@section('page-name') @lang('product.add_new_product') @endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin_role.breadcrumb_title')  </a></li>
<li class="breadcrumb-item active">@lang('admin_role.breadcrumb_sub_title')    </li>
@endsection
<?php
$vat_class_combo    = $data['vat_class_combo'] ?? [];
$brand_combo        = $data['brand_combo'] ?? [];
$roles              = userRolePermissionArray();
$active_tab         = request('tab') ?? 1;
$variant_id         = request('variant_id') ?? null;
$type               = request('type') ?? null;
$method_name        = request()->route()->getActionMethod();
$tab_index          = 1;
$categories         = $data['categories'] ?? [];
$country            = $data['country'] ?? [];
?>
@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-sm card-success" style="background-color:#f2f3f8;">
                <div class="card-content">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified no-border">
                            <li class="nav-item">
                                <a class="nav-link active" id="productBasic-tab1" data-toggle="tab" href="#productBasic" aria-controls="productBasic" aria-expanded="true">@lang('product.product_info')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="linkIcon1-tab1" @if($method_name == 'getEdit') data-toggle="tab" href="#linkIcon1" aria-controls="linkIcon1" aria-expanded="false" @endif >@lang('product.product_variant')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="linkIconOpt1-tab1" data-toggle="tab" href="#linkIconOpt1" aria-controls="linkIconOpt1">@lang('product.stock_info')</a>
                            </li>
                        </ul>
                        <div class="tab-content border-tab-content">
                            <div role="tabpanel" class="tab-pane active" id="productBasic" aria-labelledby="productBasic-tab1" aria-expanded="true">
                                {!! Form::open([ 'route' => 'admin.product.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                                @csrf
                                        <div class="card c-card">
                                            <div class="card-header"><h5>Product Info</h5></div>
                                            <div class="card-body">
                                                <div class="row">
                                                     <div class="col-md-6">
                                                            <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                                                <label for="name">{{trans('form.generic_name')}}<span class="text-danger">*</span></label>
                                                                <div class="controls">
                                                                    {!! Form::text('name', null, [ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter product name', 'tabindex' => $tab_index++]) !!}
                                                                    {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                                                </div>
                                                            </div>
                                                    </div>
                                                    {{-- <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('category') ? 'error' : '' !!}">
                                                            <label for="category">{{trans('form.category')}}<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                <select  name="category" id="category" class="form-control select2">
                                                                    @foreach ($categories as $category)
                                                                    <optgroup label="{{ $category->NAME }}">
                                                                    @if(isset($category->subcategories))
                                                                    @foreach($category->subcategories as $subcategory)
                                                                    <option value="{{$subcategory->SUBCATEGORY_ID}}"
                                                                    @if (old("categories")){{ (in_array($subcategory->SUBCATEGORY_ID, old("categories")) ? "selected":"") }}@endif
                                                                    class="optionChild">{{$category->NAME.' > '.$subcategory->SUBCATEGORY_NAME}}</option>
                                                                    @if(!empty($subcategory->subsubcategory))
                                                                    @foreach ($subcategory->subsubcategory2 as $item)
                                                                    <option value="{{$item->SUBCATEGORY_ID2}}" class="pl-3">
                                                                        <span>{{$category->NAME.' > '.$subcategory->SUBCATEGORY_NAME2.' > '.$item->SUBSUBCATEGORY_NAME2}}</span>
                                                                    </option>
                                                                    @endforeach
                                                                    @endif
                                                                    @endforeach
                                                                    @endif
                                                                    </optgroup>
                                                                    @endforeach
                                                                  </select>
                                                                {!! $errors->first('category', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div> --}}

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('brand') ? 'error' : '' !!}">
                                                            <label>{{trans('form.brand')}}<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::select('brand', $brand_combo, null, ['class'=>'form-control select2', 'id' => 'brand','data-validation-required-message' => 'This field is required', 'placeholder' => 'Select brand','id'=>'brand', 'tabindex' => $tab_index++, 'data-url' => URL::to('prod_model')]) !!}
                                                                {!! $errors->first('brand', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('prod_model') ? 'error' : '' !!}">
                                                            <label for="prod_model">{{trans('form.model')}}<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::select('prod_model', array(), null, ['class'=>'form-control select2 prod_model_add', 'id' => 'prod_model','data-validation-required-message' => 'This field is required', 'placeholder' => 'Select model', 'tabindex' => $tab_index++]) !!}
                                                                {!! $errors->first('prod_model', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('unit') ? 'error' : '' !!}">
                                                            <label for="unit">Unit<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::select('unit', array(), null, ['class'=>'form-control', 'id' => 'unit','data-validation-required-message' => 'This field is required', 'placeholder' => 'Select unit', 'tabindex' => $tab_index++]) !!}
                                                                {!! $errors->first('unit', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('min_qty') ? 'error' : '' !!}">
                                                            <label for="min_qty">Minimum Purchase Qty<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::number('min_qty', null, ['class'=>'form-control', 'id' => 'min_qty','data-validation-required-message' => 'This field is required', 'placeholder' => 'Select unit', 'tabindex' => $tab_index++]) !!}
                                                                {!! $errors->first('min_qty', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">


                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('') ? 'error' : '' !!}">
                                                            <label for="">Country of origin<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::select('country', $country, null, ['class'=>'form-control select2 country_add', 'id' => 'country','data-validation-required-message' => 'This field is required', 'placeholder' => 'Select model', 'tabindex' => $tab_index++]) !!}
                                                                {!! $errors->first('country', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('hs_code') ? 'error' : '' !!}">
                                                            <label for="hs_code">HS Code<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::select('hs_code', array(), null, [ 'class' => 'form-control', 'placeholder' => 'Enter product HS code', 'tabindex' => $tab_index++, 'id' => 'hs_code']) !!}
                                                                {!! $errors->first('hs_code', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                              <div class="controls pt-4">
                                                                <label for="is_barcode_by_mfg"><input type="checkbox" name="is_barcode_by_mfg" checked="true"  id="is_barcode_by_mfg" tabindex="{{ $tab_index++ }}"> <small>{{ trans('form.is_barcode_by_manufacturer') }} </small></label>
                                                                {!! $errors->first('is_barcode_by_mfg', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="card c-card">
                                            <div class="card-header"><h5>Product Attributes</h5></div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="card c-card">
                                            <div class="card-header"><h5>Product Description</h5></div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group {!! $errors->has('def_narration') ? 'error' : '' !!}">
                                                            <label>{{trans('form.default_description')}}</label>
                                                            <div class="controls">
                                                                {!! Form::textarea('def_narration', null, [ 'class' => 'form-control def_narration', 'placeholder' => 'Enter short description about the product', 'tabindex' => $tab_index++, 'rows' => 5,'cols'=>5,'id'=>'def_narration' ]) !!}
                                                                {!! $errors->first('def_narration', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>



                                        <div class="card c-card">
                                            <div class="card-header"><h5>Product Media</h5></div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <div class="input-field">
                                                                <label class="active" for="">Product Gallery<span class="img-note d-inline-block"></span></label>
                                                                <div class="prod_def_photo_upload" style="padding-top: .5rem;" title="Click for photo upload"></div>
                                                                <span>Drag and drop pictures below to upload.Add at least 3 images of your product from different angles.Maximum 8 pictures. Size between 500x500 and 2000x2000 px.
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="input-field">
                                                                <label class="active" for="video_url">Video URL</label>
                                                                {!! Form::text('video_url',null, ['class'=>'form-control','tabindex' =>$tab_index++, 'placeholder' => 'Video url','id'=>'video_url']) !!}
                                                                {!! $errors->first('video_url', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="card c-card">
                                            <div class="card-header"><h5>Product Variant</h5></div>
                                            <div class="card-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                       <tr>
                                                          <td class="text-center">
                                                             Variant
                                                          </td>
                                                          <td class="text-center">
                                                             Price
                                                          </td>
                                                          <td class="text-center">
                                                             SKU
                                                          </td>
                                                          <td class="text-center">
                                                             Quantity
                                                          </td>
                                                          <td class="text-center">
                                                             Photo
                                                          </td>
                                                          <td></td>
                                                       </tr>
                                                    </thead>
                                                    <tbody>
                                                       <tr>
                                                          <td>
                                                             <label for="" class="control-label">Color</label>
                                                          </td>
                                                          <td>
                                                             <input type="number" lang="en" name="price[]" value="0" min="0" step="0.01" class="form-control" required="">
                                                          </td>
                                                          <td>
                                                             <input type="text" name="sku[]" value="" class="form-control">
                                                          </td>
                                                          <td>
                                                             <input type="number" lang="en" name="qty[]" value="1" min="0" step="1" class="form-control" required="">
                                                          </td>
                                                          <td>
                                                             <div class="input-group">
                                                                <input type="hidden" name="img[]" class="selected-files">
                                                             </div>
                                                          </td>
                                                          <td>
                                                             <button type="button" class="btn btn-icon btn-sm btn-danger"><i class="la la-trash"></i></button>
                                                          </td>
                                                       </tr>
                                                    </tbody>
                                                 </table>
                                            </div>
                                        </div>

                                        <div class="card c-card">
                                            <div class="card-header"><h5>Product Price & Stock</h5></div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group {!! $errors->has('unit_price') ? 'error' : '' !!}">
                                                            <label for="unit_price">Unit Price<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::number('unit_price',NULL, ['class'=>'form-control', 'id' => 'unit_price','data-validation-required-message' => 'This field is required', 'placeholder' => 'Select unit price', 'tabindex' => $tab_index++]) !!}
                                                                {!! $errors->first('unit_price', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group {!! $errors->has('discount_price') ? 'error' : '' !!}">
                                                            <label for="discount_price">Discount Price</label>
                                                            <div class="controls">
                                                                {!! Form::number('discount_price',NULL, ['class'=>'form-control', 'id' => 'discount_price','placeholder' => 'Select discount price', 'tabindex' => $tab_index++]) !!}
                                                                {!! $errors->first('discount_price', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="card c-card">
                                            <div class="card-header"><h5>Vat & Tax</h5></div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('vat_class') ? 'error' : '' !!}">
                                                            <label class="" for="vat_class">{{trans('form.vat_class')}}</label>
                                                            <div class="controls">
                                                                {!! Form::select('vat_class', $vat_class_combo, 3, ['class'=>'form-control ','id'=>'vat_class', 'placeholder' => 'Select vat class', 'tabindex' => $tab_index++]) !!}
                                                                {!! $errors->first('vat_class', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card c-card">
                                            <div class="card-header"></div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label class="new_arrival" for="new_arrival">New arrival</label>
                                                                {!! Form::select('new_arrival', ['1' =>'Yes','0' => 'No'], 1, ['class'=>'form-control','tabindex' => $tab_index++,'id'=>'new_arrival']) !!}
                                                                {!! $errors->first('new_arrival', '<label class="help-block text-danger">:message</label>') !!}

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label class="active" for="is_feature">Is feature</label>
                                                                {!! Form::select('is_feature', ['1' =>'Yes','0' => 'No'], 1, ['class'=>'form-control','tabindex' =>$tab_index++,'id'=>'is_feature' ]) !!}
                                                                {!! $errors->first('is_feature', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="card c-card">
                                            <div class="card-header">Service & Delivery</div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label class="active" for="warranty">Warranty</label>
                                                                {!! Form::select('warranty', ['1' =>'Yes','0' => 'No'], 1, ['class'=>'form-control','tabindex' =>$tab_index++,'id'=>'warranty' ]) !!}
                                                                {!! $errors->first('warranty', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label class="active" for="warranty_policy">Warranty Policy</label>
                                                                {!! Form::text('warranty_policy',NULL, ['class'=>'form-control','tabindex' =>$tab_index++,'id'=>'warranty_policy' ]) !!}
                                                                {!! $errors->first('warranty_policy', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="card c-card">
                                            <div class="card-header"><h5>SEO Meta</h5></div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label class="active" for="meta_title">Meta title</label>
                                                                {!! Form::text('meta_title',null, ['class'=>'form-control','tabindex' =>$tab_index++, 'placeholder' => 'Meta title','id'=>'meta_title']) !!}
                                                                {!! $errors->first('meta_title', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label class="active" for="meta_keywards">Meta keywords</label>
                                                                {!! Form::text('meta_keywards',null, ['class'=>'form-control','tabindex' =>$tab_index++ , 'placeholder' => 'Meta keywords','id'=>'meta_keywards']) !!}
                                                                {!! $errors->first('meta_keywards', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="controls">
                                                                <label class="active" for="meta_description">Meta description</label>
                                                                {!! Form::textarea('meta_description',null, ['class'=>'form-control','tabindex' =>$tab_index++ ,'rows'=>3, 'placeholder' => 'Meta description','id'=>'meta_description']) !!}
                                                                {!! $errors->first('meta_description', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-actions text-center">
                                            <a href="{{route('admin.product.list')}}" class="btn btn-warning mr-1"><i class="ft-x"></i> {{ trans('form.btn_cancle') }}</a>
                                            <button type="submit" class="btn btn-primary bg-darken-1 text-white">
                                             <i class="la la-check-square-o"></i> {{ trans('form.btn_save') }} </button>
                                         </div>
                                     </div>
                                 </div>
                                 {!! Form::close() !!}
                             </div>
                             <div class="tab-pane" id="linkIcon1" role="tabpanel" aria-labelledby="linkIcon1-tab1" aria-expanded="false">
                                <p>Chocolate bar gummies sesame snaps. Liquorice cake sesame snaps cotton candy cake sweet brownie.
                                    Cotton candy candy canes brownie. Biscuit pudding sesame snaps pudding pudding sesame snaps biscuit
                                    tiramisu.
                                </p>
                            </div>
                            <div class="tab-pane" id="linkIconOpt1" role="tabpanel" aria-labelledby="linkIconOpt1-tab1" aria-expanded="false">
                                <p>Cookie icing tootsie roll cupcake jelly-o sesame snaps. Gummies cookie dragée cake jelly marzipan
                                    donut pie macaroon. Gingerbread powder chocolate cake icing. Cheesecake gummi bears ice cream
                                    marzipan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
<!--push from page-->
@push('custom_js')
<script type="text/javascript" src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/file_upload/image-uploader.min.js')}}"></script>
{{-- <script type="text/javascript" src="{{ asset('assets/vendors/js/editors/summernote/summernote.js') }}"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
{{-- <script type="text/javascript" src="{{ asset('assets/js/scripts/editors/editor-summernote.js') }}"></script> --}}
<script type="text/javascript" src="{{ asset('assets/pages/product.js') }}"></script>
<script>
    $('.def_narration').summernote();
$('.select2').on('select2:select', function (e) {
    $(this).focus();
});
   $(function () {
        $('.prod_def_photo_upload').imageUploader();
    });
 </script>
 @endpush('custom_js')
