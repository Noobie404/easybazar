{!! Form::open([ 'route' => [ 'admin.address.city_store'], 'method' => 'post', 'class' =>'form-horizontal','id'=>'cityForm','novalidate']) !!}
<div class="form-body">
   <div class="row">
      <div class="col-md-12">
         <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
            <label>Region <span class="text-danger">*</span></label>
            <div class="controls">
               {!! Form::select('region', $data['stateCombo'], $data['city_details']->F_STATE_NO ?? null, [ 'class' => 'form-control mb-1 select2', 'id'=>'region','data-validation-required-message' => 'This filed is required','required']) !!}
               {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('city') ? 'error' : '' !!}">
            <label for="city">Name <span class="text-danger">*</span></label>
            <div class="controls">
               <div class="input-group">
                  {!! Form::text('city', null, [ 'class' => 'form-control', 'placeholder' => 'Enter name', 'data-validation-required-message' => 'This field is required','maxlength' => "255", 'tabindex' =>1,'id' => 'cat_name','required']) !!}
                  <div class="input-group-append">
                     <button class="btn btn-primary" type="button" id="translate"><i class='fa fa-spinner fa-spin' style="display: none"></i>  <i class="la la-language"></i></button>
                  </div>
               </div>
               {!! $errors->first('city', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('bn_city') ? 'error' : '' !!}">
            <label for="bn_city">Bengali <span class="text-danger">*</span></label>
            <div class="controls">
               {!! Form::text('bn_city', $row->CITY_NAME_BN ?? NULL, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'Enter city', 'tabindex' => 2,'id'=>'bn_name','required']) !!}
               {!! $errors->first('bn_city', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('latitude') ? 'error' : '' !!}">
            <label for="latitude">Latitude</label>
            <div class="controls">
               {!! Form::text('latitude', $row->LATITUDE ?? null, [ 'class' => 'form-control', 'placeholder' => 'Enter Latitude', 'tabindex' => 3,'id'=>'latitude','readonly' => 'readonly' ]) !!}
               {!! $errors->first('latitude', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('longitude') ? 'error' : '' !!}">
            <label>Longitude</label>
            <div class="controls">
               {!! Form::text('longitude', $row->LONGITUDE ?? null, [ 'class' => 'form-control','placeholder' => 'Enter longitude', 'tabindex' => 4,'id'=>'longitude','readonly' => 'readonly' ]) !!}
               {!! $errors->first('longitude', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('min_latitude') ? 'error' : '' !!}">
            <label for="latitude">Min Latitude</label>
            <div class="controls">
               {!! Form::text('min_latitude', $row->MIN_LAT ?? null, [ 'class' => 'form-control','placeholder' => 'Enter Latitude', 'tabindex' => 5,'id'=>'latitude','readonly' => 'readonly' ]) !!}
               {!! $errors->first('min_latitude', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('min_longitude') ? 'error' : '' !!}">
            <label>Min Longitude</label>
            <div class="controls">
               {!! Form::text('min_longitude', $row->MIN_LON ?? null, [ 'class' => 'form-control','placeholder' => 'Enter longitude', 'tabindex' => 6,'id'=>'min_longitude','readonly' => 'readonly' ]) !!}
               {!! $errors->first('min_longitude', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('max_latitude') ? 'error' : '' !!}">
            <label for="max_latitude">Max Latitude</label>
            <div class="controls">
               {!! Form::text('max_latitude', $row->MAX_LAT ?? null, [ 'class' => 'form-control','placeholder' => 'Enter Latitude', 'tabindex' => 7,'id'=>'max_latitude','readonly' => 'readonly' ]) !!}
               {!! $errors->first('max_latitude', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('max_longitude') ? 'error' : '' !!}">
            <label for="max_longitude">Max Longitude</label>
            <div class="controls">
               {!! Form::text('max_longitude', $row->MAX_LON ?? null, [ 'class' => 'form-control','placeholder' => 'Enter longitude', 'tabindex' => 8,'id'=>'longitude','readonly' => 'readonly' ]) !!}
               {!! $errors->first('max_longitude', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('nw_latitude') ? 'error' : '' !!}">
            <label for="nw_latitude">North-West lat</label>
            <div class="controls">
               {!! Form::text('nw_latitude', $row->NW_LAT ?? null, [ 'class' => 'form-control','placeholder' => 'Enter Latitude', 'tabindex' => 9,'id'=>'nw_latitude','readonly' => 'readonly' ]) !!}
               {!! $errors->first('nw_latitude', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('nw_longitude') ? 'error' : '' !!}">
            <label for="nw_longitude">North-West lon</label>
            <div class="controls">
               {!! Form::text('nw_longitude', $row->NW_LON ?? null, [ 'class' => 'form-control','placeholder' => 'Enter longitude', 'tabindex' => 10,'id'=>'nw_longitude','readonly' => 'readonly' ]) !!}
               {!! $errors->first('nw_longitude', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('sw_latitude') ? 'error' : '' !!}">
            <label for="sw_latitude">South-West lat</label>
            <div class="controls">
               {!! Form::text('sw_latitude', $row->SW_LAT ?? null, [ 'class' => 'form-control','placeholder' => 'Enter Latitude', 'tabindex' => 11,'id'=>'sw_latitude','readonly' => 'readonly' ]) !!}
               {!! $errors->first('sw_latitude', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('sw_longitude') ? 'error' : '' !!}">
            <label for="sw_longitude">South-West Lon</label>
            <div class="controls">
               {!! Form::text('sw_longitude', $row->SW_LON ?? null, [ 'class' => 'form-control','placeholder' => 'Enter longitude', 'tabindex' => 12,'id'=>'sw_longitude','readonly' => 'readonly' ]) !!}
               {!! $errors->first('sw_longitude', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('se_latitude') ? 'error' : '' !!}">
            <label for="se_latitude">South-East lat</label>
            <div class="controls">
               {!! Form::text('se_latitude', $row->SE_LAT ?? null, [ 'class' => 'form-control','placeholder' => 'Enter Latitude', 'tabindex' => 13,'id'=>'se_latitude','readonly' => 'readonly' ]) !!}
               {!! $errors->first('se_latitude', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('se_longitude') ? 'error' : '' !!}">
            <label for="se_longitude">South-East Lon</label>
            <div class="controls">
               {!! Form::text('se_longitude', $row->SE_LON ?? null, [ 'class' => 'form-control','placeholder' => 'Enter longitude', 'tabindex' => 14,'id'=>'se_longitude','readonly' => 'readonly' ]) !!}
               {!! $errors->first('se_longitude', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('ne_latitude') ? 'error' : '' !!}">
            <label for="ne_latitude">North-East Lat</label>
            <div class="controls">
               {!! Form::text('ne_latitude', $row->NE_LAT ?? null, [ 'class' => 'form-control','placeholder' => 'Enter Latitude', 'tabindex' => 15,'id'=>'ne_latitude','readonly' => 'readonly' ]) !!}
               {!! $errors->first('ne_latitude', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
      <div class="col-md-6">
         <div class="form-group {!! $errors->has('ne_longitude') ? 'error' : '' !!}">
            <label for="ne_longitude">North-East Lon</label>
            <div class="controls">
               {!! Form::text('ne_longitude', $row->NE_LON ?? null, [ 'class' => 'form-control', 'placeholder' => 'Enter longitude', 'tabindex' => 16,'id'=>'ne_longitude','readonly' => 'readonly' ]) !!}
               {!! $errors->first('ne_longitude', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="form-group {!! $errors->has('is_active') ? 'error' : '' !!}">
            <label for="ne_longitude">Is Active</label>
            <div class="controls">
               {!! Form::select('is_active', ['1'=> 'Yes','0'=> 'No'],1 ,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => 19 ]) !!}
               {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
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
</script>
