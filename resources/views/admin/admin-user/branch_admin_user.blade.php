@extends('admin.layout.master')

@section('Admin Mangement','Open')
@section('branch-admin','active')

@section('title') Branch user | List @endsection
@section('page-name') Branch user | List @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('invoice.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">@lang('reseller.breadcrumb_sub_title')</li>
@endsection

@php
    $roles = userRolePermissionArray();
    $user_group = getOptionsData('SA_USER_GROUP',['GROUP_FOR' => 1],'PK_NO','GROUP_NAME');
    $tabindex = 1;
@endphp


@push('custom_css')

{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}"> --}}
<style>
    #scrollable-dropdown-menu .tt-menu{max-height:260px;overflow-y:auto;width:100%;border:1px solid #333;border-radius:5px}#scrollable-dropdown-menu2 .tt-menu{max-height:260px;overflow-y:auto;width:100%;border:1px solid #333;border-radius:5px}.twitter-typeahead{display:block!important}#availble_qty th,#warehouse th{border:none;border-bottom:1px solid #333;font-size:12px;font-weight:400;padding-bottom:7px;padding-bottom:11px}#book_qty th{border:none;font-size:12px;font-weight:400;padding-bottom:5px;padding-top:0}.tt-hint{color:#999!important}
</style>
@endpush('custom_css')

@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-sm card-success">
                        <div class="card-header">

                            @if(hasAccessAbility('new_seller', $roles))
                            <a href="#sellerUser" data-target="#sellerUser" data-toggle="modal" class="btn btn-sm btn-primary text-white add_new_user" title="Add new user" data-keyboard="false" data-backdrop="static" ><i class="ft-plus text-white"></i>Add branch user</a>
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
                                <div class="table-responsive ">
                                    <table class="table table-striped table-bordered table-sm" id="process_data_table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">@lang('tablehead.sl')</th>
                                                <th>Branch</th>
                                                <th>@sortablelink('F_USER_GROUP_NO', 'User group')</th>
                                                <th>@sortablelink('USERNAME', 'Name')</th>
                                                <th>Mobile</th>
                                                <th>Email </th>
                                                <th>@sortablelink('DESIGNATION', 'Designation') </th>
                                                <th title="All payments">@sortablelink('CREATED_AT', 'Reg. date')</th>
                                                <th>@sortablelink('STATUS', 'Status')  </th>
                                                <th style="width: 150px;" class="text-center">@lang('tablehead.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset( $data['rows']) && count($data['rows']) > 0 )
                                                @foreach( $data['rows'] as $k => $row )
                                                    <tr>
                                                        <td class="text-center">{{ $k+1 }}</td>
                                                        <td>{{ $data['seller']->SHOP_NAME ?? '' }}</td>
                                                        <td>{{ $row->GROUP_NAME ?? '' }}</td>
                                                        <td>{{ $row->NAME }}</td>
                                                        <td>{{ $row->MOBILE_NO }}</td>
                                                        <td>
                                                            <p>{{ $row->EMAIL }}</p>

                                                        </td>
                                                        <td>{{ $row->DESIGNATION }}</td>
                                                        <td>
                                                            {{ date('d M, Y', strtotime($row->CREATED_AT)) }}
                                                        </td>
                                                        <td>
                                                            {{ $row->STATUS == 1 ? 'Active' : 'Inactive' }}
                                                        </td>
                                                        <td class="text-center">

                                                            @if(hasAccessAbility('new_seller', $roles))
                                                                <a href="#sellerUser"
                                                                 data-target="#sellerUser"
                                                                 data-toggle="modal"
                                                                data-username="{{ $row->NAME }}"
                                                                data-mobile_no="{{ $row->MOBILE_NO }}"
                                                                data-email="{{ $row->EMAIL }}"
                                                                data-status="{{ $row->STATUS }}"
                                                                data-designation="{{ $row->DESIGNATION }}"
                                                                data-user_group_no="{{ $row->F_GROUP_NO }}"

                                                                data-pk_no="{{ $row->PK_NO }}"
                                                                class="btn btn-xs btn-info mb-05 mr-05 edit_user"
                                                                title="Edit user"><i class="la la-edit"></i></a>
                                                            @endif

                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                    @if(isset( $data['rows']) && count($data['rows']) > 0 )
                                    {!! $data['rows']->appends(\Request::except('page'))->render() !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <div class="modal animated zoomIn text-left sellerUser" tabindex="-1" role="dialog" aria-labelledby="sellerUser"
    aria-hidden="true" id="sellerUser">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-content">
                {!! Form::open([ 'route' => 'admin.seller.user_store', 'method' => 'post', 'class' =>
                'form-horizontal', 'files' => true ,'id' => 'sellerUserFrm']) !!}
                <input type="hidden" name="seller_id" value="{{ $data['seller']->PK_NO }}" />
                <input type="hidden" name="user_id" value="" id="user_id" />
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel23"><i class="la la-tree"></i> Branch user </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" tabindex="{{ $tabindex++ }}">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('user_group_id') ? 'error' : '' !!}">
                            <label>User group<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('user_group_id', $user_group ?? [] , null, ['class'=>'form-control mb-1 ','placeholder' => 'Select user group','required','data-validation-required-message' => 'This field is required', 'id' => 'user_group_id', 'tabindex' => $tabindex++ ]) !!}
                                {!! $errors->first('user_group_id', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                            <label>Name<span class="text-danger">*</span></label>
                            <div class="controls" >
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" autocomplete="off" required tabindex="{{ $tabindex++ }}">
                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('designation') ? 'error' : '' !!}">
                            <label>Designation<span class="text-danger">*</span></label>
                            <div class="controls" >
                                <input type="text" name="designation" id="designation" class="form-control" placeholder="Designation" autocomplete="off" required tabindex="{{ $tabindex++ }}">
                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('mobile_no') ? 'error' : '' !!}">
                            <label>Mobile No<span class="text-danger">*</span></label>
                            <div class="controls">
                                <input type="text" name="mobile_no" id="mobile_no" class="form-control" placeholder="Identification Number" autocomplete="off" required tabindex="{{ $tabindex++ }}">
                                {!! $errors->first('mobile_no', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('email') ? 'error' : '' !!}">
                            <label>Email<span class="text-danger">*</span></label>
                            <div class="controls">
                                <input type="email" name="email" id="email" class="form-control" placeholder="Identification Number" autocomplete="off" required tabindex="{{ $tabindex++ }}">
                                {!! $errors->first('email', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('password') ? 'error' : '' !!}">
                            <label>Password<span class="text-danger">*</span></label>
                            <div class="controls">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off" tabindex="{{ $tabindex++ }}">
                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Status</label>
                            <div class="controls">
                                {!! Form::select('status', ['1' => 'Yes', '0' => 'No'], null, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Select status', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++, 'id' => 'status']) !!}
                                {!! $errors->first('status', '<label class="help-block text-danger">:message</label>') !!}
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm grey btn-secondary" data-dismiss="modal" title="Close" tabindex="{{ $tabindex++ }}"><i class="ft-x"></i> Close</button>
                    <button type="submit" class="btn btn-sm btn-primary" value="request" name="submit" title="Submit" onclick="return confirm('Are you sure?')" tabindex="{{ $tabindex++ }}" >Submit</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection
@push('custom_js')
{{-- <script src="{{asset('/assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script> --}}
<script type="text/javascript">

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var get_url = $('#base_url').val();

$(document).on('click', '.edit_user', function(e){
    var pk_no           = $(this).data('pk_no');
    var username        = $(this).data('username');
    var mobile_no       = $(this).data('mobile_no');
    var email           = $(this).data('email');
    var status          = $(this).data('status');
    var user_group_no   = $(this).data('user_group_no');
    var designation   = $(this).data('designation');
    $('#user_id').val(pk_no);
    $('#name').val(username);
    $('#mobile_no').val(mobile_no);
    $('#email').val(email);
    $('#status').val(status);
    $('#user_group_id').val(user_group_no);
    $('#designation').val(designation);
    $('#password').removeAttr('required');
})

$(document).on('click', '.add_new_user', function(e){
    $('#password').attr('required', 'true');
})



/*

jQuery(document).ready(function($) {
    typeahead('customer');
})

$('#scrollable-dropdown-menu2 .search_to_customer').bind('typeahead:select', function(ev, suggestion) {
        $('#to_customer_hidden').val(suggestion.pk_no1);

});

function typeahead(type) {
    var get_url = $('#base_url').val();
    var engine = new Bloodhound({
        remote: {
            url: get_url+'/get-customer-info?q=%QUERY%&type='+type,
            wildcard: '%QUERY%'
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });

    $(".search_to_customer").typeahead({
        hint: true,
        highlight: true,
        minLength: 1,

    }, {
        source: engine.ttAdapter(),
        // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
        display: 'NAME',
        limit: 20,

        // the key from the array we want to display (name,id,email,etc...)
        templates: {
            // empty: [
            //     // '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
            // ],
            empty: function(context){
                $(".tt-dataset").html('<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>');

            },
            header: [
                '<div class="list-group search-results-dropdown">'
            ],
            suggestion: function (data) {
                if (type == 'customer') {
                        return '<span class="list-group-item" style="cursor: pointer;" data-id="'+data.pk_no1+'" >' + data.NAME +'- Mobile : '+ data.MOBILE_NO +'- ID : '+ data.CUSTOMER_NO +'</span>';

                }else{
                    return '<span class="list-group-item" style="cursor: pointer;" data-id="'+data.pk_no1+'" >' + data.NAME +'- Mobile : '+ data.MOBILE_NO +'- ID : '+ data.RESELLER_NO +'</span>';

                }
            },
            updater: function (data) {
            //print the id to developer tool's console
            console.log(data);
            }
        }
    });
}

$(document).on('click', '.balanceTransBtn', function(e){
    var id = $(this).data('id');
    var pageurl = get_url+'/get/'+id+'/remainingcustomerbalance';
    $.ajax({
        type:'get',
        url:pageurl,
        async :true,
        beforeSend: function () {
            $("body").css("cursor", "progress");
        },
        success: function (data) {
            console.log(data);
            if(data != '' ){
                $('#payment_no').html(data);

            } else {
                $('#payment_no').html("<option value=''>data not found</option>");
            }

        },
        complete: function (data) {
            $("body").css("cursor", "default");

        }
    });

    var name = $(this).data('name');
    var payment_no = $(this).data('payment_no');
    $('#customer_name').text(name);
    // $('#payment_no').val(payment_no);
    $('#from_customer').val(id);
    $('#to_customer').val('');
//    $('#amount_to_trans').attr('max', payment_no);

})

    $(document).ready(function() {
        var value = getCookie('reseller_list');

        if (value !== null) {
            var value = (value-1)*10;
            // table.fnPageChange(value,true);
        }else{
            var value = 0;
        }
        var table = callDatatable(value);

    });
    function callDatatable(value) {
        var table =
        $('#process_data_table').dataTable({
            processing: false,
            serverSide: true,
            paging: true,
            pageLength: 10,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            iDisplayStart: value,
            ajax: {
                url: 'reseller/all_reseller',
                type: 'POST',
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {
                    data: 'PK_NO',
                    name: 'PK_NO',
                    searchable: false,
                    sortable:false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'RESELLER_NO',
                    name: 'r.RESELLER_NO',
                    searchable: true,
                    className: 'text-center'
                },

                {
                    data: 'NAME',
                    name: 'r.NAME',
                    searchable: true
                },

                {
                    data: 'EMAIL',
                    name: 'r.EMAIL',
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
                    data: 'MOBILE_NO',
                    name: 'r.MOBILE_NO',
                    dial: 'c.DIAL_CODE',
                    searchable: true,
                    render: function(data, type, row) {
                        return row.DIAL_CODE+' '+row.MOBILE_NO;
                    }
                },

                {
                    data: 'total_unverified',
                    name: 'total_unverified',
                    searchable: false,
                    className: 'text-right',
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
                    name: 'r.CUM_BALANCE',
                    searchable: true,
                    className: 'text-right'

                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false
                },

            ]
        });
        return table;
    }
    */
</script>

<script>
    $(document).on('click','.page-link', function(){
        var pageNum = $(this).text();
        setCookie('reseller_list',pageNum);
    });

    function setCookie(reseller_list,pageNum) {
        var today = new Date();
        var name = reseller_list;
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
