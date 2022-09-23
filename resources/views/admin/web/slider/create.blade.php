@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">

@endpush('custom_css')
@section('web','open')
@section('slider','active')
@section('title')Create Gallery @endsection
@section('page-name') Create Gallery @endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Gallery</a></li>
<li class="breadcrumb-item active">Create Gallery</li>
@endsection
@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-sm card-success" >
                <div class="card-content">
                    <div class="card-body">
                                {!! Form::open([ 'route' => 'web.slider.store', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('title') ? 'error' : '' !!}">
                                            <label>Title </label>
                                            <div class="controls">
                                                {!! Form::text('title', null, [ 'class' => 'form-control mb-1','placeholder' => 'Enter Title', 'tabindex' => 1,'required']) !!}
                                                {!! $errors->first('title', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('is_slider') ? 'error' : '' !!}">
                                            <label>Is Slider <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::select('is_slider', ['1'=> 'Yes','0'=> 'No'], NULL,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select', 'tabindex' => 2]) !!}
                                                {!! $errors->first('is_slider', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                                            <label>Is Active <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::select('is_active', ['1'=> 'Yes','0'=> 'No'], NULL,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select', 'tabindex' => 3]) !!}
                                                {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                  <h4 class="p-1 border-bottom"><i class="la la-image"></i> Gallery Image</h4>
                                  <div class="card">
                                      <div class="card-body">
                                          <div id="append-row">
                                            <div class="row">
                                                <div class="col-2">
                                                <div class="form-group">
                                                    <div class="form-group {!! $errors->has('feature_image') ? 'error' : '' !!}">
                                                        <label class="active">Banner Image</label>
                                                        <div class="controls">
                                                           <div class="fileupload @if(!empty($row->RELATIVE_PATH))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                              <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                              @if(!empty($row->RELATIVE_PATH))
                                                              <img src="{{asset($row->RELATIVE_PATH)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
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
                                                              {!! Form::file('feature_image[]', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => 8]) !!}
                                                              </label>
                                                              <a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                              <i class="la la-times"></i> Remove
                                                              </a>
                                                              </span>
                                                              <span class="d-block"><small>Recommended image size: 1600x460px</small></span>
                                                           </div>

                                                           {!! $errors->first('feature_image', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                     </div>

                                                </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group {!! $errors->has('mobile_image') ? 'error' : '' !!}">
                                                        <label class="active">Mobile/App</label>
                                                        <div class="controls">
                                                           <div class="fileupload @if(!empty($row->MOBILE_BANNER))  {{'fileupload-exists'}} @else {{'fileupload-new'}} @endif " data-provides="fileupload" >
                                                              <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                                                              @if(!empty($row->MOBILE_BANNER))
                                                              <img src="{{asset($row->MOBILE_BANNER)}}" alt="Photo" class="img-fluid" height="150px" width="120px"/>
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
                                                              {!! Form::file('mobile_image[]', Null,[ 'class' => 'form-control mb-1', 'data-validation-required-message' => 'This field is required', 'tabindex' => 8]) !!}
                                                              </label>
                                                              <a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail">
                                                              <i class="la la-times"></i> Remove
                                                              </a>
                                                              </span>
                                                           </div>
                                                           {!! $errors->first('mobile_image', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                     </div>
                                                </div>
                                                <div class="col">
                                                  <div class="form-group">
                                                    <div class="form-group {!! $errors->has('caption') ? 'error' : '' !!}">
                                                        <label>Image Caption</label>
                                                        <div class="controls">
                                                            <input type="text" name="caption[]" placeholder="Enter your image caption" data-validation-required-message="This field is required" tabindex="" class="form-control">
                                                            {!! $errors->first('caption', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>
                                                  </div>
                                              </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                      <div class="form-group {!! $errors->has('url') ? 'error' : '' !!}">
                                                          <label>Custom URL</label>
                                                          <div class="controls">
                                                            <input type="url" name="custom_link[]" placeholder="https://" data-validation-required-message="This field is required" tabindex="" class="form-control">
                                                              {!! $errors->first('url', '<label class="help-block text-danger">:message</label>') !!}
                                                          </div>
                                                      </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-auto">
                                                  <div class="form-group">
                                                    <label class="d-block"></label>
                                                      <button type="button" class="mt-4 btn btn-outline-danger remove-row">
                                                          <i class="la la-times"></i>
                                                      </button>
                                                  </div>
                                                </div>
                                            </div>
                                            <hr>

                                          </div>
                                          <button type="button" id="add_more_row" class="btn btn-info btn-sm"><i class="la la-plus"></i> Add New</button>
                                      </div>
                                  </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-actions text-center">
                                            <a href="{{route('web.slider')}}" class="btn btn-warning mr-1"><i class="ft-x"></i> {{ trans('form.btn_cancle') }}</a>
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
<script>
$(document).on('click','#add_more_row',function(e) {
    var max_photos = 5;
    var x = 1;
    e.preventDefault();
    if (x < max_photos) {
        x++;
        // var get_url = $('#base_url').val();
        // var pageurl = get_url+'/slider/photo_layout/';
        // $.get(pageurl, function (data) {
        //     $("#append-row").append(data);
        // });
        $("#append-row").append('<div class="row"><div class="col-2"><div class="form-group"><div class="controls"><div class="fileupload fileupload-new" data-provides="fileupload" ><span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;"><img src="" alt="Photo" class="img-fluid" height="150px" width="120px"/></span><span><label class="btn btn-primary btn-rounded btn-file btn-sm"><span class="fileupload-new"><i class="la la-file-image-o"></i> Select Image</span><span class="fileupload-exists"><i class="la la-reply"></i> Change</span><input type="file" class="form-control" name="feature_image[]" id=""/></label><a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail"><i class="la la-times"></i> Remove</a></span><span class="d-block"><small>Recommended image size: 1600x460px</small></span></div></div></div></div><div class="col-2"><div class="form-group"><div class="controls"><div class="fileupload fileupload-new" data-provides="fileupload" ><span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;"><img src="" alt="Photo" class="img-fluid" height="150px" width="120px"/></span><span><label class="btn btn-primary btn-rounded btn-file btn-sm"><span class="fileupload-new"><i class="la la-file-image-o"></i> Select Image</span><span class="fileupload-exists"><i class="la la-reply"></i> Change</span><input type="file" class="form-control" name="mobile_image[]" id=""/></label><a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail"><i class="la la-times"></i> Remove</a></span></div></div></div></div><div class="col"><div class="form-group"><div class="controls"><input type="text" name="caption[]" placeholder="Enter your image caption" data-validation-required-message="This field is required" tabindex="" class="form-control"></div></div></div><div class="col"><div class="form-group"><div class="form-group"><div class="controls"><input type="url" name="custom_link[]" placeholder="https://" data-validation-required-message="This field is required" tabindex="" class="form-control"></div></div></div></div><div class="col-md-auto"><div class="form-group"><button type="button" class="btn btn-outline-danger remove-row"><i class="la la-times"></i></button></span></div></div></div>');
    }
    else{
        // toastr.warning('Image limit exeed')
    }
});
$("#append-row").on("click", ".remove-row", function (e) {
    e.preventDefault();
    $(this).closest('.row').remove();
    x--;
})

</script>
 @endpush('custom_js')
