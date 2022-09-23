@extends('admin.layout.master')
@section('notification','active')
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
                           <th>SL</th>
                           <th>Title</th>
                           <th>Body</th>
                           <th>Image</th>
                           <th>For</th>
                           <th>Status</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($rows) && count($rows)>0)
                        @foreach($rows as $key=>$row)
                        <tr>
                           <td>{{$loop->index + 1}}</td>
                           <td>{{ $row->TITLE }}</td>
                           <td>{{ $row->BODY }}</td>
                           <td>
                               @if(!empty($row->IMAGE))
                               <img src="{{ asset($row->IMAGE) }}" alt="{{ $row->TITLE }}" width="50px;" class="img-fluid">
                               @else
                               <span class="badge badge-light">Image Not Available</span>
                               @endif
                            </td>
                            <td><span class="badge badge-info">{{ $row->NOTIFICATION_TYPE }}</span></td>
                            <td>@if($row->STATUS ==1) <span class="badge badge-success">Success</span>
                            @else <span class="badge badge-danger">Fail</span> @endif</td>
                          </tr>
                        @endforeach

                        @else
                        <tr class="alert">
                           <td rowspan="5">Data Not Found</td>
                        </tr>
                        @endif
                     </tbody>
                  </table>
                  {{ $rows->links() }}
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@push('custom_js')
@endpush
@endsection
