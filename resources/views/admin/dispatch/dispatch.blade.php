@extends('admin.layout.master')

@section('Dispatch Management','open')
@section('list_dispatch','active')

@section('title') Order | Dispatch @endsection
@section('page-name') Dispatch Order @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('order.breadcrumb_title') </a></li>
    <li class="breadcrumb-item active">dispatch</li>
@endsection

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/pickers/daterange/daterange.css')}}">
<link rel="stylesheet" href="{{ asset('assets/lightgallery/dist/css/lightgallery.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/extensions/toastr.css')}}">
<style>
    #scrollable-dropdown-menu .tt-menu { max-height: 260px; overflow-y: auto; width: 100%;border: 1px solid #333;border-radius: 5px;}
    .twitter-typeahead{display: block !important;}
    address h6, .label1{font-weight: 400;line-height: 1;color: #081510;font-size: 14px;}
    .label2{font-weight: 600;line-height: 1.1;font-size: 16px;color: #444;}
    #process_data_table td{vertical-align: middle;}
    .must_note {margin: 10px 0;background-color: #609883;font-style: italic;padding: 10PX;color: #fff;font-weight: 600;font-size: 14px;display: block;cursor: pointer;}
    table.opt_tbl>tbody>tr>td{font-size: 14px !important;}
    .opt_tbl{margin-bottom: 0px !important;}
    .opt_tbl td input[type="radio"]{cursor: pointer;}
</style>
@endpush('custom_css')

@section('content')

<?php
    $roles = userRolePermissionArray();

    $booking                = $data['booking'];
    $order                  = $data['booking']->getOrder;
    $booking_details        = $data['booking']->booking_details;
    $booking_details_returned   = $data['booking']->booking_details_returned;
    $return_request         = $data['return_request'] ?? null;
    $order_content_types    = Config::get('static_array.order_content_types') ?? array();
    $get_parcel_sizes       = Config::get('static_array.get_parcel_sizes') ?? array();
    $return_condition       = Config::get('static_array.return_condition') ?? array();
    $consignment            = $order->consignment ?? [];
    $due                    = ($booking->TOTAL_PRICE - $booking->DISCOUNT) ?? 0 - $order->ORDER_BUFFER_TOPUP;
?>

@if($booking->DISPATCH_STATUS != 40)

<div class="row">
    <div class="col-md-12">
        <div class="alert bg-danger alert-dismissible mb-2 text-center" role="alert">
            @if($due > 0 )
            <strong>Payment Due! </strong> Please collect TK {{ number_format($due,2) }} before handover.
            @else
            <strong>RTC! </strong> Please handover the order to the customer.
            @endif
        </div>
    </div>
</div>

@endif

@if( isset($order->DISPATCH_STATUS) && (($order->DISPATCH_STATUS == 40) || ($order->DISPATCH_STATUS == 35) || ($order->IS_ADMIN_HOLD == 1)))
<div class="card card-success ">
    <div class="card-header pb-0">
        <div class="row">
            <div class="col-md-12">
                @if($order->DISPATCH_STATUS >= 35)
                    <div class="alert bg-danger mb-2 text-center" role="alert" style="background: linear-gradient(to right, #2193b0 0%, #6dd5ed 100%);">
                        <div class="row" style="">
                        <div class="col-md-12" style="">
                        <h4 style="color:#fff;"><i class="icon la la-ban"></i> Alert!</h4>
                        @if (isset($order->dispatch[0]) && $order->dispatch[0]->IS_DISPATHED == 0)
                        <span style="font-size: 16px;">This order has been scheduled for App <strong>Dispatch @if( $order->DISPATCH_STATUS == 35) (Partial) @endif </strong>.</span>
                        @else
                        <span style="font-size: 16px;">This order has <strong>Dispatched @if( $order->DISPATCH_STATUS == 35) (Partial) @endif @if (isset($order->dispatch[0]) && $order->dispatch[0]->IS_DISPATHED == 2) (Partial) @endif</strong>.</span>
                        @endif
                        <hr style="margin-bottom: 5px; border-top:2px soild #f2dade;">
                        </div>
                        </div>
                            <div class="row" style="">
                                @if($order->dispatch && count($order->dispatch) > 0 )
                                @foreach($order->dispatch as $k => $dispatch)
                                <div class="col-md-6" style="text-align: left;">
                                    <p style="margin-bottom: 2px;">Dispatch By : <strong class="text-uppercase">{{ $dispatch->DISPATCH_USER_NAME }}</strong></p>
                                    <p style="margin-bottom: 2px;">Dispatch Qty : <strong>{{ $dispatch->allChild->count() ?? 0 }}</strong></p>
                                    <p style="margin-bottom: 2px;">Dispatch At : <strong>{{ date('M d,Y',strtotime($dispatch->DISPATCH_DATE)) }}</strong></p>
                                    <p style="margin-bottom: 2px;">Tracking No./Collect By : <strong>{{ $dispatch->COURIER_TRACKING_NO }}</strong></p>
                                    <p style="margin-bottom: 2px; ">Carrier : <a href="{{ $dispatch->courier->URLS ?? '' }}" target="_blank" class="link" style="color: #ebf21e;">{{ $dispatch->COURIER_NAME }}</a></p>

                                </div>
                                @endforeach
                                @endif
                            </div>
                    </div>
                @endif

                @if($order->IS_ADMIN_HOLD == 1)
                    <div class="alert bg-danger alert-dismissible mb-2 text-center" role="alert">
                        <strong>Hold! </strong> Order has been hold by admin.
                    </div>
                @endif



            </div>
        </div>
    </div>
</div>
@endif


{!! Form::open([ 'route' => ['admin.order.dispatchstore','id' => $booking->PK_NO], 'method' => 'post', 'id' => 'form_post25', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}

<input type="hidden" name="booking_no" id="booking_no" value="{{ $data['booking']->PK_NO }}" />

    <div class="card">
        <div class="card-content collapse show">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>
                                         <h3><span class="label1">Customer : </span> <span class="label2">{{ $booking->DELIVERY_NAME }}</span></h3>
                                    </td>
                                    <td><h3><span class="label1">Entry By : </span>  <span class="label2"></span> </h3></td>
                                    <td><h3><span class="label1">Order ID : </span>  <span class="label2">ORD-{{ $booking->BOOKING_NO }}</span> </h3></td>
                                </tr>
                                <tr>
                                    <td><h3><span class="label1">Sales Agent : </span>  <span class="label2">{{ $booking->SHOP_NAME }}</span> </h3></td>
                                    <td><h3><span class="label1">Entry At : </span><span class="label2">{{ date('d-m-Y h:i A',strtotime($booking->BOOKING_TIME)) }}</span> </h3></td>
                                    <td><h3><span class="label1">Order Date : </span>  <span class="label2">{{ date('d-m-Y',strtotime($booking->CONFIRM_TIME)) }}</span> </h3></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-sm-6">
                        <address>
                            <h4 class=""><u>Send To : </u></h4>
                            <h5 class="label2">{{  $booking->DELIVERY_NAME ?? '' }}</h5>
                            @if($booking->DELIVERY_ADDRESS_LINE_1)
                                <h6>{{ $booking->DELIVERY_ADDRESS_LINE_1 }}</h6>
                            @endif
                            @if($booking->DELIVERY_ADDRESS_LINE_2)
                                <h6>{{ $booking->DELIVERY_ADDRESS_LINE_2 }}</h6>
                            @endif
                            @if($booking->DELIVERY_ADDRESS_LINE_3)
                                <h6>{{ $booking->DELIVERY_ADDRESS_LINE_3 }}</h6>
                            @endif
                            @if($booking->DELIVERY_ADDRESS_LINE_4)
                                <h6>{{ $booking->DELIVERY_ADDRESS_LINE_4 }}</h6>
                            @endif
                            @if($booking->DELIVERY_STATE)
                                <h6>{{ $booking->DELIVERY_STATE }}</h6>
                            @endif

                            @if($booking->DELIVERY_CITY)
                                <h6>{{ $booking->DELIVERY_CITY}}@if($booking->DELIVERY_POSTCODE)<span>, {{ $booking->DELIVERY_POSTCODE }}</span> @endif </h6>
                            @endif
                            @if($booking->DELIVERY_COUNTRY)
                                <h6>{{ $booking->DELIVERY_COUNTRY }}</h6>
                            @endif
                            @if($booking->DELIVERY_MOBILE)
                            <h6><b>Phone : {{ $booking->DELIVERY_MOBILE }}</b></h6>
                            @endif
                        </address>
                    </div>
                </div>
                <hr/>

                <br>     <div class="row">
                            <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-sm " id="process_data_table">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th class="text-center">Status</th>
                                            <th style="width:50px;" class="text-center">Dispatch Qty</th>
                                            <th class="text-center" style="width:120px;">Unit Price</th>
                                            <th class="text-center" style="width:120px;">Total Price</th>
                                            

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(isset($booking_details) && count($booking_details))
                                            @foreach($booking_details as $key => $row )
                                                <?php
                                        $variant_photos =  $row->stock->productVariant->allVariantPhotos ?? array();
                                        $unit_price  = $row->CURRENT_IS_REGULAR == 1 ? $row->CURRENT_REGULAR_PRICE  : $row->CURRENT_INSTALLMENT_PRICE;
                                        $unit_postage_cost = $row->CURRENT_IS_SM == 1 ? $row->CURRENT_SM_COST  : $row->CURRENT_SS_COST;
                                        $unit_freight_cost = $row->CURRENT_IS_FREIGHT == 1 ? $row->CURRENT_AIR_FREIGHT  : $row->CURRENT_SEA_FREIGHT;
                                        $unit_total_price = $unit_price + $unit_postage_cost + $unit_freight_cost;
                                                ?>

                                                <tr class="{{ $row->IS_READY == 0 ? 'bg-success' : '' }}">
                                                    <td >{{  $key+1 }} </td>
                                                    <td class="text-center img_td" style="width: 150px;">
                                                        @php $img_count = 0; @endphp
                                                        @if($variant_photos && count($variant_photos) > 0)
                                                        <div class="lightgallery" style="margin:0px  auto; text-align: center; ">
                                                            @php $img_count = count($variant_photos); @endphp
                                                            @for($i = 0; $i < $img_count; $i++ )
                                                            @php $vphoto = $variant_photos[$i]; @endphp
                                                            <a class="img_popup " href="{{ asset($vphoto->RELATIVE_PATH)}}" style="{{ $i>0 ? 'display: none' : ''}}" title="{{$row->VARIANT_NAME}}"><img style="width: 80px !important; height: 80px;" data-src="{{ asset($vphoto->RELATIVE_PATH)}}" alt="{{$row->VARIANT_NAME}}" src="{{asset($vphoto->THUMB_PATH)}}" class="unveil"></a>
                                                            @endfor
                                                        </div>


                                                        @endif
                                                        <span class="badge badge-pill badge-primary badge-square img_c" title="Total {{$img_count}} photos for the product">{{$img_count}}</span>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <p>Name : <a href="#" target="_blank"></a></p>
                                                            <p>Color : {{ $row->COLOR_NAME }} </p>
                                                            <p>Size : {{ $row->SIZE_NAME }}</p>
                                                            <p>IG Code : {{ $row->IG_CODE }}</p>
                                                            <p>Barcode : {{ $row->BARCODE }}</p>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $row->RTS_COLLECTION_USER_ID != 0 && $row->IS_COLLECTED_FOR_RTS == 0 ? 'Not Collected' : '' }}
                                                        <br>
                                                        {{ $row->IS_READY == 1 ? 'Ready' : 'Not Ready' }}
                                                    </td>
                                                    <td style="width:50px;" class="text-center">
                                                        <input type="hidden" value="{{ $row->PK_NO }}" @if($row->DISPATCH_STATUS < 40) name="booking_details_no[]" @endif  />
                                                        @if($row->DISPATCH_STATUS == 40)
                                                        1
                                                        @else
                                                        <input name="dispatch_qty[]" type="number"  class="form-control max_val_check " value="{{ $row->IS_READY == 1 ? 1 : 0 }}" max="1" required/>
                                                        @endif

                                                    </td>


                                                    <td class="text-right" style="width:120px;">
                                                        {{ number_format($unit_price,2) }}
                                                    </td>
                                                    <td class="text-right" style="width:120px;">

                                                        {{ number_format($row->LINE_PRICE,2) }}
                                                    </td>
                                                    <td style="width:150px;">
                                                        <select name="consignment_note[]" id="consignment_note" class="form-control"  @if($row->DISPATCH_STATUS == 40) disabled @endif>
                                                        @if(!empty($consignment))
                                                         @foreach($consignment as $coninfo)
                                                        <option value="{{ $coninfo->PK_NO }}" {{ isset($row->consignment->COURIER_TRACKING_NO) && $row->consignment->COURIER_TRACKING_NO == $coninfo->COURIER_TRACKING_NO ? 'selected' : '' }} >{{ $coninfo->COURIER_TRACKING_NO }}</option>
                                                        @endforeach
                                                        @endif
                                                        </select>
                                                    </td>
                                                    <td class="text-center">

                                                            @if(isset($booking_details_returned) && count($booking_details_returned))
                                                                @foreach($booking_details_returned as $key3 => $row3 )
                                                                    @if($row3->PK_NO == $row->PK_NO)
                                                                        <button type="button" class="btn btn-danger" title="{{ $return_condition[$row3->RETURN_TYPE] ?? null }}" >Returned</button>
                                                                    @else
                                                                    <button type="button" class="btn btn-info return_show_modal" data-toggle="modal" data-target="#returnModal" data-booking_child="{{ $row->PK_NO }}" data-paid_amount="{{ $row->LINE_PRICE }}"> Return</button>
                                                                    @endif
                                                                @endforeach
                                                            @else

                                                                @if(isset($return_request) && count($return_request) > 0 )
                                                                    @foreach ($return_request as $key4 => $row4)

                                                                        @if($row4->F_BOOKING_DETAILS_NO == $row->PK_NO )
                                                                            <button type="button" class="btn btn-info return_show_modal" data-toggle="modal" data-target="#returnModal" data-booking_child="{{ $row->PK_NO }}" data-paid_amount="{{ $row->LINE_PRICE }}" data-return_request="1" data-condition="{{ $row4->RETURN_CONDITION }}" data-note="{{ $row4->RETURN_NOTE }}" data-postage="{{ $row4->POSTAGE_AMT }}" data-credit_amount="{{ $row4->CREDIT_AMT }}" data-request_id="{{ $row4->PK_NO }}" data-photo_path="{{ $row4->PHOTO_PATH ? asset($row4->PHOTO_PATH) : null }}" >Return Request</button>
                                                                        @else
                                                                            <button type="button" class="btn btn-info return_show_modal" data-toggle="modal" data-target="#returnModal" data-booking_child="{{ $row->PK_NO }}" data-paid_amount="{{ $row->LINE_PRICE }}"> Return</button>

                                                                        @endif
                                                                    @endforeach
                                                                @else
                                                                    <button type="button" class="btn btn-info return_show_modal" data-toggle="modal" data-target="#returnModal" data-booking_child="{{ $row->PK_NO }}" data-paid_amount="{{ $row->LINE_PRICE }}">Return </button>

                                                                @endif
                                                            @endif

                                                    </td>
                                                </tr>

                                            @endforeach
                                        @endif

                                        {{-- For Returned Item --}}
                                        @if(isset($booking_details_returned) && count($booking_details_returned))
                                            @foreach($booking_details_returned as $key2 => $row2 )
                                            @if($row2->RETURN_TYPE != 3 )

                                                <?php
            $variant_photos =  $row2->stock->productVariant->allVariantPhotos ?? array();
            $unit_price  = $row2->CURRENT_IS_REGULAR == 1 ? $row2->CURRENT_REGULAR_PRICE  : $row2->CURRENT_INSTALLMENT_PRICE;
            $unit_postage_cost = $row2->CURRENT_IS_SM == 1 ? $row2->CURRENT_SM_COST  : $row2->CURRENT_SS_COST;
            $unit_freight_cost = $row2->CURRENT_IS_FREIGHT == 1 ? $row2->CURRENT_AIR_FREIGHT  : $row2->CURRENT_SEA_FREIGHT;
            $unit_total_price = $unit_price + $unit_postage_cost + $unit_freight_cost;
                                                ?>

                                                <tr class="{{ $row2->IS_READY == 0 ? 'bg-success' : '' }}">
                                                    <td >{{  $key2+1 }} </td>
                                                    <td class="text-center img_td" style="width: 150px;">
                                                        @php $img_count = 0; @endphp
                                                        @if($variant_photos && count($variant_photos) > 0)
                                                        <div class="lightgallery" style="margin:0px  auto; text-align: center; ">
                                                            @php $img_count = count($variant_photos); @endphp
                                                            @for($i = 0; $i < $img_count; $i++ )
                                                            @php $vphoto = $variant_photos[$i]; @endphp
                                                            <a class="img_popup " href="{{ asset($vphoto->RELATIVE_PATH)}}" style="{{ $i>0 ? 'display: none' : ''}}" title="{{$row2->VARIANT_NAME}}"><img style="width: 80px !important; height: 80px;" data-src="{{ asset($vphoto->RELATIVE_PATH)}}" alt="{{$row2->VARIANT_NAME}}" src="{{asset($vphoto->RELATIVE_PATH)}}" class="unveil"></a>
                                                            @endfor
                                                        </div>


                                                        @endif
                                                        <span class="badge badge-pill badge-primary badge-square img_c" title="Total {{$img_count}} photos for the product">{{$img_count}}</span>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <p>Name : <a href="{{ route('admin.product.view',[ 'id' => $row2->stock->productVariant->F_PRD_MASTER_SETUP_NO ?? '' ]) }}?type =variant&variant_id={{ $row2->stock->F_PRD_VARIANT_NO }}&tab=2 " target="_blank"> {{ $row2->stock->PRD_VARINAT_NAME }}</a></p>
                                                            <p>Color : {{ $row2->stock->productVariant->COLOR }} </p>
                                                            <p>Size : {{ $row2->stock->productVariant->SIZE_NAME }}</p>
                                                            <p>IG Code : {{ $row2->stock->IG_CODE }}</p>
                                                            <p>Barcode : {{ $row2->stock->BARCODE }}</p>

                                                        </div>

                                                    </td>
                                                    <td class="text-center">
                                                        {{ $row2->RTS_COLLECTION_USER_ID != 0 && $row2->IS_COLLECTED_FOR_RTS == 0 ? 'Not Collected' : '' }}
                                                        <br>
                                                        {{ $row2->IS_READY == 1 ? 'Ready' : 'Not Ready' }}
                                                    </td>
                                                    <td style="width:50px;" class="text-center">
                                                        <input type="hidden" value="{{ $row2->PK_NO }}" name="booking_details_no[]"  />
                                                       
                                                        <input name="dispatch_qty[]" type="number"  class="form-control max_val_check " value="{{ $row2->IS_READY == 1 ? 1 : 0 }}" max="1" required/>

                                                    </td>


                                                    <td class="text-right" style="width:120px;">
                                                        {{ number_format($unit_price,2) }}
                                                    </td>
                                                    <td class="text-right" style="width:120px;">

                                                        {{ number_format($row2->LINE_PRICE,2) }}
                                                    </td>
                                                    @if( $order->IS_SELF_PICKUP == 0 )
                                                    <td style="width:150px;">
                                                        <select name="consignment_note[]" id="consignment_note" class="form-control">
                                                            @if(!empty($consignment))
                                                                @foreach($consignment as $coninfo)
                                                                    <option value="{{ $coninfo->PK_NO }}" {{ isset($row2->consignment->COURIER_TRACKING_NO) && $row2->consignment->COURIER_TRACKING_NO == $coninfo->COURIER_TRACKING_NO ? 'selected' : '' }}>{{ $coninfo->COURIER_TRACKING_NO }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    @endif
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger" title="{{ $return_condition[$row2->RETURN_TYPE] ?? null }}" >Returned</button>
                                                    </td>


                                                </tr>
                                                @endif
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>

                        @if(!empty($consignment))
                            @foreach($consignment as $coninfo)
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="courier">Select courier</label>
                                            <div class="controls">
                                            <select class="form-control" disabled name="courier">
                                                <option value="">-Select One-</option>
                                                @if(isset($data['courier']) && count($data['courier']) > 0 )
                                                    @foreach($data['courier'] as $key => $val)
                                                        @if($val->PK_NO != 0)
                                                            <option @if($coninfo->F_COURIER_NO ==$val->PK_NO) {{ 'selected' }}@endif value="{{ $val->PK_NO }}">{{ $val->COURIER_NAME }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('consignment_note') ? 'error' : '' !!}">
                                            <label>Consignment Note<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::text(NULL, $coninfo->COURIER_TRACKING_NO ?? '', [ 'class' => 'form-control mb-1 ', 'placeholder' => 'ENTER COURIER_TRACKING_NO', 'tabindex' => 3,'readonly'=>true ]) !!}
                                            </div>
                                        </div>
                                    </div>

                                    @if(!empty($coninfo->SHIPMENT_KEY))
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('shipment_key') ? 'error' : '' !!}">
                                            <label>Shipment Key</label>
                                            <div class="controls">
                                                {!! Form::text(NULL, $coninfo->SHIPMENT_KEY, [ 'class' => 'form-control mb-1 ', 'placeholder' => '', 'tabindex' => 3,'readonly','id'=>'shipment_key' ]) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group {!! $errors->has('postage_cost') ? 'error' : '' !!}">
                                            <label>SHIPMENT COST</label>
                                            <div class="controls">
                                                {!! Form::text(NULL, $coninfo->POSTAGE_COST ?? '', [ 'class' => 'form-control mb-1 ', 'placeholder' => 'SHIPMENT COST', 'tabindex' => 3,'readonly','id'=>'postage_cost' ]) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 pt-2">
                                        @if(!empty($coninfo->COURIER_TRACKING_NO))
                                        <a target="_blank" href="{{ $POSLAJU_GET_PDF }}{{ $coninfo->COURIER_TRACKING_NO ?? '' }}" type="button"  class="btn btn-success btn-sm" title="PRINT CONSIGNMENT NOTE">
                                            <i class="la la-print"></i></a>
                                        @endif
                                        <button type="button" data-id="{{ $coninfo->PK_NO }}" class="btn btn-primary btn-sm retry" title="RETRY"> <i class="la la-refresh"></i></button>
                                    </div>
                                @endif

                                @if(!empty($coninfo->F_COURIER_NO==12))
                                <div class="col-md-2 pt-2">
                                    <a target="_blank" href="{{ asset($coninfo->CONSIGNMENT_LINK) }}" type="button"  class="btn btn-success btn-sm" title="PRINT CONSIGNMENT NOTE"><i class="la la-print"></i></a>
                                    <a target="_blank" href="{{route('admin.citylink.consignment.get_trucking',['id'=>$coninfo->COURIER_TRACKING_NO])  }}" type="button"  class="btn btn-success btn-sm" title="Truck Shipment"><i class="la la-truck"></i></a>
                                </div>
                                @endif

                            </div>
                            @endforeach
                        @endif

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('dispatch_date') ? 'error' : '' !!}">
                                        <label>Dispatch Date<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            {!! Form::text('dispatch_date', date('d-m-Y'), [ 'class' => 'form-control mb-1 pickadate', 'placeholder' => 'Enter dispatch date', 'tabindex' => 2, 'data-validation-required-message' => 'This field is required', ]) !!}
                                            {!! $errors->first('dispatch_date', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>

                                    </div>
                            </div>
                            @if (request()->get('type') != 'rts')
                            <div class="col-md-4">
                                <div class="form-group {!! $errors->has('collected_by') ? 'error' : '' !!}">
                                    <label>Collected By<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::text('collected_by', null, [ 'class' => 'form-control mb-1 ', 'placeholder' => 'Enter collected by', 'tabindex' => 3, 'data-validation-required-message' => 'This field is required', ]) !!}
                                        {!! $errors->first('collected_by', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        @if($booking->BOOKING_NOTES)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="m_note_agree">
                                    <label>Special Note</label>
                                    <div class="controls">
                                        {!! Form::textarea('booking_note', $booking->BOOKING_NOTES, [ 'class' => 'form-control mb-1 summernote', 'tabindex' => 16, 'rows' => 3,'style'=>'color: #D70022;', 'disabled' ]) !!}
                                        {!! $errors->first('booking_note', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                    <label class="must_note">
                                        <input type="checkbox" name="m_note" class="m_note" data-validation-required-message="This field is required" required>&nbsp;I Read The Special Note</label>
                                <span class="err err-m_note"></span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                        <div class="form-actions mt-10 text-center">
                            <a href="{{ route('admin.dispatch.list',['dispatch=rts'])}}" class="btn btn-warning mr-1"><i class="ft-x"></i> @lang('order.order_frm_button_cancel_label')</a>





                        </div>
                        </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <div class="modal fade text-left" id="collect_cod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open([ 'route' => 'admin.payment.store', 'method' => 'post', 'class' => 'form-horizontal paymentEntryFrm', 'files'
                => true , 'novalidate']) !!}

                  <input type="hidden" name="payfrom" value="cod" />
                  <input type="hidden" name="order_id" value="{{ $booking->PK_NO }}" />

                  @if($booking->IS_RESELLER == 1)
                  <input type="hidden" name="customer_id" value="{{ $booking->getReseller->PK_NO }}" />
                  <input type="hidden" name="customer" value="{{ $booking->RESHOP_NAME }}" />
                  <input type="hidden" name="type" value="reseller" />
                  @else
                  <input type="hidden" name="customer_id" value="{{ $booking->getCustomer->PK_NO }}" />
                  <input type="hidden" name="customer" value="{{ $booking->CUSTOMER_NAME }}" />
                  <input type="hidden" name="type" value="customer" />
                  @endif

                <div class="modal-header text-center" style="background-color:#6b66c6; color: #fff; ">
                    <h4 class="modal-title text-center" id="myModalLabel1" style=" color: #fff; ">Collect COD Payment</h4>

                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                    <div class="form-group {!! $errors->has('payment_acc_no') ? 'error' : '' !!}">
                        <label>Payment Account<span class="text-danger">*</span></label>
                        <div class="controls">
                            <select class="form-control" name="payment_acc_no" id="payment_acc_no" data-validation-required-message="This field is required" tabindex="4">
                                <option value="">--select bank--</option>
                                @if(isset($data['payment_acc_no']) && count($data['payment_acc_no']) > 0 )
                                    @foreach($data['payment_acc_no'] as $k => $bank)
                                        @if( ($bank->IS_COD == 1) && (Auth::user()->PK_NO == $bank->F_USER_NO))
                                        {{-- @if( ($bank->IS_COD == 1) && (Auth::user()->F_AGENT_NO == 0)) --}}
                                            <option value="{{ $bank->PK_NO }}" >{{ $bank->BANK_NAME .' ('.$bank->BANK_ACC_NAME.') ('.$bank->BANK_ACC_NO.')' }}</option>
                                        @endif
                                    @endforeach
                                @endif

                            </select>

                            {!! $errors->first('payment_acc_no', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('payment_date') ? 'error' : '' !!}">
                            <label>Payment Date<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <span class="la la-calendar-o"></span>
                                        </span>
                                    </div>
                                    <input type='text' class="form-control pickadate datepicker" placeholder="Invoice Date"
                                        value="{{date('d-m-Y')}}" name="payment_date" id="payment_date" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group {!! $errors->has('payment_amount') ? 'error' : '' !!}">
                                <label>Payment Amount (RM)<span class="text-danger">*</span></label>
                                <div class="controls">
                                    {!! Form::number('payment_amount', $due,[ 'class' => 'form-control mb-1',
                                    'data-validation-required-message' => 'This field is required','placeholder' => 'Payment Amount (RM)', 'tabindex' => 6 ,'min' => 0, 'id' => 'payment_amount', 'step' => '0.0001',  'readonly']) !!}
                                    {!! $errors->first('payment_amount', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group {!! $errors->has('ref_number') ? 'error' : '' !!}">
                                <label>Ref. Number/Slip Number<span class="text-danger">*</span></label>
                                <div class="controls">
                                    {!! Form::text('ref_number', 'CASH-'.$booking->BOOKING_NO,[ 'class' => 'form-control mb-1',
                                    'data-validation-required-message' => 'This field is required','placeholder' => 'Ref. Number/Slip Number', 'tabindex' => 7 , 'id' => 'ref_number', 'readonly']) !!}
                                    {!! $errors->first('ref_number', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group {!! $errors->has('payment_note') ? 'error' : '' !!}">
                                <label>Customer Note</label>
                                <div class="controls">
                                    {!! Form::text('payment_note', null,[ 'class' => 'form-control mb-1', 'placeholder' =>
                                    'Paymet Note', 'tabindex' => 9, 'payment_note', 'id' => 'payment_note']) !!}
                                    {!! $errors->first('payment_note', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Save changes</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    

    {{-- Return modal --}}
    <div class="modal fade text-left" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"  aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content ">
                {!! Form::open([ 'route' => ['admin.order.return','id' => $booking->PK_NO], 'class' => 'form-horizontal', 'files' => true , 'novalidate','id' => 'returnFrm']) !!}
                    <input type="hidden" id="booking_id" name="booking_id" value="{{ $booking->PK_NO }}" />
                    <input type="hidden" id="booking_details_id" name="booking_details_id" value="" />
                    <input type="hidden" id="request_id" name="request_id" value="" />
                <div class="modal-header text-center" style="background-color:#6b66c6; color: #fff; ">
                    <h4 class="modal-title text-center" id="myModalLabel1" style=" color: #fff; ">Return</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th colspan="2" class="text-center">Details</th>
                                <th>
                                    <table class="table opt_tbl">
                                        <tr>
                                            <td style="width: 20%" class="text-center">Action</td>
                                            <td style="width: 20%" class="text-center">Sales Commission</td>
                                            <td style="width: 20%" class="text-center">Stock</td>
                                            <td style="width: 15%" class="text-center">Postage</td>
                                            <td style="width: 25%" class="text-center">Action</td>
                                        </tr>
                                    </table>
                                </th>
                            </tr>
                            <tr>
                                <td><strong>Partial Damage</strong></td>
                                 <td><strong>Sellable</strong></td>
                                 <td>
                                    <table class="table opt_tbl">
                                        <tr>
                                            <td style="width: 20%">Partial discount to customer</td>
                                            <td style="width: 20%">N/A</td>
                                            <td style="width: 20%">N/A</td>
                                            <td style="width: 15%">N/A</td>
                                            <td style="width: 20%">Refund discount amount</td>
                                            <td style="width: 5%" class="text-center"><input type="radio" class="return_type" name="stock_condition" value="5" />(5)</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%">Return</td>
                                            <td style="width: 20%">Revert Sales commission</td>
                                            <td style="width: 20%">Return to stock</td>
                                            <td style="width: 15%">Return postage</td>
                                            <td style="width: 20%">Full refund + postage</td>
                                            <td style="width: 5%" class="text-center"><input type="radio" class="return_type" name="stock_condition" value="2" />(2)</td>
                                        </tr>
                                    </table>
                                 </td>
                            </tr>
                            <tr>
                                <td> <strong>Damage</strong></td>
                                 <td><strong>Non Sellable</strong></td>
                                 <td>
                                    <table class="table opt_tbl">
                                        <tr>
                                            <td style="width: 20%">Customer will dispose</td>
                                            <td style="width: 20%">Revert sales commission</td>
                                            <td style="width: 20%">N/A</td>
                                            <td style="width: 15%">N/A</td>
                                            <td style="width: 20%">Refund full</td>
                                            <td style="width: 5%" class="text-center"><input type="radio" class="return_type" name="stock_condition" value="3" />(3)</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%">Return</td>
                                            <td style="width: 20%">Revert Sales commission</td>
                                            <td style="width: 20%">N/A</td>
                                            <td style="width: 15%">Return postage</td>
                                            <td style="width: 20%">Full refund + postage</td>
                                            <td style="width: 5%" class="text-center"><input type="radio" class="return_type" name="stock_condition" value="6" />(6)</td>
                                        </tr>
                                    </table>
                                 </td>
                            </tr>
                            <tr>
                                <td><strong>Good</strong></td>
                                 <td><strong>Sellable</strong></td>
                                 <td>
                                    <table class="table opt_tbl">
                                        <tr>
                                            <td style="width: 20%">Return (wrong item sent)</td>
                                            <td style="width: 20%">Revert Sales commission</td>
                                            <td style="width: 20%">Return to stock</td>
                                            <td style="width: 15%">Return postage</td>
                                            <td style="width: 20%">Full refund + postage</td>
                                            <td style="width: 5%" class="text-center"><input type="radio" class="return_type" name="stock_condition" value="1" />(1)</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 20%">Return (Change mind)</td>
                                            <td style="width: 20%">N/A </td>
                                            <td style="width: 20%">Return to stock</td>
                                            <td style="width: 15%">N/A</td>
                                            <td style="width: 20%">Partial refund penalty</td>
                                            <td style="width: 5%" class="text-center"><input type="radio" class="return_type" name="stock_condition" value="4" />(4)</td>
                                        </tr>
                                    </table>
                                 </td>
                            </tr>
                        </tbody>
                      </table>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group {!! $errors->has('return_date') ? 'error' : '' !!}">
                                <label>Return Date<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <span class="la la-calendar-o"></span>
                                            </span>
                                        </div>
                                        <input type='text' class="form-control pickadate datepicker" placeholder="Return Date"
                                            value="{{date('d-m-Y')}}" name="return_date" id="return_date" tabindex="2" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {!! $errors->has('paid_amount') ? 'error' : '' !!}">
                                    <label>Paid Amount<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::number('paid_amount', 0,[ 'class' => 'form-control mb-1', 'placeholder' => 'Paid Amount (RM)', 'tabindex' => 3 ,'min' => 0, 'id' => 'paid_amount', 'step' => '0.0001',  'readonly']) !!}
                                        {!! $errors->first('paid_amount', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 credit_amount_div">
                                <div class="form-group {!! $errors->has('credit_amount') ? 'error' : '' !!}">
                                    <label id="credit_amount_lbl">Amount to be Credit<span class="text-danger">*</span></label>
                                    <div class="controls">
                                        {!! Form::number('credit_amount', 0,[ 'class' => 'form-control mb-1', 'placeholder' => '', 'tabindex' => 4 ,'min' => 0, 'id' => 'credit_amount', 'step' => '0.0001', 'required']) !!}
                                        {!! $errors->first('credit_amount', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 discount_div ">
                                <div class="form-group {!! $errors->has('discount_amount') ? 'error' : '' !!}">
                                    <label id="discount_amount_lbl">Return Fee/Panelty</label><span class="text-danger">*</span>
                                    <div class="controls">
                                        {!! Form::number('discount_amount','',[ 'class' => 'form-control mb-1', 'placeholder' => '', 'tabindex' => 5 ,'min' => 0, 'id' => 'discount_amount', 'step' => '0.0001','required']) !!}
                                        {!! $errors->first('discount_amount', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {!! $errors->has('amount_to_credit') ? 'error' : '' !!}">
                                    <label>Amount to be Credit</label>
                                    <div class="controls">
                                        {!! Form::text('amount_to_credit', null,[ 'class' => 'form-control mb-1', 'placeholder' => 'Return Note', 'tabindex' => 6, 'amount_to_credit', 'id' => 'amount_to_credit', 'readonly']) !!}
                                        {!! $errors->first('amount_to_credit', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group {!! $errors->has('return_note') ? 'error' : '' !!}">
                                    <label>Return Note</label>
                                    <div class="controls">
                                        {!! Form::text('return_note', null,[ 'class' => 'form-control mb-1', 'placeholder' =>
                                        'Return Note', 'tabindex' => 7, 'return_note', 'id' => 'return_note', 'required']) !!}
                                        {!! $errors->first('return_note', '<label
                                            class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {!! $errors->has('photo') ? 'error' : '' !!}">
                                    <label>Attachment</label>
                                    <div class="controls">
                                        {!! Form::file('photo',[ 'class' => 'form-control mb-1', 'placeholder' =>
                                        'Return Note', 'tabindex' => 7, 'photo', 'id' => 'photo']) !!}
                                        {!! $errors->first('photo', '<label
                                            class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="" class="return_req_photo" target="_blank">Click for photo</a>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                    @if (hasAccessAbility('new_item_return_request', $roles))
                        <button type="submit" class="btn btn-primary return_request" name="return" value="return_request">Return Request</button>

                    @endif
                    @if (hasAccessAbility('new_item_return', $roles))
                        <button type="submit" class="btn btn-primary return_request_deny d-none" name="return" value="return_request_deny">Return Request Deny</button>

                        <button type="submit" class="btn btn-primary" name="return" value="return_save">Final Save changes</button>
                    @endif
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

<!--push from page-->
@push('custom_js')
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{ asset('assets/lightgallery/dist/js/lightgallery.min.js')}}"></script>
<script>
$(".lightgallery").lightGallery();

$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    $( document ).ready(function() {
        $(document).on('click', "input[type='radio'].return_type",function(){
        var condition = $("input[name='stock_condition']:checked").val();
        stockConditionStup(condition,0,0,0);
    });

    $('.pickadate').pickadate({
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy',

    });

    setFinalWeight();
    var get_url = $('#base_url').val();

    var courier = $('.form-group').find('#courier').val();
        $('#courier option').each(function() {
            if (courier == 9){
                $(".pos-laju").show();
            }
        });

});
jQuery (document).on("change", "#length,#width,#height", function(e) {
    setFinalWeight();
});

function setFinalWeight() {
    var length = $('.form-group').find('#length').val();
    var width = $('.form-group').find('#width').val();
    var height = $('.form-group').find('#height').val();
    var amount = length*width*height/5000;
    $('.form-group').find('#total').val(amount.toFixed(2));

    if (amount > 5) {
        toastr.error('Box Weight More then .', '', {timeOut: 5000})
    }
}

$(document).on('change','#courier',function(){
    if ( this.value == '9'){
        $(".pos-laju").show(500);
    }else if(this.value == '12'){
        $(".pos-laju").show(500);
    }
    else{
        $(".pos-laju").hide(500);
    }
})

$(document).on("submit", "#consignmentNoteFrm", function(e){
    $("body").css("cursor", "progress");
    var courier = $('#courier').val();
    var note_input = $('#note_input').val();
    if(courier != 12 && courier != 9){
        if('' == note_input ){
            alert('Please put the consignment');
            return  false;
        }else{
            $("#consignmentNoteFrmSubmit").attr('disabled', 'disabled');
            return  true;
        }
    }
    else{
        $("#consignmentNoteFrmSubmit").attr('disabled', 'disabled');
        return  true;
    }
    e.preventDefault();
});

</script>

<script>

    $(document).on('click','.return_show_modal',function(e){
        $('.return_req_photo').addClass('d-none');
        var booking_child   =  $(this).data('booking_child');
        var paid_amount     =  $(this).data('paid_amount');
        var return_request  =  $(this).data('return_request');
        var condition       =  $(this).data('condition');
        var note            =  $(this).data('note');
        var postage         =  $(this).data('postage');
        var credit_amount   =  $(this).data('credit_amount');
        var request_id      =  $(this).data('request_id');
        var photo_path      =  $(this).data('photo_path');

        $('#booking_details_id').val(booking_child);
        $('#paid_amount').val(paid_amount);
        $('.credit_amount_div').addClass('d-none');
        $('#discount_amount_lbl').text('Refund/Discount');

        if(return_request == 1){
           // $('#credit_amount').val(credit_amount);
           // $('#discount_amount').val(postage);
            $('#return_note').val(note);
            $("input:radio[value='"+condition+"'][name='stock_condition']").prop('checked',true);
            stockConditionStup(condition,return_request,postage,credit_amount);
            $('.return_request_deny').removeClass('d-none');
            $('.return_request').addClass('d-none');
            $('#request_id').val(request_id);
            if(photo_path != ''){
                $('.return_req_photo').removeClass('d-none').attr('href',photo_path);
            }
        }else{
            $('.return_request_deny').addClass('d-none');
            $('.return_request').removeClass('d-none');
            $('#request_id').val('');
        }


    })

    $(document).on('submit',"#returnFrm",function(e){
        // e.preventDefault();
        var cond = $("input[name='stock_condition']:checked").val();
        if(cond == undefined){
            alert('Please select any option');
            return false;
        }else{
        return confirm('Are you sure?');
        }


    });
    $(document).on('input','#credit_amount, #discount_amount', function(){
        var cond = $("input[name='stock_condition']:checked").val();
        setAmountToCredit(cond);
    })


    function stockConditionStup(cond,return_request,postage,credit_amount){

        //var cond = $(this).val();
        if(return_request == 1){
            var paid_amount = credit_amount;
        }else{
            var paid_amount = $('#paid_amount').val();
        }

        if(cond == 1){
            $('#credit_amount_lbl').text('Refund/Discoun');
            $('#discount_amount_lbl').text('Postage');
            $('.discount_div').removeClass('d-none');
            $('.credit_amount_div').removeClass('d-none');
            $('#discount_amount').val(postage).removeAttr('disabled');
            $('#credit_amount').val(paid_amount);
            setAmountToCredit(1);

        }else if(cond == 2){

            $('#credit_amount_lbl').text('Refund/Discount');
            $('#discount_amount_lbl').text('Postage');
            $('.discount_div').removeClass('d-none');
            $('.credit_amount_div').removeClass('d-none');
            $('#credit_amount').val(paid_amount);
            $('#discount_amount').val(postage);
            setAmountToCredit(2);
        }else if(cond == 3){
            $('#credit_amount_lbl').text('Refund/Discount');
            $('#discount_amount_lbl').text('Postage');
            $('.discount_div').addClass('d-none');
            $('.credit_amount_div').removeClass('d-none');
            $('#credit_amount').val(paid_amount);
            $('#discount_amount').val(postage);
            setAmountToCredit(3);
        }else if(cond == 4){
            $('#credit_amount_lbl').text('Penalty');
            $('#discount_amount_lbl').text('Postage');
            $('.discount_div').addClass('d-none');
            $('.credit_amount_div').removeClass('d-none');
            $('#discount_amount').val(postage);
            $('#credit_amount').val('');
            setAmountToCredit(4);
        }else if(cond == 5){

            $('#credit_amount_lbl').text('Refund/Discount');
            $('#discount_amount_lbl').text('Postage');
            $('.discount_div').addClass('d-none');
            $('.credit_amount_div').removeClass('d-none');
            $('#credit_amount').val(paid_amount);
            $('#discount_amount').val(postage);
            // $('#discount_amount').val(0).removeAttr('disabled');
            setAmountToCredit(5);
        }else if(cond == 6){
            $('#credit_amount_lbl').text('Refund/Discount');
            $('#discount_amount_lbl').text('Postage');
            $('.discount_div').removeClass('d-none');
            $('.credit_amount_div').removeClass('d-none');
            $('#credit_amount').val(paid_amount);
            $('#discount_amount').val(postage);
            setAmountToCredit(6);
        }
    }


    function setAmountToCredit(condition){
        var paid_amount = Number($('#paid_amount').val());
        var credit_amount = Number($('#credit_amount').val());
        var discount_amount = Number($('#discount_amount').val());
        var amount_to_credit = 0;
        if(condition == 1){
            amount_to_credit = credit_amount + discount_amount;
        }
        if(condition == 2){
            amount_to_credit = credit_amount + discount_amount;
        }
        if(condition == 3){
            amount_to_credit = credit_amount;
        }
        if(condition == 4){
            amount_to_credit = paid_amount - credit_amount + discount_amount;
        }
        if(condition == 5){
            amount_to_credit = credit_amount + discount_amount;
        }
        if(condition == 6){
            amount_to_credit =credit_amount + discount_amount;
        }
        $('#amount_to_credit').val(amount_to_credit);

    }



    $(document).on('click','.retry',function(e){
        var id = $(this).attr('data-id');
        if (!confirm('Are you sure you want Retry Get Consignment Note')) {
            return false;
        }
        if ('' != id) {
            var pageurl = `{{ URL::to('ajax/consignment/getTrackingId')}}/`+id;
            $.ajax({
                type:'GET',
                url:pageurl,
                async :true,
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (data) {
                    location.reload();
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            });
        }
    })
    $(document).on('click','.m_note', function(e){
        if($(this).is(':checked')){
        $('.directDispatch').attr("disabled", false);
        note_status(1);
        } else{
        $('.directDispatch').attr("disabled", true);
        note_status(0);
    }
    });

    $(document).on('submit','#form_post25',function(){
        if(!confirm("Are you sure?")) {
            return false;
        }
        if (!$('input.m_note').is(':checked') && $('input.m_note').val()) {
            alert('Please read the special note');
            return false;
        }
    });
    function note_status(is_checked) {
        var pageurl = `{{ URL::to('ajax/special_note_status')}}`;
        var booking_no = $('#booking_no').val();
        $.ajax({
            type:'post',
            url:pageurl,
            async :true,
            data : {
                booking_no : booking_no,
                is_checked : is_checked
            },
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                // location.reload();
                if (data == 1) {
                    if (is_checked == 1) {
                        alert('I read the note');
                    }else{
                        alert('I did not read the note');
                    }
                }else{
                    alert('Please try again !');
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    }



</script>

@endpush
