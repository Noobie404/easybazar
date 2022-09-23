@extends('admin.layout.master')
@section('Dispatch Management','open')
@section('item_return_request_list','active')
@section('title') Product Return @endsection
@section('page-name') Product Return @endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('order.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">Return Request </li>
@endsection
@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/extensions/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush
@php
    $roles = userRolePermissionArray();
    $return_condition = Config('static_array.return_condition');
    $return_reason = $data['return_reason'] ?? [];
    $rows = $data['rows'] ?? [];
@endphp
@section('content')
<div class="card card-success min-height">
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="table-responsive ">
                <table class="table table-striped table-bordered table-sm" id="process_data_table">
                    <thead>
                    <tr>
                        <th class="text-center">@lang('tablehead.sl')</th>
                        <th>Order No</th>
                        <th>Customer</th>
                        <th>Product Name</th>
                        <th>Request At</th>
                        <th>Request By</th>
                        <th>Request Note</th>
                        <th>Amount to be Credit</th>
                        <th>Attachment</th>
                        <th>Request Condition</th>
                        <th style="width: 100px;" class="text-center">@lang('tablehead.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(isset($rows) && count($rows))
                        @foreach($rows as $key => $row )
                        <tr class="item{{ $row->PK_NO }}">
                            <td>{{ $key+1 }}</td>
                            <td>{{ $row->BOOKING_NO }}</td>
                            <td>{{ $row->CUSTOMER_NAME }}</td>
                            <td> {{$row->VARIANT_NAME}}</td>
                            <td>{{ date('d, M Y h:i A', strtotime($row->REQUEST_AT)) }}</td>
                            <td>{{ $row->REQUESTED_BY }}</td>
                            <td>{{ $row->RETURN_NOTE }}</td>
                            <td class="text-center">{{ number_format($row->CREDIT_AMT,2) }}</td>
                            <td>
                                @if($row->PHOTO_EXT)
                                    @if($row->PHOTO_EXT == 'pdf')
                                        <a href="{{ asset($row->PHOTO_PATH) }}" target="_blank">click for view</a>
                                    @else
                                       <a href="{{ asset($row->PHOTO_PATH) }}" target="_blank">
                                        <img src="{{ asset($row->PHOTO_PATH) }}" width="80">
                                       </a>
                                    @endif
                                @endif
                            </td>
                            <td>{{$return_reason[$row->RETURN_CONDITION ?? 0]}}</td>
                            <td class="text-center">
                                @if (hasAccessAbility('new_item_return', $roles))
                                <a href="#" class="btn btn-xs btn-success mb-05 confirm-return" data-id="{{$row->PK_NO}}" booking-id="{{$row->F_BOOKING_NO}}" booking-details="{{$row->F_BOOKING_DETAILS_NO}}" title="Confirm Return"><i class="la la-check-circle"></i></a>
                                <a href="{{ route('admin.order.dispatch',['id' => $row->F_BOOKING_NO, 'return_request' => 1]) }}" class="btn btn-xs btn-info mb-05" title="VIEW"><i class="la la-eye"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            {{$rows->links()}}
        </div>
    </div>
</div>
@endsection
@push('custom_js')
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script type="text/javascript">
   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var get_url = $('#base_url').val();
    $(document).on("click", ".confirm-return", function (e) {
        e.preventDefault();
        var return_id = $(this).data('id');
        var booking_id = $(this).attr('booking-id');
        var booking_details_id = $(this).attr('booking-details');

        var x = confirm("Are you sure you want to confirm return?");
        if (x) {
            $(".fa-spinner").fadeIn("slow");
            $.ajax({
                type:'POST',
                url:get_url+'/ajax/confirm-return',
                data:{
                    return_id:return_id,
                    booking_id:booking_id,
                    booking_details_id:booking_details_id,
                },
                async :true,
                beforeSend: function () {
                $("body").css("cursor", "progress");
                },
                success: function (response) {
                    if (response.status == 1) {
                        $('.item' + return_id).remove();
                        toastr.success(response.message);
                    }else{
                        toastr.success(response.message);
                    }
                },
                error: function (jqXHR, exception) {
                    toastr.error('something wrong');
                },
                complete: function (data) {
                 $("body").css("cursor", "default");
                }
            });
            $(".fa-spinner").fadeOut("slow");
        }
    });
</script>
@endpush

