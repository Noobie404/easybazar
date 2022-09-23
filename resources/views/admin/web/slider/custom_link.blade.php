@extends('admin.layout.master')
@section('custom link','active')

@section('title') Custom link highlighter list @endsection
@section('page-name') Custom link highlighter list @endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> Custom link highlighter list </a></li>
    <li class="breadcrumb-item active">Custom link highlighter</li>
@endsection

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/icheck/yellow.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush

<?php
$roles = userRolePermissionArray();
?>


@section('content')

<section id="basic-form-layouts">
    <div class="row match-height min-height">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    @if(hasAccessAbility('new_web_custom_link', $roles))
                    <a href="{{ route('web.home.custom_link.create') }}" class="btn btn-primary float-lg-right btn-sm"> <i class="la la-plus"></i> Create new</a>
                    @endif
                </div>
                <hr>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <table class="table table-bordered alt-pagination">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Title</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Status</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if(!empty($data) && count($data)>0)
                                @foreach($data as $key=>$row)
                                <tr>
                                    <td>{{$loop->index + 1}}</td>
                                    <td>{{ $row->TITLE }}</td>
                                    <td class="text-center"><a href="{{ asset($row->IMAGE_NAME) }}" target="_blank"><img src="{{ asset($row->IMAGE_NAME) }}" alt="" width="100px;" class="img-fluid"></a></td>
                                    <td class="text-center">
                                        @if($row->IS_ACTIVE == 1)
                                        <span class="badge badge-success">Active</span>
                                        @else
                                        <span class="badge badge-danger">Deactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ date('d-m-Y',strtotime($row->START_DATE)) }}
                                    </td>
                                    <td>
                                        {{ date('d-m-Y',strtotime($row->END_DATE)) }}
                                    </td>
                                    <td style="width: 140px;" class="text-center">
                                        @if(hasAccessAbility('edit_web_custom_link', $roles))
                                            <a href="{{ route('web.home.custom_link.edit', [$row->PK_NO]) }}" class="btn btn-xs btn-info" title="EDIT"><i class="la la-edit"></i></a>
                                        @endif
                                        @if(hasAccessAbility('delete_web_custom_link', $roles))
                                            <a href="{{ route('web.home.custom_link.delete', [$row->PK_NO]) }}" class="btn btn-xs btn-danger " onclick="return confirm('Are you sure you want to delete?')" title="DELETE"><i class="la la-trash"></i></a>
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
                                @else

                                <tr class="alert">
                                    <td colspan="7" align="center">Data Not Found</td>
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
<script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
@endpush
@endsection
