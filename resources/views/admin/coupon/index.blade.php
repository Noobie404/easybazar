@extends('admin.layout.master')
@section('coupon_discount','active')
@section('title')
    Coupon list
@endsection
@section('page-name')
    Coupon list
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('form.dashboard')</a>
    </li>
    <li class="breadcrumb-item active">Coupon list
    </li>
@endsection
@php
    $roles = userRolePermissionArray();
@endphp
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush

@push('custom_js')
<!-- BEGIN: Data Table-->
<script src="{{asset('/assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('/assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<!-- END: Data Table-->
@endpush
@section('content')
    <!-- Alternative pagination table -->
    <div class="content-body min-height">
        <section id="pagination">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                    <div class="form-group">
                    @if(hasAccessAbility('new_coupon', $roles))
                        <a href="{{ route('admin.coupon.create') }}" class="btn btn-sm btn-primary " href="" title="Add new primary list"> <i class="ft-plus text-white"></i> Add new coupon</a>
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
                  <div class="card-body card-dashboard ">
                    <div class="table-responsive p-1">
                      <table class="table table-striped table-bordered alt-pagination table-sm" id="indextable">
                        <thead>
                          <tr>
                            <th style="width: 5%;">Sl.</th>
                            <th class="text-left">Shop</th>
                            <th class="text-left" style="width: 20%;">Coupon</th>
                            <th class="text-left" style="width: 20%;">Discount</th>
                            <th class="text-left" >Coupon On</th>
                            <th class="text-left" >Validity From</th>
                            <th class="text-left" >Validity To</th>
                            <th class="text-left" >Status</th>
                            <th class="text-center" style="width: 10%;">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if($rows && (count($rows)> 0) )
                            @foreach($rows as $key => $row)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $row->SHOP_NAME }}</td>
                                <td>{{ $row->COUPON_CODE }}</td>
                                <td> {{ $row->DISCOUNT }}{{ $row->COUPON_TYPE == 1 ? '%' : ' TK' }}</td>
                                <td>
                                  @if($row->COUPON_ON == 1)
                                  Product
                                  @elseif($row->COUPON_ON == 2)
                                  Master
                                  @else 
                                  Flat discount
                                  @endif
                                </td>
                                <td> {{ date('d-m-Y',strtotime($row->VALIDITY_FROM)) }}</td>
                                <td> {{ date('d-m-Y',strtotime($row->VALIDITY_TO)) }}</td>
                                <td> {{ $row->IS_ACTIVE == 1 ? 'Active' : 'Disable' }}</td>
                                <td class="text-center" style="width:100px;">
                                    @if(hasAccessAbility('edit_coupon', $roles))
                                    <a href="{{ route('admin.coupon.edit', [$row->PK_NO]) }}" class="btn btn-xs btn-info" title="EDIT"><i class="la la-edit"></i></a>
                                    @endif
                                    @if(hasAccessAbility('view_coupon_list', $roles))
                                    <a href="{{ route('admin.coupon.view', [$row->PK_NO]) }}" class="btn btn-xs btn-primary" title="VIEW"><i class="la la-eye"></i></a>
                                    @endif
                                    @if(hasAccessAbility('delete_coupon', $roles))
                                    <a href="{{ route('admin.coupon.delete', [$row->PK_NO]) }}" class="btn btn-xs btn-danger" title="DELETE" onclick="return confirm('Are you sure you want to delete ?')"><i class="la la-trash"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="8"></td>
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
                  </section>
                </div>
    <!--/ Alternative pagination table -->
@endsection
@push('custom_js')

<!--script only for brand page-->
<script type="text/javascript" src="{{ asset('assets/pages/account.js')}}"></script>


@endpush('custom_js')
