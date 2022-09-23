@extends('admin.layout.master')

@section('merchant_bill','active')
@section('Payment','open')

@section('title') @lang('invoice.list_page_title') @endsection
@section('page-name') @lang('invoice.list_page_sub_title') @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('invoice.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">@lang('invoice.breadcrumb_sub_title')</li>
@endsection

@push('custom_css')
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">

    <style>
        .paystatus_due{color:#815656;}
    </style>

@endpush

@php
    $roles = userRolePermissionArray();
@endphp

@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="card card-success">
                <div class="card-header"></div>
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="process_data_table">
                                        <thead>
                                        <tr>
                                            <th class="text-center">SL.</th>
                                            <th class="text-center">Bill No</th>
                                            <th>Bill Date</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Merchant</th>
                                            <th class="text-right">Bill Amount</th>
                                            <th class="text-right">Discount</th>
                                            <th class="text-right">Net Amount</th>
                                            <th class="text-right">Paid Amount</th>
                                            <th class="text-right">Due Amount</th>

                                            <th class="text-center" style="width: 80px;">@lang('tablehead.tbl_head_action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($data['rows']) && count($data['rows']) > 0 )
                                            @foreach($data['rows'] as $key =>  $row)
                                            <tr>
                                                <td class="text-center">{{ $key+1 }}</td>
                                                <td class="text-center">{{ $row->SHIPMENT_NO }}</td>
                                                <td>
                                                    @if($row->BILL_DATE)
                                                    {{ date('d-m-Y', strtotime($row->BILL_DATE) ) }}
                                                    @else
                                                    {{ date('d-m-Y', strtotime($row->GENERATE_DATE) ) }}
                                                    @endif
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($row->FROM_DATE) ) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($row->TO_DATE) ) }}</td>
                                                <td>{{ $row->MERCHANT_NAME }}</td>
                                                <td class="text-right">{{ number_format($row->AMOUNT,2) }}</td>
                                                <td class="text-right">{{ number_format($row->DISCOUNT,2) }}</td>
                                                <td class="text-right">{{ number_format($row->NET_AMOUNT,2) }}</td>
                                                <td class="text-right">{{ number_format($row->PAID_AMOUNT,2) }}</td>
                                                <td class="text-right">{{ number_format($row->DUE_AMOUNT,2) }}</td>
                                                <td  class="text-center">

                                                    @if(hasAccessAbility('edit_merchant_bill', $roles))
                                                        <a href="{{ route('admin.mer_bill.edit',['id' =>  $row->PK_NO ]) }}" class="btn btn-xs btn-success mr-05" title="EDIT BILL"><i class="la la-edit"></i></a>
                                                    @endif
                                                    @if($row->STATUS == 0)
                                                    @if(hasAccessAbility('delete_merchant_bill', $roles))
                                                        <a href="{{ route('admin.mer_bill.delete',['id' =>  $row->PK_NO]) }}" class="btn btn-xs btn-danger mr-05" title="DELETE BILL" onclick="return confirm('Are you sure want to delete this?');"><i class="la la-trash"></i></a>

                                                    @endif
                                                    @endif

                                                </td>

                                            </tr>
                                            @endforeach
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




@push('custom_js')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript"  src="{{asset('/app-assets/js/scripts/bootstrap-datetimepicker.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('/app-assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/pages/invoice.js')}}"></script>

<script>

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var get_url = $('#base_url').val();


    });
</script>

@endpush('custom_js')
