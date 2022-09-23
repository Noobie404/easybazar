@php
$roles = userRolePermissionArray()
@endphp
@if($rows && count($rows) > 0)
@foreach($rows as $key => $row )
<tr>
    <td class="text-center" style="width:20px;">{{$key+1}}</td>
    <td class="text-center img_td" style="width:60px;">
        @php $img_count = 0; @endphp
        @if($row->allDefaultPhotos && $row->allDefaultPhotos->count() > 0)
        <div class="lightgallery" style="margin:0px  auto; text-align: center; ">
            @php $img_count = $row->allDefaultPhotos->count(); @endphp
            @for($i = 0; $i < $img_count; $i++ )
            @php $vphoto = $row->allDefaultPhotos[$i]; @endphp
            <a class="img_popup " href="{{ asset($vphoto->RELATIVE_PATH)}}" style="{{ $i>0 ? 'display: none' : ''}}" title="{{$row->COMPOSITE_CODE}}"><img style="width: 100%" data-src="{{ asset($vphoto->RELATIVE_PATH)}}" alt="{{$row->COMPOSITE_CODE}}" src="{{asset($vphoto->RELATIVE_PATH)}}" class="unveil"></a>
            @endfor
        </div>


        @endif
        <span class="badge badge-pill badge-primary badge-square img_c" title="Total {{$img_count}} photos for the product">{{$img_count}}</span>
    </td>
    <td class="variant_name" style="" >
        {{$row->DEFAULT_NAME}}
    </td>
    <td style="width:200px;">
        <div style="display:block;"><span style="width: 70px; display: inline-block">IG </span>: {{$row->COMPOSITE_CODE}}</div>
        <div style="display:block;"><span style="width: 70px; display: inline-block">HS CODE </span>: {{$row->DEFAULT_HS_CODE}}</div>
    </td>

    <td style="width: 110px;">
        <div style="font-size :10px;" title="Brand Name / Model Name">
            {{ $row->BRAND_NAME ?? '' }}
            <br>
            &nbsp;&nbsp;{{ $row->MODEL_NAME ?? '' }}
        </div>
    </td>
    <td style="width: 110px;">
        <div style="font-size :10px;" title="Category Name / Sub Category Name">
            {{ $row->subcategory->category->NAME ?? '' }}
            <br>
            &nbsp;&nbsp;{{ $row->subcategory->NAME ?? '' }}
        </div>
    </td>
    <td style="width: 100px;" class="text-center">
        @if(hasAccessAbility('view_product', $roles))
        <a href="{{ route('admin.product.view', [$row->PK_NO]) }}" target="_blank" class="btn btn-xs btn-success mr-05"><i class="la la-eye" title="View product"></i></a>
        @endif
        @if(hasAccessAbility('edit_product_list', $roles))
        <a href="javascript:void(0)" class="btn btn-xs btn-primary mr-05" id="swap_variant_master" data-master="{{ $row->PK_NO }}"><i class="la la-exchange" title="Assign Variant Under This Master"></i></a>
        @endif
    </td>
</tr>
@endforeach()
@else
<tr>
    <td colspan="10" class="text-danger text-center">Data not found</td>
</tr>

@endif
