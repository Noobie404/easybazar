@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">
@endpush('custom_css')
@section('web','open')
@section('whatsapp','active')
@section('title') Whatsapp @endsection
@section('page-name') Create Whatsapp @endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Whatsapp</a></li>
<li class="breadcrumb-item active">Create Whatsapp</li>
@endsection
@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-sm card-success" >
                <div class="card-content">
                    <div class="card-body">
                                {!! Form::open([ 'route' => 'web.home.whatsapp.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                            <label>Name </label>
                                            <div class="controls">
                                                {!! Form::text('name', null, [ 'class' => 'form-control mb-1','placeholder' => 'Enter name', 'tabindex' => 1]) !!}
                                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('phone') ? 'error' : '' !!}">
                                            <label>WhatsApp Number </label>
                                            <div class="controls">
                                                {!! Form::text('phone', null, [ 'class' => 'form-control mb-1','placeholder' => 'Enter whatsApp number', 'tabindex' => 2]) !!}
                                                {!! $errors->first('phone', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('default-msg') ? 'error' : '' !!}">
                                            <label>Default Message </label>
                                            <div class="controls">
                                                {!! Form::text('default_msg', null, [ 'class' => 'form-control mb-1','placeholder' => 'Enter default message', 'tabindex' => 2]) !!}
                                                {!! $errors->first('default-msg', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('designation') ? 'error' : '' !!}">
                                            <label>Designation </label>
                                            <div class="controls">
                                                {!! Form::text('designation', null, [ 'class' => 'form-control','placeholder' => 'Enter designation', 'tabindex' => 2]) !!}
                                                {!! $errors->first('designation', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('photo') ? 'error' : '' !!}">
                                           <label class="active">Profile Photo</label>
                                           <div class="controls">
                                              <div class="fileupload @if(!empty($row->PHOTO))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                 <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                 @if(!empty($row->PHOTO))
                                                 <img src="{{asset($row->PHOTO)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                 @endif
                                                 </span>
                                                 <span>
                                                 <label class="btn btn-primary btn-rounded btn-file btn-sm">
                                                 <span class="fileupload-new">
                                                 <i class="la la-file-image-o"></i> Select Image
                                                 </span>
                                                 <span class="fileupload-exists">
                                                 <i class="la la-reply"></i> Change
                                                 </span>
                                                 {!! Form::file('photo', Null,[ 'class' => 'form-control', 'tabindex' => 8]) !!}
                                                 </label>
                                                 <a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                 <i class="la la-times"></i> Remove
                                                 </a>
                                                 </span>
                                                 <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i> {{trans('form.image_size')}}  60 x 60 pixels</span>


                                              </div>
                                              {!! $errors->first('photo', '<label class="help-block text-danger">:message</label>') !!}
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                                            <label>Is Active <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::select('is_active', ['1'=> 'YES','0'=> 'NO'], NULL,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select', 'tabindex' => 6]) !!}
                                                {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-actions text-center">
                                            <a href="{{route('web.home.slider')}}" class="btn btn-warning mr-1"><i class="ft-x"></i> {{ trans('form.btn_cancle') }}</a>
                                            <button type="submit" class="btn bg-primary bg-darken-1 text-white">
                                             <i class="la la-check-square-o"></i> {{ trans('form.btn_save') }} </button>
                                         </div>
                                     </div>
                                 </div>
                                 {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Recent Transactions -->
</div>
@endsection
<!--push from page-->
@push('custom_js')
<script type="text/javascript" src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
 @endpush('custom_js')
