@extends('admin.layout.master')
@section('notification','open')
@section('device-list','active')
@section('title')
Notification List
@endsection
@section('page-name')
Notification List
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> Dashboard </a></li>
<li class="breadcrumb-item">Notification</li>
@endsection
@push('custom_css')
@endpush
<?php
   $rows = $data ?? [];

//    dd($rows);
   $roles = userRolePermissionArray();
   ?>
@section('content')
<section id="basic-form-layouts">
   <div class="row match-height min-height">
      <div class="col-md-12">
         <div class="card card-success">
            <div class="card-header">
               <a href="{{ route('web.notification.create') }}" class="btn btn-primary float-lg-right btn-sm"> <i class="la la-plus"></i> Create New</a>
            </div>
            <hr>
            <div class="card-content collapse show">
               <div class="card-body">
                  <table class="table table-bordered">
                     <thead>
                        <tr>
                           <th style="width: 10%">SL</th>
                           <th style="width: 80%">DEVICE_KEY</th>
                           <th style="width: 10%">Customer name/id</th>

                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($rows) && count($rows)>0)
                        @foreach($rows as $key=>$row)
                        <tr>
                           <td>{{$loop->index + 1}}</td>
                           <td>{{ $row->FCM_USER_TOKEN }}</td>
                            <td>{{ $row->NAME}}</td>
                          </tr>
                        @endforeach

                        @else
                        <tr class="alert">
                           <td rowspan="5">Data Not Found</td>
                        </tr>
                        @endif
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@push('custom_js')
@endpush
@endsection
