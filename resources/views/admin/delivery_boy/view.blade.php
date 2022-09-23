<?php
$roles = userRolePermissionArray();
?>
<tr class="item{{$row->PK_NO}}">
    <td></td>
    <td class="text-center">
        @if($row->PROFILE_PIC_URL)
        <img src="{{$row->PROFILE_PIC_URL}}" alt="{{ $row->NAME }}" width="50" class="img-fluid">
        @endif
    </td>
    <td>{{ $row->NAME }}</td>
    <td>{{ $row->EMAIL }}</td>
    <td>+88 {{ $row->MOBILE_NO }}</td>
    <td>{{ $row->IS_ACTIVE == 1 ? 'Active' : 'Inactive' }}</td>
    <td>
        @if(!empty($row->area))
            @foreach ($row->area as $item)
                <p class="cov_{{ $item->PK_NO }}">
                    <span>{{ $item->CITY_NAME }} | </span>
                    <span>{{ $item->AREA_NAME }} | </span>
                    <span class="badge item{{ $item->PK_NO }}">{{ $item->SUB_AREA_NAME }}
                    <a href="javascript:void(0)" data-id="{{ $item->PK_NO }}" class="area-times delete_cv"><i class="la la-times" style="font-size: 10px;"></i>
                    </a>
                </span></p>
            @endforeach
        @endif

    </td>
    <td class="text-center">
    @if(hasAccessAbility('edit_delivery_body', $roles))
     <a href="#" data-key="" data-id="{{ $row->PK_NO }}" class="btn btn-xs btn-primary mr-1 edit-row" title="EDIT"><i class="la la-edit"></i></a>
     {{-- <a href="#" data-id="{{ $row->PK_NO }}"  class="btn btn-xs btn-danger mr-1" title="Delete delivery boy"><i class="la la-trash" ></i></a> --}}

     <a href="{{ route('admin.delivery_boy.view', [$row->PK_NO]) }}"  class="btn btn-xs btn-info" title="Delivery boy dashboard"><i class="la la-eye"></i></a>

     @endif

     @if (hasAccessAbility('edit_delivery_body', $roles))
     <a href="javascript:void(0)" data-id="{{ $row->PK_NO }}" class="btn btn-xs btn-info mb-05 mr-05 delivery_body_area" title="Delivery body coverage area" >
         <i class="la la-map-marker"></i>
     </a>
    @endif

    </td>
</tr>
