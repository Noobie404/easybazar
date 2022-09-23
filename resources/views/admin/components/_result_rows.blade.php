<?php
$list_type = \Session::get('list_type');

?>
@php
$roles = userRolePermissionArray()
@endphp
@if($rows && count($rows) > 0)
@foreach($rows as $key => $row )
<tr>  
    <td class="text-center" style="width:20px;">{{$key+1}}</td>
    <td class="text-center img_td" style="width:60px;">
        @php $img_count = 0; @endphp
        @if($row->allVariantPhotos && $row->allVariantPhotos->count() > 0)
        <div class="lightgallery" style="margin:0px  auto; text-align: center; ">
            @php $img_count = $row->allVariantPhotos->count(); @endphp
            @for($i = 0; $i < $img_count; $i++ )
            @php $vphoto = $row->allVariantPhotos[$i]; @endphp
            <a class="img_popup " href="{{ fileExit($vphoto->THUMB_PATH)}}" style="{{ $i>0 ? 'display: none' : ''}}" title="{{$row->MRK_ID_COMPOSITE_CODE}}"><img style="width: 40px !important; height: 40px;" data-src="{{ fileExit($vphoto->THUMB_PATH)}}" alt="{{$row->MRK_ID_COMPOSITE_CODE}}" src="{{fileExit($vphoto->THUMB_PATH)}}" class="unveil"></a>
            @endfor
        </div>


        @endif
        <span class="badge badge-pill badge-primary badge-square img_c" title="Total {{$img_count}} photos for the product">{{$img_count}}</span>
    </td>
    <td class="variant_name" style="" >
        {{$row->VARIANT_NAME}}
        @if($row->PREFERRED_SHIPPING_METHOD == 'SEA')
        <span class="pull-right" title=" Prefered shipping method is SEA "> <i class='la la-ship' style="color: blue"></i></span>
        @endif
        @if($row->PREFERRED_SHIPPING_METHOD == 'AIR' )
        <span class="pull-right" title=" Prefered Shipping method is AIR "> <i class='icon-plane' style="color: blue"></i></span>
        @endif
    </td>
    <td>

        @if($row->IS_ACTIVE == 0)
        <span>Inactive</span>
        @elseif($row->IS_ACTIVE == 1)
        <span>Active</span>
        @elseif($row->IS_ACTIVE == 2)
        <span>Pending</span>
        @endif
    </td>

    <td style="width:200px;">
        <div style="display:block;"><span style="width: 70px; display: inline-block">BARCODE </span>: {{$row->BARCODE}}</div>
        <div style="display:block;"><span style="width: 70px; display: inline-block">SKU </span>: {{$row->COMPOSITE_CODE}}</div>
    </td>

    <td style="width: 110px;">
        <div>{{$row->SIZE_NAME}}</div>
        <div>{{$row->COLOR}}</div>
    </td>
    <td style="width: 110px;">
        <div style="font-size :10px;" title="Brand Name / Model Name">
            {{ getBrandName($row->F_PRD_MASTER_SETUP_NO) }}
            <br>
           / {{ getModelName($row->F_PRD_MASTER_SETUP_NO) }}
        </div>


    </td>
    <td style="width: 110px;">
        {{ getCategoryChain($row->master->PK_NO) }}
    </td>

    <td style="text-align: right" style="width: 150px;">
        <span>Regular : {{ number_format($row->REGULAR_PRICE,2) }}</span><br>
        <span>Special : {{ number_format($row->SPECIAL_PRICE,2) }}</span>
        <span>Wholesale : {{ number_format($row->WHOLESALE_PRICE,2) }}</span>
    </td>



    <td style="width: 100px;" class="text-center">
        @if($list_type == 'searchlist')

        @if(hasAccessAbility('edit_product_list', $roles))
            <a href="{{ route('admin.product.searchlist.edit', [$row->F_PRD_MASTER_SETUP_NO]) }}?variant_id={{$row->PK_NO}}&type=variant&tab=2"  target="_blank" class="btn btn-xs btn-info mr-05"><i class="la la-edit" title="Edit product variant"></i></a>
        @endif
        @if(hasAccessAbility('view_product_list', $roles))
            <a href="{{ route('admin.product.searchlist.view', [$row->F_PRD_MASTER_SETUP_NO]) }}?variant_id={{$row->PK_NO}}&type=variant&tab=2"  target="_blank" class="btn btn-xs btn-success mr-05"><i class="la la-eye" title="View product variant"></i></a>
        @endif
        @if(hasAccessAbility('edit_product_list', $roles))
            <a href="javascript:void(0)" class="btn btn-xs btn-primary mr-05" id="updatemastervariant" data-variant="{{ $row->PK_NO }}" data-master="{{ $row->F_PRD_MASTER_SETUP_NO }}" data-target="#UpdateMasterVariant" data-toggle="modal"><i class="la la-pencil" title="Update Master Variant"></i></a>
        @endif
        @else
            @if(isset($multiselect) && ($multiselect == 1) )
            <input type="checkbox" name="product_no[]" value="{{$row->PK_NO}}" data-barcode="{{$row->BARCODE}}" class="variant_select"  data-multiple="1" />
            @else
            <input type="radio" name="product_no[]" value="{{$row->PK_NO}}" data-barcode="{{$row->BARCODE}}" class="variant_select" data-multiple="0" />
            @endif
        @endif
    </td>

</tr>
@endforeach()

@else
<tr>
    <td colspan="10" class="text-danger text-center">Data not found</td>
</tr>

@endif
