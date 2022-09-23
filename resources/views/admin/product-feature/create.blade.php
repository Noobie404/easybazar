@extends('admin.layout.master')
@section('product feature master','active')

@section('title') Product feature | Create @endsection
@section('page-name') Create Variant Factor @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href=""> Variant Factor</a></li>
    <li class="breadcrumb-item active">Create Variant Factor</li>
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
   $productFeatureType = Config::get('static_array.product_feature_type');
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
            {!! Form::open([ 'route' => 'admin.product-feature.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
            {!! Form::hidden('multiselect_attributes', null, ['id' => 'multiselect_attributes']) !!}
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                            <label>@lang('form.name')<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::text('name', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter product feature name', 'data-validation-required-message' => 'This field is required', 'tabindex' => 2 ]) !!}
                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('title') ? 'error' : '' !!}">
                            <label>Title</label>
                            <div class="controls">
                                {!! Form::text('title', null, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter product feature title', 'tabindex' => 3 ]) !!}
                                {!! $errors->first('title', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('type') ? 'error' : '' !!}">
                            <label>Type<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('type',$productFeatureType ,null, [ 'class' => 'form-control mb-1','id' => 'feature_type', 'data-validation-required-message' => 'This field is required', 'tabindex' => 4 ]) !!}
                                {!! $errors->first('type', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('is_required') ? 'error' : '' !!}">
                            <label>Is Required<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('is_required',array(1=>'Yes',0=>'No'), null, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => 5 ]) !!}
                                {!! $errors->first('is_required', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('is_color') ? 'error' : '' !!}">
                            <label>Treat as COLOR<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('is_color',array(0=>'No',1=>'Yes'), 0, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => 6 ]) !!}
                                {!! $errors->first('is_color', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                            <label>Is Active<span class="text-danger">*</span></label>
                            <div class="controls">
                                {!! Form::select('is_active',array(1=>'Yes',0=>'No'), null, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => 7 ]) !!}
                                {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 offset-4">
                        <div class="form-group {!! $errors->has('description') ? 'error' : '' !!}">
                            <label>Description</label>
                            <div class="controls">
                                {!! Form::textarea('description', '', [ 'class' => 'form-control mb-1', 'tabindex' => 8,'rows' => 2 ]) !!}
                                {!! $errors->first('description', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="multiselect_section">
                    <div class="col-lg-4 offset-4">
                        <div id="child-section" class="sort_menu list-group">
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
                        <i class="la la-check-square-o"></i>@lang('form.btn_save')
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
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
                    rearrangeArray(sortData.join(','))
                }
            })
        })
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function rearrangeArray(arrayOrder) {
            var new_array = [];
            arrayOrder = arrayOrder.split(",");
            $.each(arrayOrder,function (i,v) {
                new_array.push(array[v]);
            });
            array = new_array;
            reassignArray();
        }
        function reassignArray() {
            $('#child-section').find('.list-group-item').each(function( index, row ) {
                var rows = $(row);
                rows.attr('data-id',index);
                rows.find('#update').attr('data-pk_no',index);
                rows.find('#delete').attr('data-pk_no',index);
            });
            $('#multiselect_attributes').val(array);
        }
        var get_url = $('#base_url').val();
        var array = [];
        var render_html =
        '<div class="list-group-item pb-0" data-id="">'+
            '<div class="row">'+
                '<div class="col-md-1 pl-0" align="left">'+
                '<span class="handle"></span>'+
                '</div>'+
                '<div class="col-md-6">'+
                    '<div class="form-group">'+
                        '<div class="controls">'+
                            '<input type="text" class="form-control mb-1" id="name" placeholder="Enter value">'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<div class="col-md-auto pl-0" align="right">'+
                    '<button type="button" id="update" class="btn btn-info btn-sm" title="UPDATE" value="update" data-pk_no=""><i class="la la-edit"></i>Update</button> '+
                    '<button type="button" id="delete" class="btn btn-danger btn-sm" title="DELETE" value="delete" data-pk_no="" ><i class="la la-trash"></i>Delete</button> '+
                '</div>'+
            '</div>'+
        '</div>';
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
                }else{
                    array.splice(pk_no, 1);
                    row.closest('.list-group-item').fadeOut();
                    row.closest('.list-group-item').remove();
                    reassignArray();
                    toastr.success('Item removed successfully !','Success');
                }
            }else if(type == 'add'){
                if (array.includes(value) === false) {
                    array.push(value);
                    row.find('input[name="multivalue"]').val('');
                    $('#child-section').append(render_html);
                    $('#child-section').find('.list-group-item').each(function( index, row ) {
                        var rows = $(row);
                        rows.attr('data-id',index);
                        rows.find('input[id="name"]').val(array[index]);
                        rows.find('#update').attr('data-pk_no',index);
                        rows.find('#delete').attr('data-pk_no',index);
                    });
                    $('#multiselect_attributes').val(array);

                }else{
                    toastr.warning('Duplicate value','Error');
                }
            }else if(type == 'update'){
                array[pk_no] = value;
                toastr.success('Value updated successfully !','Success');
            }
        })
        // $(document).on('change','#feature_type',function () {
        //     var value = $(this).find(":selected").val();
        //     if (value == 2) {
        //         $('#add_new_option').fadeIn();
        //         $('#multiselect_section').fadeIn();
        //     }else{
        //         $('#add_new_option').fadeOut();
        //         $('#multiselect_section').fadeOut();
        //     }
        // }).trigger('change');
    </script>
@endpush
