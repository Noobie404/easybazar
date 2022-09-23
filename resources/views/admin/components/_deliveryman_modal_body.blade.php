<div class="input-group mb-3 {!! $errors->has('delivery_boy_id') ? 'error' : '' !!}">
    {!! Form::select('delivery_boy_id',$row, NULL, [ 'class' => 'custom-select', 'tabindex' => 1,'placeholder' => 'Select delivery man' ]) !!}
    <div class="input-group-append">
        <button type="submit" class="input-group-text" for="inputGroupSelect02">Assign Delivery Man</button>
    </div>
    {!! $errors->first('delivery_boy_id', '<label class="help-block text-danger">:message</label>') !!}
</div>