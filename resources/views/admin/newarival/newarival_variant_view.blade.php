@extends('admin.layout.master')

@section('Sales Report','open')
@section('newarival','active')

@section('title') New Arival Variant List @endsection
@section('page-name') New Arival Variant List @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('shipping.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">New Arival Variant List</li>
@endsection

@php
    $roles = userRolePermissionArray();
    use Carbon\Carbon;
    $master_no = $data['na_master']->PK_NO;

@endphp

@push('custom_css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <style>
        .select2-container--classic .select2-selection--multiple .select2-selection__choice, .select2-container--default .select2-selection--multiple .select2-selection__choice{ padding: 1px 25px !important;}
        .edit_order_id{display: none;}
        .edit_order_id .form-group{display: block;}
        .edit_order_id input.order_id{width: 80px; margin: 0 auto;}
        .edit_order_id .form-group{margin-bottom: 5px;}
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover, .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:focus {
        background-color: #666ee8 !important;}
        ol, ul, dl {margin-bottom: 0rem;}
        .add_section{display: none;}
        .select2, .select2-container{width: 100% !important}
    </style>
@endpush('custom_css')


@section('content')
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <div class="form-group">
                                @if(hasAccessAbility('new_newarival', $roles))
                                    <button type="button" class="text-white btn btn-sm btn-primary add_section_show" title="Add new " ><i class="ft-plus text-white"></i> Add new Product</button>
                                @endif
                                @if(hasAccessAbility('edit_newarival', $roles))
                                    <button type="button" class="text-white btn btn-sm btn-danger" id="bulk_delete" title="Delete" >Delete</button>

                                @endif
                            </div>

                            <div class="heading-elements">
                             <h4>{{ $data['master']->DEFAULT_NAME ?? '' }}</h4>
                            </div>
                          </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="row well add_section" style="background-color: #b5b3b555; padding: 20px;">
                                    <div class="col-12">
                                    {!! Form::open([ 'route' => 'admin.newarival_variant.create', 'method' => 'post', 'class' => 'form-horizontal top_sell_create', 'files' => true , 'novalidate']) !!}
                                        <input type="hidden" value="{{ $data['na_master']->F_NA_MASTER_NO }}" name="na_master">
                                    <div class="form-group {!! $errors->has('product_id') ? 'error' : '' !!}">
                                        <label class="mb-1">Select Product<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <select class="form-control select2-multiple" multiple="multiple" name="product_id[]" required></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-sm btn-success" type="submit">Save</button>
                                        <button type="button" class="text-white btn btn-sm btn-danger pull-right add_section_close" title="Close" >Close</button>
                                    </div>



                                    {!! Form::close() !!}
                                    </div>
                                </div>

                                <div class="table-responsive p-1">
                                    <table class="table table-striped table-bordered table-sm" id="process_data_table_">
                                        <thead>
                                        <tr>
                                            <th class="text-center">SL.</th>
                                            <th class="text-left">Branch</th>
                                            <th class="text-left">Varaint name</th>
                                            <th>Is manual</th>
                                            <th>Order ID</th>
                                            <th style="width: 11%" class="text-center">
                                                <label class="c-p"><input type="checkbox" id="bulk_check" class="c-p"> Action </label>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>

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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click','.order_id_show', function(e){
        $(this).closest('td').find('.edit_order_id').show();
        $(this).hide();
    })
    $(document).on('click','.order_id_close', function(e){
        $(this).closest('td').find('.edit_order_id').hide();
        $(this).closest('td').find('.order_id_show').show();

    })


    // Use datepicker on the date inputs
    $('.pickadate').pickadate({
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy',
        //max:!0,
    });

$(document).on('click', '.add_section_show', function(){
    $('.add_section').show();
})
$(document).on('click', '.add_section_close', function(){
    $('.add_section').hide();
})


$(document).on('submit', '.edit_order_id', function(){
    var form = $(this);
    if(confirm('Are you sure?')) {
        $.ajax({
                type :'post',
                data:form.serialize(),
                url:form.attr('action'),
                async :true,
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (data) {
                    if(data.status == true){
                        getProduct();
                    }else{
                        toastr.info('Please try again','Info');
                    }
                },
                complete: function (data){
                    $("body").css("cursor", "default");
                }
            });


    }

  return false;
});
$(document).on('submit', '.top_sell_create', function(){
    var form = $(this);
    if(confirm('Are you sure?')) {
        $.ajax({
                type :'post',
                data:form.serialize(),
                url:form.attr('action'),
                async :true,
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (data) {
                    $('.select2-multiple').empty();
                    if(data.status == true){
                        getProduct();
                    }else{
                        toastr.info('Please try again','Info');
                    }
                },
                complete: function (data){
                    $("body").css("cursor", "default");
                    $('.select2-multiple').empty();
                }
            });


    }

  return false;
});




    $(document).on("click", "#bulk_check", function(event){
        $(".record_check").prop('checked', $(this).prop("checked"));

    });
    var get_url = $('#base_url').val();
    $(document).on("click", "#bulk_delete", function(event){
        var draft = [];
        $("input:checkbox[name=record_check]:checked").each(function(){
            draft.push($(this).val());
        });

        if (draft != '') {
            var url = get_url + '/newarival-variant/delete';
            if(confirm('Are you sure?')) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {'draft' : draft},
                    success: function(data) {
                        console.log(data);
                        if(data.status == true){
                            getProduct();
                        }else{
                            toastr.info('Please try again','Info');
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {}
                });

            }else{
                $("input:checkbox[name=record_check]:checked").prop('checked', false);
            }

        }else{
            toastr.info('Please check at list single record','Info');
        }
    })


</script>

<script>

    $(document).ready(function() {
        getProduct();

    });

    function getProduct(){
        var get_top_sell_view = `{{ route('admin.get_newarival_variant', $master_no) }}`;
        var table =
            $('#process_data_table_').DataTable({
                processing: false,
                serverSide: true,
                paging: true,
                pageLength: 25,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                bDestroy: true,
                ajax: {
                    url: get_top_sell_view,
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
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'SHOP_NAME',
                            name: 'SHOP_NAME',
                            searchable: true,
                            class: 'text-left'
                        },
                        {
                            data: 'VARIANT_NAME',
                            name: 'VARIANT_NAME',
                            searchable: true,
                            class: 'text-left'
                        },
                        {
                            data: 'is_manual',
                            name: 'is_manual',
                            searchable: true,
                        },
                        {
                            data: 'order_id',
                            name: 'order_id',
                            searchable: false
                        },

                        {
                            data: 'action',
                            name: 'action',
                            searchable: false,
                            class: 'text-center',
                            orderable: false,
                        }
                ]
            });
    }
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $('.select2-multiple').select2({
            ajax: {
            url: "{{route('get-newarival-variant', $master_no)}}",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
            return {
            _token: CSRF_TOKEN,
            search: params.term // search term
            };
            },
            processResults: function (response) {
            return {
            results: response
            };
            },
            cache: true
            }

    });

</script>


@endpush
