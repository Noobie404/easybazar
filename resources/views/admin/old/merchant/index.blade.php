@extends('admin.layout.master')

@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush

@section('Customer Management','open')
@section('merchant_list','active')

@section('title') Merchant @endsection
@section('page-name') Merchant @endsection

@push('custom_js')
    <script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('/app-assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">@lang('customer.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">Merchant</li>
@endsection

@php
    $roles = userRolePermissionArray();
@endphp


@push('custom_css')

    <style>
        #scrollable-dropdown-menu .tt-menu {max-height: 260px;overflow-y: auto;width: 100%;border: 1px solid #333;border-radius: 5px;}
        #scrollable-dropdown-menu2 .tt-menu {max-height: 260px;overflow-y: auto;width: 100%;border: 1px solid #333;border-radius: 5px;}
        .twitter-typeahead{display: block !important;}
        #warehouse th, #availble_qty th {border: none;border-bottom: 1px solid #333;font-size: 12px;font-weight: normal;padding-bottom: 7px;    padding-bottom: 11px;}
        #book_qty th { border: none;font-size: 12px;font-weight: normal;padding-bottom: 5px;padding-top: 0;}
        .tt-hint {color: #999 !important;}
    </style>

@endpush('custom_css')

@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-sm card-success">
                        <div class="card-header">

                            @if(hasAccessAbility('new_merchant', $roles))
                            <a class="btn btn-sm btn-primary" href="{{route('admin.merchant.create')}}" title="ADD NEW MERCHANT"><i class="ft-plus text-white"></i> Add Merchant</a>
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
                                            <th>@lang('tablehead.tbl_head_name')</th>
                                            <th>Merchant No</th>
                                            <th>@lang('tablehead.tbl_head_email')</th>
                                            <th>@lang('tablehead.tbl_head_phn_no')</th>
                                            <th title="Total Purchanse">Total Purchanse(GBP)</th>
                                            <th title="Total Purchanse">Total Purchanse(GBP) <br> By using merchant price </th>
                                            <th title="All payments">All Payments Received(GBP)</th>
                                            <th>Due(GBP)</th>
                                            <th title="Customer actual credit balanc">Credit(GBP)</th>
                                            <th style="width: 15%" class="text-center">@lang('tablehead.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($data['rows']) && count($data['rows']) > 0 )
                                            @foreach($data['rows'] as $key => $row )
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $row->NAME }} ({{ $row->SHORT_NAME }})</td>
                                                <td>{{ $row->MERCHANT_NO }}</td>
                                                <td>{{ $row->EMAIL }}</td>
                                                <td>{{ $row->MOBILE_NO }}</td>

                                                <td class="text-right">{{ number_format($row->CUM_ORDERS_VAL,2) }}</td>

                                                <td class="text-right">{{ number_format($row->MER_CUM_ORDERS_VAL,2) }}</td>
                                                <td class="text-right">{{ number_format($row->CUSTOMER_BALANCE_ACTUAL,2) }}</td>
                                                <td>{{ number_format($row->MER_CUM_ORDERS_VAL - $row->CUSTOMER_BALANCE_ACTUAL,2) }}</td>
                                                <td>{{ number_format($row->CUM_BALANCE,2) }}</td>
                                                <td>
                                                    @if(hasAccessAbility('edit_merchant', $roles))
                                                    <a href="{{ route('admin.merchant.edit', ['id' => $row->PK_NO]) }}" class="btn btn-xs btn-info mb-05 mr-05" title="EDIT"><i class="la la-edit"></i></a>
                                                    @endif
                                                    <a href="" class="btn btn-xs btn-success mb-05 mr-05" title="VIEW"><i class="la la-eye"></i></a>

                                                    @if(hasAccessAbility('new_merchant_payment', $roles))
                                                    <a href="{{ route('merchant.payment.create',['id' => $row->PK_NO]) }}" class="btn btn-xs btn-primary mb-05 mr-05" title="Add new payment"><i class="la la-usd"></i></a>
                                                    @endif

                                                    <a href="" class="btn btn-xs btn-success mb-05 mr-05" title="ALL HISTORY">&nbsp;H&nbsp;</a>
                                                </td>


                                            </tr>
                                            @endforeach
                                            @endif
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

    <div class="modal animated zoomIn text-left balanceTrans" tabindex="-1" role="dialog" aria-labelledby="balanceTrans" aria-hidden="true" id="balanceTrans">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-content">
                {!! Form::open([ 'route' => 'admin.customer.blance_transfer', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate','id' => 'balanceTransFrm']) !!}
                <input type="hidden" name="from_customer" value="" id="from_customer" />
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel23"><i class="la la-tree"></i> Balance Transfer from <span id="customer_name"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
              <div class="modal-body">

                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('payment_no') ? 'error' : '' !!}">
                            <label>Customer Balance</label>
                            <div class="controls">
                                {!! Form::select('payment_no', [], null, ['class'=>'form-control mb-1 ', 'data-validation-required-message' => 'This field is required', 'id' => 'payment_no']) !!}
                                {!! $errors->first('payment_no', '<label class="help-block text-danger">:message</label>') !!}

                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">

                        <div class="form-group {!! $errors->has('to_customer') ? 'error' : '' !!}">
                            <label>To</label>
                            <div class="controls" id="scrollable-dropdown-menu2">
                                <input type="search" name="q" id="to_customer" class="form-control search_to_customer" placeholder="Enter Customer Name" autocomplete="off" required>
                                <input type="hidden" name="to_customer_hidden" id="to_customer_hidden" >
                                {!! $errors->first('to_customer', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('amount_to_trans') ? 'error' : '' !!}">
                            <label>Amount to be transfer</label>
                            <div class="controls">


                                {!! Form::number('amount_to_trans', null, ['class'=>'form-control mb-1 ', 'data-validation-required-message' => 'This field is required', 'id' => 'amount_to_trans', 'step' => '0.01']) !!}

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


@endsection

@push('custom_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var get_url = $('#base_url').val();



</script>


@endpush
