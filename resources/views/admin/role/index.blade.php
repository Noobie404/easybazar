@extends('admin.layout.master')

@section('role','active')
@section('Role Management','open')

@section('title')
    @lang('admin_role.list_page_title')
@endsection
@section('page-name')
    @lang('admin_role.list_page_sub_title')
@endsection

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush

@push('custom_js')
<!-- BEGIN: Data Table-->
<script src="{{asset('/assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<!-- END: Data Table-->
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin_role.breadcrumb_title')    </a>
    </li>
    <li class="breadcrumb-item active">@lang('admin_role.breadcrumb_sub_title')
    </li>
@endsection
@php
    $roles = userRolePermissionArray();
@endphp
@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            @if(hasAccessAbility('new_role', $roles))
                                <a class="text-white btn btn-round btn-sm btn-primary " href="{{url('role/new')}}" title="Add new"> <i class="ft-plus text-white"></i> @lang('admin_role.role_create_btn')</a>
                            @endif
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
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-bordered alt-pagination50" id="indextable">
                                        <thead>
                                        <tr>
                                            <th>@lang('tablehead.tbl_head_sl')</th>
                                            <th>Role For</th>
                                            <th>@lang('tablehead.tbl_head_name')</th>
                                            <th>@lang('tablehead.tbl_head_created_by')</th>
                                            <th>@lang('tablehead.tbl_head_created_at')</th>
                                            <th>@lang('tablehead.tbl_head_action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($rows as $row)
                                            <tr>
                                                <td>{{$loop->index + 1}}</td>
                                                <td>{{$row->GROUP_FOR == 1 ? 'Easybazar' : 'Branch'}}</td>
                                                <td>{{$row->NAME}}</td>
                                                <td>{{$row->CREATED_BY_NAME}}</td>
                                                <td>{{ date('d-m-Y', strtotime($row->CREATED_AT)) }}</td>
                                                <td>
                                                    @if(hasAccessAbility('edit_role', $roles))
                                                        <a href="{{ route('admin.role.edit', [$row->PK_NO]) }}" class="btn btn-xs btn-primary mr-1" title="Edit"><i class="la la-edit"></i> </a>
                                                    @endif
                                                    @if(hasAccessAbility('delete_role', $roles))
                                                        <a href="{{ route('admin.role.delete', [$row->PK_NO]) }}" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-xs btn-danger mr-1" title="Delete"><i class="la la-trash"></i></a>
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
