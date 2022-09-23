@extends('admin.layout.master')

@section('Seller Management','open')
@section('seller_list','active')

@section('title') Branch | Edit @endsection
@section('page-name') Edit Branch @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Edit Branch</li>
@endsection

<?php
    $tab_index  = 1;
    $tab        = request()->get('tab') ?? 'one';
    $seller     = $data['seller'];
    // $states = $data['states'] ?? [];
    // $cities = $data['cities'] ?? [];
    $country_options    = getOptionsData('SS_COUNTRY',['IS_ACTIVE' => 1],'PK_NO','NAME');
    $states_options     = getOptionsData('SS_STATE',['IS_ACTIVE' => 1],'PK_NO','STATE_NAME');
    $cities_options     = getOptionsData('SS_CITY',['IS_ACTIVE' => 1],'PK_NO','CITY_NAME');



?>
<!--push from page-->
@push('custom_css')
 <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
 <style>
    #scrollable-dropdown-menu2 .tt-menu {max-height: 260px;overflow-y: auto;width: 100%;border: 1px solid #333;border-radius: 5px;}
    .twitter-typeahead{display: block !important;}
    .tt-hint {color: #999 !important;}
    /* Default mode */
    .tab-card-header>.nav-tabs{border:none;margin:0}
    .tab-card-header>.nav-tabs>li{margin-right:15px}
    .tab-card-header>.nav-tabs>li>a{border:0;border-bottom:2px solid transparent;margin-right:0;color:#737373;padding:2px 15px}
    .tab-card-header>.nav-tabs>li>a.show{border-bottom:2px solid #ef7026;color:#ef7026}
    .tab-card-header>.nav-tabs>li>a:hover{color:#ef7026}
    .tab-card-header>.tab-content{padding-bottom:0}
    .nav-tabs .nav-link:hover{border-color:#e9ecef #e9ecef #dee2e6!important}

</style>
@endpush('custom_css')


@section('content')
    <div class="card card-success min-height">
        <div class="card-header">
            <h4 class="card-title" id="basic-layout-colored-form-control">Edit Branch</h4>
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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mt-3 tab-card">
                                <div class="card-header tab-card-header">
                                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $tab == 'one' ? 'show' : '' }}" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true" data-route="{{ route('admin.seller.edit',['id' => $seller->PK_NO,'tab' => 'one']) }}" >Branch Account</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $tab == 'two' ? 'show' : '' }}" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false" data-route="{{ route('admin.seller.edit',['id' => $seller->PK_NO,'tab' => 'two']) }}" >Business Information</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $tab == 'three' ? 'show' : '' }}" id="three-tab" data-toggle="tab" href="#three" role="tab" aria-controls="Three" aria-selected="false" data-route="{{ route('admin.seller.edit',['id' => $seller->PK_NO,'tab' => 'three']) }}">Bank Account</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link {{ $tab == 'four' ? 'show' : '' }}" id="four-tab" data-toggle="tab" href="#four" role="tab" aria-controls="Four" aria-selected="false" data-route="{{ route('admin.seller.edit',['id' => $seller->PK_NO,'tab' => 'four']) }}">Warehouse Address</a>
                                    </li> --}}
                                    </ul>
                                </div>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade {{ $tab == 'one' ? 'show active' : '' }} p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                                        <fieldset>
                                            {!! Form::open([ 'route' => ['admin.seller.update',$seller->PK_NO ], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                                                <input type="hidden" value="two" name="tab" />
                                                <h4>Branch Account</h4>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                                            <label>Full name<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::text('name', $seller->NAME,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>

                                                        <div class="form-group {!! $errors->has('email') ? 'error' : '' !!}">
                                                            <label>Contact Email address<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::email('email',  $seller->EMAIL,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                                {!! $errors->first('email', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                        <div class="form-group {!! $errors->has('phone') ? 'error' : '' !!}">
                                                            <label>Phone Number<span class="text-danger">*</span></label>
                                                            <div class="controls">
                                                                {!! Form::text('phone',  $seller->MOBILE_NO,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                                {!! $errors->first('phone', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>

                                                        <div class="form-group {!! $errors->has('password') ? 'error' : '' !!}">
                                                            <label>Password (Enter password if you want to change)</label>
                                                            <div class="controls">
                                                                {!! Form::password('password',[ 'class' => 'form-control mb-1', 'placeholder' => '', 'tabindex' => $tab_index++, 'minlength' => 6, 'data-validation-minlength-message' => 'minimum number of characters 6' ]) !!}
                                                                {!! $errors->first('password', '<label class="help-block text-danger">:message</label>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-actions text-center">
                                                            <a href="{{ route('admin.seller.list')}}" class="btn btn-warning" title="Cancel"> <i class="ft-x"></i> Cancel </a>
                                                            <button type="submit" name="submit" value="save" class="btn btn-primary"> <i class="la la-check-square-o"></i> Update </button>
                                                            <button type="submit" class="btn btn-primary" name="submit" value="update_next"> <i class="la la-check-square-o"></i> Save & next </button>

                                                        </div>
                                                    </div>
                                                </div>
                                            {!! Form::close() !!}
                                        </fieldset>
                                    </div>


                                    <div class="tab-pane fade p-3 {{ $tab == 'two' ? 'show active' : '' }} " id="two" role="tabpanel" aria-labelledby="two-tab">
                                        <fieldset>
                                            @if($tab == 'two')
                                            {!! Form::open([ 'route' => ['admin.seller.update',$seller->PK_NO ], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                                            <input type="hidden" value="three" name="tab" />
                                            <h4>Business Information</h4>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group {!! $errors->has('legal_name') ? 'error' : '' !!}">
                                                        <label>Legal Name<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('legal_name', $seller->BusinessInfo->OWNER_NAME ?? old('legal_name'),[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('legal_name', '<label class="help-block text-danger">:message</label>') !!}

                                                        </div>
                                                    </div>

                                                    <div class="form-group {!! $errors->has('shop_name') ? 'error' : '' !!}">
                                                        <label>Display Name<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('shop_name', $seller->BusinessInfo->SHOP_NAME ?? '', [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('shop_name', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group {!! $errors->has('address1') ? 'error' : '' !!}">
                                                        <label>Address 1<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('address1', $seller->BusinessInfo->ADDRESS1 ?? old('address1'),[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('address1', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group {!! $errors->has('address2') ? 'error' : '' !!}">
                                                        <label>Address 2<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('address2', $seller->BusinessInfo->ADDRESS2 ?? old('address2'),[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('address2', '<label class="help-block text-danger">:message</label>') !!}

                                                        </div>
                                                    </div>
                                                    <div class="form-group {!! $errors->has('in_charge') ? 'error' : '' !!}">
                                                        <label>Person in Charge Name<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('in_charge', $seller->BusinessInfo->INCHARGE_NAME ?? old('in_charge'),[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('in_charge', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group {!! $errors->has('registration_no') ? 'error' : '' !!}">
                                                        <label>Business Registration Number<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('registration_no', $seller->BusinessInfo->BUSINESS_REGI_NO ?? old('registration_no'),[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('registration_no', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group {!! $errors->has('registration_file') ? 'error' : '' !!}">
                                                        <label>Upload Business Document<span class="text-danger"></span></label>
                                                        <div class="controls">
                                                            {!! Form::file('registration_file[]',[ 'class' => 'form-control mb-1', 'placeholder' => '', 'tabindex' => $tab_index++, 'multiple' => true, ]) !!}
                                                            {!! $errors->first('registration_file', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>
                                                    @if(isset($data['business_doc']) && count($data['business_doc'])>0)
                                                        <div class="form-group">
                                                            <ul class="list-group" style="margin-left: 30px;">
                                                                @foreach ($data['business_doc'] as $kd => $doc)
                                                                <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-success ">
                                                                <a class="link" target="_blank" href="{{ asset($doc->PATH) }}">{{ $doc->NAME }}</a>
                                                                <a href="{{ route('admin.seller.business_doc_delete', $doc->PK_NO) }}" onclick="return confirm('Are you sure you want to permanently delete this document')"><i class="fa fa-trash"></i></a>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    <div class="form-group {!! $errors->has('seller_tin') ? 'error' : '' !!}">
                                                        <label>Seller TIN<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('seller_tin', $seller->BusinessInfo->TIN_NO ?? old('seller_tin'),[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('seller_tin', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group {!! $errors->has('state') ? 'error' : '' !!}">
                                                        <label>Division<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::select('state',$states_options,$seller->BusinessInfo->DIVISION_NO ?? null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++, 'onchange' => "getChildOptions(this,'SS_CITY','PK_NO','CITY_NAME','city_id','F_STATE_NO')"  ]) !!}
                                                            {!! $errors->first('state', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group {!! $errors->has('city') ? 'error' : '' !!}">
                                                        <label>City<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::select('city',$cities_options,$seller->BusinessInfo->CITY_NO ?? null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++, 'id' => 'city_id' ]) !!}
                                                            {!! $errors->first('city', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group {!! $errors->has('post_code') ? 'error' : '' !!}">
                                                        <label>Post code<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('post_code', $seller->BusinessInfo->POST_CODE ?? null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('post_code', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-actions text-center">
                                                        <a href="{{ route('admin.seller.list')}}" class="btn btn-warning" title="Cancel"> <i class="ft-x"></i> Cancel </a>
                                                        <button type="submit" name="submit" value="save" class="btn btn-primary"> <i class="la la-check-square-o"></i> Update </button>
                                                        <button type="submit" class="btn btn-primary" name="submit" value="update_next"> <i class="la la-check-square-o"></i> Save & next </button>

                                                    </div>
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                            @endif
                                        </fieldset>
                                    </div>


                                    <div class="tab-pane fade p-3 {{ $tab == 'three' ? 'show active' : '' }} " id="three" role="tabpanel" aria-labelledby="three-tab">
                                        <fieldset>
                                            @if($tab == 'three')
                                            {!! Form::open([ 'route' => ['admin.seller.update',$seller->PK_NO ], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                                            <input type="hidden" value="four" name="tab" />
                                            <div class="row">
                                                <div class="col-4">
                                                    <h4>Bank Account</h4>
                                                    <div class="form-group {!! $errors->has('account_title') ? 'error' : '' !!}">
                                                        <label>Account Title<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('account_title', $seller->BankInfo->ACC_TITLE ?? old('account_title'),[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('account_title', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group {!! $errors->has('account_no') ? 'error' : '' !!}">
                                                        <label>Account Number<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('account_no', $seller->BankInfo->ACC_NO ?? old('account_no'),[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('account_no', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group {!! $errors->has('bank_name') ? 'error' : '' !!}">
                                                        <label>Bank Name<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('bank_name', $seller->BankInfo->BANK_NAME ?? old('bank_name'),[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('bank_name', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group {!! $errors->has('branch_name') ? 'error' : '' !!}">
                                                        <label>Branch Name<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('branch_name', $seller->BankInfo->BRANCH_NAME ?? old('branch_name'),[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('branch_name', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group {!! $errors->has('routing_number') ? 'error' : '' !!}">
                                                        <label>Routing Number<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('routing_number', $seller->BankInfo->ROUTING_NO ?? old('routing_number'),[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('routing_number', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-actions text-center">
                                                        <a href="{{ route('admin.seller.list')}}" class="btn btn-warning" title="Cancel"> <i class="ft-x"></i> Cancel </a>
                                                        <button type="submit" name="submit" value="save" class="btn btn-primary"> <i class="la la-check-square-o"></i> Update </button>
                                                        <button type="submit" class="btn btn-primary" name="submit" value="update_next"> <i class="la la-check-square-o"></i> Save & next </button>

                                                    </div>
                                                </div>
                                            </div>

                                            {!! Form::close() !!}
                                            @endif
                                        </fieldset>
                                    </div>


                                    <div class="tab-pane fade p-3 {{ $tab == 'four' ? 'show active' : '' }}" id="four" role="tabpanel" aria-labelledby="four-tab">
                                        <fieldset>
                                            @if($tab == 'four')
                                            {!! Form::open([ 'route' => ['admin.seller.update',$seller->PK_NO ], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                                            <input type="hidden" value="complete" name="tab" />
                                            <div class="row">
                                                <div class="col-4">
                                                    <h4>Warehouse Address</h4>
                                                    <div class="form-group {!! $errors->has('warehouse_name') ? 'error' : '' !!}">
                                                        <label>Warehouse name<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('warehouse_name', $seller->WarehousInfo->OWNER_NAME ?? old('warehouse_name'),[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('warehouse_name', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group {!! $errors->has('address') ? 'error' : '' !!}">
                                                        <label>Address<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('address', $seller->WarehousInfo->ADDRESS1 ?? old('address'),[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('address', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group {!! $errors->has('phone_no') ? 'error' : '' !!}">
                                                        <label>Phone number<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('phone_no', $seller->WarehousInfo->PHONE_NO ?? old('phone_no') ,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('phone_no', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group {!! $errors->has('country') ? 'error' : '' !!}">
                                                        <label>Country/ Region<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::select('country',$country_options ?? [],$seller->WarehousInfo->COUNTRY_NO ?? 1,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'select one', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('country', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group {!! $errors->has('state') ? 'error' : '' !!}">
                                                        <label>Division<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::select('state',$states_options,$seller->WarehousInfo->DIVISION_NO ?? null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'select one', 'tabindex' => $tab_index++, 'onchange' => "getChildOptions(this,'SS_CITY','PK_NO','CITY_NAME','city_id','F_STATE_NO')"  ]) !!}
                                                            {!! $errors->first('state', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group {!! $errors->has('city') ? 'error' : '' !!}">
                                                        <label>City<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::select('city',$cities_options,$seller->WarehousInfo->CITY_NO ?? null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'select one', 'tabindex' => $tab_index++, 'id' => 'city_id' ]) !!}
                                                            {!! $errors->first('city', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>



                                                    <div class="form-group {!! $errors->has('post_code') ? 'error' : '' !!}">
                                                        <label>Postcode<span class="text-danger">*</span></label>
                                                        <div class="controls">
                                                            {!! Form::text('post_code', $seller->WarehousInfo->POST_CODE ?? old('post_code'),[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => '', 'tabindex' => $tab_index++ ]) !!}
                                                            {!! $errors->first('post_code', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-actions text-center">
                                                        <a href="{{ route('admin.seller.list')}}" class="btn btn-warning" title="Cancel"> <i class="ft-x"></i> Cancel </a>
                                                        <button type="submit" class="btn btn-primary" name="submit" value="update_next"> <i class="la la-check-square-o"></i> Update </button>

                                                    </div>
                                                </div>
                                            </div>

                                            {!! Form::close() !!}
                                            @endif
                                        </fieldset>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!--push from page-->
@push('custom_js')

 <script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
 <script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
 <script type="text/javascript" src="{{ asset('assets/pages/country.js') }}"></script>
 <script>
$(document).on('click', '.nav-link', function(e) {
    var route = $(this).data('route');
    var aria = $(this).attr('aria-controls').toLowerCase();
    window.location.href = route;
    // alert(route);
    // history.pushState({}, null, route);

    $('.nav-link').removeClass('show');
    var id = aria+'-tab';
    $('#'+id).addClass('show');

})

function find_max(nums) {
     let max_num = Number.NEGATIVE_INFINITY; // smaller than all other numbers
    for (let num of nums) {
 if (num > max_num) {
     // (Fill in the missing line here)
     }
     }
     return max_num;
     }

 </script>

@endpush('custom_js')
