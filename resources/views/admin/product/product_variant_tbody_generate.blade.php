<tr class="next-table-row first" role="row" id={{ $id }}>
    <td class="next-table-cell first" style="text-align: center;" >
        <div class="next-table-cell-wrapper">
            <div class="custom-control custom-switch custom-switch-lg">
                <input type="checkbox" name="is_active_variant[]" value="1" class="custom-control-input variant_inputs" id="variantcustomSwitch{{ $id }}" checked>
                <label class="custom-control-label" for="variantcustomSwitch{{ $id }}"></label>
            </div>
        </div>
    </td>
    @if (isset($name[0]))
    <td class="" style="text-align: center;" >
        <div class="next-table-cell-wrapper">
            <div class="" style="display: flex; flex-direction: column;" target="_blank">
                <div type="text"><span
                    class="show-text">{{ $name[0] }}</span>
                </div>
            </div>
        </div>
    </td>
    @endif
    @if (isset($name[1]))
    <td class="" style="text-align: center;" >
        <div class="next-table-cell-wrapper">
            <div class="" style="display: flex; flex-direction: column;" target="_blank">
                <div type="text"><span
                    class="show-text">{{ $name[1] }}</span>
                </div>
            </div>
        </div>
    </td>
    @endif
    <td class="" style="text-align: center;">
        <div class="next-table-cell-wrapper">
            <div class="form-group m-0">
                <input type="number" required="" name="price[]" autocomplete="off" value="2500" height="100%" class="form-control variant_inputs">
            </div>
        </div>
    </td>
    <td class="" style="text-align: center;">
        <div class="next-table-cell-wrapper">
            <div class="form-group m-0">
                <input type="number" name="special_price[]" autocomplete="off" value="2500" height="100%" class="form-control">
            </div>
        </div>
    </td>
    <td class="" style="text-align: center;">
        <div class="next-table-cell-wrapper">
            <div class="form-group m-0">
                <input type="number" name="installment_price[]" autocomplete="off" value="2500" height="100%" class="form-control">
            </div>
        </div>
    </td>
    <td class="" style="text-align: center;">
        <div class="next-table-cell-wrapper">
            <div class="form-group m-0">
                <input type="number" name="wholesale_price[]" autocomplete="off" value="2500" height="100%" class="form-control">
            </div>
        </div>
    </td>
    <td class="" style="text-align: center;" >
        <div class="next-table-cell-wrapper">
            <input type="text" name="barcode[]" autocomplete="off" value="54f5sd4f5sd4f" height="100%" class="form-control">
        </div>
    </td>
    <td class="next-table-cell sku-row-action" style="text-align: center;">
        <div class="next-table-cell-wrapper">
            <div class="sku-delete"><i class="la la-trash"></i></div>
        </div>
    </td>
</tr>
