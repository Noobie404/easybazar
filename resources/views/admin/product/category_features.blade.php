@if ($features)
<script>
    var variable_array_list = {};
    var variable_array_name = [];
    var variable_array_fullname = [];
</script>
@foreach ($features as $item)
@if (isset($item->FEATURE_TYPE))
        <script>
            variable_array_name.push('{{ $item->SLUG }}');
            variable_array_fullname.push('{{ $item->NAME }}');
            variable_array_list['{{ $item->SLUG }}'] = {attr:[],attr_ids:[],attr_pk:{{ $item->PK_NO }},is_color:{{ $item->IS_COLOR }}};
        </script>
<div class="row">
    <div class="col-md-6">
        {{-- type = 1 => Dropdown --}}
        @if ($item->FEATURE_TYPE == 1)
            <label>{{ $item->NAME }} <span class="text-danger">*</span></label>
            <div class="append_feature_dropdown">
                @if (isset($featureoptions['color']) && $item->IS_COLOR == 1)
                    @foreach ($featureoptions['color'] as $featureOption)
                    <div class="form-repeat">
                        <div class="form-group{!! $errors->has($item->SLUG) ? ' error' : '' !!}">
                            <div class="controls">
                                <div class="row">
                                    <div class="col-md-11">
                                        <select name="{{ $item->SLUG }}" class="form-control feature_dropdown add_new" disabled required>
                                            @foreach ($item->feature_child as $key => $value)
                                            <option @if ($key == $featureOption) selected @endif value="{{ $key }}">{{ $value }}</option>
                                            <script>
                                                @if ($key == $featureOption)
                                                variable_array_list['{{ $item->SLUG }}'].attr.push('{{ $value }}');
                                                variable_array_list['{{ $item->SLUG }}'].attr_ids.push('{{ $key }}');
                                                @endif
                                            </script>
                                            @endforeach
                                        </select>
                                        {!! $errors->first($item->SLUG, '<label class="help-block text-danger">:message</label>') !!}
                                    </div>
                                    <div class="col-md-1 pl-0">
                                        <i class="la la-trash feature_dropdown_trash disable"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @elseif (isset($featureoptions['size']) && $item->IS_COLOR == 0)
                @foreach ($featureoptions['size'] as $featureOption)
                <div class="form-repeat">
                    <div class="form-group{!! $errors->has($item->SLUG) ? ' error' : '' !!}">
                        <div class="controls">
                            <div class="row">
                                <div class="col-md-11">
                                    <select name="{{ $item->SLUG }}" class="form-control feature_dropdown add_new" disabled required>
                                        @foreach ($item->feature_child as $key => $value)
                                        <option @if ($key == $featureOption) selected @endif value="{{ $key }}">{{ $value }}</option>
                                        <script>
                                            @if ($key == $featureOption)
                                            variable_array_list['{{ $item->SLUG }}'].attr.push('{{ $value }}');
                                            variable_array_list['{{ $item->SLUG }}'].attr_ids.push('{{ $key }}');
                                            @endif
                                        </script>
                                        @endforeach
                                    </select>
                                    {!! $errors->first($item->SLUG, '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                                <div class="col-md-1 pl-0">
                                    <i class="la la-trash feature_dropdown_trash disable"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                <div class="form-repeat">
                    <div class="form-group{!! $errors->has($item->SLUG) ? ' error' : '' !!}">
                        <div class="controls">
                            <div class="row">
                                <div class="col-md-11">
                                        <select name="{{ $item->SLUG }}" class="form-control feature_dropdown add_new" @if (isset($featureoptions['color']) || isset($featureoptions['size']))  @else required @endif>
                                            <option value="">select option</option>
                                            @foreach ($item->feature_child as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    {!! $errors->first($item->SLUG, '<label class="help-block text-danger">:message</label>') !!}
                                </div>
                                <div class="col-md-1 pl-0">
                                    <i class="la la-trash feature_dropdown_trash"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="feature_dropdown_hidden" style="display:none">
                    <div class="form-repeat">
                        <div class="form-group{!! $errors->has($item->SLUG) ? ' error' : '' !!}">
                            <div class="controls">
                                <div class="row">
                                    <div class="col-md-11">
                                        {{-- {!! Form::select($item->SLUG,$item->feature_child, null, [ 'id'=>$item->SLUG,'class' => 'form-control feature_dropdown', 'placeholder' => 'select option']) !!} --}}
                                        <select name="{{ $item->SLUG }}" class="form-control feature-color-hidden">
                                            <option value="">select option</option>
                                            @foreach ($item->feature_child as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1 pl-0">
                                        <i class="la la-trash feature_dropdown_trash"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="new-wrap" style="display: none;">
                <select class="form-control select2">
                    @foreach ($item->feature_child as $items)
                    <option>{{ $items }}</option>
                    @endforeach
                </select>
            </div>
            <div class="main">
                <select class="form-control select2">
                    @foreach ($item->feature_child as $items)
                    <option>{{ $items }}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" class="btn btn-primary add">Add</button> --}}
        {{-- type = 2 => Multiselect --}}
        @elseif ($item->FEATURE_TYPE == 2)
            <div class="form-group {!! $errors->has($item->SLUG) ? 'error' : '' !!}">
                <label>{{ $item->NAME }}<span class="text-danger">*</span></label>
                <div class="controls custom_radio_section">
                    @if (isset($item->feature_options))
                        <?php $i = 0; ?>
                        @foreach ($item->feature_options as $key => $feature_radio)
                        <label class="custom_radio_label">{!! Form::radio($item->SLUG, $key, isset($featureoptions) && isset($featureoptions['option2']) && $featureoptions['option2'] == $key ? true : ($i == 0 ? true : false),['class' => 'feature_radio custom_radio']) !!} {{ $feature_radio }}
                        <span class="radio_checkmark"></span>
                        </label>&nbsp;&nbsp;
                        {{-- <label class="custom_radio_label">{!! Form::radio($item->SLUG, $key, isset($featureoptions) && isset($featureoptions['option2']) && $featureoptions['option2'] == $key ? true : ($i == 0 ? true : false),['class' => 'feature_radio custom_radio',isset($featureoptions) && isset($featureoptions['option2']) ? 'disabled' : '']) !!} {{ $feature_radio }}
                        <span class="radio_checkmark"></span>
                        </label>&nbsp;&nbsp; --}}
                        <?php $i++; ?>
                        @endforeach
                    @endif
                    {{-- {!! Form::select($item->SLUG,$item->feature_child, $featureoptions['size'] ?? null, [ 'id'=>$item->SLUG,'class' => 'form-control feature_list_select2','multiple' => 'multiple','required']) !!} --}}
                    <select name="{{ $item->SLUG }}" id="{{ $item->SLUG }}" class="form-control feature_list_select2" multiple required>
                        @if (isset($item->feature_child))
                            @foreach ($item->feature_child as $key => $childs)
                            @if (isset($featureoptions) && isset($featureoptions['size']))
                            <option @if (in_array($key,$featureoptions['size'])) selected locked="locked" @endif value="{{ $key }}">{{ $childs }}</option>
                            <script>
                                @if (in_array($key,$featureoptions['size']))
                                variable_array_list['{{ $item->SLUG }}'].attr.push('{{ $childs }}');
                                variable_array_list['{{ $item->SLUG }}'].attr_ids.push('{{ $key }}');
                                @endif
                            </script>
                            @else
                            <option value="{{ $key }}">{{ $childs }}</option>
                            @endif
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        @endif
    </div>
</div>
@endif
@endforeach
@endif
