<div class="list-group-item pb-0" data-id="{{ $data['pk_no'] }}">
    <div class="row">
        <div class="col-md-1 pl-0" align="left">
        <span class="handle"></span>
        </div>
        <div class="col-md-6">
            <div class="form-group {!! $errors->has('multivalue') ? 'error' : '' !!}">
                <div class="controls">
                    {!! Form::text('multivalue', $data['value'] ?? null, [ 'class' => 'form-control mb-1','id'=>'multivalue', 'placeholder' => 'Enter value' ]) !!}
                    {!! $errors->first('multivalue', '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        </div>
        <div class="col-md-auto pl-0" align="right">
            <button type="button" id="update" class="btn btn-info btn-sm" title="UPDATE" value="update" data-pk_no="{{ $data['pk_no'] }}"><i class="la la-edit"></i>Update</button>
            @if ($data['type'] == 2)
            <button type="button" id="" class="btn btn-primary btn-sm add_child" title="ADD CHILD" value="add_child" data-pk_no="{{ $data['pk_no'] }}"><i class="la la-plus"></i></button>
            @endif
            <button type="button" id="delete" class="btn btn-danger btn-sm" title="DELETE" value="delete" data-pk_no="{{ $data['pk_no'] }}" ><i class="la la-trash"></i>Delete</button>
        </div>
    </div>
</div>
