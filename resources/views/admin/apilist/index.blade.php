@extends('admin.layout.master')

@section('System Settings','open')
@section('api_list','active')

@section('title') API List @endsection
@section('page-name') API List @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('agent.breadcrumb_title') </a></li>
    <li class="breadcrumb-item active">API List</li>
@endsection

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{asset('/custom/css/custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush

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
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-8">
                    <div class="card card-success">
                        <div class="card-header">

                                <a class="text-white btn btn-sm btn-primary" href="#" title="Add new">API List</a>

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
                                    <table class="table table-striped table-bordered alt-pagination table-sm" id="indextable">
                                        <thead>
                                        <tr class="small_table_head">
                                            <th>SL.</th>
                                            <th>Name</th>
                                            <th>Company</th>
                                            <th>Default Dimension</th>
                                            <th style="width: 100PX">@lang('tablehead.tbl_head_action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if( isset($data['apis']) && count($data['apis']) > 0 )
                                                @foreach($data['apis'] as $key => $row)
                                            <tr class="small_table_data">
                                                <td>{{$loop->index + 1}}</td>
                                                <td><span class="text-upper">{{ $row->NAME }}</span></td>
                                                <td>{{ $row->COMPANY_NAME }}</td>
                                                <td>
                                                    @if(!empty($row->WEIGHT))
                                                    <p>Weight : {{ $row->WEIGHT }}</p>
                                                    @endif
                                                    @if(!empty($row->LENGTH))
                                                    <p>Length : {{ $row->LENGTH }}</p>
                                                    @endif
                                                    @if(!empty($row->WIDTH))
                                                    <p>Width : {{ $row->WIDTH }}</p>
                                                    @endif
                                                    @if(!empty($row->HEIGHT))
                                                    <p>Height : {{ $row->HEIGHT }}</p>
                                                    @endif
                                                    @if(!empty($row->API_TOKEN))
                                                    <p>Token : {{ $row->API_TOKEN }}</p>
                                                    @endif
                                                    @if(!empty($row->TOKEN_CREATE_DATE))
                                                    <p>Token Generate  : {{ date('d M Y', strtotime($row->TOKEN_CREATE_DATE))}}</p>
                                                    @endif
                                                    @if(!empty($row->TOKEN_EXPIRE_DATE))
                                                    <p>Token Expire  : {{ date('d M Y', strtotime($row->TOKEN_EXPIRE_DATE))  }}
                                                        </p>
                                                    @endif
                                                    @if(!empty($row->ACCOUNT_NO))
                                                    <p>Account No.   : {{ $row->ACCOUNT_NO }}</p>
                                                    @endif
                                                    @if(!empty($row->METER_NO))
                                                    <p>Meter No.   : {{ $row->METER_NO }}</p>
                                                    @endif
                                                    @if(!empty($row->COMPANY_CODE))
                                                    <p>Company Code   : {{ $row->COMPANY_CODE }}</p>
                                                    @endif
                                                    @if(!empty($row->TRANSACTION_IDENTIFIRE))
                                                    <p>Tran. Id    : {{ $row->TRANSACTION_IDENTIFIRE }} </p>
                                                    @endif
                                                </td>
                                                <td style="text-align: center">
                                                    @if(hasAccessAbility('edit_apilist', $roles))
                                                        <a href="{{ route('admin.apilist.edit', [$row->PK_NO]) }}" title="Edit" class="btn btn-xs btn-info mr-1"><i class="la la-edit" ></i> </a>
                                                        @if($row->API_TYPE =='citylink')
                                                        @if($row->TOKEN_EXPIRE_DATE > date('Y-m-d') )
                                                        <a href="#" title="Generate new token" class="btn btn-xs btn-success mr-1 disabled" disabled><i class="la la-refresh" ></i> </a>
                                                        @else
                                                        <a href="{{ route('admin.citylink.access_token') }}" title="Generate new token" class="btn btn-xs btn-success mr-1"><i class="la la-refresh" ></i> </a>
                                                        @endif
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach()
                                        @endif
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
