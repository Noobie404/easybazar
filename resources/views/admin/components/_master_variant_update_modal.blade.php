<?php
    $categories_combo       = $data['category_combo'] ?? [];
    $brand_combo            = $data['brand_combo'] ?? [];
    $subcategory_combo      = $data['subcategory_combo'] ?? array();
    $prod_model_combo       = $data['prod_model_combo'] ?? array();
?>
{!! Form::open([ 'route' => 'admin.master_search', 'method' => 'get', 'class' => 'form-horizontal', 'files' => true , 'novalidate', 'id' => 'search_for_master']) !!}
@csrf
{!! Form::hidden('', null, ['id'=>'variant_id']) !!}
<div class="row">
    <div class="col-md-3">
        <div class="form-group {!! $errors->has('category') ? 'error' : '' !!}">
            <label>{{trans('form.category')}}<span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::select('category', $categories_combo, $rows->F_PRD_CATEGORY_ID, ['class'=>'form-control mb-1 select2', 'id' => 'category2', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select category', 'tabindex' => 1, 'data-url' => URL::to('prod_subcategory') ]) !!}
                {!! $errors->first('category', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {!! $errors->has('sub_category') ? 'error' : '' !!}">
            <label>{{trans('form.sub_category')}}<span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::select('sub_category', $subcategory_combo, $rows->F_PRD_SUB_CATEGORY_ID, ['class'=>'form-control mb-1 select2', 'id' => 'sub_category2', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select sub_category', 'tabindex' => 2, 'data-url' => URL::to('get_hscode_by_scat'),]) !!}
                {!! $errors->first('sub_category', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {!! $errors->has('brand') ? 'error' : '' !!}">
            <label>{{trans('form.brand')}}</label>
            <div class="controls">
                {!! Form::select('brand', $brand_combo, $rows->F_BRAND, ['class'=>'form-control mb-1 select2', 'id' => 'brand2', 'placeholder' => 'Select brand', 'tabindex' => 3, 'data-url' => URL::to('prod_model') ]) !!}
                {!! $errors->first('brand', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group {!! $errors->has('prod_model') ? 'error' : '' !!}">
            <label>{{trans('form.model')}}</label>
            <div class="controls">
                {!! Form::select('prod_model', $prod_model_combo, $rows->F_MODEL, ['class'=>'form-control mb-1 select2','style' => 'width: 80%;display: inline;', 'id' => 'prod_model2', 'placeholder' => 'Select model', 'tabindex' => 4]) !!}
                {!! $errors->first('prod_model', '<label class="help-block text-danger">:message</label>') !!}
                <a href="{{ route('product.brand.list') }}" id="" class="btn btn-primary btn-sm bg-darken-1 text-white" style="margin-top: -6px;" target="_blank" title="ADD NEW MODEL"><i class="la la-plus"></i> </a>
            </div>
        </div>

    </div>
    <div class="col-md-12">
        <div class="form-actions text-center">
          <button type="submit" id="" class="btn bg-primary bg-darken-1 text-white" title="Search"><i class="la la-search"></i> {{ trans('form.btn_search') }} </button>
          <a href="{{ route('admin.product.create') }}" id="" class="btn btn-primary bg-darken-1 text-white" target="_blank"title="ADD NEW MASTER"><i class="la la-plus"></i> Add Master </a>
        </div>
    </div>
</div>
{!! Form::close() !!}

<div class="row">
    <div class="col-md-12 table-wrapper-scroll-y my-custom-scrollbar">
        <table class="table table-scroll table-striped table-bordered table-sm table-hover" id="advanceSearchResult" style="font-size: 12px;line-height: 18px;">
            <thead>
                <tr>
                    <th colspan=" @if(request()->get('parent_url') ?? request()->get('mother_url')) 8 @else 10 @endif" class="text-center text-danger">SEARCH RESULT </th>

                      @if(request()->get('parent_url') ?? request()->get('mother_url'))
                      <th colspan="2">
                         <button type="submit" class="btn btn-sm btn-primary pull-right">Go back with result set or empty</button>
                      </th>
                        @endif

                </tr>
                <tr>
                    <th class="text-center" style="width:20px;">SL</th>
                    <th class="text-center" style="width: 130px;">Photos</th>
                    <th style="">Master Name</th>
                    <th style="width:200px;">Code</th>
                    <th style="width:120px;">Brand/Model</th>
                    <th style="width:120px;">Category</th>
                    <th style="width: 104px;" class="text-center">
                        Action
                    </th>

                </tr>
            </thead>
            <tbody id="append_result">
                {{-- @if($rows &&  $rows->count() > 0)

                @else
                <tr>
                    <td colspan="9" class="text-center">Data not found</td>

                </tr>
                @endif --}}
            </tbody>
        </table>
    </div>
</div>
