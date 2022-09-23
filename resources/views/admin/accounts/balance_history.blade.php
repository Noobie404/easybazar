
@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush
@section('Accounts','open')
@section('balance_history','active')

@section('title') Balance history @endsection
@section('page-name') Balance history @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('payment.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">Balance history</li>
@endsection
@php
    $roles = userRolePermissionArray();
@endphp

@section('content')
    <!-- Alternative pagination table -->
    <div class="content-body">
        <section id="pagination">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <div class="form-group">
                                Transaction History
                            </div>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <div class="btn-group">
                                    <a href="/accounts/pdf" class="btn btn-secondary has-tooltip" data-original-title="null"><i class="fas fa-file-export"></i></a>
                                    <a class="btn btn-info has-tooltip" data-original-title="null"><i class="fas fa-print"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard ">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered alt-pagination table-sm" id="indextable">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;">Sl.</th>
                                                <th  style="">Reason</th>
                                                <th>Date</th>
                                                <th  class="text-center" >Type</th>
                                                <th  style="">Account</th>
                                                <th class="text-right">Amount</th>
                                                <th class="text-center">Status</th>
                                                <th style="width: 50px;">Created By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>[DBBL-0001] Loan Payment sent from [DBBL-0003]</td>
                                                    <td >1st Jun, 2022</td>
                                                    <td class="text-center" ><span class="badge badge-danger">Debit</span></td>
                                                    <td>Dutch Bangla Bank[DBBL-0003]</td>

                                                    <td class="text-right">$4522.73</td>
                                                    <td class="text-center">Active</td>
                                                    <td>
                                                        Super Admin
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>2</td>
                                                    <td>[IBBL-0001] Loan added to [IBBL-0002]</td>
                                                    <td >1st Jun, 2022</td>
                                                    <td class="text-center" ><span class="badge badge-success">Credit</span></td>
                                                    <td>Dutch Bangla Bank[DBBL-0003]</td>

                                                    <td class="text-right">$4522.73</td>
                                                    <td class="text-center">Active</td>
                                                    <td>
                                                        Super Admin
                                                    </td>
                                                </tr>

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

@push('custom_js')
<script type="text/javascript" src="{{ asset('assets/pages/account.js')}}"></script>
<script src="{{asset('/assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
@endpush('custom_js')
