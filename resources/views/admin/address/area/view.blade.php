
<?php
$roles = userRolePermissionArray();
?>
<tr class="item{{ $row->PK_NO }}" style="background-color: rgba(255,203,95,.05);border: 1px solid #ffcb5f;">
    <td>{{$row->index + 1}}</td>
    <td>{{ $row->CITY_NAME }}</td>
    <td>{{ $row->STATE_NAME }}</td>
    <td>{{ $row->AREA_NAME }}</td>
    <td>{{ $row->AREA_NAME_BN }}</td>
      <td>
              @if($row->NW_LAT)
              <span title="North-West Latitude Value">{{ $row->NW_LAT }}</span>,
              @endif
              @if($row->NW_LON)
              <span title="North-West Longitude Value">{{ $row->NW_LON }}</span><br>
              @endif
              @if($row->SW_LAT)
              <span title="South-West Latitude Value">{{ $row->SW_LAT }}</span>,
              @endif
              @if($row->SW_LON)
              <span title="South-West Longitude Value">{{ $row->SW_LON }}</span>
              @endif
      </td>
      <td>
              @if($row->NE_LAT)
              <span title="North-East Latitude Value">{{ $row->NE_LAT }}</span>,
              @endif
              @if($row->NE_LON)
              <span title="North-East Longitude Value">{{ $row->NE_LON }}</span><br>
              @endif
              @if($row->SE_LAT)
              <span title="South-East Latitude Value">{{ $row->SE_LAT }}</span>,
              @endif
              @if($row->SE_LON)
              <span title="South-East Longitude Value">{{ $row->SE_LON }}</span>
              @endif
      </td>

    <td>
       @if(hasAccessAbility('edit_address_type', $roles))
       <a href="#" data-id="{{ $row->PK_NO }}" title="Edit" class="btn btn-xs btn-primary mr-1 edit-row" title="EDIT"><i class="la la-edit"></i></a>
       <a href="#" data-id="{{ $row->PK_NO }}" title="Edit" class="btn btn-xs btn-danger mr-1 delete-row" title="Delete"><i class="la la-trash"></i></a>
       <a href="{{ URL::to('address/map')}}?mode=area&id={{$row->PK_NO }}" target="_blank" class="btn btn-xs btn-success"><i class="la la-map-marker" aria-hidden="true"></i></a>
       @endif
    </td>
 </tr>
