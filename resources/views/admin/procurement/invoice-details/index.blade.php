@extends('admin.layout.master')

@section('invoice','active')
@section('Procurement','open')

@section('title') @lang('invoice_details.list_page_title') @endsection
@section('page-name') @lang('invoice_details.list_page_sub_title') @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('invoice_details.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">@lang('invoice_details.breadcrumb_sub_title')</li>
@endsection

<?php
    $roles                          = userRolePermissionArray();
    $rows                           = $data['rows'] ?? null;
    $invoice                        = $data['invoice'] ?? null;
    $gtotal_qty                     = 0;
    $gtotal_receipt                 = 0;
    $gtotal_flty                    = 0;
    $gtotal_sub_total_gbp_receipt   = 0;
    $gtotal_line_total              = 0;
    $gtotal_line_total_vat_gbp      = 0;
    $gbp_equivalent                 = 0;
    $grec_total                     = 0;
    $grec_total_vat_gbp             = 0;

    // if($invoice->INVOICE_CURRENCY == 'GBP' ){
    // $gbp_equivalent = $invoice->INVOICE_EXACT_VALUE;
    // }elseif($invoice->INVOICE_CURRENCY == 'RM' ){
    // $gbp_equivalent = $invoice->INVOICE_EXACT_VALUE/$invoice->GBP_TO_MR_RATE;
    // }else{
    //     $gbp_equivalent = $invoice->INVOICE_EXACT_VALUE/$invoice->GBP_TO_AC_RATE;
    // }
    $invoice_img =  $invoice->allPhotos ?? array();
    // dd($invoice->user);

?>


@push('custom_css')
    <link rel="stylesheet" href="{{ asset('assets/lightgallery/dist/css/lightgallery.min.css') }}">
@endpush('custom_css')


@section('content')
<div class="content-body min-height">
    <section id="pagination">
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h4 class="card-title mb-1" id="basic-layout-colored-form-control"><i class="ft-eye  text-primary"> </i> Invoice Details</h4>
                        @if(hasAccessAbility('edit_invoice', $roles))
                            <a class="text-white" href="{{ route('admin.invoice.edit',['id' => $invoice->PK_NO, 'invoice_for' => request()->get('invoice_for')]) }}">
                                <button type="button" class="btn btn-round btn-sm btn-primary"><i class="ft-edit text-white"></i> Update Invoice </button>
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
                            <div class="row">
                                 <div class="col-md-3 pb-1">
                                    <h6><b>Invoice No :</b> {{ $invoice->INVOICE_NO }}</h6>
                                    <h6><b>Invoice Date :</b> {{ date('d-m-Y',strtotime($invoice->INVOICE_DATE)) }}</h6>
                                    <h6><b>Entry Date :</b> {{ date('d-m-Y',strtotime($invoice->SS_CREATED_ON)) }}</h6>

                                </div>
                                <div class="col-md-3 pb-1">

                                    <h6><b>Vendor :</b> {{ $invoice->VENDOR_NAME }}</h6>
                                    <h6><b>Primary Discount :</b> {{ $invoice->DISCOUNT_PERCENTAGE }}%</h6>
                                    <h6><b>Secondary Discount :</b> {{ $invoice->DISCOUNT2_PERCENTAGE }}%</h6>
                                    {{-- <h6><b>Payment Source :</b> {{ $invoice->PAYMENT_SOURCE_NAME }}</h6> --}}

                                </div>
                                <div class="col-md-3 pb-1">

                                    <h6><b>Purchase Currency :</b> {{ $invoice->INVOICE_CURRENCY }}</h6>
                                    @if($invoice->F_PARENT_PRC_STOCK_IN > 0)
                                    <h6>
                                        <b>Parent Invoice : {{ $invoice->parentInvoice->INVOICE_NO ?? '' }}</b>
                                    </h6>
                                    @endif
                                    {{-- <h6><b>Payment Account :</b> {{ $invoice->PAYMENT_ACC_NAME }}</h6> --}}
                                    {{-- <h6><b>Payment Method :</b> {{ $invoice->PAYMENT_METHOD_NAME }}</h6> --}}
                                    <h6><b>Entry By :</b>{{ $invoice->user->NAME ?? '' }} - {{ $invoice->user->EMAIL ?? '' }}</h6>
                                </div>
                                <div class="col-md-3 pb-1 text-right">
                                    <h6><b>Invoice Amount </b> ({{$invoice->INVOICE_CURRENCY}}) : {{ number_format($invoice->INVOICE_EXACT_VALUE,2) }}</h6>
                                    <h6 class=""><b>Local Postage BDT :</b>  {{ number_format($invoice->INVOICE_EXACT_POSTAGE,2) }}</h6>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered alt-pagination table-sm" id="indextable" style="font-size: 13px;">
                                    <thead>
                                        <tr>
                                            <th class="">SL.</th>
                                            <th class="" title="Product variant name">Item Name</th>

                                            <th class="" title="Product variant barcode" >Bar Code</th>
                                            <th class="text-center" title="Product received quantity">Rec<br>Qty</th>
                                            @if( Auth::user()->F_MERCHANT_NO == 0 )
                                                <th class="text-center" title="Product faulty quantity">Flt <br>Qty</th>
                                                <th class="text-center" title="">Line Total<br>(Receipt)</th>
                                                <th title="Primary Discount">PD</th>
                                                <th title="Secondary Discount">SD</th>
                                                <th class="text-center" title="Unit price without actual price in GBP">Unit Price <br>W/V</th>
                                                <th class="text-center" title="Unit actual vat in GBP ">Unit <br> Vat </th>
                                                <th class="text-center" title="Unit total quanty">Unit <br> Total </th>
                                            @endif
                                            @if( Auth::user()->F_MERCHANT_NO > 0 )
                                                <th class="text-center" title="Unit total quanty">Unit Price<br></th>
                                            @endif
                                            <th class="text-center" title="Line total quantity">Line<br>Qty</th>
                                            <th class="text-center" title="Line TotalActual GBP" >Line Total </th>
                                            @if( Auth::user()->F_MERCHANT_NO == 0 )
                                                <th class="text-center" title="Line Total Actual Vat GBP">Line Vat</th>
                                                <th class="text-center" title="Received TotalActual GBP">Rec Total</th>
                                                <th class="text-center" title="Received Total Actual Vat GBP">Rec Vat</th>
                                                <th class="text-center" title="Line total actual vat in GBP">Vat</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rows as $row)
                                        <?php
                                        $gtotal_qty                     += $row->QTY;
                                        $gtotal_receipt                 += $row->RECIEVED_QTY;
                                        $gtotal_flty                    += $row->FAULTY_QTY;

                                        if($invoice->INVOICE_CURRENCY == 'RM' ){
                                            $gtotal_sub_total_gbp_receipt   += $row->SUB_TOTAL_MR_RECEIPT;
                                            $gtotal_line_total              += ($row->SUB_TOTAL_MR_EV + $row->LINE_TOTAL_VAT_MR);
                                            $gtotal_line_total_vat_gbp      += $row->LINE_TOTAL_VAT_MR;
                                            $grec_total                     += $row->REC_TOTAL_MR_WITH_VAT;
                                            $tr_left = $row->SUB_TOTAL_MR_RECEIPT;
                                            $tr_right = $row->SUB_TOTAL_MR_EV + $row->LINE_TOTAL_VAT_MR;
                                        }else {
                                            $gtotal_sub_total_gbp_receipt   += $row->SUB_TOTAL_GBP_RECEIPT;
                                            $gtotal_line_total              += ($row->SUB_TOTAL_GBP_EV + $row->LINE_TOTAL_VAT_GBP);
                                            $gtotal_line_total_vat_gbp      += $row->LINE_TOTAL_VAT_GBP;
                                            $grec_total                     += $row->REC_TOTAL_GBP_WITH_VAT;
                                            $tr_left = $row->SUB_TOTAL_GBP_RECEIPT;
                                            $tr_right = $row->SUB_TOTAL_GBP_EV + $row->LINE_TOTAL_VAT_GB;
                                        }
                                        ?>
                                        <tr class="{{ $tr_left != $tr_right ? 'text-warning' : '' }}">
                                            <td>{{$loop->index + 1}}</td>
                                            <td>{{ $row->PRD_VARIANT_NAME }}</td>
                                            <td>{{ $row->BAR_CODE }}</td>
                                            <td class="text-center">{{ $row->RECIEVED_QTY }}</td>
                                            @if( Auth::user()->F_MERCHANT_NO == 0 )
                                                <td class="text-center">{{ $row->FAULTY_QTY }}</td>
                                                <td class="text-right">
                                                    @if($invoice->INVOICE_CURRENCY == 'RM' )
                                                    {{ number_format($row->SUB_TOTAL_MR_RECEIPT,2) }}
                                                    @else
                                                    {{ number_format($row->SUB_TOTAL_GBP_RECEIPT,2) }}
                                                    @endif
                                                </td>
                                                <td>{{ $invoice->DISCOUNT_PERCENTAGE }} %</td>
                                                <td>{{ $invoice->DISCOUNT2_PERCENTAGE }} %</td>

                                                <td class="text-right">
                                                    @if($invoice->INVOICE_CURRENCY == 'RM' )
                                                    {{ number_format($row->UNIT_PRICE_MR_EV,2) }}
                                                    @else
                                                    {{ number_format($row->UNIT_PRICE_GBP_EV,2) }}
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    @if($invoice->INVOICE_CURRENCY == 'RM' )
                                                    {{ number_format($row->UNIT_VAT_RM,2) }}
                                                    @else
                                                    {{ number_format($row->UNIT_VAT_GBP,2) }}
                                                    @endif
                                                </td>
                                            @endif
                                            <td class="text-right">
                                                @if($invoice->INVOICE_CURRENCY == 'RM' )
                                                    @if (Auth::user()->F_MERCHANT_NO > 0)
                                                    {{ number_format(($row->MER_UNIT_PRICE_MR_EV +$row->MER_UNIT_VAT_RM),2) }}
                                                    @else
                                                    {{ number_format(($row->UNIT_PRICE_MR_EV +$row->UNIT_VAT_RM),2) }}
                                                    @endif
                                                @else
                                                    @if (Auth::user()->F_MERCHANT_NO > 0)
                                                    {{ number_format(($row->MER_UNIT_PRICE_GBP_EV +$row->MER_UNIT_VAT_GBP),2) }}
                                                    @else
                                                    {{ number_format(($row->UNIT_PRICE_GBP_EV +$row->UNIT_VAT_GBP),2) }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $row->QTY }}</td>
                                            <td class="text-right">
                                                @if( Auth::user()->F_MERCHANT_NO > 0 )
                                                    @if($invoice->INVOICE_CURRENCY == 'RM' )
                                                        {{ number_format(($row->MER_SUB_TOTAL_MR_EV + $row->MER_LINE_TOTAL_VAT_MR),2) }}
                                                        @else
                                                        {{ number_format(($row->MER_SUB_TOTAL_GBP_EV + $row->MER_LINE_TOTAL_VAT_GBP),2) }}
                                                    @endif
                                                @else
                                                    @if($invoice->INVOICE_CURRENCY == 'RM' )
                                                    {{ number_format(($row->SUB_TOTAL_MR_EV + $row->LINE_TOTAL_VAT_MR),2) }}
                                                    @else
                                                    {{ number_format(($row->SUB_TOTAL_GBP_EV + $row->LINE_TOTAL_VAT_GBP),2) }}
                                                    @endif
                                                @endif
                                            </td>
                                            @if( Auth::user()->F_MERCHANT_NO == 0 )
                                                <td class="text-right">
                                                    @if($invoice->INVOICE_CURRENCY == 'RM' )
                                                    {{ number_format($row->LINE_TOTAL_VAT_MR,2) }}
                                                    @else
                                                    {{ number_format($row->LINE_TOTAL_VAT_GBP,2) }}
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    @if($invoice->INVOICE_CURRENCY == 'RM' )
                                                    {{ number_format($row->REC_TOTAL_MR_WITH_VAT,2) }}
                                                    @else
                                                    {{ number_format($row->REC_TOTAL_GBP_WITH_VAT,2) }}
                                                    @endif
                                                </td>
                                                <td class="text-right">
                                                    @if($invoice->INVOICE_CURRENCY == 'RM' )
                                                    {{ number_format($row->REC_TOTAL_MR_ONLY_VAT,2) }}
                                                    @else
                                                    {{ number_format($row->REC_TOTAL_GBP_ONLY_VAT,2) }}
                                                    @endif
                                                </td>
                                                <td>{{ $row->VAT_RATE }}%</td>
                                            @endif
                                            </tr>
                                            @endforeach()
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2" class="text-center">Total</td>
                                                <td></td>
                                                <td class="text-center">{{$gtotal_receipt}}</td>
                                                <td class="text-center">{{$gtotal_flty}}</td>
                                                @if( Auth::user()->F_MERCHANT_NO == 0 )
                                                <td class="text-right">{{number_format($gtotal_sub_total_gbp_receipt,2)}}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                @endif
                                                <td class="text-center">{{$gtotal_qty}}</td>
                                                <td class="text-right">
                                                    <span class="text-danger">{{number_format($gtotal_line_total,2)}}</span>
                                                </td>
                                                @if( Auth::user()->F_MERCHANT_NO == 0 )
                                                <td class="text-right"><span class="text-danger">{{number_format($gtotal_line_total_vat_gbp,2)}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-success">{{number_format($grec_total,2)}}</span>
                                                </td>
                                                <td>
                                                     <span class="text-success">{{number_format($grec_total_vat_gbp,2)}}</span>
                                                </td>
                                                <td></td>
                                                @endif
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                @if($invoice->DESCRIPTION)
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3><u>Notes</u></h3>
                                        <div>{{$invoice->DESCRIPTION}}</div>
                                    </div>
                                </div>
                                @endif
                                @if( Auth::user()->F_MERCHANT_NO == 0  ||  (Auth::user()->F_MERCHANT_NO > 0 && $invoice->INVOICE_PHOTO_SHOW_MERCHANT == 1) )
                                @if(!empty($invoice_img))
                                <br>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div>
                                            <h4 class="mb-2"><u>Invoice Photo</u></h4>
                                            <div id="aniimated-thumbnials">
                                                @foreach($invoice_img as $key => $inv_img)
                                                @if(strtolower($inv_img->FILE_EXT) != 'pdf')

                                                <a href="{{$inv_img->RELATIVE_PATH}}" >
                                                    <img src="{{asset($inv_img->RELATIVE_PATH)}}" class=" mr-1 mb-1" style="max-width: 200px;" />
                                                </a>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <div>
                                            @php $i = 1 @endphp
                                            @foreach($invoice_img as $key => $inv_img)
                                            @if(strtolower($inv_img->FILE_EXT) == 'pdf')
                                            <a href="{{asset($inv_img->RELATIVE_PATH)}}" target="_blank">Show PDF ({{$i}})</a> ,&nbsp;

                                             @php $i++ @endphp
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endsection
    @push('custom_js')
        <script src="{{ asset('assets/lightgallery/dist/js/lightgallery.min.js')}}"></script>
        <script type="text/javascript">
            $("#aniimated-thumbnials").lightGallery({
                    thumbnail:true,
                });
        </script>
    @endpush('custom_js')

