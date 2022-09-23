<?php
$row = $data['address'] ?? [];
$country = $data['country'] ?? [];
$state = $data['state'] ?? [];
$city = $data['city'] ?? [];
$area = $data['area'] ?? [];
$subarea = $data['subarea'] ?? [];
?>
{!! Form::open([ 'route' => ['admin.customer-address.update'], 'method' => 'post', 'class'
=> 'form-horizontal', 'files' => true , 'novalidate','id'=>'addressUpdate']) !!}
{!! Form::hidden('address_id',$row->PK_NO) !!}
{!! Form::hidden('customer_id',$row->F_CUSTOMER_NO) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
            <label for="name">{{trans('form.name')}}<span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::text('name', $row->NAME ?? null, ['class'=>'form-control', 'id'=>'name', 'data-validation-required-message' => 'This field is required','placeholder' => 'Enter name', 'tabindex' => 2,'required']) !!}
                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <label for="mobile_no">{{trans('form.mobile_no')}}<span class="text-danger">*</span></label>
        <div class="controls">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="phonecode2">+88</span>
            </div>
            {!! Form::text('mobile_no',$row->MOBILE_NO ?? NULL,['class'=>'form-control','data-validation-required-message' => 'This field is required','placeholder' => 'Enter mobile no.', 'id' => 'mobile_no', 'tabindex' => 3]) !!}
            {!! $errors->first('mobile_no', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('region') ? 'error' : '' !!}">
           <label for="region">Region <span class="text-danger">*</span></label>
           <div class="controls">
              {!! Form::select('region',$state, $row->F_STATE_NO,['class' =>'form-control select2', 'id'=>'region','data-validation-required-message'=>'This filed is required','placeholder'=>'Select region','tabindex'=>5,'required']) !!}
              {!! $errors->first('region', '<label class="help-block text-danger">:message</label>') !!}
           </div>
        </div>
     </div>
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('city') ? 'error' : '' !!}">
           <label for="city">City <span class="text-danger">*</span></label>
           <div class="controls">
              {!! Form::select('city',$city,$row->F_CITY_NO,['class' => 'form-control', 'id'=>'city','data-validation-required-message' => 'This filed is required','placeholder'=>'Select city','tabindex'=>6,'required']) !!}
              {!! $errors->first('city', '<label class="help-block text-danger">:message</label>') !!}
           </div>
        </div>
     </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('area') ? 'error' : '' !!}">
            <label for="area">Area <span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::select('area',$area,$row->F_AREA_NO,['class' => 'form-control', 'id'=>'area','data-validation-required-message' => 'This filed is required','placeholder'=>'Select area','tabindex'=>6,'required']) !!}
                {!! $errors->first('area', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {!! $errors->has('subarea') ? 'error' : '' !!}">
            <label for="subarea">Sub Area <span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::select('subarea',$subarea ?? [],$row->F_SUBAREA_NO,['class' => 'form-control', 'id'=>'subarea','data-validation-required-message' => 'This filed is required','placeholder'=>'Select area','tabindex'=>6,'required']) !!}
                {!! $errors->first('subarea', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
    
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('ad_1') ? 'error' : '' !!}">
            <label for="ad1">{{trans('form.address_1')}} <span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::text('ad_1', $row->ADDRESS_LINE_1 ?? null,['class'=>'form-control', 'id' => 'ad1','placeholder' =>'Enter address','tabindex' =>8]) !!}
                {!! $errors->first('ad_1', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('ad_2') ? 'error' : '' !!}">
            <label for="ad2">{{trans('form.address_2')}}</label>
            <div class="controls">
                {!! Form::text('ad_2',$row->ADDRESS_LINE_2 ?? null,['class'=>'form-control','id' => 'ad2','placeholder' => 'Enter address','tabindex' => 9]) !!}
                {!! $errors->first('ad_2', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('post_code') ? 'error' : '' !!}">
            <label for="post_code">{{trans('form.post_code')}}</label>
            <div class="controls">
                {!! Form::text('post_code', $row->POST_CODE ?? null,['class'=>'form-control', 'id' =>'post_code', 'placeholder' => 'Post code','tabindex' => 10]) !!}
            </div>
            {!! $errors->first('post_code', '<label class="help-block text-danger">:message</label>') !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('is_default') ? 'error' : '' !!}">
            <label for="is_default">Is deafult <span class="text-danger">*</span></label>
            <div class="controls">
            {!! Form::select('is_default',['1'=>'Yes','0'=>'No'],$row->IS_DEFAULT,['class'=>'form-control', 'data-validation-required-message' => 'This field is required', 'id' => 'is_default', 'tabindex' => 11]) !!}
            {!! $errors->first('is_default', '<label class="help-block text-danger">:message</label>') !!}
        </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
            <label for="is_active">Is active <span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::select('is_active',['1'=>'Yes','0'=>'No'],$row->IS_ACTIVE,['class'=>'form-control', 'data-validation-required-message' => 'This field is required','id' =>'is_active', 'tabindex' =>12]) !!}
            {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
        </div>
        </div>
    </div>
</div>
 <div class="col-md-12 mt-2 mb-2">
        <div class="form-actions text-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="ft-x"></i> @lang('form.btn_cancle')</button>
            <button title="Update" type="submit" class="btn btn-primary" id="submit"><i class="la la-check-square-o"></i> Update</button>
         </div>
    </div>
</div>
{!! Form::close() !!}
