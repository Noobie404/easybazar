@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/file_upload/image-uploader.min.css')}}">
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/file_upload/image-uploader.min.css')}}"> --}}
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pintura.css')}}"> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/editors/summernote.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/filepond/filepond-plugin-file-poster.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/toggle/switchery.min.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
{{-- <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet"/> --}}
<link rel="stylesheet" type="text/css" href="{{asset('/assets/vendors/css/extensions/toastr.css')}}">
<style>
    .word-counter {position:absolute;top: 5px;right:87px;z-index: 9;}
    .word-counter-bn {position:absolute;top: 37px;right:20px;}
    #cat_name{padding-right: 150px;}
    #bn_name{padding-right: 60px;}
    #category {position: relative;}
    .input-group-append{position: absolute;right: 0;top: 0;z-index: 9;}
    .input-group{display: block !important}
    .overlay-wrapper{display: none;position: absolute;width: 858px;background: #fff;border: 1px solid #ccc;padding: 5px;z-index: 9999;padding: 15px 10px;}
    .overlay-wrapper ul{padding-left: 0px;height: 180px;overflow-y: scroll;}
    .overlay-wrapper ul li{white-space: nowrap;text-overflow: ellipsis;overflow: hidden;list-style: none;padding: 0px 10px;line-height: 30px;line-height: 30px;cursor: pointer;display: flex;}
    .overlay-wrapper ul li:hover{background: #f4f4f4}
    .overlay-wrapper ul li p{white-space: nowrap;text-overflow: ellipsis;overflow: hidden;width: 170px;}
    .charBold {font-weight: bold;color: red;}
    .cat-filter-section{border: 1px solid #ccc;padding: 15px;}
    .category_dropdown_trash{font-size: 24px !important;padding-top: 10px;cursor: pointer;}
    .category_dropdown_trash:hover {color: #FF4961;}
    .cat_li_active {background : #e3e3e3;border-left: 3px solid #f60}
    .attribute_dropdown_trash{font-size: 24px !important;padding-top: 10px;cursor: pointer;}
    .attribute_dropdown_trash:hover {color: #FF4961;}
    #description_more {background: #ddd;height: 43px;line-height: 3;text-align: center;cursor: pointer}
    .filepond--drop-label {color: #4c4e53;}
    .filepond--label-action {text-decoration-color: #babdc0;}
    .filepond--panel-root {background-color: #edf0f4;}
    .filepond--item-panel {background-color: #595e68;}
    .filepond--drip-blob {background-color: #7f8a9a;}
    .filepond--item {height: 250px !important;}
    /* .filepond--root {height: 200px;} */
    @media (min-width: 30em) {.filepond--item {width: calc(50% - 0.5em);}}
    @media (min-width: 50em) {.filepond--item {width: calc(16.66% - 0.5em);}}
    .filepond--credits{display: none}
    :root .pintura-editor {--color-background: 20,20,20;--color-foreground: 255,255,255;--editor-max-width: 60em;--editor-max-height: 40em;}
    @media (prefers-color-scheme: dark) {html {color: #fff;background: #000;}.pintura-editor {--color-background: 0, 0, 0;--color-foreground: 255, 255, 255;}}
    .custom-control-input:focus ~ .custom-control-label::before {box-shadow: none;}
</style>
@endpush('custom_css')
@section('Product Management','open')
@section('product_create','active')
@section('title') @lang('product.add_new_product') @endsection
@section('page-name') @lang('product.add_new_product') @endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin_role.breadcrumb_title')  </a></li>
<li class="breadcrumb-item active">Product Publish</li>
@endsection
<?php
// $vat_class_combo    = $data['vat_class_combo'] ?? [];
// $brand_combo        = $data['brand_combo'] ?? [];
$roles              = userRolePermissionArray();
$variant_id         = request('variant_id') ?? null;
$type               = request('type') ?? null;
$method_name        = request()->route()->getActionMethod();
$tab_index          = 1;
$categories         = $data['categories'] ?? [];
$country            = $data['country'] ?? [];
?>
@section('content')
<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card card-success min-height">
                <div class="card-content collapse show">
                    <div class="card-body">
                        {!! Form::open([ 'route' => 'admin.product.store', 'method' => 'post','id' => 'form_post', 'class' => 'form-horizontal', 'autocomplete' =>'off','files' => true ]) !!}
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                    <label>Product name<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        {!! Form::text('name', null, [ 'class' => 'form-control','style'=>'width:100%', 'placeholder' => 'Enter product name', 'data-validation-required-message' => 'This field is required','maxlength' => "255", 'tabindex' => $tab_index++,'id' => 'cat_name','required' ]) !!}
                                        {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                        <div class="word-counter">0/255</div>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" id="translate"><i class='fa fa-spinner fa-spin' style="display: none"></i>  Translate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group {!! $errors->has('bn_name') ? 'error' : '' !!}">
                                    <label>Product name in bengali</label><span class="text-danger">*</span>
                                    <div class="controls pt-2">
                                        {!! Form::text('bn_name', null, [ 'class' => 'form-control mb-1 validate', 'placeholder' => 'Enter product name', 'data-validation-required-message' => 'This field is required','required','maxlength' => "255", 'tabindex' => $tab_index++,'id' => 'bn_name' ]) !!}
                                        {!! $errors->first('bn_name', '<label class="help-block text-danger">:message</label>') !!}
                                        <div class="word-counter-bn">0/255</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row category_row">
                            <div class="col-md-8">
                                {!! Form::hidden('category[]', null, ['id' => 'selected_category_id']) !!}
                                <div class="form-group mb-2 {!! $errors->has('category') ? 'error' : '' !!}">
                                    <label>Choose category</label><span class="text-danger">*</span>
                                    <div class="controls pt-2">
                                        {!! Form::text('', null, [ 'class' => 'form-control mb-1 validate category', 'placeholder' => 'Enter category name', 'data-validation-required-message' => 'This field is required','required', 'tabindex' => $tab_index++,'id' => 'category','onkeydown'=>'return false;']) !!}
                                        {!! $errors->first('category', '<label class="help-block text-danger">:message</label>') !!}
                                        <div class="overlay-wrapper">
                                            <div class="row">
                                                <div class="col-md col1">
                                                    <div id="" class="cat-filter-section">
                                                        <fieldset class="form-group position-relative has-icon-left">
                                                            <input type="text" class="form-control form-control-sm input-sm filter_category" id="" placeholder="Keyword">
                                                            <div class="form-control-position">
                                                                <i class="la la-search"></i>
                                                            </div>
                                                        </fieldset>
                                                        <ul>
                                                            @foreach ($categories as $category)
                                                            <li data-cat_pk="{{ $category->PK_NO }}" data-cat_name="{{ $category->NAME }}" title="{{ $category->NAME }}">
                                                                <p class="m-0">{{ $category->NAME }}</p>@if(isset($category->subcategories))<i class="la la-angle-right" style="float:right;line-height: inherit;"></i>@endif
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md col1 pl-0"></div>
                                                <div class="col-md col1 pl-0"></div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-info parent_category_confirm_btn" title="Confirm" id="confirm_category" data-status="update" disabled>Confirm</button>
                                                    <button type="button" class="btn btn-danger" title="Close" id="close_category_overlay">Close</button>
                                                    <button type="button" class="btn btn-primary" title="Clear" id="clear_category_overlay">Clear</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <section class="append_new_category">

                        </section>
                        <div class="row">
                            <div class="col-md-3">
                                <a class="btn btn-sm btn-info text-white mb-2 add_new_category" href="javascript:void(0)" title="ADD NEW CATEGORY"><i class="ft-plus text-white"></i> New category</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                                    <label>Is active <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::select('is_active', ['1'=> 'Yes','0'=> 'No'], 1,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tab_index++ ]) !!}
                                        {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('is_feature') ? 'error' : '' !!}">
                                    <label>Is feature <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::select('is_feature', ['0'=> 'No','1'=> 'Yes'], 0,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tab_index++]) !!}
                                        {!! $errors->first('is_feature', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <label for=""><strong>Product Attributes  <a class="btn btn-sm btn-info text-white mb-2 refresh_attribute" href="javascript:void(0)" title="REFRESH ATTRIBUTES"><i class="la la-refresh text-white"></i></a> </strong></label>
                                        <div id="product_arrtibutes">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <label for=""><strong>Product Family <span class="text-danger">*</span></strong></label>
                                        <div id="product_features">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <label for=""><strong>Price & Stock <span class="text-danger">*</span></strong></label>
                                        {{-- <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group {!! $errors->has('default_price') ? 'error' : '' !!}">
                                                    <label> Default price (regular)<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::number('default_price', null, ['id'=>'default_price','class' => 'form-control', 'placeholder' => 'default price','step' => 0.01,'required']) !!}
                                                        {!! $errors->first('default_price', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group {!! $errors->has('ins_price') ? 'error' : '' !!}">
                                                    <label> Default price (installment)<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::number('ins_price', null, ['id'=>'ins_price','class' => 'form-control', 'placeholder' => 'default price','step' => 0.01,'required']) !!}
                                                        {!! $errors->first('ins_price', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div id="product_variants">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {!! $errors->has('short_description_en') ? 'error' : '' !!}" id="short_description_en">
                                    <label>Short description <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::textarea('short_description_en', null, [ 'class' => 'form-control summernote', 'placeholder' => 'Enter short description', 'tabindex' => $tab_index++,'rows'=>'5' ]) !!}
                                        {!! $errors->first('short_description_en', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                                <div class="form-group {!! $errors->has('short_description_bn') ? 'error' : '' !!}" id="short_description_bn" style="display: none;">
                                    <label>Short description <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::textarea('short_description_bn', null, [ 'class' => 'form-control summernote', 'placeholder' => 'Enter short description', 'tabindex' => $tab_index++,'rows'=>'5','cols'=>'10' ]) !!}
                                        {!! $errors->first('short_description_bn', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::select('short_description_lang', ['1'=> 'English','2'=> 'Bengali'], 1,[ 'class' => 'form-control mb-2','style' => 'width:200px;','id' => 'short_description_lang' ]) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {!! $errors->has('long_description_en') ? 'error' : '' !!}" id="long_description_en">
                                    <label>Long description (English) <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::textarea('long_description_en', null, [ 'class' => 'form-control summernote', 'placeholder' => 'Enter long description', 'tabindex' => $tab_index++,'rows'=>'5' ]) !!}
                                        {!! $errors->first('long_description_en', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {!! $errors->has('long_description_bn') ? 'error' : '' !!}" style="display: none;" id="long_description_bn">
                                    <label>Long description (Bengali) <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::textarea('long_description_bn', null, [ 'class' => 'form-control summernote', 'placeholder' => 'Enter long description', 'tabindex' => $tab_index++,'rows'=>'5','cols'=>'10' ]) !!}
                                        {!! $errors->first('long_description_bn', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div id="description_more">
                                    <i class="la la-angle-double-down"></i> <span>More</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {!! $errors->has('search_keyword') ? 'error' : '' !!}">
                                <label>Search keywords</label>
                                <div class="controls">
                                    {!! Form::text('search_keyword', null, [ 'class' => 'form-control', 'placeholder' => 'Enter search keywords','id'=>'search_keyword', 'tabindex' => $tab_index++]) !!}
                                    {!! $errors->first('search_keyword', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {!! $errors->has('meta_title') ? 'error' : '' !!}">
                                <label>Meta title</label>
                                <div class="controls">
                                    {!! Form::text('meta_title', null, [ 'class' => 'form-control', 'placeholder' => 'Enter meta title','id'=>'meta_title', 'tabindex' => $tab_index++]) !!}
                                    {!! $errors->first('meta_title', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {!! $errors->has('meta_keywards') ? 'error' : '' !!}">
                                <label>Meta keywards</label>
                                <div class="controls">
                                    {!! Form::text('meta_keywards', null, [ 'class' => 'form-control', 'placeholder' => 'Enter meta keyward','id'=>'meta_keywards', 'tabindex' => $tab_index++,'rows'=>'4','cols'=>'10' ]) !!}
                                    {!! $errors->first('meta_keywards', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-field">
                                        <label class="active">Meta DESCRIPTION</label>
                                        {!! Form::textarea('meta_description',null, ['class'=>'form-control mb-1','tabindex' => $tab_index++ ,'rows'=>3,'id'=>'meta_description']) !!}
                                        {!! $errors->first('meta_description', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <input type="file"
                        class="filepond"
                        name="filepond[]"
                        multiple
                        data-allow-reorder="true"
                        data-max-file-size="1MB"
                        data-max-files="3"
                        accept="image/png, image/jpeg, image/jpg, image/gif"> --}}
                        <div class="form-actions text-center mt-3">
                            <a href="{{ route('product.category.list') }}">
                            <button type="button" class="btn btn-warning mr-1" title="Cancel">
                            <i class="ft-x"></i> @lang('form.btn_cancle')
                            </button>
                            </a>
                            <button type="submit" id="form_submit" class="btn btn-primary" title="Save">
                            <i class="la la-check-square-o"></i> @lang('form.btn_save')
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- START ATTRIBUTE MODAL-->
<div class="modal fade text-left show" id="attributeModal" tabindex="-1" role="dialog" aria-labelledby="" aria-modal="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="">Attribute List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8 attr_list">
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control form-control-sm input-sm mb-1" id="attr_search" placeholder="Search">
                                <div class="form-control-position">
                                    <i class="la la-search"></i>
                                </div>
                            </fieldset>
                            <ul class="" id="attr-all-list">
                                {{-- @foreach ($attr as $item)
                                    <li>
                                        <label class="checkbox-label" for="input-{{ $loop->index+1}}" style="">
                                        <input name="{{ $item->NAME }}" type="checkbox"
                                                class="all_attr_input"
                                                value="{{ $item->PK_NO }}"
                                                id="input-{{ $loop->index+1}}" {{ in_array($item->PK_NO ,$selectedAttr) ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                        <span class="attr_name">{{ $item->NAME }}</span><span class="text-danger">{{ $item->IS_REQUIRED == 1 ? '*' : ''}}</span>
                                        </label>
                                    </li>
                                @endforeach --}}
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="ml-2 selected_section">
                                Selected (<span id="selected_count">0</span>)
                                <ul class="skin skin-flat pl-0" id="attr-selected-list">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success" id="confirm_attr" data-dismiss="modal">Confirm</button>
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END ATTRIBUTE MODAL-->
@endsection
<!--push from page-->
@push('custom_js')
{{-- <script type="text/javascript" src="{{ asset('assets/js/pintura.js') }}"></script> --}}
<script type="text/javascript" src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/file_upload/image-uploader.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/js/editors/summernote/summernote.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/scripts/editors/editor-summernote.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('assets/pages/product.js') }}"></script> --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
<script type="text/javascript" src="{{ asset('assets/filepond/bundle.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/js/forms/toggle/switchery.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script>
    var previous_value      = null;
    var previous_text       = '';
    var index               = null;
    var textOfindex         = null;
    var variable_array_list = {};
    var variant_combo       = {};
    var variable_array_name = [];
    var variable_array_fullname = [];
    var variable_attribures = [];
    var variable_attribure_pks = [];
    $(document).ready(function() {
        var count           = 0;
        var cat_names       = [];
        var attribute       = 0;
        var elt             = $('.input-tags'+attribute);
        var short_description_en = '';
        var short_description_bn = '';
        $(document).on('itemRemoved','[id*=input-tags]', function(event) {
            var tag_id = $(this).data('tag_id');
            if (!event.options || !event.options.preventPost) {
                if ($(this).val() !== '') {
                    $('#selected_attr_section'+tag_id).fadeIn();
                }else{
                    $('#selected_attr_section'+tag_id).fadeOut();
                }
            }
        });
        // $(function(){$(".validate").jqBootstrapValidation();});
    });
    $('.select2').on('select2:select', function (e) {
        $(this).focus();
    });
    $(function () {
        $('.prod_def_photo_upload').imageUploader();
    });
    $('#cat_name').on('keyup keydown paste input',function(){
        $('.word-counter').text(this.value.length+'/255');
    })
    $('#bn_name').on('keyup keydown paste input',function(){
        $('.word-counter-bn').text(this.value.length+'/255');
    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click','#translate',function(){
        var get_url = $('#base_url').val();
        var text = $('#cat_name').val();
        $(".fa-spinner").fadeIn("slow");
        $.ajax({
            type:'post',
            url:get_url+'/translate',
            data:{
                target:'bn',
                text:text
            },
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                if(data.status == 1 ){
                    $('#bn_name').val(data.result)
                    $('.word-counter-bn').text($('#bn_name').val().length+'/255');
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
        $(".fa-spinner").fadeOut("slow");
    });
    $(document).on('click','.category',function(e){
        e.stopPropagation();
        e.preventDefault();
        $(this).closest('.controls').find('.overlay-wrapper').fadeIn('slow');
    });
    $('html').click(function(){
        if( !$(event.target).closest('.overlay-wrapper').length){
            $('.overlay-wrapper').fadeOut('slow');
        }
    });
    $(document).on('keyup keydown paste','.filter_category',function () {
        var filter = $(this).val();
        $(this).closest(".cat-filter-section").find('ul li p').each(function () {
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).parent().fadeOut();
            } else {
                $(this).html(function (_, html) {
                    var retVal = $(this).text(); // remove any span...
                    return (filter.trim().length == 0) ? retVal :  retVal.replace(new RegExp(filter, 'gi'), '<span class="charBold">' + filter + '</span>');
                });
                $(this).parent().show();
            }
        });
    });
    $(document).on('click','.cat-filter-section ul li',function(){
        $(this).closest('.cat-filter-section').find('ul li').removeClass('cat_li_active');
        $(this).addClass('cat_li_active');
        var get_url = $('#base_url').val();
        var cat_pk = $(this).data('cat_pk');
        var cat_name = $(this).data('cat_name');
        var the = $(this);
        the.closest("ul").find('li').each(function (i,row) {
            $(row).removeClass('clicked');
        });
        $(this).addClass('clicked');
        the.closest('.category_row').find('#selected_category_id').val(the.data('cat_pk'));
        $.ajax({
            type:'post',
            url:get_url+'/product/get-category-child',
            data:{
                cat_pk:cat_pk
            },
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                the.closest('.col1').nextAll().html('');
                the.closest('.overlay-wrapper').find('#confirm_category').attr('disabled',false);
                if(data.status == 1 ){
                    the.closest('.col1').nextAll().html('');
                    the.closest('.col1').next().html(data.html);
                    // $('#confirm_category').attr('disabled',true);
                }else if(data.status == 2){
                    toastr.warning('Please contact with admin !','Warning');
                }
                cat_names = [];
                the.closest('.overlay-wrapper').find('.col1').each(function (i,row) {
                    var rows = $(row);
                    rows.find('ul li').each(function (i,row2) {
                        if ($(row2).hasClass('clicked')) {
                            cat_names.push($(row2).data('cat_name'));
                        }
                    });
                });
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    });
    $(document).on('click','#close_category_overlay',function(){
        $(this).closest('.overlay-wrapper').fadeOut('slow');
    });
    $(document).on('click','#clear_category_overlay',function(){
        cat_names = [];
        $(this).closest('.category_row').find('#selected_category_id').val('');
        $(this).closest('.category_row').find('#category').val('');
        $(this).closest('.overlay-wrapper').find('#confirm_category').attr('disabled',true);
        $(this).closest('.overlay-wrapper').find('.col1').each(function (i,row) {
            var rows = $(row);
            if (i==0) {
                rows.find('ul li').each(function (i,row2) {
                    $(row2).css({'background' : 'transparent','border-left':'none'});
                    $(row2).removeClass('clicked');
                });
            }else{
                rows.html('');
            }
        });
    });
    $(document).on('click','#confirm_category',function(){
        var category_list = '';
        for (let i = 0; i < cat_names.length; i++) {
            if (i==0) {
                category_list += cat_names[i];
            }else{
                category_list += ' / '+cat_names[i];
            }
        }
        $(this).closest('.category_row').find('#category').val(category_list);
        var cat_pk = $(this).closest('.category_row').find('#selected_category_id').val();
        // $('.overlay-wrapper').each(function (i,row) {
        //     var rows = $(row);
        //     var selected_cat_pk = rows.closest('.category_row').find('#selected_category_id').val();
        //     console.log(selected_cat_pk);
        //     console.log(cat_pk);
        //     if(cat_pk == selected_cat_pk){
        //         toastr.warning('Duplicate category category !','Warning');
        //     }
        // });
        if ($(this).hasClass('parent_category_confirm_btn')) {
            var get_url = $('#base_url').val();
            $.ajax({
                type:'post',
                url:get_url+'/category-related-attributes',
                data:{
                    category:cat_pk
                },
                async :true,
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (data) {
                    if(data.status == 1){
                        console.log(data);
                        $('#product_arrtibutes').html('');
                        $('#product_arrtibutes').html(data.attribute_html);
                        $('#product_features').html('');
                        $('#product_features').html(data.features_html);
                        $('.attr_select2').select2();
                        $('.feature_dropdown').select2();
                        // $('.feature_dropdown_hidden select').select2();
                        // $('.main .select2').select2({
                        //     allowClear: true,
                        //     width: '100%'
                        // });
                        $('.overlay-wrapper').fadeOut('slow');
                        // $('[id*=input-tags]').tagsinput();
                        $('#product_variants').html('');
                        $('#product_variants').html(data.variant_html);
                        variable_array_list = {};
                        variable_array_name = [];
                        variable_array_fullname = [];
                        variable_attribures = [];
                        variable_attribure_pks = [];
                        variant_combo = {combo_text:[],combo_id:[],variant_pk:[],is_color:[],combo_combo:[]};
                        for (var property in data.features) {
                            variable_array_list[data.features[property]['SLUG']] = {attr:[],attr_ids:[],attr_pk:data.features[property]['PK_NO'],is_color:data.features[property]['IS_COLOR']};
                            variable_array_name.push(data.features[property]['SLUG']);
                            variable_array_fullname.push(data.features[property]['NAME']);
                        }
                        for (var attr in data.attributes) {
                            variable_attribures.push(data.attributes[attr]['SLUG']);
                            variable_attribure_pks.push(data.attributes[attr]['PK_NO']);
                        }
                        // for(var i = 0; i< data.feature_slug.length; i++){
                        //     variable_array_list[data.feature_slug[i]] = {attr:[],is_color:0};
                        //     variable_array_name.push(data.feature_slug[i]);
                        // }
                        console.log(variable_array_name);
                        console.log(variable_array_fullname);
                        console.log(variable_attribures);
                        console.log(variable_attribure_pks);
                        $('[id*=input_tags]').find('.bootstrap-tagsinput input').hide();
                        $('.feature_list_select2').select2({
                            tags: true,
                            maximumSelectionLength: 10,
                            tokenSeparators: [',', ' '],
                            placeholder: "Select or type keywords",
                            allowClear: true,
                            scrollAfterSelect: false,
                            createTag: function (params) {
                                return null;
                            },
                        });
                        $(".feature_list_select2").on("select2:select", function (evt) {
                          var element = evt.params.data.element;
                          var $element = $(element);

                            window.setTimeout(function () {
                                if ($(".feature_list_select2").find(":selected").length > 1) {
                                    var $second = $(".feature_list_select2").find(":selected").eq(-2);

                                    $element.detach();
                                    $second.after($element);
                                } else {
                                    $element.detach();
                                    $(".feature_list_select2").prepend($element);
                                }

                                $(".feature_list_select2").trigger("change");
                            }, 1);
                        });
                    }else if(data.status == 2){ //ONLY ONE VARIANT AS NO FEATURES FOUND
                        variable_array_list = {};
                        variable_array_name = [];
                        variable_array_fullname = [];
                        variable_attribures = [];
                        variable_attribure_pks = [];
                        variant_combo = {combo_text:[],combo_id:[],variant_pk:[],is_color:[],combo_combo:[]};
                        $('#product_arrtibutes').html('');
                        $('#product_features').html('');
                        $('#product_variants').html('');
                        $('#product_variants').html(data.variant_html);
                        $('.overlay-wrapper').fadeOut('slow');
                    }
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            });
        }else{
            $(this).closest('.overlay-wrapper').fadeOut('slow');
        }
    })
    $(document).on('click','.category_dropdown_trash',function(){
        $(this).closest('.category_row').remove();
    })
    $(document).on('click','#attributes',function(){
        $('#attr-all-list').html('');
        $('#attr-selected-list').html('');
        $('#selected_count').text('0');
        var get_url = $('#base_url').val();
        attribute = $(this).data('attribute');
        var selected_tags = $('.input-tags'+attribute).val() ;
        $.ajax({
            type:'post',
            url:get_url+'/get-attribute-childs',
            data:{
                attribute:attribute,
                selected_tags:selected_tags
            },
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                if(data.status == 1 ){
                    $('#attr-all-list').html(data.html);
                    get_all_checked_val();
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })
    $(document).on('input','#attr_search',function () {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("attr_search");
        filter = input.value.toUpperCase();
        ul = document.getElementById("attr-all-list");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByClassName("attr_name")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    });
    $(document).on('change','.all_attr_input',function () {
        get_all_checked_val();
    })
    $(document).on('change','#input-0',function () {
        if ($(this).is(':checked')) {
            $('#attr-all-list li :checkbox').prop('checked',true);
        }else{
            $('#attr-all-list li :checkbox').prop('checked',false);
        }
        get_all_checked_val();
    })
    function get_all_checked_val() {
        var count = 0;
        $("#attr-selected-list").html('');
        $('#attr-all-list li :checkbox:checked').not('#input-0').each(function (i, row) {
            var li = row.closest('li');
            $(li).clone().appendTo("#attr-selected-list");
        });
        $("#attr-selected-list li").css('display','block');
        $('#attr-selected-list li :checkbox:checked').each(function (i, row) {
            count++;
        });
        $('#selected_count').text(count);
    }
    $('#confirm_attr').on('click',function () {
        $('.input-tags'+attribute).tagsinput('removeAll');
        var elt = $('.input-tags'+attribute);
        $('#attr-selected-list li :checkbox:checked').each(function (i, row) {
            elt.tagsinput('add', { value: row.value , text: row.name  });
        });
        if ($('.input-tags'+attribute).val() !== '') {
            $('#selected_attr_section'+attribute).fadeIn();
        }else{
            $('#selected_attr_section'+attribute).fadeOut();
        }
    });
    $(document).on('click','.attribute_dropdown_trash',function(){
        if (confirm('Are you sure ?')) {
            var the = $(this);
            the.closest('.col-md-1').prev().remove();
            the.closest('.col-md-1').remove();
        }
    })
    $(document).on('click','.refresh_attribute',function(){
        var get_url = $('#base_url').val();
        var category = $('.category_row').first().find('#selected_category_id').val();
        var the = $(this);
        $.ajax({
            type:'get',
            url:get_url+'/refresh-product-attribute-ajax',
            data:{
                category:category,
            },
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
                var block_ele = the.closest('#product_arrtibutes');
                block_ele.block({
                    message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
                    overlayCSS: {
                        backgroundColor: '#FFF',
                        cursor: 'wait',
                    },
                    css: {
                        border: 0,
                        padding: 0,
                        backgroundColor: 'none'
                    }
                });
            },
            success: function (data) {
                console.log(data);
                if(data.status == 1 ){
                    $('#product_arrtibutes').html(data.attribute_html);
                    $('[id*=input_tags]').find('.bootstrap-tagsinput input').hide();
                    // toastr.success('Successfully deleted additional category !','Success');
                }else{
                    toastr.warning('Please try again !','Warning');
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })
    $(document).on('input','#short_description_en',function(){
        short_description_en = $(this).val();
    })
    $(document).on('input','#short_description_bn',function(){
        short_description_bn = $(this).val();
    })
    $(document).on('change','#short_description_lang',function(){
        if ($(this).val() == 1) {
            $('#short_description_bn').fadeOut();
            $('#short_description_en').fadeIn();
        }else{
            $('#short_description_en').fadeOut();
            $('#short_description_bn').fadeIn();
        }
    })
    $(document).on('click','#description_more',function(){
        if ($(this).find('span').text() == 'More') {
            $('#long_description_bn').fadeIn();
            $(this).html('<i class="la la-angle-double-up"></i>  <span>Less</span>');
        }else{
            $('#long_description_bn').fadeOut();
            $(this).html('<i class="la la-angle-double-down"></i>  <span>More</span>');
        }
    });
    $(document).on('click','#form_submit',function(){
        $('.help-error').remove();
        $('input[required]:not(.variant_inputs)').each(function() {
            if($(this).val() == ''){
                console.log($(this).val());
                var message = $(this).attr("data-validation-required-message") ?? 'This field is required';
                if ($(this).hasClass('input_tags')) {
                    $(this).closest('.col-md-6').prev().find('button').after('<span class="help-error d-block text-danger"> '+message+' </span>');
                    $(this).closest('.col-md-6').prev().find('button').addClass('inputError');
                }else{
                    $(this).addClass('inputError');
                    $(this).after('<span class="help-error d-block text-danger"> '+message+' </span>');
                }
            }
        });
        $('select[required]:not(.variant_inputs):not(.feature_dropdown.add_new):not(.feature-color-hidden)').each(function() {
            if( $(this).val() == ''){
              $(this).addClass('inputError');
              var message = $(this).attr("data-validation-required-message") ?? 'This field is required';
              $(this).closest('.controls').append('<span class="help-error d-block text-danger"> '+message+' </span>');
            }
        });
        $('.variant_inputs').each(function() {
            if( $(this).val() == ''){
              $(this).addClass('inputError');
            }
        });
    });
    $(document).on('change keyup','.inputError',function(e){
        $(this).removeClass('inputError');
        $(this).parent().find(".help-error").remove();
    })
</script>
<!-- defer loading of filepond -->
<script>
    // load FilePond resources
    var resources = [
        'filepond.js',
        'filepond-plugin-file-encode.min.js',
        'filepond-plugin-file-validate-type.min.js',
        'filepond-plugin-file-validate-size.min.js',
        'filepond-plugin-image-exif-orientation.min.js',
        // 'filepond-plugin-image-preview.min.css',
        'filepond-plugin-image-preview.min.js',
        'filepond-plugin-image-crop.min.js',
        'filepond-plugin-image-resize.min.js',
        'filepond-plugin-image-transform.min.js',
        // for use with Pintura Image Editor
        'filepond-plugin-file-poster.min.js',
        'filepond-plugin-image-editor.min.js',
        // 'filepond-plugin-file-poster.min.css',
    ].map(function(resource) { return '{{ URL::asset("assets/filepond") }}/' + resource });
    // expose on global scope for demo purposes
    window.pond = null;
    loadResources(resources).then(function() {
        // register plugins
        FilePond.registerPlugin(
            FilePondPluginFileEncode,
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize,
            FilePondPluginImageExifOrientation,
            FilePondPluginImagePreview,
            FilePondPluginImageCrop,
            FilePondPluginImageResize,
            FilePondPluginImageTransform,
            FilePondPluginFilePoster,
            FilePondPluginImageEditor /* for use with Pintura */
        );
        // override default options
        FilePond.setOptions({
            dropOnPage: true,
            dropOnElement: true
        });
        // Mock server to simulate uploads (for privacy reasons)
        var mockServer = {
            remove: null,
            revert: null,
            process: function(fieldName, file, metadata, load, error, progress, abort, transfer, options) {
                var prog = 0;
                var total = file.size;
                var speed = 128 * 1024; // KB/s
                var aborted = false;
                const tick = function() {
                    if (aborted) return;
                    prog += Math.random() * speed;
                    prog = Math.min(total, prog);
                    progress(true, prog, total);
                    if (prog === total) {
                        load(Date.now());
                        return;
                    }
                    setTimeout(tick, Math.random() * 250)
                }
                tick();
                return {
                    abort: function() {
                        aborted = true;
                        abort()
                    }
                }
            }
        };
        // console.log('{{ URL::asset("assets/img/ukshop_logo_mini.jpg") }}');
        // create splash file pond element
        // var fields = [].slice.call(document.querySelectorAll('input[class="filepond"]'));
        // var ponds = fields.map(function(field, index) {
        //     return FilePond.create(field, {
        //         credits: false,
        //         server: mockServer,
        //         allowFilePoster: false,
        //         allowImageEditor: false,
        //     });
        // });
        var ponds = FilePond.create(document.querySelector('input[class="filepond"]'), {
            credits: false,
            server: mockServer,
            allowFilePoster: false,
            allowImageEditor: false,
            files: [
                {
                    source: '{{ URL::asset("assets/img/ukshop_logo_mini.jpg") }}',
                },
            ],
        });
        ponds.on('addfile', (error, file) => {
            if (error) {
                console.log('Oh no !!!!!');
                return;
            }
        });
        // ponds.addFiles('{{ URL::asset("assets/img/ukshop_logo_mini.jpg") }}');
        // loadPintura(pintura);
        loadResources(["{{ URL::asset('assets/filepond/pintura.css') }}"]).then(function() {
            import("{{ URL::asset('assets/filepond/pintura.js') }}").then(pintura => {
                if (window.pond){
                    // console.log('srgfergefvetr');
                    loadPintura(pintura);
                    return 1;
                }
                else{
                    document.addEventListener('filepond:ready', () => {
                        loadPintura(pintura)
                    })
                }
            })
        });
        $("#form_post").submit(function (e) {
            // e.preventDefault();
            var formdata = new FormData(this);
            // append FilePond files into the form data
            // pondFiles = ponds.getFiles();
            // for (var i = 0; i < pondFiles.length; i++) {
            //     // append the blob file
            //     formdata.append('file[]', pondFiles[i].file);
            // }
            var checkbox = [];
            $('[id*=variantcustomSwitch]').each(function (i,row) {
                if ($(row).is(':checked')) {
                    checkbox.push(1);
                }else{
                    checkbox.push(0);
                }
            });
            // formdata.append('features_names',JSON.stringify(variable_array_name));
            // formdata.append('variant_combo',JSON.stringify(variable_array_list));
            // formdata.append('variable_attribures',JSON.stringify(variable_attribures));
            // formdata.append('checkbox_values',JSON.stringify(checkbox));
            $('#form_post').append($("<input>").attr({"type":"hidden","name":"features_names"}).val(JSON.stringify(variable_array_name)));
            $('#form_post').append($("<input>").attr({"type":"hidden","name":"features_full_names"}).val(JSON.stringify(variable_array_fullname)));
            $('#form_post').append($("<input>").attr({"type":"hidden","name":"variable_array_list"}).val(JSON.stringify(variable_array_list)));
            $('#form_post').append($("<input>").attr({"type":"hidden","name":"variable_attribures"}).val(JSON.stringify(variable_attribures)));
            $('#form_post').append($("<input>").attr({"type":"hidden","name":"checkbox_values"}).val(JSON.stringify(checkbox)));
            $('#form_post').append($("<input>").attr({"type":"hidden","name":"variable_attribure_pks"}).val(JSON.stringify(variable_attribure_pks)));
            $('#form_post').append($("<input>").attr({"type":"hidden","name":"variant_combo"}).val(JSON.stringify(variant_combo)));
            // $.ajax({
            //     type:"post",
            //     url: "{{ route('admin.product.store') }}",
            //     data: formdata,
            //     processData: false,
            //     contentType: false,
            //     dataType: 'JSON',
            //     // async :true,
            //     beforeSend: function () {
            //         $("body").css("cursor", "progress");
            //     },
            //     success: function (data) {
            //         window.location.href = data.redirect_to;
            //     },
            //     complete: function (data) {
            //         $("body").css("cursor", "default");
            //     }
            // });
        });
        // add warning to multiple files pond
        // var pondDemoMultiple = ponds;
        // var pondMultipleTimeout;
        // pondDemoMultiple.onwarning = function() {
        //     var container = pondDemoMultiple.element.parentNode;
        //     var error = container.querySelector('p.filepond--warning');
        //     if (!error) {
        //         error = document.createElement('p');
        //         error.className = 'filepond--warning';
        //         error.textContent = 'The maximum number of files is 3';
        //         container.appendChild(error);
        //     }
        //     requestAnimationFrame(function() {
        //         error.dataset.state = 'visible';
        //     });
        //     clearTimeout(pondMultipleTimeout);
        //     pondMultipleTimeout = setTimeout(function() {
        //         error.dataset.state = 'hidden';
        //     }, 5000);
        // };
        // pondDemoMultiple.onaddfile = function() {
        //     clearTimeout(pondMultipleTimeout);
        //     var container = pondDemoMultiple.element.parentNode;
        //     var error = container.querySelector('p.filepond--warning');
        //     if (error) {
        //         error.dataset.state = 'hidden';
        //     }
        // };
        // set top pond
        pond = ponds;
        // document.dispatchEvent(new CustomEvent('filepond:ready'))
    });
    var loadPintura = (pintura) => {
        // assign to multi upload
        var pondMultiple = FilePond.find(document.querySelector('.filepond'));
        // register plugins to use
        pintura.setPlugins(pintura.plugin_crop, pintura.plugin_finetune, pintura.plugin_filter);
        // not needed when using Pintura Image Editor
        pondMultiple.allowImagePreview = false;
        pondMultiple.allowImageTransform = false;
        pondMultiple.allowImageResize = false;
        pondMultiple.allowImageCrop = false;
        pondMultiple.allowImageExifOrientation = false;
        // set Pintura Image Editor props
        pondMultiple.allowFilePoster = true;
        pondMultiple.allowImageEditor = true;
        pondMultiple.filePosterMaxHeight = 256;
        pondMultiple.imageEditor = {
            legacyDataToImageState: pintura.legacyDataToImageState,
            createEditor: pintura.openEditor,
            imageReader: [pintura.createDefaultImageReader],
            imageWriter: [pintura.createDefaultImageWriter],
            imageProcessor: pintura.processImage,
            editorOptions: {
                imageOrienter: pintura.createDefaultImageOrienter(),
                previewUpscale: true,
                ...pintura.plugin_finetune_defaults,
                ...pintura.plugin_filter_defaults,
                locale: {
                    ...pintura.locale_en_gb,
                    ...pintura.plugin_crop_locale_en_gb,
                    ...pintura.plugin_finetune_locale_en_gb,
                    ...pintura.plugin_filter_locale_en_gb,
                },
            },
        }
        $('.filepond').on('pintura:load', (e) => {
            // Handle event
            console.log('Image loaded', e.detail);
        });
    }
</script>
{{-- FEATURE FUNCTIONS --}}
<script>
    $(document).on('change','.feature_radio',function(){
        var the = $(this);
        var value = the.closest('.custom_radio_section').find('input[type=radio]:checked').val();
        console.log(value);
        var get_url = $('#base_url').val();
        $.ajax({
            type:'post',
            url:get_url+'/get-feature-options-ajax',
            data:{
                f_feature_master:value,
            },
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                console.log(data);
                if(data.status == 1 ){
                    // the.closest('.custom_radio_section').find('.feature_list_select2').select2({data: [{id: '', text: ''}]});
                    the.closest('.custom_radio_section').find('.feature_list_select2').html('');
                    the.closest('.custom_radio_section').find('.feature_list_select2').select2({
                        data: data.data,
                        tags: true,
                        maximumSelectionLength: 10,
                        tokenSeparators: [',', ' '],
                        allowClear: true,
                        scrollAfterSelect: false,
                        placeholder: "Select or type keywords",
                        createTag: function (params) {
                            return null;
                        },
                    });
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
        var slug = $(this).attr('name');
        if(variable_array_list[slug].attr){
            variable_array_list[slug].attr      = [];
            variable_array_list[slug].attr_ids  = [];
            variant_combo.combo_text            = [];
            variant_combo.combo_id              = [];
            variant_combo.is_color              = [];
            variant_combo.combo_combo           = [];
            $('#product_variants').find('tbody').html('');
        }
        console.log(variable_array_list);
    });
    $(document).on('select2:select','.feature_list_select2', function (e) {
        var slug = $(this).attr('name');
        var text = e.params.data.text;
        var id   = e.params.data.id;
        if(text){
            if(variable_array_list[slug].attr.indexOf(text) === -1){
                variable_array_list[slug].attr.push(text);
                variable_array_list[slug].attr_ids.push(id);

                var other_slug = variable_array_name.filter(function(f) { return f !== slug }); //variable_array_name array slug
                // var array_insert_index = [];
                if (other_slug.length > 0) {
                    genNewVariants = variable_array_list[other_slug].attr;
                    for (let i = 0; i < genNewVariants.length; i++) {
                        var insert_index = find_index(variant_combo.combo_combo,variant_combo.combo_combo.length,genNewVariants[i]+text);
                        variant_combo.combo_text.splice(insert_index, 0, [genNewVariants[i],text]);
                        variant_combo.combo_id.splice(insert_index, 0, [variable_array_list[other_slug].attr_ids[i],id]);
                        variant_combo.is_color.splice(insert_index, 0, [variable_array_list[other_slug].is_color,variable_array_list[slug].is_color]);
                        variant_combo.combo_combo.splice(insert_index, 0, genNewVariants[i]+text);
                        // array_insert_index.push(insert_index);
                        console.log(variant_combo);
                        generate_variants(insert_index,'add',[]);
                        // array_insert_index = adjust_inserted_array(array_insert_index,insert_index);
                    }
                }else{
                    var insert_index = find_index(variant_combo.combo_combo,variant_combo.combo_combo.length,text);
                    variant_combo.combo_text.splice(insert_index, 0, [text]);
                    variant_combo.combo_combo.splice(insert_index, 0, [text]);
                    variant_combo.combo_id.splice(insert_index, 0, [id]);
                    variant_combo.is_color.splice(insert_index, 0, [variable_array_list[slug].is_color]);
                    // array_insert_index.push(insert_index);
                    // array_insert_index = adjust_inserted_array(insert_index,insert_index);
                    generate_variants(insert_index,'add',[]);
                }
            }
        }
        console.log(variable_array_list.length);
    });
    $(document).on('select2:unselect','.feature_list_select2', function (e) {
        var slug = $(this).attr('name');
        var text = e.params.data.text;
        var id   = e.params.data.id;
        console.log(text);
        if(text){
            if(variable_array_list[slug].attr.indexOf(text) !== -1){
                var to_remove_combo = [];
                variable_array_list[slug].attr.splice(variable_array_list[slug].attr.indexOf(text), 1);
                variable_array_list[slug].attr_ids.splice(variable_array_list[slug].attr_ids.indexOf(id), 1);
                // variant_combo.combo = variant_combo.combo.filter(subarr => !subarr.includes(text));
                console.log(variant_combo);
                for (let i = 0; i < variant_combo.combo_text.length; i++) {
                    console.log(i);
                    if (variant_combo.combo_text[i].includes(text)) {
                        console.log(variant_combo.combo_text[i]);
                        to_remove_combo.push(i);
                        // variant_combo.combo_text.splice(i,1);
                        // variant_combo.combo_id.splice(i,1);
                        // variant_combo.is_color.splice(i,1);
                        // variant_combo.combo_combo.splice(i,1);
                    }
                }
                generate_variants([],'remove',to_remove_combo);
                console.log(variant_combo);
            }
        }
        console.log(variable_array_list);
    });
    $(document).on('change','.feature_dropdown.add_new', function() {
        var value = $(this).find("option:selected").val();
        var text = $(this).find("option:selected").text();
        if(value){
            var slug = $(this).attr('name');
            // var variable_array_list = $('#variable_array_list').val();
            if(variable_array_list[slug].attr.indexOf(text) === -1){
                variable_array_list[slug].attr.push(text);
                variable_array_list[slug].attr_ids.push(value);
                console.log(variable_array_list);
                $(this).closest('.append_feature_dropdown').find('.feature_dropdown').removeClass('add_new');
                $(this).closest('.append_feature_dropdown').find('.feature_dropdown_hidden select').addClass('feature_dropdown add_new');
                $(this).closest('.append_feature_dropdown').append($(this).closest('.append_feature_dropdown').find('.feature_dropdown_hidden').html());
                $(this).closest('.append_feature_dropdown').find('.feature_dropdown_hidden select').removeClass('feature_dropdown add_new');
                $('.feature_dropdown').select2({width: '100%'});

                var other_slug = variable_array_name.filter(function(f) { return f !== slug }); //variable_array_name array slug
                // var array_insert_index = [];
                if (other_slug.length > 0) {
                    genNewVariants = variable_array_list[other_slug].attr;
                    for (let i = 0; i < genNewVariants.length; i++) {
                        if (variable_array_list[slug].is_color == 1) {
                            var array_txt = [text,genNewVariants[i]];
                            var array_combo = text+genNewVariants[i];
                            var array_id  = [value,variable_array_list[other_slug].attr_ids[i]];
                            var array_color = [1,0];
                        }else{
                            var array_txt = [genNewVariants[i],text];
                            var array_combo = genNewVariants[i]+text;
                            var array_id  = [variable_array_list[other_slug].attr_ids[i],value];
                            var array_color = [0,1];
                        }
                        var insert_index = find_index(variant_combo.combo_combo,variant_combo.combo_combo.length,array_combo);
                        variant_combo.combo_text.splice(insert_index, 0, array_txt);
                        variant_combo.combo_id.splice(insert_index, 0, array_id);
                        variant_combo.is_color.splice(insert_index, 0, array_color);
                        variant_combo.combo_combo.splice(insert_index, 0, array_combo);
                        // array_insert_index.push(insert_index);
                        // array_insert_index = adjust_inserted_array(array_insert_index,insert_index);
                        console.log(variant_combo);
                        generate_variants(insert_index,'add',[]);
                    }
                }else{
                    var insert_index = find_index(variant_combo.combo_combo,variant_combo.combo_combo.length,text);
                    variant_combo.combo_text.splice(insert_index, 0, [text]);
                    variant_combo.combo_id.splice(insert_index, 0, [value]);
                    variant_combo.is_color.splice(insert_index, 0, [variable_array_list[slug].is_color]);
                    variant_combo.combo_combo.splice(insert_index, 0, [text]);
                    generate_variants(insert_index,'add',[]);
                    // array_insert_index.push(insert_index);
                    // array_insert_index = adjust_inserted_array(array_insert_index,insert_index);
                }
                console.log(variant_combo);
            }else{
                toastr.warning('Duplicate value, please modify !','Warning');
                console.log('Duplicate value, please modify !');
                $(this).val(previous_value).trigger('change.select2');
            }
        }
    });
    $(document).on('select2:selecting','.feature_dropdown.add_new', function () {
        var text = $(this).find("option:selected").text();
        var slug = $(this).attr('name');
        var value = $(this).find("option:selected").val();
        index = variable_array_list[slug].attr.indexOf(text);
        console.log('index '+index);
        if(index !== -1){
            previous_value  = value;
            previous_text   = text;
        }
        console.log('previous_value '+previous_value);
    });
    $(document).on('select2:selecting','.feature_dropdown:not(.add_new)', function () {
        var text = $(this).find("option:selected").text();
        var slug = $(this).attr('name');
        var value = $(this).find("option:selected").val();
        index = variable_array_list[slug].attr.indexOf(text);
        textOfindex = text;

        console.log('index '+index);
        if(index !== -1){
            previous_value  = value;
            previous_text   = text;
        }
        console.log('previous_value '+previous_value);
    });
    $(document).on('change','.feature_dropdown:not(.add_new)',function () {
        var slug = $(this).attr('name');
        var text = $(this).find("option:selected").text();
        var value = $(this).find("option:selected").val();
        if(value){
            if(variable_array_list[slug].attr.indexOf(text) === -1){
                variable_array_list[slug].attr.splice(index, 1);
                variable_array_list[slug].attr.splice(index, 0, text);
                variable_array_list[slug].attr_ids.splice(index, 1);
                variable_array_list[slug].attr_ids.splice(index, 0, value);

                // var array_insert_index = [];
                if (variable_array_name.length > 1) {
                    var combo_length = variant_combo.combo_text.length;
                    console.log('combo length '+ combo_length);
                    var loop = 0;
                    for (let i = 0; i < variant_combo.combo_text.length; ) {
                        console.log('line 1409  '+textOfindex);
                        console.log('line 1410 '+i);
                        console.log(variant_combo.combo_text[i]);
                        if (variant_combo.combo_text[i].includes(textOfindex)) {
                            var indextoreplace = variant_combo.combo_text[i].indexOf(textOfindex);
                            console.log('line 1412  '+indextoreplace);
                            if (indextoreplace !== -1) {
                                variant_combo.combo_text[i][indextoreplace] = text;
                                variant_combo.combo_id[i][indextoreplace] = value;
                                var new_array_text = variant_combo.combo_text[i];
                                var new_array_id = variant_combo.combo_id[i];
                                var new_array_color = variant_combo.is_color[i];
                                var new_array_combo = variant_combo.combo_text[i][0]+variant_combo.combo_text[i][1];
                                console.log('line 1420');
                                console.log(variant_combo.combo_text[i]);                                ;
                                $('#product_variants tbody tr').eq(i).find("td").eq(1).html('<div class="next-table-cell-wrapper"><div class="" style="display: flex; flex-direction: column;" target="_blank"><div type="text"><span class="show-text">'+variant_combo.combo_text[i][0]+'</span></div></div></div>');
                                $('#product_variants tbody tr').eq(i).find("td").eq(2).html('<div class="next-table-cell-wrapper"><div class="" style="display: flex; flex-direction: column;" target="_blank"><div type="text"><span class="show-text">'+variant_combo.combo_text[i][1]+'</span></div></div></div>');
                                var tr = $('#product_variants tbody tr').eq(i);
                                variant_combo.combo_text.splice(i, 1);
                                variant_combo.combo_id.splice(i, 1);
                                variant_combo.is_color.splice(i, 1);
                                variant_combo.combo_combo.splice(i, 1);
                                var insert_index = find_index(variant_combo.combo_combo,variant_combo.combo_combo.length,new_array_combo);
                                console.log('line 1431');
                                console.log(insert_index);
                                console.log(new_array_combo);
                                console.log(variant_combo.combo_combo);
                                variant_combo.combo_text.splice(insert_index, 0, new_array_text);
                                variant_combo.combo_combo.splice(insert_index, 0, new_array_combo);
                                variant_combo.combo_id.splice(insert_index, 0, new_array_id);
                                variant_combo.is_color.splice(insert_index, 0, new_array_color);
                                // $('#product_variants tbody tr').eq(insert_index).prepend(tr);
                                if (insert_index <= i) {
                                    if (insert_index == 0) {
                                        console.log('line 1504');
                                        $('#product_variants tbody').prepend(tr);
                                    }else if($('#product_variants tbody tr').length <= insert_index){
                                        console.log('line 1506');
                                        $('#product_variants tbody').append(tr);
                                    }else{
                                        console.log('line 1510');
                                        $('#product_variants tbody tr').eq(insert_index).before(tr);
                                    }
                                }else{
                                    if (insert_index == 0) {
                                        console.log('line 1514');
                                        $('#product_variants tbody').prepend(tr);
                                    }else if($('#product_variants tbody tr').length <= insert_index){
                                        console.log('line 1516');
                                        $('#product_variants tbody').append(tr);
                                    }else{
                                        console.log('line 1520');
                                        console.log(tr);
                                        $('#product_variants tbody tr').eq(parseInt(insert_index)).after(tr);
                                    }
                                }
                                console.log('line 1435');
                            }
                        }
                        i++;
                        console.log('line 1449 '+ i);
                        if(i == combo_length){
                            loop++;
                            console.log('line 1452 '+ loop);
                            if (loop < combo_length) {
                                i = 0;
                            }
                        }
                    }
                }else{
                    console.log('line 1483 '+textOfindex);
                    for (let i = 0; i < variant_combo.combo_text.length;i++ ) {
                        if (variant_combo.combo_text[i].includes(textOfindex)) {
                            variant_combo.combo_text[i][0] = text;
                            variant_combo.combo_id[i][0] = value;
                            var new_array_text = variant_combo.combo_text[i];
                            var new_array_id = variant_combo.combo_id[i];
                            var new_array_color = variant_combo.is_color[i];
                            var new_array_combo = variant_combo.combo_text[i];
                            console.log('line 1494 '+variant_combo.combo_text[i]);
                            $('#product_variants tbody tr').eq(i).find("td").eq(1).html('<div class="next-table-cell-wrapper"><div class="" style="display: flex; flex-direction: column;" target="_blank"><div type="text"><span class="show-text">'+variant_combo.combo_text[i][0]+'</span></div></div></div>');
                            var tr = $('#product_variants tbody tr').eq(i);
                            variant_combo.combo_text.splice(i, 1);
                            variant_combo.combo_id.splice(i, 1);
                            variant_combo.is_color.splice(i, 1);
                            variant_combo.combo_combo.splice(i, 1);
                            var insert_index = find_index(variant_combo.combo_combo,variant_combo.combo_combo.length,new_array_combo);
                            console.log('line 1500');
                            console.log(insert_index);
                            variant_combo.combo_text.splice(insert_index, 0, new_array_text);
                            variant_combo.combo_combo.splice(insert_index, 0, new_array_combo);
                            variant_combo.combo_id.splice(insert_index, 0, new_array_id);
                            variant_combo.is_color.splice(insert_index, 0, new_array_color);
                            if (insert_index == 0) {
                                console.log('line 1514');
                                $('#product_variants tbody').prepend(tr);
                            }else if($('#product_variants tbody tr').length <= insert_index){
                                console.log('line 1516');
                                $('#product_variants tbody').append(tr);
                            }else{
                                console.log('line 1520');
                                console.log(tr);
                                $('#product_variants tbody tr').eq(parseInt(insert_index)).after(tr);
                            }
                        }
                    }
                }
                console.log(variant_combo);
                console.log(variable_array_list);
            }else{
                toastr.warning('Duplicate value, please modify !','Warning');
                console.log('Duplicate value, please modify !');
                console.log('line 1318 '+previous_value);
                $(this).val(previous_value).trigger('change.select2');
            }
        }
    });
    $(document).on('click','.sku-delete .la-trash',function () {
        var row_index = $(this).closest('tr').index();
        $('#product_variants tbody tr').eq(row_index).fadeOut('slow');
        $('#product_variants tbody tr').eq(row_index).remove();
        variant_combo.combo_text.splice(row_index,1);
        variant_combo.combo_id.splice(row_index,1);
        variant_combo.is_color.splice(row_index,1);
        variant_combo.combo_combo.splice(row_index,1);
        console.log(row_index);
    });
    $(document).on('click','.feature_dropdown_trash',function () {
        var slug = $(this).closest('.form-repeat').find('.feature_dropdown').attr('name');
        var to_delete_text = $(this).closest('.form-repeat').find('.feature_dropdown').find("option:selected").text();
        var to_delete_id = $(this).closest('.form-repeat').find('.feature_dropdown').find("option:selected").val();
        console.log(to_delete_id);
        if(variable_array_list[slug].attr.indexOf(to_delete_text) !== -1){
            var to_remove_combo = [];
            variable_array_list[slug].attr.splice(variable_array_list[slug].attr.indexOf(to_delete_text), 1);
            variable_array_list[slug].attr_ids.splice(variable_array_list[slug].attr_ids.indexOf(to_delete_id), 1);
            $(this).closest('.form-repeat').fadeOut().remove();
            // variant_combo.combo_text = variant_combo.combo_text.filter(subarr => !subarr.includes(to_delete_text));
            for (let i = 0; i < variant_combo.combo_text.length; i++) {
                if (variant_combo.combo_text[i].includes(to_delete_text)) {
                    console.log(variant_combo.combo_text[i]);
                    to_remove_combo.push(i);
                }
            }
            generate_variants(1,'remove',to_remove_combo);
            console.log(variant_combo);
        }
    });
    function generate_variants(to_insert_index,type,to_remove_combo) {
        var get_url = $('#base_url').val();
        if(variant_combo.combo_text !== null && variant_combo.combo_text.length > 0){
            if (type == 'add') {
                var html = generate_variant_html(variant_combo['combo_combo'][to_insert_index],variant_combo['combo_text'][to_insert_index]);
                if (variable_array_name !== null) {
                    $('#product_variants').find('tbody #variant_gemerated_forst_row').remove();
                    if (to_insert_index == 0) {
                        console.log('line 1504');
                        $('#product_variants').find('tbody').prepend(html);
                    }else if($('#product_variants tbody tr').length <= to_insert_index){
                        console.log('line 1506');
                        $('#product_variants').find('tbody').append(html);
                    }else{
                        console.log('line 1510');
                        $('#product_variants tbody tr').eq(to_insert_index-1).after(html);
                    }
                }
            }else if(type == 'remove'){
                console.log(to_remove_combo);
                for (let i = 0; i < to_remove_combo.length; i++) {
                    if (i == 0) {
                        $('#product_variants tbody tr').eq(to_remove_combo[i]).fadeOut('slow');
                        $('#product_variants tbody tr').eq(to_remove_combo[i]).remove();
                        variant_combo.combo_text.splice(to_remove_combo[i],1);
                        variant_combo.combo_id.splice(to_remove_combo[i],1);
                        variant_combo.is_color.splice(to_remove_combo[i],1);
                        variant_combo.combo_combo.splice(to_remove_combo[i],1);
                    }else{
                        $('#product_variants tbody tr').eq(to_remove_combo[i]-i).fadeOut('slow');
                        $('#product_variants tbody tr').eq(to_remove_combo[i]-i).remove();
                        variant_combo.combo_text.splice(to_remove_combo[i]-i,1);
                        variant_combo.combo_id.splice(to_remove_combo[i]-i,1);
                        variant_combo.is_color.splice(to_remove_combo[i]-i,1);
                        variant_combo.combo_combo.splice(to_remove_combo[i]-i,1);
                    }
                }
                console.log(variant_combo);
            }
        }
    }
    // Function to find insert position of K
    function find_index(arr, n, K){
        // Traverse the array
        for (var i = 0; i < n; i++){
            // If K is found
            if (arr[i] == K)
                return i;
            // If current array element
            // exceeds K
            else if (arr[i] > K)
                return i;
        }
        // If all elements are smaller
        // than K
        return n;
    }
    function adjust_inserted_array(array,new_val) {
        console.log(array);
        console.log(new_val)
        // var array = [];
        if (array.length > 1) {
            array = array.slice(0, -1);
            console.log(array);
            for (let i = 0; i < array.length; i++) {
                if (new_val < array[i]) {
                    array[i]++;
                }
            }
            array.push(new_val);
        }
        console.log(array);
        return array;
    }
    function generate_variant_html(id,name) {
        var html =
        '<tr class="next-table-row first" role="row" id='+id+'>'+
            '<td class="next-table-cell first" style="text-align: center;">'+
                '<div class="next-table-cell-wrapper">'+
                    '<div class="custom-control custom-switch custom-switch-lg">'+
                        '<input type="checkbox" name="is_active_variant[]" value="1" class="custom-control-input variant_inputs" id="variantcustomSwitch'+id+'" checked>'+
                        '<label class="custom-control-label" for="variantcustomSwitch'+id+'"></label>'+
                    '</div>'+
                '</div>'+
            '</td>';
            if (name[0] !== undefined){
                html += '<td class="" style="text-align: center;" >'+
                '<div class="next-table-cell-wrapper">'+
                    '<div class="" style="display: flex; flex-direction: column;" target="_blank">'+
                        '<div type="text"><span class="show-text">'+name[0]+'</span>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</td>';
            }
            if (name[1] !== undefined){
                html += '<td class="" style="text-align: center;" >'+
                '<div class="next-table-cell-wrapper">'+
                    '<div class="" style="display: flex; flex-direction: column;" target="_blank">'+
                        '<div type="text"><span class="show-text">'+name[1]+'</span>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</td>';
            }
            html += '<td class="" style="text-align: center;">'+
                '<div class="next-table-cell-wrapper">'+
                    '<div class="form-group m-0">'+
                        '<input type="number" required="" name="price[]" autocomplete="off" value="" height="100%" class="form-control variant_inputs">'+
                    '</div>'+
                '</div>'+
            '</td>'+
            '<td class="" style="text-align: center;">'+
                '<div class="next-table-cell-wrapper">'+
                    '<div class="form-group m-0">'+
                        '<input type="number" name="special_price[]" autocomplete="off" value="" height="100%" class="form-control">'+
                    '</div>'+
                '</div>'+
            '</td>'+
            '<td class="" style="text-align: center;">'+
                '<div class="next-table-cell-wrapper">'+
                    '<div class="form-group m-0">'+
                        '<input type="number" name="installment_price[]" autocomplete="off" value="" height="100%" class="form-control">'+
                    '</div>'+
                '</div>'+
            '</td>'+
            '<td class="" style="text-align: center;">'+
                '<div class="next-table-cell-wrapper">'+
                    '<div class="form-group m-0">'+
                        '<input type="number" name="wholesale_price[]" autocomplete="off" value="" height="100%" class="form-control">'+
                    '</div>'+
                '</div>'+
            '</td>'+
            '<td class="" style="text-align: center;" >'+
                '<div class="next-table-cell-wrapper">'+
                    '<input type="text" name="barcode[]" autocomplete="off" value="" height="100%" class="form-control">'+
                '</div>'+
            '</td>'+
            '<td class="next-table-cell sku-row-action" style="text-align: center;">'+
                '<div class="next-table-cell-wrapper">'+
                    '<div class="sku-delete"><i class="la la-trash"></i></div>'+
                '</div>'+
            '</td>'+
        '</tr>';
        return html;
    }

    $('#cat_name').on('keyup keydown paste',function(){
        var str = $(this).val();
        $("#meta_title").val(str);
        $("#meta_description").val(str);
        return str;
    })

    //////////////////////ADD NEW CATEGORY SECTION ///////////////////
    function category_html() {
        return '<div class="row category_row">'
            +'<div class="col-md-8">'
                +'{!! Form::hidden("category[]", null, ["id" => "selected_category_id"]) !!}'
                +'<div class="form-group mb-2 {!! $errors->has("category") ? "error" : "" !!}">'
                    +'<div class="controls pt-2">'
                        +'{!! Form::text("", null, [ "class" => "form-control mb-1 validate category", "placeholder" => "Enter category name", "data-validation-required-message" => "This field is required","required", "id" => "category","onkeydown"=>"return false;"]) !!}'
                        {!! $errors->first("category", "<label class='help-block text-danger'>:message</label>") !!}
                        +'<div class="overlay-wrapper">'
                            +'<div class="row">'
                                +'<div class="col-md col1">'
                                    +'<div id="" class="cat-filter-section">'
                                        +'<fieldset class="form-group position-relative has-icon-left">'
                                            +'<input type="text" class="form-control form-control-sm input-sm filter_category" id="" placeholder="Keyword">'
                                            +'<div class="form-control-position">'
                                                +'<i class="la la-search"></i>'
                                            +'</div>'
                                        +'</fieldset>'
                                        +'<ul>'
                                            @foreach ($categories as $category)
                                            +'<li data-cat_pk="{{ $category->PK_NO }}" data-cat_name="{{ $category->NAME }}" title="{{ $category->NAME }}">'
                                                +'<p class="m-0">{{ $category->NAME }}</p>'
                                                @if(isset($category->subcategories))
                                                +'<i class="la la-angle-right" style="float:right;line-height: inherit;"></i>'
                                                @endif
                                            +'</li>'
                                            @endforeach
                                        +'</ul>'
                                    +'</div>'
                                +'</div>'
                                +'<div class="col-md col1 pl-0"></div>'
                                +'<div class="col-md col1 pl-0"></div>'
                            +'</div>'
                            +'<div class="row mt-3">'
                                +'<div class="col-md-6">'
                                    +'<button type="button" class="btn btn-info" title="Confirm" id="confirm_category" data-status="add" disabled>Confirm</button>'
                                    +'<button type="button" class="btn btn-danger" title="Close" id="close_category_overlay">Close</button>'
                                    +'<button type="button" class="btn btn-primary" title="Clear" id="clear_category_overlay">Clear</button>'
                                +'</div>'
                            +'</div>'
                        +'</div>'
                    +'</div>'
                +'</div>'
            +'</div>'
            +'<div class="col-md-1 pl-0">'
                +'<i class="la la-trash category_dropdown_trash"></i>'
            +'</div>'
        +'</div>';
    }
    $(document).on('click','.add_new_category',function(){
        var length = $(".category_row").length;
        if (length <= 2) {
            var html = category_html();
            $('.append_new_category').append(html);
        }else{
            toastr.warning('Can not add more than 2 additional category !','Warning');
        }
    })
</script>
@endpush('custom_js')
