@extends('admin.layout.master')

@section('Warehouse Operation','open')
@section('product_list_','active')

@section('title') Stock List @endsection
@section('page-name') Stock List @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('unshelve.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">Stock List</li>
@endsection

@php
    $roles = userRolePermissionArray();
    // echo '<pre>';
    // echo '======================<br>';
    // print_r($store);
    // echo '<br>======================<br>';
    // exit();
@endphp

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
    <style>
        .dataTables_wrapper .dataTables_processing{height: 60px !important;margin-top: 0px !important;background: #b4ffed !important;}
        #warehouse-filter input {margin-bottom: 10px;}
        .sku-desc{text-align: left;margin-left: 9px;}
    </style>
@endpush


@section('content')
    <div class="content-body">
        <section id="pagination">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard min-height">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <form class="form-inline" action="{{ route('admin.all_product.list') }}" style="position: relative;" method="get">
                                            <div class="form-group " style="">
                                            {!! Form::select('shop_id', $store, request()->get('shop_id') ?? null, ['class' => 'form-control select2','id' => 'shop_id','placeholder' => 'Select branch']) !!}

                                            <input type="text" class="form-control" name="keywords" placeholder="search by product name, ig code or barcode" style="min-width: 300px;" title="search by product name, ig code or barcode" value="{{ request()->get('keywords') }}"> &nbsp; &nbsp; &nbsp;
                                            <button type="submit" class="btn btn-info btn-sm">Search</button> &nbsp; &nbsp; &nbsp;
                                            <a href="{{ route('admin.all_product.list') }}" class="btn btn-info btn-sm">Reset</a>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="table-responsive ">
                                            <table class="table table-striped table-bordered table-sm" id="process_data_table" style="" >
                                                <thead>
                                                <tr>
                                                    <th class="text-center">SL.</th>
                                                    <th class="text-center">Image</th>
                                                    <th>Product Name</th>
                                                    <th width="150px">SKU Id</th>
                                                    <th>Branch</th>
                                                    <th>Product Count</th>
                                                    {{-- <th>Boxed</th>
                                                    <th>Yet to Box</th>
                                                    <th>Shipment Assigned</th>
                                                    <th>Shelved</th>
                                                    <th>Not Shelved</th> --}}
                                                    <th>Dispatched</th>
                                                    <th style="width: 30px" class="text-center" >@lang('tablehead.tbl_head_action')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($rows) && count($rows) > 0 )
                                                        @foreach($rows as $key => $row )

                                                            <tr>
                                                                <td class="text-center">{{ $rows->firstItem() + $key }}</td>
                                                                <td class="text-center">
                                                                    <a href="{{fileExit($row->THUMB_PATH)}}" target="_blank"><img src="{{fileExit($row->THUMB_PATH)}}" class="img-fluid img-sm"></a>
                                                                </td>

                                                                <td style="width: 250px; text-align: left">
                                                                    <a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" data-html="true" class="w-tooltip"
                                                                    data-title="
                                                                    <h5>Product Price</h5>
                                                                    <pre>Regular : {{number_format($row->REGULAR_PRICE,2)}} </pre>
                                                                    <pre>Special : {{number_format($row->SPECIAL_PRICE,2)}} </pre>
                                                                    <pre>Wholesale : {{number_format($row->WHOLESALE_PRICE,2)}} </pre>
                                                                     " data-original-title="" title="" data-popup="tooltip-custom"  data-bg-color="white">{{ $row->PRD_VARINAT_NAME }}</a>
                                                                </td>

                                                                <td>
                                                                    <div class="sku-box d-flex">
                                                                        <div class="sku-title text-left">
                                                                            <p>BC</p>
                                                                            <p>SKU</p>
                                                                        </div>
                                                                        <div class="sku-desc">
                                                                            <p>:{{ $row->BARCODE }}</p>
                                                                            <p>:{{ $row->SKUID }}</p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>{{ $row->F_SHOP_NAME }}</td>
                                                                <td>
                                                                    <a href="javascript:void(0)" style="text-decoration: underline;" id="popup_product_modal" data-toggle="modal" data-target="#popup_product_modal_" title="See Details" data-url="product-details-modal" data-sku_id="{{ $row->SKUID }}" data-warehouse_no="{{ $row->F_INV_WAREHOUSE_NO }}" data-type="booked">{{ $row->ORDERED }}</a>/{{ $row->COUNTER }}
                                                                </td>
                                                                {{-- <td>
                                                                    <a href="javascript:void(0)" style="text-decoration: underline;" id="popup_product_modal" data-toggle="modal" data-target="#popup_product_modal_" title="See Details" data-url="product-details-modal" data-sku_id="{{ $row->SKUID }}" data-warehouse_no="{{ $row->F_INV_WAREHOUSE_NO }}" data-type="boxed">{{ $row->BOXED_QTY }}</a>
                                                                </td> --}}
                                                                {{-- <td>{{ $row->YET_TO_BOXED_QTY ?? 0 }}</td> --}}
                                                                {{-- <td>
                                                                    <a href="javascript:void(0)" style="text-decoration: underline;" id="popup_product_modal" data-toggle="modal" data-target="#popup_product_modal_" title="See Details" data-url="product-details-modal" data-sku_id="{{ $row->SKUID }}" data-warehouse_no="{{ $row->F_INV_WAREHOUSE_NO }}" data-type="shipped">{{ $row->SHIPMENT_ASSIGNED_QTY ?? 0 }}</a>
                                                                </td> --}}
                                                                {{-- <td>
                                                                    <a href="javascript:void(0)" style="text-decoration: underline;" id="popup_product_modal" data-toggle="modal" data-target="#popup_product_modal_" title="See Details" data-url="product-details-modal" data-sku_id="{{ $row->SKUID }}" data-warehouse_no="{{ $row->F_INV_WAREHOUSE_NO }}" data-type="shelved">{{ $row->SHELVED_QTY ?? 0 }}</a>
                                                                </td> --}}
                                                                {{-- <td>{{ $row->NOT_SHELVED_QTY ?? 0 }}</td> --}}
                                                                <td>
                                                                    <a href="javascript:void(0)" style="text-decoration: underline;" id="popup_product_modal" data-toggle="modal" data-target="#popup_product_modal_" title="See Details" data-url="product-details-modal" data-sku_id="{{ $row->SKUID }}" data-warehouse_no="{{ $row->F_INV_WAREHOUSE_NO }}" data-type="dispatched">{{ $row->DISPATCHED }}</a>
                                                                </td>
                                                                <td class="text-center">
                                                                    @if (hasAccessAbility('view_warehouse_stock_view', $roles))
                                                                        <a href="{{ route("admin.stock_price.view", [$row->PK_NO])}}" class="btn btn-xs btn-success mb-05 mr-05" title="View Product"><i class="la la-eye"></i></a> <a href="{{ route("admin.faulty.list", ['product',$row->F_PRD_VARIANT_NO])}}" class="btn btn-xs btn-warning mb-05 mr-05" title="Mark Faulty"><i class="la la-warning"></i></a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                    <tr>
                                                        <td colspan="13" align="center">No matching records found</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="pagination">
                                            @if(isset($rows) && count($rows) > 0 )
                                            {{ $rows->appends(request()->query() ?? '')->links() }}
                                            @endif
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
@include('admin.shelve._product_modal')
@endsection

@push('custom_js')

<script src="{{ asset('assets/js/scripts/tooltip/tooltip.js')}}"></script>
{{-- <script type="text/javascript" src="{{ asset('assets/pages/product_details.js')}}"></script> --}}
<script>
    /*
        var pageurl = `{{ URL::to('get-warehouse-dropdown') }}`;
        $.ajax({
            type:'post',
            url:pageurl,
            dataType: "json",
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                $('#warehouse-filter').append(data);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
        */

</script>
{{-- <script type="text/javascript">

    function datatable_() {
        var table =
            $('#process_data_table').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                pageLength: 25,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                "deferLoading": false,
                dom: 'l<"#warehouse-filter2"><"#warehouse-filter">frtip',
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                ajax: {
                    url: `{{URL::to('all_product_list')}}`,
                    type: 'POST',
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columnDefs: [
                    { visible: false, targets: 4 },
                    { visible: false, targets: 5 }
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
                            data: 'PRC_IN_IMAGE_PATH',
                            name: 'PRC_IN_IMAGE_PATH',
                            searchable: false,
                            render: function(data, type, row) {
                                 return '<a href="{{URL::to('')}}'+row.PRD_VARIANT_IMAGE_PATH+'" target="_blank"><img src="{{URL::to('')}}'+row.PRD_VARIANT_IMAGE_PATH+'" class="img-fluid img-sm"></a>';
                            }
                        },
                        {
                            data: 'PRD_VARINAT_NAME',
                            name: 'PRD_VARINAT_NAME',
                            searchable: true
                        },
                        {
                            data: 'SKUID',
                            name: 'SKUID',
                            ig_code: 'IG_CODE',
                            barcode: 'BARCODE',
                            searchable: true,
                            render: function(data, type, row) {
                                return '<div style="display:inline-block;"><span style="width:40px;display: inline-block;">IG</span>:'+row.IG_CODE+'</div><br>'
                                        +'<div style="display:inline-block;"><span style="width:40px;display: inline-block;">BC</span>:'+row.BARCODE+'</div><br>'
                                        +'<div style="display:inline-block;"><span style="width:40px;display: inline-block;">SKU</span>:'+row.SKUID+'</div>';

                                // return '<span>IG: <span style="text-align:center;">'+row.IG_CODE+'</span></span><br>'
                                // +'<span>BARCODE: <span style="text-align:center;">'+row.BARCODE+'</span></span><br>'
                                // +'<span>SKU: <span style="text-align:center;">'+row.SKUID+'</span></span>';
                            }
                        },
                        {
                            data: 'BARCODE',
                            name: 'BARCODE',
                            searchable: true,
                        },
                        {
                            data: 'IG_CODE',
                            name: 'IG_CODE',
                            searchable: true,
                        },
                        {
                            data: 'F_SHOP_NAME',
                            name: 'F_SHOP_NAME',
                            searchable: true,
                        },
                        {
                            data: 'COUNTER',
                            name: 'COUNTER',
                            skuid: 'SKUID',
                            warehouse: 'warehouse_no',
                            className: 'text-center',
                            searchable: false,
                            render: function(data, type, row) {
                                return '<a href="javascript:void(0)" style="text-decoration: underline;" id="popup_product_modal" data-toggle="modal" data-target="#popup_product_modal_" title="See Details" data-url="product-details-modal" data-sku_id="'+row.SKUID+'" data-warehouse_no="'+row.WAREHOUSE_NO+'" data-type="booked">'+row.ORDERED+'</a>'+'/'+row.COUNTER;
                            }
                        },
                        {
                            data: 'BOXED_QTY',
                            name: 'BOXED_QTY',
                            boxed: 'SKUID',
                            warehouse: 'WAREHOUSE_NO',
                            className: 'text-center',
                            searchable: false,
                            render: function(data, type, row) {
                                return '<a href="javascript:void(0)" style="text-decoration: underline;" id="popup_product_modal" data-toggle="modal" data-target="#popup_product_modal_" title="See Details" data-url="product-details-modal" data-sku_id="'+row.SKUID+'" data-warehouse_no="'+row.WAREHOUSE_NO+'" data-type="boxed">'+row.BOXED_QTY+'</a>';
                            }
                        },
                        {
                            data: 'YET_TO_BOXED_QTY',
                            name: 'YET_TO_BOXED_QTY',
                            className: 'text-center',
                            searchable: false
                        },
                        {
                            data: 'SHIPMENT_ASSIGNED_QTY',
                            name: 'SHIPMENT_ASSIGNED_QTY',
                            boxed: 'SKUID',
                            warehouse: 'warehouse_no',
                            className: 'text-center',
                            searchable: false,
                            render: function(data, type, row) {
                                return '<a href="javascript:void(0)" style="text-decoration: underline;" id="popup_product_modal" data-toggle="modal" data-target="#popup_product_modal_" title="See Details" data-url="product-details-modal" data-sku_id="'+row.SKUID+'" data-warehouse_no="'+row.WAREHOUSE_NO+'" data-type="shipped">'+row.SHIPMENT_ASSIGNED_QTY+'</a>';
                            }
                        },
                        {
                            data: 'SHELVED_QTY',
                            name: 'SHELVED_QTY',
                            boxed: 'SKUID',
                            warehouse: 'WAREHOUSE_NO',
                            searchable: false,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return '<a href="javascript:void(0)" style="text-decoration: underline;" id="popup_product_modal" data-toggle="modal" data-target="#popup_product_modal_" title="See Details" data-url="product-details-modal" data-sku_id="'+row.SKUID+'" data-warehouse_no="'+row.WAREHOUSE_NO+'" data-type="shelved">'+row.SHELVED_QTY+'</a>';
                            }
                        },
                        {
                            data: 'NOT_SHELVED_QTY',
                            name: 'NOT_SHELVED_QTY',
                            className: 'text-center',
                            searchable: false
                        },
                        {
                            data: 'DISPATCHED',
                            name: 'DISPATCHED',
                            skuid: 'SKUID',
                            warehouse: 'warehouse_no',
                            className: 'text-center',
                            searchable: false,
                            render: function(data, type, row) {
                                return '<a href="javascript:void(0)" style="text-decoration: underline;" id="popup_product_modal" data-toggle="modal" data-target="#popup_product_modal_" title="See Details" data-url="product-details-modal" data-sku_id="'+row.SKUID+'" data-warehouse_no="'+row.WAREHOUSE_NO+'" data-type="dispatched">'+row.DISPATCHED+'</a>';
                            }
                        },
                        {
                            data: 'action',
                            name: 'action',
                            searchable: false
                        }
                    ]
            });
            warehouse_dropdown();
            $('#warehouse-filter2').addClass('dataTables_length offset-md-6 col-lg-2 col-md-2 col-sm-12');
            $('#warehouse-filter').addClass('dataTables_length col-lg-2 col-md-2 col-sm-12').css('float','right');

            $('<input>').attr('type','text').attr('id','search_input').addClass('form-control search-input2').attr('placeholder','Enter Search Keyword').attr('autocomplete','off').appendTo('#warehouse-filter');

        return table;
    }

    $(document).ready(function() {
        table = datatable_();
        $('#process_data_table_filter').hide();
        $('#process_data_table').hide();
        $('#process_data_table_info').hide();
        $('#process_data_table_paginate').hide();
        $('#process_data_table_processing').hide();
        // $('#process_data_table_filter .form-control').keyup( function() {
        //     //  table.search($(this).val()).draw();
        //     $('#process_data_table').show();
        //     $('#process_data_table_paginate').show();
        //     $('#process_data_table_processing').show();
        // });
    });
    function destroy_table() {
        $('#process_data_table').DataTable().clear().destroy();
        table = datatable_();
        $('#process_data_table').hide();
        $('#process_data_table_info').hide();
        $('#process_data_table_paginate').hide();
        $('#process_data_table_processing').hide();
        // $('#process_data_table_filter .form-control').keyup( function() {
        //     //  table.search($(this).val()).draw();
        //     $('#process_data_table').show();
        //     $('#process_data_table_paginate').show();
        //     $('#process_data_table_processing').show();
        // });
    }
    $(document).on('keyup','#process_data_table_filter .form-control', function(){
        $('#process_data_table').show();
        $('#process_data_table_paginate').show();
        $('#process_data_table_info').show();
        $('#process_data_table_processing').show();
    });
    function warehouse_dropdown() {
        var pageurl = `{{ URL::to('get-warehouse-dropdown') }}`;
        $.ajax({
            type:'post',
            url:pageurl,
            dataType: "json",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                $('#warehouse-filter2').append(data);
                $('#warehouse_type').on('change', function() {
                    var warehouse_type = $(this).val();
                    if (warehouse_type == 0) {
                        destroy_table();
                    }else{
                        table.columns(6).search(warehouse_type).draw();
                    }
                });
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    }
    // $('#search_input').keypress(function (e) {
    $(document).on('keypress','#search_input', function(e){
        var key = e.which;
        if(key == 13)  // the enter key code
        {
            $('#process_data_table_filter .form-control').val($(this).val());
            $('#process_data_table_filter .form-control').keyup();
            $('#process_data_table').show();
            $('#process_data_table_paginate').show();
            $('#process_data_table_info').show();
            $('#process_data_table_processing').show();
        return false;
      }
    });
</script> --}}
@endpush
