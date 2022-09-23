@extends('admin.layout.master')

@section('System Settings','open')
@section('api_list','active')

@section('title') API List Edit @endsection
@section('page-name') API List Edit @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Edit API List</li>
@endsection

<!--push from page-->
@push('custom_css')
 <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
@endpush('custom_css')
@php
$row = $data['row'];
@endphp

@section('content')
    <div class="card card-success min-height">
        <div class="card-header">
            <h4 class="card-title" id="basic-layout-colored-form-control"><i class="ft-plus text-primary"></i> Edit Agent</h4>
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
                {!! Form::open([ 'route' => ['admin.apilist.update', $row->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                    @csrf
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                    <label>Name<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::text('name',$row->NAME,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter name', 'tabindex' => 1 ]) !!}
                                        {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {!! $errors->has('company_name') ? 'error' : '' !!}">
                                    <label>Company Name<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::text('company_name', $row->COMPANY_NAME,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter company name', 'tabindex' => 2 ]) !!}
                                        {!! $errors->first('company_name', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {!! $errors->has('weight') ? 'error' : '' !!}">
                                    <label>Weight<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::text('weight', $row->WEIGHT,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter weight', 'tabindex' => 3 ]) !!}
                                        {!! $errors->first('weight', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group {!! $errors->has('length') ? 'error' : '' !!}">
                                    <label>Length<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::text('length', $row->LENGTH,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter length', 'tabindex' => 4 ]) !!}
                                        {!! $errors->first('length', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {!! $errors->has('width') ? 'error' : '' !!}">
                                    <label>Width<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::text('width', $row->WIDTH,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter width', 'tabindex' => 5 ]) !!}
                                        {!! $errors->first('width', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {!! $errors->has('height') ? 'error' : '' !!}">
                                    <label>Height<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::text('height', $row->HEIGHT,[ 'class' => 'form-control mb-1', 'placeholder' => 'Enter height', 'tabindex' => 6 ]) !!}
                                        {!! $errors->first('height', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions mt-10 text-center">
                        <a href="{{ route('admin.agent.list')}}" class="btn btn-warning mr-1" title="Cancel"> <i class="ft-x"></i>Cancel</a>
                        <button type="submit" class="btn btn-primary" title="Update"><i class="la la-check-square-o"></i> Update</button>
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
