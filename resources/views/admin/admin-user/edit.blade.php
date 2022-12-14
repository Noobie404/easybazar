@extends('admin.layout.master')
@section('admin-user','active')

@section('title') Admin | Edit @endsection
@section('page-name')Edit Admin User @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.admin-user') }}"> Admin User </a></li>
    <li class="breadcrumb-item active">Edit Admin User</li>
@endsection

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">
@endpush
@section('content')
    <div class="col-md-12">

        @if($errors->all())
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        @endif

        <div class="card card-success min-height">
            <div class="card-header">
                <h4 class="card-title" id="basic-layout-colored-form-control">User Profile</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    {!! Form::open([ 'route' => ['admin.admin-user.update', $user->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                    <input type="hidden" name="user" value="admin_user" />
                    <div class="form-body">
                        {{-- <h4 class="form-section"><i class="la la-eye"></i> About User</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <div class="controls">
                                        {!! Form::text('username', $user->NAME,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter username', 'tabindex' => 1 ]) !!}
                                        {!! $errors->first('username', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Designation</label>
                                    <div class="controls">
                                        {!! Form::text('designation', $user->DESIGNATION,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter designation', 'tabindex' => 1 ]) !!}
                                        {!! $errors->first('designation', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="controls">
                                        {!! Form::select('status', ['1' => 'Yes', '0' => 'No'], $user->auth_status, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Select status', 'data-validation-required-message' => 'This field is required']) !!}
                                        {!! $errors->first('status', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div> --}}


                    <h4 class="form-section"><i class="ft-mail"></i>About User</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <div class="controls">
                                    {!! Form::text('username', $user->NAME,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter username', 'tabindex' => 1 ]) !!}
                                    {!! $errors->first('username', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Designation</label>
                                <div class="controls">
                                    {!! Form::text('designation', $user->DESIGNATION,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter designation', 'tabindex' => 1 ]) !!}
                                    {!! $errors->first('designation', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <div class="controls">
                                    {!! Form::select('status', ['1' => 'Yes', '0' => 'No'], $user->auth_status, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Select status', 'data-validation-required-message' => 'This field is required']) !!}
                                    {!! $errors->first('status', '<label class="help-block text-danger">:message</label>') !!}
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contact Number</label>
                                <div class="controls">
                                    {!! Form::text('mobile_no', $user->MOBILE_NO,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter contact number', 'tabindex' => 1 ]) !!}
                                    {!! $errors->first('mobile_no', '<label class="help-block text-danger">:message</label>') !!}
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <div class="controls">
                                    {!! Form::text('email', $user->EMAIL,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter email', 'tabindex' => 1 ]) !!}
                                    {!! $errors->first('email', '<label class="help-block text-danger">:message</label>') !!}
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Gender</label>
                                <div class="controls">
                                    {!! Form::select('gender', ['1' => 'Male', '0' => 'Female'] , $user->GENDER, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Select gender', 'data-validation-required-message' => 'This field is required']) !!}
                                    {!! $errors->first('gender', '<label class="help-block text-danger">:message</label>') !!}
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Can Login</label>
                                <div class="controls">
                                    {!! Form::select('can_login', ['1' => 'Yes', '0' => 'No'] , $user->CAN_LOGIN, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Select who can login', 'data-validation-required-message' => 'This field is required']) !!}
                                    {!! $errors->first('can_login', '<label class="help-block text-danger">:message</label>') !!}
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Enter New Password</label>
                                <div class="controls">
                                    {!! Form::password('password',[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter New password', 'tabindex' => 1 ]) !!}
                                    {!! $errors->first('password', '<label class="help-block text-danger">:message</label>') !!}
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <div class="controls">
                                    {!! Form::password('password_confirmation',[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter new password confirmation', 'tabindex' => 1 ]) !!}
                                    {!! $errors->first('password_confirmation', '<label class="help-block text-danger">:message</label>') !!}
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="row">
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label>Role name</label>
                                <div class="controls">
                                    {!! Form::select('role', $role, $user->role_id, [ 'class' => 'form-control mb-1', 'placeholder' => 'Select role name', 'data-validation-required-message' => 'This field is required']) !!}
                                </div>
                                @if ($errors->has('role'))
                                    <span class="alert alert-danger">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('form.admin_user_form_field_group_name')</label>
                                <div class="controls">
                                    {!! Form::select('user_group', $userGroup, $user->F_GROUP_NO, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Select Group name']) !!}
                                    {!! $errors->first('user_group', '<label class="help-block text-danger">:message</label>') !!}
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Profile Pic <span class="required"></span></h5>
                            <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                             <div class="controls">
                                 <div class="fileupload @if(!empty($user->PROFILE_PIC_URL))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                 <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">

                                 <img src="{{fileExit($user->PROFILE_PIC_URL)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>

                                 </span>
                                 <span>
                                 <label class="btn btn-info text-white btn-file btn-sm">
                                 <span class="fileupload-new">
                                 <i class="la la-file-image-o"></i> Select Image
                                 </span>
                                 <span class="fileupload-exists">
                                 <i class="la la-reply"></i> Change
                                 </span>
                                 {!! Form::file('profile_pic', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'IS ACTIVE', 'tabindex' => 5]) !!}
                                 </label>
                                 <a href="#" class="btn fileupload-exists btn-danger btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                 <i class="la la-times"></i> Remove
                                 </a>
                                 </span>
                                 <br>
                                 <span class="MainToUpload edit-3-color" style="font-size: 12px; color: #bf4c4c;">File types jpg, png.</span>
                              </div>
                              @if ($errors->has('profile_pic'))
                              <span class="alert alert-danger">
                                  <strong>{{ $errors->first('profile_pic') }}</strong>
                              </span>
                          @endif
                                         </div>

                         </div>


                         </div>
                    </div>


                    <div class="form-actions text-center">
                        <a href="{{ route('admin.admin-user')}}" class="btn btn-warning mr-1" title="Cancel"><i class="ft-x"></i> Cancel</a>
                        <button type="submit" class="btn btn-primary" title="Save"><i class="la la-check-square-o"></i> Save changes</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom_js')
<script type="text/javascript" src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
@endpush
