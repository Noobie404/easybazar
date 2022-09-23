<?php
$customer_address       = $data['customer_address'] ?? [];
$orders                 = $data['orders'] ?? [];
$address_type           = \Config::get('static_array.address_type');
$reseller               = $data['reseller'] ?? '';
$limit                  = request()->get('limit') ?? 10;
?>
@extends('admin.layout.master')

@section('Reseller Management','open')
@section('reseller_list','active')

@push('custom_css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v=2.1.2">
    <style>
        .page-item:hover a, .page-item:focus a{color: #F78902 !important;border-color: #F78902 !important;}
    </style>
@endpush

@section('title') Reseller's Payment @endsection

@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-sm card-success" >
                <div class="card-body">
                    <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.reseller.history',['id' => $reseller->PK_NO]) }}">Account Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.reseller.reseller-details',['id' => $reseller->PK_NO]) }}">Personal Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.reseller.address-book',['id' => $reseller->PK_NO]) }}">Address Book</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.reseller.orders',['id' => $reseller->PK_NO]) }}">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('admin.reseller.payments',['id' => $reseller->PK_NO]) }}">Payments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.reseller.balance',['id' => $reseller->PK_NO]) }}">Balance</a>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="card shadow-sm" >
                <div class="card-header border-bottom">
                    <h1 class="card-title">My Paymnets</h1>

                </div>
                                <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table no-border tb1 thead-light">
                                                        <thead>
                                                            <tr class="table-head">
                                                                <th class="id">SL #</th>
                                                                <th>Payments #</th>
                                                                <th>Source</th>
                                                                <th>Date</th>
                                                                <th>Apply To</th>
                                                                <th>Status</th>
                                                                <th>Amount</th>
                                                                <th class="actions">Action </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(isset($rows))
                                                            @foreach ($rows as $key => $row)

                                                            <tr class="dashboard-orders-table-content">
                                                                <td class="text-center">{{ $rows->firstItem() + $key }}</td>
                                                                <td>
                                                                    @if($row->F_BANK_TXN_NO_TRANSFERAR !=  '' )
                                                                    Transfer From -
                                                                    @endif
                                                                    <a href="{{ route('admin.payment.details', ['id' => $row->PAYMENT_PK_NO ]) }}" target="_blank">{{ 'PAYID-'.$row->CODE ?? '' }}</a>
                                                                </td>
                                                                <td>{{ $row->PAYMENT_BANK_NAME  }}</td>
                                                                <td>{{ date('d-m-Y',strtotime($row->PAYMENT_DATE)) }}</td>

                                                                <td>

                                                                    @if ($row->allOrderPayments->count() > 0)
                                                                        @foreach ($row->allOrderPayments as $item)
                                                                            <div class="order-id">
                                                                                <a href="{{ route('admin.order.view',$item->order->booking->PK_NO) }}">ORD-{{ $item->order->booking->BOOKING_NO ?? '' }}</a>
                                                                                <span>-- RM {{ number_format($item->PAYMENT_AMOUNT,2) }}</span>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif

                                                                    @if($row->IS_TRANSFERRED == 1 )
                                                                        @if($row->TRANS_TO && count($row->TRANS_TO))
                                                                        @foreach($row->TRANS_TO as $k => $txn_to )
                                                                        <p><a href="{{ route('admin.reseller.view',$txn_to->F_TO_CUSTOMER) }}"> Transfered To (CUST-{{ $txn_to->CUSTOMER_NO }})  </a> {{ number_format($txn_to->AMOUNT,2) }}</p>
                                                                        @endforeach
                                                                        @endif
                                                                    @endif
                                                                    @if($row->PAYMENT_REMAINING_MR)
                                                                    <div class="credited">
                                                                        <a href="">Credited</a>-- RM {{ number_format($row->PAYMENT_REMAINING_MR,2) }}
                                                                    </div>
                                                                    @endif

                                                                </td>
                                                                <td>{{ $row->IS_MATCHED == 1 ? 'Verified' : 'Not Verified' }}</td>
                                                                <td>RM {{ number_format($row->PAYAMOUNT,2) }}</td>
                                                                <td><a href="{{ route('admin.payment.details', ['id' => $row->PAYMENT_PK_NO ]) }}" target="_blank">View Payments</a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            @else
                                                            <tr>
                                                                <td colspan="8" align="center">No data record found</td>
                                                            </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @if(isset($rows))
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <div class="pagination">
                                                            {{ $rows->appends(request()->query() ?? '')->links() }}
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                    <div class="table-shorting mt-1 float-left">
                                                        <p>
                                                            Displaying {{$rows->count()}} of {{ $rows->total() }} item(s).
                                                        </p>
                                                    </div>
                                                    <form action="{{ route('admin.reseller.payments', ['id' => $reseller->PK_NO]) }}" method="method">
                                                        <input type="hidden" name="type" value="{{ request()->get('type') }}" />
                                                        <div class="table-shorting mt-md-2 float-right">
                                                            <strong>Show</strong>
                                                            <select class="shorting-data" id="limiter" name="limit" onchange="this.form.submit()">
                                                                <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
                                                                <option value="20" {{ $limit == 20 ? 'selected' : '' }}>20</option>
                                                                <option value="50" {{ $limit == 50 ? 'selected' : '' }}>50</option>
                                                                <option value="all" {{ $limit == 'all' ? 'selected' : '' }}>all</option>
                                                            </select>
                                                            <span>Per Page</span>
                                                        </div>
                                                    </form>

                                    </div>
                 </div>
            </div>
    </div>
</div>
@endsection
@push('custom_js')
<script type="text/javascript" src="{{ asset('assets/pages/customer.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/pages/country.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="{{ asset('assets/pages/checkout.js') }}"></script>

@endpush
