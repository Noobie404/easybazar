@extends('admin.layout.master')
<?php
$tab_index = 1;
$attr = $data['attr'] ?? [];
$feature = $data['feature'] ?? [];
$categories = $data['categories'] ?? [];
?>
@section('Product Management','open')
@section('product category','active')
@section('title')
Create product category
@endsection
@section('page-name')
Create product category
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin_role.breadcrumb_title')  </a></li>
<li class="breadcrumb-item active">@lang('category.breadcrumb_sub_title')    </li>
@endsection
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/file_upload/image-uploader.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/editors/summernote.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<style>
    .word-counter {position:absolute;bottom: 6px;right:88px;z-index: 9;}
    .word-counter-bn {position:absolute;bottom: 27px;right:20px;}
    #cat_name{padding-right: 60px;}
    #bn_name{padding-right: 60px;}
    .optionChild{font-style: italic;}
</style>
@endpush('custom_css')
@section('content')
<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card card-success min-height">
                <div class="card-content collapse show">
                    <div class="card-body">
                        {!! Form::open([ 'route' => 'product.category.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                <label>@lang('form.name')<span class="text-danger">*</span></label>
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
                            <div class="col-md-6">
                                <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                    <label>Url slug</label>
                                    <div class="controls">
                                        {!! Form::text('url_slug', null, [ 'class' => 'form-control', 'placeholder' => 'Enter url slug','id'=>'url_slug', 'tabindex' => $tab_index++ ]) !!}
                                        {!! $errors->first('url_slug', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {!! $errors->has('bn_name') ? 'error' : '' !!}">
                                    <label>Name in Bengali</label><span class="text-danger">*</span>
                                    <div class="controls pt-2">
                                        {!! Form::text('bn_name', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter category name', 'data-validation-required-message' => 'This field is required','maxlength' => "255", 'tabindex' => $tab_index++,'id' => 'bn_name' ]) !!}
                                        {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                        <div class="word-counter-bn">0/255</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {!! $errors->has('is_popular') ? 'error' : '' !!}">
                                    <label>Is popular <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::select('is_popular', ['0'=> 'No','1'=> 'Yes'], 0,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tab_index++]) !!}
                                        {!! $errors->first('is_popular', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {!! $errors->has('parent_id') ? 'error' : '' !!}">
                                    <label for="parent_id">Parent<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <select  name="parent_id" id="parent_id" class="form-control select2">
                                            <option value="0">No Parent</option>
                                            @foreach ($categories as $category)
                                            <option {{ request()->get('category') == $category->PK_NO ? 'selected' : '' }} class="text-bold-600" style="font-weight: 600" value="{{ $category->PK_NO }}">{{ $category->NAME }}</option>
                                            {{-- <optgroup label="{{ $category->NAME }} child"> --}}
                                            @if(isset($category->subcategories))
                                            @foreach($category->subcategories as $subcategory)
                                            <option {{ request()->get('category') == $subcategory->SUBCATEGORY_ID ? 'selected' : '' }}
                                                value="{{$subcategory->SUBCATEGORY_ID}}"
                                            @if (old("categories")){{ (in_array($subcategory->SUBCATEGORY_ID, old("categories")) ? "selected":"") }}@endif
                                            class="optionChild">{{$category->NAME.' > '.$subcategory->SUBCATEGORY_NAME}}</option>
                                            @if(!empty($subcategory->subsubcategory))
                                            @foreach ($subcategory->subsubcategory as $item)
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<option {{ request()->get('category') == $item->SUBCATEGORY_ID ? 'selected' : '' }} value="{{$item->SUBCATEGORY_ID}}" class="pl-3"><span class="ml-4">{{$category->NAME.' > '.$subcategory->SUBCATEGORY_NAME.' > '.$item->SUBSUBCATEGORY_NAME}}</span></option>
                                            @endforeach
                                            @endif
                                            @endforeach
                                            @endif
                                            {{-- </optgroup> --}}
                                            @endforeach
                                            </select>
                                        {!! $errors->first('parent_id', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {!! $errors->has('order_id') ? 'error' : '' !!}">
                                    <label>Order id</label>
                                    <div class="controls">
                                        {!! Form::number('order_id', $data['max_order_id'] ?? 0, [ 'class' => 'form-control', 'placeholder' => 'Enter order id', 'tabindex' => $tab_index++,]) !!}
                                        {!! $errors->first('order_id', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                                    <label>Is active <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::select('is_active', ['1'=> 'Yes','0'=> 'No'], 1,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tab_index++ ]) !!}
                                        {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group {!! $errors->has('is_feature') ? 'error' : '' !!}">
                                    <label>Is feature <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::select('is_feature', ['0'=> 'No','1'=> 'Yes'], Null,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tab_index++]) !!}
                                        {!! $errors->first('is_feature', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group {!! $errors->has('attribute') ? 'error' : '' !!}">
                                    <label>Select attributes</label>
                                    <div class="controls">
                                        <button type="button" id="attributes" class="btn btn-outline-dropbox width-200" data-toggle="modal" data-target="#attributeModal">Attribute list</button>
                                        {!! $errors->first('attribute', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group {!! $errors->has('attribute') ? 'error' : '' !!}" style="display: none" id="selected_attr_section">
                                    <label>Selected attributes</label>
                                    <div class="controls" id="input_tags">
                                        <input class="input-tags" type="text" data-role="tagsinput" name="input_tags">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group {!! $errors->has('features') ? 'error' : '' !!}">
                                    <label>Select features</label>
                                    <div class="controls">
                                        <button type="button" id="features" class="btn btn-outline-dropbox width-200" data-toggle="modal" data-target="#featureModal">Feature list</button>
                                        {!! $errors->first('features', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group {!! $errors->has('features') ? 'error' : '' !!}" style="display: none" id="selected_feature_section">
                                    <label>Selected features</label>
                                    <div class="controls" id="feature_input_tags">
                                        <input class="feature-input-tags" type="text" data-role="tagsinput" name="feature_input_tags">
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
                                    {!! Form::text('meta_keywards', null, [ 'class' => 'form-control', 'placeholder' => 'Enter meta keyward','id'=>'meta_keywards','tabindex' => $tab_index++,'rows'=>'4','cols'=>'10' ]) !!}
                                    {!! $errors->first('meta_keywards', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {!! $errors->has('meta_description') ? 'error' : '' !!}">
                                    <label>Meta description</label>
                                    <div class="controls">
                                        {!! Form::textarea('meta_description', null, [ 'class' => 'form-control summernote', 'placeholder' => 'Enter meta description','id'=>'meta_description', 'tabindex' => $tab_index++,'rows'=>'4','cols'=>'10' ]) !!}
                                        {!! $errors->first('meta_description', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="input-field">
                                        <label class="active">Banner/Slider<span class="img-note d-inline-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}}  1200 x 300 pixels</span></label>
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
                                <input type="text" class="form-control form-control-sm input-sm" id="attr_search" placeholder="Search">
                                <div class="form-control-position">
                                    <i class="la la-search"></i>
                                </div>
                            </fieldset>
                            <ul class="" id="attr-all-list">
                                <li>
                                    <label class="checkbox-label" for="attr-input-0" style="">
                                    <input name="" type="checkbox"
                                           class="all_attr_input"
                                           value="0"
                                           id="attr-input-0">
                                    <span class="checkmark"></span>
                                    <span class="attr_name">Select All</span>
                                    </label>
                                </li>
                                    @foreach ($attr as $item)
                                        <li>
                                            <label class="checkbox-label" for="attr-input-{{ $loop->index+1}}" style="">
                                            <input name="{{ $item->NAME }}" type="checkbox"
                                                   class="all_attr_input"
                                                   value="{{ $item->PK_NO }}"
                                                   id="attr-input-{{ $loop->index+1}}">
                                            <span class="checkmark"></span>
                                            <span class="attr_name">{{ $item->NAME }}</span><span class="text-danger">{{ $item->IS_REQUIRED == 1 ? '*' : ''}}</span>
                                            </label>
                                        </li>
                                    @endforeach
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="ml-2 selected_section">
                                Selected (<span id="selected_count">0</span>)
                                <ul class="skin skin-flat pl-0" id="attr-selected-list">
                                    {{-- <fieldset style="">

                                    </fieldset> --}}
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
<!-- START FEATURE MODAL-->
<div class="modal fade text-left show" id="featureModal" tabindex="-1" role="dialog" aria-labelledby="" aria-modal="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="">Feature List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8 feature_list">
                            <fieldset class="form-group position-relative has-icon-left">
                                <input type="text" class="form-control form-control-sm input-sm mb-1" id="feature_search" placeholder="Search">
                                <div class="form-control-position">
                                    <i class="la la-search"></i>
                                </div>
                            </fieldset>
                            <ul class="" id="feature-all-list">
                                <li>
                                    <label class="checkbox-label" for="feature-input-0" style="">
                                    <input name="" type="checkbox"
                                           class="all_feature_input"
                                           value="0"
                                           id="feature-input-0">
                                    <span class="checkmark"></span>
                                    <span class="feature_name">Select All</span>
                                    </label>
                                </li>
                                @foreach ($feature as $item)
                                    <li data-is_color="{{ $item->IS_COLOR }}">
                                        <label class="checkbox-label" for="feature-input-{{ $loop->index+1}}" style="">
                                        <input name="{{ $item->NAME }}" type="checkbox"
                                                class="all_feature_input"
                                                value="{{ $item->PK_NO }}"
                                                id="feature-input-{{ $loop->index+1}}">
                                        <span class="checkmark"></span>
                                        <span class="feature_name">{{ $item->NAME }}</span><span class="text-danger">*</span>
                                        <span><i class="la la-question-circle" style="font-size: 19px;" data-toggle="tooltip" title="{{ $item->DESCRIPTION }}"></i></span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="ml-2 selected_section">
                                Selected (<span id="feature_selected_count">0</span>)
                                <ul class="skin skin-flat pl-0" id="feature-selected-list">
                                    {{-- <fieldset style="">

                                    </fieldset> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success" id="confirm_feature" data-dismiss="modal">Confirm</button>
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END FEATURE MODAL-->
<!-- START LANGUAGE CHANGE MODAL-->
{{-- <div class="modal fade text-left show" id="multiLangModal" tabindex="-1" role="dialog" aria-labelledby="" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="">Setup Multi-Languages/h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">

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
</div> --}}
<!-- END LANGUAGE CHANGE MODAL-->
@endsection
@push('custom_js')
<script type="text/javascript" src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
<script type="text/javascript" src="{{ asset('assets/file_upload/image-uploader.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/js/editors/summernote/summernote.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/scripts/editors/editor-summernote.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script>
    $('.select2').select2();
    $(function () {
        $('.prod_def_photo_upload').imageUploader();
    });
    $('.summernote').summernote();
    $(document).ready(function() {
        var count = 0;
        var feature_count = 0;
        var elt = $('.input-tags');
        elt.tagsinput({
            itemValue: 'value',
            itemText: 'text',
        });
        var feature_elt = $('.feature-input-tags');
        feature_elt.tagsinput({
            itemValue: 'value',
            itemText: 'text',
        });
        $("#attr-selected-list").html('');
        $('#attr-all-list li :checkbox:checked').each(function (i, row) {
            var li = row.closest('li');
            $(li).clone().appendTo("#attr-selected-list");
            elt.tagsinput('add', { "value": row.value , "text": row.name  });
        });
        $('#attr-selected-list li :checkbox:checked').each(function (i, row) {
            count++;
        });
        $('#selected_count').text(count);
        $('#input_tags .bootstrap-tagsinput input').hide();
        if (count == 0) {
            $('#selected_attr_section').fadeOut();
        }else{
            $('#selected_attr_section').fadeIn();
        }
        $("#feature-selected-list").html('');
        $('#feature-all-list li :checkbox:checked').each(function (i, row) {
            var li = row.closest('li');
            $(li).clone().appendTo("#feature-selected-list");
            feature_elt.tagsinput('add', { "value": row.value , "text": row.name  });
        });
        $('#feature-selected-list li :checkbox:checked').each(function (i, row) {
            feature_count++;
        });
        $('#feature_selected_count').text(feature_count);
        $('#feature_input_tags .bootstrap-tagsinput input').hide();
        if (feature_count == 0) {
            $('#selected_feature_section').fadeOut();
        }else{
            $('#selected_feature_section').fadeIn();
        }
        $('[data-toggle="tooltip"]').tooltip();
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
    })
    $(document).on('input','#feature_search',function () {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("feature_search");
        filter = input.value.toUpperCase();
        ul = document.getElementById("feature-all-list");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByClassName("feature_name")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    })
    $('.all_attr_input').on('change',function () {
        get_all_attr_checked_val();
    })
    $('.all_feature_input').on('change',function () {
        get_all_feature_checked_val();
    })
    $('#attr-input-0').on('change',function () {
        if ($(this).is(':checked')) {
            $('#attr-all-list li :checkbox').prop('checked',true);
        }else{
            $('#attr-all-list li :checkbox').prop('checked',false);
        }
        get_all_attr_checked_val();
    })
    $('#feature-input-0').on('change',function () {
        if ($(this).is(':checked')) {
            $('#feature-all-list li :checkbox').prop('checked',true);
        }else{
            $('#feature-all-list li :checkbox').prop('checked',false);
        }
        get_all_feature_checked_val();
    })
    function get_all_attr_checked_val() {
        var count = 0;
        $("#attr-selected-list").html('');
        $('#attr-all-list li :checkbox:checked').not('#attr-input-0').each(function (i, row) {
            var li = row.closest('li');
            $(li).clone().appendTo("#attr-selected-list");
        });
        $("#attr-selected-list li").css('display','block');
        $('#attr-selected-list li :checkbox:checked').each(function (i, row) {
            count++;
        });
        $('#selected_count').text(count);
    }
    function get_all_feature_checked_val() {
        var feature_count   = 0;
        var is_color_true   = 0;
        var is_color_false  = 0;
        $("#feature-selected-list").html('');
        $('#feature-all-list li :checkbox:checked').not('#feature-input-0').each(function (i, row) {
            var li = row.closest('li');
            var is_color = $(li).data('is_color');
            if (is_color == 1) {
                is_color_true++;
            }else{
                is_color_false++;
            }
            if (is_color_true <= 1 && is_color_false <= 1) {
                $(li).clone().appendTo("#feature-selected-list");
            }
        });
        $("#feature-selected-list li").css('display','block');
        $('#feature-selected-list li :checkbox:checked').each(function (i, row) {
            feature_count++;
        });
        if (is_color_true > 1) {
            toastr.warning('maximum acceptable color feature is one !')
        }
        if (is_color_false > 1) {
            toastr.warning('maximum acceptable non-color feature is one !')
        }
        $('#feature_selected_count').text(feature_count);
        $('[data-toggle="tooltip"]').tooltip();
    }
    var elt = $('.input-tags');
    elt.tagsinput({
        itemValue: 'value',
        itemText: 'text',
    });
    var feature_elt = $('.feature-input-tags');
    feature_elt.tagsinput({
        itemValue: 'value',
        itemText: 'text',
    });
    $('#confirm_attr').on('click',function () {
        $('.input-tags').tagsinput('removeAll');
        var elt = $('.input-tags');
        elt.tagsinput({
            itemValue: 'value',
            itemText: 'text',
        });
        $('#attr-selected-list li :checkbox:checked').each(function (i, row) {
            elt.tagsinput('add', { "value": row.value , "text": row.name  });
        });
        if ($('.input-tags').val() !== '') {
            $('#selected_attr_section').fadeIn();
        }else{
            $('#selected_attr_section').fadeOut();
        }
    })
    $('#confirm_feature').on('click',function () {
        $('.feature-input-tags').tagsinput('removeAll');
        $('#feature-selected-list li :checkbox:checked').each(function (i, row) {
            console.log(row.value);
            feature_elt.tagsinput('add', { "value": row.value , "text": row.name  });
        });
        if ($('.feature-input-tags').val() !== '') {
            $('#selected_feature_section').fadeIn();
        }else{
            $('#selected_feature_section').fadeOut();
        }
    })
    $('.input-tags').on('beforeItemRemove', function(event) {
        var tag = event.item;
        if (!event.options || !event.options.preventPost) {
            $("#attr-all-list li input[type=checkbox][value="+tag.value+"]").prop("checked",false).change();
            get_all_attr_checked_val();
        }
    });
    $('.feature-input-tags').on('beforeItemRemove', function(event) {
        var tag = event.item;
        if (!event.options || !event.options.preventPost) {
            $("#feature-all-list li input[type=checkbox][value="+tag.value+"]").prop("checked",false).change();
            get_all_feature_checked_val();
        }
    });
    $('.input-tags').on('itemRemoved', function(event) {
        if (!event.options || !event.options.preventPost) {
            if ($('.input-tags').val() !== '') {
                $('#selected_attr_section').fadeIn();
            }else{
                $('#selected_attr_section').fadeOut();
            }
        }
    });
    $('.feature-input-tags').on('itemRemoved', function(event) {
        if (!event.options || !event.options.preventPost) {
            if ($('.feature-input-tags').val() !== '') {
                $('#selected_feature_section').fadeIn();
            }else{
                $('#selected_feature_section').fadeOut();
            }
        }
    });
    $('#cat_name').on('keyup keydown paste',function(){
        $('.word-counter').text(this.value.length+'/255');
    })
    $('#bn_name').on('keyup keydown paste',function(){
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
    })
    $(document).on('change','#parent_id',function(){
        var get_url = $('#base_url').val();
        var parent = $(this).val();
        $.ajax({
            type:'get',
            url:get_url+'/get-parent-attributes/'+parent,
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                $('#attr-all-list li :checkbox').prop('checked',false);
                $('#feature-all-list li :checkbox').prop('checked',false);

                if(data.status == 1 ){
                    $('#attr-all-list li :checkbox').not('#attr-input-0').each(function (i, row) {
                        var val = $(row).val();
                        if(data.data.attr.F_ATTRIBUTE_NO !== null && data.data.attr.F_ATTRIBUTE_NO.includes(val)){
                            $(row).prop('checked',true);
                        }
                    });
                    $('#feature-all-list li :checkbox').not('#feature-input-0').each(function (i, row) {
                        var val = $(row).val();
                        if(data.data.feature.F_FEATURE_NO !== null && data.data.feature.F_FEATURE_NO.includes(val)){
                            $(row).prop('checked',true);
                        }
                    });
                }
                get_all_feature_checked_val();
                get_all_attr_checked_val();
                $('#confirm_attr').trigger('click');
                $('#confirm_feature').trigger('click');
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })

    $('#cat_name').on('keyup keydown paste',function(){
        var str = $(this).val();
        $("#meta_title").val(str);
        $("#meta_keywards").val(str);
        $("#meta_description").val(str);
        str = str.replace(/^\s+|\s+$/g, ''); // trim
        str = str.toLowerCase();
        // remove accents, swap ñ for n, etc
        var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
        var to   = "aaaaaeeeeeiiiiooooouuuunc------";
        for (var i = 0, l = from.length; i < l; i++) {
            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }
        str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes
    $("#url_slug").val(str);
     return str;
    })




</script>
@endpush('custom_js')
