@extends('admin.layout.master')
@push('custom_css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush

@section('pending_master','active')
@section('Product Management','open')

@section('title') Pending Product master @endsection
@section('page-name') Pending Product master @endsection


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('product.breadcrumb_title') </a></li>
    <li class="breadcrumb-item active">@lang('product.breadcrumb_sub_title')</li>
@endsection

@php
    $roles = userRolePermissionArray();
@endphp

@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-sm card-success">
                        <div class="card-header">

                            @if(hasAccessAbility('view_pending_master', $roles))
                            <a class="btn btn-sm btn-info text-white {{ request()->get('status') == 'pending' ? 'active' : '' }}" href="{{ route('admin.product.pending') }}" title="PENDING PRODUCT MASTER"> Pending List ({{ getPendingProduct() }})</a>
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
                                    <table class="table table-striped table-bordered  table-sm" id="process_data_table">
                                        <thead>
                                        <tr>
                                            <th class="text-center">@lang('tablehead.sl')</th>
                                            <th>@lang('tablehead.category')</th>
                                            <th>@lang('tablehead.brand')</th>
                                            <th>@lang('tablehead.model')</th>
                                            <th>@lang('tablehead.name')</th>
                                            <th class="text-center">@lang('tablehead.image')</th>
                                            <th class="text-center">Entry By</th>
                                            <th style="width: 120px;" class="text-center" >@lang('tablehead.action')</th>
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
@endsection

@push('custom_js')
<script src="{{ asset('assets/js/scripts/tooltip/tooltip.js')}}"></script>
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var get_url = $('#base_url').val();
    $(document).ready(function() {
        var value = getCookie('product_list');
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
        var status = `{{ request()->get('status') }}`;
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
                url: get_url+'/product/pending_master',
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
                    data: 'category',
                    name: 'category',
                    searchable: true
                },
                {
                    data: 'BRAND_NAME',
                    name: 'BRAND_NAME',
                    searchable: true,
                },
                {
                    data: 'MODEL_NAME',
                    name: 'MODEL_NAME',
                    searchable: true,
                },
                {
                    data: 'DEFAULT_NAME',
                    name: 'DEFAULT_NAME',
                    searchable: true,
                    className: 'text-left',
                },
                {
                    data: 'image',
                    name: 'image',
                    searchable: false,
                    className: 'text-center'

                },
                {
                    data: 'entry_by',
                    name: 'entry_by',
                    searchable: false,
                    className: 'text-left'
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
        setCookie('product_list',pageNum);
    });

    function setCookie(product_list,pageNum) {
        var today = new Date();
        var name = product_list;
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
