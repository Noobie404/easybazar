@extends('admin.layout.master')

@section('dashboard','active')
@section('title') Dashboard @endsection
@section('page-name') Dashboard @endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Home</li>
@endsection
@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
    <style>
        #dashboard_notepad, #dashboard_notepad_merchant {
            font-weight: bold;
        }
    </style>
@endpush
@php
    $roles = userRolePermissionArray();
@endphp

@section('content')
    <div class="content-body min-height">
            <div class="row">
                @if(hasAccessAbility('view_dashboard_cards_sales_agent', $roles) || hasAccessAbility('view_dashboard_cards_my_manager', $roles))
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-12 mb-1">
                            <div class="pull-up">
                                <div class="card-content">
                                    <div class="card-body bg-success">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h6 class="text-white">Customers / Reseller</h6>
                                                <h3 class="text-white">{{ $data['customer_count'] }} / {{ $data['reseller_count']  }}</h3>
                                            </div>
                                            <div>
                                                <i class="icon-basket-loaded font-large-2 float-right text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-12 mb-1">
                            <div class="pull-up">
                                <div class="card-content">
                                    <div class="card-body bg-success">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h6 class="text-white">Master / Variant - Brand / Model</h6>
                                                <h3 class="text-white">{{ $data['product_master']  }} / {{ $data['product_variant']  }} - {{ $data['product_brand']  }} / {{ $data['product_model']  }}</h3>
                                            </div>
                                            <div>
                                                <i class="icon-user-follow font-large-2 float-right text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-12 mb-1">
                            <div class="pull-up">
                                <div class="card-content">
                                    <div class="card-body bg-blue-grey">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h6 class="text-white">Order today / week / month</h6>

                                                <h5 class="text-white">{{ $data['order_today'] }} / {{ $data['order_last7days'] }} / {{ $data['order_last30days'] }} Qty</h5>
                                                <h5 class="text-white">{{ number_format($data['order_RM_value_today'],2) }} / {{ number_format($data['order_RM_value_7day'],2) }} / {{ number_format($data['order_RM_value_30day'],2) }} RM</h5>

                                            </div>
                                            <div>
                                                <i class="icon-user-follow font-large-2 float-right text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-12 mb-1">
                            <div class="pull-up">
                                <div class="card-content">
                                    <div class="card-body bg-blue-grey">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h6 class="text-white">Dispatch today / week / month</h6>
                                                <h5 class="text-white">{{ $data['order_dispatch_today'] }} / {{ $data['order_dispatch_last7days'] }} / {{ $data['order_dispatch_last30days'] }}</h5>
                                                <h5 class="text-white">{{ number_format($data['order_dispatch_RM_value_today'],2) }} / {{number_format( $data['order_dispatch_RM_value_7day'],2) }} / {{ number_format($data['order_dispatch_RM_value_30day'],2) }} RM</h5>

                                            </div>
                                            <div>
                                                <i class="icon-user-follow font-large-2 float-right text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-12 mb-1">
                            <div class="pull-up">
                                <div class="card-content">
                                    <div class="card-body bg-cyan" style="min-height: 118px;">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h6 class="text-white">COD/RTC - RTS</h6>
                                                <h5 class="text-white">{{ $data['cod_rtc_today'] }} - {{ $data['rts_today'] }}</h5>

                                            </div>
                                            <div>
                                                <i class="icon-user-follow font-large-2 float-right text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-12 mb-1">
                            <div class="pull-up">
                                <div class="card-content">
                                    <div class="card-body bg-cyan">
                                        <div class="media d-flex">
                                            <div class="media-body text-left">
                                                <h6 class="text-white">SMS today / week / month</h6>
                                                <h5 class="text-white">{{ $data['arrival_msg_sent_today'] }} / {{ $data['arrival_msg_sent_last7days'] }} / {{ $data['arrival_msg_sent_last30days'] }} Arrival</h5>
                                                <h5 class="text-white">{{ $data['dispatch_msg_sent_today'] }} / {{ $data['dispatch_msg_sent_last7days'] }} / {{ $data['dispatch_msg_sent_last30days'] }} Dispatch</h5>

                                            </div>
                                            <div>
                                                <i class="icon-user-follow font-large-2 float-right text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-md-6">
                    <div class="row">
                        @if(hasAccessAbility('view_dashboard_notice', $roles))
                        <div class="col-md-6 col-12">
                            <div class="card pull-up mb-1">
                                <div class="card-header bg-hexagons">
                                    <h4 class="card-title"><strong>NOTICE</strong></h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                </div>
                                <div class="card-content collapse show bg-hexagons">
                                    <div class="card-body pt-0">
                                        {!! Form::textarea('dashboard_notepad', $data['sticky_note']->NOTE ?? null, [ 'class' => 'form-control', 'id' => 'dashboard_notepad', 'placeholder' => 'Enter note', 'tabindex' => 16, 'rows' => 13 , $data['role_id'] != 1 ? 'readonly' : '']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(hasAccessAbility('view_dashboard_merchant_notice', $roles))
                        <div class="col-md-6 col-12">
                            <div class="card pull-up mb-1">
                                <div class="card-header bg-hexagons">
                                    <h4 class="card-title"><strong>NOTICE FOR MERCHANT</strong></h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                </div>
                                <div class="card-content collapse show bg-hexagons">
                                    <div class="card-body pt-0">
                                        {!! Form::textarea('dashboard_notepad_merchant', $data['sticky_note']->MERCHANT_NOTE ?? null, [ 'class' => 'form-control', 'id' => 'dashboard_notepad_merchant', 'placeholder' => 'Enter note', 'tabindex' => 16, 'rows' => 13 , $data['role_id'] != 1 ? 'readonly' : '']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>

            </div>
            @if(hasAccessAbility('view_dashboard_cards_uk_manager', $roles))
                <div class="row mb-1">
                    <div class="col-xl-3 col-lg-6 col-12 mb-1">
                        <div class="pull-up">
                            <div class="card-content">
                                <div class="card-body bg-blue">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h6 class="text-white">Purchase today / week / month</h6>
                                            <h5 class="text-white">{{ $data['purchase_qty_today'] }} / {{ $data['purchase_qty_last7days'] }} / {{ $data['purchase_qty_last30days'] }} Qty</h5>
                                            <h5 class="text-white">{{ number_format($data['purchase_val_today'],2) }} / {{ number_format($data['purchase_val_last7days'],2) }} / {{ number_format($data['purchase_val_last30days'],2) }} GBP</h5>

                                        </div>
                                        <div>
                                            <i class="icon-basket-loaded font-large-2 float-right text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 mb-1">
                        <div class="pull-up">
                            <div class="card-content">
                                <div class="card-body bg-blue" style="min-height: 118px;">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h6 class="text-white">Vat Claim Pending</h6>
                                            <h3 class="text-white">{{ number_format($data['purchase_yet_to_claim_vat'],2) }} GBP</h3>
                                        </div>
                                        <div>
                                            <i class="icon-user-follow font-large-2 float-right text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 mb-1">
                        <div class="pull-up">
                            <div class="card-content">
                                <div class="card-body bg-blue" style="min-height: 118px;">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h6 class="text-white">Shipment / Box / Product </h6>
                                            <h5 class="text-white">{{ $data['shipment_in_vessel'] }} / {{ $data['shipment_in_vessel_box_count'] }} / {{ $data['shipment_in_vessel_product_count'] }} (Vessel)
                                            </h5>
                                            <h5 class="text-white">{{ $data['shipment_not_in_vessel'] }} / {{ $data['shipment_not_in_vessel_box_count'] }} / {{ $data['shipment_not_in_vessel_product_count'] }} (Origin)</h5>
                                        </div>
                                        <div>
                                            <i class="icon-heart font-large-2 float-right text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 mb-1">
                        <div class="pull-up">
                            <div class="card-content">
                                <div class="card-body bg-blue" style="min-height: 118px;">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h6 class="text-white">Box Not Assigned(Product) / Yet to Box</h6>
                                            <h3 class="text-white">{{ $data['box_not_assigned'] }} ({{ $data['box_not_assigned_prd_qty'] }}) / {{ $data['yet_to_box'] }}</h3>
                                        </div>
                                        <div>
                                            <i class="icon-heart font-large-2 float-right text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        @if($data['role_id'] == 1)
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-12 mb-1">
                    <div class="pull-up">
                        <div class="card-content">
                            <div class="card-body bg-teal">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h6 class="text-white">Free Stock Qty ({{ $data['free_stock_qty'] }})</h6>
                                        <h5 class="text-white">{{ number_format($data['free_stock_purchase_price_rm'],2) }} RM (P)</h5>
                                        <h5 class="text-white">{{ number_format($data['free_stock_salses_price_rm'],2) }} RM (S)</h5>
                                    </div>
                                    <div>
                                        <i class="icon-basket-loaded font-large-2 float-right text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12 mb-1">
                    <div class="pull-up">
                        <div class="card-content">
                            <div class="card-body bg-teal">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h6 class="text-white">Verified Deposit / Unverified / Due</h6>
                                        <h5 class="text-white">
                                            @php
                                                $due = $data['booked_not_dispatched_price_rm'] - $data['sales_pipeline_varified_deposit'] - $data['payment_verfication_pending'];
                                            @endphp
                                            {{ number_format($data['sales_pipeline_varified_deposit'],2) }} / {{ number_format($data['payment_verfication_pending'],2) }} / {{ number_format($due,2) }} </h5>

                                        <h5 class="text-white">{{ number_format($data['booked_not_dispatched_price_rm'],2) }} RM (Exisiting Order)</h5>
                                    </div>
                                    <div>
                                        <i class="icon-heart font-large-2 float-right text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12 mb-1">
                    <div class="pull-up">
                        <div class="card-content">
                            <div class="card-body bg-teal" style="min-height: 118px;">
                                <div class="media d-flex">
                                    <div class="media-body text-left">
                                        <h6 class="text-white">Customer Free Credit</h6>
                                        <h3 class="text-white">{{ number_format($data['customer_free_credit'],2) }} RM</h3>
                                    </div>
                                    <div>
                                        <i class="icon-basket-loaded font-large-2 float-right text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12 mb-1">
                    <div class="pull-up">
                        <div class="card-content">
                            <div class="card-body bg-teal" style="min-height: 118px;">
                                <div class="media d-flex">
                                    <div class="media-body text-left text-white">
                                        <h6 class="text-white">COD</h6>
                                        <h5 class="text-white">{{ number_format($data['cod_balance'],2) }} RM</h5>
                                    </div>
                                    <div>
                                        <i class="icon-pie-chart font-large-2 float-right text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-xl-6 col-lg-6 col-12 mb-1">
                <div class="pull-up">
                    <div class="card-content">
                        <div class="card-body bg-cyan">
                            <div class="row">
                                <div class="col-3">
                                    <h4 class="text-white">Top Agent</h4>
                                </div>
                                <div class="col-3">
                                    <h4 class="text-white">Today</h4>
                                </div>
                                <div class="col-3">
                                    <h4 class="text-white">Last 7 day</h4>
                                </div>
                                <div class="col-3">
                                    <h4 class="text-white">Last 30 days/{{ \Carbon\Carbon::now()->format('M') }}</h4>
                                </div>
                            </div>
                            <hr>
                            @foreach ($data['top_agent'] as $item)
                            <div class="row">
                                <div class="col-3">
                                    <h6 class="text-white">{{ $item->SHOP_NAME }}</h6>
                                </div>
                                <div class="col-3">
                                    <h6 class="text-white">{{ $item->today_qty }}</h6>
                                </div>
                                <div class="col-3">
                                    <h6 class="text-white">{{ $item->last7days_qty }}</h6>
                                </div>
                                <div class="col-3">
                                    <h6 class="text-white">{{ $item->last30days_qty }} / {{ $item->this_month }}</h6>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-12 mb-1">
                <div class="pull-up">
                    <div class="card-content">
                        <div class="card-body bg-cyan" style="min-height: 195px;">
                            <div class="row">
                                <div class="col-3">
                                    <h4 class="text-white">Top Reseller</h4>
                                </div>
                                <div class="col-3">
                                    <h4 class="text-white">Today</h4>
                                </div>
                                <div class="col-3">
                                    <h4 class="text-white">Last 7 day</h4>
                                </div>
                                <div class="col-3">
                                    <h4 class="text-white">Last 30 days/{{ \Carbon\Carbon::now()->format('M') }}</h4>
                                </div>
                            </div>
                            <hr>
                            @foreach ($data['top_reseller'] as $item)
                            <div class="row">
                                <div class="col-3">
                                    <h6 class="text-white">{{ $item->RESHOP_NAME }}</h6>
                                </div>
                                <div class="col-3">
                                    <h6 class="text-white">{{ $item->today_qty }}</h6>
                                </div>
                                <div class="col-3">
                                    <h6 class="text-white">{{ $item->last7days_qty }}</h6>
                                </div>
                                <div class="col-3">
                                    <h6 class="text-white">{{ $item->last30days_qty }} / {{ $item->this_month }}</h6>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
@push('custom_js')
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
@if ($data['role_id'] == 1)
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function delay(callback, ms) {
      var timer = 0;
      return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
          callback.apply(context, args);
        }, ms || 0);
      };
    }
    $(document).on('input','#dashboard_notepad, #dashboard_notepad_merchant', delay(function(e){
        var get_url = $('#base_url').val();
        var note = $("#dashboard_notepad").val();
        var merchant_note = $("#dashboard_notepad_merchant").val();
        $.ajax({
            type:'POST',
            url:get_url+'/postDashboardNote',
            data: {
                note,
                merchant_note,
            },
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                if (data == 1) {
                    toastr.info('Note Updated Successfully ! ','Success');
                }else{
                    toastr.warning('Please Try Again !','Failed');
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    }, 3000));

</script>
@endif
@endpush
