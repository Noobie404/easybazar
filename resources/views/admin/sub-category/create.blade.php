@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">
@endpush('custom_css')

@section('Product Management','open')
@section('product sub-category','active')

@section('title') Create sub category @endsection
@section('page-name')Create sub category @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin_role.breadcrumb_title')  </a></li>
    <li class="breadcrumb-item active">@lang('form.sub_category')    </li>
@endsection
<?php
    $categories_combo = $data['category_combo'] ?? [];
?>

@section('content')

<section id="basic-form-layouts">
                    <div class="row match-height min-height">
                        <div class="col-md-12">
                            <div class="card card-success">
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        {!! Form::open([ 'route' => 'admin.sub_category.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group {!! $errors->has('category') ? 'error' : '' !!}">
                                                    <label>{{trans('form.category')}}<span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::select('category', $categories_combo, null, ['class'=>'form-control mb-1 select2', 'id' => 'category', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select category', 'tabindex' => 1, 'data-url' => URL::to('prod_subcategory')]) !!}
                                                        {!! $errors->first('category', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                                   <label>@lang('form.name')<span class="text-danger">*</span></label>
                                                   <div class="controls">
                                                      {!! Form::text('name', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter subcategory name', 'data-validation-required-message' => 'This field is required', 'tabindex' => 2 ]) !!}
                                                      {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                                   </div>
                                                </div>
                                             </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group {!! $errors->has('url_slug') ? 'error' : '' !!}">
                                                   <label>URL slug</label>
                                                   <div class="controls">
                                                      {!! Form::text('url_slug', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter url slug', 'tabindex' => 3 ]) !!}
                                                      {!! $errors->first('url_slug', '<label class="help-block text-danger">:message</label>') !!}
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-4">
                                                <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                                                    <label>IS active <span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::select('is_active', ['1'=> 'YES','0'=> 'NO'], 1,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => 4]) !!}
                                                        {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group {!! $errors->has('is_feature') ? 'error' : '' !!}">
                                                    <label>IS feature <span class="text-danger">*</span></label>
                                                    <div class="controls">
                                                        {!! Form::select('is_feature', ['1'=> 'YES','0'=> 'NO'],NULL,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => 5]) !!}
                                                        {!! $errors->first('is_feature', '<label class="help-block text-danger">:message</label>') !!}
                                                    </div>
                                                </div>
                                                </div>
                                             {{--
                                             <div class="col-md-4">
                                                <div class="form-group {!! $errors->has('comment') ? 'error' : '' !!}">
                                                   <label>COMMENTS</label>
                                                   <div class="controls">
                                                      {!! Form::textarea('comment', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter hs prefix', 'data-validation-required-message' => 'This field is required', 'tabindex' => 1 ]) !!}
                                                      {!! $errors->first('comment', '<label class="help-block text-danger">:message</label>') !!}
                                                   </div>
                                                </div>
                                             </div>
                                             --}}
                                          </div>
                                          <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group {!! $errors->has('meta_title') ? 'error' : '' !!}">
                                                   <label>Meta title</label>
                                                   <div class="controls">
                                                      {!! Form::text('meta_title', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter meta title', 'tabindex' => 6]) !!}
                                                      {!! $errors->first('meta_title', '<label class="help-block text-danger">:message</label>') !!}
                                                   </div>
                                                </div>
                                             </div>
                                            <div class="col-md-12">
                                                <div class="form-group {!! $errors->has('meta_keywards') ? 'error' : '' !!}">
                                                   <label>Meta keywards</label>
                                                   <div class="controls">
                                                      {!! Form::textarea('meta_keywards', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter meta keyward', 'tabindex' => 7,'rows'=>'4','cols'=>'10' ]) !!}
                                                      {!! $errors->first('meta_keywards', '<label class="help-block text-danger">:message</label>') !!}
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="col-md-12">
                                                <div class="form-group {!! $errors->has('meta_description') ? 'error' : '' !!}">
                                                   <label>Meta description</label>
                                                   <div class="controls">
                                                      {!! Form::textarea('meta_description', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter meta description', 'tabindex' => 8,'rows'=>'4','cols'=>'10' ]) !!}
                                                      {!! $errors->first('meta_description', '<label class="help-block text-danger">:message</label>') !!}
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
                                                        <label class="btn btn-success text-white btn-file btn-sm">
                                                        <span class="fileupload-new">
                                                        <i class="la la-file-image-o"></i> Select image
                                                        </span>
                                                        <span class="fileupload-exists">
                                                        <i class="la la-reply"></i> Change
                                                        </span>
                                                        {!! Form::file('thumbnail_image', Null,[ 'class' => 'form-control mb-1', 'tabindex' => 9]) !!}
                                                        </label>
                                                        <a href="#" class="btn fileupload-exists btn-danger  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
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
                                                        <label class="btn btn-success btn-file btn-sm text-white">
                                                        <span class="fileupload-new">
                                                        <i class="la la-file-image-o"></i> Select image
                                                        </span>
                                                        <span class="fileupload-exists">
                                                        <i class="la la-reply"></i> Change
                                                        </span>
                                                        {!! Form::file('banner_image', Null,[ 'class' => 'form-control mb-1', 'placeholder' => 'IS ACTIVE', 'tabindex' => 10]) !!}
                                                        </label>
                                                        <a href="#" class="btn fileupload-exists btn-danger text-white btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
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
                                                        <label class="btn btn-success btn-file btn-sm text-white">
                                                        <span class="fileupload-new">
                                                        <i class="la la-file-image-o"></i> Select image
                                                        </span>
                                                        <span class="fileupload-exists">
                                                        <i class="la la-reply"></i> Change
                                                        </span>
                                                        {!! Form::file('icon', Null,[ 'class' => 'form-control mb-1', 'placeholder' => 'IS ACTIVE', 'tabindex' => 11]) !!}
                                                        </label>
                                                        <a href="#" class="btn fileupload-exists btn-danger text-white btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                        <i class="la la-times"></i> Remove
                                                        </a>
                                                        </span>
                                                        <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}}  80 x 80 pixels</span>
                                                     </div>
                                                     {!! $errors->first('feature_image', '<label class="help-block text-danger">:message</label>') !!}
                                                  </div>
                                               </div>
                                            </div>
                                         </div>

                                            <div class="form-actions text-center mt-3">
                                                <a href="{{route('admin.sub_category.list')}}">
                                                    <button type="button" class="btn btn-warning mr-1" title="Cancel">
                                                        <i class="ft-x"></i> @lang('form.btn_cancle')
                                                    </button>
                                                </a>
                                                <button type="submit" class="btn btn-primary" title="Save">
                                                    <i class="la la-check-square-o"></i> @lang('form.btn_save')
                                                </button>
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
@endpush
