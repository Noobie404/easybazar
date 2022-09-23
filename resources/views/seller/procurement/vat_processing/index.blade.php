@extends('admin.layout.master')

@section('Procurement','open')
@section('vat_processing','active')

@section('title') Vat Processing @endsection
@section('page-name') Vat Processing @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('form.dashboard')</a></li>
    <li class="breadcrumb-item active">@lang('form.breadcrumb_vat_processing')</li>
@endsection

<?php
    $roles              = userRolePermissionArray();
    $rows               = $data['rows'] ?? null;
    $warehouse_combo    = $data['warehouse_combo'] ?? array();
?>

@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <style type="text/css">
        .acc{width: 55px; line-height: 18px; font-style: italic; display: inline-block;}
    </style>


@endpush

@section('content')
<div class="content-body min-height">
    <section id="pagination">
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header">
                        <a href="{{ route('admin.vat_processing') }}?invoice_for=azuramart" class="text-white btn btn-round btn-sm btn-primary {{ request()->get('invoice_for') != 'merchant' ? 'active' : '' }}">Auramart Invoice</a>

                        <a href="{{ route('admin.vat_processing') }}?invoice_for=merchant" class="text-white btn btn-round btn-sm btn-primary {{ request()->get('invoice_for') == 'merchant' ? 'active' : '' }}"> Merchant Invoice</a>

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
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-sm" id="indextable">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 30px;">SL.</th>
                                            <th class="text-center" style="width: 100px;">Date</th>
                                            <th class="text-center">Vendor</th>
                                            <th class="text-center">Infoice for</th>
                                            <th class="text-center" style="width: 150px;">Account Info</th>
                                            <th class="text-center">Reciept No</th>
                                            <th class="text-center" title="Calculated/Reciept Value">Cal/Rec </th>
                                            <th class="text-center" title="Receive quantity (Faulty quantity) / Reciept quantity">Rec(Faulty)/Total</th>
                                            <th class="text-center" title="Vat refund claimed">QB / Rec VAT Claimed</th>

                                            <th class="text-center" title="Exact VAT">Exact VAT</th>
                                            <th class="text-center"  style="width:100px;">@lang('tablehead.tbl_head_action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="11" class="text-center">
                                                <br>
                                                <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
                                                <br>
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
@include('admin.procurement.invoice_processing._select_warehouse', $warehouse_combo)

@endsection

<!--push from page-->
@push('custom_js')
<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('/app-assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>

<script type="text/javascript" src="{{ asset('assets/pages/invoice.js')}}"></script>
<script>
    $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    var get_url = $('#base_url').val();
    $(document).on('click','.page-link', function(){
        var pageNum = $(this).text();
        setCookie('vat-processing',pageNum);
    });
    var value = getCookie('vat-processing');
    if (value !== null ) {
        var value = (value-1)*25;
        // table.fnPageChange(value,true);
    }else{
        var value = 0;
    }
    var table = callDatatable(value);

    function callDatatable() {

       var table = $('#indextable').DataTable({
            processing: false,
            serverSide: true,
            paging: true,
            pageLength: 25,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            aaSorting: [],
            iDisplayStart: value,
            ajax: {
                url: get_url+'/vat-processing/list',
                type: 'POST',
                data: function(d) {
                    d._token        = "{{ csrf_token() }}";
                    d.invoice_for   = "{{ request()->get('invoice_for') }}";
                }
            },
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
                    data: 'date',
                    name: 'date',
                    searchable: true,
                    className:'w100'
                },
                {
                    data: 'vendor',
                    name: 'vendor',
                    searchable: true,
                },
                {
                    data: 'invoice_for',
                    name: 'invoice_for',
                    searchable: false,
                },

                {
                    data: 'acc_info',
                    name: 'acc_info',
                    searchable: true,
                },
                {
                    data: 'reciept_no',
                    name: 'reciept_no',
                    searchable: true,

                },

                {
                    data: 'cal_value',
                    name: 'cal_value',
                    searchable: true,
                    className:'text-uppercase'
                },
                {
                    data: 'cal_qty',
                    name: 'cal_qty',
                    searchable: true,
                },
                {
                    data: 'vat_calim',
                    name: 'vat_calim',
                    searchable: false,
                    orderable: true,
                },
                {
                    data: 'vat',
                    name: 'vat',
                    searchable: false,
                    className: 'text-right'

                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    className: 'text-center'
                },
            ],
        });
        return table;
    }
</script>

@endpush('custom_js')
