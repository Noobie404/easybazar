<div class="props-sku">
    <div class="props-sku-table">
        <div class="next-table only-bottom-border next-table-lock">
            <div class="next-table-inner">
                <div class="next-table-header">
                    <div class="next-table-header-inner">
                        <table class="table table-hover">
                            <colgroup>
                                <col style="width: 80px;">
                                @foreach ($featurenames as $item)
                                <col style="width: 120px;">
                                @endforeach
                                <col style="width: 120px;">
                                <col style="width: 120px;">
                                <col style="width: 120px;">
                                <col style="width: 120px;">
                                <col style="width: 180px;">
                                <col style="width: 40px;">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th rowspan="1" type="header" class=""
                                        style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">Availability</div>
                                    </th>
                                    <?php $family_count = 0; ?>
                                    @foreach ($featurenames as $item)
                                    <?php $family_count++; ?>
                                    <th rowspan="1" type="header" class=""
                                        style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">{{ $item }}</div>
                                    </th>
                                    @endforeach
                                    <th rowspan="1" type="header" class=""
                                        style="text-align: center;" >
                                        <div class="next-table-cell-wrapper"><span class="label">Regular Price<span
                                                    class="label-required"></span></span></div>
                                    </th>
                                    <th rowspan="1" type="header" class=""
                                        style="text-align: center;" >
                                        <div class="next-table-cell-wrapper"><span class="label">Special Price</span></div>
                                    </th>
                                    <th rowspan="1" type="header" class=""
                                        style="text-align: center;" >
                                        <div class="next-table-cell-wrapper"><span class="label">Installment Price</span></div>
                                    </th>
                                    <th rowspan="1" type="header" class=""
                                        style="text-align: center;" >
                                        <div class="next-table-cell-wrapper"><span class="label">Wholesale Price</span></div>
                                    </th>
                                    <th rowspan="1" type="header" class=""
                                        style="text-align: center;" >
                                        <div class="next-table-cell-wrapper"><span class="label">Barcode</span></div>
                                    </th>
                                    <th rowspan="1" type="header"
                                        class=" sku-row-action"
                                        style="text-align: center;" >
                                        <div class="next-table-cell-wrapper"><span class="label">Action</span></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($variants))
                                @foreach ($variants as $variant)
                                <tr class="next-table-row first disable" role="row">
                                    <td class="next-table-cell first" style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="checkbox" name="is_active_variant[]" value="1" class="custom-control-input variant_inputs" id="variantcustomSwitch{{ $variant->PK_NO }}" @if($variant->IS_ACTIVE == 1) checked @endif disabled>
                                                <label class="custom-control-label" for="variantcustomSwitch{{ $variant->PK_NO }}"></label>
                                            </div>
                                        </div>
                                    </td>
                                    @if (isset($variant->COLOR_NAME) || $family_count == 2)
                                    <td class="" style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">
                                            <div class="" style="display: flex; flex-direction: column;" target="_blank">
                                                <div type="text"><span
                                                    class="show-text">{{ $variant->COLOR_NAME ?? null }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                    @if (isset($variant->SIZE_NAME) || $family_count == 2)
                                    <td class="asdadadasd" style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">
                                            <div class="" style="display: flex; flex-direction: column;" target="_blank">
                                                <div type="text"><span
                                                    class="show-text">{{ $variant->SIZE_NAME ?? null }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                    <td class="" style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">
                                            <div class="form-group m-0">
                                                <input type="number" data-validation-required-message="This fiel is required" required="" name="price[]" autocomplete="off" height="100%" class="form-control variant_inputs" disabled value="{{ $variant->REGULAR_PRICE }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="" style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">
                                            <div class="form-group m-0">
                                                <input type="number" name="special_price[]" autocomplete="off" height="100%" class="form-control" disabled value="{{ $variant->SPECIAL_PRICE }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="" style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">
                                            <div class="form-group m-0">
                                                <input type="number" name="installment_price[]" autocomplete="off" height="100%" class="form-control" disabled value="{{ $variant->INSTALLMENT_PRICE }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="" style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">
                                            <div class="form-group m-0">
                                                <input type="number" name="wholesale_price[]" autocomplete="off" height="100%" class="form-control" disabled value="{{ $variant->WHOLESALE_PRICE }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="" style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">
                                            <input type="text" name="barcode[]" autocomplete="off" height="100%" class="form-control" value="{{ $variant->BARCODE }}" disabled>
                                        </div>
                                    </td>
                                    <td class="next-table-cell sku-row-action" style="text-align: center;">
                                        <div class="next-table-cell-wrapper">
                                            <div class="sku-delete"><i class="la la-trash"></i></div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr class="next-table-row first" role="row" id="variant_gemerated_forst_row">
                                    <td class="next-table-cell first" style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">
                                            <div class="custom-control custom-switch custom-switch-lg">
                                                <input type="checkbox" name="is_active_variant[]" value="1" class="custom-control-input variant_inputs" id="variantcustomSwitch" checked>
                                                <label class="custom-control-label" for="variantcustomSwitch"></label>
                                            </div>
                                        </div>
                                    </td>
                                    @foreach ($featurenames as $item)
                                    <td class="" style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">
                                            <div class="" style="display: flex; flex-direction: column;" target="_blank">
                                                <div type="text"><span
                                                    class="show-text"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    @endforeach
                                    <td class="" style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">
                                            <div class="form-group m-0">
                                                <input type="number" data-validation-required-message="This fiel is required" required="" name="price[]" autocomplete="off" value="" height="100%" class="form-control variant_inputs">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="" style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">
                                            <div class="form-group m-0">
                                                <input type="number" name="special_price[]" autocomplete="off" value="" height="100%" class="form-control">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="" style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">
                                            <div class="form-group m-0">
                                                <input type="number" name="installment_price[]" autocomplete="off" value="" height="100%" class="form-control">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="" style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">
                                            <div class="form-group m-0">
                                                <input type="number" name="wholesale_price[]" autocomplete="off" value="" height="100%" class="form-control">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="" style="text-align: center;" >
                                        <div class="next-table-cell-wrapper">
                                            <input type="text" name="barcode[]" autocomplete="off" value="" height="100%" class="form-control">
                                        </div>
                                    </td>
                                    <td class="next-table-cell sku-row-action" style="text-align: center;">
                                        <div class="next-table-cell-wrapper">
                                            <div class="sku-delete"><i class="la la-trash"></i></div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
