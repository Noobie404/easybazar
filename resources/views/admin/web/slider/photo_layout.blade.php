<div class="row">
    <div class="col-2">
       <div class="form-group">
          <div class="controls">
             <div class="fileupload fileupload-new" data-provides="fileupload" >
                 <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                    <img src="" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                </span>
                <span>
                    <label class="btn btn-primary btn-rounded btn-file btn-sm">
                        <span class="fileupload-new"><i class="la la-file-image-o"></i> Select Image</span>
                        <span class="fileupload-exists"><i class="la la-reply"></i> Change</span>
                        <input type="file" class="form-control" name="feature_image[]" id=""/>
                    </label>
                    <a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail"><i class="la la-times"></i> Remove</a>
                </span>
            </div>
          </div>
       </div>
    </div>
    <div class="col-2">
       <div class="form-group">
          <div class="controls">
             <div class="fileupload fileupload-new" data-provides="fileupload" >
                 <span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;">
                    <img src="" alt="Photo" class="img-fluid" height="150px" width="120px"/>
                </span>
                <span>
                    <label class="btn btn-primary btn-rounded btn-file btn-sm">
                        <span class="fileupload-new"><i class="la la-file-image-o"></i> Select Image</span>
                        <span class="fileupload-exists"><i class="la la-reply"></i> Change</span>
                        <input type="file" class="form-control" name="mobile_image[]" id=""/>
                    </label>
                    <a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail"><i class="la la-times"></i> Remove</a></span>
                    <span class="d-block"><small>Recommended image size: 1600x460px</small></span>

            </div>
          </div>
       </div>
    </div>
    <div class="col">
       <div class="form-group">
          <div class="controls"><input type="text" name="caption[]" placeholder="Enter your image caption" data-validation-required-message="This field is required" tabindex="" class="form-control"></div>
       </div>
    </div>
    <div class="col">
       <div class="form-group">
          <div class="form-group">
             <div class="controls"><input type="url" name="custom_link[]" placeholder="https://" data-validation-required-message="This field is required" tabindex="" class="form-control"></div>
          </div>
       </div>
    </div>
    <div class="col-md-auto">
       <div class="form-group"><button type="button" class="btn btn-outline-danger remove-row"><i class="la la-times"></i></button></div>
    </div>
 </div>
