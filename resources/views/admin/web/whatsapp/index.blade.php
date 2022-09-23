@extends('admin.layout.master')
@section('web','open')
@section('whatsapp','active')
@section('title')
Whatsapp List
@endsection
@section('page-name')
Whatsapp List
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> Whatsapp List </a></li>
    <li class="breadcrumb-item active">Home Whatsapp</li>
@endsection
@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
@endpush
<?php
$rows = $data['whatsapp'] ?? [];
$roles = userRolePermissionArray();
?>
@section('content')
<section id="basic-form-layouts">
    <div class="row match-height min-height">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <a href="{{ route('web.home.whatsapp.create') }}" class="btn btn-primary float-lg-right btn-sm"> <i class="la la-plus"></i> Create New</a>
                </div>
                <hr>
                <div class="card-content collapse show">
                    <div class="card-body">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Phone No</th>
                                    <th>Designation</th>
                                    <th>Default Message</th>
                                    <th class="text-center">Photo</th>
                                    <th class="text-center">ACTION</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(!empty($rows))
                                @foreach($rows as $key=>$row)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{ $row->NAME }}</td>

                                    <td>{{ $row->PHONE_NUMBER }}</td>
                                    <td>{{ $row->DESIGNATION }}</td>
                                    <td>{{ $row->DEFAULT_MSG }}</td>
                                    <td class="text-center"><img src="{{ asset($row->PHOTO) }}" alt="" width="50px"></td>
                                      <td style="width: 140px;" class="text-center">
                                        @if(hasAccessAbility('edit_whatsapp', $roles))
                                        <a href="{{ route('web.whatsapp.order-up', [$row->PK_NO]) }}" class="btn btn-xs btn-warning" title="Order Up"><i class="la la-chevron-circle-up" aria-hidden="true"></i></a>
                                        <a href="{{ route('web.whatsapp.order-down', [$row->PK_NO]) }}" class="btn btn-xs btn-success" title="Order Down"><i class="la la-chevron-circle-down" aria-hidden="true"></i></a>
                                        <a href="{{ route('web.home.whatsapp.edit', [$row->PK_NO]) }}" class="btn btn-xs btn-info" title="EDIT"><i class="la la-edit"></i></a>
                                        @endif
                                        @if(hasAccessAbility('delete_whatsapp', $roles))
                                        <a href="{{ route('web.home.whatsapp.delete', [$row->PK_NO]) }}" class="btn btn-xs btn-danger " onclick="return confirm('Are you sure you want to delete?')" title="DELETE"><i class="la la-trash"></i></a>
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
