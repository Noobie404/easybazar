@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/file_upload/image-uploader.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/file_upload/image-uploader.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/editors/summernote.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<style>
    .word-counter {position:absolute;bottom: 6px;right:88px;z-index: 9;}
    .word-counter-bn {position:absolute;bottom: 27px;right:20px;}
    #cat_name{padding-right: 60px;}
    #bn_name{padding-right: 60px;}
    #category {position: relative;}
    .overlay-wrapper{display: none;position: absolute;width: 1200px;background: #fff;border: 1px solid #ccc;padding: 5px;z-index: 9;padding: 15px 10px;}
    .overlay-wrapper ul{padding-left: 0px;height: 180px;overflow-y: scroll;}
    .overlay-wrapper ul li{white-space: nowrap;text-overflow: ellipsis;overflow: hidden;list-style: none;padding: 0px 10px;line-height: 30px;line-height: 30px;cursor: pointer;display: flex;}
    .overlay-wrapper ul li:hover{background: #f4f4f4}
    .overlay-wrapper ul li p{white-space: nowrap;text-overflow: ellipsis;overflow: hidden;width: 170px;}
    .charBold {font-weight: bold;color: red;}
    .cat-filter-section{border: 1px solid #ccc;padding: 15px;}
    #description_more {background: #ddd;height: 43px;line-height: 3;text-align: center;cursor: pointer}
</style>
@endpush('custom_css')
@section('Product Management','open')
@section('product_list','active')
@section('title') @lang('product.add_new_product') @endsection
@section('page-name') @lang('product.add_new_product') @endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin_role.breadcrumb_title')  </a></li>
<li class="breadcrumb-item active">Product Publish    </li>
@endsection
<?php
$vat_class_combo    = $data['vat_class_combo'] ?? [];
$brand_combo        = $data['brand_combo'] ?? [];
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
                        {!! Form::open([ 'route' => 'product.category.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                <label>Product name<span class="text-danger">*</span></label>
                                <div class="input-group">
                                        {!! Form::text('name', null, [ 'class' => 'form-control', 'placeholder' => 'Enter category name', 'data-validation-required-message' => 'This field is required','maxlength' => "255", 'tabindex' => $tab_index++,'id' => 'cat_name' ]) !!}
                                        {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                        <div class="word-counter">0/255</div>
                                        <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="translate"><i class='fa fa-spinner fa-spin' style="display: none"></i>  Translate</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group {!! $errors->has('bn_name') ? 'error' : '' !!}">
                                    <label>Product name in bengali</label><span class="text-danger">*</span>
                                    <div class="controls pt-2">
                                        {!! Form::text('bn_name', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter category name', 'data-validation-required-message' => 'This field is required','maxlength' => "255", 'tabindex' => $tab_index++,'id' => 'bn_name' ]) !!}
                                        {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                        <div class="word-counter-bn">0/255</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group {!! $errors->has('category') ? 'error' : '' !!}">
                                    <label>Choose category</label><span class="text-danger">*</span>
                                    <div class="controls pt-2">
                                        {!! Form::text('category', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter category name', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tab_index++,'id' => 'category','onkeydown'=>'return false;']) !!}
                                        {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                        <div class="overlay-wrapper">
                                            <div class="row">
                                                <div class="col-md-3">
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
                                                <div class="col-md-3 pl-0"></div>
                                                <div class="col-md-3 pl-0"></div>
                                                <div class="col-md-3 pl-0"></div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-info" title="Confirm" id="confirm_category" disabled>Confirm</button>
                                                    <button type="button" class="btn btn-danger" title="Close" id="close_category_overlay">Close</button>
                                                    <button type="button" class="btn btn-primary" title="Clear" id="clear_category_overlay">Clear</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                        {!! Form::select('is_feature', ['0'=> 'No','1'=> 'Yes'], Null,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tab_index++]) !!}
                                        {!! $errors->first('is_feature', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <label for=""><strong>Product Attributes <span class="text-danger">*</span></strong></label>
                                        <div id="product_arrtibutes">

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
                                <div class="form-group {!! $errors->has('meta_title') ? 'error' : '' !!}">
                                <label>Meta title</label>
                                <div class="controls">
                                    {!! Form::text('meta_title', null, [ 'class' => 'form-control', 'placeholder' => 'Enter meta title', 'tabindex' => $tab_index++]) !!}
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
                                    {!! Form::text('meta_keywards', null, [ 'class' => 'form-control', 'placeholder' => 'Enter meta keyward', 'tabindex' => $tab_index++,'rows'=>'4','cols'=>'10' ]) !!}
                                    {!! $errors->first('meta_keywards', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-field">
                                        <label class="active">Banner/Slider<span class="img-note d-inline-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}}  800 x 800 pixels</span></label>
                                        <div class="prod_def_photo_upload" style="padding-top: .5rem;" title="Click for photo upload"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                                <label class="active">Thumbnail image</label>
                                <div class="controls">
                                    <div class="fileupload @if(!empty($category->thumbnail_image))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                        <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                        @if(!empty($category->thumbnail_image))
                                        <img src="{{asset($category->thumbnail_image)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                        @endif
                                        </span>
                                        <span>
                                        <label class="btn btn-primary btn-rounded btn-file btn-sm">
                                        <span class="fileupload-new">
                                        <i class="la la-file-image-o"></i> Select image
                                        </span>
                                        <span class="fileupload-exists">
                                        <i class="la la-reply"></i> Change
                                        </span>
                                        {!! Form::file('thumbnail_image', Null,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'IS ACTIVE', 'tabindex' => $tab_index++]) !!}
                                        </label>
                                        <a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                        <i class="la la-times"></i> Remove
                                        </a>
                                        </span>
                                        <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}}  500 x 372 pixels</span>
                                    </div>
                                    {!! $errors->first('feature_image', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                                <label class="active">Banner image</label>
                                <div class="controls">
                                    <div class="fileupload @if(!empty($category->banner_image))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                        <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                        @if(!empty($category->banner_image))
                                        <img src="{{asset($category->banner_image)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                        @endif
                                        </span>
                                        <span>
                                        <label class="btn btn-primary btn-rounded btn-file btn-sm">
                                        <span class="fileupload-new">
                                        <i class="la la-file-image-o"></i> Select image
                                        </span>
                                        <span class="fileupload-exists">
                                        <i class="la la-reply"></i> Change
                                        </span>
                                        {!! Form::file('banner_image', Null,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'IS ACTIVE', 'tabindex' => $tab_index++]) !!}
                                        </label>
                                        <a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                        <i class="la la-times"></i> Remove
                                        </a>
                                        </span>
                                        <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}}  1920 x 145 pixels</span>
                                    </div>
                                    {!! $errors->first('feature_image', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                                <label class="active">Icon image</label>
                                <div class="controls">
                                    <div class="fileupload @if(!empty($category->icon))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                        <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                        @if(!empty($category->icon))
                                        <img src="{{asset($category->icon)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                        @endif
                                        </span>
                                        <span>
                                        <label class="btn btn-primary btn-rounded btn-file btn-sm">
                                        <span class="fileupload-new">
                                        <i class="la la-file-image-o"></i> Select image
                                        </span>
                                        <span class="fileupload-exists">
                                        <i class="la la-reply"></i> Change
                                        </span>
                                        {!! Form::file('icon', Null,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'IS ACTIVE', 'tabindex' => $tab_index++]) !!}
                                        </label>
                                        <a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                        <i class="la la-times"></i> Remove
                                        </a>
                                        </span>
                                        <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}}  60 x 60 pixels</span>
                                    </div>
                                    {!! $errors->first('feature_image', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-center mt-3">
                            <a href="{{ route('product.category.list') }}">
                            <button type="button" class="btn btn-warning mr-1" title="Cancel">
                            <i class="ft-x"></i> @lang('form.btn_cancle')
                            </button>
                            </a>
                            <button type="submit" class="btn btn-primary" title="Save">
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
<script type="text/javascript" src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/file_upload/image-uploader.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/js/editors/summernote/summernote.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/scripts/editors/editor-summernote.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/pages/product.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
<script>
    $(document).ready(function() {
        var count = 0;
        var cat_names = [];
        var cat_pks  = [];
        var attribute = 0;
        var short_description_en = '';
        var short_description_bn = '';
        var elt = $('.input-tags'+attribute);
        $(document).on('itemRemoved','[id*=input-tags]', function(event) {
            var tag_id = $(this).data('tag_id');
            // if (!event.options || !event.options.preventPost) {
            //     if ($(this).val() !== '') {
            //         $('#selected_attr_section'+tag_id).fadeIn();
            //     }else{
            //         $('#selected_attr_section'+tag_id).fadeOut();
            //     }
            // }
        });
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
    $('#category').click(function(e){
        e.stopPropagation();
        e.preventDefault();
        $('.overlay-wrapper').fadeIn('slow');
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
        $(this).closest('.cat-filter-section').find('ul li').css({'background' : 'transparent','border-left':'none'});
        $(this).css({'background' : '#e3e3e3','border-left': '3px solid #f60'});
        var get_url = $('#base_url').val();
        var cat_pk = $(this).data('cat_pk');
        var cat_name = $(this).data('cat_name');
        var the = $(this);
        the.closest("ul").find('li').each(function (i,row) {
            $(row).removeClass('clicked');
        });
        $(this).addClass('clicked');
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
                the.closest('.col-md-3').nextAll().html('');
                if(data.status == 1 ){
                    the.closest('.col-md-3').nextAll().html('');
                    the.closest('.col-md-3').next().html(data.html);
                    $('#confirm_category').attr('disabled',true);
                }else if(data.status == 2){
                    alert('Please contact with admin !');
                }else{
                    $('#confirm_category').attr('disabled',false);
                }
                cat_names = [];
                cat_pks  = [];
                $('.overlay-wrapper').find('.col-md-3').each(function (i,row) {
                    var rows = $(row);
                    rows.find('ul li').each(function (i,row2) {
                        if ($(row2).hasClass('clicked')) {
                            cat_pks.push($(row2).data('cat_pk'));
                            cat_names.push($(row2).data('cat_name'));
                        }
                    });
                });
                // the.closest("ul").find('li').each(function (i,row) {
                //     var rows = $(row);
                //     if($.inArray(rows.data('cat_pk'),cat_pks) > 0){
                //         var index = cat_pks.indexOf(rows.data('cat_pk'));
                //         if (index > -1) {
                //             cat_pks.splice(index, 1);
                //             cat_names.splice(index, 1);
                //         }
                //     }
                // });
                // if($.inArray(cat_pk,cat_pks) == -1){
                //     cat_pks.push(cat_pk);
                //     cat_names.push(cat_name);
                // }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    });
    $(document).on('click','#close_category_overlay',function(){
        $('.overlay-wrapper').fadeOut('slow');
    });
    $(document).on('click','#clear_category_overlay',function(){
        cat_names = [];
        cat_pks  = [];
        $('#category').val('');
        $('.overlay-wrapper').find('.col-md-3').each(function (i,row) {
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
        $('#category').val(category_list);
        var get_url = $('#base_url').val();
        $.ajax({
            type:'post',
            url:get_url+'/category-related-attributes',
            data:{
                category:cat_pks.at(-1)
            },
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                if(data.status == 1 ){
                    $('#product_arrtibutes').html('');
                    $('#product_arrtibutes').html(data.html);
                    $('.select2').select2();
                    $('.overlay-wrapper').fadeOut('slow');
                    // $('[id*=input-tags]').tagsinput();
                    $('[id*=input_tags]').find('.bootstrap-tagsinput input').hide();
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
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
    })
 </script>
 @endpush('custom_js')
