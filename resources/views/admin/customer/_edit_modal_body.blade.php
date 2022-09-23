{!! Form::open([ 'route' => ['admin.customer.update',$row->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate','id'=>'customerUpdate','autocomplete='=>'off']) !!}
@csrf
<div class="row">
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
            <label for="name">{{trans('form.name')}}<span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::text('name',$row->NAME, ['class'=>'form-control', 'id' => 'name', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter customer name', 'tabindex' => 2,'required' ]) !!}
                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('mobile_no') ? 'error' : '' !!}">
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
</div>
<div class="row">
    <div class="col-md-6">
            <div class="form-group {!! $errors->has('email') ? 'error' : '' !!}">
                <label for="email">{{trans('form.email')}}</label>
                <div class="controls">
                    {!! Form::text('email',  $row->EMAIL, ['class'=>'form-control', 'id' => 'email', 'placeholder' => 'Enter your email', 'tabindex' => 5,'autocomplete'=>'nope']) !!}
                    {!! $errors->first('email', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('password') ? 'error' : '' !!}">
            <label for="password">Password</label>
            <div class="controls">
                {!! Form::password('password',['class'=>'form-control','id'=>'password','placeholder'=>'Enter user password', 'tabindex' => 6,'autocomplete'=>'new-password']) !!}
                <small class="">(Leave it blank if you do not want to change the password)</small>
                {!! $errors->first('password', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('birth_date') ? 'error' : '' !!}">
            <label for="birth_date">Birth date</label>
            <div class="controls">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="la la-calendar-o"></span>
                        </span>
                    </div>
                    <input type='text' class="form-control" name="birth_date" id="datepicker" placeholder="yyyy-mm-dd" tabindex="7" value="{{ $row->BIRTH_DATE }}"/>
                </div>
                {!! $errors->first('birth_date', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('gender') ? 'error' : '' !!}">
            <label for="gender">Gender</label>
            <div class="controls">
                <label>{!! Form::radio('gender','male', $row->GENDER == 'male' ? 'checked': '') !!} Male</label>
                <label>{!! Form::radio('gender','female', $row->GENDER == 'female' ?  'checked': '') !!} Female</label>
                {!! $errors->first('gender', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('photo') ? 'error' : '' !!}">
            <label class="photo" for="photo">Photo</label>
            <div class="controls">
                <div class="fileupload @if(!empty($row->PROFILE_PIC_URL))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                    <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                    @if(!empty($row->PROFILE_PIC_URL))
                    <img src="{{$row->PROFILE_PIC_URL}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                    @endif
                    </span>
                    <span>
                    <label class="btn btn-primary btn-rounded btn-file btn-sm">
                    <span class="fileupload-new"><i class="la la-file-image-o"></i> Select image</span>
                    <span class="fileupload-exists"><i class="la la-reply"></i> Change</span>
                    <input type="file" name="photo" tabindex="9" id="photo"/>
                    </label>
                    <a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail"><i class="la la-times"></i> Remove</a>
                    </span>
                    {{-- <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}}  300 x 300 pixels</span> --}}
                </div>
                {!! $errors->first('photo', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="form-actions text-center">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" ><i class="ft-x"></i> @lang('form.btn_cancle')</button>
        <button title="Update" type="submit" class="btn btn-primary" id="submit"><i class="la la-check-square-o"></i> Update</button>
    </div>
</div>
{!! Form::close() !!}
<script>
    $(function () {
        $("#customerUpdate input,#customerUpdate select,#customerUpdate textarea").not("[type=submit]").jqBootstrapValidation();
        });
    $("#datepicker").datepicker({
        format: "yyyy-mm-dd",
    });
</script>
