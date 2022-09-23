<div class="row">
    @foreach ($attributes as $item)
    @if (isset($item->ATTRIBUTE_TYPE))
    <div class="col-md-6">
        {{-- type = 1 => text --}}
        @if ($item->ATTRIBUTE_TYPE == 1)
            <div class="form-group {!! $errors->has($item->SLUG) ? 'error' : '' !!}">
                <label>{{ $item->NAME }} @if($item->IS_REQUIRED == 1)<span class="text-danger">*</span>@endif</label>
                <div class="controls">
                    {!! Form::text($item->SLUG, null, ['id'=>$item->SLUG,'class'=>'form-control','placeholder'=>'Input']) !!}
                    {!! $errors->first($item->SLUG, '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        {{-- type = 2 => Dropdown --}}
        @elseif ($item->ATTRIBUTE_TYPE == 2)
            <div class="form-group {!! $errors->has($item->SLUG) ? 'error' : '' !!}">
                <label>{{ $item->NAME }} @if($item->IS_REQUIRED == 1)<span class="text-danger">*</span>@endif</label>
                <div class="controls">
                    {!! Form::select($item->SLUG,$item->attribute_child, null, [ 'id'=>$item->SLUG,'class' => 'form-control select2', 'placeholder' => 'select']) !!}
                    {!! $errors->first($item->SLUG, '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        {{-- type = 3 => Multiselect --}}
        @elseif ($item->ATTRIBUTE_TYPE == 3)
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group {!! $errors->has($item->SLUG) ? 'error' : '' !!}">
                        <label>{{ $item->NAME }} @if($item->IS_REQUIRED == 1)<span class="text-danger">*</span>@endif</label>
                        <div class="controls">
                            <button type="button" id="attributes" class="btn btn-outline-dropbox width-200" data-toggle="modal" data-target="#attributeModal" data-attribute="{{ $item->PK_NO }}">select attribute</button>
                            {!! $errors->first($item->SLUG, '<label class="help-block text-danger">:message</label>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {!! $errors->has($item->SLUG) ? 'error' : '' !!}" id="selected_attr_section{{ $item->PK_NO }}">
                        <label>Selected attributes</label>
                        <div class="controls" id="input_tags">
                            <input class="input-tags{{ $item->PK_NO }}" id="input-tags{{ $item->PK_NO }}" type="text" data-tag_id="{{ $item->PK_NO }}" data-role="tagsinput" name="{{ $item->SLUG }}">
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
            </script>
        {{-- type = 4 => Number --}}
        @elseif ($item->ATTRIBUTE_TYPE == 4)
            <div class="form-group {!! $errors->has($item->SLUG) ? 'error' : '' !!}">
                <label>{{ $item->NAME }} @if($item->IS_REQUIRED == 1)<span class="text-danger">*</span>@endif</label>
                <div class="controls">
                    {!! Form::number($item->SLUG, null, ['id'=>$item->SLUG,'class'=>'form-control','placeholder'=>'Input']) !!}
                    {!! $errors->first($item->SLUG, '<label class="help-block text-danger">:message</label>') !!}
                </div>
            </div>
        @endif
    </div>
    @endif
    @endforeach
</div>
