@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush
@section('notify_sms','active')

@section('title')Notification SMS @endsection
@section('page-name')Notification SMS @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('form.dashboard') </a></li>
    <li class="breadcrumb-item active">Notification SMS</li>
@endsection
@php
    $roles = userRolePermissionArray();
@endphp

@push('custom_js')
<!-- BEGIN: Data Table-->
<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/app-assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<!-- END: Data Table-->
@endpush

@section('content')
    <!-- Alternative pagination table -->
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <div class="form-group">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-success btn-sm  {{ request()->get('type') != 'success' ? 'active' : '' }}">
                                        <a href="{{ route('admin.notify_sms.list') }}"><i class="la la-th-list"></i> Pending</a>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm {{ request()->get('type') == 'success' ? 'active' : '' }}"><a href="{{ route('admin.notify_sms.list',['type' => 'success']) }}"><i class="la la-list-ol"></i> Success</a></button>
                                    {{-- <a href="{{ URL::to('api/notification/all_notify_sms/send') }}" class="btn btn-sm btn-info">Send All Pending SMS</a> --}}
                                </div>
                            </div>
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
                            <div class="card-body card-dashboard ">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered  table-sm" id="process_data_table">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;">Sl.</th>
                                                <th style="width: 40px;">Type</th>
                                                <th class="" style="width: 100px;">Name</th>
                                                <th class="" style="width: 100px;">Order ID</th>
                                                <th> SMS</th>
                                                <th style="width: 150px;" class="text-center">Mobile</th>
                                                <th style="width: 50px;" class="text-center">IS Send</th>
                                                <th style="width: 140px;" class="text-center">Time</th>
                                                <th style="width: 80px;">Active</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</div>


      @include('admin.account._account_edit_modal')

    <!--/ Alternative pagination table -->
@endsection
@push('custom_js')
<!--script only for brand page-->
<script type="text/javascript" src="{{ asset('assets/pages/account.js')}}"></script>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var get_url = $('#base_url').val();

$(document).ready(function() {
    var value = getCookie('notification_list');

    if (value !== null ) {
        var value = (value-1)*10;
        // table.fnPageChange(value,true);
    }else{
        var value = 0;
    }
    var table = callDatatable(value);

});

function callDatatable(value) {
    var get_url = $('#base_url').val();
    var status = `{{ request()->get('type') }}`;
    var table = $('#process_data_table').dataTable({
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
        ajax: {
            url: get_url+'/notification/all_notification',
            type: 'POST',
            data: function(d) {
                d._token = "{{ csrf_token() }}";
                d.status = status;
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
                data: 'type',
                name: 'type',
                searchable: true
            },
            {
                data: 'name',
                name: 'name',
                searchable: true
            },
            {
                data: 'ORDER_ID',
                name: 'ORDER_ID',
                searchable: true,
            },

            {
                data: 'SMS',
                name: 'SMS',
                searchable: true,
            },
            {
                data: 'MOBILE',
                name: 'MOBILE',
                searchable: true,
                className: 'text-center',
            },

            {
                data: 'IS_SEND',
                name: 'IS_SEND',
                searchable: false,
                className: 'text-center'

            },
            {
                data: 'time',
                name: 'time',
                searchable: false,
                className: 'text-center'

            },

            {
                data: 'active',
                name: 'active',
                searchable: false,
                className: 'text-center'
            },

        ]
    });
    return table;
}

// Pagination //

$(document).on('click','.page-link', function(){
    var pageNum = $(this).text();
    setCookie('notification_list',pageNum);
});

function setCookie(notification_list,pageNum) {
    var today = new Date();
    var name = notification_list;
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

@endpush('custom_js')
