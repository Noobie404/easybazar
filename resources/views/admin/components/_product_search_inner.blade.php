
@push('custom_css')
<style>

    #bulkCheck{display: none;}
    #advanceSearchResult td{vertical-align: middle;}
    .variant_name{position: relative;}
    .variant_name div{position: absolute; right: 0; bottom: 0;}
    table.table-sm th, .table.table-sm td {padding: 0.5rem .1rem;}

</style>

@endpush
<?php

$category       = request()->get('category') ?? '';
$sub_category   = request()->get('sub_category') ?? '';
$brand          = request()->get('brand') ?? '';
$name           = request()->get('name') ?? '';
$vat_class      = request()->get('vat_class') ?? '';
$hs_code        = request()->get('hs_code') ?? '';
$ig_code        = request()->get('ig_code') ?? '';
$sku_id         = request()->get('sku_id') ?? '';
$barcode        = request()->get('barcode') ?? '';
$preferred_shipping_method = request()->get('preferred_shipping_method') ?? '';
$categories_combo = getCategorCombo() ?? [];
$subcategories_combo = getSubCategorCombo($category) ?? [];
$subsubcategory = request()->get('subsubcategory') ?? '';
$subsubcategories_combo = getSubCategorCombo($sub_category) ?? [];
$vat_class_combo = getVatClassCombo() ?? [];
$brand_combo     = getBrandCombo() ?? [];
$rows = $data['rows'] ?? null;
$list_type = \Session::get('list_type');
$tab_index = 1;
?>
<div>
   {!! Form::open([ 'route' => 'admin.product_search', 'method' => 'get', 'class' => 'form-horizontal', 'files' => true , 'novalidate', 'id' => 'advanceSearch']) !!}
   @csrf
   <input type="hidden" name="parent_url" value="" id="serach_parent_url">
   <input type="hidden" name="multiple_select" value="" id="multiple_select">
   <input type="hidden" name="mother_url" value="{{request()->get('parent_url') ?? request()->get('mother_url')}}" />
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
                {!! Form::select('subcategory', $subcategories_combo, $sub_category, ['class'=>'form-control mb-1 select2', 'id' => 'subcategory',  'placeholder' => 'Select sub category','tabindex' => $tab_index++] ) !!}
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

      <div class="col-md-3">
          <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
              <label>{{trans('form.search_key')}}</label>
              <div class="controls">
                  {!! Form::text('name', $name, [ 'class' => 'form-control mb-1', 'placeholder' => 'Search by keywords', 'tabindex' => $tab_index++]) !!}
                  {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
              </div>
          </div>
      </div>

    <div class="col-md-3">
        <div class="form-group {!! $errors->has('sku_id') ? 'error' : '' !!}">
            <label>SKU </label>
            <div class="controls">
                {!! Form::text('sku_id', $sku_id, [ 'class' => 'form-control mb-1', 'placeholder' => 'Search by SKU', 'tabindex' => $tab_index++]) !!}
                {!! $errors->first('sku_id', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {!! $errors->has('barcode') ? 'error' : '' !!}">
            <label>{{trans('form.barcode')}}</label>
            <div class="controls">
                {!! Form::text('barcode', $barcode, [ 'class' => 'form-control mb-1', 'placeholder' => 'Search by barcode', 'tabindex' => $tab_index++]) !!}
                {!! $errors->first('barcode', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-3">
          <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
              <label>Is Active</label>
              <div class="controls">
                  {!! Form::select('is_active', ['1' => 'Active', '0' => 'Inactive', '2' => 'Pending'], '1', ['class'=>'form-control mb-1 ', 'placeholder' => 'Select vat class', 'tabindex' => $tab_index++]) !!}
                  {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
              </div>
          </div>
      </div>
  </div>
    <div class="col-md-12">
        <div class="form-actions text-center">
          <button type="submit" class="btn bg-primary bg-darken-1 text-white" title="Search"><i class="la la-search"></i> {{ trans('form.btn_search') }} </button>
        </div>
    </div>
     {!! Form::close() !!}
  </div>
  <div>
    {!! Form::open([ 'route' => 'admin.add_to_mother_page', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate', 'id' => 'variantSearchItem']) !!}
    <input type="hidden" name="parent_url" value="{{request()->get('parent_url') ?? request()->get('mother_url')}}" />
    <div class="row">
        <div class="col-md-12 table-wrapper-scroll-y my-custom-scrollbar">
            <table class="table table-scroll table-striped table-bordered table-sm table-hover" id="advanceSearchResult" style="font-size: 12px;line-height: 18px;">
                <thead>
                    <tr>
                        <th colspan=" @if(request()->get('parent_url') ?? request()->get('mother_url')) 9 @else 11 @endif" class="text-center text-danger">SEARCH RESULT </th>
                         @if(request()->get('parent_url') ?? request()->get('mother_url'))
                          <th colspan="2">
                             <button type="submit" class="btn btn-sm btn-primary pull-right">Go back with result set or empty</button>
                          </th>
                        @endif
                    </tr>
                    <tr>
                        <th class="text-center" style="width:20px;">SL</th>
                        <th class="text-center" style="width: 60px;">Photos</th>
                        <th style="">Variant Name</th>
                        <th style="">Status</th>
                        <th style="width:200px;">Code</th>
                        <th style="width:80px;">Size/Color</th>
                        <th style="width:120px;">Brand/Model</th>
                        <th style="width:120px;">Category</th>
                        <th title="Unit Variant Price" style="width: 150px;">Unit Price</th>
                        <th style="width: 104px;" class="text-center">
                            Action
                            @if($list_type != 'searchlist')
                                <button type="button" class="btn btn-xs btn-info" id="bulkCheck">Submit Select</button>
                            @endif
                        </th>

                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@push('custom_js')
<script src="{{ asset('assets/lightgallery/js/lightgallery.min.js')}}"></script>
<script src="{{ asset('assets/pages/product.js')}}"></script>
<script src="{{ asset('assets/js/scripts/tooltip/tooltip.js')}}"></script>
<script>
//for image gallery
$(".lightgallery").lightGallery();
$(document).ready(function(){
    $('#advanceSearch').submit(function(){
        var pageurl = `{{ route('admin.searchlist.view.post') }}`;
        $.ajax({
            type    : 'POST',
            url     : pageurl,
            async   : true,
            data    : $(this).serialize(),
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
               $('#advanceSearchResult tbody').html('').append(data.html);
                $(".lightgallery").lightGallery();
                $("[data-popup=tooltip-custom]").on('shown.bs.tooltip', function(){
                    var bg = "",
                    text = "",
                    bgClass = "",
                    textClass = "",
                    $this = $(this);
                    if($this.data("bg-color") !== undefined){
                    bg = $this.data("bg-color");
                    bgClass = "tooltip-bg-" +bg;
                    $('.tooltip').addClass(bgClass);
                    $('.tooltip').addClass('tooltip-card');
                    }
                    if($this.data("text-color") !== undefined){
                    text = $this.data("text-color");
                    textClass = "tooltip-text-" +text;
                    $('.tooltip').addClass(textClass);
                    }
	            }).tooltip();
            },
            complete: function (data) {
                $("body").css("cursor", "default");
                //$.unblockUI();
            }
        });
        return false;
    });
});

    $(document).on('click', '#advanceSearchResult tbody tr', function() {
        var barcode     = $(this).find(".variant_select").data("barcode");
        var multiple    = $(this).find(".variant_select").data("multiple");
        if(multiple == 0){
            $('#bar-code').val(barcode).trigger('enterPress');
            getItemList(barcode);
            $('#variant-modal').modal('toggle');
        }
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

@endpush('custom_js')
