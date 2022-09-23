@extends('admin.layout.master')
@section('System Settings','open')
@section('area_map','active')
@section('title') Area Map @endsection
@section('page-name')  Area Map @endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active"> Area Map</li>
@endsection
<?php
$roles = userRolePermissionArray();
$mode = request()->get('mode') ?? '';
$id = request()->get('id') ?? '';
$childmap = request()->get('childmap') ?? '';
$map = $data['map'] ?? [];
$childmap = $data['childmap'] ?? [];
?>

@push('custom_js')
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPyxcXSRzd6kXD5xVzSbD3BaaADqt5XDs&callback=initMap&libraries=&v=weekly" defer></script>
<style type="text/css">
       /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
    #map {
         height: 100%;
     }
     /* Optional: Makes the sample page fill the window. */
     html,
     body {
         height: 100%;
         margin: 0;
         padding: 0;
     }
 </style>
 @if($childmap)
 <script>
  var sites = {!! json_encode($childmaps, JSON_HEX_TAG) !!};
  var parent = {!! json_encode($map, JSON_HEX_TAG) !!};
  console.log(parent);
  var parent_max_lat = parent.max_lat*1;
  var parent_max_lon = parent.max_lon*1;
  var parent_nw_lat = parent.nw_lat*1;
  var parent_sw_lat = parent.sw_lat*1;
  var parent_se_lon = parent.se_lon*1;
  var parent_ne_lon = parent.ne_lon*1;
  var parent_se_lat = parent.se_lat*1;
  var parent_nw_lon = parent.nw_lon*1;
  (function(exports) {
     "use strict";
       // This example adds a user-editable rectangle to the map.
       function initMap() {
        var map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: (parent_nw_lat+parent_se_lat)/2,
                lng: (parent_se_lon+parent_nw_lon)/2
            },
            zoom: 14
        });
        var i;
        for (i = 0; i < sites.length; i++) {
            var row = sites[i];
            var max_lat = row.max_lat*1;
            var max_lon = row.max_lon*1;
            var nw_lat = row.nw_lat*1;
            var sw_lat = row.sw_lat*1;
            var se_lon = row.se_lon*1;
            var ne_lon = row.ne_lon*1;
            var se_lat = row.se_lat*1;
            var nw_lon = row.nw_lon*1;
            var bounds = {
                north: nw_lat,
                south: se_lat,
                east: se_lon,
                west: nw_lon
            };
            new google.maps.Marker({
                position:{
                    lat: (nw_lat+se_lat)/2,
                    lng: (se_lon+nw_lon)/2
                },
                map,
                title: row.mark_title.toString(),
                label: row.mark_label.toString(),
            });
                // Define a rectangle and set its editable property to true.
                var rectangle = new google.maps.Rectangle({
                    bounds: bounds,
                    editable: true,
                    // strokeColor: ,
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    // fillColor: '#ccc',
                    fillOpacity: 0.35,
                });
                rectangle.setMap(map);
            }
        }
        exports.initMap = initMap;
    })((this.window = this.window || {}));
</script>
@else
<script>
    var sites = {!! json_encode($map, JSON_HEX_TAG) !!};
    var max_lat = sites.MAX_LAT*1;
    var max_lon = sites.MAX_LON*1;
    var nw_lat = sites.NW_LAT*1;
    var sw_lat = sites.SW_LAT*1;
    var se_lon = sites.SE_LON*1;
    var ne_lon = sites.NE_LON*1;
    var se_lat = sites.SE_LAT*1;
    var nw_lon = sites.NW_LON*1;
    (function(exports) {
        "use strict";
            // This example adds a user-editable rectangle to the map.
            function initMap() {
                var map = new google.maps.Map(document.getElementById("map"), {
                 center: {
                    lat: +(nw_lat+se_lat)/2,
                   lng: +(se_lon+nw_lon)/2
                //    center: {lat: +lat, lng: +lng},
               },
               zoom: 14
           });
                var bounds = {
                north: nw_lat,
                 south: se_lat,
                 east: se_lon,
                 west: nw_lon
             };
           // Define a rectangle and set its editable property to true.
           var rectangle = new google.maps.Rectangle({
             bounds: bounds,
             editable: true
         });
           rectangle.setMap(map);
       }

       exports.initMap = initMap;
   })((this.window = this.window || {}));
</script>
@endif
@endpush
@section('content')
<div class="content-body min-height">
    <section id="pagination">
       <div class="row">
          <div class="col-12">
             <div class="card card-sm card-success">
                <div class="card-header pl-2">
                    @if($mode != 'submap')
                    <a href="{{ URL::to('address/map')}}?mode={{$mode}}&id={{$id }}" class="btn btn-sm btn-info pull-right {{$childmap == true ? '' : 'active'}}" style="margin-left: 10px;">Parent Map</a>
                    <a href="{{ URL::to('address/map')}}?mode={{$mode}}&id={{$id }}&childmap=true" class="btn btn-sm btn-info pull-right {{$childmap == true ? 'active' : ''}}" style="margin-left: 10px;">Child Map</a>
                    @endif
                 </div>
                <div class="card-content collapse show">
                   <div class="card-body card-dashboard">
                       <div class="content-wrapper">
                            <section class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="col-xs-12" style="height: 600px;">
                                                        <div id="map"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </section>
</div>
@endsection



