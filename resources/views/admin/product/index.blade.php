
@extends('admin.layout.master')
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
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('product.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">@lang('product.breadcrumb_sub_title')</li>
@endsection
@php
    $tab_index = 1;
    $roles = userRolePermissionArray();
    $shop_id = request()->get('shop_id');
    $category       = request()->get('category') ?? '';
    $subcategory   = request()->get('subcategory') ?? '';
    $subsubcategory   = request()->get('subsubcategory') ?? '';
    $categories_combo       = getCategorCombo() ?? [];
    $subcategories_combo    = getSubCategorCombo($category) ?? [];
    $subsubcategories_combo    = getSubCategorCombo($subcategory) ?? [];
    $brand          = request()->get('brand') ?? '';
    $vat_class      = request()->get('vat_class') ?? '';
    $sku_id         = request()->get('sku_id') ?? '';
    $barcode        = request()->get('barcode') ?? '';
    $brand_combo            = getBrandCombo() ?? [];

@endphp
@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-sm card-success">
                        <div class="card-header">
                            @if(Auth::user()->USER_TYPE == 10)
                            {{-- <a class="btn btn-sm btn-info text-white" href="{{ route('admin.product.list') }}?product=all" title="PRODUCT MASTER" > Master product (EB) </a> --}}
                            {{-- <a class="btn btn-sm btn-info text-white" href="{{ route('admin.product.list') }}?product=shop" title="PRODUCT MASTER"> Master product (Shop)</a> --}}
                            {{-- @else --}}
                            @endif
                            @if(Auth::user()->USER_TYPE == 0)
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            {{-- <div class="heading-elements"> --}}
                                @if(hasAccessAbility('new_product', $roles))
                                    <a class="btn btn-sm btn-info text-white" href="{{ route('admin.product.create') }}" title="ADD NEW PRODUCT MASTER"><i class="ft-plus text-white"></i> New master product</a>
                                @endif
                            {{-- </div> --}}
                            @endif


                        </div>


                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="form-body p-3">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {!! $errors->has('category') ? 'error' : '' !!}">
                                                <label>{{trans('form.category')}}<span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    {!! Form::select('category', $categories_combo, $category, ['class'=>'form-control mb-1 select2', 'id' => 'category', 'placeholder' => 'Select category', 'tabindex' => $tab_index++]) !!}
                                                    {!! $errors->first('category', '<label class="help-block text-danger">:message</label>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {!! $errors->has('subcategory') ? 'error' : '' !!}">
                                                <label>{{trans('form.sub_category')}} <span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    {!! Form::select('subcategory', $subcategories_combo, $subcategory, ['class'=>'form-control mb-1 select2', 'id' => 'subcategory',  'placeholder' => 'Select sub category','tabindex' => $tab_index++] ) !!}
                                                    {!! $errors->first('subcategory', '<label class="help-block text-danger">:message</label>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {!! $errors->has('subsubcategory') ? 'error' : '' !!}">
                                                <label>Sub subcategory <span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    {!! Form::select('subsubcategory', $subsubcategories_combo, $subsubcategory, ['class'=>'form-control mb-1 select2', 'id' => 'subsubcategory',  'placeholder' => 'Select sub category','tabindex' => $tab_index++] ) !!}
                                                    {!! $errors->first('subsubcategory', '<label class="help-block text-danger">:message</label>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group {!! $errors->has('brand') ? 'error' : '' !!}">
                                                <label>{{trans('form.brand')}}</label>
                                                <div class="controls">
                                                    {!! Form::select('brand', $brand_combo, $brand, ['class'=>'form-control mb-1 select2', 'id' => 'brand', 'placeholder' => 'Select brand', 'tabindex' => $tab_index++, 'data-url' => URL::to('prod_model')]) !!}
                                                    {!! $errors->first('brand', '<label class="help-block text-danger">:message</label>') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group {!! $errors->has('keyword') ? 'error' : '' !!}">
                                                <label>{{trans('form.search_key')}}</label>
                                                <div class="controls">
                                                    {!! Form::text('keyword',NULL, [ 'class' => 'form-control mb-1', 'placeholder' => 'Search by keywords','id'=>'keyword', 'tabindex' => $tab_index++]) !!}
                                                    {!! $errors->first('keyword', '<label class="help-block text-danger">:message</label>') !!}
                                                </div>
                                            </div>
                                        </div>

                                      {{-- <div class="col-md-3">
                                          <div class="form-group {!! $errors->has('sku_id') ? 'error' : '' !!}">
                                              <label>SKU </label>
                                              <div class="controls">
                                                  {!! Form::text('sku_id', $sku_id, [ 'class' => 'form-control mb-1', 'placeholder' => 'Search by SKU','id'=>'sku_id', 'tabindex' => $tab_index++]) !!}
                                                  {!! $errors->first('sku_id', '<label class="help-block text-danger">:message</label>') !!}
                                              </div>
                                          </div>
                                      </div>
                                      <div class="col-md-3">
                                          <div class="form-group {!! $errors->has('barcode') ? 'error' : '' !!}">
                                              <label>{{trans('form.barcode')}}</label>
                                              <div class="controls">
                                                  {!! Form::text('barcode', $barcode, [ 'class' => 'form-control mb-1', 'placeholder' => 'Search by barcode', 'id'=>'barcode','tabindex' => $tab_index++]) !!}
                                                  {!! $errors->first('barcode', '<label class="help-block text-danger">:message</label>') !!}
                                              </div>
                                          </div>
                                      </div> --}}
                                      <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                                            <label>Is Active</label>
                                            <div class="controls">
                                                {!! Form::select('is_active', ['1' => 'Yes', '0' => 'No', '2' => 'Pending'], '1', ['class'=>'form-control mb-1 ', 'placeholder' => 'Select status','id'=>'is_active', 'tabindex' => $tab_index++]) !!}
                                                {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-info filter_category" title="Confirm" id="filter_category" >Filter</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive ">
                                    <table class="table table-striped table-bordered  table-sm" id="process_data_table">
                                        <thead>
                                        <tr>
                                            <th class="text-center">@lang('tablehead.sl')</th>
                                            <th>@lang('tablehead.category')</th>
                                            <th>@lang('tablehead.name')</th>
                                            <th class="text-center">@lang('tablehead.image')</th>
                                            <th class="text-center">Entry by</th>
                                            <th class="text-center">Total Variants</th>
                                            <th style="width: 120px;" class="text-center" >@lang('tablehead.action')</th>
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

    $(document).on('click', '#filter_category', function () {
        var value = getCookie('product_list');

        if (value !== null ) {
            var value = (value-1)*25;
            // table.fnPageChange(value,true);
        }else{
            var value = 0;
        }
        var table = callDatatable(value);
    })

    $(document).ready(function() {
        var value = getCookie('product_list');

        if (value !== null ) {
            var value = (value-1)*25;
            // table.fnPageChange(value,true);
        }else{
            var value = 0;
        }
        var table = callDatatable(value);

    });

    function callDatatable(value) {
        var category = $('#category').val();
        var subsubcategory = $('#subsubcategory').val();
        var subcategory = $('#subcategory').val();
        var brand = $('#brand').val();
        // alert(brand);
        var keyword = $('#keyword').val();
        var sku_id = $('#sku_id').val();
        var barcode = $('#barcode').val();
        var is_active = $('#is_active').val();
        var status = `{{ request()->get('status') }}`;
        var product = `{{ request()->get('product') }}`;
        var get_url = $('#base_url').val();
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
            stateSave: true,
            bDestroy: true,
            iDisplayStart: value,
            ajax: {
                url: get_url+'/product/all_product',
                type: 'POST',
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.status = status;
                    d.product = product;
                    d.category = category;
                    d.subcategory = subcategory;
                    d.subsubcategory = subsubcategory;
                    d.keyword = keyword;
                    d.sku_id = sku_id;
                    d.barcode = barcode;
                    d.brand = brand;
                    d.is_active = is_active;
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
                    data: 'product_name',
                    name: 'product_name',
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
                    data: 'total_variant',
                    name: 'total_variant',
                    searchable: false,
                    className: 'text-center'

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

    $(document).on('change', '#category', function () {
        var category_id = $(this).val();
        var get_url = $('#base_url').val();
        $.ajax({
            type: 'get',
            url: get_url + '/ajax/get-subcategory/' + category_id,
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (res) {
                $('#subcategory').empty();
                $('#subcategory').append(res);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })
    $(document).on('change', '#subcategory', function () {
        var category_id = $(this).val();
        var get_url = $('#base_url').val();
        $.ajax({
            type: 'get',
            url: get_url + '/ajax/get-subcategory/' + category_id,
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (res) {
                $('#subsubcategory').empty();
                $('#subsubcategory').append(res);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })




</script>

@endpush
