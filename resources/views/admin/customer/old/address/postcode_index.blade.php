@extends('admin.layout.master')
@section('System Settings','open')

@section('postage_list','active')
@section('title') Postage List @endsection

@section('page-name') Postage List @endsection

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{asset('/custom/css/custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Postage list</li>
@endsection

@push('custom_js')
<!-- BEGIN: Data Table-->
<script src="{{asset('/assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<!-- END: Data Table-->
@endpush
@php
    $roles = userRolePermissionArray()
@endphp
@section('content')
    <!-- Alternative pagination table -->
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-12">
                    <div class="card card-sm">
                        <div class="card-header pl-2">
                            @if(hasAccessAbility('new_address_type', $roles))
                                <a href="{{route('admin.address_type.postage_view_')}}" title="Add new" class="btn btn-round btn-sm btn-primary text-white"><i class="ft-plus text-white"></i> Create New Post Code
                                </a>
                            @endif
                            <a class="heading-elements-toggle heading-elements-toggle-sm"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements heading-elements-sm">
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
                                    <table class="table table-striped table-bordered alt-pagination table-sm" id="indextable">
                                        <thead>
                                        <tr class="small_table_head">
                                            <th style="width: 50px;">Sl.</th>
                                            <th style="width: 250px;">Country</th>
                                            <th>State</th>
                                            <th>City</th>
                                            <th>Post Code</th>
                                            <th style="width: 100px;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                       @foreach($rows as $row)
                                        <tr class="small_table_data">
                                            <td>{{$loop->index + 1}}</td>
                                            <td>{{ $row->NAME }}</td>
                                            <td>{{ $row->STATE_NAME }}</td>
                                            <td>{{ $row->CITY_NAME }}</td>
                                            <td>{{ $row->PO_CODE }}</td>
                                            <td style="width: 100px;">

                                                @if(hasAccessAbility('edit_address_type', $roles))
                                                    @if ($row->CREATED_BY == 1)
                                                    <a href="{{route('admin.address_type.postage_view_',$row->PK_NO)}}" class="btn btn-xs btn-warning mr-1" title="Created by Customer"><i class="la la-edit"></i></a>
                                                    @else
                                                    <a href="{{route('admin.address_type.postage_view_',$row->PK_NO)}}" class="btn btn-xs btn-primary mr-1" title="EDITsss"><i class="la la-edit"></i></a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
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

    <!--/ Alternative pagination table -->
@endsection
