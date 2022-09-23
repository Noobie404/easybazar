@extends('admin.layout.master')
@section('product attr master','active')

@section('title') Product attribute child | Create @endsection
@section('page-name') Create product attribute child @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('admin.product-model') }}"> product attribute child </a> </li>
<li class="breadcrumb-item active">Create product attribute child </li>
@endsection

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<style>
    .list-group-item {align-items: center;}
    .highlight {background: #f7e7d3;min-height: 50px;list-style-type: none;}
    .handle {min-width: 15px;background: #607D8B;height: 15px;display: inline-block;cursor: move;margin-left: 12px;margin-top: 9px;}
</style>
@endpush

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
            <div class="form-body">
                <div class="row">
                    <h5 align="center" style="width: 100%"><b>Attribute name : </b>{{ $data['master']->NAME }}</h5>
                    {!! Form::hidden('', $data['master']->PK_NO, ['id' => 'parent']) !!}
                    {!! Form::hidden('', $data['master']->NAME, ['id' => 'parent_name']) !!}
                </div>
                <div class="row mb-3">
                    <h5 align="center" style="width: 100%"><b>Attribute type : </b>{{$data['master']->ATTRIBUTE_TYPE == 1 ? 'Text' : ($data['master']->ATTRIBUTE_TYPE == 2 ? 'Dropdown' : ($data['master']->ATTRIBUTE_TYPE == 3 ? 'Multiselect' : 'Number'))}}</h5>
                </div>
                <div class="row">
                    <div class="col-lg-6 offset-2">
                        <div id="child-section" class="sort_menu list-group">
                        @if (isset($data['child']) && !empty($data['child']))
                            @foreach ($data['child'] as $item)
                            <div class="list-group-item pb-0" data-id="{{ $item->PK_NO }}">
                                <div class="row">
                                    <div class="col-md-1" align="left">
                                    <span class="handle"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                            <div class="controls">
                                                {!! Form::text('name', $item->VALUE ?? null, [ 'class' => 'form-control mb-1','id'=>'name', 'placeholder' => 'Enter value','tabindex' => 1 ]) !!}
                                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-auto" align="right">
                                        <button type="button" id="update" class="btn btn-info btn-sm" title="UPDATE"value="update" data-pk_no="{{ $item->PK_NO }}"><i class="la la-edit"></i>Update</button>
                                        <button type="button" id="delete" class="btn btn-danger btn-sm" title="DELETE" value="delete" data-pk_no="{{ $item->PK_NO }}" ><i class="la la-trash"></i>Delete</button>
                                        <div class="controls" style="display: inline-block;">
                                        {!! Form::select('is_active', array(1=>'Yes',0=>'No'), $item->IS_ACTIVE ?? 1, ['class' =>'custom-select','id'=>'is_active','style' => 'font-size: 12px;','data-pk_no' => $item->PK_NO]) !!}
                                        </div>
                                        <div style="display: inline-block;">
                                            <i class="la la-question-circle" style="font-size: 22px;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        </div>
                    </div>
                </div>
                <div id="new_empty_section">
                </div>
                <div class="row">
                    <div class="col-md-4 offset-3 mt-3">
                        <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                            <div class="controls">
                                {!! Form::text('name', null, [ 'class' => 'form-control mb-1','id'=>'name', 'placeholder' => 'Enter value','tabindex' => 1 ]) !!}
                                {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mt-3">
                        <button type="button" id="add" class="btn btn-primary btn-sm" value="add"><i class="la la-plus"></i>Add</button>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-md-4 offset-3">
                        <button type="button" id="add_new_field" class="btn btn-success btn-sm" value="add"><i class="la la-plus"></i>Add New Field</button>
                    </div>
                </div> --}}
                <div class="form-actions text-center mt-3">
                    <a href="{{route('admin.product-attr.index')}}">
                        <button type="button" class="btn btn-warning mr-1">
                            <i class="ft-x"></i>@lang('form.btn_cancle')
                        </button>
                    </a>
                </div>
                <div id="result"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('custom_js')
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var get_url = $('#base_url').val();
    $(document).on('click','#add,#update,#delete',function () {
        var value       = $(this).closest('.row').find('input[name="name"]').val();
        var row         = $(this).closest('.row');
        var parent_name = $('#parent_name').val();
        var pk_no       = $(this).data('pk_no');
        var parent      = $('#parent').val();
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
            url:get_url+'/addUpdateChild',
            data: {
                value:value,
                type:type,
                pk_no:pk_no,
                parent:parent,
                parent_name:parent_name
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
                            row.find('input[name="name"]').val('');
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
    // $(document).on('click','#add_new_field',function () {
    //     $('#new_empty_section').append('<div class="row"><div class="col-md-4 offset-3"><div class="form-group"><div class="controls"><input class="form-control mb-1" placeholder="Enter value" name="name" type="text"><div class="help-block"></div></div></div></div><div class="col-md-2"><button type="button" id="add" class="btn btn-primary btn-sm" value="add"><i class="la la-plus"></i>Add</button></div></div>');
    // })
    $(document).on('change','select',function () {
        var value = $(this).find(":selected").val();
        var pk_no = $(this).data('pk_no');
        $.ajax({
            type:'POST',
            url:get_url+'/addUpdateFeatureChild',
            data: {
                value:value,
                type:'is_active',
                pk_no:pk_no,
            },
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                if (data['status'] == 1) {
                    toastr.success(data['msg'],'Success');
                }else{
                    toastr.warning(data['msg'],'Error');
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    }).trigger('change');
</script>
<script>
    $(document).ready(function(){
        $('.la-question-circle').tooltip({title: "Wheather you want to view this or not", animation: true});
        function updateToDatabase(idString){
            $.ajax({
                url:get_url+'/update-attribute-order',
                method:'POST',
                data:{ids:idString},
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
        var target = $('.sort_menu');
        target.sortable({
            handle: '.handle',
            placeholder: 'highlight',
            axis: "y",
            update: function (e, ui){
                var sortData = target.sortable('toArray',{ attribute: 'data-id'})
                updateToDatabase(sortData.join(','))
            }
        })
    })
</script>
@endpush
