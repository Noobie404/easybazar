@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
@endpush('custom_css')
@section('web','open')
@section('slider','active')
@section('title') Gallery @endsection
@section('page-name') Edit Gallery @endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Gallery</a></li>
<li class="breadcrumb-item active">Edit Gallery</li>
@endsection
<?php
$slider         = $data['slider'] ?? [];
$slider_photo   = $data['slider_photo'] ?? [];
?>
@section('content')
<div class="content-body min-height">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-sm card-success" >
                <div class="card-content">
                    <div class="card-body">
                                {!! Form::open([ 'route' => ['web.slider.update',$slider->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('title') ? 'error' : '' !!}">
                                            <label>Title</label>
                                            <div class="controls">
                                                {!! Form::text('title', $slider->TITLE, [ 'class' => 'form-control', 'placeholder' => 'Enter Title', 'tabindex' => 1]) !!}
                                                {!! $errors->first('title', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('is_slider') ? 'error' : '' !!}">
                                            <label>Is Slider <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::select('is_slider', ['1'=> 'Yes','0'=> 'No'], $slider->IS_SLIDER,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select', 'tabindex' => 2]) !!}
                                                {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                                            <label>Is Active <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                {!! Form::select('is_active', ['1'=> 'Yes','0'=> 'No'], $slider->IS_ACTIVE,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Select', 'tabindex' => 3]) !!}
                                                {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-actions text-right">
                                            <button type="submit" class="btn bg-primary bg-darken-1 text-white">
                                             <i class="la la-check-square-o"></i> Update </button>
                                         </div>
                                    </div>
                                </div>

                                {!! Form::close() !!}
                                <h4 class="p-1 border-bottom"><i class="la la-image"></i> Slider Image</h4>

                                <div class="card">
                                    <div class="card-body">
                                            @if(!empty($slider_photo) && count($slider_photo) > 0)
                                            @foreach ($slider_photo as $photo)

                                            {!! Form::open([ 'route' => ['web.slider.photo_update',$photo->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                                                @csrf
                                          <div class="row" id="row_{{ $photo->PK_NO }}">
                                              <div class="col-2">
                                                <label class="d-block">Photo <span class="text-danger">*</span></label>
                                                <div class="fileupload fileupload-exists" data-provides="fileupload" >
                                                    <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px; max-height: 100px;">
                                                        @if(!empty($photo->RELATIVE_PATH))
                                                        <img src="{{asset($photo->RELATIVE_PATH)}}" alt="Article Photo" class="img-fluid" width="100px" height="100px"/>
                                                        @endif
                                                    </span>

                                                    <label class="btn btn-primary btn-file btn-sm" >
                                                        <span class="fileupload-new"><i class="la la-reply"></i> Select Image</span>
                                                        <span class="fileupload-exists"><i class="la la-reply"></i> Change</span>
                                                        <input type="file" name="feature_image" id="feature_image">
                                                    </label>
                                                </div>
                                                {{-- <img src="{{ asset($photo->RELATIVE_PATH) }}" alt="" class="img-fluid" width="100"> --}}
                                              </div>
                                              <div class="col-2">
                                                <label class="d-block">Mobile/App</label>

                                                <div class="fileupload fileupload-exists" data-provides="fileupload" >
                                                    <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px; max-height: 100px;">
                                                        @if(!empty($photo->MOBILE_BANNER))
                                                        <img src="{{asset($photo->MOBILE_BANNER)}}" alt="Article Photo" class="img-fluid" width="100px" height="100px"/>
                                                        @else
                                                        <img src="https://via.placeholder.com/100x80.png" alt="" class="img-fluid" width="100">
                                                        @endif
                                                    </span>
                                                    <label class="btn btn-primary btn-file btn-sm" >
                                                        <span class="fileupload-new"><i class="la la-reply"></i> Select Image</span>
                                                        <span class="fileupload-exists"><i class="la la-reply"></i> Change</span>
                                                        <input type="file" name="mobile_image" id="mobile_image">
                                                    </label>
                                                </div>
                                              </div>
                                              <div class="col">
                                                <div class="form-group">
                                                  <div class="form-group {!! $errors->has('caption') ? 'error' : '' !!}">
                                                      <label>Image Caption</label>
                                                      <div class="controls">
                                                          <input type="text" name="caption" placeholder="Enter your image caption" class="form-control" value="{{ $photo->CAPTION }}">
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
                                                          <input type="url" name="custom_link" placeholder="Enter url" class="form-control" value="{{ $photo->CUSTOM_LINK }}">
                                                            {!! $errors->first('url', '<label class="help-block text-danger">:message</label>') !!}
                                                        </div>
                                                    </div>

                                                  </div>
                                              </div>
                                              <div class="col-md-auto">
                                                <div class="form-group mt-4">
                                                    <button type="submit" class="btn btn-outline-primary"><i class="la la-save"></i></button>
                                                    <button type="button" class="btn btn-outline-danger delete-row" data-id="{{ $photo->PK_NO  }}">
                                                        <i class="la la-times"></i>
                                                    </button>
                                                </div>
                                              </div>
                                          </div>
                                          {!! Form::close() !!}
                                          @endforeach
                                          @endif

                                          {!! Form::open([ 'route' => ['web.slider.add_photo'], 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                                            @csrf
                                            {!! Form::hidden('id', $slider->PK_NO) !!}

                                          <div id="append-row">

                                          </div>
                                        <button type="button" id="add_more_row" class="btn btn-info btn-sm"><i class="la la-plus"></i> Add New</button>

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
</div>
</div>
@endsection
@push('custom_js')
<script type="text/javascript" src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script type="text/javascript">
    var get_url = $('#base_url').val();
   $(document).on('click','.delete-row', function(e){
    var id = $(this).attr('data-id');
    if (!confirm('Are you sure you want to delete the photo')) {
        return false;
    }
    if ('' != id) {
        var pageurl = get_url+'/slider/delete-photo/'+id;
        $.ajax({
            type:'get',
            url:pageurl,
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                if(data.status == true ){
                    $('#row_'+id).remove();
                    toastr.success('Slider image successfully removed')
                } else {
                    toastr.warning('something wrong please you should reload the page')
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    }
})
$(document).on('click','#add_more_row',function(e) {
    var max_photos = 5;
    var x = {{ $slider_photo->count() }};
    e.preventDefault();
    if (x < max_photos) {
        x++;
        // var get_url = $('#base_url').val();
        // var pageurl = get_url+'/slider/photo_layout/';
        // $.get(pageurl, function (data) {
        //     $("#append-row").append(data);
        // });

        $("#append-row").append('<div class="row"><div class="col-2"><div class="form-group"><div class="controls"><div class="fileupload fileupload-new" data-provides="fileupload" ><span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;"><img src="" alt="Photo" class="img-fluid" height="150px" width="120px"/></span><span><label class="btn btn-primary btn-rounded btn-file btn-sm"><span class="fileupload-new"><i class="la la-file-image-o"></i> Select Image</span><span class="fileupload-exists"><i class="la la-reply"></i> Change</span><input type="file" class="form-control" name="feature_image[]" id=""/></label><a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail"><i class="la la-times"></i> Remove</a></span><span class="d-block"><small>Recommended image size: 1600x460px</small></span></div></div></div></div><div class="col-2"><div class="form-group"><div class="controls"><div class="fileupload fileupload-new" data-provides="fileupload" ><span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;"><img src="" alt="Photo" class="img-fluid" height="150px" width="120px"/></span><span><label class="btn btn-primary btn-rounded btn-file btn-sm"><span class="fileupload-new"><i class="la la-file-image-o"></i> Select Image</span><span class="fileupload-exists"><i class="la la-reply"></i> Change</span><input type="file" class="form-control" name="mobile_image[]" id=""/></label><a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail"><i class="la la-times"></i> Remove</a></span></div></div></div></div><div class="col"><div class="form-group"><div class="controls"><input type="text" name="caption[]" placeholder="Enter your image caption" data-validation-required-message="This field is required" tabindex="" class="form-control"></div></div></div><div class="col"><div class="form-group"><div class="form-group"><div class="controls"><input type="url" name="custom_link[]" placeholder="https://" data-validation-required-message="This field is required" tabindex="" class="form-control"></div></div></div></div><div class="col-md-auto"><div class="form-group"><button type="button" class="btn btn-outline-danger remove-row"><i class="la la-times"></i></button></div></div></div>');
    }
    else{
        // toastr.warning('Image limit exeed');
    }
});
$("#append-row").on("click", ".remove-row", function (e) {
    e.preventDefault();
    $(this).closest('.row').remove();
    x--;
})


// $(document).ready(function() {
// 		var max_fields      = 50;
// 		var wrapper         = $(".appended_tr");
// 		var add_button      = $(".add_more_photo");

// 		var x = 1;
// 		$(add_button).click(function(e){
// 			e.preventDefault();
// 			if(x < max_fields){
// 				x++;
// 				$(wrapper).append('<tr><td><div class="fileupload fileupload-new" data-provides="fileupload"><span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 75px; max-height: 75px;"></span> <label class="btn btn-primary btn-file btn-sm"><span class="fileupload-new"><i class="fa fa-picture-o"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture-o"></i> Change</span><input type="file" name="image[]" required="required"></label> <a href="#" class="btn fileupload-exists btn-default btn-sm" data-dismiss="fileupload"> <i class="fa fa-times"></i> Remove</a></span></div></td><td><textarea class="form-control" name="image_caption[]" placeholder="Image Caption" required="required"></textarea></td></td><td style="width:50px"><i class="fa fa-trash-o fa-2x text-dark remove_field"></i></td></tr>');
// 			}
// 		});

// 		$(wrapper).on("click",".remove_field", function(e){
// 			e.preventDefault(); $(this).closest('tr').remove(); x--;
// 		})
// 	});



</script>
 @endpush('custom_js')
