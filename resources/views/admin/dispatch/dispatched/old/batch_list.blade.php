@extends('admin.layout.master')

@section('Dispatck Management','open')
@section('view_batch_list_collected','active')

@section('title') Order Batch List @endsection
@section('page-name') Order Batch List @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('order.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">@lang('order.breadcrumb_sub_title')</li>
@endsection

@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset(assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <style>
    .f12{font-size:12px}.w100{width:100px}#process_data_table td{vertical-align:middle}.order-type{display:inline-block;margin-right:10px}.order-type label{cursor:pointer}a:not([href]):not([tabindex]){color:#fff}.c-btn.active{color:#fff!important}
    </style>
@endpush

@php
    $roles = userRolePermissionArray();
@endphp


@section('content')
<div class="card card-success min-height">
    <div class="card-header">
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
        <div class="card-body" style="padding: 15px 5px;">
            <div class="table-responsive">
                <table class="table table-striped table-bordered alt-pagination table-sm">
                    <thead>
                    <tr>
                        <th class="text-center">SL.</th>
                        <th class="text-center">Batch No.</th>
                        <th class="text-center" title="">Consignment Note Print & Dispatch Order</th>
                        <th class="text-center">Assign User For Collection</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                        <tr>
                            <td class="text-center">{{ $loop->index + 1 }}</td>
                            <td class="text-center">{{ $row->batch_no }}</td>
                            <td class="text-center">

                                @if(hasAccessAbility('view_order_collect', $roles))
                                <a href="{{ route('admin.order_collect.list', [$row->batch_pk]) }}" class="btn btn-md btn-info" title="SENT FOR MOBILE DISPATCH-{{ $row->order_dispatched }} TOTAL-{{ $row->order_count }}">{{ $row->order_dispatched }} / {{ $row->order_count }}</a>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(hasAccessAbility('view_item_collected', $roles))
                                <a href="{{ route('admin.item_collected.list', [$row->batch_pk]) }}" class="btn btn-md btn-info" title="COLLECTED-{{ $row->item_count_collected ?? 0  }} TOTAL-{{ $row->item_count ?? 0 }}">{{ $row->item_count_collected ?? 0 }} / {{ $row->item_count }}</a>
                                @endif

                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-success btn-min-width mr-1 mb-1"><i class="la la-backward" ></i> Back</a>
        </div>
    </div>
</div>

@endsection

@push('custom_js')
    <script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>

@endpush

