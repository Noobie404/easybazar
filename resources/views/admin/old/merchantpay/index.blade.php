@extends('admin.layout.master')

@section('Payment','open')
@section('merchant_payment_list','active')

@section('title') Merchant Payment @endsection
@section('page-name') Merchant Payment @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Payment List</li>
@endsection

@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <style>
        #scrollable-dropdown-menu .tt-menu {max-height: 260px; overflow-y: auto; width: 100%; border: 1px solid #333; border-radius: 5px;}
        .twitter-typeahead {display: block !important;}
        #indextable td{vertical-align: middle}
    </style>
@endpush

<?php
    $key = 0;
    $roles = userRolePermissionArray();
?>

@section('content')
<div class="card card-success min-height">
    <div class="card-header">
        <h4 class="card-title" id="basic-layout-colored-form-control">
            @if(hasAccessAbility('new_merchant_payment', $roles))
                <a href="{{ route('merchant.payment.create',0) }}" class="btn btn-xs btn-primary mb-05 mr-05" title="Add new payment">+ Add New Payment</a>
            @endif
        </h4>
        @if($errors->any())
        {{ implode($errors->all(':message')) }}
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
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-12 text-center">
                    <form class="form-inline" action="{{ route('merchant.payment.list') }}" style="position: relative;" method="get">
                        <div class="form-group " style="position: absolute; right:0;">
                            <div id="warehouse-filter"></div>
                        <input type="text" class="form-control" id="input-payment" name="keywords" placeholder="Search" style="min-width: 300px;" title="Search" value="{{ request()->get('keywords') }}"> &nbsp; &nbsp; &nbsp;
                        <button type="button" id="search-payment" class="btn btn-info btn-sm">Search</button> &nbsp; &nbsp; &nbsp;
                        <a href="{{ route('merchant.payment.list') }}" class="btn btn-info btn-sm">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm" id="indextable">
                    <thead>
                        <tr>
                            <th style="width: 40px;" class="text-center">Sl.</th>
                            <th class="" style="width: 80px;">Entry Date</th>
                            <th class="" style="width:100px;">Entry By</th>
                            <th style="width: 90px;">Pay Date</th>
                            <th>Merchant Name</th>
                            <th>Paid By</th>
                            <th style="width: 100px;" >Ref</th>
                            <th style="width: 100px;" class="text-center">Image</th>
                            <th style="width: 80px;">Via</th>
                            <th style="width: 80px;">Amount(GBP)</th>
                            <th style="width: 60px;" class="text-center">Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($data['rows']) && count($data['rows']) > 0 )
                            @foreach($data['rows'] as $key => $row )

                                <tr @if($row->PAYMENT_CONFIRMED_STATUS == 0 )  @endif>
                                    <td class="text-center">{{ $data['rows']->firstItem() + $key }}</td>
                                    <td style="width: 80px;" class="text-center">
                                       <div style="font-size:12px; font-weight: 600;">
                                        {{ date('d-m-Y',strtotime($row->SS_CREATED_ON)) }}
                                        </div>
                                        <div style="font-size:12px;">
                                        {{ date('h:i A',strtotime($row->SS_CREATED_ON)) }}
                                       </div>
                                       @if( ($row->IS_MATCHED == 1) && ($row->MATCHED_ON))
                                       <div style="font-size:12px; font-weight: 600; border-top: 1px solid #000;">
                                        {{ date('d-m-Y',strtotime($row->MATCHED_ON)) }}
                                        </div>
                                        <div style="font-size:12px;">
                                        {{ date('h:i A',strtotime($row->MATCHED_ON)) }}
                                       </div>
                                       @endif
                                    </td>
                                    <td style="width:100px; text-transform: uppercase;">{{ $row->entryBy->NAME ?? '' }}</td>
                                    <td>{{ date('d-m-Y', strtotime($row->PAYMENT_DATE) ) }}</td>
                                    <td class="text-uppercase">
                                        <a href="" class="font-bold">
                                            {{ $row->MERCHANT_NAME ?? ''}}
                                        </a>
                                    </td>
                                    <td class="text-uppercase">
                                         {{ $row->PAID_BY  ?? $row->MERCHANT_NAME }} </td>
                                    <td style="width:100px;">
                                        {{ $row->SLIP_NUMBER }} <br>
                                        <a href="{{ route('admin.payment.details',['id' =>  $row->PK_NO ]) }}" class="font-bold">{{ 'PAYID-'.$row->CODE ?? '' }}</a>
                                    </td>
                                    <td class="text-center" >
                                        @if($row->ATTACHMENT_PATH)
                                        <a href="{{ asset($row->ATTACHMENT_PATH) }}" target="_blank">
                                            <img src="{{ asset($row->ATTACHMENT_PATH) }}"  style="width: 60px;">
                                        </a>
                                        @endif
                                    </td>
                                    <td >
                                        {{ $row->PAYMENT_BANK_NAME }}
                                        <br>
                                        <span style="font-size:10px;">{{ $row->PAYMENT_ACCOUNT_NAME }}</span>
                                    </td>
                                    <td class="text-right">{{ number_format($row->MR_AMOUNT,2) }}</td>
                                    <td class="text-center" style="width: 5%;">
                                        @if(hasAccessAbility('view_payment', $roles))
                                        <a href="{{ route('admin.payment.details',['id' =>  $row->PK_NO ]) }}" class="btn btn-xs btn-success mr-05" title="VIEW PAYMENT"><i class="la la-eye"></i></a>
                                        @endif
                                        @if(hasAccessAbility('delete_payment', $roles))
                                        @if($row->IS_COD == 0)
                                        <a href="{{ route('admin.payment.delete',['id' =>  $row->PK_NO ?? 0]) }}" class="btn btn-xs btn-danger mr-05" title="DELETE PAYMENT" onclick="return confirm('Are you sure want to delete this?');"><i class="la la-trash"></i></a>
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="11" align="center">No data record found</td>
                        </tr>
                        @endif
                    </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="pagination">
                        {{ $data['rows']->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-success btn-min-width mr-1 mb-1"><i class="la la-backward" ></i> Back</a>
        </div>
    </div>

</div>
@endsection

@push('custom_js')

    <script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('/app-assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
    <script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/file_upload/image-uploader.min.js')}}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>

    <script>
        $('.pickadate').pickadate({
            format: 'dd-mm-yyyy',
            formatSubmit: 'dd-mm-yyyy',
        });
        $(document).on('click','#search-payment',function(){
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('keywords', $('#input-payment').val());
            window.location.search = urlParams;
        })
    </script>

@endpush('custom_js')
