@if($rows && count($rows) > 0 )
@foreach( $rows as $key => $row )
<tr class="row_{{ $row->IS_PRODUCT == 1 ? $row->PK_NO : $row->MASTER_NO }}">
    <td>
        {!! Form::checkbox('checkbox', null, '', ['id'=>'checkbox','class'=>'ml-1']) !!}
    </td>
    <td>
        <img src="{{ asset($row->IMAGE_PATH) }}"  style="width : 50px;" />
    </td>
    <td>
        {{ $row->NAME }}
    </td>
    <td class="text-center">
        <a href="{{ $row->IS_PRODUCT == 1 ? route('admin.product.view',$row->MASTER_NO) : route('admin.product.view',$row->PK_NO) }}" class="btn btn-xs btn-info mr-1 delete-row"><i class="la la-eye"></i></a>
    </td>
</tr>
@endforeach
@else
<tr>
    <td colspan="4">
        Data not found
    </td>
</tr>
@endif
