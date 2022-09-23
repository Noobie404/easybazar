@extends('seller.layout.master')

@section('Procurement','open')
@section('stock_processing','active')

@section('title') Stock Processing @endsection
@section('page-name') Stock Processing @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('seller.dashboard') }}">@lang('form.dashboard')</a></li>
    <li class="breadcrumb-item active">@lang('form.breadcrumb_stock_processing')</li>
@endsection

@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{asset('/assets/vendors/css/extensions/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <style type="text/css">
        .acc{width: 55px; line-height: 18px; font-style: italic; display: inline-block;}
    </style>
@endpush

<?php
    $roles              = userRolePermissionArray();
    $rows               = $data['rows'] ?? null;
?>

@section('content')
<div class="content-body min-height">
    <section id="pagination">
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header">
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
                                <table class="table table-striped table-bordered table-sm" id="process_data_table">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 30px;">SL.</th>
                                            <th class="text-center" style="width: 120px;">Date</th>
                                            <th class="text-center">Vendor</th>
                                            <th class="text-center" style="width: 150px;">Account Info</th>
                                            <th class="text-center">Reciept No</th>
                                            <th class="text-center {{ request()->get('invoice_for') == 'merchant' ? 'd-none' : '' }} " title="Calculated/Reciept Value">Cal/Rec </th>
                                            <th class="text-center" title="Receive quantity (Faulty quantity) / Reciept quantity">Rec(Faulty)/Total</th>
                                            <th class="text-center" title="loyalty claimed">Loyalty Claimed</th>
                                            <th class="text-center" title="Vat refund claimed">Rec VAT Claimed</th>
                                            <th class="text-center" title="Exact VAT">Exact VAT</th>

                                            <th class="text-center" title="STOCK GENERATING">Stock Generated</th>
                                            <th class="text-center" style="width: 100px;">@lang('tablehead.tbl_head_action')</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

{{-- @include('admin.procurement.invoice_processing._select_warehouse', $store_list) --}}


@endsection


@push('custom_js')
<script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/pages/seller_invoice.js?v=1.10')}}"></script>
<script>
    $(document).on('click','.page-link', function(){
        var pageNum = $(this).text();
        setCookie('invoice-processing',pageNum);
    });
    var value = getCookie('invoice-processing');
</script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var get_url = $('#base_url').val();

        var table   = $('#process_data_table').DataTable({
            processing: false,
            serverSide: true,
            paging: true,
            pageLength: 25,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            ajax: {
                url: get_url+'/seller/invoice-processing/list',
                type: 'POST',
                data: function(d) {
                    d._token  = "{{ csrf_token() }}";
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
                    name: 'INVOICE_DATE',
                    searchable: true,
                    className:'w100'
                },
                {
                    data: 'vendor',
                    name: 'VENDOR_NAME',
                    searchable: true,
                },
                {
                    data: 'acc_info',
                    name: 'acc_info',
                    searchable: true
                },
                {
                    data: 'reciept_no',
                    name: 'INVOICE_NO',
                    searchable: true,

                },
                {
                    data: 'cal_value',
                    name: 'cal_value',
                    searchable: true,
                    className:'text-uppercase',
                },
                {
                    data: 'cal_qty',
                    name: 'cal_qty',
                    searchable: true,
                },
                {
                    data: 'loyalty',
                    name: 'loyalty',
                    searchable: false,
                    className: 'text-center',

                },
                {
                    data: 'vat_claim',
                    name: 'vat_claim',
                    searchable: false,
                    className: 'text-right',
                },
                {
                    data: 'ext_vat',
                    name: 'ext_vat',
                    searchable: false,
                    className:'text-right',
                },
                {
                    data: 'stock_gen',
                    name: 'INV_STOCK_RECORD_GENERATED',
                    searchable: false,
                    orderable: true,
                    className: 'text-center ',
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    className: 'text-center'
                },
            ],
        });
        // table.column(3).search("UKSHOP LTD/AMEX-1003",true,false).draw();
    });
</script>

@endpush('custom_js')
