@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush
@section('Accounts','open')
@section('payment_bank','active')
@section('title') Account Transactions @endsection
@section('page-name') Account Transactions @endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('payment.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">Bank account</li>
@endsection
@php
    $roles = userRolePermissionArray();
    $settings  = getWebSettings();
@endphp
@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">

                        <div class="card-content">
                            <div class="content-body">

                                <div class="row mt-2">
                                    <div class="col-xl-3 col-lg-6 col-12">
                                        <div class="card pull-up">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="media d-flex">
                                                        <div class="media-body text-left">
                                                            <h3 class="info">850</h3>
                                                            <h6>Total Transactions</h6>
                                                        </div>
                                                        <div>
                                                            <i class="icon-basket-loaded info font-large-2 float-right"></i>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                        <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12">
                                        <div class="card pull-up">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="media d-flex">
                                                        <div class="media-body text-left">
                                                            <h3 class="warning">$748</h3>
                                                            <h6>Credit Amount</h6>
                                                        </div>
                                                        <div>
                                                            <i class="icon-pie-chart warning font-large-2 float-right"></i>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                        <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12">
                                        <div class="card pull-up">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="media d-flex">
                                                        <div class="media-body text-left">
                                                            <h3 class="success">146</h3>
                                                            <h6>Debit Amount</h6>
                                                        </div>
                                                        <div>
                                                            <i class="icon-user-follow success font-large-2 float-right"></i>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                        <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6 col-12">
                                        <div class="card pull-up">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="media d-flex">
                                                        <div class="media-body text-left">
                                                            <h3 class="danger">99.89</h3>
                                                            <h6>
                                                                Available Balance</h6>
                                                        </div>
                                                        <div>
                                                            <i class="icon-heart danger font-large-2 float-right"></i>
                                                        </div>
                                                    </div>
                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                        <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <section class="card">
                                <div id="invoice-template" class="card-body p-4">

                                  <!-- Invoice Customer Details -->
                                  <div id="invoice-customer-details" class="row pt-2">

                                    <div class="col-sm-6 col-12 text-center text-sm-left">
                                      <ul class="px-0 list-unstyled">

                                        <li ><img class="brand-logo img-fluid" alt="{{ $settings->SITE_NAME  ?? 'DEMO WEBSITE'}}" title="{{ $settings->SITE_NAME ?? 'DEMO WEBSITE' }}" src="{{ asset($settings->LOGIN_LOGO ?? '') }}" style="height: 50px;"></li>
                                        <li >Ultimate Sales, Inventory, Accounting Management System</li>
                                        <li >Phone: 0170000000</li>
                                        <li>Email: support@codeshape.net</li>
                                        <li>Address: Ground Floor, Road# 24, House# 339, New DOHS,</li>
                                        <li>Mohakhali, Dhaka - 1206, Bangladesh.</li>
                                      </ul>
                                    </div>
                                    <div class="col-sm-6 col-12 text-center text-sm-right">
                                      <p>Account Details</p>
                                      <p><span class="text-muted">Bank Name :</span> Cash</p>
                                      <p><span class="text-muted">Branch Name :</span> Office</p>
                                      <p><span class="text-muted">Account Number :</span> CASH-0001</p>
                                      <p><span class="text-muted">Created At :</span> 30th Apr, 2022</p>

                                    </div>
                                  </div>
                                  <!-- Invoice Customer Details -->

                                  <!-- Invoice Items Details -->
                                  <div id="invoice-items-details" class="pt-2">
                                    <div class="row">
                                      <div class="table-responsive col-12">
                                        <table class="table">
                                          <thead>
                                            <tr>
                                              <th>#</th>
                                              <th>Reason</th>
                                              <th class="text-right">Date</th>
                                              <th class="text-right">Type</th>
                                              <th class="text-right">Amount</th>
                                              <th class="text-right">Status</th>
                                              <th class="text-right">Created By</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <th scope="row">1</th>
                                              <td>
                                                [APP-6] Purchase Payment sent from [CASH-0001]
                                              </td>
                                              <td class="text-right">31st May, 2022</td>
                                              <td class="text-right">Debit</td>
                                              <td class="text-right">$8060.38</td>
                                              <td class="text-right">Active</td>
                                              <td class="text-right">Super Admin</td>
                                            </tr>

                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="btn-group">
                                                <a href="/accounts/pdf" class="btn btn-secondary has-tooltip" data-original-title="null"><i class="fas fa-file-export"></i></a> <a class="btn btn-info has-tooltip" data-original-title="null"><i class="fas fa-print"></i></a>
                                                <a href="{{ route('admin.accounts.list') }}" class="btn btn-primary"> <i class="fas fa-backward"></i> Back </a>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                              </section>
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
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
@endpush('custom_js')
