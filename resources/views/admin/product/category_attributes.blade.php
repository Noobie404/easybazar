<div class="row">
    @foreach ($attributes as $item)
    @if (isset($item->ATTRIBUTE_TYPE))
    <div class="col-md-5">
        {{-- type = 1 => text --}}
        @if ($item->ATTRIBUTE_TYPE == 1)
            <div class="form-group {!! $errors->has('attr_'.$item->SLUG) ? 'error' : '' !!}">
                <label>{{ $item->NAME }} @if($item->IS_REQUIRED == 1)<span class="text-danger">*</span>@endif</label>
                <div class="controls">
                    {!! Form::text('attr_'.$item->SLUG, null, ['id'=>$item->SLUG,'class'=>'form-control','placeholder'=>'Input',$item->IS_REQUIRED == 1 ? 'required' : '']) !!}
                    {!! $errors->first('attr_'.$item->SLUG, '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        {{-- type = 2 => Dropdown --}}
        @elseif ($item->ATTRIBUTE_TYPE == 2)
            <div class="form-group {!! $errors->has('attr_'.$item->SLUG) ? 'error' : '' !!}">
                <label>{{ $item->NAME }} @if($item->IS_REQUIRED == 1)<span class="text-danger">*</span>@endif</label>
                <div class="controls">
                    {!! Form::select('attr_'.$item->SLUG,$item->attribute_child, null, [ 'id'=>$item->SLUG,'class' => 'form-control attr_select2', 'placeholder' => 'select',$item->IS_REQUIRED == 1 ? 'required' : '']) !!}
                    {!! $errors->first('attr_'.$item->SLUG, '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        {{-- type = 3 => Multiselect --}}
        @elseif ($item->ATTRIBUTE_TYPE == 3)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {!! $errors->has('attr_'.$item->SLUG) ? 'error' : '' !!}">
                        <label>{{ $item->NAME }} @if($item->IS_REQUIRED == 1)<span class="text-danger">*</span>@endif</label>
                        <div class="controls">
                            <button type="button" id="attributes" class="btn btn-outline-dropbox width-200" data-toggle="modal" data-target="#attributeModal" data-attribute="{{ $item->PK_NO }}">select attribute</button>
                            {!! $errors->first('attr_'.$item->SLUG, '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" id="selected_attr_section{{ $item->PK_NO }}" style="display: none">
                        <label>Selected attributes</label>
                        <div class="controls" id="input_tags">
                            <input class="input-tags{{ $item->PK_NO }} input_tags" id="input-tags{{ $item->PK_NO }}" type="text" data-tag_id="{{ $item->PK_NO }}" data-role="tagsinput" name="attr_{{ $item->SLUG }}" {{ $item->IS_REQUIRED == 1 ? 'required' : '' }}>
                            {{-- {!! Form::hidden('', $item->selected_attribute_child ?? [], ['id' => 'hidden_selected_attr_section']) !!} --}}
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var id = {{ $item->PK_NO }};
                var elt = $('.input-tags'+id);
                elt.tagsinput({
                    itemValue: 'value',
                    itemText: 'text',
                });
                $('#input-tags'+id).tagsinput('refresh');
                // var selected_array = $('#selected_attr_section'+id).find('#hidden_selected_attr_section').val();
                // console.log(selected_array);
                // for (var key in selected_array) {
                //     elt.tagsinput('add', { "value": key , "text": selected_array[key]  });
                // }
            </script>
        {{-- type = 4 => Number --}}
        @elseif ($item->ATTRIBUTE_TYPE == 4)
            <div class="form-group {!! $errors->has('attr_'.$item->SLUG) ? 'error' : '' !!}">
                <label>{{ $item->NAME }} @if($item->IS_REQUIRED == 1)<span class="text-danger">*</span>@endif</label>
                <div class="controls">
                    {!! Form::number('attr_'.$item->SLUG, null, ['id'=>$item->SLUG,'class'=>'form-control','placeholder'=>'Input',$item->IS_REQUIRED == 1 ? 'required' : '']) !!}
                    {!! $errors->first('attr_'.$item->SLUG, '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        @endif
    </div>
    <div class="col-md-1 pl-0">
        <i class="la la-trash attribute_dropdown_trash mt-3" data-attribute="{{ $item->PK_NO }}"></i>
    </div>
    @endif
    @endforeach
</div>
