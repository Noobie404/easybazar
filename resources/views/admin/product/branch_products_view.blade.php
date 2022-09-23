<?php
$roles = userRolePermissionArray();
$rows = $rows ?? [];
$selected = $selected ?? [];
?>
<table class="table table-striped table-bordered table-sm" id="process_data_table">
         <thead>
            <tr>
              <th class="text-center">
                @if(hasAccessAbility('product_assigned_to_shop', $roles))
                    <label for="select-all"><input type="checkbox" id="select-all"> Select all </label>
                    @else
                    SL
                @endif
                </th>
                <th>@lang('tablehead.category')</th>
                <th>@lang('tablehead.name')</th>
                <th class="text-center">@lang('tablehead.image')</th>
                <th class="text-center">Total Variants</th>
                <th class="text-center" >@lang('tablehead.action')</th>
            </tr>
         </thead>
        <tbody>
            @if(!empty($rows) && count($rows) > 0)
            @foreach($rows as $key=>$row)
            <?php
             $checked ='';
            ?>
            @foreach($selected as $select)
            <?php
            if($row->PK_NO == $select->F_PRD_MASTER_SETUP_NO ) {
                if($select->IS_ACTIVE == 0){
                    $checked ='2';
                }
                else{
                    $checked ='1';
                }
            }
            ?>
            @endforeach
            <tr>
                <td class="text-center">
                    <input class="checkSingle" type="checkbox" name="master_id[]" value="{{$row->PK_NO}}" @if($checked) checked @endif id="master_id{{$row->PK_NO}}">
                </td>
                <td>{{ getCategoryChain($row->PK_NO) }}</td>
                <td>{{$row->DEFAULT_NAME}}</td>
                <td>
                    <?php
                        $product = DB::table('PRD_VARIANT_SETUP')->where('F_PRD_MASTER_SETUP_NO',$row->PK_NO)->first();
                ?>
                @if(!empty($product->THUMB_PATH))
                <a href="{{fileExit($product->THUMB_PATH)}}" target="_blank"><img src="{{fileExit($product->THUMB_PATH)}}" class="img-fluid img-sm"></a>
                @endif
                </td>
                <td class="text-center">
                    <a href="#" data-id="{{$row->PK_NO}}" class="d-inline open-modal">
                        {{$row->TOTAL_VARIANT}}
                    </a>
                </td>
                <td>
                <a href="#" data-id="{{$row->PK_NO}}" class="d-inline open-modal"><i class="la la-tasks"></i></a>
                @if(!empty($checked))
                {{-- <div class="custom-control custom-switch custom-switch-md d-inline">
                    <input type="checkbox" data-id="{{$row->PK_NO}}" class="custom-control-input status" id="customSwitch_{{$row->PK_NO}}" @if($checked=='1') checked @endif>
                    <label class="custom-control-label" for="customSwitch_{{$row->PK_NO}}"></label>
                </div> --}}
                @endif
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
</table>

<script>
$(document).ready(function() {
    $("#select-all").change(function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle").each(function() {
                this.checked=false;
            });
        }
    });
    $(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;
            $(".checkSingle").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });
            if (isAllChecked == 0) {
                $("#select-all").prop("checked", true);
            }
        }
        else {
            $("#select-all").prop("checked", false);
        }
    });
});
</script>

