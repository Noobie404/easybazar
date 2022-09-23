@extends('admin.layout.master')

@section('invoice','active')
@section('Procurement','open')

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
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">

    <style>
    .paystatus_due{color:#815656;}

    .invoice-entry{
        display: inline-flex;
    }
    .invoice-entry .help-block{display:none;}
    </style>

@endpush

@php
    $tab_index = 0;
    $roles = userRolePermissionArray();
    $branch_id = null;
    $branch = $data['branch'] ?? [];
    $branch_id =  request()->get('branch_id');
    if(Auth::user()->USER_TYPE == 10){
        $branch_id = Auth::user()->SHOP_ID;
    }


@endphp

@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                <a class="text-white btn btn-round btn-sm btn-primary" href="{{route('admin.invoice.new')}}"  title="Add new invoice"><i class="ft-plus text-white"></i> @lang('invoice.create_btn')</a>
                                {!! Form::open([ 'route' => 'admin.invoice', 'method' => 'get', 'class' => 'form-inline invoice-entry', 'files' => true , 'novalidate']) !!}
                                <div class="form-group {!! $errors->has('branch_id') ? 'error' : '' !!}">
                                    <div class="controls">
                                {!! Form::select('branch_id', $branch, $branch_id, [ 'class' => 'form-control ', 'placeholder' => 'Select branch', 'tabindex' => $tab_index++ ]) !!}

                                    </div>
                                </div>
                                <div class="form-group {!! $errors->has('branch_id') ? 'error' : '' !!}">
                                    <div class="controls">
                                <button type="submit" class="text-white btn btn-round  btn-primary" title="Search">Search</button>
                                    </div>
                                </div>

                                {!! Form::close() !!}
                             </div>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered" id="process_data_table">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">SL.</th>
                                                    <th class="text-center">Branch</th>
                                                    <th class="text-center">Date</th>
                                                    <th class="text-center">Vendor</th>
                                                    <th class="text-center">Reciept No</th>
                                                    <th class="text-center" title="Calculated/Reciept Value">Cal/Rec </th>
                                                    <th class="text-center">Rec(Faulty)/Total</th>
                                                    <th class="text-center">VAT</th>
                                                    <th class="text-center" style="width: 220px;">@lang('tablehead.tbl_head_action')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="10" class="text-center">
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
                </div>
            </div>
        </section>
    </div>
@if( request()->get('open_poup') == 'yes')
    <!--Edit Product Subcategory  html-->
<div class="modal fade text-left" id="non_paid_invoice" tabindex="-1" role="dialog" aria-labelledby="non_paid_invoice" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <p>Non Paid Invoice for {{ $data['merchant']->NAME ?? '' }}</p>
                    <p style="font-size: 12px;">From date : {{ request()->get('from_date') }}</p>
                    <p style="font-size: 12px;">To date : {{ request()->get('to_date') }}</p>

                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                {!! Form::open(['method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate' , 'id' => 'bill_gen_frm', 'route' => 'admin.mer_bill.create' ] ) !!}
                <input type="hidden" value="{{ request()->get('from_date') }}" name="from_date" />
                <input type="hidden" value="{{ request()->get('to_date') }}" name="to_date" />
                <input type="hidden" value="{{ $data['merchant']->PK_NO }}" name="f_merchant_no" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered" >
                                <thead>
                                <tr>
                                    <th class="text-center">SL.</th>
                                    <th class="text-center" style="width: 80px;">Date</th>
                                    <th class="text-center">Vendor</th>
                                    <th class="text-center">Invoice For</th>
                                    <th class="text-center">Reciept No</th>
                                    <th class="text-center">Currency</th>
                                    <th class="text-center">Invoice Value</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">@lang('tablehead.tbl_head_action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if(isset($data['invoices']) && count($data['invoices']) > 0 )
                                    @php $invoice_exact_value = 0; @endphp
                                    @foreach($data['invoices'] as $key => $row )
                                    @php
                                        $invoice_exact_value += $row->MER_INVOICE_TOTAL_ACTUAL_GBP;
                                    @endphp
                                    <tr class="tr_{{ $row->PK_NO }}">
                                        <td>
                                            <input type="hidden" value="{{ $row->PK_NO }}" name="pk_no[]" />
                                            {{ $key+1 }}
                                        </td>
                                        <td>{{ date('d-m-Y',strtotime($row->INVOICE_DATE)) }}</td>
                                        <td>{{ $row->VENDOR_NAME }}</td>
                                        <td>{{ $data['merchant']->NAME }}</td>
                                        <td>{{ $row->INVOICE_NO }}</td>
                                        <td>{{ $row->INVOICE_CURRENCY }}</td>
                                        <td class="text-right">
                                            {{ number_format($row->MER_INVOICE_TOTAL_ACTUAL_GBP,2) }}
                                            <input type="hidden" value="{{ $row->MER_INVOICE_TOTAL_ACTUAL_GBP }}" class="invoice_exact_value" />
                                        </td>
                                        <td>{{ $row->RECIEVED_QTY }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info" type="button" onclick="delectTr({{ $row->PK_NO }})">X</button>
                                        </td>

                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6">Total</td>
                                        <td class="text-right g_invoice_total">
                                            {{  number_format($invoice_exact_value,2) }}
                                            <input type="hidden" value="{{ $invoice_exact_value }}" name="amount" id="amount" />
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="10" class="text-center">Data not found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group {!! $errors->has('shipment_no') ? 'error' : '' !!}">
                                <label>Shipment<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <select class="form-control" name="shipment_no">
                                        @if(isset($data['shipments']) && count($data['shipments']) > 0 )
                                        @foreach($data['shipments'] as $ke =>  $ship )
                                        <option value="{{ $ship->PK_NO }}">({{ $data['merchant']->SHORT_NAME }}){{ $ship->CODE }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    {!! $errors->first('shipment_no', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary btn-sm submit-btn" value="Generate" title="Update">
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endif
@endsection
@push('custom_js')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript"  src="{{asset('assets/js/scripts/bootstrap-datetimepicker.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>

<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/pages/invoice.js')}}"></script>
<script>
    var get_url = $('#base_url').val();
    $(document).on('click','.page-link', function(){
        var pageNum = $(this).text();
        setCookie('invoice',pageNum);
    });
    var value = getCookie('invoice');
    var table = $('#indextable').dataTable({
        'pageLength' : 50,
    });

    if (value !== null) {
        var value = value-1
        table.fnPageChange(value,true);
    }
</script>
<script>
    /*
    $(document).on('change','#merchant_invoice_view', function(){
        var merchant_id = $(this).attr('data-merchant_id');
        var invoice_id = $(this).attr('data-invoice_pk');
        if ($(this).is(':checked')) {
            var check_type = 1;
        }else{
            var check_type = 0;
        }
        $.ajax({
                type :'post',
                data:{
                    merchant_id : merchant_id,
                    invoice_id : invoice_id,
                    check_type : check_type
                },
                url:get_url+'/merchant_invoice_pdf_permission',
                async :true,
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (data) {
                    if(data.status == true){
                        toastr.success('Success !','Success');
                    }else{
                        toastr.info('Please try again','Info');
                    }
                },
                complete: function (data){
                    $("body").css("cursor", "default");
                }
        });
    });
    */
</script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var branch_id   = "{{ request()->get('branch_id') }}";
        var invoice_for   = "{{ request()->get('invoice_for') }}";
        var var_vat = '';
        if(invoice_for == 'merchant'){
            var var_vat = 'd-none';
        }
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
            aaSorting: [],
            ajax: {
                url: get_url+'/invoice/list',
                type: 'POST',
                data: function(d) {
                    d._token        = "{{ csrf_token() }}";
                    d.invoice_for   = invoice_for;
                    d.branch_id   = branch_id;
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
                    data: 'shop',
                    name: 'shop',
                    searchable: true,
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
                    data: 'reciept_no',
                    name: 'reciept_no',
                    searchable: true,

                },
                {
                    data: 'cal_value',
                    name: 'cal_value',
                    searchable: true,
                    className:'text-uppercase text-right'
                },
                {
                    data: 'cal_qty',
                    name: 'cal_qty',
                    searchable: true,
                },
                {
                    data: 'vat',
                    name: 'vat',
                    searchable: false,
                    className: 'text-right '+ var_vat

                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    className: 'text-center'
                },
            ],
        });

    });
</script>


<script type="text/javascript">
$(function() {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('DD-MM-Y') + ' - ' + end.format('DD-MM-Y'));
        $('#from_date').val(start.format('DD-MM-Y'));
        $('#to_date').val(end.format('DD-MM-Y'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

});

</script>

<script type="text/javascript">
    $(window).on('load', function() {
        var open_poup = "{{ request()->get('open_poup') }}";
        if(open_poup == 'yes'){
            $('#non_paid_invoice').modal('show');
        }
    });
    function delectTr(id) {
        if (confirm('Are you sure ? ')) {
            $('.tr_'+id).remove();
        }
        var sum = 0;
        $('.invoice_exact_value').each(function(){
            sum += parseFloat(this.value);
        });
        $('.g_invoice_total').text(sum.toFixed(2));
        $('#amount').val(sum);

    }
</script>
@endpush('custom_js')
