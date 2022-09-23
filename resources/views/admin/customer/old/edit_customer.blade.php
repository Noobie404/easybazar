@extends('admin.layout.master')

@section('Customer Management','open')
@section('customer_list','active')

@section('title') Customer | Update @endsection
@section('page-name') Update Customer @endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Customer</li>
@endsection
@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">

@endpush('custom_css')

@section('content')
    <div class="card card-success min-height">
        <div class="card-header">
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
            {!! Form::open([ 'route' => ['admin.customer.update',$customer->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {!! $errors->has('customer') ? 'error' : '' !!}">
                            <label>{{trans('form.select_customer')}}<span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="controls">
                                        <label>{!! Form::radio('customer', 'ukshop', $customer->F_SHOP_NO == 0 ? true : '') !!} {{trans('form.agent')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="controls">
                                        <label>{!! Form::radio('customer','seller', $customer->F_SHOP_NO == 0 ? '' : true) !!} Seller</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {!! $errors->has('agent') ? 'error' : '' !!}">
                                            <div class="controls">
                                            {!! Form::select('agent', $data['seller_combo'], $customer->F_SHOP_NO != 0 ? $customer->seller->PK_NO : 0, ['class'=>'form-control mb-1 select2', 'data-validation-required-message' => 'This field is required', 'id' => 'booking_under', 'tabindex' => 1]) !!}
                                            {!! $errors->first('agent', '<label class="help-block text-danger">:message</label>') !!}
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
                                {!! Form::text('name',  $customer->NAME, ['class'=>'form-control', 'id' => 'name', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter customer name', 'tabindex' => 1,  ]) !!}
                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('mobileno') ? 'error' : '' !!}">
                            <label for="mobileno">{{trans('form.mobile_no')}}<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::text('mobileno',  $customer->MOBILE_NO, [ 'class' => 'form-control',  'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter mobile no', 'tabindex' => 2]) !!}
                                {!! $errors->first('mobileno', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('altno') ? 'error' : '' !!}">
                            <label for="altno">{{trans('form.alternative_no')}}</label>
                            <div class="controls">
                                {!! Form::text('altno', $customer->ALTERNATE_NO, ['class'=>'form-control', 'id' => 'altno',  'placeholder' => 'Enter alternative mobile no', 'tabindex' => 3,  ]) !!}
                                {!! $errors->first('altno', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('email') ? 'error' : '' !!}">
                            <label for="email">{{trans('form.email')}}<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::text('email',  $customer->EMAIL, ['class'=>'form-control mb-1', 'id' => 'email', 'placeholder' => 'Enter your email', 'tabindex' => 4,  ]) !!}
                                {!! $errors->first('email', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('ukid') ? 'error' : '' !!}">
                            <label for="ukid">Customer ID</label>
                            <div class="controls">
                                {!! Form::text('ukid', $customer->EASYBAZAR_ID, ['class'=>'form-control mb-1', 'id' => 'ukid',  'placeholder' => 'Enter  user id', 'tabindex' => 6,  ]) !!}
                                {!! $errors->first('ukid', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {!! $errors->has('password') ? 'error' : '' !!}">
                            <label for="password">Customer Password<span class="text-danger">*</span> <small class="">(Leave it blank if you do not want to change the password)</small></label>
                            <div class="controls">
                                {!! Form::password('password', ['class'=>'form-control mb-1', 'id' => 'password',  'placeholder' => 'Enter user password', 'tabindex' => 6,  ]) !!}
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
                                    <label>{!! Form::radio('gender','0', $customer->GENDER = 0 ?? 'checked') !!} Male</label>
                                    <label>{!! Form::radio('gender','1', $customer->GENDER = 1 ??  'checked') !!} Female</label>
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
                        <label class="photo">Photo</label>
                        <div class="controls">
                            <div class="fileupload @if(!empty($customer->PROFILE_PIC_URL))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                @if(!empty($customer->PROFILE_PIC_URL))
                                <img src="{{asset($customer->PROFILE_PIC_URL)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
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
                                <input type="file" name="photo" tabindex="11" id="photo"/>
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
                    <div class="col-md-12">
                        <div class="form-actions text-center">
                            <a href="{{route('admin.customer.list')}}" class="btn btn-warning mr-1" title="Cancel"><i class="ft-x"></i> {{ trans('form.btn_cancle') }}</a>
                            <button type="submit" onclick="return confirm('Are you sure you want to update?')" class="btn bg-primary bg-darken-1 text-white" title="Save">
                                <i class="la la-check-square-o"></i> {{ trans('form.btn_edit') }} </button>
                        </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
<!--push from page-->
@push('custom_js')
 <script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
 <script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
 <script type="text/javascript" src="{{ asset('assets/pages/customer.js')}}"></script>
 <script src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>

@endpush('custom_js')
