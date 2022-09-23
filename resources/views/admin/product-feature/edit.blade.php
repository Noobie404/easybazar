@extends('admin.layout.master')
@section('product feature master','active')

@section('title') Variant Factor | Edit @endsection
@section('page-name') Edit Variant Factor @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a> </li>
<li class="breadcrumb-item"><a href="{{ route('admin.product-feature.index') }}"> Variant Factors </a></li>
<li class="breadcrumb-item active">Edit Variant Factor </li>
@endsection

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<style>
    .list-group-item {align-items: center;}
    .highlight {background: #f7e7d3;min-height: 50px;list-style-type: none;}
    .handle {min-width: 15px;background: #607D8B;height: 15px;display: inline-block;cursor: move;margin-left: 12px;margin-top: 9px;}
</style>
@endpush
@php
   $productFeaType = Config::get('static_array.product_feature_type');
@endphp

@section('content')
<div class="card card-success min-height">
    <div class="card-header">
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
        <div class="card-body">
            {!! Form::open([ 'route' => ['admin.product-feature.update',$data['parent']->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
            @csrf
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                            <label>@lang('form.name')<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::text('name', $data['parent']->NAME ?? null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter product feature name', 'data-validation-required-message' => 'This field is required', 'tabindex' => 2 ]) !!}
                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('title') ? 'error' : '' !!}">
                            <label>Title</label>
                            <div class="controls">
                                {!! Form::text('title', $data['parent']->TITLE ?? null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter product feature title', 'tabindex' => 3 ]) !!}
                                {!! $errors->first('title', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('type') ? 'error' : '' !!}">
                            <label>Type<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('type',$productFeaType,$data['parent']->FEATURE_TYPE ?? null, [ 'class' => 'form-control mb-1', 'id' => 'feature_type','data-validation-required-message' => 'This field is required', 'tabindex' => 4 ]) !!}
                                {!! $errors->first('type', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                            <label>Is Active<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('is_active',array(1=>'Yes',0=>'No'), $data['parent']->IS_ACTIVE ?? null, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => 5 ]) !!}
                                {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('is_color') ? 'error' : '' !!}">
                            <label>Treat as COLOR<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('is_color',array(0=>'No',1=>'Yes'), $data['parent']->IS_COLOR ?? null, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => 6 ]) !!}
                                {!! $errors->first('is_color', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('description') ? 'error' : '' !!}">
                            <label>Description</label>
                            <div class="controls">
                                {!! Form::textarea('description', $data['parent']->DESCRIPTION ?? '', [ 'class' => 'form-control mb-1', 'tabindex' => 7,'rows' => 2 ]) !!}
                                {!! $errors->first('description', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="multiselect_section">
                    <div class="col-lg-4 offset-4">
                        <div id="child-section" class="sort_menu list-group">
                        @if (isset($data['child']) && !empty($data['child']))
                            @foreach ($data['child'] as $item)
                            <div class="list-group-item pb-0" data-id="{{ $item->PK_NO }}">
                                <div class="row">
                                    <div class="col-md-1 pl-0" align="left">
                                    <span class="handle"></span>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                            <div class="controls">
                                                {!! Form::text('multivalue', $item->NAME ?? null, [ 'class' => 'form-control mb-1','id'=>'name', 'placeholder' => 'Enter value' ]) !!}
                                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-auto pl-0" align="right">
                                        <button type="button" id="update" class="btn btn-info btn-sm" title="UPDATE"value="update" data-pk_no="{{ $item->PK_NO }}"><i class="la la-edit"></i>Update</button>
                                        @if ($data['parent']->FEATURE_TYPE == 2)
                                        <button type="button" id="" class="btn btn-primary btn-sm add_child" title="ADD CHILD" value="add_child" data-pk_no="{{ $item->PK_NO }}"><i class="la la-plus"></i></button>
                                        @endif
                                        <button type="button" id="delete" class="btn btn-danger btn-sm" title="DELETE" value="delete" data-pk_no="{{ $item->PK_NO }}" ><i class="la la-trash"></i>Delete</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        </div>
                    </div>
                </div>
                <div class="row" id="add_new_option">
                    <div class="col-md-3 offset-4 mt-3">
                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                            <div class="controls">
                                {!! Form::text('multivalue', '', [ 'class' => 'form-control mb-1','id'=>'name', 'placeholder' => 'Enter value','tabindex' => 1 ]) !!}
                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mt-3">
                        <button type="button" id="add" class="btn btn-primary btn-sm" value="add"><i class="la la-plus"></i>Add Options</button>
                    </div>
                </div>
                <div class="form-actions text-center mt-3">
                    <a href="{{route('admin.product-feature.index')}}">
                        <button type="button" class="btn btn-warning mr-1">
                            <i class="ft-x"></i>@lang('form.btn_cancle')
                        </button>
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="la la-check-square-o"></i>@lang('form.btn_update')
                    </button>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<!--Add Edit Feature Child Method html-->
<div class="modal fade text-left" id="popup_feature_childs" tabindex="-1" role="dialog" aria-labelledby="method" aria-hidden="true">
    <div class="modal-dialog" role="document">
        {!! Form::hidden('', null, ['id' => 'feature_parent_pk']) !!}
        {!! Form::hidden('', null, ['id' => 'feature_parent_name']) !!}
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal_title"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="feature_childs_view" class="sort_menu_child list-group">
                        </div>
                    </div>
                </div>
                <div class="row mt-3" id="add_child_option">
                    <div class="col-md-8">
                        <div class="form-group {!! $errors->has('multivalue') ? 'error' : '' !!}">
                            <div class="controls">
                                {!! Form::text('multivalue', '', [ 'class' => 'form-control mb-1','id'=>'child', 'placeholder' => 'Enter value' ]) !!}
                                {!! $errors->first('multivalue', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="button" id="add_new_child" class="btn btn-primary btn-sm" value="add"><i class="la la-plus"></i>Add Options</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-secondary btn-sm" data-dismiss="modal" value="Close">
            </div>
        </div>
    </div>
</div>
<!--End Add Edit Feature Child Method  html-->
@endsection

@push('custom_js')
    <script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
    <script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            var target = $('.sort_menu');
            target.sortable({
                handle: '.handle',
                placeholder: 'highlight',
                axis: "y",
                update: function (e, ui){
                    var sortData = target.sortable('toArray',{ attribute: 'data-id'})
                    updateToDatabase(sortData.join(','),'parent')
                }
            });
            var target_child = $('.sort_menu_child');
            target_child.sortable({
                handle: '.handle',
                placeholder: 'highlight',
                axis: "y",
                update: function (e, ui){
                    var sortData = target_child.sortable('toArray',{ attribute: 'data-id'})
                    updateToDatabase(sortData.join(','),'child')
                }
            });
            // var value = $(this).find(":selected").val();
            // if (value == 2) {
            //     $('#add_new_option').fadeIn();
            //     $('#multiselect_section').fadeIn();
            // }else{
            //     $('#add_new_option').fadeOut();
            //     $('#multiselect_section').fadeOut();
            // }
        })
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var get_url = $('#base_url').val();
        $(document).on('click','#add,#update,#delete',function () {
            var value       = $(this).closest('.row').find('input[name="multivalue"]').val();
            var row         = $(this).closest('.row');
            var pk_no       = $(this).data('pk_no');
            var type        = $(this).val();
            if (type != 'delete' && value == '') {
                toastr.warning('Value can not be empty','Error');
                return false;
            }
            if (type == 'delete') {
                if(!confirm('Are you sure your want to delete?')){
                    return false;
                }
            }
            $.ajax({
                type:'POST',
                url:get_url+'/addUpdateFeature',
                data: {
                    value:value,
                    type:type,
                    pk_no:pk_no,
                    parent:`{{ $data['parent']->PK_NO }}`
                },
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (data) {
                    if (data['status'] == 1) {
                        toastr.success(data['msg'],'Success');
                        if (type == 'delete') {
                            row.closest('.list-group-item').fadeOut();
                            row.closest('.list-group-item').remove();
                        }else if(type == 'add'){
                            if (data['data']['html'] != '') {
                                $('#child-section').append(data['data']['html']);
                                row.find('input[name="multivalue"]').val('');
                            }
                        }
                    }else{
                        toastr.warning(data['msg'],'Error');
                    }
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            });
        })
        $(document).on('change','#feature_type',function () {
            var value = $(this).find(":selected").val();
            if (value == 2) {
                $('#add_new_option').fadeIn();
                $('#multiselect_section').fadeIn();
            }else{
                $('#add_new_option').fadeOut();
                $('#multiselect_section').fadeOut();
            }
        }).trigger('change');
        $(document).on('click','.add_child', function(e){

            e.preventDefault();
            var pk_no = $(this).data('pk_no');
            var value = $(this).closest('.row').find('input[name="multivalue"]').val();
            $('#feature_parent_pk').val(pk_no);
            $('#feature_parent_name').val(value);
            $('#modal_title').html('Childs of '+value);
            $.ajax({
                type:'POST',
                url:get_url+'/showFeatureChilds',
                data: {
                    pk_no:pk_no,
                },
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (data) {
                    if (data['status'] == 1) {
                        $('#feature_childs_view').html(data['data']['html']);
                        // $('#feature_childs_view').append();
                        $('#popup_feature_childs').modal('show');
                    }else{
                        toastr.warning(data['msg'],'Error');
                    }
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            });
        });
        $(document).on('click','#add_new_child,#update_child,#delete_child',function () {
            var value       = $(this).closest('.row').find('input[name="multivalue"]').val();
            var row         = $(this).closest('.row');
            var pk_no       = $(this).data('pk_no');
            var type        = $(this).val();
            var feature_parent_pk = $('#feature_parent_pk').val();
            var feature_parent_name = $('#feature_parent_name').val();
            if (type != 'delete' && value == '') {
                toastr.warning('Value can not be empty','Error');
                return false;
            }
            if (type == 'delete') {
                if(!confirm('Are you sure your want to delete?')){
                    return false;
                }
            }
            $.ajax({
                type:'POST',
                url:get_url+'/addUpdateFeatureChilds',
                data: {
                    value:value,
                    type:type,
                    pk_no:pk_no,
                    parent_pk:feature_parent_pk,
                    parent_name:feature_parent_name
                },
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (data) {
                    if (data['status'] == 1) {
                        toastr.success(data['msg'],'Success');
                        if (type == 'delete') {
                            row.closest('.list-group-item').fadeOut();
                            row.closest('.list-group-item').remove();
                        }else if(type == 'add'){
                            if (data['data']['html'] != '') {
                                $('#feature_childs_view').append(data['data']['html']);
                                row.find('input[name="multivalue"]').val('');
                            }
                        }
                    }else{
                        toastr.warning(data['msg'],'Error');
                    }
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            });
        })
        function updateToDatabase(idString,type){
            $.ajax({
                url:get_url+'/update-feature-order',
                method:'POST',
                data:{ids:idString,type:type},
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success:function(data){
                    if (data['status'] == 1) {
                        toastr.success(data['msg'],'Success');
                    }else{
                        toastr.warning(data['msg'],'Error');
                    }
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            })
        }
    </script>
@endpush
