@extends('admin.layout.master')

@section('Customer Management','open')
@section('customer_list','active')

@section('title') @lang('customer.add_new_customer') @endsection
@section('page-name') @lang('customer.add_new_customer') @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">@lang('admin_role.breadcrumb_title')  </a></li>
<li class="breadcrumb-item active">@lang('customer.breadcrumb_sub_title')    </li>
@endsection
<?php
    $roles = userRolePermissionArray();
    $method_name = request()->route()->getActionMethod();
    $tab_index = 1;
?>
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/file_upload/image-uploader.min.css')}}">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">
@endpush('custom_css')
    <style>
        #scrollable-dropdown-menu2 .tt-menu {max-height: 260px;overflow-y: auto; width: 100%; border: 1px solid #333;border-radius: 5px;}
        #scrollable-dropdown-menu4 .tt-menu {max-height: 260px; overflow-y: auto; width: 100%; border: 1px solid #333;border-radius: 5px;}
        .twitter-typeahead{display: block !important;}
    </style>

@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-sm card-success" >
                <div class="card-content">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified no-border">
                            <li class="nav-item">
                                <a class="nav-link active" id="productBasic-tab1" data-toggle="tab" href="#productBasic" aria-controls="productBasic" aria-expanded="true">@lang('customer.customer_info')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="linkIcon1-tab1" data-toggle="tab" href="#linkIcon1" aria-controls="linkIcon1" aria-expanded="false" >@lang('customer.customer_address')</a>
                            </li>
                        </ul>
                        <!-- Customer Info -->
                        <div class="tab-content border-tab-content">
                            <div role="tabpanel" class="tab-pane active" id="productBasic" aria-labelledby="productBasic-tab1" aria-expanded="true">
                                {!! Form::open([ 'route' => 'admin.customer.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                                <div class="row">
                                    <div class="col-md-6">
                                            <div class="form-group {!! $errors->has('customer') ? 'error' : '' !!}">
                                                <label for="customer">{{trans('form.select_customer')}}<span class="text-danger">*</span></label>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="controls">
                                                            <label>{!! Form::radio('customer', 'ukshop', true) !!} Easybazar</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="controls">
                                                            <label>{!! Form::radio('customer','seller') !!} Seller</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group {!! $errors->has('seller') ? 'error' : '' !!}">
                                                            <div class="controls">
                                                                {!! Form::select('seller', $seller, null, ['class'=>'form-control select2', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tab_index++, 'id' => 'booking_under']) !!}
                                                                {!! $errors->first('seller', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                            <label for="name">{{trans('form.name')}}<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::text('name',  null, ['class'=>'form-control', 'id' => 'name', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter name', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="mobile_no">{{trans('form.mobile_no')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="phonecode4">+88</span>
                                            </div>
                                            {!! Form::text('mobile_no',null,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter mobile No', 'tabindex' => $tab_index++]) !!}
                                            {!! $errors->first('mobile_no', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('altno') ? 'error' : '' !!}">
                                        <label for="altno">{{trans('form.alternative_no')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="phonecode4">+88</span>
                                            </div>
                                            {!! Form::text('altno',null,[ 'class' => 'form-control','placeholder' => 'Enter Alternative mobile no', 'tabindex' => $tab_index++]) !!}
                                            {!! $errors->first('altno', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('email') ? 'error' : '' !!}">
                                            <label for="email">{{trans('form.email')}}</label>
                                            <div class="controls">
                                                {!! Form::email('email', null, ['class'=>'form-control', 'id' => 'email', 'placeholder' => 'Enter email', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('email', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('ukid') ? 'error' : '' !!}">
                                            <label for="ukid">Customer ID</label>
                                            <div class="controls">
                                                {!! Form::text('ukid',  null, ['class'=>'form-control', 'id' => 'ukid',  'placeholder' => 'Enter id', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('ukid', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('password') ? 'error' : '' !!}">
                                            <label for="password">Password</label>
                                            <div class="controls">
                                                {!! Form::password('password', ['class'=>'form-control', 'id' => 'password',  'placeholder' => 'Enter pass', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('password', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('gender') ? 'error' : '' !!}">
                                            <label for="gender">Gender</label>
                                                <div class="controls">
                                                    <label>{!! Form::radio('gender','0', NULL) !!} Male</label>
                                                    <label>{!! Form::radio('gender','1', NULL) !!} Female</label>
                                                {!! $errors->first('gender', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('birth_date') ? 'error' : '' !!}">
                                            <label for="birth_date">Birth date</label>
                                            <div class="controls">
                                                {!! Form::date('birth_date',NULL,['class'=>'form-control', 'id' => 'birth_date',  'placeholder' => 'yyyy/mm/dd', 'tabindex' => 6,  ]) !!}
                                                {!! $errors->first('birth_date', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('photo') ? 'error' : '' !!}">
                                        <label class="photo" for="photo">Photo</label>
                                        <div class="controls">
                                            <div class="fileupload @if(!empty($customer->PROFILE_PIC_URL))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($customer->PROFILE_PIC_URL))
                                                <img src="{{asset($customer->PROFILE_PIC_URL)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-rounded btn-file btn-sm">
                                                <span class="fileupload-new"><i class="la la-file-image-o"></i> Select image</span>
                                                <span class="fileupload-exists"><i class="la la-reply"></i> Change</span>
                                                <input type="file" name="photo" tabindex="11" id="photo"/>
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail"> <i class="la la-times"></i> Remove</a>
                                                </span>
                                                <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}}  300 x 300 pixels</span>
                                            </div>
                                            {!! $errors->first('photo', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Customer Address -->
                             <div class="tab-pane" id="linkIcon1" role="tabpanel" aria-labelledby="linkIcon1-tab1" aria-expanded="false">
                             {{-- {!! Form::open([ 'route' => 'admin.customer-address.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!} --}}
                                <h3>Address</h3>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('addresstype') ? 'error' : '' !!}">
                                            <label for="addressCombo">{{trans('form.address_type')}}</label>
                                            <div class="controls">
                                            {!! Form::select('addresstype', $address, null, ['class'=>'form-control select2', 'data-validation-required-message' => 'This field is required', 'id' => 'addressCombo', 'tabindex' => $tab_index++ ]) !!}
                                            {!! $errors->first('addresstype', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                            <label for="name">{{trans('form.name')}}<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::text('name',  null, ['class'=>'form-control', 'id' => 'name', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter name', 'tabindex' => $tab_index++, 'required' ]) !!}
                                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="mobile_no">{{trans('form.mobile_no')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="phonecode2">+88</span>
                                            </div>
                                            {!! Form::text('mobile_no',null,[ 'class' => 'form-control', 'placeholder' => 'Enter mobile no.', 'tabindex' => $tab_index++, 'id' => 'mobile_no']) !!}
                                            {!! $errors->first('mobile_no', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('country') ? 'error' : '' !!}">
                                            <label>{{trans('form.country')}}</label>
                                            <div class="controls">
                                                <select name="country" id="country" tabindex="{{ $tab_index++ }}" class="form-control select2">
                                                    @foreach ($data['country'] as $item)
                                                        <option value="{{ $item->PK_NO }}" data-dial_code="{{ $item->DIAL_CODE }}" {{ $item->PK_NO == 1 ? "selected='selected'" : '' }}>{{ $item->NAME }} ({{ $item->DIAL_CODE }})</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('country', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('region') ? 'error' : '' !!}">
                                           <label for="region">Region <span class="text-danger">*</span></label>
                                           <div class="controls">
                                              {!! Form::select('region', $data['state'], null, [ 'class' => 'form-control', 'id'=>'region','data-validation-required-message' => 'This filed is required','placeholder'=>'Select region','tabindex'=>5,'required']) !!}
                                              {!! $errors->first('region', '<label class="help-block text-danger">:message</label>') !!}
                                           </div>
                                        </div>
                                     </div>
                                     <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('city') ? 'error' : '' !!}">
                                           <label for="city">City <span class="text-danger">*</span></label>
                                           <div class="controls">
                                              <select name="city" class="form-control" id="city" data-validation-required-message="This filed is required" tabindex="6" required></select>
                                              {!! $errors->first('city', '<label class="help-block text-danger">:message</label>') !!}
                                           </div>
                                        </div>
                                     </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('area') ? 'error' : '' !!}">
                                            <label for="area">Area <span class="text-danger">*</span></label>
                                            <div class="controls">
                                               <select name="area" class="form-control select2" id="area" data-validation-required-message="This filed is required" tabindex="7" required></select>
                                               {!! $errors->first('area', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('ad_1') ? 'error' : '' !!}">
                                            <label>{{trans('form.address_1')}}</label>
                                            <div class="controls">
                                                {!! Form::text('ad_1',  null, ['class'=>'form-control', 'id' => 'ad1',  'placeholder' => 'Enter address 1', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('ad_1', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('ad_2') ? 'error' : '' !!}">
                                            <label>{{trans('form.address_2')}}</label>
                                            <div class="controls">
                                                {!! Form::text('ad_2',  null, ['class'=>'form-control', 'id' => 'ad3',  'placeholder' => 'Enter address 2', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('ad_2', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                 </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('post_code') ? 'error' : '' !!}">
                                            <label for="post_code">{{trans('form.post_code')}}</label>
                                            <div class="controls">
                                                {!! Form::text('post_code', null, ['class'=>'form-control', 'id' => 'post_code','placeholder' => 'Post code', 'tabindex' => 10 ]) !!}
                                                {!! $errors->first('post_code', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <br>
                                            <div class="controls">
                                                {{Form::hidden('same_as_add',0)}}
                                                <label style="float: right;"><input type="checkbox" name="same_as_add" id="checkbox1">  {{ trans('form.same_as_add') }}</label>
                                                {!! $errors->first('same_as_add', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Billing Address --}}

                                <div class="row" id="display_none" style="display: none">
                                    <div class="col-md-12">
                                        <h3>Billing Address</h3>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('addresstype2') ? 'error' : '' !!}">
                                            <label>{{trans('form.address_type')}}</label>
                                            <div class="controls">
                                            {!! Form::select('addresstype2', $address, 2, ['class'=>'form-control select2', 'tabindex' => $tab_index++, 'id' => 'addresstype2']) !!}
                                            {!! $errors->first('addresstype2', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('customeraddress2') ? 'error' : '' !!}">
                                            <label>{{trans('form.name')}}<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::text('customeraddress2',  null, ['class'=>'form-control', 'id' => 'customeraddress2', 'placeholder' => 'Enter name', 'tabindex' => $tab_index++, '' ]) !!}
                                                {!! $errors->first('customeraddress2', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="mobile_no">{{trans('form.mobile_no')}}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="phonecode3">+88</span>
                                            </div>
                                            {!! Form::text('mobilenoadd2',null,[ 'class' => 'form-control', 'placeholder' => 'Enter mobile no.', 'id' => 'mobilenoadd2', 'tabindex' => $tab_index++]) !!}
                                            {!! $errors->first('mobilenoadd2', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('country2') ? 'error' : '' !!}">
                                            <label>{{trans('form.country')}}</label>
                                            <div class="controls">
                                                <select name="country2" id="country2" class="form-control select2" tabindex="{{ $tab_index++ }}">
                                                    @foreach ($data['country'] as $item)
                                                        <option value="{{ $item->PK_NO }}" data-dial_code="{{ $item->DIAL_CODE }}" {{ $item->PK_NO == 1 ? "selected='selected'" : '' }}>{{ $item->NAME }} ({{ $item->DIAL_CODE }})</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('country2', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group {!! $errors->has('region2') ? 'error' : '' !!}">
                                        <label for="region2">Region <span class="text-danger">*</span></label>
                                        <div class="controls">
                                           {!! Form::select('region2', $data['state'], null, [ 'class' => 'form-control', 'id'=>'region2','data-validation-required-message' => 'This filed is required','placeholder'=>'Select region','tabindex'=>5,'required']) !!}
                                           {!! $errors->first('region2', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                     </div>


                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('post_code2') ? 'error' : '' !!}">
                                            <label>{{trans('form.post_code')}}</label>
                                            <div class="controls" id="scrollable-dropdown-menu4">
                                                <input type="search" name="post_code2" id="post_code_2" class="form-control search-input8" placeholder="Post code" autocomplete="off" required>
                                                {!! $errors->first('post_code2', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                            <div id="post_code2_appended_div">
                                                {!! Form::hidden('post_code2', 0, ['id'=>'post_code2']) !!}
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('city2') ? 'error' : '' !!}">
                                            <label>{{trans('form.city')}}</label>
                                            <div class="controls">
                                                {!! Form::select('city2', array(), null, ['class'=>'form-control select2',
                                                'data-validation-required-message' => 'Select City', 'id' => 'city2','tabindex' =>
                                                $tab_index++, 'placeholder' => 'Select city', 'data-url' => URL::to('customer_pCode') ]) !!}
                                                {!! $errors->first('city', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('state2') ? 'error' : '' !!}">
                                            <label>{{trans('form.state')}}</label>
                                            <div class="controls">
                                                {!! Form::select('state2', array(), null, ['class'=>'form-control select2',
                                                'data-validation-required-message' => 'Select City', 'placeholder' => 'Select state', 'id' => 'state2','tabindex' => $tab_index++, 'data-url' => URL::to('customer_city') ]) !!}
                                                {!! $errors->first('state2', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('ad_12') ? 'error' : '' !!}">
                                            <label>{{trans('form.address_1')}}</label>
                                            <div class="controls">
                                                {!! Form::text('ad_12',null, ['class'=>'form-control', 'id' => 'ad1',  'placeholder' => 'Enter address 1', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('ad_12', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('ad_22') ? 'error' : '' !!}">
                                            <label>{{trans('form.address_2')}}</label>
                                            <div class="controls">
                                                {!! Form::text('ad_22',null, ['class'=>'form-control', 'id' => 'ad2',  'placeholder' => 'Enter address 2', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('ad_22', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('ad_32') ? 'error' : '' !!}">
                                            <label>{{trans('form.address_3')}}</label>
                                            <div class="controls">
                                                {!! Form::text('ad_32',null, ['class'=>'form-control', 'id' => 'ad3',  'placeholder' => 'Enter Address 3', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('ad_32', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('ad_42') ? 'error' : '' !!}">
                                            <label>{{trans('form.address_4')}}</label>
                                            <div class="controls">
                                                {!! Form::text('ad_42',null, ['class'=>'form-control', 'id' => 'ad4',  'placeholder' => 'Enter Address 4', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('ad_42', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('location2') ? 'error' : '' !!}">
                                            <label>{{trans('form.location')}}</label>
                                            <div class="controls">
                                                {!! Form::text('location2',null, ['class'=>'form-control', 'id' => 'location',  'placeholder' => 'Enter location', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('location2', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2 mb-2">
                                    <div class="form-actions text-center">
                                        <a href="{{route('admin.customer.list')}}" class="btn btn-warning mr-1" title="Cancel"><i class="ft-x"></i> {{ trans('form.btn_cancle') }}</a>
                                        <button type="submit" class="btn bg-primary bg-darken-1 text-white" title="Save">
                                         <i class="la la-check-square-o"></i> {{ trans('form.btn_save') }} </button>
                                     </div>
                                 </div>
                                {!! Form::close() !!}
                            </div>

                        </div>
                    </div>
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
<script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/pages/customer.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/pages/country.js') }}"></script>
<script src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/pages/address.js')}}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script>
    $(document).on('change','#country3', function(){
        changeDialCodePopups4();
    });
    function changeDialCodePopups4() {
        var selected_country_dial = $('#country3').find(":selected").data('dial_code');
        console.log(selected_country_dial);
        $('#phonecode4').text(selected_country_dial);
        $('#mobileno').val('');
    }
</script>
 @endpush('custom_js')
