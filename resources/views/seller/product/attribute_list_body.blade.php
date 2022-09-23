<li>
    <label class="checkbox-label" for="input-0" style="">
    <input name="" type="checkbox"
           class="all_attr_input"
           value="0"
           id="input-0">
    <span class="checkmark"></span>
    <span class="attr_name">Select All</span>
    </label>
</li>
@foreach ($attributes as $item)
    <li>
        <label class="checkbox-label" for="input-{{ $loop->index+1}}" style="">
        <input name="{{ $item->VALUE }}" type="checkbox"
                class="all_attr_input"
                value="{{ $item->PK_NO }}"
                id="input-{{ $loop->index+1}}" {{ in_array($item->PK_NO ,$tags) ? 'checked' : '' }}>
        <span class="checkmark"></span>
        <span class="attr_name">{{ $item->VALUE }}</span>
        </label>
    </li>
@endforeach
