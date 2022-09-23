@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/pickers/pickadate/pickadate.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/plugins/pickers/daterange/daterange.css')}}">
<style>
    .tt-hint {color: #999 !important;}
    .twitter-typeahead{display: block !important;}
    #scrollable-dropdown-menu .tt-menu {max-height: 260px;Overflow-y: auto;width: 100%;border: 1px solid #333;border-radius: 5px;background:#fff;}
    #scrollable-dropdown-menu .typeahead-header {margin: 5px 20px 5px 20px;padding: 3px 0;}
</style>
@endpush('custom_css')
@section('web','open')
@section('custom link','active')
@section('title') Edit Custom Link Highlighter @endsection
@section('page-name') Edit Custom Link Highlighter @endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Custom Link Highlighter</a></li>
<li class="breadcrumb-item active">Edit Custom Link Highlighter</li>
@endsection
@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-sm card-success" >
                <div class="card-content">
                    <div class="card-body">
                                {!! Form::open([ 'route' => ['web.home.custom_link.update',$data->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                                @csrf
                                {!! Form::hidden('title_id', $data->F_TITLE_NO ?? 0, ['id' => 'title_id']) !!}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('title') ? 'error' : '' !!}">
                                            <label>Select Source <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::select('source', array('Category','Brand','Custom'),$data->TITLE_SOURCE ?? 0, [ 'class' => 'form-control mb-1','id' => 'source','data-validation-required-message' => 'This field is required', 'tabindex' => 1]) !!}
                                                {!! $errors->first('title', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('title') ? 'error' : '' !!}">
                                            <label>Title <span class="text-danger">*</span></label>
                                            <div class="controls" id="scrollable-dropdown-menu">
                                                {!! Form::search('title', $data->TITLE ?? null, [ 'class' => 'form-control search-input mb-1','placeholder' => 'Enter Title (30 LETTERS)','data-validation-required-message' => 'This field is required', 'tabindex' => 2]) !!}
                                                {!! $errors->first('title', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('url_link') ? 'error' : '' !!}">
                                            <label>Url Link</label>
                                            <div class="controls">
                                                {!! Form::url('url_link', $data->URL_LINK ?? null, [ 'class' => 'form-control mb-1','placeholder' => 'Enter url_link', 'tabindex' => 3]) !!}
                                                {!! $errors->first('url_link', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('validity_from') ? 'error' : '' !!}">
                                            <label>@lang('form.validity_from')<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::text('validity_from', date('d-m-Y',strtotime($data->START_DATE)) ?? null, [ 'class' => 'form-control mb-1 pickadate', 'placeholder' => 'Enter date', 'data-validation-required-message' => 'This field is required', 'tabindex' => 4 ]) !!}
                                                {!! $errors->first('validity_from', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('validity_to') ? 'error' : '' !!}">
                                            <label>@lang('form.validity_to')<span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::text('validity_to', date('d-m-Y',strtotime($data->END_DATE)) ?? null,  [ 'class' => 'form-control mb-1 pickadate', 'placeholder' => 'Enter date', 'data-validation-required-message' => 'This field is required', 'tabindex' => 5 ]) !!}
                                                {!! $errors->first('validity_to', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                                            <label>Is Active <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::select('is_active', ['1'=> 'YES','0'=> 'NO'], $data->IS_ACTIVE ?? NULL,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select', 'tabindex' => 6]) !!}
                                                {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('banner') ? 'error' : '' !!}">
                                            <label class="active">Banner Image <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <div class="fileupload @if(!empty($data->IMAGE_NAME))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                @if(!empty($data->IMAGE_NAME))
                                                <img src="{{asset($data->IMAGE_NAME)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                                                @endif
                                                </span>
                                                <span>
                                                <label class="btn btn-primary btn-rounded btn-file btn-sm">
                                                <span class="fileupload-new">
                                                <i class="la la-file-image-o"></i> Select Image
                                                </span>
                                                <span class="fileupload-exists">
                                                <i class="la la-reply"></i> Change
                                                </span>
                                                {!! Form::file('banner', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'IS ACTIVE', 'tabindex' => 7]) !!}
                                                </label>
                                                <a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                <i class="la la-times"></i> Remove
                                                </a>
                                                </span>
                                                <span class="img-note d-block"><i class="la la-bell" aria-hidden="true"></i>{{trans('form.image_size')}}  119 x 60 pixels</span>
                                             </div>
                                                 {!! $errors->first('banner', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-actions text-center">

                                            <button type="submit" class="btn bg-primary bg-darken-1 text-white">
                                             <i class="la la-check-square-o"></i> {{ trans('form.btn_save') }} </button>
                                         </div>
                                     </div>
                                 </div>
                                 {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('custom_js')
<script type="text/javascript" src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

<script>
    $(document).on('change','#source',function(){
        var source = $('#source').find(":selected").val();
        if(source == 2){
            $(".search-input").typeahead("destroy");
        }else{
            $(".search-input").typeahead("destroy");
            typeahead(source);
        }
    })
    $(document).ready(function () {
        $('.pickadate').pickadate({
            format: 'dd-mm-yyyy',
        });
        var source = $('#source').find(":selected").val();
        $(".search-input").typeahead("destroy");
        typeahead(source);
    })
    function typeahead(source) {
        var get_url = $('#base_url').val();

        var engine = new Bloodhound({
            remote: {
                url: get_url+'/get-custom-link-title?title=%QUERY%&type='+source,
                wildcard: '%QUERY%'
            },
            datumTokenizer: Bloodhound.tokenizers.whitespace('title'),
            queryTokenizer: Bloodhound.tokenizers.whitespace
        });
        $('.search-input').on('typeahead:selected', function (e, datum) {
            $('#title_id').val(datum.PK_NO)
        });
        $(".search-input").typeahead({
                hint: true,
                highlight: true,
                minLength: 1,
                autoFocus: true
            },
            {
                source: engine.ttAdapter(),
                // This will be appended to "tt-dataset-" to form the class name of the suggestion menu.
                display: 'NAME',
                limit: 100,
                // the key from the array we want to display (name,id,email,etc...)
                templates: {
                    empty: [
                        '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
                    ],
                    header: [
                        // '<h3 class="typeahead-header"><strong>CATEGORIES</strong></h3>'
                    ],
                    suggestion: function (data) {
                        return '<span class="list-group-item" style="cursor: pointer;">' + data.NAME + '</span>'
                    }
                }
            }
        );
    }
</script>
@endpush('custom_js')
