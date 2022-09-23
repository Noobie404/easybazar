@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush
@section('Accounts','open')
@section('payment_bank','active')

@section('title') Bank account @endsection
@section('page-name') Bank account @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('payment.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">Bank account</li>
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
                            <div class="form-group">
                                <div class="btn-group">
                                    <a href="/accounts/pdf" class="btn btn-secondary has-tooltip" data-original-title="null"><i class="fas fa-file-export"></i></a> <a class="btn btn-info has-tooltip" data-original-title="null"><i class="fas fa-print"></i></a>

                                    @if(hasAccessAbility('new_account_source', $roles))
                                    <a href="{{ route('admin.accounts.create') }}" class="btn btn-primary"> Add New <i class="fas fa-plus-circle d-none d-sm-inline-block"></i></a>
                                    @endif
                                </div>
                            </div>
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
                            <div class="card-body card-dashboard ">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered alt-pagination table-sm" id="indextable">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;">Sl.</th>
                                                <th  style="">Code</th>
                                                <th  style="">Bank Name</th>
                                                <th  style="">Branch Name</th>
                                                <th  style="">Account Name</th>
                                                <th >Account Number</th>
                                                <th>Available Balance</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th style="width: 50px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rows as $key => $row)
                                                <tr>
                                                    <td>
                                                        {{ $key+1 }}
                                                    </td>
                                                    <td>{{ $row->CODE }}</td>
                                                    <td>{{ $row->BANK_NAME }}</td>
                                                    <td>{{ $row->BRANCH_NAME }}</td>
                                                    <td>{{ $row->BANK_ACC_NAME }}</td>
                                                    <td>{{ $row->BANK_ACC_NO }}</td>
                                                    <td class="text-right">
                                                        {{ number_format($row->BALANCE_ACTUAL,2) }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ date('d M, Y', strtotime($row->START_DATE)) }}

                                                    </td>
                                                    <td>{{ $row->IS_ACTIVE == 1 ? 'Active' : 'Inactive' }}</td>
                                                    <td>
                                                        <div class="btn-group">

                                                            <a href="{{ route('admin.accounts.transaction', ['id' =>$row->PK_NO ]) }}" class="btn btn-primary btn-sm has-tooltip" data-original-title="null"><i class="fas fa-list-ol"></i></a>
                                                            <a href="{{ route('admin.accounts.edit',$row->PK_NO) }}" class="btn btn-info btn-sm has-tooltip" data-original-title="null"><i class="fas fa-edit"></i></a>

                                                        </div>
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
@include('admin.account._account_edit_modal')
@endsection
@push('custom_js')
<script type="text/javascript" src="{{ asset('assets/pages/account.js')}}"></script>
<script src="{{asset('/assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
@endpush('custom_js')

