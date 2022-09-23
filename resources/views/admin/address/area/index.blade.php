@extends('admin.layout.master')
@section('System Settings','open')
@section('area_list','active')
@section('title') Address @endsection
@section('page-name') Address @endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Area</li>
@endsection
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/extensions/toastr.css')}}">

@endpush
@php
    $roles = userRolePermissionArray();
    $rows = $data['area'] ?? [];
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
                   <div class="card-body card-dashboard ">
                      <div class="table-responsive p-1">
                         <table class="table table-striped table-bordered alt-pagination50 table-sm" id="indextable">
                            <thead>
                               <tr>
                                  <th>Sl.</th>
                                  <th>City</th>
                                  <th>Region</th>
                                  <th>Area (EN)</th>
                                  <th>Area (BN)</th>
                                  <th>North-West/South-West</th>
                                  <th>North-East/South-East</th>

                                  <th>Action</th>
                               </tr>
                            </thead>
                            <tbody id="area-data">
                               @foreach($rows as $row)
                               <tr class="item{{ $row->PK_NO }}">
                                  <td>{{$loop->index + 1}}</td>
                                  <td>{{ $row->CITY_NAME }}</td>
                                  <td>{{ $row->STATE_NAME }}</td>
                                  <td>{{ $row->AREA_NAME }}</td>
                                  <td>{{ $row->AREA_NAME_BN }}</td>
                                    <td>
                                            @if($row->NW_LAT)
                                            <span title="North-West Latitude Value">{{ $row->NW_LAT }}</span>,
                                            @endif
                                            @if($row->NW_LON)
                                            <span title="North-West Longitude Value">{{ $row->NW_LON }}</span><br>
                                            @endif
                                            @if($row->SW_LAT)
                                            <span title="South-West Latitude Value">{{ $row->SW_LAT }}</span>,
                                            @endif
                                            @if($row->SW_LON)
                                            <span title="South-West Longitude Value">{{ $row->SW_LON }}</span>
                                            @endif
                                    </td>
                                    <td>
                                            @if($row->NE_LAT)
                                            <span title="North-East Latitude Value">{{ $row->NE_LAT }}</span>,
                                            @endif
                                            @if($row->NE_LON)
                                            <span title="North-East Longitude Value">{{ $row->NE_LON }}</span><br>
                                            @endif
                                            @if($row->SE_LAT)
                                            <span title="South-East Latitude Value">{{ $row->SE_LAT }}</span>,
                                            @endif
                                            @if($row->SE_LON)
                                            <span title="South-East Longitude Value">{{ $row->SE_LON }}</span>
                                            @endif
                                    </td>

                                  <td>
                                     @if(hasAccessAbility('edit_address_type', $roles))
                                     <a href="#" data-id="{{ $row->PK_NO }}" title="Edit" class="btn btn-xs btn-primary mr-1 edit-row" title="EDIT"><i class="la la-edit"></i></a>
                                     <a href="#" data-id="{{ $row->PK_NO }}" title="Edit" class="btn btn-xs btn-danger mr-1 delete-row" title="Delete"><i class="la la-trash"></i></a>
                                     <a href="{{ URL::to('address/map')}}?mode=area&id={{$row->PK_NO }}" target="_blank" class="btn btn-xs btn-success"><i class="la la-map-marker" aria-hidden="true"></i></a>
                                     <a href="{{ URL::to('address/coordinator')}}?mode=area&id={{$row->PK_NO }}" target="_blank" class="btn btn-xs btn-success"><i class="la la-map-marker" aria-hidden="true"></i></a>
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
 <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title" id="addressModalLabel">Area</h5>
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
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{ asset('assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/js/scripts/forms/select/form-select2.js')}}"></script>
  <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', '.open-modal', function () {
        var get_url = $('#base_url').val();
        $.ajax({
            type: 'get',
            url: get_url + '/ajax/get-area-create',
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

    $(document).on('change', '#region', function () {
        var region_id = $(this).val();
        var get_url = $('#base_url').val();
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
    $(document).on('submit', "#areaForm", function (e) {
        // $("[id*=areaForm]").find('input,select,textarea').jqBootstrapValidation();
        e.preventDefault();
        var form = $("#areaForm");
        $.ajax({
            type: 'post',
            data: form.serialize(),
            url: form.attr('action'),
            async: true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (response) {
                console.log(response.data);
                if (response.status == 1) {
                    toastr.success(response.message);
                    $('#indextable > tbody').prepend(response.data);
                    $('#areaForm')[0].reset();
                    $('#addressModal').modal('hide');
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

    $(document).on("click", ".edit-row", function (e) {
        e.preventDefault();
        var area_id = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: '{{URL("ajax/get-area-edit")}}' + "/" + area_id,
            success: function (response) {
                if (response.status == 1) {
                    $('#addressModalBody').empty();
                    $('#addressModal').modal('show');
                    $('#addressModalBody').append(response.data);
                }
            },
            error: function (jqXHR, exception) {
                toastr.error('something wrong');
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
    });

    $(document).on('submit', "#areaUpdateForm", function (e) {
        e.preventDefault();
        var form = $("#areaUpdateForm");
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
                    $('.item' + response.data.area.PK_NO).empty();
                    $('.item' + response.data.area.PK_NO).replaceWith(response.data.html);
                    toastr.success(response.message);
                    $('#areaUpdateForm')[0].reset();
                    $('#addressModal').modal('hide');
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

    $(document).on("click", ".delete-row", function (e) {
        e.preventDefault();
        var area_id = $(this).data('id');
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            $.ajax({
                type: 'GET',
                url: '{{URL("ajax/get-area-delete")}}' + "/" + area_id,
                success: function (response) {
                    if (response.status == 1) {
                        $('.item' + area_id).remove();
                        toastr.success(response.message);
                    }else{
                        toastr.success(response.message);
                    }
                },
                error: function (jqXHR, exception) {
                    toastr.error('something wrong');
                },
                complete: function (data) {
                    $("body").css("cursor", "default");
                }
            });
        }
    });
    $(document).on('click','#translate',function(){
        var get_url = $('#base_url').val();
        var text = $('#cat_name').val();
        $(".fa-spinner").fadeIn("slow");
        $.ajax({
            type:'post',
            url:get_url+'/translate',
            data:{
                target:'bn',
                text:text
            },
            async :true,
            beforeSend: function () {
                $("body").css("cursor", "progress");
            },
            success: function (data) {
                if(data.status == 1 ){
                    $('#bn_name').val(data.result)
                    $('.word-counter-bn').text($('#bn_name').val().length+'/255');
                }
            },
            complete: function (data) {
                $("body").css("cursor", "default");
            }
        });
        $(".fa-spinner").fadeOut("slow");
    });
  </script>
@endpush
@endsection
