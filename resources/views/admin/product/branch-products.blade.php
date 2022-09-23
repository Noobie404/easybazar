@extends('admin.layout.master')
@section('branch_product','active')
@section('Product Management','open')
@section('title') Branch Product @endsection
@section('page-name') Branch Product @endsection
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/core/colors/palette-tooltip.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/extensions/toastr.css')}}">
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('product.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">@lang('product.breadcrumb_sub_title')</li>
@endsection
@php
    $tab_index = 1;
    $roles = userRolePermissionArray();
    $rows = $data['rows'];
    $branch_id = request()->get('branch_id');
    $category  = request()->get('category') ?? '';
    $subcategory   = request()->get('subcategory') ?? '';
    $subsubcategory   = request()->get('subsubcategory') ?? '';
    $categories_combo   = getCategorCombo() ?? [];
    $subcategories_combo    = getSubCategorCombo($category) ?? [];
    $subsubcategories_combo    = getSubCategorCombo($subcategory) ?? [];
    $brand_combo            = getBrandCombo() ?? [];
    $brand          = request()->get('brand') ?? '';

@endphp
@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <div class="card card-sm card-success">
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                           {!! Form::open([ 'route' => 'admin.product.storeToShop', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate','id'=>'areaForm']) !!}
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('branch_id') ? 'error' : '' !!}">
                                            <label>Branch Name<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <select class="form-control mb-1" data-validation-required-message="This field is required" tabindex="4" id="branch_id" name="branch_id" >
                                                    @if(isset($data['shop_info']) && count($data['shop_info']) > 0 )
                                                    @foreach($data['shop_info'] as $shop)
                                                    <option value="{{ $shop->PK_NO }}" {{ $branch_id == $shop->PK_NO ? 'selected' : '' }} >{{ $shop->SHOP_NAME }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                {!! $errors->first('branch_id', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('category') ? 'error' : '' !!}">
                                            <label>{{trans('form.category')}}</label>
                                            <div class="controls">
                                                {!! Form::select('category', $categories_combo, $category, ['class'=>'form-control mb-1 select2', 'id' => 'category', 'placeholder' => 'Select category', 'tabindex' => $tab_index++, 'data-url' => URL::to('prod_subcategory') ]) !!}
                                                {!! $errors->first('category', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('subcategory') ? 'error' : '' !!}">
                                            <label>{{trans('form.sub_category')}}</label>
                                            <div class="controls">
                                                {!! Form::select('subcategory', $subcategories_combo, $subcategory, ['class'=>'form-control mb-1 select2', 'id' => 'subcategory',  'placeholder' => 'Select sub category', 'data-url' => URL::to('get_brand_model_by_scat'), 'tabindex' => $tab_index++] ) !!}
                                                {!! $errors->first('subcategory', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('subsubcategory') ? 'error' : '' !!}">
                                            <label>Sub subcategory</label>
                                            <div class="controls">
                                                {!! Form::select('subsubcategory', $subsubcategories_combo, $subsubcategory, ['class'=>'form-control mb-1 select2', 'id' => 'subsubcategory',  'placeholder' => 'Select sub category', 'data-url' => URL::to('get_brand_model_by_scat'), 'tabindex' => $tab_index++] ) !!}
                                                {!! $errors->first('subsubcategory', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('brand') ? 'error' : '' !!}">
                                            <label>{{trans('form.brand')}}</label>
                                            <div class="controls">
                                                {!! Form::select('brand', $brand_combo, $brand, ['class'=>'form-control mb-1 select2', 'id' => 'brand', 'placeholder' => 'Select brand', 'tabindex' => $tab_index++, 'data-url' => URL::to('prod_model')]) !!}
                                                {!! $errors->first('brand', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {!! $errors->has('keyword') ? 'error' : '' !!}">
                                            <label>{{trans('form.search_key')}}</label>
                                            <div class="controls">
                                                {!! Form::text('keyword',NULL, [ 'class' => 'form-control mb-1', 'placeholder' => 'Search by keywords','id'=>'keyword', 'tabindex' => $tab_index++]) !!}
                                                {!! $errors->first('keyword', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
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
                              <div class="row py-2">
                                <div class="col-md-6 text-center">
                                    <button type="button" class="btn btn-primary float-left filter">
                                        <i class="la la-arrow-right"></i> Show
                                    </button>
                                </div>
                                @if(hasAccessAbility('product_assigned_to_shop', $roles))
                                {{-- <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary float-right" onclick="return confirm('Are you sure？')" >
                                            <i class="la la-arrow-right"></i> Save change
                                        </button>
                                </div> --}}
                                @endif
                              </div>
                                <div class="table-responsive" id="show_master">
                                    <table class="table table-striped table-bordered  table-sm" id="process_data_table">
                                        <thead>
                                        <tr>

                                            <th class="text-center">
                                                @if(hasAccessAbility('product_assigned_to_shop', $roles))
                                                <label for="select-all"><input type="checkbox" id="select-all"> Select all </label>
                                                @else
                                                SL
                                                @endif
                                            </th>
                                            <th>@lang('tablehead.category')</th>
                                            <th>@lang('tablehead.name')</th>
                                            <th class="text-center">@lang('tablehead.image')</th>
                                            <th class="text-center">Total Variants</th>
                                            <th class="text-center" >@lang('tablehead.action')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($rows) && count($rows) > 0)
                                            @foreach($rows as $key => $row)
                                            <?php
                                            $checked = '';
                                            if($row->PRD_SHOP_MASTER_MAP_NO){
                                                $checked = 'checked';
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-center">
                                                    <label>
                                                        {{-- {{ $key+1 }} --}}
                                                        @if(hasAccessAbility('product_assigned_to_shop', $roles))
                                                            <input class="checkSingle" type="checkbox" name="master_id[]" value="{{$row->PK_NO}}" @if($checked) checked @endif >
                                                        @else
                                                        <input class="checkSingle" type="checkbox" name="master_id[]" value="{{$row->PK_NO}}" @if($checked) checked @endif onClick="return false;" >
                                                        @endif
                                                    </label>
                                                </td>
                                                <td>{{ getCategoryChain($row->PK_NO) }}</td>
                                                <td>{{$row->DEFAULT_NAME}}</td>
                                                <td>
                                                    <?php
                                                        $product = DB::table('PRD_VARIANT_SETUP')->where('F_PRD_MASTER_SETUP_NO',$row->PK_NO)->first();
                                                     ?>
                                                    @if(!empty($product->THUMB_PATH))
                                                    <a href="{{fileExit($product->THUMB_PATH)}}" target="_blank"><img src="{{fileExit($product->THUMB_PATH)}}" class="img-fluid img-sm"></a>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="#" data-id="{{$row->PK_NO}}" class="d-inline open-modal">
                                                    {{$row->TOTAL_VARIANT}}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="#" data-id="{{$row->PK_NO}}" class="d-inline open-modal"><i class="la la-tasks"></i></a>
                                                    @if(!empty($checked))
                                                {{-- <div class="custom-control custom-switch custom-switch-md d-inline">
                                                    <input type="checkbox" data-id="{{$row->PK_NO}}"  class="custom-control-input status" id="customSwitch_{{$row->PK_NO}}" @if($checked=='1') checked @endif>
                                                    <label class="custom-control-label" for="customSwitch_{{$row->PK_NO}}"></label>
                                                </div> --}}
                                                @endif
                                               </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        <div class="form-actions text-center">
                            <a href="{{ route('product.category.list') }}">
                                <button type="button" class="btn btn-warning mr-1" title="Cancel">
                                    <i class="ft-x"></i> @lang('form.btn_cancle')
                                </button>
                            </a>
                            @if(hasAccessAbility('product_assigned_to_shop', $roles))
                                <button type="submit" id="form_submit" class="btn btn-primary" title="Save">
                                    <i class="la la-check-square-o"></i> @lang('form.btn_save')
                                </button>
                                @endif
                        </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title" id="addressModalLabel">Product variant</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>
          <div class="modal-body" id="addressModalBody">
          </div>
       </div>
    </div>
 </div>


@endsection


@push('custom_js')
<!-- BEGIN: Data Table-->
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

// $('#select-all').click(function(event) {
//         var $that = $(this);
//         $(':checkbox').each(function() {
//             this.checked = $that.is(':checked');
//         });
//     });

$(document).ready(function() {
    $("#select-all").change(function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;
            $(".checkSingle").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });
            if (isAllChecked == 0) {
                $("#select-all").prop("checked", true);
            }
        }
        else {
            $("#select-all").prop("checked", false);
        }
    });

});

    // $(document).on('change', "#branch_id,#category,#subcategory,#subsubcategory", function (e) {
    //         e.preventDefault();
    //         var branch_id = $('#branch_id').val();
    //         var category = $('#category').val();
    //         var subcategory = $('#subcategory').val();
    //         var subsubcategory = $('#subsubcategory').val();
    //         var get_url = $('#base_url').val();
    //         var current_url = get_url+'/product/shop_product?branch_id='+branch_id+'&category='+category+'&subcategory='+subcategory+'&subsubcategory='+subsubcategory;
    //         window.location.href = current_url;

    //         // $.ajax({
    //         //     type: 'GET',
    //         //     url: get_url + '/ajax/get-shop-master' + "/" + branch_id,
    //         //     success: function (response) {
    //         //         if (response.status == 1) {
    //         //             $('#show_master').empty();
    //         //             $('#show_master').append(response.data);
    //         //         }
    //         //     },
    //         //     error: function (jqXHR, exception) {
    //         //         toastr.error('Something wrong');
    //         //     },
    //         //     complete: function (data) {
    //         //         $("body").css("cursor", "default");
    //         //     }
    //         // });

    // });

    $(document).on('click', ".filter", function (e) {
            e.preventDefault();
            var branch_id = $('#branch_id').val();
            var category = $('#category').val();
            var subcategory = $('#subcategory').val();
            var subsubcategory = $('#subsubcategory').val();
            var brand = $('#brand').val();
            var keyword = $('#keyword').val();
            var is_active = $('#is_active').val();
            var get_url = $('#base_url').val();
            $.ajax({
                type: 'POST',
                url: get_url + '/ajax/get-shop-master',
                 data: {
                    'branch_id': branch_id,
                    'category': category,
                    'subcategory': subcategory,
                    'subsubcategory': subsubcategory,
                    'brand': brand,
                    'keyword': keyword,
                    'is_active': is_active,
                },
                async: true,
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (response) {
                    if (response.status == 1) {
                        $('#show_master').empty();
                        $('#show_master').append(response.data);
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
                toastr.success(response.message);
                $('html, body').animate({ scrollTop: 0 }, 0);
            },
            error: function (jqXHR, exception) {
                toastr.error('something wrong');
            },
            complete: function (response) {
                $("body").css("cursor", "default");
            }
        });
    });


/*
    $(document).on('change', ".status", function (e) {
        e.preventDefault();
        var get_url = $('#base_url').val();
        var branch_id = $('#branch_id').val();
        var master_id = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: get_url + '/ajax/shop-master-status',
            data: {
                'master_id': master_id,
                'branch_id': branch_id,
            },
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                toastr.success(response.message);
                console.log(response.data);
            },
            error: function (jqXHR, exception) {
                toastr.error('something wrong');
            },
            complete: function (response) {
                $("body").css("cursor", "default");
            }
        });
    });
    */

    $(document).on('click', '.open-modal', function (e) {
        e.preventDefault();
        var get_url = $('#base_url').val();
        var branch_id = $('#branch_id').val();
        var master_id = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: get_url + '/ajax/variant-by-master',
            data: {
                'master_id': master_id,
                'branch_id': branch_id,
            },

            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
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




    $(document).on('change', ".variant-status", function (e) {
        e.preventDefault();
        var get_url = $('#base_url').val();
        var branch_id = $(this).attr("shop-id");
        var variant_id = $(this).data('id');
        var variant_status = 0;
        if($(this).is(':checked')){
            var variant_status = 1;
        }
        $.ajax({
            type: 'POST',
            url: get_url + '/ajax/shop-variant-status',
            data: {
                'variant_id': variant_id,
                'branch_id': branch_id,
                'variant_status': variant_status,
            },
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                toastr.success(response.message);
                console.log(response.data);
            },
            error: function (jqXHR, exception) {
                toastr.error('something wrong');
            },
            complete: function (response) {
                $("body").css("cursor", "default");
            }
        });
    });


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
