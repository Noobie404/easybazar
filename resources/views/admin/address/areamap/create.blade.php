
<?php
$tabindex = 0;
?>
{!! Form::open([ 'route' => ['admin.address.map_store'], 'method' => 'post', 'class' =>'form-horizontal','id'=>'mapForm','novalidate']) !!}
<div class="form-body">
    <div class="row">
       <div class="col-md-6">
           <div class="form-group {!! $errors->has('region') ? 'error' : '' !!}">
              <label for="region">Region <span class="text-danger">*</span></label>
              <div class="controls">
                 {!! Form::select('region', $row, null, [ 'class' => 'form-control', 'id'=>'region','data-validation-required-message' => 'This filed is required','placeholder'=>'Select region','tabindex'=>$tabindex++,'required']) !!}
                 {!! $errors->first('region', '<label class="help-block text-danger">:message</label>') !!}
              </div>
           </div>
        </div>
        <div class="col-md-6">
           <div class="form-group {!! $errors->has('city') ? 'error' : '' !!}">
              <label for="city">City <span class="text-danger">*</span></label>
              <div class="controls">
                 <select name="city" class="form-control" id="city" data-validation-required-message="This filed is required" tabindex="{{ $tabindex++ }}" required></select>
                 {!! $errors->first('city', '<label class="help-block text-danger">:message</label>') !!}
              </div>
           </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group {!! $errors->has('area') ? 'error' : '' !!}">
                <label for="area">Area <span class="text-danger">*</span></label>
                <div class="controls">
                <select name="area" class="form-control mb-1 select2" id="area" data-validation-required-message="This filed is required" tabindex="{{ $tabindex++ }}" required></select>
                {!! $errors->first('area', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="form-group {!! $errors->has('zone') ? 'error' : '' !!}">
            <label for="zone">Zone <span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::text('zone',NULL, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'Enter zone', 'tabindex' => $tabindex++,'id'=>'zone','required' ]) !!}
                {!! $errors->first('zone', '<label class="help-block text-danger">:message</label>') !!}
            </div>
            </div>
        </div> --}}
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group {!! $errors->has('subarea') ? 'error' : '' !!}">
            <label for="subarea"> Subarea <span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::text('subarea',NULL, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'Enter subarea', 'tabindex' => $tabindex++,'id'=>'subarea','required']) !!}
                {!! $errors->first('subarea', '<label class="help-block text-danger">:message</label>') !!}
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group {!! $errors->has('subarea_bn') ? 'error' : '' !!}">
            <label for="subarea_bn"> Subarea (BN) <span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::text('subarea_bn',NULL, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'Enter subarea bn', 'tabindex' => $tabindex++,'id'=>'subarea_bn','required' ]) !!}
                {!! $errors->first('subarea_bn', '<label class="help-block text-danger">:message</label>') !!}
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group {!! $errors->has('coordinates_xml') ? 'error' : '' !!}">
            <label for="coordinates_xml"> Coordinate  XML<span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::textarea('coordinates_xml',NULL, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'Enter xml code', 'tabindex' => $tabindex++,'id'=>'subarea','required','rows'=>5  ]) !!}
                {!! $errors->first('coordinates_xml', '<label class="help-block text-danger">:message</label>') !!}
            </div>
            </div>
        </div>
    </div>


{{--
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="schedule" id="schedule">
                <div class="row">
                    <div class="col-md-1"><span class=" badge badge-info p-2 mt-4 float-right">1</span> </div>
                   <div class="col-md-5">
                      <div class="form-group {!! $errors->has('latitude') ? 'error' : '' !!}">
                         <label for="latitude_co">Latitude  <span class="text-danger">*</span></label>
                         <div class="controls">
                            {!! Form::text('latitude_co[]', NULL, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'Enter Latitude', 'tabindex' => 2,'id'=>'bn_name','required']) !!}
                            {!! $errors->first('latitude_co', '<label class="help-block text-danger">:message</label>') !!}
                         </div>
                      </div>
                   </div>
                   <div class="col-md-5">
                      <div class="form-group {!! $errors->has('longitude_co') ? 'error' : '' !!}">
                         <label for="longitude_co">Longitude <span class="text-danger">*</span></label>
                         <div class="controls">
                            {!! Form::text('longitude_co[]', NULL, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'Enter Longitude', 'tabindex' => 2,'id'=>'bn_name','required']) !!}
                            {!! $errors->first('longitude_co', '<label class="help-block text-danger">:message</label>') !!}
                         </div>
                      </div>
                   </div>
                   <div class="col-md-1">
                    <button type="button" class="add_new_row btn btn-default btn-sm btn-success mt-4"><i class="la la-plus"></i></button>
                   </div>
                </div>
                </div>
        </div>
    </div> --}}



    {{-- <div class="row">
        <div class="col-md-12">
            <div class="form-group {!! $errors->has('nw_lat_lon') ? 'error' : '' !!}">
                <label for="nw_lat_lon" class="control-label">North-West (Latitude Longitude)<span class="text-danger">*</span></label>
                <div class="controls">
                    {!! Form::text('nw_lat_lon', NULL, array('class'=>'form-control','id'=>'nw_lat_lon','data-validation-required-message' => 'This filed is required','required','tabindex' => $tabindex++))!!}
                    {!! $errors->first('nw_lat_lon', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group {!! $errors->has('se_lat_lon') ? 'error' : '' !!}">
                <label for="se_lat_lon" class="control-label">South-East (Latitude Longitude)<span class="text-danger">*</span></label>
                <div class="controls">
                    {!! Form::text('se_lat_lon', NULL, array('class'=>'form-control','id'=>'se_lat_lon','data-validation-required-message' => 'This filed is required','required','tabindex' => $tabindex++))!!}
                    {!! $errors->first('se_lat_lon', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="row">
        <div class="col-md-6">
        <div class="form-group {!! $errors->has('min_lat') ? 'error' : '' !!}">
            <label for="min_lat" class="control-label">Min Latitude</label>
        <div class="controls">
            {!! Form::text('min_lat',NULL, array('class'=>'form-control','id'=>'min_lat','readonly' => 'readonly','tabindex' => $tabindex++))!!}
            {!! $errors->first('min_lat', '<label class="help-block text-danger">:message</label>') !!}
        </div>
        </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {!! $errors->has('min_Lon') ? 'error' : '' !!}">
            <label for="min_Lon" class="control-label">Min Longitude</label>
            <div class="controls">
                {!! Form::text('min_Lon',NULL, array('class'=>'form-control','id'=>'min_Lon','readonly' => 'readonly','tabindex' => $tabindex++))!!}
                {!! $errors->first('min_Lon', '<label class="help-block text-danger">:message</label>') !!}
            </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="row">
        <div class="col-md-6">
            <div class="form-group {!! $errors->has('max_lat') ? 'error' : '' !!}">
                <label for="max_lat" class="control-label">Max Latitude</label>
                <div class="controls">
                    {!! Form::text('max_lat',NULL, array('class'=>'form-control', 'id'=>'max_lat', 'readonly' => 'readonly','tabindex' => $tabindex++))!!}
                    {!! $errors->first('max_lat', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {!! $errors->has('max_lon') ? 'error' : '' !!}">
                <label for="max_lon" class="control-label">Max Longitude</label>
                <div class="controls">
                    {!! Form::text('max_lon',NULL, array('class'=>'form-control', 'id'=>'max_lon','readonly' => 'readonly','tabindex' => $tabindex++))!!}
                    {!! $errors->first('max_lon', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="row">
        <div class="col-md-6">
        <div class="form-group {!! $errors->has('ne_lat') ? 'error' : '' !!}">
            <label for="ne_lat" class="control-label">North-East Latitude<span class="text-danger">*</span>
            </label>
            <div class="controls">
                {!! Form::text('ne_lat',NULL, array('class'=>'form-control', 'id'=>'ne_lat','data-validation-required-message' => 'This filed is required','readonly' => 'readonly','required','tabindex' => $tabindex++))!!}
                {!! $errors->first('ne_lat', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group {!! $errors->has('ne_lat') ? 'error' : '' !!}">
            <label for="ne_lat" class="control-label">North-East Longitude<span class="text-danger">*</span>
            </label>
            <div class="controls">
                {!! Form::text('ne_lon',NULL, array('class'=>'form-control', 'id'=>'ne_lon','data-validation-required-message' => 'This filed is required','readonly' => 'readonly','required','tabindex' => $tabindex++))!!}
                {!! $errors->first('ne_lon', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
        </div>
    </div> --}}
    {{-- <div class="row">
        <div class="col-md-6">
        <div class="form-group {!! $errors->has('se_lat') ? 'error' : '' !!}">
            <label for="se_lat" class="control-label">South-East Latitude<span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::text('se_lat',NULL, array('class'=>'form-control','id'=>'se_lat','data-validation-required-message' => 'This filed is required','readonly' => 'readonly','required','tabindex' => $tabindex++))!!}
                {!! $errors->first('se_lat', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="form-group {!! $errors->has('se_lon') ? 'error' : '' !!}">
            <label for="se_lon" class="control-label">South-East Longitude<span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::text('se_lon',NULL, array('class'=>'form-control','id'=>'se_lon','data-validation-required-message' => 'This filed is required','readonly' => 'readonly','required','tabindex' => $tabindex++))!!}
                {!! $errors->first('se_lon', '<label class="help-block text-danger">:message</label>') !!}
            </div>
        </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                <label for="ne_longitude">Is Active</label>
                <div class="controls">
                    {!! Form::select('is_active', ['1'=> 'Yes','0'=> 'No'],1 ,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++ ]) !!}
                    {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions text-center">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ft-x"></i> @lang('form.btn_cancle')</button>
        <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Save</button>
    </div>
</div>
{!! Form::close() !!}
<script>
    $(function () { $("#mapForm input,#mapForm select,#mapForm textarea").not("[type=submit]").jqBootstrapValidation(); } );

    $(document).ready(function() {
		var max_fields      = 20;
		var wrapper         = $(".schedule");
		var add_button      = $(".add_new_row");
		var x = 1;
		$(add_button).click(function(e){
			e.preventDefault();
			if(x < max_fields){
				x++;
				$(wrapper).append('<div class="row py-2"> <div class="col-md-1"><span class=" badge badge-info p-2 mt-4 float-right">'+x+'</span></div><div class="col-md-5"><div class="form-group><label for="latitude_co">Latitude <span class="text-danger">*</span></label><div class="controls"><input type="text" name="latitude_co[]" class="form-control" data-validation-required-message="This filed is required" placeholder="Enter Latitude"> </div></div></div><div class="col-md-5"><div class="form-group><label for="longitude_co">Longitude <span class="text-danger">*</span></label><div class="controls"><input type="text" name="longitude_co[]" class="form-control" data-validation-required-message="This filed is required" placeholder="Enter Longitude">  </div></div></div><div class="col-md-1"><button type="button" class="remove_field btn btn-danger btn-sm mt-4"><i class="la la-times"></i></button></div></div>').show('slow');;
			}
		});
		$(wrapper).on("click",".remove_field", function(e){
			e.preventDefault(); $(this).closest('.row').remove(); x--;
		})
	});
</script>
