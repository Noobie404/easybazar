
{!! Form::open([ 'route' => [ 'admin.delivery.schedule_store'], 'method' => 'post', 'class' =>'form-horizontal','id'=>'delScForm','novalidate']) !!}

<div class="form-body">
   <div class="row">
      <div class="col-12">
      <button type="button" class="add_more_photo btn btn-default btn-sm btn-rounded pull-right">Add More</button>
      </div>
   </div>



   <div class="schedule" id="schedule">
   <div class="row">
      <div class="col-md-4">
         <div class="form-group {!! $errors->has('from_time') ? 'error' : '' !!}">
            <label for="from_time">From Time <span class="text-danger">*</span></label>
            <div class="controls">
               {!! Form::time('from_time[]', NULL, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'Enter time', 'tabindex' => 2,'id'=>'bn_name','required']) !!}
               {!! $errors->first('from_time', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group {!! $errors->has('time') ? 'error' : '' !!}">
            <label for="time">To Time <span class="text-danger">*</span></label>
            <div class="controls">
               {!! Form::time('to_time[]', NULL, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'Enter time', 'tabindex' => 2,'id'=>'bn_name','required']) !!}
               {!! $errors->first('time', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
      <div class="col-md-4">
         <div class="form-group {!! $errors->has('slot_title') ? 'error' : '' !!}">
            <label for="slot_title">Slot Title<span class="text-danger">*</span></label>
            <div class="controls">
               {!! Form::text('slot_title[]', NULL, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'eg:09:00 AM - 10:00 AM', 'tabindex' => 2,'required']) !!}
               {!! $errors->first('slot_title', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
   </div>
   </div>


   <div class="form-actions text-center">
      <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ft-x"></i> @lang('form.btn_cancle')</button>
      <button title="Update" type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Save</button>
   </div>
</div>
{!! Form::close() !!}

<script>
   $(function () { $("#cityForm input,#cityForm select,#cityForm textarea").not("[type=submit]").jqBootstrapValidation(); } );

	$(document).ready(function() {
		var max_fields      = 10;
		var wrapper         = $(".schedule");
		var add_button      = $(".add_more_photo");

		var x = 1;
		$(add_button).click(function(e){
			e.preventDefault();
			if(x < max_fields){
				x++;
				$(wrapper).append('<div class="row py-2"><div class="col-md-4"><div class="form-group><label for="from_time">From Time <span class="text-danger">*</span></label><div class="controls"><input type="time" name="from_time[]" class="form-control" data-validation-required-message="This filed is required" placeholder="Enter time"> </div></div></div><div class="col-md-4"><div class="form-group><label for="time">To Time <span class="text-danger">*</span></label><div class="controls"><input type="time" name="to_time[]" class="form-control" data-validation-required-message="This filed is required" placeholder="Enter time">  </div></div></div><div class="col-md-4"><div class="form-group><label for="slot_title">Slot title <span class="text-danger">*</span></label><div class="controls"><input type="text" name="slot_title[]" class="form-control" data-validation-required-message="This filed is required" placeholder="eg.09:00AM - 10:00AM">  </div></div></div></div>').show('slow');;
			}
		});

		$(wrapper).on("click",".remove_field", function(e){
			e.preventDefault(); $(this).closest('tr').remove(); x--;
		})
	});
</script>
