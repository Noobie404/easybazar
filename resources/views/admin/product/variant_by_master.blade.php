<?php
$rows = $data['rows'] ?? [];

?>
<table class="table table-striped table-bordered table-sm" id="process_data_table">
    <thead>
        <tr>
            <th>@lang('tablehead.name')</th>
            <th class="text-center">@lang('tablehead.image')</th>
            <th style="width: 120px;" class="text-center" >@lang('tablehead.action')</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($rows) && count($rows) > 0)
        @foreach($rows as $key=>$row)
            <?php
            $checked = '';
            if($row->PRD_SHOP_VARIANT_MAP_NO){
                $checked = 1;
            }

            ?>

            <tr>
                <td>{{$row->VARIANT_NAME}}</td>
                <td>
                    @if(!empty($row->THUMB_PATH))
                    <img style="width: 50px !important; height: 50px;" data-src="{{ fileExit($row->THUMB_PATH)}}" alt="{{ $row->DEFAULT_NAME ?? ''}}" src="{{fileExit($row->THUMB_PATH)}}" class="unveil">
                    @endif
                </td>
                <td>
                @if(!empty($data['master_map']))
                <div class="custom-control custom-switch custom-switch-md d-inline">
                    <input type="checkbox" data-id="{{$row->PK_NO}}" shop-id="{{$data['shop_id']}}" class="custom-control-input variant-status" id="custom_{{$row->PK_NO}}" @if($checked=='1') checked @endif name="variant-status">
                    <label class="custom-control-label" for="custom_{{$row->PK_NO}}"></label>
                </div>
                @else

                <span><i class="la la-sad-cry"></i> Pls. Add product master</span>
                @endif
                </td>

            </tr>
            @endforeach
            @endif
        </tbody>
</table>

<script>

</script>
