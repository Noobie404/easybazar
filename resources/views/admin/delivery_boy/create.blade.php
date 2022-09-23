<?php
$tabindex = 1;
?>
{!! Form::open([ 'route' => [ 'admin.delivery_boy.store'], 'method' => 'post', 'class' => 'form-horizontal','files' => true,'id'=>'deliveryBoyForm','novalidate']) !!}
<div class="form-body p-3">
    <div class="row">
        <div class="col-6">
            <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                <label for="name">Name <span class="text-danger">*</span></label>
                <div class="controls">
                        {!! Form::text('name', null, [ 'class' => 'form-control','data-validation-required-message' => 'This field is required','maxlength' => "255", 'tabindex' =>$tabindex++ ,'id' => 'name']) !!}
                    {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group {!! $errors->has('email') ? 'error' : '' !!}">
                <label for="email">Email <span class="text-danger">*</span></label>
                <div class="controls">
                        {!! Form::email('email', null, [ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required','maxlength' => "255", 'tabindex' =>$tabindex++,'id' => 'email','required' ]) !!}
                    {!! $errors->first('email', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group {!! $errors->has('mobile_no') ? 'error' : '' !!}">
                <label for="mobile_no">Mobile number <span class="text-danger">*</span></label>
                <div class="controls">
                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">+88</span>
                    </div>
                    {!! Form::number('mobile_no', null, [ 'class' => 'form-control','data-validation-required-message' => 'This field is required','maxlength' => "255", 'tabindex' =>$tabindex++,'id' => 'mobile_no','required' ]) !!}
                    {!! $errors->first('mobile_no', '<label class="help-block text-danger">:message</label>') !!}
                  </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group {!! $errors->has('sallery') ? 'error' : '' !!}">
                <label for="sallery">Monthly sallery <span class="text-danger">*</span></label>
                <div class="controls">
                    {!! Form::number('sallery', 0, [ 'class' => 'form-control','tabindex' =>$tabindex++,'id' => 'sallery']) !!}
                    {!! $errors->first('sallery', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group {!! $errors->has('per_delivery_comm') ? 'error' : '' !!}">
                <label for="per_delivery_comm">Per delivery commission<span class="text-danger">*</span></label>
                <div class="controls">
                    {!! Form::number('per_delivery_comm', 0, [ 'class' => 'form-control','tabindex' =>$tabindex++,'id' => 'per_delivery_comm']) !!}
                    {!! $errors->first('per_delivery_comm', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group {!! $errors->has('joining_date') ? 'error' : '' !!}">
                <label for="joining_date">Joining date <span class="text-danger">*</span></label>
                <div class="controls">
                    <input type="text" name="joining_date" class="form-control datepicker" tabindex="{{ $tabindex++ }}" id="joining_date"/>
                    {!! $errors->first('joining_date', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group {!! $errors->has('password') ? 'error' : '' !!}">
                <label for="password">Password <span class="text-danger">*</span></label>
                <div class="controls">
                    <input type="password" name="password" class="form-control" id="password" tabindex="{{ $tabindex++ }}"/>
                    {!! $errors->first('password', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>


        <div class="col-6">
            <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                <label for="is_active">Is Active <span class="text-danger">*</span></label>
                <div class="controls">
                    {!! Form::select('is_active', ['1'=> 'Yes','0'=> 'No'],1,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++ ]) !!}
                    {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                </div>
             </div>
         </div>
        <div class="col-6">
            <div class="form-group {!! $errors->has('address') ? 'error' : '' !!}">
                <label for="address">Address <span class="text-danger">*</span></label>
                <div class="controls">
                    {!! Form::textarea('address', null, [ 'class' => 'form-control', 'placeholder' => 'Enter name', 'data-validation-required-message' => 'This field is required','maxlength' => "255", 'tabindex' =>$tabindex++,'id' => 'address','required','rows'=>'3', 'cols'=>'50' ]) !!}
                    {!! $errors->first('address', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group {!! $errors->has('photo') ? 'error' : '' !!}">
            <label class="photo">Photo</label>
                <div class="controls">
                    <div class="fileupload @if(!empty($row->PROFILE_PIC_URL))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                        <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                        @if(!empty($row->PROFILE_PIC_URL))
                        <img src="{{asset($row->PROFILE_PIC_URL)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
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
                        <input type="file" name="photo" tabindex="{{ $tabindex++ }}" id="photo"/>
                        </label>
                        <a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                        <i class="la la-times"></i> Remove
                        </a>
                        </span>
                        <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}}  300 x 300 pixels</span>
                    </div>
                    {!! $errors->first('photo', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
    </div>

   <div class="form-actions text-center">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="ft-x"></i> @lang('form.btn_cancle')</button>
        <button title="Update" type="submit" class="btn btn-primary" id="submit"><i class="la la-check-square-o"></i> Save</button>
   </div>
</div>
{!! Form::close() !!}


<script>
$(function () {
    $(".datepicker").datepicker({
        format: "yyyy-mm-dd",
    });

    $("#deliveryBoyForm input,#deliveryBoyForm select,#deliveryBoyForm textarea").not("[type=submit]").jqBootstrapValidation();
});
</script>
