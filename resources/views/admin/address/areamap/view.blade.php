<?php
$roles = userRolePermissionArray();
?>
<table class="table table-striped table-bordered alt-pagination table-sm" id="indextable" >
    <thead>
    <tr>
        <th>SL</th>
        <th>Region</th>
        <th>City</th>
        <th>City Area</th>
        <th>Sub Area</th>
        <th>Min Latitude/Min Longitute</th>
        <th>Max Latitude/Max Longitute</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody id="area-data">
    @if(count($rows)>0)
        @foreach ($rows as $key=> $row)
            <tr class="item{{ $row->PK_NO }}">
                <td>{{ $key+1 }}</td>
                <td>{{ $row->STATE_NAME ?? '' }}</td>
                <td>{{ $row->CITY_NAME ?? '' }}</td>
                <td>{{ $row->AREA_NAME ?? '' }}</td>
                <td>{{ $row->SUB_AREA_NAME ?? '' }} ({{ $row->SUB_AREA_NAME_BN ?? '' }})</td>
                <td>
                    <p><span title="Min Latitude Value">{{ $row->MIN_LAT }}</span></span></p>
                    <p><span title="Min Latitude Value">{{ $row->MIN_LON }}</span></span></p>
                </td>
                <td>
                    <p><span title="Max Latitude Value">{{ $row->MAX_LAT }}</span></span></p>
                    <p><span title="Max Latitude Value">{{ $row->MAX_LON }}</span></span></p>
                </td>
                <td style="width: 120px;">
                    @if(hasAccessAbility('edit_address_type', $roles))
                    <a href="#" title="Edit" data-id="{{ $row->PK_NO }}" class="btn btn-xs btn-primary mr-1 edit-row" title="EDIT"><i class="la la-edit"></i></a>
                    <a href="#" data-id="{{ $row->PK_NO }}" title="Edit" class="btn btn-xs btn-danger mr-1 delete-row" title="Delete"><i class="la la-trash"></i></a>
                    <a href="{{ URL::to('address/map')}}?mode=submap&id={{$row->PK_NO }}" target="_blank" class="btn btn-xs btn-success"><i class="la la-map-marker" aria-hidden="true"></i></a>
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="50">No record found</td>
        </tr>
    @endif
    </tbody>
</table>
@push('custom_js')
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script>
    $('#indextable').datatable();
</script>
@endpush
