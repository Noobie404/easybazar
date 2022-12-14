@extends('admin.layout.master')
@section('postage_list','active')
{{-- @section('Role Management','open') --}}
@section('title')
    @lang('admin_action.edit_page_title')
@endsection
@section('page-name')
    @lang('admin_action.edit_page_sub_title')
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">@lang('admin_action.breadcrumb_title')</a></li>
    <li class="breadcrumb-item active">Postage</li>
@endsection
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">

@section('content')
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header">
                <h4 class="card-title" id="basic-layout-colored-form-control">Postage</h4>
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
                    {!! Form::open([ 'route' => [ 'admin.customer_address_postage.put', $data['postage_details']->PK_NO ?? 0], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                    @csrf
                    <div class="form-body">
                        <div class="col-md-6 offset-3">
                            <div class="form-group">
                                <label>Country</label>
                                <div class="controls">
                                    {!! Form::select('country', $data['countryCombo'], $data['postage_details']->F_COUNTRY_NO ?? 1, [ 'class' => 'form-control mb-1 select2 ', 'id'=>'country','data-validation-required-message' => 'This Filed Is Required']) !!}
                                </div>
                                @if ($errors->has('country'))
                                    <div class="alert alert-danger">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 offset-3">
                            <div class="form-group">
                                <label>State</label>
                                <div class="controls">
                                    {!! Form::select('state', $data['stateCombo'], $data['postage_details']->F_STATE_NO ?? null, [ 'class' => 'form-control mb-1 select2', 'id'=>'state','data-validation-required-message' => 'This Filed Is Required']) !!}
                                </div>
                                @if ($errors->has('state'))
                                    <div class="alert alert-danger">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 offset-3">
                            <div class="form-group">
                                <label>City</label>
                                <div class="controls">
                                    {!! Form::select('city', $data['cityCombo'] ?? array(), $data['postage_details']->F_CITY_NO ?? null, [ 'class' => 'form-control mb-1 select2', 'id'=>'city', 'data-validation-required-message' => 'This Filed Is Required']) !!}
                                </div>
                                @if ($errors->has('city'))
                                    <div class="alert alert-danger">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 offset-3">
                            <div class="form-group">
                                <label>Post Code</label>
                                <div class="controls">
                                    {!! Form::text('postage', $data['postage_details']->PO_CODE ?? null, [ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This Filed Is Required', 'placeholder' => 'Enter Post Code','id'=>'postage', 'tabindex' => 2 ]) !!}
                                </div>
                                @if ($errors->has('postage'))
                                    <div class="alert alert-danger">
                                        <strong>{{ $errors->first('postage') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-actions text-center">
                            <a href="{{ route('admin.address_type.postage_list_') }} " class="btn btn-warning mr-1" title="Cancel"><i class="ft-x"></i> @lang('form.btn_cancle')</a>
                            <button type="submit" class="btn btn-primary" title="Save"><i class="la la-check-square-o"></i> {{ isset($data['postage_details']->PK_NO) != 0 ? 'Update' : 'Add'}}</button>
                        </div>
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
<script>
    function getPostage(city) {
        var get_url = $('#base_url').val();
        $.ajax({
            type:'get',
            url:get_url+'/customer_postage_by_city/'+city,
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                    $('#postage').val(data.PO_CODE);
                    // var city_id = $('#city').find(":selected").val();
                    // getPostage(city_id);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    }
    function getCity(state) {
        var get_url = $('#base_url').val();
        $.ajax({
            type:'get',
            url:get_url+'/customer_city_by_state/'+state,
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                console.log(data);
                    $('#city').html(data);
                    var city_id = $('#city').find(":selected").val();
                    getPostage(city_id);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    }
    function getState(country) {
        var get_url = $('#base_url').val();
        $.ajax({
            type:'get',
            url:get_url+'/customer_state_by_country/'+country,
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                    $('#state').html(data);
                    var state_id = $('#state').find(":selected").val();
                    state_id = state_id !== '' ? state_id : 0;
                    console.log(state_id);
                    getCity(state_id);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    }
    $(document).on('change','#country', function(){
        var country_id     = $(this).val();
        $('#city').html('');
        $('#postage').val('');
        getState(country_id);
    });
    $(document).on('change','#state', function(){
        var state_id     = $(this).find(":selected").val();
        $('#city').html('');
        $('#postage').val('');
        getCity(state_id);
    });
    $(document).on('change','#city', function(){
        var city_id     = $(this).find(":selected").val();
        getPostage(city_id);
    });
</script>
@endpush
