@extends('admin.layout.master')

@section('Dispatch Management','open')
@section('list_dispatch','active')

@section('title') Order for Dispatch @endsection
@section('page-name') Order for Dispatch @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('order.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">@lang('order.breadcrumb_sub_title')</li>
@endsection

@push('custom_css')
<link rel="stylesheet" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/invoice.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<style>
    .f12{font-size: 12px;}
    .w100{width: 100px;}
    #process_data_table td{vertical-align: middle;}
    .order-type{display: inline-block; margin-right: 10px;}
    .order-type label {cursor: pointer;}
    .badge-default{ background-color: #fff; color: blue;}
    .pulse-green {animation: pulsered 2s infinite;background: #90ee90;box-shadow: 0 0 0 #e00e3f;}
    table.order-due-table tr > td {text-transform: uppercase;}
    table.order-due-table {width: 100%;font-size: 14px;border-collapse: collapse;}
    table.order-due-table th,table.order-due-table td {padding: 0.5em;}
    .form-inline{display: inline-flex;}
    .daterangepicker td.active, .daterangepicker td.active:hover {
    background-color: #41cac0!important;
    /* border-color: transparent;
    color: #fff; */
}
.daterangepicker td.in-range {
    background-color: rgba(65, 202, 192,.4)!important;
}
</style>
@endpush
@php
    $booking_status = [
        '70'    => 'Ready to dispatch',
    ];
    $roles = userRolePermissionArray();
    $order_type = 'all';
    $branch = $data['branch'];
    $tab_index = 0;
    $branch_id =  request()->get('branch_id');
    if(Auth::user()->USER_TYPE == 10){
        $branch_id = Auth::user()->SHOP_ID;
    }
    $_booking_status  = request()->get('booking_status') ?? '';
    $order_id   = request()->get('order_id') ?? '';
    $order_date_ = request()->get('order_date') ?? '';
@endphp
@section('content')
<div class="card card-success min-height">
    <div class="card-content collapse show">
        <div class="card-body" style="padding: 15px 5px;">
            <div class="row mb-2">
                <div class="col-12">
                    @if(hasAccessAbility('new_booking', $roles))
                    <a href="{{ route('admin.booking.create',['branch_id' => $branch_id]) }}" class="btn btn-primary open-modal" title="Add new customer">
                        <i class="ft-plus text-white"></i> Create new
                    </a>
                    @endif
                {!! Form::open(['method' => 'get', 'class' => 'form-inline', 'files' => true , 'novalidate']) !!}
                    <div class="form-group {!! $errors->has('branch_id') ? 'error' : '' !!}">
                        <div class="controls">
                            {!! Form::select('branch_id',$branch,$branch_id,['id'=>'branch_id','class'=>'form-control','placeholder'=>'Select branch','tabindex'=>$tab_index++]) !!}
                        </div>
                    </div>
                    <div class="form-group {!! $errors->has('order_id') ? 'error' : '' !!}">
                        <div class="controls">
                            {!! Form::text('order_id',$order_id,['class'=>'form-control', 'id' => 'order_id','placeholder' =>'Enter order id', 'tabindex' => $tab_index++]) !!}
                            {!! $errors->first('order_id', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                    <div class="form-group {!! $errors->has('order_date') ? 'error' : '' !!}">
                        <div class="controls">
                         {!! Form::text('order_date',$order_date_, ['class'=>'form-control', 'id' => 'order_date_', 'placeholder' => 'Filter by date', 'tabindex' => $tab_index++]) !!}
                         {!! $errors->first('order_id', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="controls">
                            <button type="submit" class="text-white btn btn-round  btn-primary" title="Search">Search</button>
                        </div>
                    </div>
                {!! Form::close() !!}
                </div>
            </div>

            {!! Form::open([ 'route' => 'admin.delivery-man.bulkAssign', 'method' => 'POST','id'=>'bulkUpdateForm', 'novalidate']) !!}
            <div class="bulk-update-form p-2">
            {{-- <div class="deliveryManBody">
            </div> --}}
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm table-white-space display no-wrap table-middle" id="process_data_table">
                    <thead>
                    <tr>
                        <th><input type="checkbox" class="input-chk-all check-all"></th>
                        <th class="text-center" style="width:100px;">Created</th>
                        <th class="text-center">Branch</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Order No</th>
                        <th>Customer</th>
                        <th class="text-center" style="width:50px;">Variations</th>
                        <th class="text-center" style="width:50px;" class=" text-right">Order value</th>
                        <th class="text-center" style="width:50px;">Payment</th>
                        <th class="text-center" style="width:50px;">Source</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" title="IS HOLD BY ADMIN">Hold</th>
                        <th class="text-center" title="SELF PICKUP/ COD or RTC">SP</th>
                        <th class="text-center" style="width:122px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            {!! Form::close() !!}
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-success btn-min-width mr-1 mb-1"><i class="la la-backward" ></i> Back</a>
        </div>
    </div>
</div>
@include('admin.components._assign_deliveryman')
 @endsection
@push('custom_js')
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">

    var get_url = $('#base_url').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#order_date_').daterangepicker({
    autoUpdateInput: false,
    ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, (from_date, to_date) => {
    console.log(from_date.toDate(), to_date.toDate());
    $('#order_date_').val(from_date.format('MM/DD/YYYY') + '-' + to_date.format('MM/MM/DD'));
    });
  getDeliveryman("{{ request()->get('branch_id') }}");
    $(document).on("click", "#assign-deliveryman", function (e) {
         e.preventDefault();
        var booking_id = $(this).data('id');
        var branch_id = $(this).attr('shop-id');
        $.ajax({
            type: 'GET',
            url: '{{URL("ajax/get-delivery-man")}}' + "/" + branch_id,
            success: function (response) {
                $('.deliveryManBody').empty();
                $('#deliveryMan').modal('show');
                $('#booking_id').val(booking_id);
                $('.deliveryManBody').append(response);

            },
            error: function (jqXHR, exception) {
                toastr.error('something wrong');
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    });

    $(document).on("change", "#branch_id", function (e) {
         e.preventDefault();
        var branch_id = $(this).val();

        var delivery_man = getDeliveryman(branch_id);

    });

    function getDeliveryman(branch_id){
        if(branch_id){
            $.ajax({
            type: 'GET',
            url: '{{URL("ajax/get-delivery-man")}}' + "/" + branch_id,
            success: function (response) {
                console.log(response);
                $('.deliveryManBody').empty();
                $('.deliveryManBody').append(response);

            },
            error: function (jqXHR, exception) {
                toastr.error('something wrong');
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });

        }


    }

$(document).on('submit', "#assignDeliManForm", function (e) {
        e.preventDefault();
        var form = $("#assignDeliManForm");
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
                    $('#assignDeliManForm')[0].reset();
                    $('#deliveryMan').modal('hide');
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

    $(document).on("change", ".check-all", function() {
            if(this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }

        });

    $(document).ready(function() {
        var table = callDatatable();
    });


function callDatatable() {
        var id          =  `{{ request()->get('id') }}`;
        var type        =  `{{ request()->get('type') }}`;
        var dispatch    =  'confirm';
        var order_from  =  `{{ request()->get('order_from') }}`;
        var branch_id   =  `{{ request()->get('branch_id') }}`;
        var booking_status    =  `{{ request()->get('booking_status') }}`;
        var order_id    =  `{{ request()->get('order_id') }}`;
        var order_date    =  `{{ request()->get('order_date') }}`;

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
            stateSave: true,
            bDestroy: true,
            // iDisplayStart: value,


            ajax: {
                url: get_url+'/booking/all_booking',
                type: 'POST',
                data: function(d) {
                    d._token        = "{{ csrf_token() }}";
                    d.id            = id;
                    d.type          = type;
                    d.dispatch      = dispatch;
                    d.order_from    = order_from;
                    d.branch_id     = branch_id;
                    d.booking_status= booking_status;
                    d.order_id      = order_id;
                    d.order_date    = order_date;
                }
            },

            columns: [
                {
                    data: 'SL',
                    name: 'SL',
                    className:'text-center mx-auto'
                    // searchable: false,
                    // render: function(data, type, row, meta) {
                    //     return meta.row + meta.settings._iDisplayStart + 1;
                    // }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    searchable: false,
                    className:'w100 text-center'
                },
                {
                    data: 'SHOP_NAME',
                    name: 'SLS_BOOKING.SHOP_NAME',
                    searchable: true,
                    className:'text-center'
                },
                {
                    data: 'order_date',
                    name: 'order_date',
                    searchable: true,
                    className:'text-center'
                },
                {
                    data: 'order_id',
                    name: 'SLS_BOOKING.BOOKING_NO',
                    searchable: true,
                    className:'text-center'

                },
                {
                    data: 'customer_name',
                    name: 'SLS_BOOKING.CUSTOMER_NAME',
                    searchable: true,
                    className:'text-capitalize'
                },

                {
                    data: 'variantion',
                    name: 'variantion',
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'price_after_dis',
                    name: 'SLS_BOOKING.TOTAL_PRICE',
                    searchable: false,
                    className: 'text-right'

                },
                {
                    data: 'payment',
                    name: 'payment',
                    searchable: false
                },
                {
                    data: 'avaiable',
                    name: 'avaiable',
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'text-center',
                    searchable: true
                },
                {
                    data: 'admin_hold',
                    name: 'admin_hold',
                    className: 'text-center',
                    searchable: false
                },
                {
                    data: 'self_pickup',
                    name: 'self_pickup',
                    className: 'text-center',
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    className: 'text-center'
                },

            ],

        });
}

$(document).on('submit', "#bulkUpdateForm", function (e) {
        e.preventDefault();
        var form = $("#bulkUpdateForm");
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
                    $('#bulkUpdateForm')[0].reset();
                    callDatatable();
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

@endpush

