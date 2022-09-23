@extends('admin.layout.master')

@section('Seller Management','open')
@section('seller_list','active')

@section('title') Branch | List @endsection
@section('page-name') Branch | List @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('invoice.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">@lang('reseller.breadcrumb_sub_title')</li>
@endsection

@php
    $roles = userRolePermissionArray();
    $regions = $data['regions'] ?? [];
@endphp

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">

<style>
    #scrollable-dropdown-menu .tt-menu{max-height:260px;overflow-y:auto;width:100%;border:1px solid #333;border-radius:5px}#scrollable-dropdown-menu2 .tt-menu{max-height:260px;overflow-y:auto;width:100%;border:1px solid #333;border-radius:5px}.twitter-typeahead{display:block!important}#availble_qty th,#warehouse th{border:none;border-bottom:1px solid #333;font-size:12px;font-weight:400;padding-bottom:7px;padding-bottom:11px}#book_qty th{border:none;font-size:12px;font-weight:400;padding-bottom:5px;padding-top:0}.tt-hint{color:#999!important}
    a.area-times i {font-size: 10px;color: #fff;text-align: center;margin-left: 2px;}
    a.area-times {border-left: 1px solid #fff;}


</style>
@endpush('custom_css')


@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-sm card-success">
                        <div class="card-header">

                            @if(hasAccessAbility('new_customer', $roles))
                            <a class="btn btn-sm btn-primary text-white" href="{{route('admin.seller.create')}}" title="Add new reseller"><i class="ft-plus text-white"></i>Add Branch</a>
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
                                                <th>@sortablelink('CODE', 'Branch no')</th>
                                                <th>@sortablelink('BusinessInfo.SHOP_NAME', 'Branch name')</th>
                                                <th>Location</th>
                                                <th>Coverage</th>
                                                <th>Phone & Email </th>

                                                <th title="All payments">@sortablelink('CREATED_AT', 'Branch reg. date')</th>
                                                <th>Status</th>
                                                <th style="width: 150px;" class="text-center">@lang('tablehead.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset( $data['rows']) && count($data['rows']) > 0 )
                                                @foreach( $data['rows'] as $k => $row )
                                                    <tr>
                                                        <td>{{ $k+1 }}</td>
                                                        <td>{{ $row->CODE }}</td>
                                                        <td>{{ $row->SHOP_NAME ?? '' }}</td>
                                                        <td>
                                                            @if(isset($row->BusinessInfo->ADDRESS1))
                                                            <p>Address1 : {{ $row->BusinessInfo->ADDRESS1 ?? '' }} </p>
                                                            @endif
                                                            @if(isset($row->BusinessInfo->ADDRESS2))
                                                                <p>Address2 : {{ $row->BusinessInfo->ADDRESS2 ?? '' }} </p>
                                                            @endif
                                                            @if(isset($row->BusinessInfo->DIVISION_NO))
                                                                <p>Division : {{ $row->BusinessInfo->state->STATE_NAME ?? '' }} </p>
                                                            @endif
                                                            @if(isset($row->BusinessInfo->CITY_NO))
                                                                <p>City : {{ $row->BusinessInfo->city->CITY_NAME ?? '' }} </p>
                                                            @endif

                                                        </td>
                                                        <td>
                                                            @if(!empty($row->area))
                                                                @foreach ($row->area as $item)
                                                                    <p>
                                                                        <span>{{ $item->CITY_NAME }} | </span>
                                                                        <span>{{ $item->AREA_NAME }} | </span>
                                                                        <span class="badge item{{ $item->PK_NO }}">{{ $item->SUB_AREA_NAME }}
                                                                        <a href="#" data-id="{{ $item->PK_NO }}" class="area-times delete-row "><i class="la la-times"></i>
                                                                        </a>
                                                                    </span></p>
                                                                @endforeach
                                                            @else
                                                            <a href="#" data-id="{{ $row->PK_NO }}" class="btn btn-xs btn-info mb-05 mr-05 seller-area open-modal" title="Seller Coverage Area">
                                                                <i class="la la-map-marker"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <p>{{ $row->MOBILE_NO }}</p>
                                                            <p>{{ $row->EMAIL }}</p>
                                                        </td>

                                                        <td>
                                                            {{ date('d M, Y', strtotime($row->CREATED_AT)) }}
                                                        </td>
                                                        <td>
                                                            {{ $row->STATUS == 1 ? 'Active' : 'Inactive' }}
                                                        </td>
                                                        <td class="text-center">

                                                            @if (hasAccessAbility('edit_reseller', $roles))
                                                                <a href="{{ route("admin.seller.edit", [$row->PK_NO]) }}" class="btn btn-xs btn-info " title="EDIT"><i class="la la-edit"></i></a>
                                                            @endif

                                                            {{-- @if (hasAccessAbility('view_reseller', $roles))
                                                                <a href="{{ route("admin.seller.view", [$row->PK_NO]) }}" class="btn btn-xs btn-success " title="VIEW"><i class="la la-eye"></i></a>
                                                            @endif --}}



                                                            @if (hasAccessAbility('edit_seller', $roles))
                                                                <a href="#" data-id="{{ $row->PK_NO }}" class="btn btn-xs btn-info  seller-area open-modal" title="Seller Coverage Area">
                                                                    <i class="la la-map-marker"></i>
                                                                </a>
                                                            @endif

                                                            @if (hasAccessAbility('view_product', $roles))
                                                            <a href="{{ route('admin.product.branch-products', ['shop_id' => $row->PK_NO]) }}"  class="btn btn-xs btn-info " title="View product list">
                                                                <i class="la la-list"></i>
                                                            </a>
                                                            @endif

                                                            @if (hasAccessAbility('view_seller_category', $roles))
                                                            <a href="{{ route('product.category.list', ['shop_id' => $row->PK_NO]) }}"  class="btn btn-xs btn-info " title="Seller category">
                                                                <i class="la la-list"></i>
                                                            </a>
                                                            @endif

                                                            @if(hasAccessAbility('view_stock', $roles))
                                                            <a class="btn btn-xs btn-danger " href="{{route('admin.all_product.list', ['shop_id' => $row->PK_NO])}}" title="Seller Stock list"><i class="la la-list"></i></a>
                                                            @endif

                                                            @if(hasAccessAbility('login_as', $roles))
                                                            <a class="btn btn-xs btn-info" href="{{route('admin.login_as', ['shop_id' => $row->PK_NO])}}" title="Login As {{ $row->SHOP_NAME }}"><i class="la la-lock"></i></a>
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


        <!--Seller Coverage Area Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Seller Coverage Area</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="addressModalBody">

      </div>
    </div>
</div>
</div>
</div>
@endsection
@push('custom_js')
<script src="{{ asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{ asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).on('submit', "#areaForm", function (e) {
        e.preventDefault();
        var form = $("#areaForm");
        $.ajax({
            type: 'post',
            data: form.serialize(),
            url: form.attr('action'),
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    toastr.success(response.message);
                    // $('#indextable > tbody').prepend(response.data);
                    $('#areaForm')[0].reset();
                    $('#addressModal').modal('hide');
                    location.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (jqXHR, exception) {
                toastr.error('something wrong');
            },
            complete: function (response) {
                $("body").css("cursor", "default");
            }
        });
    });

    var get_url = $('#base_url').val();
    $(document).on('click', '.open-modal', function () {
        var area_id = $(this).data('id');
        var get_url = $('#base_url').val();
        $.ajax({
            type: 'get',
            url: get_url + '/seller/ajax/get-coverage-area-create'+ "/" + area_id,
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                $('#addressModal').on('shown.bs.modal', function (e) {
                    $(this).find('.select2').select2({
                        dropdownParent: $(this).find('.modal-content')
                    });
                })
                if (response.status == 1) {
                    $('#addressModalBody').empty();
                    $('#addressModal').modal('show');
                    $('#addressModalBody').append(response.data);
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })

    // $('.select-box').select2({
    //         placeholder: "Choose area...",
    //         minimumInputLength: 3,
    //         ajax: {
    //             type: "POST",
    //             url:get_url+'/seller/ajax/get_area_search',
    //             dataType: 'json',
    //             data: function (params) {
    //                 return {
    //                     q: $.trim(params.term)
    //                 };
    //             },
    //             processResults: function (data) {
    //                 return {
    //                     results: data
    //                 };
    //             },
    //             cache: true
    //         }
    //     });
        $(document).on('change', '#region', function () {
        var region_id = $(this).val();
        var get_url = $('#base_url').val();
        $.ajax({
            type: 'get',
            url: get_url + '/ajax/get-city-by-region/' + region_id,
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (res) {
                $('#city').empty();
                $('#city').append(res);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })
    $(document).on('change', '#city', function () {
        var city_id = $(this).val();
        var get_url = $('#base_url').val();
        $.ajax({
            type: 'get',
            url: get_url + '/ajax/get-area-by-city/' + city_id,
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (res) {
                $('#area').empty();
                $('#area').append(res);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })

    $(document).on('change', '#area', function () {
        var area_id = $(this).val();
        var get_url = $('#base_url').val();
        $.ajax({
            type: 'get',
            url: get_url + '/ajax/get-subarea-by-area/' +area_id,
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (res) {
                $('#subarea').empty();
                $('#subarea').append(res);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })
    $(document).on("click", ".delete-row", function (e) {
        e.preventDefault();
        var area_id = $(this).data('id');
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            $.ajax({
                type: 'GET',
                url: '{{URL("ajax/get-coverage-area-delete")}}' + "/" + area_id,
                success: function (response) {
                    if (response.status == 1) {
                        $('.item' + area_id).remove();
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
        }
    });


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
