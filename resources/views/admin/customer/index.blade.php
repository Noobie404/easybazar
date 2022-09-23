@extends('admin.layout.master')

@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
    <style>
        .vendor-entry{
            display: inline-flex;
        }
        .vendor-entry .help-block{display:none;}
    </style>
@endpush
@section('Customer Management','open')
@section('customer_list','active')
@section('title') @lang('customer.list_page_title') @endsection
@section('page-name') @lang('customer.list_page_sub_title') @endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">@lang('customer.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">@lang('customer.breadcrumb_sub_title')</li>
@endsection
@php
    $tab_index = 1;
    $roles = userRolePermissionArray();
    $branch_id =  request()->get('branch_id');
    if(Auth::user()->USER_TYPE == 10){
        $branch_id = Auth::user()->SHOP_ID;
    }
@endphp

@section('content')
<div class="content-body min-height">
    <section id="pagination">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-sm card-success">
                    <div class="card-header">
                        @if(hasAccessAbility('new_customer', $roles))
                        {{-- <a class="btn btn-sm btn-primary" href="{{route('admin.customer.create')}}" title="ADD NEW  CUSTOMER"><i class="ft-plus text-white"></i> @lang('customer.customer_create_btn')</a> --}}
                        <button type="button" class="btn btn-primary open-modal" title="Add new customer">
                            <i class="ft-plus text-white"></i> Create new
                        </button>
                        @endif
                        {!! Form::open([ 'route' => 'admin.customer.list', 'method' => 'get', 'class' => 'form-inline vendor-entry', 'files' => true , 'novalidate']) !!}
                            <div class="form-group {!! $errors->has('branch_id') ? 'error' : '' !!}">
                                <div class="controls">
                                    {!! Form::select('branch_id', $branch, $branch_id, [ 'class' => 'form-control ', 'placeholder' => 'Select branch', 'tabindex' => $tab_index++ ]) !!}
                                </div>
                            </div>
                            <div class="form-group {!! $errors->has('branch_id') ? 'error' : '' !!}">
                                <div class="controls">
                                    <button type="submit" class="text-white btn btn-round  btn-primary" title="Search">Search</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
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
                            <div class="table-responsive ">
                                <table class="table table-striped table-bordered table-sm" id="process_data_table1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">@lang('tablehead.sl')</th>
                                            <th>Customer No</th>
                                            <th>@lang('tablehead.tbl_head_name')</th>
                                            <th>@lang('tablehead.tbl_head_email')</th>
                                            <th>@lang('tablehead.tbl_head_phn_no')</th>
                                            <th title="All payments">All Payments(BDT)</th>
                                            <th>@lang('tablehead.customer_due')(BDT)</th>
                                            <th title="Customer actual credit balance (only verified)">Credit(BDT)</th>
                                            <th style="width: 15%" class="text-center">@lang('tablehead.action')</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal animated zoomIn text-left balanceTrans" tabindex="-1" role="dialog" aria-labelledby="balanceTrans" aria-hidden="true" id="balanceTrans">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-content">
                {!! Form::open([ 'route' => 'admin.customer.blance_transfer', 'method' => 'post', 'class' =>
                'form-horizontal', 'files' => true , 'novalidate','id' => 'balanceTransFrm']) !!}
                <input type="hidden" name="from_customer" value="" id="from_customer" />
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel23"><i class="la la-tree"></i> Balance Transfer from <span
                            id="customer_name"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('payment_no') ? 'error' : '' !!}">
                            <label>Customer Balance</label>
                            <div class="controls">
                                {!! Form::select('payment_no', [], null, ['class'=>'form-control mb-1 ',
                                'data-validation-required-message' => 'This field is required', 'id' => 'payment_no'])
                                !!}
                                {!! $errors->first('payment_no', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('to_customer') ? 'error' : '' !!}">
                            <label>To</label>
                            <div class="controls" id="scrollable-dropdown-menu2">
                                <input type="search" name="q" id="to_customer" class="form-control search_to_customer"
                                    placeholder="Enter Customer Name" autocomplete="off" required>
                                <input type="hidden" name="to_customer_hidden" id="to_customer_hidden">
                                {!! $errors->first('to_customer', '<label
                                    class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('amount_to_trans') ? 'error' : '' !!}">
                            <label>Amount to be transfer</label>
                            <div class="controls">
                                {!! Form::number('amount_to_trans', null, ['class'=>'form-control mb-1 ',
                                'data-validation-required-message' => 'This field is required', 'id' =>
                                'amount_to_trans', 'step' => '0.01']) !!}
                                {!! $errors->first('amount_to_trans', '<label class="help-block text-danger">:message</label>') !!}

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-secondary" data-dismiss="modal" title="Close"><i class="ft-x"></i> Close</button>
                    <button type="submit" class="btn btn-primary" title="Save"><i class="la la-save"></i> Save changes</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title" id="customerModalLabel">Customer</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <div class="modal-body" id="customerModalBody">
          </div>
       </div>
    </div>
</div>
@endsection
@push('custom_js')
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(".datepicker").datepicker({
        format: "yyyy-mm-dd",
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var get_url = $('#base_url').val();

$(document).on('click', '.open-modal', function () {
        $.ajax({
            type: 'get',
            url: get_url + '/ajax/customer/new',
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                console.log(response.data);
                if (response.status == 1) {
                    $('#customerModalBody').empty();
                    $('#addressModal').modal('show');
                    $('#customerModalBody').append(response.data);
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })

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
                    var value = getCookie('customer_list');
                    if (value !== null ) {
                        var value = (value-1)*10;
                    }else{
                        var value = 0;
                    }
                    var table = callDatatable(value);
                    $('#customerForm')[0].reset();
                    $('#addressModal').modal('hide');
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

$(document).on("click", ".edit-row", function (e) {
    e.preventDefault();
    var customer_id = $(this).data('id');
    $.ajax({
        type: 'GET',
        url: get_url + '/ajax/customer/edit/'+customer_id,
        success: function (response) {
            if (response.status == 1) {
                $('#customerModalBody').empty();
                $('#addressModal').modal('show');
                $('#customerModalBody').append(response.data);
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
                    var value = getCookie('customer_list');
                    if (value !== null ) {
                        var value = (value-1)*10;
                    }else{
                        var value = 0;
                    }
                    var table = callDatatable(value);
                    toastr.success(response.message);
                    $('#customerUpdate')[0].reset();
                    $('#addressModal').modal('hide');
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

    $(document).on("click", ".delete-row", function (e) {
        e.preventDefault();
        var customer_id = $(this).data('id');
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            $.ajax({
                type: 'GET',
                url: '{{URL("customer/delete")}}' + "/" + customer_id,
                success: function (response) {
                    console.log(response);
                    if (response.status == 1) {
                        toastr.success(response.message);
                        var value = getCookie('customer_list');
                        if (value !== null ) {
                            var value = (value-1)*10;
                        }else{
                            var value = 0;
                        }
                        var table = callDatatable(value);
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

$(document).on('click', '.billplztrans', function(e){
    var customer_id = $(this).data('id');
    $('#customer_id').val(customer_id);
});

    $(document).ready(function() {
        var value = getCookie('customer_list');
        if (value !== null ) {
            var value = (value-1)*10;
        }else{
            var value = 0;
        }
        var table = callDatatable(value);
    });

    function callDatatable(value) {
        var get_url = $('#base_url').val();
        var branch_id =`{{ request()->get('branch_id') }}`;
        var table = $('#process_data_table1').dataTable({
            processing: false,
            serverSide: true,
            paging: true,
            pageLength: 25,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            iDisplayStart: value,
            stateSave: true,
            "bDestroy": true,
            ajax: {
                url: 'customer/all_customer',
                type: 'POST',
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.branch_id = branch_id;
                }
            },
            columns: [
                {
                    data: 'PK_NO',
                    name: 'PK_NO',
                    searchable: false,
                    sortable:false,
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },

                {
                    data: 'CUSTOMER_NO',
                    name: 'c.CUSTOMER_NO',
                    searchable: true,
                    className: 'text-center'
                },
                {
                    data: 'NAME',
                    name: 'c.NAME',
                    searchable: true
                },
                {
                    data: 'EMAIL',
                    name: 'c.EMAIL',
                    searchable: true,
                    render: function(data, type, row) {
                        if (row.EMAIL == null) {
                            return '----------------------------';
                        } else {
                            return row.EMAIL;
                        }
                    }
                },
                {
                    data: 'mobile',
                    name: 'c.MOBILE_NO',
                    searchable: true,
                },

                {
                    data: 'balance',
                    name: 'balance',
                    searchable: false,
                    className: 'text-right',
                },

                {
                    data: 'due',
                    name: 'due',
                    searchable: true,
                    className: 'text-right'

                },
                {
                    data: 'credit',
                    name: 'c.CUM_BALANCE',
                    searchable: true,
                    className: 'text-right'

                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    className: 'text-center'
                },
            ]
        });
        return table;
    }

</script>

<script>
    $(document).on('click','.page-link', function(){
        var pageNum = $(this).text();
        setCookie('customer_list',pageNum);
    });
    function setCookie(customer_list,pageNum) {
        var today = new Date();
        var name = customer_list;
        var elementValue = pageNum;
        var expiry = new Date(today.getTime() + 30 * 24 * 3600 * 1000); // plus 30 days
        document.cookie = name + "=" + elementValue + "; path=/; expires=" + expiry.toGMTString();
    }
    function getCookie(name) {
        var re = new RegExp(name + "=([^;]+)");
        var value = re.exec(document.cookie);
        return (value != null) ? unescape(value[1]) : null;
    }

</script>
@endpush
