@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
@endpush

@section('Customer Management','open')
@section('customer_list','active')


@section('title')
    @lang('customer.list_page_title')
@endsection

@section('page-name')
    @lang('customer.list_page_sub_title')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">@lang('customer.breadcrumb_title')    </a>
    </li>
    <li class="breadcrumb-item active">@lang('customer.breadcrumb_sub_title')
    </li>
@endsection

@php
    $roles = userRolePermissionArray()
@endphp

@section('content')
    <div class="content-body">
        <section id="pagination">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-sm">
                        <div class="card-header">

                            @if(hasAccessAbility('new_role', $roles))
                            <a class="btn btn-sm btn-primary text-white" href="{{route('admin.customer.create')}}" title="ADD NEW PRODUCT CUSTOMER"><i class="ft-plus text-white"></i> @lang('customer.customer_create_btn')</a>
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
                                            <th>@lang('tablehead.tbl_head_email')</th>
                                            <th>@lang('tablehead.tbl_head_phn_no')</th>
                                            <th>@lang('tablehead.customer_under')</th>
                                            <th style="width: 120px;" class="text-center">@lang('tablehead.action')</th>
                                        </tr>
                                        </thead>
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

<script src="http://coxsbazarpolice.gov.bd/tms/js/jquery3.3.1.js"></script>
<script src="http://coxsbazarpolice.gov.bd/tms/js/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var table =
            $('#process_data_table').DataTable({
                processing: false,
                serverSide: true,
                paging: true,
                pageLength: 10,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                ajax: {
                    url: 'all_guest_filter_data',
                    type: 'POST',
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [
                    {
                        data: 'PK_NO',
                        name: 'c.PK_NO',
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'NAME',
                        name: 'c.NAME',
                        searchable: true
                    },
                    {
                        data: 'EMAIL',
                        name: 'c.EMAIL',
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
                        name: 'c.MOBILE_NO',
                        searchable: true,
                    },
                    {
                        data: 'seller',
                        name: 'r.NAME',
                        searchable: true,
                        render: function(data, type, row) {
                            if (row.seller == null) {
                                return 'Easybazar';
                            } else {
                                return row.seller;
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false
                    },
                ]
            });
        });
    </script>
