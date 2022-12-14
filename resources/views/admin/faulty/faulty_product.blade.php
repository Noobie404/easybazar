@extends('admin.layout.master')

@section('Warehouse Operation','open')
@section('product_list_','active')


@section('title') Lost Product @endsection
@section('page-name') Lost Product @endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('order.breadcrumb_dashboard_title') </a></li>
<li class="breadcrumb-item active">Lost Product </li>
@endsection

@push('custom_css')
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" type="text/css" href="{{asset('/assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/forms/icheck/icheck.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/forms/icheck/custom.css')}}">

<style>
#warehouse td {border: none;border-bottom: 1px solid #333;font-size: 12px;font-weight: normal;padding-bottom: 7px;/* padding-bottom: 15px; */}
#warehouse tr{margin-bottom: 5px;display: block;height: 34px;}
#book_qty th {border: none;/* border-bottom: 1px solid #333; */font-size: 12px;font-weight: normal;padding-bottom: 5px;padding-top: 0;}
#faulty_table td{border-top: none;height: 34px;}
</style>

@endpush('custom_css')

@section('content')
<div class="card card-success min-height">
    <div class="card-header">
        <h4 class="card-title" id="basic-layout-colored-form-control"><i class="ft-plus text-primary"></i> Lost Product &nbsp;
            @if (Request::segment(4) == 'dispatched')
            <a href="{{ route('admin.faulty.list',['type'=>'product','id'=>Request::segment(3)]) }}" class="btn btn-sm btn-warning c-btn active" style="min-width:90px;">All List </a>
            @else
            <a href="{{ route('admin.faulty.list',['type'=>'product','id'=>Request::segment(3),'dispatched'=>'dispatched']) }}" class="btn btn-sm btn-warning c-btn active" style="min-width:90px;">Dispatched List </a>
            @endif
        </h4>

        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
        </div>
    </div>
    <div class="card-content collapse show">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-body" id="order_form">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-borde alt-pagination table-sm" id="faulty_table">
                                <thead>
                                    <tr>
                                        <th style="width: 200px">@lang('tablehead.image')</th>
                                        <th style="width: 200px">@lang('tablehead.product_name')</th>
                                        <th class="" style="width: 70px;">@lang('tablehead.warehouse')</th>

                                        <th class="" style="width: 10px;">Regular Price</th>
                                        <th class="" style="width: 10px;">Special Price</th>
                                        <th class="" style="width: 10px;">Wholesale Price</th>
                                        <th class="checkBox" style="width: 10px;">Invoice</th>
                                        <th class="checkBox" style="width: 10px;">Faulty</th>
                                    </tr>
                                </thead>
                                <tbody id="append_tr">
                                    @if($data && count($data) > 0 )
                                    @foreach($data as $key => $val)

                                        <?= $val->product_info; ?>

                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@include('admin.faulty.mark_faulty_modal')
@endsection
<!--push from page-->
@push('custom_js')
<script type="text/javascript" src="{{ asset('assets/js/common.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script>
function mark_faulty_fun(type,pk_no,faulty_type,the) {
    if(confirm('Are you sure ?')){
        var get_url = $('#base_url').val();
        if($(the).is(":checked")) {
            $.ajax({
                type:'get',
                url:get_url+'/faulty-checker/product/'+pk_no+'/'+faulty_type,
                async :true,
                dataType: 'json',
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (data) {
                    if (data == 1) {
                        toastr.success('Product Is Marked As Faulty !', 'Product Faulty Marked !');
                        $(the).prop("disabled", true);
                        $('#mark_faulty_popup'+pk_no).removeClass('btn-warning');
                        $('#mark_faulty_popup'+pk_no).addClass('btn-danger');
                        $('#mark_faulty_modal').modal('hide');
                    }else{
                        toastr.danger('Something is wrong !', 'Please Try Again !');
                    }
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            });
        }else{
            $(the).prop("checked", false);
        }
    }else{
        $(the).prop("checked", false);
    }
}
$(document).on('click','#faulty_non_sellable', function(){
    var pk_no = 0;
    pk_no = $(this).data('pk_no');
    var booking_no      = $(this).data('booking_no');
    if (booking_no > 0) {
        alert('There is a booking/order in this product !');
        $(this).prop("checked", false);
        // $('#mark_faulty_modal').modal('hide');
    }else{
        // $('#mark_faulty_modal').modal('show');
        mark_faulty_fun('product',pk_no,'non-sellable',this);
    }
});
$(document).on('click','#faulty_sellable', function(){
    // var pk_no2 = 0;
    // pk_no2 = $(this).data('pk_no');
    mark_faulty_fun('product',$(this).data('pk_no'),'sellable',this);
});
$(document).on('click','[id*=mark_faulty_popup]', function(){
        var pk_no           = $(this).data('pk_no');
        var product_status  = $(this).data('product_status');
        var is_faulty       = $(this).data('is_faulty');
        var booking_no      = $(this).data('booking_no');
        $('.modal-body').html("");
        $('.modal-body').append('<label><input id="faulty_sellable" name="faulty_sellable" type="checkbox" value="1"> Mark as faulty but sellable</label><br><br><label><input id="faulty_non_sellable" name="faulty_non_sellable" type="checkbox" value="1"> Mark as faulty and lost<label>');
        $('#mark_faulty_modal').modal('show');

        $('#faulty_sellable').attr('data-pk_no',pk_no);
        $('#faulty_sellable').attr('data-booking_no',booking_no);
        $('#faulty_non_sellable').attr('data-pk_no',pk_no);
        $('#faulty_non_sellable').attr('data-booking_no',booking_no);
        if (product_status == 420) {
            $('#faulty_non_sellable').prop("checked", true);
            $('#faulty_non_sellable').attr("disabled", true);
        }else{
            $('#faulty_non_sellable').prop("checked", false);
            $('#faulty_non_sellable').attr("disabled", false);
        }
        if (is_faulty == 1) {
            $('#faulty_sellable').prop("checked", true);
            $('#faulty_sellable').attr("disabled", true);
        }else{
            $('#faulty_sellable').prop("checked", false);
            $('#faulty_sellable').attr("disabled", false);
        }
});
</script>
@endpush('custom_js')
