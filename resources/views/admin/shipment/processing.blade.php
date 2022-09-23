@extends('admin.layout.master')

@section('Shipping','open')
@section('processing_shipping','active')

@section('title') @lang('shipping.list_page_title') @endsection
@section('page-name') @lang('shipping.list_page_sub_title') @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('shipping.breadcrumb_title') </a></li>
    <li class="breadcrumb-item active">@lang('shipping.breadcrumb_sub_title')</li>
@endsection

@php
    $roles = userRolePermissionArray();
    $shipment_status = Config::get('static_array.shipping_status') ?? array();
@endphp


@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/extensions/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush

@push('custom_js')

    <script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('/app-assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>

@endpush
@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            @if(hasAccessAbility('new_shipment', $roles))
                            <a class="text-white" href="{{route('admin.shipment.create')}}">
                                <button type="button" class="btn btn-round btn-sm btn-primary">
                                    <i class="ft-plus text-white"></i> @lang('shipping.new_shipment_btn')
                                </button>
                            </a>
                            @endif
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
                                <div class="table-responsive text-center p-1">
                                    <table class="table table-striped table-bordered alt-pagination table-sm" id="indextable">
                                        <thead>
                                        <tr>
                                            <th>SL.</th>
                                            <th>Shipment No.</th>
                                            <th>AWB/Docket No.</th>
                                            <th>Delivery Address</th>
                                            <th>Box Count</th>
                                            <th>Departure Date</th>
                                            <th>Arrival Date</th>
                                            <th style="width: 20%">Status</th>
                                            <th style="width:300px;">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="rows_">
                                            @foreach ($shipment as $row)
                                            @php
                                            if($row->SHIPMENT_FOR == 1){
                                                $invoice_for = 'azuramart';
                                            }else{
                                                $invoice_for = 'merchant';
                                            }

                                            @endphp
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>@if($row->F_MERCHANT_NO == 0) (AMT) @else {{ '('.$row->MECHANT_NAME. ')' }}  @endif {{ $row->CODE }}</td>
                                                <td>{{ $row->WAYBILL }}</td>
                                                <td>{{ $row->shipment_address_set_ship_to->NAME ?? '' }}</td>
                                                <td title="BOX RECEIVED-{{ $row->received }} TOTAL BOX-{{ $row->SENDER_BOX_COUNT }}">{{ $row->received }}/{{ $row->SENDER_BOX_COUNT }}</td>
                                                <td>{{ date('d-m-Y', strtotime($row->SCH_DEPARTING_DATE)) }}</td>
                                                <td >{{ date('d-m-Y', strtotime($row->SCH_ARRIVAL_DATE)) }}</td>
                                                <td class="text-center">
                                                <div class="controls">

                                                    @if ($row->SHIPMENT_STATUS < 80)
                                                    <select name="shipment_status" id="shipment_status{{ $row->PK_NO }}" class="custom-select" data-shipment_id={{ $row->PK_NO }} data-invoice_for="{{ $invoice_for }}">
                                                    @if ($row->SHIPMENT_STATUS == 30)
                                                        <option value="30">Cancelled</option>
                                                    @else
                                                        @foreach ($shipment_status as $key => $status)
                                                            @if ($key >= $row->SHIPMENT_STATUS)
                                                            <option value="{{ $key }}">{{ $status }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    @else
                                                    <span>Shipment Life cycle completed</span>
                                                    @endif
                                                </div>
                                                </td>
                                                <td style="width:350px;">
                                                    @if(hasAccessAbility('view_shipment', $roles))
                                                    <a href="{{ route('admin.shipment.view',['id'=>$row->PK_NO,'invoice_for' => $invoice_for]) }}" title="VIEW BOX DETAILS IN THE SHIPMENT">
                                                        <button type="button" class="btn btn-xs btn-success"><i class="la la-eye">B</i></button>
                                                    </a>
                                                    @endif


                                                    @if(hasAccessAbility('add_packaging', $roles))
                                                    <a href="{{ route('admin.shipment.invoice',['id'=>$row->PK_NO,'invoice_for' => $invoice_for]) }}" title="VIEW INVOICE DETAILS IN THE SHIPMENT">
                                                        <button type="button" class="btn btn-xs btn-success"><i class="la la-eye">I</i></button>
                                                    </a>
                                                    @endif

                                                    @if ($row->SHIPMENT_STATUS <= 20)
                                                    @if(hasAccessAbility('add_packaging', $roles))
                                                    <a href="{{ route('admin.shipment.packaging',['id'=>$row->PK_NO,'type'=>1, 'invoice_for' => $invoice_for ]) }}" title="GENERATE PACKAGING" onclick="return confirm('Warning!!! Are you sure, you want to regenerate the Packing List? & If you do, will lose all previous amendment.')">
                                                        <button type="button" class="btn btn-xs btn-danger"><i class="la la-support"></i></button>
                                                    </a>
                                                    @endif
                                                    @endif

                                                    @if(hasAccessAbility('edit_packaging', $roles))
                                                    <a href="{{ route('admin.packaging.edit',['id'=>$row->PK_NO,'invoice_for' => $invoice_for]) }}" title="EDIT PACKAGING" class="btn btn-xs btn-info"><i class="la la-pencil"></i> P</a>
                                                    @endif

                                                    @if(hasAccessAbility('edit_packaging', $roles))
                                                    <a href="{{ route('admin.packaginglist.commarcialpdf',['shipment_no' => $row->PK_NO,'invoice_for' => $invoice_for ]) }}" class="btn btn-xs btn-azura" style="" title="DOWNLOAD COMMERCIAL PDF"><i class="la la-cloud-download"></i> CI</a>
                                                    @endif

                                                    @if(hasAccessAbility('edit_packaging', $roles))
                                                    <a href="{{ route('admin.packaginglist.pdfwithinvoice',['shipment_no' => $row->PK_NO,'invoice_for' => $invoice_for ]) }}" class="btn btn-xs btn-azura" style="" title="DOWNLOAD PACKING PDF WITH INVOICE DETAILS"><i class="la la-cloud-download"></i> PI</a>
                                                    @endif

                                                    @if(hasAccessAbility('edit_packaging', $roles))
                                                    <a href="{{route('admin.packaginglist.pdf',['shipment_no' => $row->PK_NO , 'invoice_for' => $invoice_for, 'price' => 'regular']) }}" class="btn btn-xs btn-azura"  title="DOWNLOAD PDF"><i class="la la-cloud-download"></i>  P</a>
                                                    @endif

                                                    @if($row->SHIPMENT_FOR == 2)
                                                        @if(hasAccessAbility('edit_packaging', $roles))
                                                        <a href="{{route('admin.packaginglist.pdf',['shipment_no' => $row->PK_NO , 'invoice_for' => $invoice_for, 'price' => 'merchant' ]) }}" class="btn btn-xs btn-primary"  title="DOWNLOAD PDF BY USING MERCHANT PRICE"><i class="la la-cloud-download"></i>  P</a>
                                                        @endif
                                                    @endif

                                                </td>
                                            </tr>
                                            @endforeach
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
 <script type="text/javascript" src="{{ asset('assets/pages/shipment.js')}}"></script>
 <script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>

@endpush('custom_js')
