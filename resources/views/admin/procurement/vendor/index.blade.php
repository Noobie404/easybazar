@extends('admin.layout.master')

@section('vendor','active')
@section('Procurement','open')

@section('title') @lang('vendor.list_page_title') @endsection
@section('page-name') @lang('vendor.list_page_sub_title') @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('vendor.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">@lang('vendor.breadcrumb_sub_title')</li>
@endsection

@php
    $roles = userRolePermissionArray();
    $tab_index = 1;
    $branch_id =  request()->get('branch_id');
    if(Auth::user()->USER_TYPE == 10){
        $branch_id = Auth::user()->SHOP_ID;
    }
@endphp

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
<style>
    .vendor-entry{
        display: inline-flex;
    }
    .vendor-entry .help-block{display:none;}
</style>
@endpush

@push('custom_js')
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
@endpush

@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            @if(hasAccessAbility('new_vendor', $roles))
                                <a class="text-white btn btn-round  btn-primary" href="{{route('admin.vendor.new')}}" title="Add new vandor"> <i class="ft-plus text-white"></i> @lang('vendor.role_create_btn')</a>
                            @endif
                            {!! Form::open([ 'route' => 'admin.vendor', 'method' => 'get', 'class' => 'form-inline vendor-entry', 'files' => true , 'novalidate']) !!}
                            <div class="form-group {!! $errors->has('branch_id') ? 'error' : '' !!}">
                                <div class="controls">
                            {!! Form::select('branch_id', $branch, $branch_id, [ 'class' => 'form-control ', 'placeholder' => 'Select branch', 'tabindex' => $tab_index++ ]) !!}

                                </div>
                            </div>
                            <div class="form-group {!! $errors->has('branch_id') ? 'error' : '' !!}">
                                <div class="controls">
                            <button type="submit" class="text-white btn btn-round  btn-primary" title="Search">Search</button>
                                </div>
                            </div>

                            {!! Form::close() !!}

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
                            <div class="card-body card-dashboard">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered alt-pagination50 table-sm" id="indextable">
                                        <thead>
                                        <tr>
                                            <th class="text-center">SL.</th>
                                            <th>Branch</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Country</th>
                                            <th style="width: 80px;" class="text-center">@lang('tablehead.tbl_head_action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($rows as $row)
                                            <tr>
                                                <td class="text-center">{{$loop->index + 1}}</td>
                                                <td>{{ $row->SHOP_NAME }}</td>
                                                <td>{{ $row->NAME }}</td>
                                                <td>{{ $row->ADDRESS }}</td>
                                                <td>{{ $row->PHONE }}</td>
                                                <td>{{ $row->COUNTRY }}</td>
                                                <td style="width: 10%;" class="text-center">
                                                    @if(hasAccessAbility('view_vendor', $roles))
                                                        <a href="{{ route('admin.vendor.view', [$row->PK_NO]) }}" class="btn btn-xs btn-info" title="View"><i class="la la-eye"></i></a>
                                                    @endif

                                                    @if(hasAccessAbility('edit_vendor', $roles))
                                                        <a href="{{ route('admin.vendor.edit', [$row->PK_NO]) }}" class="btn btn-xs btn-info" title="Edit"><i class="la la-edit"></i></a>
                                                    @endif

                                                    @if(hasAccessAbility('delete_vendor', $roles))
                                                        <a href="{{ route('admin.vendor.delete', [$row->PK_NO]) }}" onclick="return confirm('Are You Sure?')" class="btn btn-xs btn-danger" title="Delete"><i class="la la-trash"></i></a>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach()
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
