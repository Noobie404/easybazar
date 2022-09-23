@extends('admin.layout.master')
@section('Product Management','open')
@section('product category','active')
@section('title') Product category @endsection
@section('page-name') Product category @endsection
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
  <li class="breadcrumb-item active">Category</li>
@endsection
@php
    $roles = userRolePermissionArray();
    $shop_id = request()->get('shop');
@endphp
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<style>
    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th{
    vertical-align: top!important;}
    .collapse.show{
        color: #0e4099;
    }
    .collapse.show .category-btn{
        color: #0e4099;
    }
    .cat_check{transform: scale(1.8); margin: 5px;}
</style>
@endpush
@section('content')
<div class="content-body min-height">
  <section id="pagination">

    <div class="row">
      <div class="col-12">
        <div class="card card-sm card-success">
          <div class="card-header pl-2">
            <div class="form-group">
              @if(hasAccessAbility('new_category', $roles))
              <a class="text-white btn btn-sm btn-primary" href="{{ route('product.category.create')}}" title="Create new category"><i class="ft-plus text-white"></i> Create category</a>
              @endif
            </div>
            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
            @if(isset($shop) && !empty($shop))
            <div class="heading-elements">
                <h3> {{ $shop->SHOP_NAME }} </h3>
                <input type="hidden" value="{{ $shop->PK_NO }}" name="shop_id" id="shop_id" />
            </div>
            @endif

          </div>
          <div class="card-content">
            <div class="card-body card-dashboard">
              <div class="table-responsive p-1">
                <table class="table table-bordered alt-pagination50" id="indextable">
                  <thead>
                    <tr>
                        <th style="width: 50px;">Sl.</th>
                        <th>ICON</th>
                        <th style="width: 120px;">Category name</th>
                        <th>Subcategory</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($rows as $key=>$row)
                    <tr>
                        <td style="width: 50px;">{{ $loop->index + 1 }}</td>
                        <td style="width: 60px;">
                            <img src="{{fileExit($row->ICON)}}" class="img-fluid" style="height: 50px;">
                        </td>
                        <td style="width: 120px;" title="{{ $row->IS_ACTIVE == 0 ? 'Inactive category' : 'Active category' }}">
                            </span><div class="{{ $row->IS_ACTIVE == 0 ? 'text-danger' : '' }}" >{{ $row->NAME }}
                                <span class="bn">({{ $row->BN_NAME }})</span>
                                @if($row->TOTAL_VARIANT > 0)
                                        <span class="badge badge-success"> Product:{{ $row->TOTAL_VARIANT }}</span>
                                @endif

                                @if($row->ORDER_ID)
                                    <span class="badge badge-secondary">Priority: {{ $row->ORDER_ID }}</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div id="accordionWrap{{ $key }}">
                                <div class="card accordion-card">
                                @if($row->subcategories && $row->subcategories->count() > 0 )
                                @foreach($row->subcategories as $key2 => $scat)
                                <?php
                                $scat_subsubcat = $scat->subsubcategory->count();
                                ?>
                                    <div id="" class="card-header info subcat-accordion collapsed">
                                        <span style="cursor: pointer"  title="{{ $scat->IS_ACTIVE == 0 ? 'Inactive category' : 'Active category' }}"  class="{{ $scat->IS_ACTIVE == 0 ? 'text-danger' : '' }} accordion collapse-icon accordion-icon-rotate" data-toggle={{ $scat_subsubcat > 0 ? 'collapse' : '' }} href="#accordion2nd{{ $scat->SUBCATEGORY_ID }}" aria-expanded="false" data-parent="#accordionWrap{{ $key }}" ><i class="la la-arrow-right"></i>
                                            {{$scat->SUBCATEGORY_NAME}}(<small class="bn">{{ $scat->BN_NAME }}</small>)
                                            @if($scat_subsubcat > 0)
                                            <span class="badge badge-info">SC: {{ $scat_subsubcat }}</span>
                                            @endif
                                            @if($scat->TOTAL_VARIANT >0)
                                            <span class="badge badge-success"> Product:{{ $scat->TOTAL_VARIANT }}</span>
                                            @endif
                                            @if($scat->ORDER_ID)
                                                <span class="badge badge-secondary">Priority: {{ $scat->ORDER_ID }}</span>
                                            @endif
                                        <div class="category-btn-group">
                                            @if((Auth::user()->USER_TYPE == 0) || ($scat->SUB_CATEGORY_ORDER_ID ))
                                            @if(hasAccessAbility('edit_category', $roles))
                                            <a class="text-info" href="{{ route('product.category.edit', ['id' => $scat->SUBCATEGORY_ID,'shop'=>$shop_id]) }}" class="category-btn" title="EDIT SUBCATEGORY"><i class="la la-edit"></i></a>
                                            @endif
                                            @endif
                                            @if(hasAccessAbility('delete_category', $roles))
                                                <a class="text-danger" href="{{ route('product.category.delete', ['id' => $scat->SUBCATEGORY_ID,'shop'=>$shop_id]) }}" class="category-btn" title="DELETE SUBCATEGORY" onclick="return confirm('Are you sure you want to delete?')"><i class="la la-trash"></i>
                                                </a>
                                            @endif
                                            @if(hasAccessAbility('edit_category', $roles))
                                                @if(isset($shop) && !empty($shop))
                                                    <label><input type="checkbox" value="{{ $scat->SUBCATEGORY_ID }}" class="shop_cat_add_remove" @if($scat->SUB_CATEGORY_ORDER_ID) checked @endif /></label>
                                                @endif
                                            @endif
                                            @if(hasAccessAbility('new_category', $roles))
                                                <a class="text-success" class="category-btn" href="{{ route('product.category.create',['category' => $scat->SUBCATEGORY_ID ]) }}" ><i class="la la-plus"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($scat_subsubcat > 0)
                                    <div id="accordion2nd{{ $scat->SUBCATEGORY_ID }}" class="collapse" data-parent="#accordionWrap{{ $key }}">
                                        <div class="card-content">
                                            <div class="card-body">
                                                @if(!empty($scat->subsubcategory))
                                                    @foreach ($scat->subsubcategory as $key3 => $sscat)
                                                    <div class="card accordion-card ">
                                                        <div id="" class="card-header info subcat-accordion " ><span title="{{ $sscat->IS_ACTIVE == 0 ? 'Inactive category' : 'Active category' }}" class="{{ $sscat->IS_ACTIVE == 0 ? 'text-danger' : '' }}"><i class="la la-arrow-right"></i> {{$sscat->SUBSUBCATEGORY_NAME}} (<small class="bn"> {{ $sscat->BN_NAME }}</small>)
                                                            @if($sscat->TOTAL_VARIANT >0)
                                                                <span class="badge badge-success"> Product:{{ $sscat->TOTAL_VARIANT }}</span>
                                                            @endif</span>
                                                            @if($sscat->ORDER_ID)
                                                                <span class="badge badge-secondary">Priority: {{ $sscat->ORDER_ID }}</span>
                                                            @endif

                                                            <div class="category-btn-group">
                                                                @if((Auth::user()->USER_TYPE == 0) || ($sscat->SUB_SUB_CATEGORY_ORDER_ID))
                                                                @if(hasAccessAbility('edit_category', $roles))
                                                                <a class="text-info" href="{{ route('product.category.edit', ['id' => $sscat->SUBSUBCATEGORY_ID,'shop'=>$shop_id]) }}" class="category-btn" title="EDIT SUBCATEGORY"><i class="la la-edit"></i></a>
                                                                @endif
                                                                @endif
                                                                @if(hasAccessAbility('delete_category', $roles))
                                                                    <a class="text-danger" href="{{ route('product.category.delete', ['id' => $sscat->SUBSUBCATEGORY_ID,'shop'=>$shop_id]) }}" class="category-btn" title="DELETE SUBCATEGORY" onclick="return confirm('Are you sure you want to delete?')"><i class="la la-trash"></i>
                                                                        </a>
                                                                @endif
                                                                @if(hasAccessAbility('edit_category', $roles))
                                                                    @if(isset($shop) && !empty($shop))
                                                                        <label><input type="checkbox" value="{{ $sscat->SUBSUBCATEGORY_ID }}" class="shop_cat_add_remove" @if($sscat->SUB_SUB_CATEGORY_ORDER_ID) checked @endif /></label>
                                                                    @endif
                                                                @endif

                                                                {{-- @if(hasAccessAbility('new_category', $roles))
                                                                    <a class="category-btn" href="{{ route('product.category.create',['category' => $sscat->SUBSUBCATEGORY_ID ]) }}" ><i class="la la-plus"></i></a>
                                                                @endif --}}


                                                            </div>
                                                        </div>

                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach()
                                @endif
                                </div>
                            </div>
                        </td>
                        <td style="width:10%">
                            @if((Auth::user()->USER_TYPE == 0) || ($row->CATEGORY_ORDER_ID))
                                @if(hasAccessAbility('edit_category', $roles))
                                <a href="{{ route('product.category.edit', ['id'=>$row->PK_NO,'shop_id'=>$shop_id]) }}" title="EDIT" class="btn btn-xs btn-info  mb-1"><i class="la la-edit"></i></a>
                                @endif
                            @endif
                            @if(hasAccessAbility('delete_category', $roles))
                            <a href="{{ route('product.category.delete', ['id' => $row->PK_NO,'shop_id'=>$shop_id]) }}" onclick="return confirm('Are you sure you want to delete product category?')" title="DELETE" class="btn btn-xs btn-danger mb-1"><i class="la la-trash"></i></a>
                            @endif

                            @if(hasAccessAbility('new_category', $roles))
                            <a class="btn btn-xs btn-success mb-1 text-white" href="{{ route('product.category.create',['category' => $row->PK_NO ]) }}" ><i class="la la-plus"></i></a>
                            @endif

                            @if(hasAccessAbility('edit_category', $roles))
                                @if(isset($shop) && !empty($shop))
                                    <label><input type="checkbox" value="{{ $row->PK_NO }}" class="shop_cat_add_remove cat_check " @if($row->CATEGORY_ORDER_ID) checked @endif /></label>
                                @endif
                            @endif

                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection
@push('custom_js')
<script type="text/javascript" src="{{ asset('assets/pages/category.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>

<script>
$(".shop_cat_add_remove").on('change',function(){
    var shop_id =  $('#shop_id').val();
    var cat_id =  $(this).val();
    if(!$(this).is(':checked')){
        ShopCatAddRemove(shop_id,cat_id,'uncheckd');
    }else{
        ShopCatAddRemove(shop_id,cat_id,'checkd');
    }
});
$(document).on('click', '.accordion-icon-rotate', function(){
    // $(this).find("i.fa-plus").toggleClass(" fa-minus")
})
function ShopCatAddRemove(shop_id,cat_id,mode){
    var get_url = $('#base_url').val();
    $.ajax({
        type: 'get',
        url: get_url + '/shop_cat_add_remove/'+shop_id+'/'+cat_id+'/'+mode,
        async: true,
        beforeSend: function () {
            $("body").css("cursor", "progress");
        },
        success: function (response) {
            if (response.status == 1) {
                toastr.success(response.message);
            }
        },
        complete: function (data) {
            $("body").css("cursor", "default");
        }
    });

}

</script>

@endpush('custom_js')
