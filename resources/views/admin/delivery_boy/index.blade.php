@extends('admin.layout.master')
@section('Delivery Boy','open')
@section('d_boy','active')
@section('title') Delivery Boy @endsection
@section('page-name') Delivery Boy @endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Delivery Boy</li>
@endsection
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/selects/select2.min.css') }}">
@endpush
@php
    $roles = userRolePermissionArray();
@endphp
@section('content')
<div class="content-body min-height">
    <section id="pagination">
       <div class="row">
          <div class="col-12">
             <div class="card card-sm card-success">
                <div class="card-header pl-2">
                    @if(hasAccessAbility('new_address_type', $roles))
                    <button type="button" class="btn btn-primary open-modal">
                    <i class="ft-plus text-white"></i> Create new
                    </button>
                    @endif
                   <a class="heading-elements-toggle heading-elements-toggle-sm"><i class="la la-ellipsis-v font-medium-3"></i></a>
                   <div class="heading-elements heading-elements-sm">
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
                         <table class="table table-striped table-bordered alt-pagination50 table-sm" id="indextable">
                            <thead>
                               <tr>
                                  <th style="width: 50px;">Sl.</th>
                                  <th class="text-center">Photo</th>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Phone</th>
                                  <th>Status</th>
                                  <th>Coverage area</th>
                                  <th class="text-center">Action</th>
                               </tr>
                            </thead>
                            <tbody id="area-data">
                                @if(!empty($rows))
                                @foreach ($rows as $key=>$row)
                                <tr class="item{{$row->PK_NO}}">
                                    <td>{{ $key+1 }}</td>
                                    <td class="text-center">
                                    @if(!empty($row->PROFILE_PIC_URL))
                                        <img style="width: 50px !important; height: 50px;" data-src="{{ fileExit($row->PROFILE_PIC_URL)}}" alt="{{ $row->NAME ?? ''}}" src="{{$row->PROFILE_PIC_URL}}">
                                    @endif
                                    </td>
                                    <td>{{ $row->NAME }}</td>
                                    <td>{{ $row->EMAIL }}</td>
                                    <td>+88 {{ $row->MOBILE_NO }}</td>
                                    <td>{{ $row->IS_ACTIVE == 1 ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                    @if(!empty($row->area))
                                        @foreach ($row->area as $item)
                                            <p class="cov_{{ $item->PK_NO }}">
                                                <span>{{ $item->CITY_NAME }} | </span>
                                                <span>{{ $item->AREA_NAME }} | </span>
                                                <span class="badge item{{ $item->PK_NO }}">{{ $item->SUB_AREA_NAME }}
                                                <a href="javascript:void(0)" data-id="{{ $item->PK_NO }}" class="area-times delete_cv"><i class="la la-times" style="font-size: 10px;"></i>
                                                </a>
                                            </span></p>
                                        @endforeach

                                    @endif

                                    </td>
                                    <td class="text-center">
                                    @if(hasAccessAbility('edit_delivery_body', $roles))
                                     <a href="#" data-key="{{ $key+1 }}" data-id="{{ $row->PK_NO }}" class="btn btn-xs btn-primary mr-1 edit-row" title="EDIT"><i class="la la-edit"></i></a>
                                     {{-- <a href="#" data-id="{{ $row->PK_NO }}"  class="btn btn-xs btn-danger mr-1" title="Delete delivery boy"><i class="la la-trash" ></i></a> --}}

                                     <a href="{{ route('admin.delivery_boy.view', [$row->PK_NO]) }}"  class="btn btn-xs btn-info" title="Delivery boy dashboard"><i class="la la-eye"></i></a>

                                     @endif

                                     @if (hasAccessAbility('edit_delivery_body', $roles))
                                     <a href="javascript:void(0)" data-id="{{ $row->PK_NO }}" class="btn btn-xs btn-info mb-05 mr-05 delivery_body_area" title="Delivery body coverage area" >
                                         <i class="la la-map-marker"></i>
                                     </a>
                                    @endif

                                    </td>
                                </tr>
                                @endforeach
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
    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-lg">
          <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Delivery boy</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
             </div>
             <div class="modal-body" id="addressModalBody">
             </div>
          </div>
       </div>
    </div>

    <div class="modal fade" id="areaCoverage" tabindex="-1" aria-labelledby="areaCoverageLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title" id="areaCoverageLabel">Delivery Coverage Area</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
                 </button>
              </div>
              <div class="modal-body" id="areaCoverageBody">
                <img src="{{ asset('logo/ms-icon-310x310.png') }}" style="width: 100%" />
              </div>
           </div>
        </div>
    </div>

 </div>
@push('custom_js')
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{ asset('assets/vendors/fileupload/bootstrap-fileupload.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>

<script>

$(document).on('click', '.open-modal', function () {
        var get_url = $('#base_url').val();
        $.ajax({
            type: 'get',
            url: get_url + '/ajax/delivery-boy/create',
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                if (response.status == 1) {
                    $('#addressModalBody').empty();
                    $('#addressModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show:true,
                    });
                    $('#addressModalBody').append(response.data);
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        $(document).on('submit', "#deliveryBoyForm", function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var form = $("#deliveryBoyForm");
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
                        $('#indextable > tbody').prepend(response.data);
                        $('#deliveryBoyForm')[0].reset();
                        $('#addressModal').modal('hide');
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function (err) {
                    if (err.status == 422) {
                        // toastr.error(err.responseJSON.message);
                    }
                },
                complete: function (response) {
                    $("body").css("cursor", "default");
                }
            });
        });

        $(document).on("click", ".edit-row", function (e) {
            e.preventDefault();
            var city_id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: '{{URL("ajax/delivery-boy/edit")}}' + "/" + city_id,
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
        $(document).on('submit', "#deliveryBoyUpdate", function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var form = $("#deliveryBoyUpdate");
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
                        $('.item' + response.data.delivery_boy.PK_NO).replaceWith(response.data.html);
                        toastr.success(response.message);
                        $('#deliveryBoyUpdate')[0].reset();
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
        var area_id = $(this).data('id');
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            $.ajax({
                type: 'GET',
                url: '{{URL("ajax/delivery-boy/delete")}}' + "/" + area_id,
                success: function (response) {
                    if (response.status == 1) {
                        $('.item' + area_id).remove();
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
    $(document).on("click", ".delete_cv", function (e) {
        e.preventDefault();
        var area_id = $(this).data('id');
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            $.ajax({
                type: 'GET',
                url: '{{URL("ajax/delivery-area/delete")}}' + "/" + area_id,
                success: function (response) {
                    console.log(response);
                    if (response) {
                        $('.cov_' + area_id).remove();
                        toastr.success('Area removed successfully!');
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

    $(document).on('change', '#region', function () {
        var region_id   = $(this).val();
        var get_url     = $('#base_url').val();
        $.ajax({
            type: 'get',
            url: get_url + '/ajax/get-city-by-region/' + region_id,
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (res) {
                $('#city').empty();
                $('#city').append(res);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })
    $(document).on('change', '#city', function () {
        var city_id = $(this).val();
        var get_url = $('#base_url').val();
        $.ajax({
            type: 'get',
            url: get_url + '/ajax/get-area-by-city/' + city_id,
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (res) {
                $('#area').empty();
                $('#area').append(res);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })
    $(document).on('change', '#area', function () {
        var area_id = $(this).val();
        var get_url = $('#base_url').val();
        $.ajax({
            type: 'get',
            url: get_url + '/ajax/get-subarea-by-area/' +area_id,
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (res) {
                $('#subarea').empty();
                $('#subarea').append(res);
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })

    $(document).on('click','.delivery_body_area',function(e){
        var user_id = $(this).data('id');
        var get_url = $('#base_url').val();
        $.ajax({
            type: 'get',
            url: get_url + '/delivery-boy/'+user_id+'/area-list',
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                $('#areaCoverage').on('shown.bs.modal', function (e) {
                    $(this).find('.select2').select2({
                        dropdownParent: $(this).find('.modal-content')
                    });
                })
                if(response.status == 1) {
                    $('#areaCoverageBody').empty();
                    $('#areaCoverage').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show:true,
                    });
                    $('#areaCoverageBody').append(response.data);
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    })

    $("body").on("submit", "#areaForm", function(e){
        e.preventDefault();
        var flag = true;
        var region = $('#region').val();
        var city = $('#city').val();
        var area = $('#area').val();
        var subarea = $('#subarea').val();
        var form = $(this);
        if(region == ''){
            flag = false;
            toastr.success('Region is required');
        }
        if((city == '') || ( null == city)){
            flag = false;
            toastr.success('City is required');
        }
        if((area == '') || (null == area)){
            flag = false;
            toastr.success('Area is required');
        }
        if(subarea == ''){
            flag = false;
            toastr.success('Subarea is required');
        }
        if(flag){
            $.ajax({
                type: 'post',
                url: form.attr('action'),
                data: form.serialize(),
                async: true,
                beforeSend: function () {
                    $("body").css("cursor", "progress");
                },
                success: function (response) {
                    if(response.status == 1){
                        toastr.success(response.message);
                        window.location.reload();
                    }else{
                        toastr.success(response.message);
                    }
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            });

        }



    });


  </script>
@endpush
@endsection
