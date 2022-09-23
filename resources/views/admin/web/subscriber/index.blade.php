@extends('admin.layout.master')
@section('web','open')
@section('subscribers','active')
@section('title')
Subscriber List
@endsection
@section('subscriber-name')
Subscriber List
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home </a></li>
<li class="breadcrumb-item active">Subscriber</li>
@endsection
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
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
            <div class="card-content collapse show">
               <div class="card-body">
                  <table class="table table-bordered">
                     <thead>
                        <tr>
                           <th>SL</th>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Phone no</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($rows) && count($rows)>0)
                        @foreach($rows as $key=>$row)
                        <tr>
                           <td>{{$loop->index + 1}}</td>
                           <td>{{ $row->NAME }}</td>
                           <td>{{ $row->EMAIL }}</td>
                           <td>{{ $row->PHONE_NUMBER }}</td>
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
