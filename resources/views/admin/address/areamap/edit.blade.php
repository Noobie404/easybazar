<?php
$row = $data['areamap'] ;
$region = $data['region'] ?? [];
$tabindex = 0;
$subarea_polygons = $data['subarea_polygons'] ?? [];
$count = $subarea_polygons->count();
?>
{!! Form::open([ 'route' => ['admin.address.map_update'], 'method' => 'post', 'class'
=>'form-horizontal','id'=>'mapUpdateForm','novalidate']) !!}
{!! Form::hidden('id', $row->PK_NO, ['id'=>'id']) !!}
<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {!! $errors->has('region') ? 'error' : '' !!}">
                <label for="region">Region <span class="text-danger">*</span></label>
                <div class="controls">
                    {!! Form::select('region', $data['stateCombo'], $row->F_STATE_NO, [ 'class' => 'form-control mb-1
                    select2', 'id'=>'region','data-validation-required-message' => 'This filed is
                    required','placeholder'=>'Select region','tabindex'=>$tabindex++,'required']) !!}
                    {!! $errors->first('region', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {!! $errors->has('city') ? 'error' : '' !!}">
                <label for="city">City <span class="text-danger">*</span></label>
                <div class="controls">
                    {!! Form::select('city', $data['city'], $row->F_CITY_NO, [ 'class' => 'form-control',
                    'id'=>'city','data-validation-required-message' => 'This filed is required','placeholder'=>'Select
                    city','tabindex'=>$tabindex++,'required']) !!}
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
                    {!! Form::select('area', $data['area'], $row->F_AREA_NO, [ 'class' => 'form-control',
                    'id'=>'area','data-validation-required-message' => 'This filed is required','placeholder'=>'Select
                    area','tabindex'=>$tabindex++,'required']) !!}
                    {!! $errors->first('area', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group {!! $errors->has('subarea') ? 'error' : '' !!}">
            <label for="subarea">Subarea <span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::text('subarea',$row->SUB_AREA_NAME, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'Enter subarea', 'tabindex' => $tabindex++,'id'=>'subarea','required' ]) !!}
                {!! $errors->first('subarea', '<label class="help-block text-danger">:message</label>') !!}
            </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group {!! $errors->has('subarea_bn') ? 'error' : '' !!}">
            <label for="subarea_bn">Subarea (BN) <span class="text-danger">*</span></label>
            <div class="controls">
                {!! Form::text('subarea_bn',$row->SUB_AREA_NAME_BN, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'Enter subarea bn', 'tabindex' => $tabindex++,'id'=>'subarea_bn','required' ]) !!}
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
                {!! Form::textarea('coordinates_xml',$row->COORDINATE_XML, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'Enter xml code', 'tabindex' => $tabindex++,'id'=>'subarea','required','rows'=>5  ]) !!}
                {!! $errors->first('coordinates_xml', '<label class="help-block text-danger">:message</label>') !!}
            </div>
            </div>
        </div>
    </div>


    <div class="row mb-4">
        <div class="col-md-12">
            {{-- <button type="button" class="add_new_row btn btn-default btn-sm btn-success mt-4 float-right"><i class="la la-plus"></i></button> --}}
            <div class="schedule" id="schedule">
                @if(!empty($subarea_polygons))
                @foreach($subarea_polygons as $key=>$polygon)
                <div class="row" id="polygon{{ $polygon->PK_NO }}">
                    <div class="col-md-1"><span class=" badge badge-info p-2 mt-4 float-right">{{ $key+1}}</span> </div>
                   <div class="col-md-5">
                      <div class="form-group {!! $errors->has('latitude') ? 'error' : '' !!}">
                         <label for="latitude_co">Latitude  <span class="text-danger">*</span></label>
                         <div class="controls">
                            {!! Form::text('latitude_co[]', $polygon->LAT, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'Enter Latitude', 'tabindex' => 2,'id'=>'bn_name','required', 'readonly']) !!}
                            {!! $errors->first('latitude_co', '<label class="help-block text-danger">:message</label>') !!}
                         </div>
                      </div>
                   </div>
                   <div class="col-md-5">
                      <div class="form-group {!! $errors->has('longitude_co') ? 'error' : '' !!}">
                         <label for="longitude_co">Longitude <span class="text-danger">*</span></label>
                         <div class="controls">
                            {!! Form::text('longitude_co[]',$polygon->LON, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'Enter Longitude', 'tabindex' => 2,'id'=>'bn_name','required', 'readonly']) !!}
                            {!! $errors->first('longitude_co', '<label class="help-block text-danger">:message</label>') !!}
                         </div>
                      </div>
                   </div>
                   {{-- <div class="col-md-1">
                    <button type="button" class="delete_field btn btn-danger btn-sm mt-4" data-id="{{ $polygon->PK_NO}}"><i class="la la-times"></i></button>
                   </div> --}}
                </div>
                @endforeach
                @endif

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
        <div class="form-group {!! $errors->has('min_lat') ? 'error' : '' !!}">
            <label for="min_lat" class="control-label">Min Latitude</label>
        <div class="controls">
            {!! Form::text('min_lat',$row->MIN_LAT, array('class'=>'form-control','id'=>'min_lat','readonly' => 'readonly','tabindex' => $tabindex++))!!}
            {!! $errors->first('min_lat', '<label class="help-block text-danger">:message</label>') !!}
        </div>
        </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {!! $errors->has('min_Lon') ? 'error' : '' !!}">
            <label for="min_Lon" class="control-label">Min Longitude</label>
            <div class="controls">
                {!! Form::text('min_Lon',$row->MIN_LON, array('class'=>'form-control','id'=>'min_Lon','readonly' => 'readonly','tabindex' => $tabindex++))!!}
                {!! $errors->first('min_Lon', '<label class="help-block text-danger">:message</label>') !!}
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {!! $errors->has('max_lat') ? 'error' : '' !!}">
                <label for="max_lat" class="control-label">Max Latitude</label>
                <div class="controls">
                    {!! Form::text('max_lat',$row->MAX_LAT, array('class'=>'form-control', 'id'=>'max_lat', 'readonly' => 'readonly','tabindex' => $tabindex++))!!}
                    {!! $errors->first('max_lat', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {!! $errors->has('max_lon') ? 'error' : '' !!}">
                <label for="max_lon" class="control-label">Max Longitude</label>
                <div class="controls">
                    {!! Form::text('max_lon',$row->MAX_LON, array('class'=>'form-control', 'id'=>'max_lon','readonly' => 'readonly','tabindex' => $tabindex++))!!}
                    {!! $errors->first('max_lon', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
                <label for="ne_longitude">Is Active</label>
                <div class="controls">
                    {!! Form::select('is_active', ['1'=> 'Yes','0'=> 'No'],$row->IS_ACTIVE ?? 1 ,[ 'class' =>
                    'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => $tabindex++, ])
                    !!}
                    {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions text-center">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ft-x"></i>
            @lang('form.btn_cancle')</button>
        <button type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Save</button>
    </div>
</div>
{!! Form::close() !!}
<script>
    $(function () {
        $("#mapUpdateForm input,#mapUpdateForm select,#mapUpdateForm textarea").not("[type=submit]")
            .jqBootstrapValidation();
    });

</script>
<script>
    $(function () { $("#mapForm input,#mapForm select,#mapForm textarea").not("[type=submit]").jqBootstrapValidation(); } );

    $(document).ready(function() {
		var max_fields      = 20;
		var wrapper         = $(".schedule");
		var add_button      = $(".add_new_row");
		var x = {{ $count }};
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
