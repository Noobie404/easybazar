<?php
$shipping_address       = $data['shipping'] ?? [];
$billing_address        = $data['billing'] ?? [];
$address_type           = \Config::get('static_array.address_type');
$reseller       = $data['reseller'] ?? '';
?>
@extends('admin.layout.master')
@section('Reseller Management','open')
@section('reseller_list','active')
@push('custom_css')
{{-- <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}?v=2.1.2"> --}}
@endpush
@section('title')
Address
@endsection
@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-sm card-success">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.reseller.history',['id' => $reseller->PK_NO]) }}">Account Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.reseller.reseller-details',['id' => $reseller->PK_NO]) }}">Personal Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('admin.reseller.address-book',['id' => $reseller->PK_NO]) }}">Address Book</a>
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
            <div class="bg-white px-2" >
                <div class="section-header border-bottom p-1">
                    <h4 class="section-title">Address Book <a class="float-right btn btn-sm btn-success" href="javascript:void(0)" id="add-address-popup" data-type="shipping"data-toggle="modal" data-target="#AddCustomerAddress"><i class="la la-plus"></i> Add New</a></h4>
                </div>
                <div class="sec-body">
                    <div class="row">
                        @if (isset($shipping_address) && !empty($shipping_address))
                                                @foreach ($shipping_address as $key => $item)
                                                @if ($item->IS_DEFAULT == 1)
                                                <div class="col-lg-6 mx-auto">
                                                    <div class="card card-dashboard mt-2">
                                                        <div class="card-header">
                                                            <h4 class="card-title h4 border-bottom pb-1"><i class="la la-truck" aria-hidden="true"></i>
                                                                Default Shipping Address </h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <h5 class="customer-name"><i class="la la-map-marker" aria-hidden="true"></i>
                                                                 {{ $item->NAME }} {{ $item->LAST_NAME }}</h5>
                                                            <p>{{ $item->ADDRESS_LINE_1 }}</p>
                                                            <p>{{ $item->ADDRESS_LINE_2 }}</p>
                                                            <p>{{ $item->city->CITY_NAME ?? '' }}</p>
                                                            <p>{{$item->state->STATE_NAME ?? '' }}</p>
                                                            <p> {{ $item->country->NAME }}</p>
                                                            <p>{{ $item->POST_CODE }}</p>
                                                            <p>{{ $item->country->DIAL_CODE }} {{ $item->TEL_NO }}</p>

                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach
                                                @endif

                    </div>
                    <div class="row">
                        @if (isset($billing_address) && !empty($billing_address))
                        <div class="col-lg-6 mx-auto">
                            <div class="card card-dashboard my-1">
                                <div class="card-body">
                                    <h3 class="card-title border-bottom pb-1">Billing Address</h3>
                                    <p class="text-capitalize">{{ $billing_address->NAME }} {{ $billing_address->LAST_NAME }}<br>
                                    {{ $billing_address->ADDRESS_LINE_1 }}<br>
                                    {{ $billing_address->ADDRESS_LINE_2 }}<br>
                                    {{ $billing_address->city->CITY_NAME ?? '' }}, {{ $billing_address->state->STATE_NAME ?? '' }}<br>
                                    {{ $billing_address->country->NAME }}-
                                    {{ $billing_address->POST_CODE }}<br>
                                    {{ $billing_address->country->DIAL_CODE }} {{ $billing_address->MOBILE_NO ?? $billing_address->TEL_NO ?? '' }}<br>

                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-lg-6 mx-auto">
                            <div class="card card-dashboard">
                                <div class="card-body">
                                    <h3 class="card-title">Billing Address</h3>
                                    <p>You have not set up this type of address yet.<br>
                                        </p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="p-1 border-bottom">Address History</h3>
                        </div>
                    </div>
                    <div class="row">
                        @if (isset($shipping_address) && !empty($shipping_address))
                        @foreach ($shipping_address as $key => $item)
                        @if ($item->IS_DEFAULT !== 1)
                        <div class="col-lg-4">
                            <div class="card card-dashboard card-border-l">
                                <div class="card-header">
                                    <h5 class="customer-name card-title border-bottom pb-1"><i class="la la-map-marker" aria-hidden="true"></i>
                                        {{ $item->NAME }} {{ $item->LAST_NAME }}</h5>
                                </div>
                                <div class="card-body">
                                   <p>{{ $item->ADDRESS_LINE_1 }}</p>
                                   <p>{{ $item->ADDRESS_LINE_2 }}</p>
                                   <p>{{ $item->city->CITY_NAME ?? '' }}</p>
                                   <p>{{ $item->state->STATE_NAME ?? '' }}</p>
                                   <p> {{ $item->country->NAME }}</p>
                                   <p>{{ $item->POST_CODE }}</p>
                                   <p>{{ $item->country->DIAL_CODE }} {{ $item->TEL_NO }}</p>

                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @else
                        <div class="col-lg-6">
                            <div class="card card-dashboard">
                                <div class="card-body">
                                    <h3 class="card-title">Shipping Address</h3>
                                    <p>You have not set up this type of address yet</p>
                                    <a href="javascript:void(0)" id="add-address-popup" data-type="shipping"data-toggle="modal" data-target="#AddCustomerAddress">Add New <i class="la la-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
           </div>
        </div>
    </div>
</div>


@endsection
@push('custom_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script>
    $(function () { $("input,select").not("[type=submit]").jqBootstrapValidation(); } );
</script>
@endpush
