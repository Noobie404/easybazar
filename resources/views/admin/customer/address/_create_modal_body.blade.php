<?php

$customer = $data['customer'] ?? [];
$subarea = [];

?>
{!! Form::open([ 'route' => ['admin.customer-address.store'], 'method' => 'post', 'class' =>
'form-horizontal', 'files' => true , 'novalidate','id'=>'addressForm']) !!}
@csrf
{!! Form::hidden('customer_id',$customer->PK_NO) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
            <label for="name">{{trans('form.name')}}<span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::text('name',$customer->NAME ?? NULL, ['class'=>'form-control', 'id' => 'name', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter name', 'tabindex' => 2, 'required' ]) !!}
                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <label for="mobile_no">{{trans('form.mobile_no')}} <span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="phonecode2">+88</span>
            </div>
            {!! Form::text('mobile_no',$customer->MOBILE_NO ?? NULL,[ 'class' => 'form-control', 'placeholder' => 'Enter mobile no.', 'id' => 'mobile_no','data-validation-required-message' => 'This field is required', 'tabindex' => 3]) !!}
            {!! $errors->first('mobile_no', '<label class="help-block text-danger">:message</label>') !!}

        </div>
    </div>
 </div>
 <div class="row">
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('region') ? 'error' : '' !!}">
           <label for="region">Region <span class="text-danger">*</span></label>
           <div class="controls">
              {!! Form::select('region', $data['state'], null, [ 'class' => 'form-control', 'id'=>'region','data-validation-required-message' => 'This filed is required','placeholder'=>'Select region','tabindex'=>5,'required']) !!}
              {!! $errors->first('region', '<label class="help-block text-danger">:message</label>') !!}
           </div>
        </div>
     </div>
     <div class="col-md-6">
        <div class="form-group {!! $errors->has('city') ? 'error' : '' !!}">
           <label for="city">City <span class="text-danger">*</span></label>
           <div class="controls">
              <select name="city" class="form-control" id="city" data-validation-required-message="This filed is required" tabindex="6" required>
                  <option>Select city</option>
              </select>
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
               <select name="area" class="form-control select2" id="area" data-validation-required-message="This filed is required" tabindex="7" required>
                <option>Select area</option>
               </select>
               {!! $errors->first('area', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('subarea') ? 'error' : '' !!}">
            <label for="subarea">Sub Area <span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::select('subarea',$subarea ?? [],NULL,['class' => 'form-control', 'id'=>'subarea','data-validation-required-message' => 'This filed is required','placeholder'=>'Select subarea','tabindex'=>6,'required']) !!}
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
                {!! Form::text('ad_1',  null, ['class'=>'form-control', 'id' => 'ad1','data-validation-required-message' => 'This filed is required','placeholder' => 'Enter address', 'tabindex' => 8 ]) !!}
                {!! $errors->first('ad_1', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('ad_2') ? 'error' : '' !!}">
            <label for="ad2">{{trans('form.address_2')}}</label>
            <div class="controls">
                {!! Form::text('ad_2',  null, ['class'=>'form-control', 'id' => 'ad2',  'placeholder' => 'Enter address', 'tabindex' => 9,  ]) !!}
                {!! $errors->first('ad_2', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('post_code') ? 'error' : '' !!}">
            <label for="post_code">{{trans('form.post_code')}}</label>
            <div class="controls">
                {!! Form::text('post_code', null, ['class'=>'form-control', 'id' => 'post_code','placeholder' => 'Post code', 'tabindex' => 10 ]) !!}
                {!! $errors->first('post_code', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
 </div>
<div class="row">
    <div class="col-md-12 mt-2 mb-2">
        <div class="form-actions text-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="ft-x"></i> @lang('form.btn_cancle')</button>
            <button title="Update" type="submit" class="btn btn-primary" id="submit"><i class="la la-check-square-o"></i> Save</button>
         </div>
    </div>
</div>
{!! Form::close() !!}
<script>
    $(function () { $("#addressForm input,#addressForm select,#addressForm textarea").not("[type=submit]").jqBootstrapValidation(); } );
</script>
