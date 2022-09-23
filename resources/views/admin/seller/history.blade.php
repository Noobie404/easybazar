@extends('admin.layout.master')
@section('reseller Management','open')
@section('reseller_list','active')

@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <style>
        .customer-info{color: blue !important; font-size: 18px;}
        .customer-info p{ text-align: right;}
        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {border: 1px solid #ddd!important;vertical-align: top!important;}
        .table-head {width: 100%;background-color: #F78902!important;}
    </style>
@endpush


@section('title') Reseller History  @endsection
@section('page-name') Reseller History  @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">@lang('reseller.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">Reseller History </li>
@endsection

@php
    $customer_address  = $data['customer_address'] ?? [];
    $orders            = $data['orders'] ?? [];
    $roles          = userRolePermissionArray();
    $balance        = 0;
    $html           = array();
    $cum_balance    = 0;
    $cum_order_due  = 0;
    $reseller       = $data['reseller'] ?? '';
@endphp

@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-sm card-success" >
                <div class="card-body">
                    <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('admin.reseller.reseller-details',['id' => $reseller->PK_NO]) }}">Account Dashboard</a>
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
                            <a class="nav-link" href="{{ route('admin.reseller.payments',['id' => $reseller->PK_NO]) }}">Payments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.reseller.balance',['id' => $reseller->PK_NO]) }}">Balance</a>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header px-2 pt-2">
                    <h4 class="card-title">Recent Order<a class="float-right" href="{{ route('admin.reseller.orders',['id' => $reseller->PK_NO]) }}"><i class="la la-link"></i> View All</a></h4>
                </div>
                <div class="card-body">
                    <table class="table no-border tb1 thead-light table-striped" id="order_table">
                        <thead>
                            <tr class="table-head">
                                <th>SL</th>
                                <th>Order # </th>
                                <th class="d-md-block">Agent</th>
                                <th>Date</th>
                                <th class="text-right">Total Value</th>
                                <th class="text-right">Payment</th>
                                <th class="d-md-block text-center">Location</th>
                                <th class="text-center">Status</th>
                                <th class="actions text-center" style="min-width: 50px">Action </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="contact-info p-2 shadow-sm">
                        <h4 class="heading-title border-bottom">Account Summary</h4>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class=""><span class="badge badge-success">CREDIT BALANCE - RM {{ number_format($reseller->CUM_BALANCE,2) }}</span></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="pull-right"><span class="badge badge-danger">DUE BALANCE - RM {{ $data['due'] }}</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="contact-info p-2 shadow-sm">
                        <h4 class="heading-title border-bottom">Contact Information</h4>
                        <h4>{{ $reseller->NAME }} {{ $reseller->LAST_NAME }}</h4>
                        <p>{{ $reseller->EMAIL }}</p>
                        @if($reseller->TEL_NO)
                        <p>{{ $reseller->country->DIAL_CODE ?? '' }} {{ $reseller->TEL_NO }}</p>
                        @endif
                        @if($reseller->MOBILE_NO)
                        <p>{{ $reseller->country->DIAL_CODE ?? '' }} {{ $reseller->MOBILE_NO }}</p>
                        @endif
                    </div>

                    <div class="reseller-address p-2 shadow-sm">
                        <h4 class="heading-title border-bottom">Default Address &nbsp;&nbsp;<small><a class="float-right" href="{{ route('admin.reseller.address-book',['id' => $reseller->PK_NO]) }}">Manage Addresses</a></small></h4>
                        @if(!empty($data['default_address']))
                        <h4>{{ $data['default_address']->NAME ?? '' }} {{ $data['default_address']->LAST_NAME ?? '' }}</h4>
                            <p>{{ $data['default_address']->country->DIAL_CODE ?? '' }}{{ $data['default_address']->TEL_NO ?? $data['default_address']->MOBILE_NO ?? '' }}</p>
                           <p>Address 1: {{ $data['default_address']->ADDRESS_LINE_1 ?? '' }}</p>
                           <p>Address 2: {{ $data['default_address']->ADDRESS_LINE_2 ?? '' }}</p>
                           <p>Post Code : {{ $data['default_address']->POST_CODE ?? '' }}</p>
                            <p>Country: {{ $data['default_address']->country->NAME ?? '' }}</p>
                            <p>State : {{ $data['default_address']->state->STATE_NAME ?? '' }}</p>
                            <p>City : {{ $data['default_address']->city->CITY_NAME ?? '' }}</p>
                            @else
                            <p>Not Found</p>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom_js')
<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/app-assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script>
    var get_url = $('#base_url').val();

    $(document).ready(function() {
        $('#order_table').DataTable({
            processing: false,
            serverSide: true,
            paging: true,
            pageLength: 10,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            searching: false,
            paging: false,
            info: false,
            bSort: false,
            ajax: {

                url: get_url+'/reseller/user-orderList-datatable',
                type: 'POST',
                data: function(d) {
                    d.limit_order = 1,
                    d.reseller_id = {{ $reseller->PK_NO }}
                    d._token = "{{ csrf_token() }}";
                }
            },
            columnDefs: [
                { visible: false, targets: 9, },
                {orderable: false, targets: '_all'}
                ],
            columns: [
                {
                    data: 'PK_NO',
                    name: 'PK_NO',
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'order_id',
                    name: 'SLS_BOOKING.BOOKING_NO',
                    searchable: true,

                },
                {
                    data: 'SHOP_NAME',
                    name: 'SLS_BOOKING.SHOP_NAME',
                    searchable: true,
                },
                {
                    data: 'order_date',
                    name: 'order_date',
                    searchable: true
                },
                // {
                //     data: 'item_type',
                //     name: 'item_type',
                //     searchable: false,
                //     className: 'text-center'
                // },
                {
                    data: 'price_after_dis',
                    name: 'price_after_dis',
                    searchable: false,
                    className: 'text-right'

                },
                {
                    data: 'payment',
                    name: 'payment',
                    searchable: false,
                    className: 'text-right'
                },
                {
                    data: 'avaiable',
                    name: 'avaiable',
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'status',
                    name: 'status',
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'IS_DEFAULT',
                    name: 'IS_DEFAULT',
                    searchable: true,
                }
            ],
            rowCallback: function (row, data, index) {
                if (data['IS_DEFAULT'] == 1) {
                    $(row).css('background-color','#ffd945')
                }
            },
        });
    });

    $(document).on('click','#view_note',function(){
        var note = $(this).data('note');
        $('#note_body').text(note);
    });
</script>
@endpush
@endsection

