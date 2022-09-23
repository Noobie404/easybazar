<?php
$region = $data['region'] ?? [];
$countryCombo = $data['countryCombo'] ?? [];
?>
{!! Form::open([ 'route' => ['admin.address.region_update'], 'method' => 'post', 'class' =>'form-horizontal','id'=>'stateEditForm','novalidate']) !!}
{!! Form::hidden('id', $region->PK_NO, ['id'=>'id']) !!}
<div class="form-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {!! $errors->has('region') ? 'error' : '' !!}">
                <label for="region">Name <span class="text-danger">*</span></label>
                <div class="controls">
                    <div class="input-group">
                        {!! Form::text('region', $region->STATE_NAME, [ 'class' => 'form-control', 'placeholder' => 'Enter name', 'data-validation-required-message' => 'This field is required','maxlength' => "255", 'tabindex' =>1,'id' => 'cat_name','required' ]) !!}
                        <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="translate"><i class='fa fa-spinner fa-spin' style="display: none"></i>  <i class="la la-language"></i></button>
                    </div>
                    </div>
                    {!! $errors->first('region', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {!! $errors->has('bn_region') ? 'error' : '' !!}">
               <label for="bn_region">Bengali <span class="text-danger">*</span></label>
               <div class="controls">
                  {!! Form::text('bn_region', $region->STATE_NAME_BN, [ 'class' => 'form-control', 'data-validation-required-message' => 'This filed is required', 'placeholder' => 'Enter region', 'tabindex' => 2,'id'=>'bn_name','required' ]) !!}
                  {!! $errors->first('bn_region', '<label class="help-block text-danger">:message</label>') !!}
               </div>
            </div>
         </div>
    </div>

    <div class="row">
        <div class="col-md-6">
           <div class="form-group {!! $errors->has('latitude') ? 'error' : '' !!}">
               <label for="latitude">Latitude</label>
               <div class="controls">
                  {!! Form::text('latitude', $region->LATITUDE, [ 'class' => 'form-control', 'placeholder' => 'Enter Latitude', 'tabindex' => 3,'id'=>'latitude','readonly' => 'readonly' ]) !!}
                  {!! $errors->first('latitude', '<label class="help-block text-danger">:message</label>') !!}
               </div>
            </div>
        </div>
        <div class="col-md-6">
           <div class="form-group {!! $errors->has('longitude') ? 'error' : '' !!}">
               <label for="longitude">Longitude</label>
               <div class="controls">
                  {!! Form::text('longitude', $region->LONGITUDE, [ 'class' => 'form-control','placeholder' => 'Enter longitude', 'tabindex' => 4,'id'=>'longitude','readonly' => 'readonly' ]) !!}
                  {!! $errors->first('longitude', '<label class="help-block text-danger">:message</label>') !!}
               </div>
            </div>
        </div>
    </div>

    <div class="row">
       <div class="col-md-6">
          <div class="form-group {!! $errors->has('min_latitude') ? 'error' : '' !!}">
              <label for="min_latitude">Min Latitude</label>
              <div class="controls">
                 {!! Form::text('min_latitude', $region->MIN_LAT, [ 'class' => 'form-control','placeholder' => 'Enter Latitude', 'tabindex' => 5,'id'=>'latitude','readonly' => 'readonly' ]) !!}
                 {!! $errors->first('min_latitude', '<label class="help-block text-danger">:message</label>') !!}
              </div>
           </div>
       </div>
       <div class="col-md-6">
          <div class="form-group {!! $errors->has('min_longitude') ? 'error' : '' !!}">
              <label for="min_longitude">Min Longitude</label>
              <div class="controls">
                 {!! Form::text('min_longitude', $region->MIN_LON, [ 'class' => 'form-control','placeholder' => 'Enter longitude', 'tabindex' => 6,'id'=>'min_longitude','readonly' => 'readonly' ]) !!}
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
                 {!! Form::text('max_latitude', $region->MAX_LAT, [ 'class' => 'form-control','placeholder' => 'Enter Latitude', 'tabindex' => 7,'id'=>'max_latitude','readonly' => 'readonly' ]) !!}
                 {!! $errors->first('max_latitude', '<label class="help-block text-danger">:message</label>') !!}
              </div>
           </div>
       </div>
       <div class="col-md-6">
          <div class="form-group {!! $errors->has('max_longitude') ? 'error' : '' !!}">
              <label for="max_longitude">Max Longitude</label>
              <div class="controls">
                 {!! Form::text('max_longitude', $region->MAX_LON, [ 'class' => 'form-control','placeholder' => 'Enter longitude', 'tabindex' => 8,'id'=>'longitude','readonly' => 'readonly' ]) !!}
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
                 {!! Form::text('nw_latitude', $region->NW_LAT, [ 'class' => 'form-control','placeholder' => 'Enter Latitude', 'tabindex' => 9,'id'=>'nw_latitude','readonly' => 'readonly' ]) !!}
                 {!! $errors->first('nw_latitude', '<label class="help-block text-danger">:message</label>') !!}
              </div>
           </div>
       </div>
       <div class="col-md-6">
          <div class="form-group {!! $errors->has('nw_longitude') ? 'error' : '' !!}">
              <label for="nw_longitude">North-West lon</label>
              <div class="controls">
                 {!! Form::text('nw_longitude', $region->NW_LON, [ 'class' => 'form-control','placeholder' => 'Enter longitude', 'tabindex' => 10,'id'=>'nw_longitude','readonly' => 'readonly' ]) !!}
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
                 {!! Form::text('sw_latitude', $region->SW_LAT, [ 'class' => 'form-control','placeholder' => 'Enter Latitude', 'tabindex' => 11,'id'=>'sw_latitude','readonly' => 'readonly' ]) !!}
                 {!! $errors->first('sw_latitude', '<label class="help-block text-danger">:message</label>') !!}
              </div>
           </div>
       </div>
       <div class="col-md-6">
          <div class="form-group {!! $errors->has('sw_longitude') ? 'error' : '' !!}">
              <label for="sw_longitude">South-West Lon</label>
              <div class="controls">
                 {!! Form::text('sw_longitude', $region->SW_LON, [ 'class' => 'form-control','placeholder' => 'Enter longitude', 'tabindex' => 12,'id'=>'sw_longitude','readonly' => 'readonly' ]) !!}
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
                 {!! Form::text('se_latitude', $region->SE_LAT, [ 'class' => 'form-control','placeholder' => 'Enter Latitude', 'tabindex' => 13,'id'=>'se_latitude','readonly' => 'readonly' ]) !!}
                 {!! $errors->first('se_latitude', '<label class="help-block text-danger">:message</label>') !!}
              </div>
           </div>
       </div>
       <div class="col-md-6">
          <div class="form-group {!! $errors->has('se_longitude') ? 'error' : '' !!}">
              <label for="se_longitude">South-East Lon</label>
              <div class="controls">
                 {!! Form::text('se_longitude', $region->SE_LON, [ 'class' => 'form-control','placeholder' => 'Enter longitude', 'tabindex' => 14,'id'=>'se_longitude','readonly' => 'readonly' ]) !!}
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
                 {!! Form::text('ne_latitude', $region->NE_LAT, [ 'class' => 'form-control','placeholder' => 'Enter Latitude', 'tabindex' => 15,'id'=>'ne_latitude','readonly' => 'readonly' ]) !!}
                 {!! $errors->first('ne_latitude', '<label class="help-block text-danger">:message</label>') !!}
              </div>
           </div>
       </div>
       <div class="col-md-6">
          <div class="form-group {!! $errors->has('ne_longitude') ? 'error' : '' !!}">
              <label for="ne_longitude">North-East Lon</label>
              <div class="controls">
                 {!! Form::text('ne_longitude', $region->NE_LON, [ 'class' => 'form-control', 'placeholder' => 'Enter longitude', 'tabindex' => 16,'id'=>'ne_longitude','readonly' => 'readonly' ]) !!}
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
                {!! Form::select('is_active', ['1'=> 'Yes','0'=> 'No'],$region->IS_ACTIVE ?? 1 ,[ 'class' => 'form-control', 'data-validation-required-message' => 'This field is required', 'tabindex' => 19 ]) !!}
                {!! $errors->first('is_active', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
     </div>
   </div>
    <div class="form-actions text-center">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ft-x"></i> @lang('form.btn_cancle')</button>
        <button title="Update" type="submit" class="btn btn-primary"><i class="la la-check-square-o"></i> Update</button>
    </div>
</div>
{!! Form::close() !!}
<script>
    $(function () { $("#stateEditForm input,#stateEditForm select,#stateEditForm textarea").not("[type=submit]").jqBootstrapValidation(); } );
 </script>
