@extends('admin.layout.master')

@section('Procurement','open')
@section('invoice_product_details','active')

@section('title') Invoice Product Details @endsection
@section('page-name') Invoice Product Details @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin_role.breadcrumb_title') </a></li>
    <li class="breadcrumb-item active">Invoice Product Details </li>
@endsection

@php
    $roles = userRolePermissionArray();

@endphp

@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/file_upload/image-uploader.min.css')}}">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/editors/summernote.css')}}">
    <style>
        #warehouse th{border:none;border-bottom:1px solid #333;font-size:12px;font-weight:400;padding-bottom:15px}.shipment_box{border-bottom:1px solid #e3ebf3;padding:12px}.box_{display:inline-block;margin-left:45px}.shipment_{display:inline-block;vertical-align:top}
    </style>
@endpush('custom_css')

@section('content')
<div class="card card-success">
    <div class="card-header">
        <h4 class="card-title" id="basic-layout-colored-form-control"><i class="ft-plus text-primary"></i> Invoice Product Details</h4>
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
        <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm alt-pagination" id="invoicetable">
                                <thead>
                                    <tr>
                                        <th>SL.</th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        @if ($pagetype == 'stock-processing')
                                        <th>Outlet </th>
                                        @endif
                                        <th>Product Count</th>
                                        @if ($pagetype == 'stock-processing')
                                            {{-- <th>Shelved</th>
                                            <th>Not Shelved</th> --}}
                                            <th>Dispatched</th>
                                            @if (hasAccessAbility('view_warehouse_stock_view', $roles))
                                            <th style="width: 30px">@lang('tablehead.tbl_head_action')</th>
                                            @endif
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($data && count($data) > 0 )
                                    @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->index+1 }}</td>
                                        <td style="width: 10%;">

                                        @if(!empty($item->PRD_VARIANT_IMAGE_PATH))
                                            <img style="width: 50px !important; height: 50px;" data-src="{{ fileExit($item->PRD_VARIANT_IMAGE_PATH)}}" alt="{{ $item->DEFAULT_NAME ?? ''}}" src="{{fileExit($item->PRD_VARIANT_IMAGE_PATH)}}">
                                        @endif
                                        </td>
                                        <td id="prd_name" style="width: 40%">
                                            {{ $item->PRD_VARINAT_NAME ?? '' }} <br>
                                            {{-- <div style="display:inline-block;"><span style="width:40px;display: inline-block;">IG</span> : {{ $item->IG_CODE }}</div><br> --}}
                                            <div style="display:inline-block;"><span style="width:40px;display: inline-block;">BC</span> : {{ $item->BARCODE }}</div><br>
                                            <div style="display:inline-block;"><span style="width:40px;display: inline-block;">SKU</span> : {{ $item->SKUID }}</div>
                                        </td>
                                        @if ($pagetype == 'stock-processing')
                                        <td>{{ $item->SHOP_NAME }}</td>
                                        @endif
                                        <td>
                                            @if ($pagetype == 'stock-processing')
                                            <a href="javascript:void(0)" style="text-decoration: underline;" id="popup_product_modal" data-toggle="modal" data-target="#popup_product_modal_" title="See Details" data-url="product-details-modal-invoice" data-sku_id="{{ $item->SKUID }}" data-warehouse_no="{{ $item->WAREHOUSE_NO }}" data-type="booked">{{ $item->ORDERED }}</a>/
                                            @endif
                                            {{ $item->COUNTER }}
                                        </td>
                                        @if ($pagetype == 'stock-processing')

                                        {{-- <td>
                                            <a href="javascript:void(0)" style="text-decoration: underline;" id="popup_product_modal" data-toggle="modal" data-target="#popup_product_modal_" title="See Details" data-url="product-details-modal-invoice" data-sku_id="{{ $item->SKUID }}" data-warehouse_no="{{ $item->WAREHOUSE_NO }}" data-type="shelved">{{ $item->SHELVED_QTY }}</a>
                                        </td>
                                        <td>
                                            {{ $item->NOT_SHELVED_QTY }}
                                        </td> --}}
                                        <td>
                                            <a href="javascript:void(0)" style="text-decoration: underline;" id="popup_product_modal" data-toggle="modal" data-target="#popup_product_modal_" title="See Details" data-url="product-details-modal-invoice" data-sku_id="{{ $item->SKUID }}" data-warehouse_no="{{ $item->WAREHOUSE_NO }}" data-type="dispatched">{{ $item->DISPATCHED }}</a>
                                        </td>
                                        @if (hasAccessAbility('view_warehouse_stock_view', $roles))
                                        <td>
                                            <a href="{{ route("admin.stock_price.view", [$item->PK_NO,'invoice_for='.request()->get('invoice_for')]) }}" class="btn btn-xs btn-success mb-05 mr-05" title="View Product"><i class="la la-eye"></i></a>
                                        </td>
                                        @endif
                                        @endif
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
    @include('admin.shelve._product_modal')
@endsection
@push('custom_js')
 <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    /*View Product Details Modal*/
    $(document).on('click','#popup_product_modal', function(){
        var url         = $(this).data('url');
        var sku_id      = $(this).data('sku_id');
        var warehouse   = $(this).data('warehouse_no');
        var type        = $(this).data('type');
        var invoice_id  = `{{ $invoiceid }}`;
        var invoice_type  = `{{ $pagetype }}`;
        var get_url = $('#base_url').val();

        var pageurl = get_url+'/'+url;
        $.ajax({
            type:'post',
            url:pageurl,
            dataType: "json",
            data: {
                sku_id: sku_id,
                warehouse_no: warehouse,
                type: type,
                invoice_id: invoice_id,
                invoice_type: invoice_type,
                "_token": $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                var label = ''
                if (type == 'boxed') {
                    var label = 'Product In Box'
                }else if (type == 'shipped') {
                    var label = 'Product In Shipment'
                }else if (type == 'shelved') {
                    var label = 'Product In Shelve'
                }else if (type == 'dispatched') {
                    var label = 'Product That Is Dispatched'
                }
                $('#modal_title').text(label);
                $('#append_view').html('');
                $('#append_view').html(data);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    });
</script>
@endpush
