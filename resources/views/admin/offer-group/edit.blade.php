@extends('admin.layout.master')

@section('offer_group','active')
@section('offer_management','open')

@section('title') Edit offer group @endsection
@section('page-name') Edit offer group @endsection

<!--push from page-->
@push('custom_css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">


    <style>
        .text-normal{font-weight:400}body{font-family:Ubuntu,sans-serif;font-weight:700}.select2-container{min-width:400px}.select2-results__option{padding-right:20px;vertical-align:middle}.select2-results__option:before{content:"";display:inline-block;position:relative;height:20px;width:20px;border:2px solid #887777;border-radius:4px;background-color:#fff;margin-right:20px;vertical-align:middle}.select2-results__option[aria-selected=true]:before{font-family:fontAwesome;content:"\f00c";color:#fff;background-color:#f77750;border:0;display:inline-block;padding-left:3px}.select2-container--default .select2-results__option[aria-selected=true]{background-color:#fff}.select2-container--default .select2-results__option--highlighted[aria-selected]{background-color:#eaeaeb;color:#272727}.select2-container--default .select2-selection--multiple{margin-bottom:10px}.select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple{border-radius:4px}.select2-container--default.select2-container--focus .select2-selection--multiple{border-color:#f77750;border-width:2px}.select2-container--default .select2-selection--multiple{border-width:2px}.select2-container--open .select2-dropdown--below{border-radius:6px;box-shadow:0 0 10px rgba(0,0,0,.5)}.select2-selection .select2-selection--multiple:after{content:'hhghgh'}
    </style>



@endpush('custom_css')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('payment.breadcrumb_title')  </a></li>
    <li class="breadcrumb-item active">Edit offer group</li>
@endsection


@section('content')

<section id="basic-form-layouts">
    <div class="row match-height min-height">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-content collapse show">
                    <div class="card-body">
                        {!! Form::open([ 'route' => ['admin.offergroup.update',$data['row']->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                                        <label>@lang('form.name')<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            {!! Form::text('name',$data['row']->BUNDLE_NAME, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter offer group name', 'data-validation-required-message' => 'This field is required', 'tabindex' => 1 ]) !!}
                                            {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {!! $errors->has('public_name') ? 'error' : '' !!}">
                                        <label>@lang('form.public_name')<span class="text-danger">*</span></label>
                                        <div class="controls">
                                            {!! Form::text('public_name',$data['row']->BUNDLE_NAME_PUBLIC, [ 'class' => 'form-control mb-1', 'placeholder' => 'Enter offer group public name', 'data-validation-required-message' => 'This field is required', 'tabindex' => 2 ]) !!}
                                            {!! $errors->first('public_name', '<label class="help-block text-danger">:message</label>') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Thumbnail Image<span class="required"></span></h5>
                                    <div class="form-group {!! $errors->has('image') ? 'error' : '' !!}">
                                     <div class="controls">
                                         <div class="fileupload @if(!empty($data['row']->IMAGE))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                         <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                         @if(!empty($data['row']->IMAGE))
                                         <img src="{{ asset($data['row']->IMAGE) }}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                         @endif
                                         </span>
                                         <span>
                                         <label class="btn btn-info text-white btn-file btn-sm">
                                         <span class="fileupload-new">
                                         <i class="la la-file-image-o"></i> Select Image
                                         </span>
                                         <span class="fileupload-exists">
                                         <i class="la la-reply"></i> Change
                                         </span>
                                         {!! Form::file('image', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'image', 'tabindex' => 5]) !!}
                                         </label>
                                         <a href="#" class="btn fileupload-exists btn-danger btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                         <i class="la la-times"></i> Remove
                                         </a>
                                         </span>
                                         <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}}  800 x 800 pixels</span>
                                      </div>
                                      @if ($errors->has('image'))
                                      <span class="alert alert-danger">
                                          <strong>{{ $errors->first('image') }}</strong>
                                      </span>
                                  @endif
                                </div>
                                 </div>
                                </div>

                                <div class="col-md-6">
                                    <h5>Banner Image <span class="required"></span></h5>
                                    <div class="form-group {!! $errors->has('image') ? 'error' : '' !!}">
                                     <div class="controls">
                                         <div class="fileupload @if(!empty($data['row']->BANNER_IMAGE))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                         <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                         @if(!empty($data['row']->BANNER_IMAGE))
                                         <img src="{{ asset($data['row']->BANNER_IMAGE) }}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                         @endif
                                         </span>
                                         <span>
                                         <label class="btn btn-info text-white btn-file btn-sm">
                                         <span class="fileupload-new">
                                         <i class="la la-file-image-o"></i> Select Image
                                         </span>
                                         <span class="fileupload-exists">
                                         <i class="la la-reply"></i> Change
                                         </span>
                                         {!! Form::file('banner_image', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'image', 'tabindex' => 5]) !!}
                                         </label>
                                         <a href="#" class="btn fileupload-exists btn-danger btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                         <i class="la la-times"></i> Remove
                                         </a>
                                         </span>
                                         <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}}  1920 x 145 pixels</span>
                                      </div>
                                      @if ($errors->has('banner_image'))
                                      <span class="alert alert-danger">
                                          <strong>{{ $errors->first('banner_image') }}</strong>
                                      </span>
                                  @endif
                                </div>
                                 </div>
                                </div>
                            </div>

                            <div class="row card p-1">
                                <div class="col-md-12">

                                    <div class="row">
                                        <div class="col-md-2"><h4>Select Offer</h4></div>
                                        <div class="col-md-10">
                                            <div class="form-group {!! $errors->has('offers') ? 'error' : '' !!} mb-0">
                                                <div class="controls">
                                                    {!! Form::select('offers[]', $data['offers'] ?? array() , $data['select_offers'] ?? [], [ 'class' => 'form-control mb-1 js-select2','data-validation-required-message' => 'This field is required',  'tabindex' => 4, 'multiple' => true ]) !!}
                                                    {!! $errors->first('offers', '<label class="help-block text-danger">:message</label>') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                        </div>
                                    </div>


                                <div class="form-actions text-center mt-3">
                                    <a href="{{ route('admin.offergroup.list') }}">
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
        </div>
    </section>
@endsection

@push('custom_js')
    <script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>

    <script>

        $(".js-select2").select2({
            closeOnSelect : false,
            placeholder : "Placeholder",
            allowHtml: true,
            allowClear: true,
            tags: true // создает новые опции на лету
        });

</script>

@endpush()


