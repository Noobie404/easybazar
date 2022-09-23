@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/editors/summernote.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">

<style>
</style>
@endpush('custom_css')
@section('Product Management','open')
@section('product_create','active')
@section('title') Documentation @endsection
@section('page-name') Documentation @endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('admin_role.breadcrumb_title')  </a></li>
<li class="breadcrumb-item active">Documentation</li>
@endsection
<?php
$roles              = userRolePermissionArray();
$tab_index          = 1;
$row = $row ?? [];
?>
@section('content')
<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card card-success min-height">
                <div class="card-content collapse show">
                <a href="{{url('documentation-view')}}" class="btn btn-default float-right py-2" target="_blank">View</a>
                    <div class="card-body">
                        {!! Form::open([ 'route' => 'admin.documentation.store', 'method' => 'post','id' => 'documentationForm', 'class' => 'form-horizontal','files' => true ]) !!}
                        <input class="form-control" type="hidden" name="id" value="{{$row->PK_NO}}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group {!! $errors->has('description') ? 'error' : '' !!}">
                                    <label for="description">Documentation <span class="text-danger">*</span></label>
                                    <div class="controls">
                                            <textarea id="text-editor" class="form-control summernote" name="description" rows="3">{{$row->DESCRIPTION}}</textarea>
                                        {!! $errors->first('documentation', '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-center mt-3">
                    <a href="{{route('admin.product-attr.index')}}">
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
<script type="text/javascript" src="{{ asset('assets/vendors/js/editors/summernote/summernote.js') }}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script>
       $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
    	function uploadImage(image) {
				var data = new FormData();
				data.append("image", image);
				$.ajax({
					url: '{{URL("ajax/text-editor/image/")}}',
					cache: false,
					contentType: false,
					processData: false,
					data: data,
					type: "POST",
					success: function(url) {
						var image = $('<img>').attr('src', url).attr('class', 'img-fluid');
						$('#text-editor').summernote("insertNode", image[0]);
					},
					error: function(data) {
						console.log(data);
					}
				});
			}
        $(document).on('submit', "#documentationForm", function (e) {
        e.preventDefault();
        var form = $("#documentationForm");
        $.ajax({
            type: 'post',
            data: form.serialize(),
            url: form.attr('action'),
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                console.log(response.data);
                if (response.status == 1) {
                    toastr.success(response.message);
                    $('#text-editor').summernote('code', response.DESCRIPTION);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (jqXHR, exception) {
                toastr.error('something wrong');
            },
            complete: function (response) {
                $("body").css("cursor", "default");
            }
        });
    });

    $(document).ready(function() {
        $('#text-editor').summernote({
         callbacks: {
            onImageUpload: function(image) {
                uploadImage(image[0]);
            }
        }, 
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph', 'style']],
            ['height', ['height']],
            ['Insert', ['picture', 'link', 'video', 'table', 'hr']],
            ['Misc', ['fullscreen', 'codeview', 'help']],
            ['mybutton', ['highlight']]
        ],
        popover: {
            image: [
                ['custom', ['captionIt']],
                ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                ['remove', ['removeMedia']]
            ]
        },
        captionIt:{
            icon:'<i class="note-icon-pencil"/>',
            figureClass:'image-container',
            figcaptionClass:'image-caption'
        },
        height: 300,                 
        minHeight: null,             
        maxHeight: null,
        buttons: {
            highlight: HighlightButton
          },
        focus: false
    });
		$('#text-editor').summernote('fontSize', 14);
    $('.note-current-fontsize').text('14');
    });
    //Custom Button
    var HighlightButton = function (context) {
      var ui = $.summernote.ui;
      // create button
      var button = ui.button({
        contents: '<i class="fa fa-certificate"/>',
        tooltip: 'Highlight',
        click: function () {
           var node = document.createElement('span');
            node.innerHTML = '<div style="padding:10px;background-color:#f5f5f5;margin:10px 0 10px 15px;float:right;width:300px"><h4 style="font-weight:bold">HIGHLIGHTS</h4><ul style=padding-left:15px><li style=color:#000;margin-bottom:5px;font-size:15px;font-weight:400>Write your highlight point</ul></div>';
            context.invoke('editor.insertNode', node);
        }
      });
      return button.render();   // return button as jquery object 
    }
</script>

@endpush('custom_js')
