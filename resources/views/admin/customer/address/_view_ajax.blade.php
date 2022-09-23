<?php
    $roles = userRolePermissionArray();
?>
@if(!empty($row))
<div class="p-2 item{{$row->PK_NO}}" style="background-color: rgba(255,203,95,.05);border: 1px solid #ffcb5f;">
    <div width="25%;" class="pinfo">
       <span class="d-block">{{ $row->NAME }}</span>
       <span class="d-block"><i class="ft-phone-call"></i> +88{{ $row->MOBILE_NO }}</span>
    </div>
    <div> 
        @if(!empty($row->ADDRESS_LINE_1))
         <span> {{ $row->ADDRESS_LINE_1 }}, </span>
        @endif
        @if(!empty($row->ADDRESS_LINE_2))
         <span> {{ $row->ADDRESS_LINE_2 }}, </span>
        @endif
        @if(!empty($row->AREA_NAME))
         <span> {{ $row->AREA_NAME }} </span>
        @endif
         <br>
        @if(!empty($row->CITY_NAME))
          <span> {{ $row->CITY_NAME ?? '' }} - {{ $row->POST_CODE ?? '' }}, </span>
        @endif
         <span> {{ $row->STATE_NAME ?? '' }}, Bangladesh </span>
    </div>
    <div>
        @if($row->IS_DEFAULT == 1)
        <span class="d-block">Default Shipping Address</span>
        @endif
    </div>
    <div style="width: 120px;">
        <div class="wrap-td-action">
            @if(hasAccessAbility('edit_customer_address', $roles))
            <a href="#" data-key="{{ $row->PK_NO }}" data-id="{{ $row->PK_NO }}" class="btn btn-xs btn-primary edit-row" title="EDIT"><i class="la la-edit"></i></a>
            @endif
            @if(hasAccessAbility('delete_customer_address', $roles))
            <a href="#" data-id="{{ $row->PK_NO }}"  class="btn btn-xs btn-danger delete-address" title="Delete customer address"><i class="la la-trash"></i></a>
            @endif
        </div>
    </div>
</div>
@else
<div class="border py-1 px-2 mb-2" style="background-color: rgba(255,203,95,.05);border: 1px solid #ffcb5f;">
    <div class="align-items-center text-center"> 
        <button type="button" class="btn btn-sm btn-info" id="newAddresss"><i class="la la-plus"></i> Add Address</button>
    </div>
</div>
@endif