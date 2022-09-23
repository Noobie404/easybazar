
@extends('seller.layout.master')
@section('product_list','active')
@section('Product Management','open')
@section('title') Product master @endsection
@section('page-name') Product master @endsection
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('seller.dashboard') }}">@lang('product.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">@lang('product.breadcrumb_sub_title')</li>
@endsection
@php
    $roles = userRolePermissionArray()
@endphp
@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-sm card-success">
                        <div class="card-header">

                            <a class="btn btn-sm btn-info text-white" href="{{ route('seller.product.list') }}?product=all" title="PRODUCT MASTER" > Master product (EB) </a>

                            <a class="btn btn-sm btn-info text-white" href="{{ route('seller.product.list') }}?product=shop" title="PRODUCT MASTER"> Master product (Shop)</a>

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
                                            <th>@lang('tablehead.name')</th>
                                            <th class="text-center">@lang('tablehead.image')</th>
                                            <th class="text-center">Entry by</th>
                                            <th style="width: 140px;" class="text-center" >@lang('tablehead.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody id="rows_">
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
<!-- BEGIN: Data Table-->
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script src="{{asset('assets/js/scripts/tooltip/tooltip.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var get_url = $('#base_url').val();

    $(document).ready(function() {
        var prev_val;
        var value = getCookie('product_list');

        if (value !== null ) {
            var value = (value-1)*25;
        }else{
            var value = 0;
        }
        var table = callDatatable(value);
    });
    function callDatatable(value) {
        var get_url = $('#base_url').val();
        var status = `{{ request()->get('status') }}`;
        var product = `{{ request()->get('product') }}`;
        var table = $('#process_data_table').DataTable({
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
                url: get_url+'/seller/all_product',
                type: 'POST',
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.status = status;
                    d.product = product;
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
        if (table) {

        }
        return table;
    }
</script>
<script>
    $('#process_data_table').on( 'init.dt', function () {
        var product = `{{ request()->get('product') }}`;
            $('#rows_ [id*=product_check]').focus(function() {
                prev_val = $(this).val();
                console.log(prev_val);
            }).change(function(){
                $(this).blur() // Firefox fix as suggested by AgDude
                var success = confirm('Are you sure ?');
                if (success) {
                    var the = $(this);
                    var is_new = $(this).val();
                    $.ajax({
                        type:'post',
                        url: get_url+'/ajax/if-product-master-in-shop',
                        data:{
                            product_id: $(this).data('product_id'),
                            is_new: is_new,
                        },
                        dataType: 'JSON',
                        async :true,
                        beforeSend: function () {
                            $("body").css("cursor", "progress");
                        },
                        success: function (data) {
                            if(data.status == 1) {
                                toastr.success(data.msg, 'Successfull');
                                if (product == 'shop' && is_new == 0) {
                                    the.val(0);
                                    the.closest('tr').remove();
                                }
                            }else if(data.status == 0) {
                                toastr.error(data.msg, 'Error');
                                the.val(prev_val);
                            }
                        },
                        complete: function (data) {
                            $("body").css("cursor", "default");
                        }
                    });
                    return false;
                }else{
                    $(this).val(prev_val);
                    return false;
                }
            })
    })
    $(document).on('click','.page-link', function(){
        var pageNum = $(this).text();
        setCookie('seller_product_list',pageNum);
    });
    function setCookie(seller_product_list,pageNum) {
        var today = new Date();
        var name = seller_product_list;
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
