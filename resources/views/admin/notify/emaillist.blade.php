@extends('admin.layout.master')
@push('custom_css')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}"> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush
@section('notify_email','active')

@section('title')Notification Email @endsection
@section('page-name')Notification Email @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('form.dashboard') </a></li>
    <li class="breadcrumb-item active">Notification Email</li>
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
                        <div class="card-header pb-0">
                            <div class="form-group">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('admin.notify_email.list',['type' => 'success','filter' => 'Order Create']) }}" class="btn btn-success btn-sm {{ request()->get('type') == 'success' ? 'active' : '' }}"><i class="la la-list-ol"></i> Success</a>
                                    <a href="{{ route('admin.notify_email.list',['type' => 'pending','filter' => 'Order Create']) }}" class="btn btn-success btn-sm  {{ request()->get('type') != 'success' ? 'active' : '' }}"><i class="la la-th-list"></i> Pending</a>
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
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <a href="{{ route('admin.notify_email.list',[ 'type' => request()->type,'filter' => 'Order Create']) }}" class="btn btn-xs btn-success c-btn {{ request()->get('filter') == 'Order Create' ? 'active' : ''}} " style="min-width:90px;">Order Create</a>
                                        <a href="{{ route('admin.notify_email.list',[ 'type' => request()->type,'filter' => 'Order Payment' ]) }}" class="btn btn-xs btn-success c-btn {{ request()->get('filter') == 'Order Payment' ? 'active' : ''}} " style="min-width:90px;">Order Payment</a>
                                        <a href="{{ route('admin.notify_email.list',[ 'type' => request()->type,'filter' => 'Payment Confirmation' ]) }}" class="btn btn-xs btn-success c-btn {{ request()->get('filter') == 'Payment Confirmation' ? 'active' : ''}} " style="min-width:90px;">Payment Confirmation</a>
                                        <a href="{{ route('admin.notify_email.list',[ 'type' => request()->type,'filter' => 'Arrival' ]) }}" class="btn btn-xs btn-success c-btn {{ request()->get('filter') == 'Arrival' ? 'active' : ''}} " style="min-width:90px;">Arrival</a>
                                        <a href="{{ route('admin.notify_email.list',[ 'type' => request()->type,'filter' => 'Return' ]) }}" class="btn btn-xs btn-success c-btn {{ request()->get('filter') == 'Return' ? 'active' : ''}} " style="min-width:90px;">Return</a>
                                        <a href="{{ route('admin.notify_email.list',[ 'type' => request()->type,'filter' => 'Dispatch' ]) }}" class="btn btn-xs btn-success c-btn {{ request()->get('filter') == 'Dispatch' ? 'active' : ''}} " style="min-width:90px;">Dispatch</a>
                                        <a href="{{ route('admin.notify_email.list',[ 'type' => request()->type,'filter' => 'Default' ]) }}" class="btn btn-xs btn-success c-btn {{ request()->get('filter') == 'Default' ? 'active' : ''}} " style="min-width:90px;">Default</a>
                                      </div>
                                </div>
                                <hr>
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-bordered table-sm" id="process_data_table">
                                        <thead>
                                            <tr>
                                                <th style="width: 40px;">Sl.</th>
                                                <th style="width: 40px;">Type</th>
                                                <th class="" style="width: 100px;">Name</th>
                                                <th class="" style="width: 100px;">Email</th>
                                                <th class="" style="width: 100px;">Order ID</th>
                                                {{-- <th> SMS</th> --}}
                                                <th style="width: 150px;" class="text-center">Mobile</th>
                                                <th style="width: 50px;" class="text-center">IS Send</th>
                                                <th style="width: 140px;" class="text-center">Time</th>
                                                <th style="width: 80px;">Active</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @if($rows && count($rows) > 0 )
                                                @foreach($rows as $key => $row )
                                                    <tr>
                                                        <td style="width: 40px;">{{ $key+1 }}</td>
                                                        <td style="width: 40px;">{{ $row->TYPE }}</td>
                                                        <td style="width: 100px;">
                                                            @if(isset($row->customer->NAME))
                                                            <a href="{{ route('admin.customer.view',[$row->customer->PK_NO]) }}" class="link" title="VIEW">{{  $row->customer->NAME  }}</a>
                                                            @endif
                                                            @if(isset($row->reseller->NAME))
                                                            <a href="{{ route('admin.reseller.edit', [$row->reseller->PK_NO]) }}" title="VIEW" class="link">
                                                            {{ $row->reseller->NAME  }}
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td>{{ $row->EMAIL }}</td>
                                                        <td style="width: 100px;">

                                                            <a href="{{ route("admin.order.view", [$row->booking->PK_NO ?? 0 ]) }}" target="_blank" class="link" title="VIEW ORDER">@if($row->booking){{ '#ORD-'.$row->booking->BOOKING_NO ?? 0 }}@endif</a>

                                                        </td>
                                                        <td style="width: 150px;" class="text-center">{{ $row->MOBILE_NO }}</td>
                                                        <td style="width: 50px;" class="text-center">{{ $row->IS_SEND == 1 ? 'Yes' : 'No' }}</td>
                                                        <td style="width: 140px;" class="text-center">
                                                            @if($row->SS_CREATED_ON)
                                                                <div title="Generated">
                                                                    {{ date('d-m-y h:i A',strtotime($row->SS_CREATED_ON)) }}
                                                                </div>
                                                            @endif
                                                            @if($row->SEND_AT)
                                                                <div style="border-top: 1px solid #eee;" title="Sent At">{{ date('d-m-y h:i A',strtotime($row->SEND_AT)) }}</div>
                                                            @endif
                                                        </td>
                                                        <td style="width: 80px;" class="text-center">
                                                            <a href="{{ route('admin.notify_email.body', [$row->PK_NO]) }}" title="VIEW EMAIL" class="btn btn-xs btn-primary mr-05" target="_blank"><i class="la la-eye"></i></a>
                                                            @if($row->IS_SEND == 0)
                                                            @else

                                                            @endif
                                                            <a href="{{ route('admin.notify_email.send', [$row->PK_NO]) }}" title="SEND SMS" class="btn btn-xs btn-primary mr-05"><i class="la la-send"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif --}}
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
    // var value = getCookie('email_list');

    // if (value !== null ) {
    //     var value = (value-1)*10;
    // }else{
    //     var value = 0;
    // }
    var value = 0;
    var table = callDatatable(value);
});

function callDatatable(value) {
    var get_url = $('#base_url').val();
    var status = `{{ request()->get('type') }}`;
    var filter = `{{ request()->get('filter') }}`;
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
            url: get_url+'/notification/email/list',
            type: 'POST',
            data: function(d) {
                d._token = "{{ csrf_token() }}";
                d.status = status;
                d.filter = filter;
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
                data: 'email',
                name: 'email',
                searchable: true
            },
            {
                data: 'ORDER_ID',
                name: 'ORDER_ID',
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

// $(document).on('click','.page-link', function(){
//     var pageNum = $(this).text();
//     setCookie('email_list',pageNum);
// });

function setCookie(email_list,pageNum) {
    var today = new Date();
    var name = email_list;
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
