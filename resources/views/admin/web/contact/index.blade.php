@extends('admin.layout.master')
@section('web','open')
@section('contact','active')
@section('title')
Contact List
@endsection
@section('contact-name')
Contact List
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home </a></li>
<li class="breadcrumb-item active">Contact</li>
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
            {{-- <div class="card-header">
               <a href="" class="btn btn-primary float-lg-right btn-sm"> <i class="la la-plus"></i> Create New</a>
            </div> --}}
            <div class="card-content collapse show">
               <div class="card-body">
                  <table class="table table-bordered">
                     <thead>
                        <tr>
                           <th>SL</th>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Subject</th>
                           <th>Message</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($rows) && count($rows)>0)
                        @foreach($rows as $key=>$row)
                        <tr>
                           <td>{{$loop->index + 1}}</td>
                           <td>{{ $row->NAME }}</td>
                           <td>{{ $row->EMAIL }}</td>
                           <td>{{ $row->SUBJECT }}</td>
                           <td>{{ $row->MESSAGE_TEXT }}</td>
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
