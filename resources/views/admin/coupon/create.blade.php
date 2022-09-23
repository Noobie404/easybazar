@extends('admin.layout.master')
@section('coupon_discount','active')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{asset('/assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/pickers/daterange/daterange.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">
    <style>
        .f12{font-size: 12px !important;}
        tr.active_row, tr.active_row .active_txt {color: yellow !important;}
        .active_row {background-color: red !important; color: #FFF !important;}
        .card-header-sm{padding: 1rem 1.5rem;}
        .card-header-sm .heading-elements, .card-header .heading-elements-toggle{top: 12px;}
        .fix-table{ height: 450px;overflow-x: hidden; overflow-y: auto;}
        .active_txt {color: red;}
        .col-sm-12{padding: 5px;}
        .table.table-sm th, .table.table-sm td {padding: 0.5rem .2rem;}
    </style>
@endpush

@section('title') Create Coupon @endsection
@section('page-name') Create Coupon @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('payment.breadcrumb_title') </a></li>
    <li class="breadcrumb-item active">Coupon </li>
@endsection

@php
    $roles = userRolePermissionArray();
    $branch_id = 0;
@endphp
@section('content')
<!-- Alternative pagination table -->
<div class="content-body min-height">
    <div class="card card-success">
        <div class="card-body">
            {!! Form::open([ 'route' => 'admin.coupon.store', 'method' => 'post', 'class' => 'form-horizontal','id'=>'coupon_form','files' => true ,'novalidate']) !!}
            {!! Form::hidden('input_values[]', null, ['id'=>'input_values']) !!}
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group {!! $errors->has('branch_id') ? 'error' : '' !!}">
                        <label>Select Branch<span class="text-danger">*</span></label>
                        <div class="controls">
                            {!! Form::select('branch_id', $data['branch'], $branch_id, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Please select', 'data-validation-required-message' => 'This field is required', 'tabindex' =>1, 'id' => 'branch_id', 'onchange' => "getPurchaser(this)"  ]) !!}
                            {!! $errors->first('branch_id', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group {!! $errors->has('coupon_code') ? 'error' : '' !!}">
                        <div class="controls">
                            <label>Enter Coupon<span class="text-danger">*</span></label>
                            {!! Form::text('coupon_code', null, ['class'=>'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'coupon_code', 'required','placeholder'=>'BLACKFRIDAY10']) !!}
                            {!! $errors->first('coupon_code', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="controls">
                        <label>Choose type<span class="text-danger">*</span></label>
                        {!! Form::select('coupon_type', array(1=>'Percentage',2=>'Amount'), 1, ['class'=>'form-control mb-1 select2', 'data-validation-required-message' => 'This field is required', 'id' => 'coupon_type', 'required']) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group {!! $errors->has('discount') ? 'error' : '' !!}">
                        <div class="controls">
                            <label>Enter <span id="coupon_type_span">Discount (%)</span> <span class="text-danger">*</span></label>
                            {!! Form::number('discount', null, ['class'=>'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'discount', 'required','placeholder'=>'EX:10']) !!}
                            {!! $errors->first('discount', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group {!! $errors->has('order_min_value') ? 'error' : '' !!}">
                        <div class="controls">
                            <label>Minimum Order (TK)<span class="text-danger">*</span></label>
                            {!! Form::number('order_min_value', 0, ['class'=>'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'id' => 'order_min_value', 'required','placeholder'=>'EX:100']) !!}
                            {!! $errors->first('order_min_value', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group {!! $errors->has('validity_from') ? 'error' : '' !!}">
                        <label>Enter Start Date<span class="text-danger">*</span></label>
                        <div class="controls">
                            {!! Form::text('validity_from', null, [ 'class' => 'form-control pickadate', 'placeholder' => 'Enter start date', 'data-validation-required-message' => 'This field is required' ]) !!}
                            {!! $errors->first('validity_from', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group {!! $errors->has('validity_to') ? 'error' : '' !!}">
                        <label>Enter End Date<span class="text-danger">*</span></label>
                        <div class="controls">
                            {!! Form::text('validity_to', null, [ 'class' => 'form-control pickadate', 'placeholder' => 'Enter end date', 'data-validation-required-message' => 'This field is required' ]) !!}
                            {!! $errors->first('validity_to', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="controls">
                        <label>Choose option<span class="text-danger">*</span></label>
                        {{-- {!! Form::select('coupon_for', array(1=>'Product',2=>'Master',3=>'Flat discount'), 1, ['class'=>'form-control mb-1 select2', 'data-validation-required-message' => 'This field is required', 'id' => 'coupon_for', 'required']) !!} --}}
                        {!! Form::select('coupon_for', array(3=>'Flat discount'), 1, ['class'=>'form-control mb-1 select2', 'data-validation-required-message' => 'This field is required', 'id' => 'coupon_for', 'required']) !!}
                    </div>
                </div>
                {{-- <div class="col-md-4">
                    <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                        <div class="controls" style="position: relative;">
                            <label>Search </label>
                            {!! Form::text('name', '', ['class'=>'form-control mb-1', 'id' => 'name','placeholder'=>'Enter keyword']) !!}
                            {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                            <button type="button" style="position: absolute;right: 0;top: 23px;" class="btn btn-info btn-sm" id="search_item">Search</button>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-2">
                    <div class="controls">
                        <label>Is active<span class="text-danger">*</span></label>
                        {!! Form::select('is_active', array(1=>'Active',2=>'Inactive'), 1, ['class'=>'form-control mb-1 select2', 'data-validation-required-message' => 'This field is required', 'id' => 'is_active', 'required']) !!}
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-6" style="padding: 5px;">
                    <div class="card box-shadow-0 border-success">
                        <div class="card-header card-head-inverse bg-success card-header-sm">
                            <h4 class="card-title text-center text-white">All List</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard" style="padding: 10px 0px;">
                                <div class="table-responsive fix-table">
                                    <table class="table table-striped table-bordered cust50 table-sm " id="all_list_table">
                                        <thead>
                                            <tr>
                                                <th style="width: 70px;" class="text-center nosort">
                                                    <label class="c-p">
                                                        <input type="checkbox" id="bulk_check1" class="">
                                                    </label>
                                                    Select</th>
                                                <th class="text-left" style="width: 120px;">Image</th>
                                                <th class="text-left">Name</th>
                                                <th style="width: 50px;" class="text-left" >Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="all_list_tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6" style="padding-left: 5px;">
                    <div class="row">
                        <div class="col-1" style="margin-top: 26%;">
                            <button class="btn btn-success btn-sm" id="move_right" style="mrgin-top:40%;" title="MOVE TO RIGHT"><i class="la la-forward"></i></button>
                            <button class="btn btn-success btn-sm mt-2" id="move_left" style="mrgin-top:40%;" title="MOVE TO RIGHT"><i class="la la-backward"></i></button>
                        </div>
                        <div class="col-11" style="padding-left: 5px;">
                            <div class="card box-shadow-0 border-success">
                                <div class="card-header card-head-inverse bg-success card-header-sm">
                                    <h4 class="card-title text-center text-white">Selected Data</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard" style="padding: 10px 0px;">
                                        <div class="table-responsive fix-table">
                                            <table class="table table-striped table-bordered table-sm" id="selected_list_table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 70px;" class="text-center nosort">
                                                            <label class="c-p">
                                                                <input type="checkbox" id="bulk_check2" class="">
                                                            </label>
                                                            Select</th>
                                                        <th class="text-left" style="width: 120px;">Image</th>
                                                        <th class="text-left">Name</th>
                                                        <th style="width: 80px;" class="text-left">
                                                            Action
                                                            <label class="c-p">
                                                                <input type="checkbox" id="bulk_check3" class="ml-1">
                                                            </label>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="slected_list_tbody">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {!! $errors->has('image') ? 'error' : '' !!}">
                        <label class="active">Coupon Image</label>
                        <div class="controls">
                            <div class="fileupload fileupload-exists" data-provides="fileupload" >
                            <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                            </span>
                            <span>
                            <label class="btn btn-primary btn-rounded btn-file btn-sm">
                            <span class="fileupload-new">
                            <i class="la la-file-image-o"></i> Select Image
                            </span>
                            <span class="fileupload-exists">
                            <i class="la la-reply"></i> Change
                            </span>
                            {!! Form::file('image', Null,[ 'class' => 'form-control mb-1']) !!}
                            </label>
                            <a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                            <i class="la la-times"></i> Remove
                            </a>
                            </span>
                            {{-- <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}}  119 x 60 pixels</span> --}}
                            </div>
                                {!! $errors->first('image', '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <a href="{{ route('admin.coupon.list') }}">
                            <button type="button" class="btn btn-warning mr-1">
                            <i class="ft-x"></i>Cancel
                        </button>
                        </a>
                        <button type="submit" class="btn btn-primary" id="submit">
                            <i class="la la-check-square-o"></i> Save
                        </button>
                    </div>
                </div>
            </div>


            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@push('custom_js')
<script src="{{asset('/assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
<script  type="text/javascript">
    $(document).ready(function(){
        $('.pickadate').pickadate({
            format: 'dd-mm-yyyy',
            formatSubmit: 'dd-mm-yyyy',
        });
    })
    var table1 = $('#all_list_table').DataTable( {
    "pageLength": -1,
    "bSort" : false,
    "lengthMenu": [[-1], ["All"]],
    "paging":   false,
    } );
    var table2 = $('#selected_list_table').DataTable( {
    "pageLength": -1,
    "bSort" : false,
    "lengthMenu": [[-1], ["All"]],
    "paging":   false,
    } );
    $(document).on("change", "#coupon_for", function(e){
        table1.clear().draw();
        // table2.clear().draw();
        // var selected_item_list = [];
    });
    $(document).on("click", "#bulk_check1", function(e){
        $('#all_list_tbody input[name=checkbox]').prop('checked', $(this).is(':checked'));
    });
    $(document).on("click", "#bulk_check2", function(e){
        $('#slected_list_tbody input[name=checkbox]').prop('checked', $(this).is(':checked'));
    });
    $(document).on("click", "#bulk_check3", function(e){
        $('#slected_list_tbody input[id*=to_show]').prop('checked', $(this).is(':checked'));
    });
    $(document).on("click", "#slected_list_tbody :checkbox", function(e){
        if (!$(this).is(':checked')) {
            $('#all_list_tbody').append($(this).closest('tr'));
        }
    });
    $(document).on("change", "#coupon_type", function(e){
        if ($(this).val() == 1) {
            $('#coupon_type_span').text('Discount (%)');
        }else{
            $('#coupon_type_span').text('Amount');
        }
    });
    var selected_item_list = []; //variant
    var master_ids = []; //master
    $(document).on("click", "#move_right", function(e){
        e.preventDefault();
        var id = 0;
        var checked_vals = $('#all_list_tbody :checkbox:checked').closest('tr');
        var selected_items = [];
        var coupon_for = $('#coupon_for').val();

        $("#all_list_tbody :checkbox:checked").closest('tr').each(function(index){
            selected_items = [];
            $(this).find('td').each(function(i){
                selected_items.push($(this).html());
                if($(this).find('input[type=checkbox]').val()){
                    id = $(this).find('input[type=checkbox]').val();
                }
            });

            if (master_ids.includes(id) == false && coupon_for == 2) {
                master_ids.push(id);
            }
            if (selected_item_list.includes(id) == false && coupon_for == 1) {
                var dom = table2.row.add( [
                    selected_items[0],
                    selected_items[1],
                    selected_items[2],
                    selected_items[3],
                ] ).draw().node();
                $(dom).addClass('row_'+id);
                $(dom).find('input[id*=to_show]').show();
                selected_item_list.push(id);
            }
            table1.row(checked_vals[index]).remove().draw();
        });
        if(coupon_for == 1){
            $('#input_values').val(selected_item_list);
        }else{
            var url = get_url + '/coupon/get-master-variants';
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    'master_pks' : master_ids,
                },
                success: function(data) {
                    if (data.status === true){
                        for (let i = 0; i < data.data['count']; i++) {
                            if (selected_item_list.includes(data.data['html'][i][0]) == false) {
                                var dom = table2.row.add([
                                    '<input id="checkbox" class="ml-1" name="checkbox" type="checkbox" value="'+data.data['html'][i][0]+'" >',
                                    '<img src="'+get_url+data.data['html'][i][1]+'"  style="width : 50px;" />',
                                    data.data['html'][i][2],
                                    '<a href="'+data.data['html'][i][3]+'" target="_blank" class="btn btn-xs btn-info mr-1"><i class="la la-eye"></i></a> <input id="to_show" class="ml-1" name="to_show[]" type="checkbox" value="'+data.data['html'][i][0]+'" >',
                                ]).draw().node();
                                $(dom).addClass('row_'+data.data['html'][i][0]);
                                selected_item_list.push(data.data['html'][i][0]);
                            }
                        }
                        $('#input_values').val(selected_item_list);
                    }else{
                        toastr.warning(data.msg, 'Warning');
                    }
                    $("body").css("cursor", "default");
                },
                error: function (xhr, ajaxOptions, thrownError) {}
            });
        }
    });
    $(document).on("click", "#move_left", function(e){
        e.preventDefault();
        var id = 0;
        var checked_vals = $('#slected_list_tbody input[name="checkbox"]:checked').closest('tr');
        var coupon_for = $('#coupon_for').val();
        var selected_items = [];
        $("#slected_list_tbody input[name='checkbox']:checked").closest('tr').each(function(index2){
            selected_items = [];
            $(this).find('td').each(function(i){
                selected_items.push($(this).html());
                if($(this).find('input[name=checkbox]').val()){
                    id = $(this).find('input[name=checkbox]').val();
                }
            });
            if (coupon_for == 1) {
                var dom = table1.row.add( [
                    selected_items[0],
                    selected_items[1],
                    selected_items[2],
                    selected_items[3],
                ] ).draw().node();
                $(dom).addClass('row_'+id);
                $(dom).find('input[id*=to_show]').hide();
            }
            // var index = selected_item_list.indexOf(id);
            // if (index !== -1) {
            //     selected_item_list.splice(index, 1);
            // }
            table2.row(checked_vals[index2]).remove().draw();
        });
        selected_item_list = [];
        $("#slected_list_tbody tr > td:first-child :checkbox").each(function(i){
            selected_item_list.push($(this).val());
        });
        $('#input_values').val(selected_item_list);
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var get_url = $('#base_url').val();
    $(document).on("click", "#search_item", function(e) {
        if ($('input[id="name"]').val() == '') {
            $('#coupon_form .help-error').remove();
            $('input[id="name"]').closest('.form-group').addClass('error');
            return false;
        }
        var initHtml = '<tr><td colspan="5" class="text-center text-danger" title="Loading"> <i class="fa fa-spinner fa-spin" style="font-size:24px"></i></td></tr>';
        $('#all_list_table > tbody').empty().append(initHtml);
        $("body").css("cursor", "progress");
        var coupon_for = $('#coupon_for').val();
        var value = $('#name').val();
        var url = get_url + '/coupon/search-product';
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            data: {
                'coupon_for' : coupon_for,
                'value' : value,
            },
            success: function(data) {
                if (data.status === true){
                    table1.clear().draw();
                    for (let i = 0; i < data.data['count']; i++) {
                        var dom = table1.row.add( [
                            '<input id="checkbox" class="ml-1" name="checkbox" type="checkbox" value="'+data.data['html'][i][0]+'" >',
                            '<img src="'+get_url+data.data['html'][i][1]+'"  style="width : 50px;" />',
                            data.data['html'][i][2],
                            '<a href="'+data.data['html'][i][3]+'" target="_blank" class="btn btn-xs btn-info mr-1"><i class="la la-eye"></i></a> <input id="to_show" class="ml-1" name="to_show[]" type="checkbox" value="'+data.data['html'][i][0]+'" >',
                        ] ).draw().node();
                        $(dom).addClass('row_'+data.data['html'][i][0]);
                        $(dom).find('input[id*=to_show]').hide();
                    }
                }else{
                    toastr.warning(data.msg, 'Warning');
                }
                $("body").css("cursor", "default");
            },
            error: function (xhr, ajaxOptions, thrownError) {}
        });
    });
    $(document).on("submit", "#coupon_form", function(e) {
        $('#submit').attr('disabled',true);
        var values = $('#input_values').val();
        // if ($('#input_values').val().length == 0) {
        //     toastr.warning('Please choose at least one option !', 'Warning');
        //     $('#submit').attr('disabled',false);
        //     return false;
        // }
    });

</script>
@endpush('custom_js')
