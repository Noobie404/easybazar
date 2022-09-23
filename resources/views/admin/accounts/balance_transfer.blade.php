
@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush
@section('Accounts','open')
@section('balance_transfer','active')

@section('title') Balances Transfer @endsection
@section('page-name') Balances Transfer @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('payment.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">Balances Transfer</li>
@endsection

@php
    $roles = userRolePermissionArray()
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
                                <div class="btn-group">
                                    <a href="/accounts/pdf" class="btn btn-secondary has-tooltip" data-original-title="null"><i class="fas fa-file-export"></i></a> <a class="btn btn-info has-tooltip" data-original-title="null"><i class="fas fa-print"></i></a>

                                    @if(hasAccessAbility('new_account_source', $roles))
                                    <a href="{{ route('accounts.balance_transfer.create') }}" class="btn btn-primary"> Add Transfer <i class="fas fa-plus-circle d-none d-sm-inline-block"></i></a>
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
                                                <th  style="">Reason</th>
                                                <th  style="">From Account</th>
                                                <th  style="">To Account</th>
                                                <th class="text-right">Amount</th>
                                                <th>Date</th>
                                                <th class="text-center">Status</th>
                                                <th style="width: 50px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                                <tr>
                                                    <td>1</td>
                                                    <td>Regular Transfer</td>
                                                    <td>Cash[CASH-0001]</td>
                                                    <td>Dutch Bangla Bank[DBBL-0003]</td>

                                                    <td class="text-right">$10000.00</td>
                                                    <td >1st Jun, 2022</td>
                                                    <td class="text-center">Active</td>
                                                    <td>
                                                        <div class="btn-group"><a href="" class="btn btn-info btn-sm has-tooltip" ><i class="fas fa-edit"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>2</td>
                                                    <td>Office Cash Transfer</td>
                                                    <td>Cash[CASH-0001]</td>
                                                    <td>Islami Bank Bangladesh Ltd[IBBL-0002]</td>

                                                    <td class="text-right">$20000.00</td>
                                                    <td >1st Jun, 2022</td>
                                                    <td class="text-center">Active</td>
                                                    <td>
                                                        <div class="btn-group"><a href="" class="btn btn-info btn-sm has-tooltip" ><i class="fas fa-edit"></i></a>
                                                        </div>
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
