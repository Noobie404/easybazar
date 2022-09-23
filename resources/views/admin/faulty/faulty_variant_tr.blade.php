<?php
use Carbon\Carbon;
// echo '<pre>';
// echo '======================<br>';
// print_r($item);
// echo '<br>======================<br>';
// exit();
?>
<style>
    #checkbox_div{
        height: 39.2px;
    }
</style>
<tr>
    <td style="width: 10%;"><img style="width: 150px !important; height: 150px;" src="{{ asset($item['info'][0]->PRD_VARIANT_IMAGE_PATH ?? '' ) }}" alt="PICTURE"></td>
    <td style="width: 20%">
        {{ $item['info'][0]->PRD_VARINAT_NAME ?? '' }}
        <br>
        <p>Retail price:<span id="ss_price" class="danger" >{{ number_format($item['info'][0]->REGULAR_PRICE,2, '.', '') }}</span> RM</p>
        <p>Special price:<span id="sm_price" class="danger"> {{number_format($item['info'][0]->SPECIAL_PRICE,2, '.', '') }}</span> RM</p>
        <p>Wholesale price:<span id="sm_price" class="danger"> {{number_format($item['info'][0]->WHOLESALE_PRICE,2, '.', '') }}</span> RM</p>

    </td>
    <th style="width: 10%">
        <table id="warehouse">
            @if(!empty($item['info']))
            @foreach ($item['info'] as $data)
            <tr id="warehouse_delete{{ $data->PK_NO }}">
                <td>
                    @if ($data->F_BOOKING_NO != null || $data->F_BOOKING_NO != 0)
                    <a href="{{ route('admin.booking_to_order.book-order',$data->F_BOOKING_NO) }}" target="_blank">
                    @elseif($data->F_BOOKING_NO != null || $data->F_BOOKING_NO != 0)
                    <a href="{{ route('admin.booking.edit',$data->F_BOOKING_NO) }}" style="color: #FF9149;" target="_blank">
                    @endif
                    {{ $data->SHOP_NAME }} (Ready Stock)
                    @if ($data->F_BOOKING_NO != null || $data->F_BOOKING_NO != 0 || $data->F_BOOKING_NO != null || $data->F_BOOKING_NO != 0)
                    </a>
                    @endif
                </td>
            </tr>

            @endforeach
            @endif
        </table>
    </th>
    <th id="per_product_costs_th" style="width: 1%;">
        @foreach ($item['info'] as $data)
        <div id="per_product_costs_delete{{ $data->PK_NO }}" style="width: 100%;">
            <div style="margin-bottom: 5px" id="per_product_costs">
                <input name="unit_costs[]" value="{{ number_format($data->REGULAR_PRICE,2, '.', '') }}" id="per_product_value" type="number" style="font-weight: normal;font-size: 12px;text-align:right;" class="form-control input-sm" readonly>
            </div>
        </div>
        @endforeach
    </th>
    <th id="per_product_costs_th" style="width: 1%;">
        @foreach ($item['info'] as $data)
        <div id="per_product_costs_delete{{ $data->PK_NO }}" style="width: 100%;">
            <div style="margin-bottom: 5px" id="per_product_costs">
                <input name="unit_costs[]" value="{{ number_format($data->INSTALLMENT_PRICE,2, '.', '') }}" id="per_product_value" type="number" style="font-weight: normal;font-size: 12px;text-align:right;" class="form-control input-sm" readonly>
            </div>
        </div>
        @endforeach
    </th>
    <th id="per_product_costs_th" style="width: 1%;">
        @foreach ($item['info'] as $data)
        <div id="per_product_costs_delete{{ $data->PK_NO }}" style="width: 100%;">
            <div style="margin-bottom: 5px" id="per_product_costs">
                <input name="unit_costs[]" value="{{ number_format($data->INSTALLMENT_PRICE,2, '.', '') }}" id="per_product_value" type="number" style="font-weight: normal;font-size: 12px;text-align:right;" class="form-control input-sm" readonly>
            </div>
        </div>
        @endforeach
    </th>

    <th id="per_product_costs_th" style="width: 1%;">
        @foreach ($item['info'] as $data)
        <div id="per_product_costs_delete{{ $data->PK_NO }}" style="width: 100%;height: 34px;margin-bottom: 5px">
            <div style="" id="per_product_costs">
                <a href="{{ asset($data->PRC_IN_IMAGE_PATH) }}" class="btn btn-xs btn-info" style="" target="_blank" title="VIEW INVOICE"><i class="ft-file-text"></i></a>
            </div>
        </div>
        @endforeach
    </th>
    <th id="checkbox_th" style="width: 1%;">
        @foreach ($item['info'] as $data)
        <div id="checkbox_delete{{ $data->PK_NO }}" style="width: 100%;height: 34px;margin-bottom: 5px">
            <div style="" id="checkbox_div" class="">
                {{-- <fieldset>
                    <input name="checkbox_value_{{ $data->PK_NO }}" type="checkbox" data-pk_no="{{ $data->PK_NO }}" data-booking_no="{{ $data->F_BOOKING_NO ?? 0 }}" id="checkbox_of_faulty{{ $data->PK_NO }}" {{ $data->PRODUCT_STATUS == 420 ? 'disabled checked' : '' }}>
                </fieldset> --}}
                <a href="javascript:void(0)" class="btn btn-xs {{ $data->PRODUCT_STATUS == 420 || $data->IS_FAULTY == 1 ? 'btn-danger' : 'btn-warning' }} mr-05" title="Mark Faulty" data-pk_no="{{ $data->PK_NO }}" data-product_status="{{ $data->PRODUCT_STATUS }}" data-is_faulty="{{ $data->IS_FAULTY }}" data-booking_no="{{ $data->F_BOOKING_NO ?? 0 }}" id="mark_faulty_popup{{ $data->PK_NO }}"><i class="la la-warning"></i></a>
            </div>
        </div>
        @endforeach
    </th>
</tr>
