@extends('admin.layout.master')

@section('Customer Management','open')
@section('merchant_list','active')

@section('title') Edit Merchant @endsection
@section('page-name') Edit Merchant @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">@lang('admin_role.breadcrumb_title')  </a></li>
<li class="breadcrumb-item active">Merchant</li>
@endsection

<?php

    $roles = userRolePermissionArray();
    $method_name = request()->route()->getActionMethod();
    $tab_index = 1;
    $row = $data['row'];

?>

<!--push from page-->
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/file_upload/image-uploader.min.css')}}">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
                <!--?php vError($errors) ?-->
                <div class="card-content">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified no-border">
                            <li class="nav-item">
                                <a class="nav-link active" id="productBasic-tab1" data-toggle="tab" href="#productBasic" aria-controls="productBasic" aria-expanded="true">Merchant Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="linkIcon1-tab1" data-toggle="tab" href="#linkIcon1" aria-controls="linkIcon1" aria-expanded="false" >Address</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="linkIconOpt1-tab1" data-toggle="tab" href="#linkIconOpt1" aria-controls="linkIconOpt1">Stock Info</a>
                            </li>
                        </ul>

                        <div class="tab-content border-tab-content">
                            <div role="tabpanel" class="tab-pane active" id="productBasic" aria-labelledby="productBasic-tab1" aria-expanded="true">
                                {!! Form::open([ 'route' => ['admin.merchant.update', $row->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('customername') ? 'error' : '' !!}">
                                            <label>{{trans('form.name')}}<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::text('customername',  $row->NAME, ['class'=>'form-control mb-1', 'id' => 'customername', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter name', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('customername', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('country3') ? 'error' : '' !!}">
                                            <label>{{trans('form.country')}}</label>
                                            <div class="controls">
                                                <select name="country3" id="country3" class="form-control mb-1 select2" tabindex="{{ $tab_index++ }}">
                                                    @foreach ($data['country'] as $item)
                                                        <option value="{{ $item->PK_NO }}" data-dial_code="{{ $item->DIAL_CODE }}" {{ $item->PK_NO == 2 ? "selected='selected'" : '' }}>{{ $item->NAME }} ({{ $item->DIAL_CODE }})</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('country3', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label>{{trans('form.mobile_no')}}</label>
                                        <div class="input-group  {!! $errors->has('mobileno') ? 'error' : '' !!}">
                                            <div class="input-group-prepend ">
                                                <span class="input-group-text" id="phonecode4">+60</span>
                                            </div>
                                            {!! Form::text('mobileno',$row->MOBILE_NO,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter mobile No', 'tabindex' => $tab_index++]) !!}
                                            {!! $errors->first('mobileno', '<label class="help-block text-danger">:message</label>') !!}


                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('altno') ? 'error' : '' !!}">
                                            <label>{{trans('form.alternative_no')}}</label>
                                            <div class="controls">
                                                {!! Form::text('altno',  $row->ALTERNATE_NO, ['class'=>'form-control mb-1', 'id' => 'altno',  'placeholder' => 'Enter Alternative mobile no', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('altno', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                   

                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('fbid') ? 'error' : '' !!}">
                                            <label>{{trans('form.fb_id')}}</label>
                                            <div class="controls">
                                                {!! Form::text('fbid',  $row->FB_ID, ['class'=>'form-control mb-1', 'id' => 'fbid',  'placeholder' => 'Enter facebook id', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('fbid', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('insid') ? 'error' : '' !!}">
                                            <label>{{trans('form.ins_id')}}</label>
                                            <div class="controls">
                                                {!! Form::text('insid',  $row->IG_ID, ['class'=>'form-control mb-1', 'id' => 'insid',  'placeholder' => 'Enter instagram id', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('insid', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('email') ? 'error' : '' !!}">
                                            <label>{{trans('form.email')}}</label>
                                            <div class="controls">
                                                {!! Form::email('email',  $row->EMAIL, ['class'=>'form-control mb-1', 'id' => 'email', 'placeholder' => 'Enter email', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('email', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('ukpass') ? 'error' : '' !!}">
                                            <label>Password</label>
                                            <div class="controls">
                                                {!! Form::password('ukpass', ['class'=>'form-control mb-1', 'id' => 'ukpass', 'placeholder' => 'Enter azuramart pass', 'tabindex' => $tab_index++,  ]) !!}
                                                {!! $errors->first('ukpass', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('short_name') ? 'error' : '' !!}">
                                            <label>Short Name</label>
                                            <div class="controls">
                                                {!! Form::text('short_name',  $row->SHORT_NAME, ['class'=>'form-control mb-1', 'id' => 'short_name', 'placeholder' => 'Enter short name', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tab_index++, 'minlength' => 3, 'maxlength' => 3, 'data-validation-maxlength-message' => 'This field is required',  ]) !!}
                                                {!! $errors->first('short_name', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-2 mb-2">
                                        <div class="form-actions text-center">
                                            <a href="{{route('admin.merchant.list')}}" class="btn btn-warning mr-1" title="Cancel"><i class="ft-x"></i> {{ trans('form.btn_cancle') }}</a>
                                            <button type="submit" class="btn bg-primary bg-darken-1 text-white" title="Save">
                                             <i class="la la-check-square-o"></i> {{ trans('form.btn_save') }} </button>
                                         </div>
                                     </div>


                                </div>
                                {!! Form::close() !!}
                            </div>

                            <!-- Customer Address -->

                             <div class="tab-pane" id="linkIcon1" role="tabpanel" aria-labelledby="linkIcon1-tab1" aria-expanded="false">



                            </div>
                            <div class="tab-pane" id="linkIconOpt1" role="tabpanel" aria-labelledby="linkIconOpt1-tab1" aria-expanded="false">
                                <p>Cookie icing tootsie roll cupcake jelly-o sesame snaps. Gummies cookie dragée cake jelly marzipan
                                    donut pie macaroon. Gingerbread powder chocolate cake icing. Cheesecake gummi bears ice cream
                                    marzipan.
                                </p>
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
