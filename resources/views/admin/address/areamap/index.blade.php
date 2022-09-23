@extends('admin.layout.master')
@section('System Settings','open')
@section('sub_area','active')

@section('title') Subarea @endsection
@section('page-name') Subarea @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active"> Subarea</li>
@endsection

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<style>
    div#indextable_length,div#indextable_info {
    float: left;
}
div#indextable_filter,div#indextable_paginate {
    float: right;
}
</style>
@endpush
@php
    $roles = userRolePermissionArray();
@endphp
@section('content')
<script type="text/javascript">
     $(document).ready(function(){
        initGeolocation();
    });

     function initGeolocation()
     {
        if( navigator.geolocation )
        {
           // Call getCurrentPosition with success and failure callbacks
           navigator.geolocation.getCurrentPosition( success, fail );
        }
        else
        {
           alert("Sorry, your browser does not support geolocation services.");
        }
     }

     function success(position)
     {

         document.getElementById('long').value = position.coords.longitude;
         document.getElementById('lat').value = position.coords.latitude
     }

     function fail()
     {
        // Could not obtain location
     }

   </script>  

<div onLoad="initGeolocation();">
   <FORM NAME="rd" METHOD="POST" ACTION="index.html">
     <INPUT TYPE="text" NAME="long" ID="long" VALUE="">
     <INPUT TYPE="text" NAME="lat" ID="lat" VALUE="">
   </FORM>
 </div>

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
                      <div class="table-responsive" id="append-table">
                        <table class="table table-striped table-bordered alt-pagination50 table-sm" id="indextable" >
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Region</th>
                                            <th>City</th>
                                            <th>Area</th>
                                            <th>Sub Area</th>
                                            <th>Min La/South-West</th>
                                            <th>Max Lat/Max Lon</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="area-data">
                                        @if(count($rows)>0)
                                            @foreach ($rows as $key=> $row)
                                                <tr class="item{{ $row->PK_NO }}">
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $row->STATE_NAME ?? '' }}</td>
                                                    <td>{{ $row->CITY_NAME ?? '' }}</td>
                                                    <td>{{ $row->AREA_NAME ?? '' }}</td>
                                                    <td>{{ $row->SUB_AREA_NAME ?? '' }} ({{ $row->SUB_AREA_NAME_BN ?? '' }})</td>
                                                    <td>
                                                        <p><span title="Min Latitude Value">{{ $row->MIN_LAT }}</span></span></p>
                                                        <p><span title="Min Latitude Value">{{ $row->MIN_LON }}</span></span></p>
                                                    </td>
                                                    <td>
                                                        <p><span title="Max Latitude Value">{{ $row->MAX_LAT }}</span></span></p>
                                                        <p><span title="Max Latitude Value">{{ $row->MAX_LON }}</span></span></p>
                                                    </td>
                                                    <td style="width: 120px;">
                                                        @if(hasAccessAbility('edit_address_type', $roles))
                                                        <a href="#" title="Edit" data-id="{{ $row->PK_NO }}" class="btn btn-xs btn-primary mr-1 edit-row" title="EDIT"><i class="la la-edit"></i></a>
                                                        <a href="#" data-id="{{ $row->PK_NO }}" title="Edit" class="btn btn-xs btn-danger mr-1 delete-row" title="Delete"><i class="la la-trash"></i></a>
                                                        <a href="{{ URL::to('address/map')}}?mode=submap&id={{$row->PK_NO }}" target="_blank" class="btn btn-xs btn-success"><i class="la la-map-marker" aria-hidden="true"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="50">No record found</td>
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

                 <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                       <div class="modal-content">
                          <div class="modal-header">
                             <h5 class="modal-title" id="addressModalLabel">Add Sub Area</h5>
                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                             </button>
                          </div>
                          <div class="modal-body" id="addressModalBody"></div>
                       </div>
                    </div>
                 </div>
</div>
@push('custom_js')
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
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
            url: get_url + '/ajax/get-map-create',
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

    $(document).on('submit', "#mapForm", function (e) {
        e.preventDefault();
        var form = $("#mapForm");
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
                    $('#append-table').empty();
                    $('#append-table').append(response.data);
                    $('#mapForm')[0].reset();
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
        var map_id = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: '{{URL("ajax/get-map-edit")}}' + "/" + map_id,
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

    $(document).on('submit', "#mapUpdateForm", function (e) {
        e.preventDefault();
        var form = $("#mapUpdateForm");
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
                    $('#append-table').empty();
                    $('#append-table').append(response.data.html);
                    // $('.item' + response.data.area.PK_NO).empty();
                    // $('.item' + response.data.area.PK_NO).replaceWith(response.data.html);
                    toastr.success(response.message);
                    $('#mapUpdateForm')[0].reset();
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
        var map_id = $(this).data('id');
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            $.ajax({
                type: 'GET',
                url: '{{URL("ajax/get-map-delete")}}' + "/" + map_id,
                success: function (response) {
                    if (response.status == 1) {
                        $('.item' + map_id).remove();
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
    $(document).on('input','#nw_lat_lon',function(e){
            var str = $(this).val();
            var nw_lat_lon = str.replace(/\s/g,"");
            if(nw_lat_lon.length > 0){
                var res = nw_lat_lon.split(",");
                if(res[0]){
                     $('#nw_lat').val(res[0]);
                     $('#sw_lat').val(res[0]);
                }
                if(typeof(res[0]) != 'undefined') {
                    $('#nw_lon').val(res[1]);
                    $('#ne_lon').val(res[1]);
                }
            }else{
                $('#nw_lat').val('');
                $('#nw_lon').val('');
                $('#sw_lat').val('');
                $('#ne_lon').val('');
            }
        })

        $(document).on('input','#se_lat_lon',function(e){
            var str = $(this).val();
            var se_lat_lon = str.replace(/\s/g,"");;
            console.log(se_lat_lon);
            if(se_lat_lon.length > 0){
                var res = se_lat_lon.split(",");
                if(res[0]){
                     $('#se_lat').val(res[0]);
                     $('#ne_lat').val(res[0]);
                }
                if(typeof(res[0]) != 'undefined') {
                    $('#se_lon').val(res[1]);
                    $('#sw_lon').val(res[1]);
                }
            }else{
                $('#se_lat').val('');
                $('#se_lon').val('');
                $('#ne_lat').val('');
                $('#sw_lon').val('');
            }
        })

        $(document).on("click", ".delete_field", function (e) {
        e.preventDefault();
        var polygon_id = $(this).data('id');
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            $.ajax({
                type: 'GET',
                url: '{{URL("ajax/get-polygon-delete")}}' + "/" + polygon_id,
                success: function (response) {
                    if (response.status == 1) {
                        $('#polygon'+polygon_id).remove();
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
  </script>
@endpush
@endsection


