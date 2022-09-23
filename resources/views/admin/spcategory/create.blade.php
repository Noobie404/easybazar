@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/file_upload/image-uploader.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/editors/summernote.css')}}">
<style>
    .word-counter {position:absolute;bottom: 6px;right:88px;z-index: 9;}
    .word-counter-slug {position:absolute;bottom: 6px;right:11px;z-index: 9;}
    .word-counter-bn {position:absolute;bottom: 27px;right:20px;}
    #spcat_name{padding-right: 60px;}
    #url_slug{padding-right: 68px;}
    #bn_name{padding-right: 60px;}
    .optionChild{font-style: italic;}
</style>
@endpush('custom_css')

@section('product_special_category','active')

@section('title') Create special category @endsection
@section('page-name')Create special category @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin_role.breadcrumb_title')  </a></li>
    <li class="breadcrumb-item active">special category    </li>
@endsection
@section('content')
@php
$tab_index = 1;
@endphp
<section id="basic-form-layouts">
    <div class="row match-height min-height">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-content collapse show">
                    <div class="card-body">
                        {!! Form::open([ 'route' => 'product.spcategory.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                <label>@lang('form.name')<span class="text-danger">*</span></label>
                                <div class="input-group">
                                        {!! Form::text('name', null, [ 'class' => 'form-control', 'placeholder' => 'Enter category name', 'data-validation-required-message' => 'This field is required','maxlength' => "255", 'tabindex' => $tab_index++,'id' => 'spcat_name' ]) !!}
                                        {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                        <div class="word-counter">0/255</div>
                                        <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="translate"><i class='fa fa-spinner fa-spin' style="display: none"></i>  Translate</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {!! $errors->has('url_slug') ? 'error' : '' !!}">
                                    <label>Url slug <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        {!! Form::text('url_slug', null, [ 'class' => 'form-control', 'placeholder' => 'Enter url slug', 'data-validation-required-message' => 'This field is required','maxlength' => "255", 'tabindex' => $tab_index++,'id' => 'url_slug' ]) !!}
                                        {!! $errors->first('url_slug', '<label class="help-block text-danger">:message</label>') !!}
                                        <div class="word-counter-slug">0/255</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {!! $errors->has('bn_name') ? 'error' : '' !!}">
                                    <label>Name in Bengali</label><span class="text-danger">*</span>
                                    <div class="controls">
                                        {!! Form::text('bn_name', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter category name', 'data-validation-required-message' => 'This field is required','maxlength' => "255", 'tabindex' => $tab_index++,'id' => 'bn_name' ]) !!}
                                        {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                        <div class="word-counter-bn">0/255</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {!! $errors->has('order_id') ? 'error' : '' !!}">
                                    <label>Order Id <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::number('order_id', null,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required','placeholder' => 'Enter order id', 'tabindex' => $tab_index++ ]) !!}
                                        {!! $errors->first('order_id', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                                    <label>Is active <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::select('is_active', ['1'=> 'Yes','0'=> 'No'], 1,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tab_index++ ]) !!}
                                        {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {!! $errors->has('description') ? 'error' : '' !!}">
                                    <label>Description</label>
                                    <div class="controls">
                                        {!! Form::textarea('description', null, [ 'class' => 'form-control summernote', 'placeholder' => 'Enter meta description','id'=>'description', 'tabindex' => $tab_index++,'rows'=>'4','cols'=>'10' ]) !!}
                                        {!! $errors->first('description', '<label class="help-block text-danger">:message</label>') !!}
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
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('banner_path') ? 'error' : '' !!}">
                                <label class="active">Banner/Slider</label>
                                <div class="controls">
                                    <div class="fileupload fileupload-new" data-provides="fileupload" >
                                        <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
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
                                        <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}}  1200 x 300 pixels</span>
                                    </div>
                                    {!! $errors->first('banner_path', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('thumbnail_image') ? 'error' : '' !!}">
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
                                    {!! $errors->first('thumbnail_image', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('icon') ? 'error' : '' !!}">
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
                                    {!! $errors->first('icon', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-center mt-3">
                            <a href="{{ route('product.spcategory.list') }}">
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
@endsection
@push('custom_js')
    <script type="text/javascript" src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>\
    <script type="text/javascript" src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/file_upload/image-uploader.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/js/editors/summernote/summernote.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/scripts/editors/editor-summernote.js') }}"></script>
    <script>
        $('.select2').select2();
        $(function () {
            $('.prod_def_photo_upload').imageUploader();
        });
        $('.summernote').summernote();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click','#translate',function(){
            var get_url = $('#base_url').val();
            var text = $('#spcat_name').val();
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
        $('#bn_name').on('keyup keydown paste',function(){
            $('.word-counter-bn').text(this.value.length+'/255');
        })
        $('#url_slug').on('keyup keydown paste',function(){
            $('.word-counter-slug').text(this.value.length+'/255');
        })
        $('#spcat_name').on('keyup keydown paste',function(){
            $('.word-counter').text(this.value.length+'/255');

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
            $('.word-counter-slug').text(str.length+'/255');
            $("#url_slug").val(str);
         return str;
        })
    </script>
@endpush
