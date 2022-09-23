{{-- <div class="list-group-item pb-0" data-id="{{ $data['pk_no'] }}">
    <div class="row">
        <span class="handle"></span>
        <div class="col-md-6">
            <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                <div class="controls">
                    {!! Form::text('name', $data['value'] ?? null, [ 'class' => 'form-control mb-1','id'=>'name', 'placeholder' => 'Enter value','tabindex' => 1 ]) !!}
                    {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-5" align="right">
            <button type="button" id="update" class="btn btn-info btn-sm" title="UPDATE" value="update" data-pk_no="{{ $data['pk_no'] }}"><i class="la la-edit"></i>Update</button>
            <button type="button" id="delete" class="btn btn-danger btn-sm" title="DELETE" value="delete" data-pk_no="{{ $data['pk_no'] }}" ><i class="la la-trash"></i>Delete</button>
            <div class="controls" style="display: inline-block;">
            {!! Form::select('is_active', array(1=>'YES',0=>'NO'), 1, ['class' =>'custom-select','style' => 'font-size: 12px;','id'=>'is_active','data-pk_no' => $data['pk_no']]) !!}
            </div>
        <div style="display: inline-block;">
            <i class="la la-question-circle" style="font-size: 22px;"></i>
        </div>
        </div>
    </div>
</div> --}}

<div class="list-group-item pb-0" data-id="{{ $data['pk_no'] }}">
    <div class="row">
        <div class="col-md-1" align="left">
        <span class="handle"></span>
        </div>
        <div class="col-md-6">
            <div class="form-group {!! $errors->has('name') ? 'error' : '' !!}">
                <div class="controls">
                    {!! Form::text('name', $data['value'] ?? null, [ 'class' => 'form-control mb-1','id'=>'name', 'placeholder' => 'Enter value','tabindex' => 1 ]) !!}
                    {!! $errors->first('name', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-auto" align="right">
            <button type="button" id="update" class="btn btn-info btn-sm" title="UPDATE"value="update" data-pk_no="{{ $data['pk_no'] }}"><i class="la la-edit"></i>Update</button>
            <button type="button" id="delete" class="btn btn-danger btn-sm" title="DELETE" value="delete" data-pk_no="{{ $data['pk_no'] }}" ><i class="la la-trash"></i>Delete</button>
            <div class="controls" style="display: inline-block;">
            {!! Form::select('is_active', array(1=>'YES',0=>'NO'), 1, ['class' =>'custom-select','id'=>'is_active','style' => 'font-size: 12px;','data-pk_no' => $data['pk_no']]) !!}
            </div>
            <div style="display: inline-block;">
                <i class="la la-question-circle" style="font-size: 22px;"></i>
            </div>
        </div>
    </div>
</div>
<script>
    $('.la-question-circle').tooltip({title: "Wheather you want to view this or not", animation: true});
</script>
