@extends('admin.layout.master')
@section('permission-group','active')
@section('Role Management','open')

@section('title') @lang('admin_menu.list_page_title')@endsection
@section('page-name') @lang('admin_menu.list_page_sub_title') @endsection

@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush

@push('custom_js')
    <script src="{{asset('/assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('/assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">@lang('admin_menu.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">@lang('admin_menu.breadcrumb_sub_title')</li>
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
                            @if(hasAccessAbility('new_menu', $roles))
                            <a class="text-white btn btn-round btn-sm btn-primary" href="{{route('admin.permission-group.new')}}" title="Add new"><i class="ft-plus text-white"></i> New Menu</a>
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
                            <div class="card-body card-dashboard text-center">
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-bordered alt-pagination50" id="indextable">
                                        <thead>
                                        <tr>
                                            <th>@lang('tablehead.tbl_head_sl')</th>
                                            <th class="text-left">@lang('tablehead.tbl_head_name')</th>
                                            <th>@lang('tablehead.tbl_head_created_at')</th>
                                            <th>Order ID</th>
                                            <th>@lang('tablehead.tbl_head_action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($rows as $row)
                                            <tr>
                                                <td>{{$loop->index + 1}}</td>
                                                <td class="text-left">{{$row->NAME}}</td>
                                                <td>{{$row->CREATED_AT}}</td>
                                                <td>{{$row->ORDER_ID}}</td>
                                                <td>
                                                    @if(hasAccessAbility('edit_menu', $roles))
                                                        <a class="text-white btn btn-xs btn-primary mr-1" href="{{ route('admin.permission-group.edit', ['id' => $row->PK_NO] ) }}" title="Edit"> <i class="la la-edit"></i></a>
                                                    @endif
                                                    @if(hasAccessAbility('delete_menu', $roles))
                                                        <a class="text-white btn btn-xs btn-danger mr-1" href="{{ route('admin.permission-group.delete', array($row->PK_NO)) }}" title="Delete"><i class="la la-trash"></i></a>
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
