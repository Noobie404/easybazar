@extends('admin.layout.master')
@push('custom_css')
@endpush('custom_css')
@section('notification','open')
@section('web-notification','active')
@section('title') Push Notification @endsection
@section('page-name') Create Notification @endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Notification</a></li>
<li class="breadcrumb-item active">Create Notification</li>
@endsection
@section('content')
<div class="content-body min-height">
   <div class="row">
      <div class="col-md-12">
         <div class="card card-sm card-success" >
            <div class="card-content">
               <div class="card-body">
                  {!! Form::open([ 'route' => 'web.notification.web-push', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate']) !!}
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group {!! $errors->has('title') ? 'error' : '' !!}">
                           <label>Title<span class="text-danger">*</span></label>
                           <div class="controls">
                              {!! Form::text('title', null, [ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'placeholder' => 'Enter Title', 'tabindex' => 1]) !!}
                              {!! $errors->first('title', '<label class="help-block text-danger">:message</label>') !!}
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group {!! $errors->has('body') ? 'error' : '' !!}">
                           <label>Body</label>
                           <div class="controls">
                              {!! Form::textarea('body', null, [ 'class' => 'form-control', 'placeholder' => 'Enter Notification Body', 'tabindex' => 2, 'rows' => 5]) !!}
                              {!! $errors->first('body', '<label class="help-block text-danger">:message</label>') !!}
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            {!! Form::url('image', null, [ 'class' => 'form-control image_url', 'placeholder' => 'Enter Image Url', 'tabindex' => 3,'aria-label'=>'Text input']) !!}
                            <div class="input-group-append">
                              <button type="button" class="btn btn-sm btn-info"  data-toggle="modal" data-target="#adsModal">Add</button>
                            </div>
                          </div>
                          <div id="myAds" class="p-1"></div>
                    </div>
                 </div>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-actions text-center">
                           <a href="{{route('web.notification')}}" class="btn btn-warning mr-1"><i class="ft-x"></i> {{ trans('form.btn_cancle') }}</a>
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
<!-- Modal -->
<div class="modal fade" id="adsModal" tabindex="-1" aria-labelledby="adsLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="adsLabel">Image Upload</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        {!! Form::open([ 'route' => 'web.notification.image-upload', 'method' => 'post', 'class' => 'form-horizontal', 'files' => true , 'novalidate','id'=>'ads-image-form']) !!}
        <div class="modal-body">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group {!! $errors->has('image') ? 'error' : '' !!}">
                       <label>Image</label>
                       <div class="controls">
                             {!! Form::file('image', [ 'class' => 'form-control mb-1 image', 'tabindex' => 8,'data-validation-required-message' => 'This field is required']) !!}
                          {!! $errors->first('image', '<label class="help-block text-danger">:message</label>') !!}
                       </div>
                    </div>
                 </div>
            </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection
@push('custom_js')
<script>
    $(document).on('submit','#ads-image-form',function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            beforeSend: function () {
               $("body").css("cursor", "progress");
            //    xhr.setRequestHeader('X-CSRF-Token', $('[name="csrf-token"]').attr('content'));
            },
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                var image = $('<img>').attr('src', data).attr('class', 'img-fluid').attr('width', '200px');
                $('#myAds').append(image);
                $('.image_url').val(data);
                $('#adsModal').modal('hide');
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });
    });
</script>
@endpush('custom_js')
