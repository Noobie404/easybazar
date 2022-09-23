@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">

@endpush('custom_css')
@section('Customer Management','open')
@section('customer_list','active')
@section('title') @lang('customer.customer_view') @endsection
@section('page-name') @lang('customer.customer_view') @endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('product.breadcrumb_title')  </a></li>
<li class="breadcrumb-item active">@lang('product.breadcrumb_sub_title')    </li>
@endsection
<?php
    $roles = userRolePermissionArray();
    $active_tab = request('tab') ?? 1;
    $type = request('type') ?? null;
    $balance = 0;
    $html = array();
    $balance     = 0;
    $orders = $data['orders']->data ?? [];
    $booking_status = Config::get('static_array.booking_status') ?? array();

?>
@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success" >
                <div class="card-content">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                            <li class="nav-item">
                                <a class="nav-link {{$active_tab == 1 ? 'active' : ''}}" id="productBasic-tab1" data-toggle="tab" href="#productBasic" aria-controls="productBasic" aria-expanded="true">@lang('customer.customer_info')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{$active_tab == 2 ? 'active' : ''}}" id="productVariant-tab1" data-toggle="tab" href="#productVariant" aria-controls="linkIcon1" aria-expanded="false">@lang('customer.customer_address')</a>
                            </li>
                            <li class="nav-item {{$active_tab == 3 ? 'active' : ''}}">
                                <a class="nav-link" id="linkIconOpt1-tab1" data-toggle="tab" href="#linkIconOpt1" aria-controls="linkIconOpt1">Customer History</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-1">
                            <div role="tabpanel" class="tab-pane {{$active_tab == 1 ? 'active' : ''}}" id="productBasic" aria-labelledby="productBasic-tab1" aria-expanded="true">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h5 class="section-title py-2 border-bottom">Customer Information</h5>
                                        @if(!empty($customer->PROFILE_PIC_URL))
                                        <p><img src="{{ asset($customer->PROFILE_PIC_URL) }}" class="img-fluid rounded-circle" width="150px" alt="{{ $customer->NAME }}" title="{{ $customer->NAME }}"/></p>
                                        @endif
                                        <h6>Name :{{ $customer->NAME }}</h6>
                                        <h6>Phone :<i>+88{{ $customer->MOBILE_NO }}</i></h6>
                                        @if($customer->ALTERNATE_NO)
                                        <h6>Alternative Phone: {{ $customer->ALTERNATE_NO }}</h6>
                                        @endif
                                        <h6>Email:{{ $customer->EMAIL }}</h6>
                                        @if($customer->BIRTH_DATE)
                                        <h6>Birth date:{{ $customer->BIRTH_DATE }}</h6>
                                        @endif
                                        @if($customer->GENDER)
                                        <h6>Gender: @if($customer->GENDER==1) {{ 'Male' }} @else {{ 'Female' }} @endif</h6>
                                        @endif
                                        <h6><span>Customer No. :{{ $customer->CUSTOMER_NO }}</span></h6>
                                        <a href="#" class="btn btn-xs edit-customer" data-id="{{ $customer->PK_NO }}" title="Edit Customer"><i class="la la-edit"></i> Edit</a>                                      
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="section-title py-2 border-bottom">Default Address</h5>

                                        @if(!empty($address))
                                                @foreach($address as $row)
                                                @if($row->IS_DEFAULT == 1)
                                                <div class="item{{$row->PK_NO}}">
                                                <div>
                                                   <span class="d-block"><i class="la la-user"></i> {{ $row->NAME }}</span>
                                                   <span class="d-block"><i class="ft-phone-call"></i> +88{{ $row->TEL_NO }}</span>
                                                </div>
                                                <div><i class="la la-map-marker"></i>
                                                    @if(!empty($row->ADDRESS_LINE_1))
                                                   <span> {{ $row->ADDRESS_LINE_1 }}, </span>
                                                   @endif
                                                   @if(!empty($row->ADDRESS_LINE_2))
                                                   <span> {{ $row->ADDRESS_LINE_2 }}, </span>
                                                   @endif
                                                   @if(!empty($row->AREA_NAME))
                                                   <span class="d-block"> {{ $row->AREA_NAME }}, </span>
                                                   @endif
                                                   @if(!empty($row->CITY_NAME))
                                                   <span class="d-block"> {{ $row->CITY_NAME ?? '' }} {{ $row->POST_CODE ?? '' }} </span>
                                                   @endif
                                                   <span class="d-block"> {{ $row->STATE_NAME ?? '' }}, Bangladesh </span>
                                                </div>
                                                 <div>
                                                    <div class="py-2">
                                                        @if(hasAccessAbility('edit_customer_address', $roles))
                                                        <a href="#" data-key="{{ $loop->index + 1 }}" data-id="{{ $row->PK_NO }}" class="btn btn-xs btn-primary mr-1 edit-row" title="EDIT"><i class="la la-edit"></i></a>
                                                        @endif
                                                        @if(hasAccessAbility('delete_customer_address', $roles))
                                                        <a href="#" data-id="{{ $row->PK_NO }}"  class="btn btn-xs btn-danger mr-1 delete-row" title="Delete customer address"><i class="la la-trash"></i></a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach()
                                            @else 
                                            <div>
                                                <div>
                                                    <span>Addreess not found</span>
                                                </div>
                                            </div>
                                            @endif
                                   </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="order py-2">
                                            <h5 class="border-bottom">Order list</h5>

                                            <div class="card-body">
                                                <table class="table no-border tb1 thead-light" id="order_table">
                                                    <thead>
                                                        <tr class="table-head">
                                                            <th>SL</th>
                                                            <th>Order # </th>
                                                            <th>Branch</th>
                                                            <th>Date</th>
                                                            <th>Total Value</th>
                                                            <th>Payment</th>
                                                            <th>Status</th>
                                                            <th class="actions text-center">Action </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @if(!empty($orders))

                                                        @foreach( $orders as $key=> $order)

                                                        <tr>
                                                            <td>{{ $key }}</td>
                                                            <td>{{$order->BOOKING_NO}}</td>
                                                            <td>{{$order->SHOP_NAME}}</td>
                                                            <td>{{$order->BOOKING_TIME}}</td>
                                                            <td>৳ {{number_format($order->TOTAL_PRICE,2)}}</td>
                                                            <td>{{$order->PAYMENT_STATUS}}</td>
                                                            <td>{{$booking_status[$order->BOOKING_STATUS]}}</td>
                                                            <td>
                                                            <a href="{{route('admin.booking.view',$order->PK_NO)}}" 
                                                            class="btn btn-xs btn-primary mb-05 mr-05">
                                                            <i class="la la-eye font-size11"></i></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                                {{$orders->links()}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>

                             <div class="tab-pane {{$active_tab == 2 ? 'active' : ''}}" id="productVariant" role="tabpanel" aria-labelledby="productVariant-tab1" aria-expanded="false">
                                @if(hasAccessAbility('new_customer_address', $roles))
                                <button class="btn btn-sm btn-primary text-white mb-1 open-modal" type="button" title="ADD NEW ADDRESS"><i class="ft-plus text-white"></i> @lang('customer.customer_address_btn')</button>
                                {{-- <a class="btn btn-sm btn-primary text-white mb-1" href="{{route('admin.customer-address.create',$customer->PK_NO)}}" title="ADD NEW ADDRESS"><i class="ft-plus text-white"></i> @lang('customer.customer_address_btn')</a> --}}
                                {{-- open-modal --}}
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        <div>
                                           
                                            <div id="appendRow">
                                                @if(!empty($address))
                                                @foreach($address as $row)
                                                <div class="item{{$row->PK_NO}}">
                                                <div width="25%;" class="pinfo">
                                                   <span class="d-block">{{ $row->NAME }}</span>
                                                   <span class="d-block"><i class="ft-phone-call"></i> +88{{ $row->TEL_NO }}</span>
                                                </div>
                                                <div>
                                                    @if(!empty($row->ADDRESS_LINE_1))
                                                   <span> {{ $row->ADDRESS_LINE_1 }}, </span>
                                                   @endif
                                                   @if(!empty($row->ADDRESS_LINE_2))
                                                   <span> {{ $row->ADDRESS_LINE_2 }}, </span>
                                                   @endif
                                                   @if(!empty($row->AREA_NAME))
                                                   <span> {{ $row->AREA_NAME }} </span>
                                                   @endif
                                                   <br>
                                                   @if(!empty($row->CITY_NAME))
                                                   <span> {{ $row->CITY_NAME ?? '' }} - {{ $row->POST_CODE ?? '' }}, </span>
                                                   @endif
                                                   <span> {{ $row->STATE_NAME ?? '' }}, Bangladesh </span>
                                                </div>
                                                <div>
                                                    @if($row->IS_DEFAULT == 1)
                                                    <span class="d-block">Default Shipping Address</span>
                                                    @endif
                                                </div>
                                                <div style="width: 120px;">
                                                    <div class="wrap-td-action">
                                                        @if(hasAccessAbility('edit_customer_address', $roles))
                                                        <a href="#" data-key="{{ $loop->index + 1 }}" data-id="{{ $row->PK_NO }}" class="btn btn-xs btn-primary mr-1 edit-row" title="EDIT"><i class="la la-edit"></i></a>
                                                        @endif
                                                        @if(hasAccessAbility('delete_customer_address', $roles))
                                                        <a href="#" data-id="{{ $row->PK_NO }}"  class="btn btn-xs btn-danger mr-1 delete-row" title="Delete customer address"><i class="la la-trash"></i></a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach()
                                            @else 
                                            <div class="not-found">
                                                <div colspan="5">
                                                    <span>Addreess not found</span>
                                                </div>


                                            </div>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane {{$active_tab == 3 ? 'active' : ''}}" id="linkIconOpt1" role="tabpanel" aria-labelledby="linkIconOpt1-tab1" aria-expanded="false">
                                <div class="content-body">
                                    @include('admin.customer._customerhistory')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="addressModalLabel">Customer Address</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
                 </button>
              </div>
              <div class="modal-body" id="addressModalBody">
              </div>
           </div>
        </div>
    </div>
</div>

@push('custom_js')
<script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{ asset('assets/js/scripts/tooltip/tooltip.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{ asset('assets/pages/address.js')}}"></script>
<script src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
<script type="text/javascript">
$(document).on('click', '.open-modal', function () {
        var get_url = $('#base_url').val();
        $.ajax({
            type: 'get',
            url: get_url + '/ajax/address/create/'+{{ $customer->PK_NO }},
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    $('#addressModalBody').empty();
                    $('#addressModal').modal('show');
                    $('#addressModalBody').append(response.data);
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })

    $(document).on("click", ".edit-row", function (e) {
            e.preventDefault();
            var address_id = $(this).data('id');
            var get_url = $('#base_url').val();
            $.ajax({
                type: 'GET',
                url: get_url + '/ajax/address/edit/'+address_id,
                success: function (response) {
                    if (response.status == 1) {
                        $('#addressModalBody').empty();
                        $('#addressModal').modal('show');
                        $('#addressModalBody').append(response.data);
                    }
                },
                error: function (jqXHR, exception) {
                    toastr.error('Something wrong');
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            });
        });
        $(document).on('submit', "#addressForm", function (e) {
        e.preventDefault();
        var form = $("#addressForm");
        $.ajax({
            type: 'post',
            data: form.serialize(),
            url: form.attr('action'),
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    toastr.success(response.message);
                    $('#appendRow').append(response.data);
                    $('#addressForm')[0].reset();
                    $('#addressModal').modal('hide');
                    $('.address').hide();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (jqXHR, exception) {
                toastr.error('something wrong');
            },
            complete: function (response) {
                $("body").css("cursor", "default");
            }
        });
    });

        $(document).on('submit', "#addressUpdate", function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var form = $("#addressUpdate");
            $.ajax({
                type: 'post',
                data: formData,
                url: form.attr('action'),
                cache:false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (response) {
                    if (response.status == 1) {
                        $('.item' + response.data.address.PK_NO).replaceWith(response.data.html);
                        toastr.success(response.message);
                        $('#addressUpdate')[0].reset();
                        $('#addressModal').modal('hide');
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (jqXHR, exception) {
                    toastr.error('Something wrong');
                },
                complete: function (response) {
                    $("body").css("cursor", "default");
                }
            });
        });
        $(document).on("click", ".delete-address", function (e) {
            e.preventDefault();
            var address_id = $(this).data('id');
            var x = confirm("Are you sure you want to delete?");
            if (x) {
                $.ajax({
                    type: 'GET',
                    url: '{{URL("ajax/address/delete")}}' + "/" + address_id,
                    success: function (response) {
                        if (response.status == 1) {
                            $('.item' + address_id).remove();
                            toastr.success(response.message);
                        }
                    },
                    error: function (jqXHR, exception) {
                        toastr.error('Something wrong');
                    },
                    complete: function (data) {
                        $("body").css("cursor", "default");
                    }
                });
            }
        });
$(document).on("click", ".edit-customer", function (e) {
    e.preventDefault();
    var customer_id = $(this).data('id');
    var get_url = $('#base_url').val();
    $.ajax({
        type: 'GET',
        url: get_url + '/ajax/customer/edit/'+customer_id,
        success: function (response) {
            if (response.status == 1) {
                $('#addressModalBody').empty();
                $('#addressModalLabel').text('Customer update');
                $('#addressModal').modal('show');
                $('#addressModalBody').append(response.data);
            }
        },
        error: function (jqXHR, exception) {
            toastr.error('Something wrong');
        },
        complete: function (data) {
            $("body").css("cursor", "default");
        }
    });
});
$(document).on('submit', "#customerUpdate", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var form     = $("#customerUpdate");
        $.ajax({
                type: 'post',
                data: formData,
                url: form.attr('action'),
                cache:false,
                contentType: false,
                processData: false,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    toastr.success(response.message);
                    $('#customerUpdate')[0].reset();
                    $('#addressModal').modal('hide');
                    location.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (jqXHR, exception) {
                toastr.error('something wrong');
            },
            complete: function (response) {
                $("body").css("cursor", "default");
            }
        });
    });


</script>
@endpush('custom_js')
@endsection
