@extends('admin.layout.master')
@section('Order Management','open')
@section('web_cart','active')
@section('title') Web Cart @endsection
@section('page-name') Web Cart @endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin_role.breadcrumb_title') </a></li>
<li class="breadcrumb-item active">Web Cart </li>
@endsection
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/pickers/daterange/daterange.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lightgallery/css/lightgallery.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/core/colors/palette-callout.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
<style>
.lightgallery {
    width: 100px;
    float: left;
}
.c-pointer {
    cursor: pointer !important;
}
.fs-14 {
    font-size: 0.875rem !important;
}
.fw-600 {
    font-weight: 600 !important;
}

.bg-dark {
    background-color: var(--dark) !important;
}
.opacity-50 {
    opacity: 0.5 !important;
}

.absolute-full {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    height: 100%;
    display: none;
}
.absolute-center {
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}
.product-card:hover .absolute-full{
    display: block;
    transition: .3s;
}
.la-6x {
    font-size: 6em;
}

div#product-list .col-3 {
    padding: 5px;
}
i.la.la-plus.absolute-center.la-6x {
    font-size: 50px;
}
.card.product-card {
    max-height: 260px;
    min-height: 260px;
    border-radius: 0.25rem;
    padding: 5px;
}
.card {
    margin-bottom: 0.575rem;
}
.img-fit {
    padding: 10px;
}
ul#cartBody {
    min-height: 450px;
}
.dropdown-menu.dropdown-menu-lg {
    width: 320px;
    min-width: 320px;
}
.line-height15{
    line-height: 15px;
}
.cart-img {
    float: left;
    width: 50px;
    margin: 0 auto;
    padding-right: 10px;
}
.soldout-box {
    position: absolute;
    width: 61px;
    height: 14px;
    background-color: red;
    transform: rotate(312deg);
    left: -7px;
    top: 20px;
    text-align: center;
    font-size: 9px;
    line-height: 12px;
    color: #fff;
}
div#cart-details {
    min-height: 600px;
}
div.quantity {
    width: 30px;
    text-align: center;
    padding-top: 0;
    align-self: center;
}
div.orderItem>div.quantity div.caret {
    display: block;
    width: 30px;
    height: 20px;
    color: #aaa;
    cursor: pointer;
    opacity: .35;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.pos-product-list,#cart-details {
    overflow-y: auto;
    /* max-height: calc(100vh - 220px);
    height: calc(100vh - 220px); */
    overflow-x: hidden;
}
</style>
@endpush('custom_css')
<?php
    $roles = userRolePermissionArray();
    $booking_validity = Config::get('static_array.booking_validity') ?? array();
    $branch_id = request()->get('branch_id');
    $tab_index = 0;
    $delivery_schedules = $delivery_schedules ?? [];
    $categories     = $categories ?? [];
    $brand          = request()->get('brand') ?? '';
    $barcode        = request()->get('barcode') ?? '';
    $brand_combo    = getBrandCombo() ?? [];
?>
@section('content')
<div class="card card-success min-height">
    <div class="card-content ">
        <div class="card-body">

            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group ">
                                <label for="branch_id">Branch</label>
                                <div class="controls">
                                    <select class="form-control" tabindex="{{ $tab_index++ }}" id="branch_id" onchange="filterProducts()">
                                        <option value="">Select branch</option>
                                            @if(isset($branch) && count($branch) > 0 )
                                            @foreach($branch as $key => $val)
                                        <option
                                            value="{{ $val->SHOP_ID }}"
                                            data-min_order_amount="{{ $val->MIN_ORDER_AMOUNT }}"
                                            data-max_order_amount="{{ $val->MAX_ORDER_AMOUNT }}"
                                            @if($branch_id )
                                            {{ $val->SHOP_ID == $branch_id ? 'selected' : '' }}
                                            @else
                                            {{ $val->SHOP_ID == 79 ? 'selected' : '' }}
                                            @endif
                                            >{{ $val->SHOP_NAME }}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group {!! $errors->has('category') ? 'error' : '' !!}">
                                <label for="category">{{trans('form.category')}}<span class="text-danger">*</span></label>
                                <div class="controls">
                                    <select class="form-control select2" name="category" id="category">
                                        <option value="">Select category</option>
                                         @if(!empty($categories))
                                        @foreach($categories as $category)
                                        <option value="{{$category->PK_NO}}">{{$category->NAME}}</option>
                                        @if(!empty($category->subcategories))
                                        @foreach($category->subcategories as $subcategory)
                                        <option value="{{$subcategory->SUBCATEGORY_ID}}">{{$category->NAME}} > {{$subcategory->SUBCATEGORY_NAME}}</option>
                                        @if(!empty($subcategory->subsubcategories))
                                        @foreach($subcategory->subsubcategories as $subsubcategory)
                                        <option value="{{$subsubcategory->SUBSUBCATEGORY_ID}}">{{$subcategory->SUBCATEGORY_NAME}} >{{$subsubcategory->SUBSUBCATEGORY_NAME}}</option>
                                        @endforeach
                                        @endif
                                        @endforeach
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                    {!! $errors->first('category', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group {!! $errors->has('brand') ? 'error' : '' !!}">
                                <label for="brand">{{trans('form.brand')}}</label>
                                <div class="controls">
                                    {!! Form::select('brand', $brand_combo, $brand, ['class'=>'form-control mb-1 select2', 'id' => 'brand', 'placeholder' => 'Select brand', 'tabindex' => $tab_index++]) !!}
                                    {!! $errors->first('brand', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group {!! $errors->has('keyword') ? 'error' : '' !!}">
                                <label class="mb-1" for="product">Product Keyword<span class="text-danger">*</span></label>
                                <div class="controls" id="scrollable-dropdown-menu">
                                    <input type="search" name="keyword" id="keyword" class="form-control search-input product-search" onkeyup="filterProducts()" placeholder="Search by product name/Barcode" autocomplete="off">
                                    {!! $errors->first('keyword', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pos-product-list">
                        <div class="row p-2 d-flex flex-wrap justify-content-center" id="product-list">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    {!! Form::open([ 'route' => ['admin.booking.store-ajax'], 'method' => 'post', 'id' => 'place-order', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                    {!! Form::hidden('branch_id',$branch_id,['id'=>'shop_id']) !!}
                    <div class="card mar-btm" id="cart-details">
                        <div class="card-body d-flex flex-column">
                           <div id="address_html" class="mb-2"></div>
                           <div class="d-flex">
                              <div class="flex-grow-1">
                                 <div class="pb-3 border-bottom row">
                                    <div class="col pr-0 overflow-hidden">
                                       <select name="customer_id" class="custom-select customer_id select-box" id="customer_id">
                                          <option selected value="">Choose...</option>
                                       </select>
                                    </div>
                                    <div class="col-2 pl-0">
                                       <button class="btn btn-outline-secondary open-modal btn-block" type="button"><i class="la la-plus"></i></button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="">
                              <div id="cartBody" >
                              </div>
                           </div>
                           <div class="mt-auto mx-auto">
                              <div class="row">
                                 <div class="col-6 col-md-6">
                                    <div class="form-group {!! $errors->has('delivery_date') ? 'error' : '' !!}">
                                       <label class="mb-1">Delivery date<span class="text-danger">*</span></label>
                                       <div class="controls">
                                          <select class="form-control" name="delivery_date" required>
                                             <option value="{{ date('Y-m-d') }}">{{ date('M d, Y') }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+1 days')) }}">{{ date('M d, Y', strtotime('+1 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+2 days')) }}">{{ date('M d, Y', strtotime('+2 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+3 days')) }}">{{ date('M d, Y', strtotime('+3 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+4 days')) }}">{{ date('M d, Y', strtotime('+4 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+5 days')) }}">{{ date('M d, Y', strtotime('+5 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+6 days')) }}">{{ date('M d, Y', strtotime('+6 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+7 days')) }}">{{ date('M d, Y', strtotime('+7 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+8 days')) }}">{{ date('M d, Y', strtotime('+8 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+9 days')) }}">{{ date('M d, Y', strtotime('+9 days')) }}</option>
                                             <option value="{{ date('Y-m-d', strtotime('+10 days')) }}">{{ date('M d, Y', strtotime('+10 days')) }}</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-6 col-md-6">
                                    <div class="form-group {!! $errors->has('delivery_time') ? 'error' : '' !!}">
                                       <label class="mb-1">Delivery time<span class="text-danger">*</span></label>
                                       <div class="controls">
                                          <select class="form-control" name="delivery_time" required>
                                             @if(!empty($delivery_schedules))
                                             @foreach($delivery_schedules as $schedule)
                                             <option value="{{$schedule->PK_NO}}">{{$schedule->SLOT_TITLE}}</option>
                                             @endforeach
                                             @endif
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>

                     </div>

                     <div class="pos-footer mar-btm py-3">
                        <div class="d-flex justify-content-between">
                           <div class="d-flex">
                              <div class="dropdown dropup">
                                 <button class="btn btn-outline-dark btn-styled dropdown-toggle border-right-0" type="button" data-toggle="dropdown">
                                 {{'Shipping'}}
                                 </button>
                                 <div class="dropdown-menu p-3 dropdown-menu-lg">
                                    <div class="radio radio-inline">
                                       <input type="radio" name="shipping" id="radioExample_2a" value="0"  onchange="setShipping()">
                                       <label for="radioExample_2a">{{'Without Shipping Charge'}}</label>
                                    </div>
                                    <div class="radio radio-inline">
                                       <input type="radio" name="shipping" id="radioExample_2b" value="1" checked onchange="setShipping()">
                                       <label for="radioExample_2b">{{'With Shipping Charge'}}</label>
                                    </div>
                                 </div>
                              </div>
                              <div class="dropdown dropup">
                                 <button class="btn btn-outline-dark btn-styled dropdown-toggle border-right-0" type="button" data-toggle="dropdown">
                                 {{'Discount'}}
                                 </button>
                                 <div class="dropdown-menu p-3 dropdown-menu-lg">
                                    <div class="input-group">
                                       <input type="number" min="0" placeholder="Amount" name="flat_discount" id="flat_discount" class="form-control" value="{{ Session::get('flat_discount', 0) }}" required>
                                       <div class="input-group-append">
                                          <button type="button" class="btn btn-light" id="flat-submit-btn">Submit</button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="dropdown dropup">
                                 <button class="btn btn-outline-dark btn-styled dropdown-toggle" type="button" data-toggle="dropdown">
                                 {{'Coupon'}}
                                 </button>
                                 <div class="dropdown-menu p-3 dropdown-menu-lg">
                                    <div class="input-group">
                                       <input type="text" placeholder="Coupon code" name="coupon_code" id="coupon_code" class="form-control" value="{{ Session::get('coupon_code',NULL) }}" required>
                                       <div class="input-group-append">
                                          <button type="button" class="btn btn-light" id="coupon-submit-btn">Submit</button>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="">
                              <button type="submit" class="btn btn-primary save-inv-details searh_and_book_submit_btn"  value="book"><i class="la la-check-square-o"></i> Proceed to Order </button>
                           </div>
                        </div>
                     </div>

                {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title" id="customerModalLabel">Customer</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <div class="modal-body addressModalBody" id="customerModalBody">
          </div>
       </div>
    </div>
</div>
@endsection
@push('custom_js')
<script src="{{ asset('assets/js/common.js?v-1.04')}}"></script>
<script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{ asset('assets/lightgallery/js/lightgallery.min.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script src="{{ asset('assets/pages/address.js')}}"></script>
<script type="text/javascript">
  var get_url = $('#base_url').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var page = 1;
    filterProducts(page);
    $(window).scroll(function() {
      var total_page =$('#total-page').val();
      if($(window).scrollTop() + $(window).height() >= $(document).height()) {
        if(page <= total_page){
        page++;
        filterProducts(page);
        }
       }
    });
   $(document).on('change', '#branch_id,#category,#brand', function () {
        var branch_id = $('#branch_id').val();
        $('#shop_id').val(branch_id);
        $('#product-list').empty();
        filterProducts(page);
    })
    $(document).on('keyup', '#keyword', function () {
        $('#product-list').empty();
        filterProducts(page);
    })
    $(document).on('click', '.open-modal', function () {
        $.ajax({
            type: 'get',
            url: get_url + '/ajax/customer/new',
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    $('#customerModalBody').empty();
                    $('#customerModal').modal('show');
                    $('#customerModalBody').append(response.data);
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })

    $(document).on('change', '.customer_id', function () {
        var customer_id = $(this).val();
        var branch_id = $('#branch_id').val();
        $.ajax({
            type: 'POST',
            url: get_url + '/ajax/customer/get-cart-details/',
            data:{
                branch_id:branch_id,
                customer_id:customer_id,
            },
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    $('#cartBody').empty();
                    $('#address_html').empty();
                    $('#address_html').append(response.data.address_html);
                    $('#cartBody').append(response.data.html);
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })
    function filterProducts(page){
            var branch_id = $('#branch_id').val();
            var keyword = $('#keyword').val();
            var category = $('#category').val();
            var brand = $('#brand').val();
            $.get("{{ URL('ajax/search-list') }}?page=" + page,
                {
                    branch_id:branch_id,
                    keyword:keyword,
                    category:category,
                    brand:brand
                }, function(data){
                products = data;
                console.log(data.data);
                $('#product-list').append(data.data.html);
            });
        }

    $(document).on('click', '.btn-cart', function(e) {
        var product_id = $(this).data('id');
        var branch_id = $('#branch_id').val();
        var customer_id = $('#customer_id').val();
        $.ajax({
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="csrf-token"]').attr('content'));
                $("#loader").fadeIn(300);
             },
            async: true,
            type: 'POST',
            url: '{{URL("ajax/add-to-cart")}}',
            data:{
                branch_id:branch_id,
                product_id:product_id,
                customer_id:customer_id,
            },
            success: function (response) {
                toastr.success(response.message);
                if (response.status == 1) {
                    $('#cartBody').empty();
                    $('#cartBody').append(response.data.html);
                   }
            },
            error: function (jqXHR, exception) {
                toastr.error('something wrong');
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    });

    $(document).on("click", ".delete-cart", function (e) {
        e.preventDefault();
        var cart_id = $(this).data('id');
        var customer_id = $('#customer_id').val();
        var branch_id = $('#branch_id').val();
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            $.ajax({
                beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-Token', $('[name="csrf-token"]').attr('content'));
                $("#loader").fadeIn(300);
                },
                type: 'POST',
                url: '{{URL("ajax/delete-to-cart")}}',
                data:{
                    cart_id:cart_id,
                    customer_id:customer_id,
                    branch_id:branch_id,
                 },
                success: function (response) {
                    if (response.status == 1) {
                        toastr.success(response.message);
                        $('#cartBody').empty();
                        $('#cartBody').append(response.data.html);
                    }
                    else {
                        toastr.error(response.message);
                    }
                },
                error: function (jqXHR, exception) {
                    toastr.error('something wrong');
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            });
        }
    });
    $(document).on("click", ".cart-update", function (e) {
        e.preventDefault();
        var cart_id = $(this).data('id');
        var type = $(this).attr("data-type");
        var customer_id = $('#customer_id').val();
        var branch_id = $('#branch_id').val();
          $.ajax({
                type: 'POST',
                url: '{{URL("ajax/update-cart-qty")}}',
                data:{
                    cart_id:cart_id,
                    type:type,
                    customer_id:customer_id,
                    branch_id:branch_id,
                 },
                success: function (response) {
                    if (response.status == 1) {
                        toastr.success(response.message);
                        $('#cartBody').empty();
                        $('#cartBody').append(response.data.html);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (jqXHR, exception) {
                    toastr.error('something wrong');
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            });
    });
    $(document).on("click", ".edit-row", function (e) {
            e.preventDefault();
            var address_id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: get_url + '/ajax/address/edit/'+address_id,
                success: function (response) {
                    if (response.status == 1) {
                        $('#customerModalBody').empty();
                        $('#customerModal').modal('show');
                        $('#customerModalBody').append(response.data);
                    }else {
                        toastr.error(response.message);
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

    $(document).on('submit', "#customerForm", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var form     = $("#customerForm");
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
                    $('#customerForm')[0].reset();
                    $('#customerModal').modal('hide');
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

    $('.select-box').select2({
            placeholder: "Choose customer...",
            minimumInputLength: 3,
            ajax: {
                type: "POST",
                url:get_url+'/ajax/search-customer',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    $(document).on('click', '#newAddresss', function () {
        var customer_id = $('#customer_id').val();
        $.ajax({
            type: 'GET',
            url: get_url + '/ajax/address/create/'+customer_id,
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    $('#customerModalBody').empty();
                    $('#customerModal').modal('show');
                    $('#customerModalBody').append(response.data);
                } else {
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })
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
                console.log(response);
                if (response.status == 1) {
                    toastr.success(response.message);
                    $('#address_html').empty();
                    $('#address_html').append(response.data);
                    $('#addressForm')[0].reset();
                    $('#customerModal').modal('hide');
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
                        $('#customerModal').modal('hide');
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
            var customer_id = $('#customer_id').val();
            var x = confirm("Are you sure you want to delete?");
            if (x) {
                $.ajax({
                    type: 'POST',
                    url: '{{URL("ajax/address/delete")}}',
                    data:{
                        address_id:address_id,
                        customer_id:customer_id,
                    },
                    success: function (response) {
                        if (response.status == 1) {
                            $('.item' + address_id).remove();
                            $('#address_html').empty();
                            $('#address_html').append(response.data);
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
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


        $(document).on('submit', "#place-order", function (e) {
        e.preventDefault();
        var form = $("#place-order");
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
                        $('#place-order')[0].reset();
                        $('#cartBody').empty();
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


    $(document).on('click', '#flat-submit-btn', function () {
        var flat_discount   = $('#flat_discount').val();
        var customer_id     = $('#customer_id').val();
        var branch_id       = $('#branch_id').val();
        $.ajax({
            type: 'POST',
            url: get_url + '/ajax/flat-discount/',
            async: true,
            data:{
                flat_discount:flat_discount,
                customer_id:customer_id,
                branch_id:branch_id,
            },
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if(response.status == 1) {
                        toastr.success(response.message);
                        $('#cartBody').empty();
                        $('#cartBody').append(response.data.html);
                }
                toastr.success(response.message);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })


    $(document).on('click', '#coupon-submit-btn', function () {
        var coupon_code   = $('#coupon_code').val();
        var customer_id     = $('#customer_id').val();
        var branch_id       = $('#branch_id').val();
        $.ajax({
            type: 'POST',
            url: get_url + '/ajax/coupon-discount/',
            async: true,
            data:{
                coupon_code:coupon_code,
                customer_id:customer_id,
                branch_id:branch_id,
            },
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    toastr.success(response.message);
                    $('#cartBody').empty();
                    $('#cartBody').append(response.data.html);
                }
                else{
                    toastr.error(response.message);
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })
</script>
@endpush('custom_js')


