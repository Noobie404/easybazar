@extends('admin.layout.master')
@section('Sales Report','open')
@section('top_sell','active')
@section('title') Top Sell @endsection
@section('page-name') Top Sell @endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('shipping.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">Top Sell </li>
@endsection
@php
    $roles = userRolePermissionArray();
    use Carbon\Carbon;
    $tabindex = 1;
@endphp
@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush('custom_css')
@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <div class="form-group">
                                @if(hasAccessAbility('new_top_sell', $roles))
                                    <button class="text-white btn btn-sm btn-primary" title="Add new " data-toggle="modal" data-target="#addNewTopSell" ><i class="ft-plus text-white"></i> Create New</button>
                                @endif
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
                            <div class="card-body card-dashboard">
                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-bordered table-sm" id="process_data_table_">
                                        <thead>
                                        <tr>
                                            <th class=" text-center">SL.</th>
                                            <th>Branch</th>
                                            <th>Start date</th>
                                            <th>To date</th>
                                            <th>PDF</th>
                                            <th class="text-center">Max variant</th>
                                            <th style="width: 11%" class="text-center">@lang('tablehead.tbl_head_action')</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

<div class="modal fade text-left" id="addNewTopSell" tabindex="-1" role="dialog" aria-labelledby="category_name" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="category_name">Generate top sell</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open([ 'route' => 'admin.top_sell.create', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group {!! $errors->has('branch_id') ? 'error' : '' !!}">
                                <label>Select Branch<span class="text-danger">*</span></label>
                                <div class="controls">
                                    {!! Form::select('branch_id', $data['branch'], null, [ 'class' => 'form-control mb-1 select2', 'placeholder' => 'Please select', 'data-validation-required-message' => 'This field is required', 'tabindex' =>$tabindex++, 'id' => 'branch_id', 'onchange' => "getPurchaser(this)", 'required'  ]) !!}
                                    {!! $errors->first('branch_id', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="from_date">From Date<span class="text-danger">*</span></label>
                                <div class="controls">
                                <input type="text" id="from_date" class="form-control pickadate" name="from_date" title="" value="" data-validation-required-message ="This field is required" required tabindex="{{ $tabindex++ }}">
                                {!! $errors->first('from_date', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="to_date">To Date<span class="text-danger">*</span></label>
                                <div class="controls">
                                <input type="text" id="to_date" class="form-control pickadate" name="to_date" title="" value="{{ date('d-m-Y') }}" data-validation-required-message ="This field is required" tabindex="{{ $tabindex++ }}">
                                {!! $errors->first('to_date', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="max_variant">Max Product<span class="text-danger">*</span></label>
                                <div class="controls">
                                <input type="text" id="max_variant" class="form-control" name="max_variant" title="" value="" data-validation-required-message ="This field is required" tabindex="{{ $tabindex++ }}">
                                {!! $errors->first('max_variant', '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="reset" class="btn btn-secondary btn-sm" data-dismiss="modal" value="Close" title="Close">
                    <input type="submit" class="btn btn-primary btn-sm submit-btn" value="Generate" title="Update">
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@push('custom_js')
<!-- BEGIN: Data Table-->
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<!-- END: Data Table-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script>
    // Use datepicker on the date inputs
    $('.pickadate').pickadate({
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy',
        //max:!0,
    });
</script>
<script>
    $(document).ready(function() {
        var table =
            $('#process_data_table_').DataTable({
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
                    url: `{{ URL::to('get_top_sell') }}`,
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
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                            class: 'text-center',
                        },
                        {
                            data: 'SHOP_NAME',
                            name: 'SHOP_NAME',
                            searchable: true
                        },
                        {
                            data: 'from_date',
                            name: 'FROM_DATE',
                            searchable: true
                        },
                        {
                            data: 'to_date',
                            name: 'TO_DATE',
                            searchable: true,
                        },
                        {
                            data: 'pdf_path',
                            name: 'PDF_PATH',
                            searchable: false
                        },
                        {
                            data: 'MAX_VARIANT',
                            name: 'MAX_VARIANT',
                            searchable: false,
                            class: 'text-center',
                        },

                        {
                            data: 'action',
                            name: 'action',
                            searchable: false,
                            class: 'text-center',
                        }
                ]
            });
    });
</script>
@endpush
