<select id="warehouse_type" class="form-control select2" name="warehouse_type">
    <option value="0">Select Warehouse</option>
@foreach ($data as $item)
    <option value="{{ $item->PK_NO }}">{{ $item->NAME }}</option>
@endforeach
</select>
