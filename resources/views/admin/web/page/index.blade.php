@extends('admin.layout.master')
@section('web','open')
@section('pages','active')
@section('title')
Page List
@endsection
@section('page-name')
Page List
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> Page List </a></li>
<li class="breadcrumb-item active">Home Page</li>
@endsection
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
@endpush
<?php
   $rows = $data['pages'] ?? [];
   $roles = userRolePermissionArray();
   ?>
@section('content')
<section id="basic-form-layouts">
   <div class="row match-height min-height">
      <div class="col-md-12">
         <div class="card card-success">
            <div class="card-header">
               <a href="{{ route('web.page.create') }}" class="btn btn-primary float-lg-right btn-sm"> <i class="la la-plus"></i> Create New</a>
            </div>
            <hr>
            <div class="card-content collapse show">
               <div class="card-body">
                  <table class="table table-bordered">
                     <thead>
                        <tr>
                           <th>SL</th>
                           <th>Title</th>
                           <th>Feature Image</th>
                           <th>For App</th>
                           <th>Web Section</th>
                           <th>Is Acive</th>
                           <th>Order Id</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($rows) && count($rows)>0)
                        @foreach($rows as $key=>$row)
                        <tr>
                           <td>{{$loop->index + 1}}</td>
                           <td>{{ $row->TITLE }}</td>
                           <td><img src="{{ asset($row->FEATURE_IMAGE) }}" alt="" width="100px;" class="img-fluid"></td>
                           <td>@if($row->FOR_APP == 1) <span class="badge badge-success">Yes</span> @else <span class="badge badge-danger">No</span> @endif</td>
                           <td>@if($row->SECTION == 1) Pages @elseif($row->SECTION == 3) Footer Top @else Customer Section @endif</td>
                           <td>
                               @if($row->IS_ACTIVE == 1) <span class="badge badge-success">Active</span> @else <span class="badge badge-danger">Deactive</span>@endif

                           </td>
                           <td>{{ $row->ORDER_ID }}</td>
                           <td style="width: 140px;">
                            @if(hasAccessAbility('view_web_settings', $roles))
                            <a href="{{ route('web.page.order-up', [$row->PK_NO]) }}" class="btn btn-xs btn-warning" title="Order Up"><i class="la la-chevron-circle-up" aria-hidden="true"></i></a>
                            <a href="{{ route('web.page.order-down', [$row->PK_NO]) }}" class="btn btn-xs btn-success" title="Order Down"><i class="la la-chevron-circle-down" aria-hidden="true"></i></a>
                            @endif

                              @if(hasAccessAbility('view_web_settings', $roles))
                              <a href="{{ route('web.page.edit', [$row->PK_NO]) }}" class="btn btn-xs btn-info" title="EDIT"><i class="la la-edit"></i></a>
                              @endif
                              @if(hasAccessAbility('view_web_settings', $roles))
                              {{-- <a href="{{ route('web.page.delete', [$row->PK_NO]) }}" class="btn btn-xs btn-danger " onclick="return confirm('Are you sure you want to delete?')" title="DELETE"><i class="la la-trash"></i></a> --}}
                              @endif
                           </td>
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
<script src="{{ asset('assets/vendors/js/extensions/toastr.min.js')}}"></script>
@endpush
@endsection
