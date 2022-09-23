@extends('admin.layout.master')
@push('custom_css')
<link rel="stylesheet" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/charts/morris.css') }}"> --}}
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/charts/chartist.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/charts/chartist-plugin-tooltip.css') }}">
<style>
    circle.ct-area-circle {
    fill: #28d094;
    stroke-width: 5;
    stroke: #fff;
}
</style>
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
    $active_tab = request('tab') ?? 1;
    $variant_id = request('variant_id') ?? null;
    $type = request('type') ?? null;
    $balance = 0;
    $html = array();
    $balance     = 0;
?>
@section('content')
            <div class="content-body">
                <!-- eCommerce statistic -->
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                   <a href="{{ route('admin.delivery_boy.delivery_list',
                                      [
                                       'dboy_id' => $row->PK_NO,
                                       'type'=>'complete'
                                       ]) }}">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="info">850</h3>
                                            <h6>Complete Delivery</h6>
                                        </div>
                                        <div>
                                            <i class="la la-shopping-basket info font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                   </a>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <a href="">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="warning">&#2547; 748</h3>
                                            <h6>Total Collection</h6>
                                        </div>
                                        <div>
                                            <i class="icon-pie-chart warning font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                    </a>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <a href="">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="success">146</h3>
                                            <h6>Assign Delivery</h6>
                                        </div>
                                        <div>
                                            <i class="la la-chart-pie"></i>
                                            <i class="icon-user-follow success font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                    </a>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <a href="">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="danger">12</h3>
                                            <h6>Pending Delivery</h6>
                                        </div>
                                        <div>
                                            <i class="icon-heart danger font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                    </a>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ eCommerce statistic -->

                <!-- Products sell and New Orders -->
                <div class="row match-height">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Delivery boy information</h4>
                            </div>
                            <div class="card-body card-content text-center">
                                        @if(!empty($row->PROFILE_PIC_URL))
                                        <p><img src="{{ asset($row->PROFILE_PIC_URL) }}" class="img-fluid rounded-circle" width="100px" alt="{{ $row->NAME }}" title="{{ $row->NAME }}"/></p>
                                        @endif
                                        <h6><strong><i class="la la-user"></i> Name :</strong>{{ $row->NAME }}</h6>
                                        <h6><i class="la la-mobile"></i>Phone :+88{{ $row->MOBILE_NO }}</h6>
                                        @if($row->ALTERNATE_NO)
                                        <h6><strong>Alternative Phone:</strong> {{ $row->ALTERNATE_NO }}</h6>
                                        @endif
                                        <h6><strong><i class="la la-envelope"></i> Email:</strong>{{ $row->EMAIL }}</h6>
                                        @if($row->BIRTH_DATE)
                                        <h6><strong><i class="la la-birthday-cake"></i> Birth date:</strong>{{ $row->BIRTH_DATE }}</h6>
                                        @endif
                                        @if($row->GENDER)
                                        <h6><strong> <i class="la la-universal-access"></i> Gender:</strong> @if($row->GENDER==1) {{ 'Male' }} @else {{ 'Female' }} @endif</h6>
                                        @endif
                                        @if($row->ADDRESS1)
                                        <h6><span><strong><i class="la la-location-arrow"></i> Address :</strong>{{ $row->ADDRESS1 }}</span></h6>
                                        @endif
                                        @if($row->ADDRESS2)
                                        <h6>{{ $row->ADDRESS2 }}</h6>
                                        @endif
                                        <div>
                                            <strong><i class="la la-map-marker"></i> Assign Area :</strong>
                                            <span>{{ $row->AREA_NAME }}</span>,
                                            <span>{{ $row->CITY_NAME }} </span>,
                                            <span>{{ $row->STATE_NAME }}</span>
                                            <span>{{ $row->COUNTRY }}</span>
                                        </div>


                                        <strong> Log:</strong>
                                        @if($row->PLATFORM)
                                        <span> Platform:{{ $row->PLATFORM }}</span>,
                                        @endif
                                        @if($row->IP_ADDRESS)
                                        <span> ip:{{ $row->IP_ADDRESS }}</span>,
                                        @endif
                                        @if($row->BROWSER)
                                        <span>Browser: {{ $row->BROWSER }}</span>
                                        @endif

                                        {{-- <a href="#" class="btn btn-xs edit-customer" data-id="{{ $row->PK_NO }}" title="Edit Customer"><i class="la la-edit"></i> Edit</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Latest Delivery</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div id="new-orders" class="media-list position-relative">
                                    <div class="table-responsive">
                                        <table id="new-orders-table" class="table table-hover table-xl mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="border-top-0">Order no</th>
                                                    <th class="border-top-0">Product</th>
                                                    <th class="border-top-0">Customer</th>
                                                    <th>Status</th>
                                                    <th class="border-top-0">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><a href="">#202524555</a></td>
                                                    <td class="text-truncate">iPhone X</td>
                                                    <td class="text-truncate p-1">Abdullah</td>
                                                    <td><span class="badge badge-success">Delivered</span></td>
                                                    <td class="text-truncate">&#2547;8999</td>
                                                </tr>
                                                <tr>
                                                    <td><a href="">#202524555</a></td>
                                                    <td class="text-truncate">Pixel 2</td>
                                                    <td class="text-truncate p-1">Abdul Alim</td>
                                                    <td><span class="badge badge-danger">Canceled</span></td>

                                                    <td class="text-truncate">&#2547;5550</td>
                                                </tr>
                                                <tr>
                                                    <td><a href="">#202524555</a></td>
                                                    <td class="text-truncate">OnePlus</td>
                                                    <td class="text-truncate p-1">Abu Bakar</td>
                                                    <td><span class="badge badge-info">On The Ways</span></td>
                                                    <td class="text-truncate">&#2547;9000</td>
                                                </tr>
                                                <tr>
                                                    <td><a href="">#202524555</a></td>
                                                    <td class="text-truncate">Galaxy</td>
                                                    <td class="text-truncate p-1">Jasim uddin</td>
                                                    <td><span class="badge badge-primary">Pending</span></td>
                                                    <td class="text-truncate">&#2547;7500</td>
                                                </tr>
                                                <tr>
                                                    <td><a href="">#202524555</a></td>
                                                    <td class="text-truncate">Moto Z2</td>
                                                    <td class="text-truncate p-1">Morshed Alam</td>
                                                    <td><span class="badge badge-danger">Canceled</span></td>
                                                    <td class="text-truncate">&#2547;8500</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Products sell and New Orders -->

                <!-- Recent Transactions -->
                <div class="row">
                    <div id="recent-transactions" class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Recent Transactions</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table id="recent-orders" class="table table-hover table-xl mb-0">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Status</th>
                                                <th class="border-top-0">Invoice#</th>
                                                <th class="border-top-0">Customer Name</th>
                                                <th class="border-top-0">Products</th>
                                                <th class="border-top-0">Shipping</th>
                                                <th class="border-top-0">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-truncate"><i class="la la-dot-circle-o success font-medium-1 mr-1"></i> Paid</td>
                                                <td class="text-truncate"><a href="#">INV-001001</a></td>
                                                <td class="text-truncate">
                                                    <span>Elizabeth W.</span>
                                                </td>
                                                <td class="text-truncate p-1">
                                                </td>
                                                <td>
                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                        <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </td>
                                                <td class="text-truncate">&#2547; 1200.00</td>
                                            </tr>
                                            <tr>
                                                <td class="text-truncate"><i class="la la-dot-circle-o danger font-medium-1 mr-1"></i> Declined</td>
                                                <td class="text-truncate"><a href="#">INV-001002</a></td>
                                                <td class="text-truncate">
                                                    <span>Doris R.</span>
                                                </td>
                                                <td class="text-truncate p-1">
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
                <!--/ Recent Transactions -->

                <!--Recent Orders & Monthly Sales -->
                <div class="row match-height">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-content ">
                                <div id="cost-revenue" class="height-250 position-relative"></div>
                            </div>
                            <div class="card-footer">
                                <div class="row mt-1">
                                    <div class="col-3 text-center">
                                        <h6 class="text-muted">Total Deliveries</h6>
                                        <h2 class="block font-weight-normal">18.6 k</h2>
                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-3 text-center">
                                        <h6 class="text-muted">Total Pending</h6>
                                        <h2 class="block font-weight-normal">64.54 M</h2>
                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-3 text-center">
                                        <h6 class="text-muted">Total Canceled</h6>
                                        <h2 class="block font-weight-normal">24.38 B</h2>
                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-3 text-center">
                                        <h6 class="text-muted">Total Collection</h6>
                                        <h2 class="block font-weight-normal">36.72 M</h2>
                                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
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
<script type="text/javascript" src="{{ asset('assets/pages/address.js')}}"></script>
<script src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
<script src="{{ asset('assets/vendors/js/charts/chartist.min.js')}}"></script>
<script src="{{ asset('assets/vendors/js/charts/chartist-plugin-tooltip.min.js')}}"></script>
{{-- <script src="{{ asset('assets/vendors/js/charts/raphael-min.js')}}"></script> --}}
{{-- <script src="{{ asset('assets/vendors/js/charts/morris.min.js')}}"></script> --}}
{{-- <script src="{{ asset('assets/vendors/js/vendors.min.js')}}"></script> --}}
<script src="{{ asset('assets/js/scripts/pages/dashboard-ecommerce.js')}}"></script>


<script type="text/javascript">
$(document).on('click', '.open-modal', function () {
        var get_url = $('#base_url').val();
        $.ajax({
            type: 'get',
            url: get_url + '/ajax/address/create/'+{{ $row->PK_NO }},
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    $('#addressModalBody').empty();
                    $('#addressModal').modal('show');
                    $('#addressModalBody').append(response.data);
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })

    $(document).on("click", ".edit-row", function (e) {
            e.preventDefault();
            var address_id = $(this).data('id');
            var get_url = $('#base_url').val();
            $.ajax({
                type: 'GET',
                url: get_url + '/ajax/address/edit/'+address_id,
                success: function (response) {
                    if (response.status == 1) {
                        $('#addressModalBody').empty();
                        $('#addressModal').modal('show');
                        $('#addressModalBody').append(response.data);
                    }
                },
                error: function (jqXHR, exception) {
                    toastr.error('Something wrong');
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            });
        });
        $(document).on('submit', "#addressForm", function (e) {
        e.preventDefault();
        var form = $("#addressForm");
        $.ajax({
            type: 'post',
            data: form.serialize(),
            url: form.attr('action'),
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    toastr.success(response.message);
                    $('#appendRow').append(response.data);
                    $('#addressForm')[0].reset();
                    $('#addressModal').modal('hide');
                    $('.address').hide();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (jqXHR, exception) {
                toastr.error('something wrong');
            },
            complete: function (response) {
                $("body").css("cursor", "default");
            }
        });
    });

        $(document).on('submit', "#addressUpdate", function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var form = $("#addressUpdate");
            $.ajax({
                type: 'post',
                data: formData,
                url: form.attr('action'),
                cache:false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (response) {
                    if (response.status == 1) {
                        $('.item' + response.data.address.PK_NO).replaceWith(response.data.html);
                        toastr.success(response.message);
                        $('#addressUpdate')[0].reset();
                        $('#addressModal').modal('hide');
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (jqXHR, exception) {
                    toastr.error('Something wrong');
                },
                complete: function (response) {
                    $("body").css("cursor", "default");
                }
            });
        });
        $(document).on("click", ".delete-row", function (e) {
            e.preventDefault();
            var address_id = $(this).data('id');
            var x = confirm("Are you sure you want to delete?");
            if (x) {
                $.ajax({
                    type: 'GET',
                    url: '{{URL("ajax/address/delete")}}' + "/" + address_id,
                    success: function (response) {
                        if (response.status == 1) {
                            $('.item' + address_id).remove();
                            toastr.success(response.message);
                        }
                    },
                    error: function (jqXHR, exception) {
                        toastr.error('Something wrong');
                    },
                    complete: function (data) {
                        $("body").css("cursor", "default");
                    }
                });
            }
        });
$(document).on("click", ".edit-customer", function (e) {
    e.preventDefault();
    var customer_id = $(this).data('id');
    var get_url = $('#base_url').val();
    $.ajax({
        type: 'GET',
        url: get_url + '/ajax/customer/edit/'+customer_id,
        success: function (response) {
            if (response.status == 1) {
                $('#addressModalBody').empty();
                $('#addressModalLabel').text('Customer update');
                $('#addressModal').modal('show');
                $('#addressModalBody').append(response.data);
            }
        },
        error: function (jqXHR, exception) {
            toastr.error('Something wrong');
        },
        complete: function (data) {
            $("body").css("cursor", "default");
        }
    });
});
$(document).on('submit', "#customerUpdate", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var form     = $("#customerUpdate");
        $.ajax({
                type: 'post',
                data: formData,
                url: form.attr('action'),
                cache:false,
                contentType: false,
                processData: false,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    toastr.success(response.message);
                    $('#customerUpdate')[0].reset();
                    $('#addressModal').modal('hide');
                    location.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (jqXHR, exception) {
                toastr.error('something wrong');
            },
            complete: function (response) {
                $("body").css("cursor", "default");
            }
        });
    });
</script>
@endpush('custom_js')
@endsection
