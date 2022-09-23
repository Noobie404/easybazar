@extends('admin.layout.master')
@section('vendor','active')

@section('title') Vendor | Create @endsection
@section('page-name') Create Vendor @endsection

<?php
$tab_index = 1;
$branch_id =  null;
if(Auth::user()->USER_TYPE == 10){
    $branch_id = Auth::user()->SHOP_ID;
}
?>

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.admin-user') }}"> Vendor </a></li>
    <li class="breadcrumb-item active">Create vendor</li>
@endsection
<!--push from page-->
@push('custom_css')
 <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
@endpush('custom_css')
@section('content')
    <div class="card card-success min-height">
        <div class="card-header">
            <h4 class="card-title" id="basic-layout-colored-form-control"><i class="ft-plus text-primary"></i> Add New
         Vendor</h4>
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
                {!! Form::open([ 'route' => 'admin.vendor.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('branch_id') ? 'error' : '' !!}">
                                    <label>Branch<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::select('branch_id', $branch, $branch_id, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select branch', 'tabindex' => $tab_index++ ]) !!}
                                        {!! $errors->first('branch_id', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                    <label>@lang('vendor.name')<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::text('name', null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter name', 'tabindex' => $tab_index++ ]) !!}
                                        {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('phone') ? 'error' : '' !!}">
                                    <label>@lang('vendor.phone')<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::number('phone', null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter phone number', 'tabindex' => $tab_index++ ]) !!}
                                        {!! $errors->first('phone', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('country') ? 'error' : '' !!}">
                                    <label>@lang('vendor.country')<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::select('country', $country, 1, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Please select country', 'data-validation-required-message' => 'This field is required','tabindex' => $tab_index++]) !!}
                                        {!! $errors->first('country', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="form-group {!! $errors->has('has_loyality') ? 'error' : '' !!}">
                                    <label>@lang('vendor.has_loyality')<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::select('has_loyality', ['1' => 'Yes', '0' => 'No'], null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Please select', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tab_index++]) !!}
                                        {!! $errors->first('has_loyality', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-md-8">
                                <div class="form-group {!! $errors->has('address') ? 'error' : '' !!}">
                                    <label>@lang('vendor.address')<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::textarea('address', null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter address', 'tabindex' => $tab_index++, 'rows' => 2 ]) !!}
                                        {!! $errors->first('address', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="form-actions mt-10 text-center">
                        <a href="{{ route('admin.vendor')}}"  class="btn btn-warning mr-1" title="Cancel"><i class="ft-x"></i> Cancel</a>
                        <button type="submit" class="btn btn-primary" title="Save"><i class="la la-check-square-o"></i> Save </button>
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
@endpush('custom_js')
