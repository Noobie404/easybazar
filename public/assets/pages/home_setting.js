var max_fields = 5;
var wrapper = $("#append-row");
var add_more_row = $("#add_more_row");
var x = 1;
$(add_more_row).click(function (e) {
    e.preventDefault();
    if (x < max_fields) {
        x++;
        $(wrapper).append(
            '<div class="row"><div class="col-3"><div class="form-group"><div class="controls"><div class="fileupload fileupload-new" data-provides="fileupload" ><span class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 120px;"><img src="" alt="Photo" class="img-fluid" height="150px" width="120px"/></span><span><label class="btn btn-primary btn-rounded btn-file btn-sm"><span class="fileupload-new"><i class="la la-file-image-o"></i> Select Image</span><span class="fileupload-exists"><i class="la la-reply"></i> Change</span><input type="file" class="form-control" name="feature_image[]" id=""/></label><a href="#" class="btn fileupload-exists btn-default btn-rounded  btn-sm" data-dismiss="fileupload" id="remove-thumbnail"><i class="la la-times"></i> Remove</a></span></div></div></div></div><div class="col"><div class="form-group"><div class="controls"><input type="text" name="title[]" class="form-control" placeholder="Enter Title"/></div></div></div><div class="col"><div class="form-group"><div class="controls"><input type="text" name="link[]" class="form-control" placeholder="https://"/></div></div></div><div class="col-1"><button type="button" class="btn btn-outline-danger remove-row"><i class="la la-times"></i></button></div></div>'
            );
    }
    else{
        toastr.warning('Image limit exeed')
    }
});

$(wrapper).on("click", ".remove-row", function (e) {
    e.preventDefault();
    $(this).closest('.row').remove();
    x--;
})
