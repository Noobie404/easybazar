@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
@endpush('custom_css')
@section('Delivery boy','open')
@section('delivery_boy','active')
@section('title') Delivery boy dashboard @endsection
@section('page-name') Delivery boy @endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('product.breadcrumb_title')  </a></li>
<li class="breadcrumb-item active">Delivery boy</li>
@endsection
<?php
    $roles = userRolePermissionArray();
    $variant_id = request('variant_id') ?? null;
    $type = request('type') ?? null;
?>
@section('content')
            <div class="content-body">
                <div class="row">
                    <div id="recent-transactions" class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Recent deliveries</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table id="recent-orders" class="table table-hover table-xl mb-0">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Status</th>
                                                <th class="border-top-0">order#</th>
                                                <th class="border-top-0">Customer Name</th>
                                                <th class="border-top-0">Products</th>
                                                <th class="border-top-0">Shipping</th>
                                                <th class="border-top-0">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-truncate"><i class="la la-dot-circle-o success font-medium-1 mr-1"></i> Delivered</td>
                                                <td class="text-truncate"><a href="#">ORD-001001</a></td>
                                                <td class="text-truncate">
                                                    <span>Elizabeth W.</span>
                                                </td>
                                                <td class="text-truncate p-1">
                                                    iPhone
                                                </td>
                                                <td>
                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                        <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-truncate">&#2547; 1200.00</td>
                                            </tr>
                                            <tr>
                                                <td class="text-truncate"><i class="la la-dot-circle-o danger font-medium-1 mr-1"></i> Canceled</td>
                                                <td class="text-truncate"><a href="#">ORD-001002</a></td>
                                                <td class="text-truncate">
                                                    <span>Doris R.</span>
                                                </td>
                                                <td class="text-truncate p-1">
                                                    OnePlus
                                                </td>
                                                <td>
                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                        <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-truncate">&#2547; 1850.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="addressModalLabel">Customer Address</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
                 </button>
              </div>
              <div class="modal-body" id="addressModalBody">
              </div>
           </div>
        </div>
    </div>
@push('custom_js')
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script type="text/javascript">
</script>
@endpush('custom_js')
@endsection
