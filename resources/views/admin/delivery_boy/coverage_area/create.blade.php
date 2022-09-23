<?php
$regions = $data['stateCombo'] ?? [];
$user = $data['user'] ?? [];
?>
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
<style>
    .select2-close-mask{
    z-index: 2099;
}
.select2-dropdown{
    z-index: 3051;
}
</style>
@endpush('custom_css')

{!! Form::open([ 'route' => ['admin.delivery_boy.area_list.store',$user->PK_NO], 'method' => 'post', 'class' => 'form-horizontal', 'files' => false, 'id'=>'areaForm', 'novalidate']) !!}

<div class="row">
    <div class="col-md-6">
        <div class="form-group {!! $errors->has('region') ? 'error' : '' !!}">
           <label for="region">Region <span class="text-danger">*</span></label>
           <div class="controls">
              {!! Form::select('region', $regions, null, [ 'class' => 'form-control', 'id'=>'region','data-validation-required-message' => 'This filed is required','placeholder'=>'Select region','tabindex'=>1,'required']) !!}
              {!! $errors->first('region', '<label class="help-block text-danger">:message</label>') !!}
           </div>
        </div>
     </div>
     <div class="col-md-6">
        <div class="form-group {!! $errors->has('city') ? 'error' : '' !!}">
           <label for="city">City <span class="text-danger">*</span></label>
           <div class="controls">
              <select name="city" class="form-control" id="city" data-validation-required-message="This filed is required" tabindex="2" required>
              </select>
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
                <select name="area" class="form-control" id="area" data-validation-required-message="This filed is required" tabindex="3" required>
                </select>
             {!! $errors->first('area', '<label class="help-block text-danger">:message</label>') !!}
            </div>
         </div>
     </div>
     <div class="col-md-12">
         <div class="form-group {!! $errors->has('subarea') ? 'error' : '' !!}">
         <label for="subarea">Subarea <span class="text-danger">*</span></label>
         <div class="controls">
            <select name="subarea[]" class="form-control select2" id="subarea" data-validation-required-message="This filed is required" tabindex="4"  multiple="multiple" required>
                @if(!empty($user->area))
                @foreach ($user->area as $item)
                <option value="{{ $item->PK_NO }}" selected>{{ $item->SUB_AREA_NAME }}</option>
                @endforeach
                @endif
            </select>
             {!! $errors->first('subarea', '<label class="help-block text-danger">:message</label>') !!}
         </div>
         </div>
     </div>
 </div>
<div class="form-actions text-center mt-3">
    <button type="button" class="btn btn-warning mr-1" title="Cancel"  data-dismiss="modal">
        <i class="ft-x"></i> @lang('form.btn_cancle')
    </button>
    <button type="submit" class="btn btn-primary" title="Save">
        <i class="la la-check-square-o"></i> @lang('form.btn_save')
    </button>
</div>

{!! Form::close() !!}

@push('custom_js')
<script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script>
$('.select2').each(function() {
    $(this).select2({ dropdownParent: $(this).parent()});
})
</script>
@endpush
