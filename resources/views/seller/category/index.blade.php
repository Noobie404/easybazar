@extends('seller.layout.master')
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
@endphp
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">

<style>
    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    vertical-align: top!important;
}
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
            <div class="heading-elements">
              <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                <li><a data-action="close"><i class="ft-x"></i></a></li>
              </ul>
            </div>
          </div>
          <div class="card-content collapse show">
            <div class="card-body card-dashboard">
              <div class="table-responsive p-1">
                <table class="table table-bordered alt-pagination50" id="indextable">
                  <thead>
                    <tr>
                        <th style="width: 50px;">Sl.</th>
                        <th style="width: 20px;">Order ID</th>
                        <th style="width: 120px;">Category name</th>
                        <th>Subcategory</th>
                        <th>Meta title</th>
                        <th style="width: 150px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($rows as $key=>$row)
                    <tr>
                        <td style="width: 50px;">{{ $loop->index + 1 }}</td>
                        <td style="width: 20px;">{{ $row->ORDER_ID }}</td>
                        <td style="width: 120px;">{{ $row->NAME }}<br> <span class="bn">({{ $row->BN_NAME }})</span></td>
                        <td>
                            <div id="accordionWrap{{ $key }}">
                                <div class="card accordion-card accordion collapse-icon accordion-icon-rotate">
                                @if($row->subcategories && $row->subcategories->count() > 0 )
                                @foreach($row->subcategories as $key2 => $scat)
                                <?php
                                $scat_subsubcat = $scat->subsubcategory->count();
                                ?>
                                    <div id="" class="card-header info subcat-accordion collapsed" data-toggle={{ $scat_subsubcat > 0 ? 'collapse' : '' }} href="#accordion2nd{{ $scat->SUBCATEGORY_ID }}" aria-expanded="false" data-parent="#accordionWrap{{ $key }}">
                                        <i class="la la-arrow-right"></i> {{$scat->SUBCATEGORY_NAME}}(<small class="bn"> {{ $scat->BN_NAME }}</small>) ({{ $scat_subsubcat }})
                                        <div class="category-btn-group">
                                            @if(hasAccessAbility('edit_sub_category', $roles))
                                            <a href="{{ route('product.category.edit', [$scat->SUBCATEGORY_ID]) }}" class="category-btn" title="EDIT SUBCATEGORY"><i class="la la-edit"></i></a>
                                            @endif
                                            @if(hasAccessAbility('delete_sub_category', $roles))
                                                <a href="{{ route('product.category.delete', [$scat->SUBCATEGORY_ID]) }}" class="category-btn" title="DELETE SUBCATEGORY" onclick="return confirm('Are you sure you want to delete?')"><i class="la la-trash"></i>
                                                    </a>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($scat_subsubcat > 0)
                                    <div id="accordion2nd{{ $scat->SUBCATEGORY_ID }}" class="collapse" data-parent="#accordionWrap{{ $key }}">
                                        <div class="card-content">
                                            <div class="card-body">
                                                @if(!empty($scat->subsubcategory))
                                                    @foreach ($scat->subsubcategory as $key3 => $subsubcategory)
                                                    @php
                                                    $subsubcat_count = $subsubcategory->subsubcategory2->count();
                                                    @endphp
                                                    <div class="card accordion-card accordion collapse-icon accordion-icon-rotate">
                                                        <div id="" class="card-header info subcat-accordion collapsed" data-toggle={{ $subsubcat_count > 0 ? 'collapse' : '' }} href="#accordion3rd{{ $subsubcategory->SUBCATEGORY_ID }}" aria-expanded="false">
                                                            <i class="la la-arrow-right"></i> {{$subsubcategory->SUBSUBCATEGORY_NAME}} (<small class="bn"> {{ $subsubcategory->BN_NAME }}</small>) ({{ $subsubcat_count }})
                                                            <div class="category-btn-group">
                                                                @if(hasAccessAbility('edit_sub_category', $roles))
                                                                <a href="{{ route('product.category.edit', [$subsubcategory->SUBCATEGORY_ID]) }}" class="category-btn" title="EDIT SUBCATEGORY"><i class="la la-edit"></i></a>
                                                                @endif
                                                                @if(hasAccessAbility('delete_sub_category', $roles))
                                                                    <a href="{{ route('product.category.delete', [$subsubcategory->SUBCATEGORY_ID]) }}" class="category-btn" title="DELETE SUBCATEGORY" onclick="return confirm('Are you sure you want to delete?')"><i class="la la-trash"></i>
                                                                        </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        @if ($subsubcat_count > 0)
                                                        <div id="accordion3rd{{ $subsubcategory->SUBCATEGORY_ID }}" data-parent="#accordion2nd{{ $scat->SUBCATEGORY_ID }}" class="collapse">
                                                            <div class="card-content" aria-labelledby="heading{{ $row->PK_NO }}">
                                                                <div class="card-body">
                                                                    <ul class="list-unstyled">
                                                                        @if(!empty($subsubcategory->subsubcategory2))
                                                                        @foreach ($subsubcategory->subsubcategory2 as $subsubcategory)
                                                                        <li><a style="color: #555;" href="{{ route('product.category.edit', [$subsubcategory->SUBCATEGORY_ID2]) }}"><small><i class="la la-angle-right"></i></small> {{ $subsubcategory->SUBSUBCATEGORY_NAME2}} (<small class="bn"> {{ $subsubcategory->BN_NAME }}</small>)</a>
                                                                        </li>
                                                                        @endforeach
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
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
                        <td>
                           {{ $row->META_TITLE   }}
                        </td>
                        <td style="width:10%">
                            @if(hasAccessAbility('edit_category', $roles))
                            <a href="{{ route('product.category.edit', [$row->PK_NO]) }}" title="EDIT" class="btn btn-xs btn-info  mb-1"><i class="la la-edit"></i></a>
                            @endif
                            @if(hasAccessAbility('delete_category', $roles))
                            <a href="{{ route('product.category.delete', [$row->PK_NO]) }}" onclick="return confirm('Are you sure you want to delete product category?')" title="DELETE" class="btn btn-xs btn-danger mb-1"><i class="la la-trash"></i></a>
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
@include('admin.category._subcategory_add_edit_modal')
@endsection
@push('custom_js')
<script type="text/javascript" src="{{ asset('assets/pages/category.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
@endpush('custom_js')
