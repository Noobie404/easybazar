@extends('admin.layout.master')
@section('list_delivered','active')

@section('title') Order | Delivered @endsection
@section('page-name') Delivered Order @endsection

@section('page-name') @lang('order.list_page_sub_title') @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('order.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">@lang('order.breadcrumb_sub_title')</li>
@endsection

@push('custom_css')
<link rel="stylesheet" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
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
</style>
@endpush


@php
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
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm" id="process_data_table">
                    <thead>
                    <tr>
                        <th>SL.</th>
                        <th style="width:100px;">Created</th>
                        <th>Banch</th>
                        <th>Date</th>
                        <th>Order No</th>
                        <th>Customer</th>
                        <th style="width:50px;">Variations</th>
                        <th style="width:50px;" class=" text-right">Order value</th>
                        <th style="width:50px;">Payment</th>
                        <th style="width:50px;">Source</th>
                        <th class=" text-center">Status</th>
                        <th class=" text-center" title="IS HOLD BY ADMIN">Hold</th>
                        <th class=" text-center" title="SELF PICKUP/ COD or RTC">SP</th>
                        <th class=" text-center" style="width:122px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-success btn-min-width mr-1 mb-1"><i class="la la-backward" ></i> Back</a>
        </div>
    </div>
</div>



@endsection

@push('custom_js')
<!-- BEGIN: Data Table-->
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<!-- END: Data Table-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="https://pixinvent.com/modern-admin-clean-bootstrap-4-dashboard-html-template/app-assets/js/scripts/forms/checkbox-radio.min.js"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
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

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var get_url = $('#base_url').val();


$(document).ready(function() {
    var id          =  `{{ request()->get('id') }}`;
    var type        =  `{{ request()->get('type') }}`;
    var dispatch    =  'delivered';
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
                    data: 'PK_NO',
                    name: 'PK_NO',
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    searchable: false,
                    className:'w100'
                },
                {
                    data: 'SHOP_NAME',
                    name: 'SLS_BOOKING.SHOP_NAME',
                    searchable: true,
                },
                {
                    data: 'order_date',
                    name: 'order_date',
                    searchable: true
                },
                {
                    data: 'order_id',
                    name: 'SLS_BOOKING.BOOKING_NO',
                    searchable: true,

                },
                {
                    data: 'customer_name',
                    name: 'SLS_BOOKING.CUSTOMER_NAME',
                    searchable: true,
                    className:'text-uppercase'
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
});


</script>

@endpush

