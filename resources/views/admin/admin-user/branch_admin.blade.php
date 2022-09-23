@extends('admin.layout.master')
@section('Admin Mangement','Open')
@section('branch-admin','active')
@section('title')
    Branch User
@endsection
@section('page-name')
    Branch User
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Branch User </li>
@endsection

@push('custom_css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endpush

@php
    $roles = userRolePermissionArray();
@endphp
@section('content')
    <!-- Alternative pagination table -->
    <div class="content-body min-height">
        <section id="pagination">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            {{-- @if(hasAccessAbility('add_admin_user', $roles))
                                <a class="text-white btn btn-sm btn-primary" href="{{url('admin-user/new')}}" title="Create Admin User">
                                    <i class="ft-user-plus text-white"></i> Create Easybazar Admin User
                                </a>
                            @endif --}}
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <div class="table-responsive p-1">
                                    <table class="table display nowrap table-striped table-bordered  alt-pagination50 dataTables_scroll" id="indextable">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Sl.</th>
                                            <th>Admin For</th>
                                            <th class="text-center">Image</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Email</th>
                                            <th>Mobile no</th>
                                            <th>Group</th>
                                            <th>Role</th>
                                            <th class="text-center">Can login</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($triggers as $row)
                                            <tr>
                                                <td class="text-center">{{$loop->index + 1}}</td>
                                                <td>{{$row->USER_TYPE == 0 ? 'Easybazar' : 'Branch'}}</td>
                                                <td class="text-center">
                                                    <img align="middle" width="50" height="50" src="{{fileExit($row->PROFILE_PIC_URL)}}" alt="Profile">
                                                </td>
                                                <td>
                                                    {{$row->USER_NAME}}
                                                    @if($row->USER_TYPE == 10)
                                                    <br>
                                                    <strong>{{ $row->SHOP_NAME }}</strong>
                                                    @endif
                                                </td>
                                                <td>{{$row->DESIGNATION}}</td>
                                                <td>{{$row->EMAIL}}</td>
                                                <td>{{$row->MOBILE_NO}}</td>
                                                <td>{{$row->GROUP_NAME}}</td>
                                                <td>{{$row->NAME}}</td>
                                                @if($row->CAN_LOGIN == 0)
                                                    <td class="text-center"><i class='ft-crosshair text-danger'></i>
                                                    </td>
                                                @else
                                                    <td class="text-center"><i class='ft-check text-success'></i></td>
                                                @endif
                                                <td class="text-center">
                                                    @if($row->STATUS == 0)
                                                        {{'Inactive'}}
                                                    @else
                                                        {{'Active'}}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if(hasAccessAbility('edit_branch_admin', $roles))
                                                    <a href="{{ route('admin.branch-admin.edit', array($row->PK_NO)) }}" class="btn btn-xs btn-info mr-1" title="Edit"><i class="la la-edit"></i></a>
                                                    @endif
                                                    @if(hasAccessAbility('delete_admin_user', $roles))
                                                    {{-- <a href="{{ route('admin.admin-user.delete', [$row->PK_NO]) }}" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-xs btn-danger mr-1" title="Delete"><i class="la la-trash"></i></a> --}}
                                                    @endif

                                                    @if (hasAccessAbility('view_branch_user', $roles))
                                                        <a href="{{ route("admin.branch.user_create", [$row->PK_NO]) }}" class="btn btn-xs btn-success mb-05 mr-05" title="Users"><i class="la la-user"></i><div class="badge badge-danger" style="min-width: auto">{{ $row->SUB_USER }}</div></a>
                                                    @endif
                                                    @if(hasAccessAbility('login_as', $roles))
                                                    <a class="btn btn-xs btn-info" href="{{route('admin.login_as', ['shop_id' => $row->PK_NO])}}" title="Login As {{ $row->SHOP_NAME }}"><i class="la la-lock"></i></a>
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
    @push('custom_js')
    <script src="{{asset('assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/scripts/tables/datatables/datatable-basic.js')}}"></script>
    @endpush
    <!--/ Alternative pagination table -->
@endsection
